@extends('adminlte::page')

@section('title', $record ? __('Update Related Product') . ' | ' . $record->title : __('Create Related Product for ') . $productItem->title)

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0">{{ $record ? __('Update Related Product') . ' | ' . $record->title : __('Create Related Product for ') . $productItem->title }}</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="/">{{ __('Dashboard') }}</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.products.index') }}">{{ __('Products') }}</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.products.edit', ['product' => $product]) }}">{{ $productItem->title }}</a></li>
                <li class="breadcrumb-item active">{{ $record ? __('Update Related Product') : __('Create Related Product') }}</li>
            </ol>
        </div>
    </div>
@stop

@section('content')
    <form action="{{ $record ? route('admin.related-products.update',['product' => $product, 'related_product' => $record->id]) : route('admin.related-products.store',['product' => $product]) }}" method="post" enctype="multipart/form-data">
        <div class="row">
            <div class="col-md-7">
                <div class="card card-primary card-outline">
                    <div class="card-body">
                        @csrf
                        @if($record)
                            @method('PUT')
                            <input name="id" type="hidden" value="{{ $record->id }}"/>
                        @endif
                        <input name="product_code" type="hidden" value="{{ $productItem->code }}"/>
                        <div class="row">
                            <div class="col-md-5">
                                <x-adminlte-input name="title" label="Product Title" value="{{ old('title') ?? ($record ? $record->title : '') }}"/>
                            </div>
                            <div class="col-md-4{{ $record ? ' d-flex align-items-center' : '' }}">
                                @if($record)
                                    <img src="{{ $record->image_link }}" alt="{{ $record->title }}" style="max-width: 30%;" class="mr-2">
                                @endif
                                <x-adminlte-input name="image" type="file" label="Product Image"/>
                            </div>
                            <div class="col-md-3">
                                <x-adminlte-input type="number" step="0.1" name="additional_price" label="Additional Price" value="{{ old('additional_price') ?? ($record ? $record->additional_price : '') }}"/>
                            </div>
                        </div>
                        <div class="text-right">
                            <x-adminlte-button class="btn btn-success btn-flat" type="submit" label="Save" theme="success" icon="fas fa-lg fa-save"/>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
@stop

