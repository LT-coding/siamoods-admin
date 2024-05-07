<tr>
    <td class="pt-2">
        <div class="input-group w-75">
            <span class="input-group-text">֏</span>
            <input type="number" step="0.01" class="form-control" name="area[{{$k}}][product_cost][]" value="{{$rate?$rate->product_cost:''}}">
        </div>
    </td>
    <td class="pt-2">
        <div class="input-group w-75">
            <span class="input-group-text">֏</span>
            <input type="number" step="0.01" class="form-control" name="area[{{$k}}][rate][]" value="{{$rate?$rate->rate:''}}">
        </div>
    </td>
</tr>
