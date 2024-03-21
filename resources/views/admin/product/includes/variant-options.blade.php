<h5>Options</h5>

@if($record)
    <div class="row mb-2">
        @foreach($record->variantOptions as $item)
            <input type="hidden" name="options[]" value="{{ $item->option->id }}"/>
            <div class="col-md-6">
                <div class="card card-body p-1">
                    <a href="#" data-toggle="collapse" class="text-olive" data-target="#option_{{ $item->option->id }}">{{ $item->option->title }}</a>
                    <div id="option_{{ $item->option->id }}" class="collapse">
                        <div class="group-container">
                            @foreach($item->values as $valueItem)
                                <div class="file_container">
                                    <div class="row fields-item">
                                        <div class="col-md-8">
                                            <x-adminlte-input name="values_{{ $item->option->id }}[]" label="Value" value="{{ old('values_'.$item->option->id) ?? $valueItem->value }}"/>
                                        </div>
                                        <div class="col-md-4">
                                            <x-adminlte-input type="number" step="0.1" name="additional_prices_{{ $item->option->id }}[]" label="Additional Price" value="{{ old('additional_prices_'.$item->option->id) ?? $valueItem->additional_price }}"/>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                            <x-adminlte-button class="btn btn-success btn-flat btn-sm add_field p-1" type="button" theme="primary" icon="fas fa-lg fa-plus" title="Add Value"/>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endif

<div class="group-container">
    <div class="file_container">
        <div class="row fields-item">
            <div class="col-md-4">
                <x-adminlte-select name="options[]" label="Option">
                    <x-adminlte-options :options="$options" empty-option="Select Option"/>
                </x-adminlte-select>
            </div>
            <div class="col-md-8">
                <div class="group-container">
                    <div class="file_container">
                        <div class="row fields-item">
                            <div class="col-md-8">
                                <x-adminlte-input name="values_" label="Value"/>
                            </div>
                            <div class="col-md-4">
                                <x-adminlte-input type="number" step="0.1" name="additional_prices_" label="Additional Price"/>
                            </div>
                        </div>
                    </div>
                    <x-adminlte-button class="btn btn-success btn-flat btn-sm add_field p-1" type="button" theme="primary" icon="fas fa-lg fa-plus" title="Add Value"/>
                </div>
            </div>
        </div>
    </div>
    <x-adminlte-button class="btn btn-success btn-flat btn-sm add_field" type="button" theme="primary" icon="fas fa-lg fa-plus" title="Add Option"/>
</div>

