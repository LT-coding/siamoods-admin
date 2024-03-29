<tr data-id="{{$i}}">
    <td class="pt-2">
        <div class="image_preview">
            <div class="input-group ">
                <span class="input-group-text"><i class="fa-solid fa-image"></i></span>
                <input type="file" class="form-control" name="1[socials][{{$i}}][image]">
            </div>
            <div class="preview" style="{{!($social&&$social->image)?'display: none;':''}} width: 100px">
                <img src="{{$social ?$social->image:''}}" class="img_preview">
            </div>
        </div>
    </td>
    <td class="pt-2" style="vertical-align: top;">
        <div class="input-group pl-2">
            <span class="input-group-text"><i class="fa-solid fa-link"></i></span>
            <input type="text" class="form-control" name="1[socials][{{$i}}][url]" value="{{$social?$social->url:''}}">
        </div>
    </td>
</tr>
