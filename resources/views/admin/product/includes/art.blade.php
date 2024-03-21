<div class="group-container">
    <x-adminlte-button class="btn-sm add_field" type="button" theme="primary" icon="fas fa-lg fa-plus" title="Add {{ ucfirst($style) }}"/>

    @if($errors->has('images.*'))
        <span class="invalid-feedback d-block" role="alert">
            <strong>{{ $errors->first('images.*') }}</strong>
        </span>
    @endif
    <div class="row file_container">
        <div class="col-md-3 fields-item">
            <x-adminlte-input type="file" name="images[]" label="{{ ucfirst($style) }}" class="file-input"/>
        </div>
    </div>
</div>
