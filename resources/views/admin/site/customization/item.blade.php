<div class="mb-3">
    @php
        $name=\App\Models\Customization::query()->where('name','LIKE','main_item_'.$i.'_name')->first();
        $icon=\App\Models\Customization::query()->where('name','LIKE','main_item_'.$i.'_icon')->first();
        $desc=\App\Models\Customization::query()->where('name','LIKE','main_item_'.$i.'_desc')->first();
    @endphp
    <div class="row mb-2">
        <label class="col-sm-3 form-label align-self-center mb-lg-0 text-end">Անուն<sup
                class="text-danger">*</sup></label>
        <div class="col-sm-9">
            <x-adminlte-input name="2[main_item][main_item_{{$i}}_name]" value="{{ $name ? $name->value : '' }}"/>
        </div>
    </div>
    <div class="row mb-2">
        <label class="col-sm-3 form-label align-self-start mb-lg-0 text-end">Նկար</label>
        <div class="col-sm-9">
            <div class="image_preview">
                <x-adminlte-input type="file" name="2[main_item][main_item_{{$i}}_icon]"/>
                @if($icon?->value)
                    <div class="preview" style="{{!($icon&&$icon->value)?'display: none;':''}} width:100px" >
                        <img src="{{ $icon->value }}" class="img_preview" alt="icon">
                    </div>
                @endif
            </div>
        </div>
    </div>
    <div class="row">
        <label class="col-sm-3 form-label align-self-start mb-lg-0 text-end">Բովանդակություն</label>
        <div class="col-sm-9">
            <x-adminlte-textarea name="2[main_item][main_item_{{$i}}_desc]">{{ $desc ? $desc->value : '' }}</x-adminlte-textarea>
        </div>
    </div>
    @if($i!=2)
        <hr>
    @endif
</div>
