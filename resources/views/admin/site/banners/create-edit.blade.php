@extends('adminlte::page')

@section('title', $record ? __('Update Banner') : __('Create Banner') )

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0">{{ $record ? __('Update Banner') : __('Create Banner') }}</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="/">{{ __('Dashboard') }}</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.banners.index') }}">{{ __('Banners') }}</a></li>
                <li class="breadcrumb-item active">{{ $record ? __('Update Banner') : __('Create Banner') }}</li>
            </ol>
        </div>
    </div>
@stop

@section('content')
    @php $statuses = \App\Enums\StatusTypes::statusList(); $types = \App\Enums\BannerTypes::typeList() @endphp
    <div class="row">
        <div class="col-md-10">
            <div class="card card-primary card-outline">
                <div class="card-body">
                    <form action="{{ $record ? route('admin.banners.update',['banner'=>$record->id]) : route('admin.banners.store') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        @if($record)
                            @method('PUT')
                            <input name="id" type="hidden" value="{{ $record->id }}"/>
                            <img src="{{ $record->image_link }}" alt="image" style="max-height:150px;max-width: 100%;">
                        @endif
                        <div class="fields-group">
                            <div class="row">
                                <div class="col-md-2">
                                    <x-adminlte-select name="type" label="Select Banner Location" id="banner_location">
                                        <x-adminlte-options :options="$types" :selected="old('type') ?? ($record ? [$record->type] : [])"/>
                                    </x-adminlte-select>
                                </div>
                                <div class="col-md-3">
                                    <x-adminlte-input name="image" label="{{ __('Banner Image') }}" type="file"/>
                                </div>
                                <div class="col-md-5">
                                    <x-adminlte-input name="title" label="Title" value="{{ old('title') ?? ($record ? $record->title : '') }}"/>
                                </div>
                                <div class="col-md-2">
                                    <x-adminlte-select name="status" label="Status">
                                        <x-adminlte-options :options="$statuses" :selected="old('status') ?? ($record ? [$record->status] : [])"/>
                                    </x-adminlte-select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <x-adminlte-input name="subtitle" label="Subtitle" value="{{ old('subtitle') ?? ($record ? $record->subtitle : '') }}"/>
                                </div>
                                <div class="col-md-6 show-header{{old('type') && old('type')=='home' ? ' d-none' : ''}}">
                                    <x-adminlte-input name="offer_text" label="Offer Text" value="{{ old('offer_text') ?? ($record ? $record->offer_text : '') }}"/>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <x-adminlte-input name="main_button_text" label="Main Button Text" value="{{ old('main_button_text') ?? ($record ? $record->main_button_text : '') }}"/>
                                        </div>
                                        <div class="col-sm-8">
                                            <x-adminlte-input name="main_button_url" label="Main Button URL" value="{{ old('main_button_url') ?? ($record ? $record->main_button_url : '') }}"/>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 show-header{{old('type') && old('type')=='home' ? ' d-none' : ''}}">
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <x-adminlte-input name="secondary_button_text" label="Secondary Button Text" value="{{ old('secondary_button_text') ?? ($record ? $record->secondary_button_text : '') }}"/>
                                        </div>
                                        <div class="col-sm-8">
                                            <x-adminlte-input name="secondary_button_url" label="Secondary Button URL" value="{{ old('secondary_button_url') ?? ($record ? $record->secondary_button_url : '') }}"/>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="text-right">
                                <x-adminlte-button class="btn-sm" type="submit" label="Save" theme="outline-danger" icon="fas fa-lg fa-save"/>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop

