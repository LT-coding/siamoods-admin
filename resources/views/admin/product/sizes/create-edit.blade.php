@extends('adminlte::page')

@section('title', $record ? __('Update Size') . ' | ' . $record->title : __('Create Size for ') . $productTitle)

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0">{{ $record ? __('Update Size') . ' | ' . $record->title : __('Create Size for ') . $productTitle }}</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="/">Գլխավոր</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.products.index') }}">{{ __('Products') }}</a></li>
                <li class="breadcrumb-item"><a
                        href="{{ route('admin.products.edit', ['product' => $product->id]) }}">{{ $product->title }}</a>
                </li>
                <li class="breadcrumb-item"><a
                        href="{{ route('admin.variants.edit', ['product' => $product->id,'variant' => $variant]) }}">{{ $productTitle }}</a>
                </li>
                <li class="breadcrumb-item active">{{ $record ? __('Update Size') : __('Create Size') }}</li>
            </ol>
        </div>
    </div>
@stop

@section('content')
    <form
        action="{{ $record ? route('admin.sizes.update',['variant' => $variant, 'size' => $record->id]) : route('admin.sizes.store',['variant' => $variant]) }}"
        method="post" enctype="multipart/form-data"
        data-success-url="{{ route('admin.variants.edit', ['product' => $product->id,'variant' => $variant]) }}"
    >
        <div class="row">
            <div class="col-md-8">
                <div class="card card-danger card-outline">
                    <div class="card-body">
                        @csrf
                        @if($record)
                            @method('PUT')
                            <input name="id" type="hidden" value="{{ $record->id }}"/>
                        @endif

                        <div class="row">
                            <div class="col-md-4">
                                <x-adminlte-input name="sizeName" label="Size Name" value="{{ old('sizeName') ?? ($record ? $record->sizeName : '') }}"/>
                            </div>
                            <div class="col-md-3">
                                <x-adminlte-input type="number" name="quantity" label="Quantity" value="{{ old('quantity') ?? ($record ? $record->quantity : '') }}"/>
                            </div>
                        </div>
                        <hr>
                        @include('admin.includes.prices')
                        <div class="text-right">
                            <x-adminlte-button class="btn-sm ajaxSave" type="button" label="Պահպանել" theme="outline-danger" icon="fas fa-lg fa-save"/>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
@stop

