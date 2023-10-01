<?php

namespace App\Http\Controllers\ApiControllers;


use App\Http\Controllers\Controller;
use App\Http\Resources\InvoiceCollection;
use App\Http\Resources\InvoiceResource;
use App\Models\Currency;
use App\Models\Invoice;
use App\Http\Requests\InvoiceRequest;
use App\Http\Responses\ApiResponse;
use App\Models\InvoiceTotal;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    public function index() :JsonResponse
    {
        $invoices = Invoice::paginate(10);
        return ApiResponse::successResponse('Invoices retrieved successfully', 200, new InvoiceCollection($invoices));
    }

    public function store(InvoiceRequest $request) :JsonResponse
    {
        $validatedData = $request->validated();
        try {
            \DB::beginTransaction();
            $invoice = Invoice::create($validatedData);
            if ($request->has("totals")) {
                foreach ($validatedData['totals'] as $totalData) {
                    $total = new InvoiceTotal();
                    $total->title = $totalData['title'];
                    $total->price = $totalData['cost'];
                    $total->type = $totalData["type"];
                    $total->invoice_id = $invoice->id;
                    $total->save();
                }
            }
            \DB::commit();
            return ApiResponse::successResponse('Invoice created successfully', 201, new InvoiceResource($invoice));

        } catch (\Exception $e) {
            return ApiResponse::errorResponse($e->getMessage(), 500);
        }



    }

    public function show(Invoice $invoice) :JsonResponse
    {
        return ApiResponse::successResponse('Invoice retrieved successfully', 200, new InvoiceResource($invoice));
    }

    public function update(InvoiceRequest $request, Invoice $invoice) :JsonResponse
    {
        $validatedData = $request->validated();
        $invoice->update($validatedData);

        // Handle invoice totals if needed

        return ApiResponse::successResponse('Invoice updated successfully', 200,  new InvoiceResource($invoice));
    }

    public function destroy(Invoice $invoice) :JsonResponse
    {
        $invoice->delete();
        return ApiResponse::successResponse('Invoice deleted successfully', 200);
    }
}
