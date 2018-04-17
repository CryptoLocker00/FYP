<?php
$invoiceDate = Request::old('invoice_date');
if (is_null($invoiceDate)) {
  $invoiceDate = empty($invoice) ? '' : $invoice->date;
}

$invoiceNo = Request::old('invoice');
if (is_null($invoiceNo)) {
  $invoiceNo = empty($invoice) ? '' : $invoice->invoice_no;
}

$references = Request::old('your_references');
if (is_null($references)) {
    $references = empty($invoice) ? '' : $invoice->your_references;
}

$doNo = Request::old('do_no');
if (is_null($doNo)) {
    $doNo = empty($invoice) ? '' : $invoice->do_no;
}

$validity = Request::old('validity');
if (is_null($validity)) {
    $validity = empty($invoice) ? '' : $invoice->validity;
}
?>

<div class="col-md-4">
  <div class="form-group">
    <label class="control-label">Company</label>
    <input type="text" class="form-control" value="{{$quotation->client->company_name}}" disabled>
  </div>
</div>

<div class="col-md-4">
  <div class="form-group">
    <label class="control-label">Invoice date<span class="red">*</span></label>
    <input type="text" class="form-control" id="invoice_date" name="invoice_date" value="{{$invoiceDate}}">
  </div>
</div>

<div class="col-md-4">
  <div class="form-group">
    <label class="control-label">Invoice no<span class="red">*</span></label>
    <input type="number" class="form-control" name="invoice_no" value="{{$invoiceNo}}">
  </div>
</div>

<div class="col-md-5">
  <div class="form-group">
    <label class="control-label">Your References<span class="red">*</span></label>
    <input type="text" class="form-control" name="your_references" value="{{$references}}">
  </div>
</div>

<div class="col-md-5">
  <div class="form-group">
    <label class="control-label">D/O No.<span class="red">*</span></label>
    <input type="text" class="form-control" name="do_no" value="{{$doNo}}">
  </div>
</div>

<div class="col-md-2">
  <div class="form-group">
    <label class="control-label">Validity<span class="red">*</span></label>
    <input type="number" class="form-control" name="validity" value="{{$validity}}">
  </div>
</div>

@section('script')
  @parent
  <script type="text/javascript">
    // quotation date
    $('#invoice_date').datepicker({
      format: 'yyyy-mm-dd',
      todayBtn: true,
      todayHighlight: true
    });
  </script>
@stop
