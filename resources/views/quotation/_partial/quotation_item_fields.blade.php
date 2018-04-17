<?php
$total = 0;

$remarks = Request::old('remarks');
if (is_null($remarks)) {
    $remarks = empty($quotation) ? '' : $quotation->remarks;
}
?>

<div class="col-md-12">
  <table class="table">
    <thead>
    <tr>
      <th class="col-md-5">Description</th>
      <th class="col-md-2">Unit Cost</th>
      <th class="col-md-3">Quantity</th>
      <th class="col-md-2 text-right">Total</th>
      <th></th>
    </tr>
    </thead>
    <tbody id="append-table">
    {{-- with here start is the table row --}}
    @if(!empty($quotationItems))
        <?php $key = 0; ?>
        @foreach($quotationItems as $item)
            <?php $newSelect = false; ?>
            <tr id="{{$key}}" class="quote-item active-item">
              <td>
                <textarea class="form-control no-horizontal item-description" rows="2" name="item[{{$key}}][description]">{{$item->description}}</textarea>
              </td>

              <td><input type="text" class="form-control item-unit-cost" name="item[{{$key}}][unit_cost]" value="{{$item->unit_cost}}"></td>
              <td>
                <div class="input-group">
                  <input type="text" class="form-control item-quantity" name="item[{{$key}}][quantity]" value="{{$item->quantity}}">
                  <span class="input-group-btn" style="width:0px;"></span>
                  <input type="text" class="form-control item-unit-type" name="item[{{$key}}][unit_type]" value="{{$item->unit_type}}">
                </div>
              </td>
                <?php
                $subTotal = number_format($item->unit_cost * $item->quantity, 2, '.', '');
                $total += $subTotal;
                ?>
              <td><p class="item-total text-right">{{number_format($item->unit_cost * $item->quantity,2,'.','')}}</p></td>
              <td><p class="item-remove">x</p></td>
            <?php $key++; ?>
        @endforeach
    @endif

    <tr id="{{$nextKey}}" class="quote-item">
      <td>
        <textarea class="form-control no-horizontal item-description" rows="2" name="item[{{$nextKey}}][description]"></textarea>
      </td>
      <td><input type="text" class="form-control item-unit-cost" name="item[{{$nextKey}}][unit_cost]"></td>
      <td>
        <div class="form-group">
          <div class="input-group">
            <input type="text" class="form-control item-quantity" name="item[{{$nextKey}}][quantity]" value="0">
            <span class="input-group-btn" style="width:0px;"></span>
            <input type="text" class="form-control item-unit-type" name="item[{{$nextKey}}][unit_type]" placeholder="PCS">
          </div>
        </div>
      </td>
      <td><p class="item-total text-right">0.00</p></td>
      <td><p class="item-remove hidden">x</p></td>
    </tr>
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
</div>



@section('script')
  @parent
  <script type="text/javascript">

    var list = document.getElementById("append-table");
    Sortable.create(list);

    // auto resize for textarea
    autosize($('.item-description'));

    $(document).ready(function () {
      $('.item-select-2').select2({
        tags        :true,
        placeholder :"Select item"
      }).on('select2:select', function (e) {
        getAndAssignDataValue(e, $(this));
        cloneAndAppandObject($(this))
      });

      function getAndAssignDataValue(e, element) {
        var desc = "";
        var cost = "";
        if ( typeof e.params.data.element != 'undefined' ) {
          desc = e.params.data.element.dataset.description;
          cost = e.params.data.element.dataset.cost;
        }

        assignItemDefaultVal(desc, cost, $(element));
      }

      function assignItemDefaultVal(desc, cost, element) {
        $(element).parents('tr').find('.item-unit-cost').val(cost);
        $(element).parents('tr').find('.item-description').val(desc);
        autosize.update($('.item-description'))
      }

      function cloneAndAppandObject(element) {
        // not going to clone another new object when this parent has 'active item' class
        if ( $(element).parents('tr').hasClass('active-item') ) {
          return false;
        }

        // add class to disable clone
        $(element).parents('tr').addClass('active-item').addClass('quote-item');

        // get parent id and + 1
        var parentId = $(element).parents('.quote-item').attr('id');
        var cloneObjId = parseInt(parentId) + 1;

        var newItem = initCloneItem(cloneObjId);
        $('#append-table').append(newItem);

        initParticularSelect2(cloneObjId);
      }

      function initCloneItem(ObjId) {
        var newItem = $('#item-clone').find('tr.clone-row').clone();
        // enable clone
        $(newItem).removeClass('clone-row').addClass('quote-item').attr('id', ObjId);
        $(newItem).find('.item-remove').removeClass('hidden');
        // replace all _itemKey to ids
        newItem = $(newItem).prop('outerHTML').replace(/_itemKey/g, ObjId);
        newItem = $.parseHTML(newItem);
        autosize($('.item-description'));

        return newItem;
      }

      // init select 2
      function initParticularSelect2(ObjId) {
        $('.init-item-select-2' + '.' + ObjId).select2({
          tags        :true,
          placeholder :"Select item"
        }).on('select2:select', function (e) {
          getAndAssignDataValue(e, $(this));
          cloneAndAppandObject($(this))
        });
      }

      $.fn.digits = function () {
        return this.each(function () {
          $(this).text($(this).text().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,"));
        })
      };

      // convert every number to float
      function filterFloat(value) {
        value = value.replace(/,/g, '');
        if ( /^(\-|\+)?([0-9]+(\.[0-9]+)?)$/.test(value) )
          return Number(value);
        return 0;
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

      // calculate the total
      $(document).on('keyup', '.item-unit-cost', function (e) {
        var itemParents = $(this).parents('.quote-item');
        var itemCost = $(this).val();
        var itemQty = itemParents.find('.item-quantity').val();
        // using function
        assignItemTotal(itemCost, itemQty, itemParents);
        cloneAndAppandObject($(this))
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

      $(document).on('click', '.item-remove', function (e) {
        $(this).parents('tr').remove();
      })
    })

  </script>
@stop
