<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\URL;


class PaymentController extends Controller
{
    public function index() {
        $invoices = Invoice::get();

        return view("payment.index",compact("invoices"));
    }

    public function generateSignedRoute(Invoice $id) {
       $url =  URL::temporarySignedRoute("invoice.pay",now()->addMinutes(20),["invoice"=>$id->id]);
        return redirect()->to($url);
    }

    public function processing(Invoice $invoice,Request $request) {
        if (! $request->hasValidSignature()) {
            abort(401);
        }
        if ($invoice->invoice_status_id == 1) {
            return $this->pay($invoice,$request);
        } else {
            return $this->refund($invoice,$request);
        }
    }

    public function refund(Invoice $invoice,Request $request) {


        $body = collect([
            'tran_type' => 'refund',
            'tran_class' => 'ecom',
            'cart_id' => (string)$invoice->id,
            'cart_currency' => (string)$invoice->currency->symbol,
            'cart_amount' => (double)$invoice->total,
            'cart_description' => (string)$invoice->title . " Refund",
            "tran_ref"=>(string)$invoice->last_trans_ref,
            "callback"=>route(config("app.paytabs.callback_route_name"),$invoice->id),
        ]);



        $response =  $this->paytabsRequest("payment/request","POST",$body);




        try {

            if ($response?->payment_result?->response_status == "A" && isset($response->tranRef)) {
                if ($invoice->invoice_status_id == 2) {
                    $invoice->invoice_status_id = 4;
                    $invoice->save();
                }
                $invoice->invoiceTransactions()->create(["invoice_status_id"=>4,"request_type"=>"redirect","tran_ref"=>$response->tranRef,"tran_type"=>"refund","payment_info"=>$response]);

                return redirect()->to("/")->with("success","Invoice ".$invoice->id ." Refunded Successfully");
            } else  {

                $invoice->invoiceTransactions()->create(["invoice_status_id"=>4,"request_type"=>"redirect","tran_ref"=>"invalid","tran_type"=>"refund","payment_info"=>$response]);
                return redirect()->to("/")->with("error","Invoice ".$invoice->id ." Refund Failed");
            }
        } catch (\Exception $exception) {
            $invoice->invoiceTransactions()->create(["invoice_status_id"=>$invoice->invoice_status_id,"request_type"=>"redirect","tran_ref"=>"invalid","tran_type"=>"refund field","payment_info"=>$response]);
            return redirect()->to("/")->with("error","Invoice ".$invoice->id ." Refund Failed with code " . $response->code . " and message " . $response->message );
        }
    }

    protected function pay(Invoice $invoice,Request $request) {


        $body = collect([
            'tran_type' => 'sale',
            'tran_class' => 'ecom',
            'cart_id' => (string)$invoice->id,
            'cart_currency' => (string)$invoice->currency->symbol,
            'cart_amount' => (double)$invoice->total,
            'cart_description' => (string)$invoice->title,
            'paypage_lang' => 'en',
            "hide_shipping"=>true,
            "return"=>route(config("app.paytabs.redirect_route_name"),$invoice->id),
            "callback"=>route(config("app.paytabs.callback_route_name"),$invoice->id),
        ]);

       $response =  $this->paytabsRequest("payment/request","POST",$body);
        if (!empty($response->message)) {
            return redirect()->to(route("invoices.index"))->with("error",$response->message);
        }


        return redirect()->to($response->redirect_url);

    }

    public function redirectPayment(Invoice $invoice,Request $request) {

        // Make request to verify payment if the status is still pending and not changed by the ipn request

        $body = collect([
            'tran_ref' => $request->tranRef,
        ]);
        $response = $this->paytabsRequest("payment/query","POST",$body);
        $response->request_type = "redirect";
        if ($response->payment_result->response_status == "A") {
            if ($invoice->invoice_status_id == 1) {
                $invoice->invoice_status_id = 2;
            }
            $invoice->invoiceTransactions()->create(["invoice_status_id"=>2,"request_type"=>"redirect","tran_ref"=>$request->tranRef,"tran_type"=>"sale","payment_info"=>$response]);
            $invoice->save();

            return redirect()->to("/")->with("success","Invoice ".$invoice->id ." Paid Successfully");
        } else {
            $invoice->invoiceTransactions()->create(["invoice_status_id"=>2,"request_type"=>"redirect","tran_ref"=>$request->tranRef,"tran_type"=>"sale","payment_info"=>$response]);
            return redirect()->to("/")->with("error","Invoice ".$invoice->id ." Payment Failed");
        }
    }

    public function callbackPayment(Invoice $invoice,Request $request) {
        // Make request to verify payment if the status is still pending and not changed by the redirect request
        if ($request->tran_type == "Refund") {
            return $this->callbackRefund($invoice,$request);
        } else {
            return $this->callbackSale($invoice,$request);
        }

    }

    protected function callbackRefund(Invoice $invoice,Request $request) {
        $invoice->invoiceTransactions()->create(["invoice_status_id"=>4,"request_type"=>"callback","tran_ref"=>$request->tran_ref,"tran_type"=>"refund","payment_info"=>collect($request->all())->toJson()]);

        if ($invoice->invoice_status_id == 2) {
            $invoice->invoice_status_id = 4;
            $invoice->save();
        }
    }

    protected function callbackSale(Invoice $invoice,Request $request) {
        if ($request->payment_result["response_status"] == "A") {
            if ($invoice->invoice_status_id == 1) {
                $invoice->invoice_status_id = 2;
                $invoice->save();
            }
            $invoice->invoiceTransactions()->create(["invoice_status_id"=>2,"request_type"=>"callback","tran_ref"=>$request->tran_ref,"tran_type"=>"sale","payment_info"=>collect($request->all())->toJson()]);

        } else {
            $invoice->invoiceTransactions()->create(["invoice_status_id"=>2,"request_type"=>"callback","tran_ref"=>$request->tran_ref ?? "invalid","tran_type"=>"sale payment field","payment_info"=>collect($request->all())->toJson()]);
        }
    }





    /**
     * @param string $path
     * @param string $method
     * @param Collection $body
     * @return mixed|\Psr\Http\Message\ResponseInterface
     */
    protected function paytabsRequest(string $path,string $method,Collection $body) : mixed {
        $client = new \GuzzleHttp\Client();
        $body = $body->merge(collect(["profile_id"=>config("app.paytabs.profile_id"),
        ]));


        try {
            $response =  $client->request($method, config("app.paytabs.url").$path, [
                'headers' => [
                    'Authorization' => config("app.paytabs.server_key"),
                    "Content-type"=>"application/json"
                ],
                'body' => $body->toJson()
            ]);
           return json_decode($response->getBody()->getContents());
        } catch (ClientException $exception) {
            return json_decode($exception->getResponse()->getBody(), false);
        }
    }


}
