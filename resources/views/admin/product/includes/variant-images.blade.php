<h5>Variant images</h5>

@if($record)
    <div class="row mb-2">
        @foreach($record->images as $image)
            <div class="col-md-2 text-center">
                @if($image->allow_customization)
                    <i class="fas fa-broom text-success" title="Customization Allowed"></i>
                @else
                    <i class="fas fa-broom text-danger" title="Customization Not Allowed"></i>
                @endif
                <img src="{{ $image->image_link }}" alt="{{ $image->viewCode }}">
            </div>
        @endforeach
    </div>
@endif

<hr>

<div class="group-container">
    <x-adminlte-button class="btn-sm add_field" type="button" theme="primary" icon="fas fa-lg fa-plus" title="Add Image"/>

    <div class="file_container">
        <div class="row fields-item align-items-center">
            <div class="col-md-6">
                <x-adminlte-input type="file" name="images[]" label="Image" class="file-input"/>
            </div>
            <div class="col-md-6">
                <div class="text-right">
                    <x-adminlte-input-switch name="allow_customization[]" label="{{ __('Allow Customization') }}" :checked="old('allow_customization') ?? $record && $record->allow_customization == 1"/>
                </div>
            </div>
        </div>
    </div>
</div>

