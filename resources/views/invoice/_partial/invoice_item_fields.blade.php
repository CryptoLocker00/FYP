<?php
$total = 0;

$remarks = Request::old('remarks');
if (is_null($remarks)) {
    $remarks = empty($invoice) ? '' : $invoice->remarks;
}
?>
<div class="col-md-12">
  <table class="table">
    <thead>
    <tr>
      {{--<th class="col-md-2">Item Code</th>--}}
      <th class="col-md-6">Description</th>
      <th class="col-md-2">Unit Cost</th>
      <th class="col-md-2">Quantity</th>
      <th class="col-md-2 text-right">Total</th>
      <th></th>
    </tr>
    </thead>
    <tbody id="append-table">
    {{-- with here start is the table row --}}
    <?php $key = 0; ?>
    @foreach($invoiceItems as $item)

      <tr id="{{$key}}" class="quote-item">
        {{--<td><input type="text" class="form-control" value="{{$item->item_code}}"></td>--}}
        <td><textarea name="item[{{$key}}][description]" class="form-control no-horizontal item-description" rows="2">{{$item->description}}</textarea></td>
        <td><input name="item[{{$key}}][unit_cost]" type="text" class="form-control item-unit-cost" value="{{$item->unit_cost}}"></td>
        <td>
          <div class="input-group">
            <input name="item[{{$key}}][quantity]" type="text" class="form-control item-quantity" value="{{$item->quantity}}">
            <span class="input-group-btn" style="width:0px;"></span>
            <input name="item[{{$key}}][unit_type]" type="text" class="form-control item-unit-type" value="{{$item->unit_type}}">
          </div>
        </td>
          <?php
          $subTotal = number_format($item->unit_cost * $item->quantity, 2, '.', '');
          $total += $subTotal;
          ?>
        <td><p class="item-total text-right">{{number_format($item->unit_cost * $item->quantity,2,'.','')}}</p></td>
      </tr>
      <?php $key++; ?>
    @endforeach
    </tbody>
  </table>

  <div class="col-md-6">
    <div class="form-group row">
      <label class="control-label">Remarks</label>
      <textarea name="remarks" id="input-remarks" rows="3" class="form-control">{{$remarks}}</textarea>
    </div>
  </div>

  <div class="col-md-6">
    <div class="row">
      <div class="col-md-10 col-md-offset-2 quote-total-wrapper">
        <h4 class="no-space col-md-3">Sub Total</h4>
        <h4 class="no-space col-md-9 text-right" id="quote-sub-total">{{number_format($total, 2, '.', '')}}</h4>
      </div>
    </div>
    <div class="row">
      <div class="col-md-10 col-md-offset-2 quote-total-wrapper">
        <h4 class="no-space col-md-3">GST</h4>
        <h4 class="no-space col-md-9 text-right" id="quote-gst">{{number_format($total / 100 * 6, 2, '.', ',')}}</h4>
      </div>
    </div>
    <div class="row">
      <div class="col-md-10 col-md-offset-2 quote-total-wrapper">
        <h4 class="no-space col-md-3">Total</h4>
        <h4 class="no-space col-md-9 text-right" id="quote-total">{{number_format($total + ($total / 100 * 6), 2, '.', ',')}}</h4>
      </div>
    </div>
  </div>
</div>

@section('script')
  @parent
  <script type="text/javascript">
    // auto resize for textarea
    autosize($('.item-description'));

    $.fn.digits = function () {
      return this.each(function () {
        $(this).text($(this).text().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,"));
      })
    };

    // calculate the total
    $(document).on('keyup', '.item-unit-cost', function (e) {
      var itemParents = $(this).parents('.quote-item');
      var itemCost = $(this).val();
      var itemQty = itemParents.find('.item-quantity').val();
      // using function
      assignItemTotal(itemCost, itemQty, itemParents);
    });

    // calculate the total
    $(document).on('keyup', '.item-quantity', function () {
      var itemParents = $(this).parents('.quote-item');
      var itemQty = $(this).val();
      var itemCost = itemParents.find('.item-unit-cost').val();
      // using function
      assignItemTotal(itemCost, itemQty, itemParents);
    });

    function assignItemTotal(cost, qty, parentDom) {
      var total = 0;
      cost = typeof cost !== 'undefined' ? filterFloat(cost) : 0;
      qty = typeof qty !== 'undefined' ? filterFloat(qty) : 0;

      total = cost * qty;
      parentDom.find('.item-total').html(total.toFixed(2));
      parentDom.find('.item-total').digits();
      assignQuoteTotal();
    }

    function assignQuoteTotal() {
      var subTotal = 0;
      $('.quote-item').each(function () {
        subTotal += filterFloat($(this).find('.item-total').html());
      });
      $('#quote-sub-total').html(subTotal.toFixed(2));
      var gst = subTotal / 100 * 6;
      $('#quote-gst').html(gst.toFixed(2));
      var total = subTotal + gst;
      $('#quote-total').html(total.toFixed(2));
      $('#quote-total').digits();
      $('#quote-gst').digits();
      $('#quote-sub-total').digits();
    }

    function filterFloat(value) {
      value = value.replace(/,/g, '');
      if (/^(\-|\+)?([0-9]+(\.[0-9]+)?)$/.test(value))
        return Number(value);
      return 0;
    }

//    $(document).on('click', '.item-remove', function (e) {
//      $(this).parents('tr').remove();
//    })
  </script>
@endsection
