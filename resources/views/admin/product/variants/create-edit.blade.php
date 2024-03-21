@extends('adminlte::page')

@section('title', $record ? __('Update Variant') . ' | ' . $record->title : __('Create Variant for ') . $productItem->title)

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0">{{ $record ? __('Update Variant') . ' | ' . $record->title : __('Create Variant for ') . $productItem->title }}</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="/">{{ __('Dashboard') }}</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.products.index') }}">{{ __('Products') }}</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.products.edit', ['product' => $product]) }}">{{ $productItem->title }}</a></li>
                <li class="breadcrumb-item active">{{ $record ? __('Update Variant') : __('Create Variant') }}</li>
            </ol>
        </div>
    </div>
@stop

@section('content')
    <form action="{{ $record ? route('admin.variants.update',['product' => $product, 'variant' => $record->id]) : route('admin.variants.store',['product' => $product]) }}"
          method="post" enctype="multipart/form-data"
          data-success-url="{{ route('admin.products.edit', ['product' => $product]) }}"
    >
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
                            <div class="col-md-7">
                                <x-adminlte-input name="name" label="Variant Name" value="{{ old('name') ?? ($record ? $record->name : '') }}"/>
                            </div>
                        </div>
                        <hr>
                        @include('admin.product.includes.variant-colors')
                        <hr>
                        @include('admin.product.includes.variant-options')
                    </div>
                </div>
            </div>
            <div class="col-md-5">
                <div class="card card-olive card-outline">
                    <div class="card-body">
                        @include('admin.product.includes.variant-images')
                        <div class="text-right">
                            <x-adminlte-button class="btn btn-success btn-flat ajaxSave" type="button" label="Save" theme="success" icon="fas fa-lg fa-save"/>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
    @if($record)
        <div class="card card-success card-outline">
            <div class="card-body">
                <h5>Variant Sizes <a href="{{ route('admin.sizes.create',['variant'=>$record->id]) }}" class="btn btn-primary btn-sm" title="Add"><i class="fa fa-lg fa-fw fa-plus"></i></a></h5>
                @include('admin.product.includes.sizes',['sizes' => $record->sizes ?? null])
            </div>
        </div>
    @endif
@stop

