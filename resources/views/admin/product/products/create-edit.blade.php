@extends('adminlte::page')

@section('title', $record ? __('Update Product') . ' | ' . $record->title : __('Create Product') )

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="mb-2">{{ $record ? __('Update Product') .  ' | ' . $record->title : __('Create Product') }}</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="/">Գլխավոր</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.products.index') }}">{{ __('Products') }}</a></li>
                <li class="breadcrumb-item active">{{ $record ? __('Update Product') : __('Create Product') }}</li>
            </ol>
        </div>
    </div>
@stop

@section('content')
    @php $categories = \App\Models\Category::query()->pluck('title','code')->toArray(); $currencies = \App\Enums\Currencies::list() @endphp
    <form action="{{ $record ? route('admin.products.update',['product'=>$record->id]) : route('admin.products.store') }}" method="post">
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
                            <div class="col-md-3">
                                <x-adminlte-select name="category_code" label="Category">
                                    <x-adminlte-options :options="$categories" :selected="old('category_code') ?? ($record ? [$record->category_code] : [])" empty-option="Select a Category"/>
                                </x-adminlte-select>
                            </div>
                            <div class="col-md-4">
                                <x-adminlte-input name="name" label="Name" value="{{ old('name') ?? ($record ? $record->name : '') }}"/>
                                @if($errors->has('slug'))
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $errors->first('slug') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="col-md-5">
                                <x-adminlte-input name="subtitle" label="Subtitle" value="{{ old('subtitle') ?? ($record ? $record->subtitle : '') }}"/>
                            </div>
                            <div class="col-md-12">
                                <x-adminlte-input name="specification" label="Specification" value="{{ old('specification') ?? ($record ? $record->specification : '') }}"/>
                            </div>
                            <div class="col-md-12">
                                <x-adminlte-textarea name="description" label="Description">{{ old('description') ?? ($record ? $record->description : '') }}</x-adminlte-textarea>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-md-2">
                                <x-adminlte-select name="currency" label="Currency">
                                    <x-adminlte-options :options="$currencies" :selected="old('currency') ?? ($record ? [$record->currency] : [])" empty-option="Select"/>
                                </x-adminlte-select>
                            </div>
                            <div class="col-md-2">
                                <x-adminlte-input type="number" name="discount" label="Discount (%)" value="{{ old('discount') ?? ($record ? $record->discount : '') }}" step="0.1"/>
                            </div>
                            <div class="col-md-4">
                                <x-adminlte-input type="date" name="discount_start_date" label="Discount Start" value="{{ old('discount_start_date') ?? ($record ? $record->discount_start_date : '') }}"/>
                            </div>
                            <div class="col-md-4">
                                <x-adminlte-input type="date" name="discount_end_date" label="Discount End" value="{{ old('discount_end_date') ?? ($record ? $record->discount_end_date : '') }}"/>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card card-secondary card-outline">
                    <div class="card-body">
                        <div class="text-right">
                            <x-adminlte-input-switch name="show_in_hot_sales" label="{{ __('Show in Hot Sales') }}" :checked="old('show_in_hot_sales') ?? $record && $record->show_in_hot_sales == 1"/>
                        </div>
                        <x-adminlte-input name="meta_title" label="Մետա վերնագիր" value="{{ old('meta_title') ?? ($record ? $record->meta_title : '') }}"/>
                        <x-adminlte-input name="meta_keywords" label="Մետա բանալի բառեր" value="{{ old('meta_keywords') ?? ($record ? $record->meta_keywords : '') }}"/>
                        <x-adminlte-textarea name="meta_description" label="Մետա նկարագրություն">{{ old('meta_description') ?? ($record ? $record->meta_description : '') }}</x-adminlte-textarea>
                        <div class="text-right">
                            <x-adminlte-button class="btn-sm" type="submit" label="Պահպանել" theme="outline-danger" icon="fas fa-lg fa-save"/>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                @if($record)
                    <div class="card card-success card-outline">
                        <div class="card-body">
                            <h5>Related Products <a href="{{ route('admin.related-products.create', ['product' => $record->id]) }}" class="btn btn-outline-danger btn-sm float-sm-right" title="Ավելացնել">Ավելացնել</a></h5>
                            @include('admin.product.includes.related-products',['relatedProducts' => $record->relatedProducts ?? null])
                        </div>
                    </div>
                @endif
            </div>
            <div class="col-md-6">
                @if($record)
                    <div class="card card-success card-outline">
                        <div class="card-body">
                            <h5>Product Variants <a href="{{ route('admin.variants.create', ['product' => $record->id]) }}" class="btn btn-outline-danger btn-sm float-sm-right" title="Ավելացնել">Ավելացնել</a></h5>
                            @include('admin.product.includes.variants',['variants' => $record->variants ?? null])
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </form>
@stop

