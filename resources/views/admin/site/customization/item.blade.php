<div>
    @php
        $name=\App\Models\Customization::where('name','LIKE','main_item_'.$i.'_name')->first();
        $icon=\App\Models\Customization::where('name','LIKE','main_item_'.$i.'_icon')->first();
        $desc=\App\Models\Customization::where('name','LIKE','main_item_'.$i.'_desc')->first();
    @endphp
    <div class="mb-3">
        <div class="row">
            <label class="col-sm-3 form-label align-self-center mb-lg-0 text-end">Անուն<sup
                    class="text-danger">*</sup></label>
            <div class="col-sm-9">
                <input class="form-control" type="text" name="2[main_item][main_item_{{$i}}_name]" value="{{$name?$name->value:''}}">
            </div>
        </div>
    </div>
    <div class="mb-3">
        <div class="row">
            <label class="col-sm-3 form-label align-self-start mb-lg-0 text-end">Նկար</label>
            <div class="col-sm-9">
                <div class="image_preview">
                    <input type="file" name="2[main_item][main_item_{{$i}}_icon]" class="form-control img_with_preview">
                    <div class="preview" style="{{!($icon&&$icon->value)?'display: none;':''}} width:100px" >
                        <img src="{{$icon?$icon->value:''}}" class="img_preview">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div>
        <div class="row">
            <label class="col-sm-3 form-label align-self-start mb-lg-0 text-end">Բովանդակություն</label>
            <div class="col-sm-9">
                <div class="">
                    <textarea class="form-control" name="2[main_item][main_item_{{$i}}_desc]">{{$desc?$desc->value:''}}</textarea>
                </div>
            </div>
        </div>
    </div>
    @if($i!=2)
        <hr>
    @endif
</div>
