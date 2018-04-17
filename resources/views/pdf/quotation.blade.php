<?php
$total = 0;
?>

        <!DOCTYPE html>
<html>
<head>
  <title>Quotation PDF</title>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
  <style type="text/css">
    * {
      font-family: sans-serif;
    }

    html, body {
      margin: 0 !important;
      padding: 0 !important;
    }

    thead, tfoot {
      display: table-row-group
    }

    tr {
      page-break-inside: avoid
    }
  </style>
  <link href="{{asset('/css/app.css')}}" rel="stylesheet">
  <link href="{{asset('/css/all.css')}}" rel="stylesheet">
</head>

<body>
<div class="col-xs-12">
  <div class="row">
    <div class="col-xs-12 quote-pdf-header">
      <div class="col-xs-6">
        <div class="row">
          <address class="text-font-11">
            <h3><b class="text-font-14">{{$quotation->client->company_name}}</b></h3><br/>
            {!! $quotation->client->company_address !!}
          </address>
        </div>
      </div>

      <div class="col-xs-6 text-right">
        <div class="row">
          <div class="col-xs-12 row text-right">
            <b class="text-font-14">QUO{{$quotation->quotation_no}}</b>
          </div>

          <div class="col-xs-12 text-font-11 row text-right margin-bot--10">
            <p class="col-xs-8">Date :</p>
            {{$quotation->quotation_date}}
          </div>

          <div class="col-xs-12 text-font-11 row text-right">
            <p class="col-xs-8">Validity :</p>
            {{$quotation->validity}} Days
          </div>
        </div>
      </div>
    </div>

    {{--<div class="col-xs-12 text-font-11">--}}
    {{--<strong>Attention: {{$quotation->contactPerson[0]['first_name']}} {{$quotation->contactPerson[0]['last_name']}}</strong>--}}
    {{--<p>Thank you for your interest in our services. We are pleased to submit our quotation for the following items, details as follows:- </p>--}}
    {{--</div>--}}
  </div>

  <div class="col-xs-12">
    <div class="row">
      <table class="table table-striped">
        <thead>
        <tr>
          <th class="col-xs-6 text-font-11 text-left">Description</th>
          <th class="col-xs-2 text-font-11 text-center">Quantity</th>
          <th class="col-xs-2 text-font-11 text-right">Unit Price (RM)</th>
          <th class="col-xs-2 text-font-11 text-right">Total Price (RM)</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($items as $item)
          <tr>
            <td class="text-font-11 text-left" style="white-space: pre;">{!! trim(preg_replace("/\r\n|\r/", "<br />", $item->description)) !!}</td>
            <td class="text-font-11 text-center">{{$item->quantity == '0' ? '-' : $item->quantity}}</td>
            <td class="text-font-11 text-right">{{$item->unit_cost}}</td>
              <?php
              $subTotal = number_format($item->unit_cost * $item->quantity, 2, '.', '');
              $total += $subTotal;
              ?>
            <td class="text-font-11 text-right">{{$subTotal == '0.00' ? '-' : $subTotal}}</td>
          </tr>
        @endforeach
        </tbody>
      </table>
    </div>
  </div>

  <div class="col-xs-12">
    <div class="row">
      <div class="col-xs-5 col-xs-offset-7 quote-total-wrapper">
        <div class="row">
          <h5 style="margin-bottom: 0; padding-bottom: 0" class="col-xs-6 text-right text-font-11">Sub Total</h5>
          <h5 style="margin-bottom: 0; padding-bottom: 0" class="col-xs-6 text-right text-font-11" id="quote-total">{{number_format($total, 2, '.', ',')}}</h5>
        </div>

        <div class="row">
          <h5 style="margin-bottom: 0; padding-bottom: 0" class="col-xs-6 text-right text-font-11">6% GST</h5>
          <h5 style="margin-bottom: 0; padding-bottom: 0" class="col-xs-6 text-right text-font-11" id="quote-total">{{number_format($total / 100 * 6, 2, '.', ',')}}</h5>
        </div>

        <div class="row">
          <h5 style="margin-bottom: 0; padding-bottom: 0" class="col-xs-6 text-right text-font-11">Total</h5>
          <h5 style="margin-bottom: 0; padding-bottom: 0" class="col-xs-6 text-right text-font-11" id="quote-total">{{number_format($total + ($total / 100 * 6), 2, '.', ',')}}</h5>
        </div>
      </div>
    </div>
  </div>

  <div class="col-xs-12 text-font-11 margin-top-20">
    <br><br>
    <small>{!! nl2br($quotation->remarks) !!}</small>
    <br><br>
    <small>Yours truly,</small>
    <br>
    <small>Name</small>
  </div>
</div>
</body>
</html>
