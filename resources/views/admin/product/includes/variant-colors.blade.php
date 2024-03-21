@php $color = \App\Models\Option::query()->colorOnly()->first(); @endphp
<h5>Colors</h5>

<div class="group-container">
    <input type="hidden" name="options[]" value="{{ $color->id }}"/>

    @if($record && $record->color && $record->color->values()->count() > 0)
        <div class="row file_container">
            @foreach($record->color->values as $item)
                <div class="col-md-3 fields-item">
                    <div class="card card-body p-1">
                        <div class="row">
                            <div class="col-md-7">
                                <x-adminlte-input name="names_{{ $color->id }}[]" label="Color Name" value="{{ old('names_'.$color->id) ?? $item->name }}"/>
                            </div>
                            <div class="col-md-5">
                                <x-adminlte-input type="color" name="values_{{ $color->id }}[]" label="Value" value="{{ old('values_'.$color->id) ?? $item->value }}"/>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="row file_container">
            <div class="col-md-3 fields-item">
                <div class="card card-body p-1">
                    <div class="row">
                        <div class="col-md-7">
                            <x-adminlte-input name="names_{{ $color->id }}[]" label="Color Name"/>
                        </div>
                        <div class="col-md-5">
                            <x-adminlte-input type="color" name="values_{{ $color->id }}[]" label="Value" value="#000000"/>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
    <x-adminlte-button class="btn-sm add_field" type="button" theme="primary" icon="fas fa-lg fa-plus" title="Add Image"/>
</div>
