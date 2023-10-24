<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>All invoices</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">

    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }
        th, td {
            text-align: left;
            padding: 8px;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>

    <h1 class="text-center py-5">Invoice List</h1>
   @if (session()->has("error"))
      <div class="alert alert-danger my-3 text-center">
          {{ session()->get("error") }}
      </div>
   @endif

    @if (session()->has("success"))
        <div class="alert alert-success my-3 text-center">
            {{ session()->get("success") }}
        </div>
    @endif
   <div class="">
       <div class="container py-5 d-flex justify-content-center align-items-center">

           <table class="table col-12">
               <thead>
               <tr>
                   <th>Invoice ID</th>
                   <th>Invoice Title</th>
                   <th>Invoice Date</th>
                   <th>Invoice Amount</th>
                   <th>Invoice Status</th>
                   <th>Actions</th>
               </tr>
               </thead>
               <tbody>
               @foreach($invoices as $invoice)
                   <tr>
                       <td>{{ $invoice->id }}</td>
                       <td>{{ $invoice->title }}</td>
                       <td>{{ $invoice->created_at->format("Y-m-d g:iA") }}</td>
                       <td>{{ $invoice->total }} {{$invoice->currency->symbol}}</td>
                       <td>{{ $invoice->invoiceStatus->title }}</td>
                       <td>
                           <form id="invoice_{{$invoice->id}}" method="post" action="{{route("generate-signed-route",$invoice->id)}}">
                               @csrf
                               @if ($invoice->invoice_status_id == 1)
                                   <button type="submit" class="btn btn-primary">Pay</button>
                               @elseif($invoice->invoice_status_id == 2)
                                   <button type="submit" class="btn btn-danger">Refund</button>
                               @endif
                           </form>
                       </td>
                   </tr>
               @endforeach
               </tbody>
           </table>
       </div>
   </div>



   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
</body>
</html>
