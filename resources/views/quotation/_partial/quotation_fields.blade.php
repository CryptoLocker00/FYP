<?php
$clientId = Request::old('client_id');
if (is_null($clientId)) {
  $clientId = empty($quotation) ? '' : $quotation->client_id;
}

$quotationDate = Request::old('quotation_date');
if (is_null($quotationDate)) {
  $quotationDate = empty($quotation) ? '' : $quotation->quotation_date;
}

$validity = Request::old('validity');
if (is_null($validity)) {
  $validity = empty($quotation) ? '' : $quotation->validity;
}

$quotationNo = Request::old('quotation_no');
if (is_null($quotationNo)) {
  $quotationNo = empty($quotation) ? '' : $quotation->quotation_no;
}
?>

<div class="col-md-4">
  <div class="form-group">
    <label class="control-label">Company<span class="red">*</span></label>
    <select id="input-status" name="client_id" class="form-control fancy-select">
      <option value="" readonly>Select One</option>
      @foreach ($clients as $client)
        <option {{$client->id == $clientId ? 'selected' : ''}} value="{{$client->id}}">{{$client->company_name}}</option>
      @endforeach
    </select>
  </div>
</div>

<div class="col-md-4">
  <div class="form-group">
    <label class="control-label">Quotation date<span class="red">*</span></label>
    <input type="text" class="form-control" id="quotation_date" name="quotation_date" value="{{$quotationDate}}">
  </div>
</div>

<div class="col-md-2">
  <div class="form-group">
    <label class="control-label">Quotation no<span class="red">*</span></label>
    <input type="number" class="form-control" name="quotation_no" value="{{$quotationNo}}">
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
    $('.fancy-select').select2();

    // quotation date
    $('#quotation_date').datepicker({
      format: 'yyyy-mm-dd',
      todayBtn: true,
      todayHighlight: true
    });
  </script>
@stop