<h4>Contact Info</h4>
<div class="row mt-3">
    <div class="col-md-6">
        <form method="post" action="{{ route('admin.contact.store') }}">
            @csrf
            <div class="card card-olive card-outline">
                <div class="card-body">
                    @foreach(App\Enums\ContactTypes::getKeys() as $i => $item)
                        @php $contact = App\Models\Contact::query()->where('type',$item)->first(); @endphp
                        <input name="type[]" type="hidden" value="{{ $item }}"/>
                        <x-adminlte-input name="text[]" label="{{ App\Enums\ContactTypes::getConstants()[$item] }}"
                                          value="{{ old('text')[$i] ?? ($contact ? $contact->text : '') }}"/>
                    @endforeach
                    <div class="text-right">
                        <x-adminlte-button class="btn btn-success btn-flat" type="submit" label="Save" theme="success" icon="fas fa-lg fa-save"/>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
