<div class="row mb-3">
    <div class="col-md-4 image_preview">
        <x-adminlte-input type="file" name="1[socials][{{$i}}][image]"/>
        @if($social?->image)
            <div class="preview" style="{{!($social&&$social->image)?'display: none;':''}} width: 100px">
                <img src="{{ $social->image }}" class="img_preview" alt="icon">
            </div>
        @endif
    </div>
    <div class="col-md-8">
        <x-adminlte-input name="1[socials][{{$i}}][url]" value="{{ $social ? $social->url : '' }}"/>
    </div>
</div>
