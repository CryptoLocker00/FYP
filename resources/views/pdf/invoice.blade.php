<?php
$total = 0;
?>

        <!DOCTYPE html>
<html>
<head>
  <title>Invoice PDF</title>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
  <style type="text/css">
    html, body {
      margin: 0 !important;
      padding: 0 !important;
      font-family: Arial !important;
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
<div class="container-fluid">
  <div class="row">
    <h3>Invoice</h3>
  </div>

  <div class="invoice-body" style="margin: 0px 60px 0;">
    <div class="row" style="margin-bottom: 5px">
      <div class="col-xs-7 text-right">
        <p style="margin-bottom: 0px">
          <strong style="font-size:16px;">Tax invoice</strong>
        </p>
      </div>
      <div class="col-xs-5">
        <p style="font-size:14px; margin-bottom: 0; margin-top: 1px" class="text-right">GST Reg No. : 000753987584</p>
      </div>
    </div>

    <div class="row" style="border-bottom: 1px solid #000; border-top: 1px solid #000;">
      <div class="col-xs-6">
        <div class="row">
          <address class="text-font-11" style="margin-bottom: 10px;">
            <b>Billing Address</b><br/>
            <strong>{{$quotation->client->company_name}}</strong><br/>
            <div class="col-xs-10" style="padding-left: 0px !important;">
              <p>{!! $quotation->client->company_address!!}</p>
            </div>
            <strong>Attention: {{$quotation->client->contactPerson->name}}</strong><br/>
            <strong>Tel: {{$quotation->client->contactPerson->contact_number}}</strong>
          </address>
        </div>
      </div>

      <div class="col-xs-6">
        <div class="row">
          <address class="text-font-11" style="margin-bottom: 10px;">
            <b>Delivery Address</b><br/>
            <br/>
            <div class="col-xs-10" style="padding-left: 0px !important;">
              <p>{!! $quotation->client->company_address!!}</p>
            </div>
          </address>
        </div>
      </div>
    </div>


    <div class="row" style="border-bottom: 1px solid #000; padding-top: 5px; padding-bottom: 5px;">
      <div class="col-xs-3" style="padding-left: 0">
        <strong>Your Ref:</strong>
        <p style="margin: 0;">{{$invoice->your_references}}</p>
      </div>
      <div class="col-xs-3">
        <strong>D/O No:</strong>
        <p style="margin: 0;">{{$invoice->do_no}}</p>
      </div>
      <div class="col-xs-3">
        <strong>Invoice No:</strong>
        <p style="margin: 0;">{{$invoice->invoice_no}}</p>
      </div>
      <div class="col-xs-3">
        <strong>Date:</strong>
        <p style="margin: 0;">{{$invoice->date}}</p>
      </div>
    </div>

    <div class="row" style="margin-bottom: 60px;">
      <table class="table table-striped">
        <thead>
        <tr>
          <th style="font-size: 11px !important;" class="col-xs-1">No</th>
          <th style="font-size: 11px !important;" class="col-xs-5">Description</th>
          <th style="font-size: 11px !important;" class="col-xs-2 text-center">Qty</th>
          <th style="font-size: 11px !important;" class="col-xs-2 text-right">Unit Price (RM)</th>
          <th style="font-size: 11px !important;" class="col-xs-2 text-right">Amount (RM)</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($items as $key=>$item)
          <tr>
            <td>{{$key+1}}</td>
            <td class="text-font-11 text-left" style="white-space: pre;">{!! trim(preg_replace("/\r\n|\r/", "<br />", $item->description)) !!}</td>
            <td class="text-font-11 text-center">{{$item->quantity == '0' ? '-' : $item->quantity}} {{$item->unit_type}}</td>
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

    <div class="row" style="border-top: 1px solid #000; border-bottom: 1px solid #000; padding: 15px 0;">
      <div class="col-xs-7" style="padding-left: 0">
          <?php
          $tax = $total / 100 * 6;
          $totalWithTax = $total + $tax;
          $roundDecimal = number_format($totalWithTax, 2, '.', '');
          $exp = explode('.', $roundDecimal);
          $formattedPrice = (new \NumberFormatter("en", \NumberFormatter::SPELLOUT));
          $formattedPrice = $formattedPrice->format($exp[0]) . ' and ' . $formattedPrice->format($exp[1]);
          $totalWithTax = number_format($totalWithTax, 2, '.', ',');;
          ?>
        <strong style="margin-top: 10px;">RINGGIT MALAYSIA :</strong><br/>
        <p style="text-transform: uppercase; margin: 0px; font-size: 15px;">
          {{$formattedPrice}} only
        </p>
      </div>
      <div class="col-xs-5 quote-total-wrapper" style="padding-right: 0">
        <div class="row">
          <h5 style="margin-bottom: 0; margin-top: 0" class="col-xs-6 text-right text-font-11">Total Excl. GST</h5>
          <h5 style="margin-bottom: 0; margin-top: 0" class="col-xs-6 text-right text-font-11" id="quote-total">{{number_format($total, 2, '.', ',')}}</h5>
        </div>

        <div class="row">
          <h5 style="margin-bottom: 0; margin-top: 0" class="col-xs-6 text-right text-font-11">GST Amt @ 6%</h5>
          <h5 style="margin-bottom: 0; margin-top: 0" class="col-xs-6 text-right text-font-11" id="quote-total">{{number_format($tax, 2, '.', ',')}}</h5>
        </div>

        <div class="row">
          <h5 style="margin-bottom: 0; margin-top: 0" class="col-xs-6 text-right text-font-11">Total Amount</h5>
          <h5 style="margin-bottom: 0; margin-top: 0" class="col-xs-6 text-right text-font-11" id="quote-total">
            <strong>{{$totalWithTax}}</strong>
          </h5>
        </div>
      </div>
    </div>

    <div class="row" style="border-bottom: 1px solid #000; padding-top: 5px; padding-bottom: 5px;">
      <div class="col-xs-12" style="padding-left: 0">
        <strong>Payment Terms:</strong> <br/>
        <p style="margin-bottom: 0; font-size: 12px;"> Cash - {{$invoice->validity}} Days</p>
      </div>
    </div>

    <div class="row">
      <div class="col-xs-8" style="padding-left: 0">
        <br>
        <strong>Notes</strong>
        <p style="font-size:12px; margin-bottom: 0;">1. All cheque should be crossed and made payable to
          <strong>(COMPANY NAME)</strong> (please email or fax the bank slip)
        </p>
        <p style="font-size:12px;">2. Goods sold are neither returnable nor refundable.</p>
      </div>

      <div class="col-xs-4" style="padding-right: 0">
        <br>
        <br>
        <br>
        <div class="col-xs-12" style="border-bottom: 1px solid #000;"></div>
        <p style="margin-top: 5px; font-size: 14px;" class="text-center"></p>
      </div>
    </div>
  </div>
</div>
</div>
</body>
</html>
