{{-- clone-ing start here --}}
<div id="item-clone" class="hidden">
  <table>
    <tr class="clone-row">
      <td>
        <textarea class="form-control no-horizontal item-description" rows="2" name="item[_itemKey][description]"></textarea>
      </td>

      <td><input type="text" class="form-control item-unit-cost" name="item[_itemKey][unit_cost]"></td>
      <td>
        <div class="form-group">
          <div class="input-group">
            <input type="text" class="form-control item-quantity" name="item[_itemKey][quantity]" value="0">
            <span class="input-group-btn" style="width:0px;"></span>
            <input type="text" class="form-control item-unit-type" name="item[_itemKey][unit_type]" placeholder="PCS">
          </div>
        </div>

      </td>
      <td><p class="item-total text-right">0.00</p></td>
      <td><p class="item-remove hidden">x</p></td>
    </tr>
  </table>
</div>
