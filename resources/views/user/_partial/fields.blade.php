<?php
$email = Request::old('email');
if (is_null($email)) {
  $email = empty($user) ? '' : $user->email;
}
$name = Request::old('name');
if (is_null($name)) {
  $name = empty($user) ? '' : $user->name;
}
$roleId = Request::old('role_id');
if (is_null($roleId)) {
  $roleId = empty($user) ? '' : $user->role_id;
}
?>

<div class="form-group">
  <label class="col-md-2 control-label">Email<span class="mandatory">*</span></label>
  <div class="col-md-10">
    <input type="text" class="form-control" name="email" value="{{$email}}">
  </div>
</div>
<div class="form-group">
  <label class="col-md-2 control-label">Name<span class="mandatory">*</span></label>
  <div class="col-md-10">
    <input type="text" class="form-control" name="name" value="{{$name}}">
  </div>
</div>
<div class="form-group">
  <label class="col-md-2 control-label">Role<span class="mandatory">*</span></label>
  <div class="col-md-10">
    {{--todo change to style--}}
    <select class="fancy-select form-control" name="role_id" style="width:100%">
      @foreach($roles as $role)
        <option value="{{$role->id}}"
                @if($roleId == $role->id) selected @endif>
          {{$role->name}}
        </option>
      @endforeach
    </select>
  </div>
</div>
<div class="form-group">
  <label class="col-md-2 control-label">Password<span class="mandatory">*</span></label>
  <div class="col-md-10">
    <input type="password" class="form-control" name="password">
  </div>
</div>
<div class="form-group">
  <label class="col-md-2 control-label">Confirm Password<span class="mandatory">*</span></label>
  <div class="col-md-10">
    <input type="password" class="form-control" name="cfm-password">
  </div>
</div>

@section('script')
  @parent
  <script type="text/javascript">
    $('.fancy-select').select2();
  </script>
@stop

