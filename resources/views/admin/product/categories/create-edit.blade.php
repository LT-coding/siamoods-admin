@extends('adminlte::page')

@section('title', $record ? __('Update Category') . ' | ' . $record->title : __('Create Category') )

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0">{{ $record ? __('Update Category') .  ' | ' . $record->title : __('Create Category') }}</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="/">{{ __('Dashboard') }}</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.categories.index') }}">{{ __('Categories') }}</a></li>
                <li class="breadcrumb-item active">{{ $record ? __('Update Category') : __('Create Category') }}</li>
            </ol>
        </div>
    </div>
@stop

@section('content')
    @php $categories = $record ? \App\Models\Category::query()->where('id','!=',$record->id)->pluck('title','id')->toArray() : \App\Models\Category::query()->pluck('title','id')->toArray() @endphp
    <form action="{{ $record ? route('admin.categories.update',['category'=>$record->id]) : route('admin.categories.store') }}" method="post" enctype="multipart/form-data">
        <div class="row">
            <div class="col-md-8">
                <div class="card card-primary card-outline">
                    <div class="card-body">
                        @csrf
                        <div class="text-right">
                            <x-adminlte-input-switch name="show_in_menu" label="{{ __('Show in Main Menu') }}" :checked="old('show_in_menu') ?? $record && $record->show_in_menu == 1"/>
                            <x-adminlte-input-switch name="show_in_best" label="{{ __('Show in Best Categories') }}" :checked="old('show_in_best') ?? $record && $record->show_in_best == 1"/>
                            <x-adminlte-input-switch name="show_in_new" label="{{ __('Show in New Categories') }}" :checked="old('show_in_new') ?? $record && $record->show_in_new == 1"/>
                        </div>
                        @if($record)
                            @method('PUT')
                            <input name="id" type="hidden" value="{{ $record->id }}"/>
                            @if($record->image)
                                <img src="{{ $record->image_link }}" alt="image" style="max-height:150px;max-width: 100%;">
                            @endif
                        @endif
                        <div class="row">
                            <div class="col-md-3">
                                <x-adminlte-select name="parent_id" label="Parent">
                                    <x-adminlte-options :options="$categories" :selected="old('parent_id') ?? ($record ? [$record->parent_id] : [])" empty-option="Select a Category"/>
                                </x-adminlte-select>
                            </div>
                            <div class="col-md-4">
                                <x-adminlte-input name="title" label="Title" value="{{ old('title') ?? ($record ? $record->title : '') }}"/>
                                @if($errors->has('code'))
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $errors->first('code') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="col-md-2">
                                <x-adminlte-input name="image" label="{{ __('Image') }}" type="file"/>
                            </div>
                            <div class="col-md-3">
                                <x-adminlte-input type="number" step="0.1" name="extra_shipping_price" label="Extra Shipping Price" value="{{ old('extra_shipping_price') ?? ($record ? $record->extra_shipping_price : '') }}"/>
                            </div>
                        </div>
                    </div>
                </div>
                @include('admin.product.includes.rush-service')
            </div>
            <div class="col-md-4">
                <div class="card card-olive card-outline">
                    <div class="card-body">
                        <x-adminlte-input name="meta_title" label="Meta Title" value="{{ old('meta_title') ?? ($record ? $record->meta_title : '') }}"/>
                        <x-adminlte-input name="meta_keywords" label="Meta Keywords" value="{{ old('meta_keywords') ?? ($record ? $record->meta_keywords : '') }}"/>
                        <x-adminlte-textarea name="meta_description" label="{{ __('Meta Description') }}">{{ old('meta_description') ?? ($record ? $record->meta_description : '') }}</x-adminlte-textarea>
                        <div class="text-right">
                            <x-adminlte-button class="btn btn-success btn-flat" type="submit" label="Save" theme="success" icon="fas fa-lg fa-save"/>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
@stop

