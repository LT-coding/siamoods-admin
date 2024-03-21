<h5>Prices</h5>

<div class="group-container">
    @if($record)
        <div class="row file_container">
            @foreach($record->prices as $item)
                <div class="col-md-6 fields-item">
                    <div class="card card-body p-1">
                        <div class="row">
                            <div class="col-md-4">
                                <x-adminlte-input type="number" min="1" name="price_from_counts[]" label="Price from Count" value="{{ $item->price_from_count }}"/>
                            </div>
                            <div class="col-md-4">
                                <x-adminlte-input type="number" step="0.1" name="prices[]" label="Price" value="{{ $item->price }}"/>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="row file_container">
            <div class="col-md-6 fields-item">
                <div class="card card-body p-1">
                    <div class="row">
                        <div class="col-md-4">
                            <x-adminlte-input type="number" min="1" name="price_from_counts[]" label="Price from Count"/>
                        </div>
                        <div class="col-md-4">
                            <x-adminlte-input type="number" step="0.1" name="prices[]" label="Price"/>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
    <x-adminlte-button class="btn btn-success btn-flat btn-sm add_field" type="button" theme="primary" icon="fas fa-lg fa-plus" title="Add Price"/>
</div>

