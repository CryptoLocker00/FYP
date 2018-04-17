<?php
$item_code = Request::old('item_code');
if (is_null($item_code)) {
  $item_code = empty($item) ? '' : $item->item_code;
}
$description = Request::old('description');
if (is_null($description)) {
  $description = empty($item) ? '' : $item->description;
}
$unit_cost = Request::old('unit_cost');
if (is_null($unit_cost)) {
  $unit_cost = empty($item) ? '' : $item->unit_cost;
}
?>

<div class="form-group">
  <label class="col-md-2 control-label">Item Code<span class="mandatory">*</span></label>
  <div class="col-md-10">
    <input type="text" class="form-control" name="item_code" value="{{$item_code}}">
  </div>
</div>
<div class="form-group">
  <label class="col-md-2 control-label">Description</label>
  <div class="col-md-10">
    <textarea rows="3" class="form-control description" name="description">{{$description}}</textarea>
  </div>
</div>
<div class="form-group">
  <label class="col-md-2 control-label">Unit Cost<span class="mandatory">*</span></label>
  <div class="col-md-10">
    <input type="text" class="form-control" name="unit_cost" value="{{$unit_cost}}">
  </div>
</div>

@section('script')
  @parent
  <script type="text/javascript">
    autosize($('.description'));
  </script>
@stop