<h4>Social Links <a href="#add_social" class="btn btn-primary btn-sm" title="Add" data-toggle="collapse" data-target="#add_social"><i class="fa fa-lg fa-fw fa-plus"></i></a></h4>
<div class="row mt-3">
    <div class="col-md-12">
        <div id="add_social" class="collapse">
            <form method="post" action="{{ route('admin.social.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="card card-olive card-outline">
                    <div class="card-body">
                        <h5>Add social link</h5>
                        <hr>
                        <div class="row">
                            <div class="col-md-3">
                                <x-adminlte-input name="title" label="{{ __('Title') }}" value="{{ old('title') }}"/>
                            </div>
                            <div class="col-md-3">
                                <x-adminlte-input name="icon" label="{{ __('Icon') }}" type="file"/>
                            </div>
                            <div class="col-md-6">
                                <x-adminlte-input name="link" label="{{ __('Link') }}" value="{{ old('link') }}"/>
                            </div>
                        </div>
                        <div class="text-right">
                            <x-adminlte-button class="btn-sm" type="submit" label="Save" theme="outline-danger" icon="fas fa-lg fa-save"/>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        @foreach($socials as $social)
            <div class="card card-olive card-outline">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-11">
                            <form method="post" action="{{ route('admin.social.store') }}" enctype="multipart/form-data" id="{{ $social->id }}_update">
                                @csrf
                                <input name="id" value="{{ $social->id }}" type="hidden"/>
                                <div class="row">
                                    <div class="col-md-2">
                                        <x-adminlte-input name="{{ $social->id }}_title" label="{{ __('Title') }}" value="{{ old('title') ?? $social->title }}"/>
                                    </div>
                                    @if($social->icon)
                                        <div class="col-md-1 d-flex justify-content-center align-items-center">
                                            <img src="{{ $social->image_link }}" alt="icon" style="max-height:45px;max-width: 45px;">
                                        </div>
                                    @endif
                                    <div class="col-md-{{ $social->icon ? '2' : '3' }}">
                                        <x-adminlte-input name="{{ $social->id }}_icon" label="{{ __('Icon') }}" type="file"/>
                                    </div>
                                    <div class="col-md-6">
                                        <x-adminlte-input name="{{ $social->id }}_link" label="{{ __('Link') }}" value="{{ old('link') ?? $social->link }}"/>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="col-lg-1 d-flex">
                            <x-adminlte-button class="text-success mx-1 p-0" type="submit" form="{{ $social->id }}_update" theme="" theme="outline-danger" icon="fas fa-lg fa-save"/>
                            <form action="{{ route('admin.social.destroy', ['id' => $social->id]) }}" method="post" onsubmit="return confirm('Do you really want to remove?');" style="display: inline-flex">
                                @csrf
                                @method('DELETE')
                                <input name="id" value="{{ $social->id }}" type="hidden"/>
                                <x-adminlte-button class="text-danger mx-1 p-0" type="submit" theme="" icon="fas fa-lg fa-trash"/>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
