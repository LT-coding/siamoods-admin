@extends('adminlte::page')

@section('title', __('Site SEO'))

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0">{{ __('Site SEO') }}</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="/">{{ __('Dashboard') }}</a></li>
                <li class="breadcrumb-item active">{{ __('Site SEO') }}</li>
            </ol>
        </div>
    </div>
@stop

@section('content')
    <div class="card card-primary card-outline card-outline-tabs">
        <div class="card-header p-0 border-bottom-0">
            <ul class="nav nav-tabs" id="custom-tabs-four-tab" role="tablist">
                @foreach(App\Enums\StaticPages::getKeys() as $i => $item)
                    <li class="nav-item">
                        <a class="nav-link{{ $i == 0 ? ' active' : '' }}" id="{{$item}}-tab" data-toggle="pill" href="#tab-{{$item}}" role="tab">{{ App\Enums\StaticPages::getConstants()[$item] }}</a>
                    </li>
                @endforeach
            </ul>
        </div>
        <div class="card-body">
            <div class="tab-content" id="custom-tabs-four-tabContent">
                @foreach(App\Enums\StaticPages::getKeys() as $i => $item)
                    @php $meta = App\Models\Meta::query()->where('page',$item)->first(); @endphp
                    <div class="tab-pane fade{{ $i == 0 ? ' active show' : '' }}" id="tab-{{$item}}" role="tabpanel">
                        <h4>
                            {{ App\Enums\StaticPages::getConstants()[$item] }} Page SEO
                        </h4>
                        <form method="post" action="{{ route('admin.seo.store') }}">
                            @csrf
                            <x-adminlte-input name="page" id="{{ $item }}_page" type="hidden" value="{{ $item }}"/>
                            <div class="row">
                                <div class="col-md-6">
                                    <x-adminlte-input name="{{ $item }}_meta_title" label="{{ __('Meta Title') }}" value="{{ old($item .'_meta_title') ?? ($meta ? $meta->meta_title : '') }}"/>
                                </div>
                                <div class="col-md-6">
                                    <x-adminlte-input name="{{ $item }}_meta_keywords" label="{{ __('Meta Keywords') }}" value="{{ old($item .'_meta_keywords') ?? ($meta ? $meta->meta_keywords : '') }}"/>
                                </div>
                                <div class="col-md-12">
                                    <x-adminlte-textarea name="{{ $item }}_meta_description" label="{{ __('Meta Description') }}">{{ old($item .'_meta_description') ?? ($meta ? $meta->meta_description : '') }}</x-adminlte-textarea>
                                </div>
                            </div>
                            <div class="text-right">
                                <x-adminlte-button class="btn btn-success btn-flat" type="submit" label="Save" theme="success" icon="fas fa-lg fa-save"/>
                            </div>
                        </form>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@stop
