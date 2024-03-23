@extends('adminlte::page')

@section('title', $record ? __('Update Shipping Method') . ' | ' . $record->title : __('Create Shipping Method'))

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0">{{ $record ? __('Update Shipping Method') . ' | ' . $record->title : __('Create Shipping Method') }}</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="/">Գլխավոր</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.shipping-methods.index') }}">{{ __('Shipping Methods') }}</a></li>
                <li class="breadcrumb-item active">{{ $record ? __('Update Shipping Method') : __('Create Shipping Method') }}</li>
            </ol>
        </div>
    </div>
@stop

@section('content')
    <form action="{{ $record ? route('admin.shipping-methods.update',['shipping_method' => $record->id]) : route('admin.shipping-methods.store') }}" method="post" enctype="multipart/form-data">
        <div class="row">
            <div class="col-md-7">
                <div class="card card-danger card-outline">
                    <div class="card-body">
                        @csrf
                        @if($record)
                            @method('PUT')
                            <input name="id" type="hidden" value="{{ $record->id }}"/>
                        @endif
                        <div class="row">
                            <div class="col-md-6">
                                <x-adminlte-input name="title" label="Title" value="{{ old('title') ?? ($record ? $record->title : '') }}"/>
                            </div>
                            <div class="col-md-6{{ $record ? ' d-flex align-items-center' : '' }}">
                                @if($record)
                                    <img src="{{ $record->image_link }}" alt="{{ $record->title }}" style="max-width: 30%;" class="mr-2">
                                @endif
                                <x-adminlte-input name="image" type="file" label="Image"/>
                            </div>
                        </div>
                        @include('admin.includes.prices')
                        <div class="text-right">
                            <x-adminlte-button class="btn-sm" type="submit" label="Պահպանել" theme="outline-danger" icon="fas fa-lg fa-save"/>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
@stop

