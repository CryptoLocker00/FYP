<?php
$company_name = Request::old('company_name');
if (is_null($company_name)) {
  $company_name = empty($client) ? '' : $client->company_name;
}
$company_address = Request::old('company_address');
if (is_null($company_address)) {
  $company_address = empty($client) ? '' : $client->company_address;
}
$name = Request::old('name');
if (is_null($name)) {
  $name = empty($client) ? '' : $client->contactPerson->name;
}
$email = Request::old('email');
if (is_null($email)) {
  $email = empty($client) ? '' : $client->contactPerson->email;
}
$contact_number = Request::old('contact_number');
if (is_null($contact_number)) {
  $contact_number = empty($client) ? '' : $client->contactPerson->contact_number;
}
?>
<div class="form-group">
  <label class="col-md-2 control-label">Name<span class="mandatory">*</span></label>
  <div class="col-md-10">
    <input type="text" class="form-control" name="name" value="{{$name}}">
  </div>
</div>

<div class="form-group">
  <label class="col-md-2 control-label">Company Name<span class="mandatory">*</span></label>
  <div class="col-md-10">
    <input type="text" class="form-control" name="company_name" value="{{$company_name}}">
  </div>
</div>

<div class="form-group">
  <label class="col-md-2 control-label">Company Address</label>
  <div class="col-md-10">
    <textarea class="form-control" name="company_address">{{$company_address}}</textarea>
  </div>
</div>

<div class="form-group">
  <label class="col-md-2 control-label">Email</label>
  <div class="col-md-10">
    <input type="text" class="form-control" name="email" value="{{$email}}">
  </div>
</div>

<div class="form-group">
  <label class="col-md-2 control-label">Contact Number</label>
  <div class="col-md-10">
    <input type="text" class="form-control" name="contact_number" value="{{$contact_number}}">
  </div>
</div>

