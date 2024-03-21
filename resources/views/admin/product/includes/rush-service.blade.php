<div class="card card-success card-outline">
    <div class="card-body">
        <div class="text-right">
            <x-adminlte-input-switch name="rush_service_available" label="{{ __('Rush Service Available') }}" :checked="old('rush_service_available') ?? $record && $record->rush_service_available == 1"/>
        </div>
        <div id="rush_service" style="display: {{ old('rush_service_available') || $record && $record->rush_service_available == 1 ? 'block' : 'none' }}">
            <div class="group-container">
                @if($record && $record->rushServices()->count() > 0)
                    <div class="row file_container">
                        @foreach($record->rushServices as $service)
                            <div class="col-md-3 fields-item">
                                <div class="card card-sm p-1">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <x-adminlte-input name="service_days[]" placeholder="Days" value="{{ $service->service_days }}"/>
                                        </div>
                                        <div class="col-md-6">
                                            <x-adminlte-input type="number" step="0.1" name="service_prices[]" placeholder="Price" value="{{ $service->service_price }}"/>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="row file_container">
                        <div class="col-md-3 fields-item">
                            <div class="card card-sm p-1">
                                <div class="row">
                                    <div class="col-md-6">
                                        <x-adminlte-input name="service_days[]" placeholder="Days"/>
                                    </div>
                                    <div class="col-md-6">
                                        <x-adminlte-input type="number" step="0.1" name="service_prices[]" placeholder="Price"/>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                <x-adminlte-button class="btn btn-success btn-flat btn-sm add_field mb-2" type="button" theme="primary" icon="fas fa-lg fa-plus" title="Add"/>
            </div>
        </div>
    </div>
</div>

