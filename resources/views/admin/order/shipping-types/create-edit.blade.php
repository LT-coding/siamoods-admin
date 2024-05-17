@extends('adminlte::page')

@section('title', $record ? 'Խմբագրել առաքման մեթոդը' : 'Ավելացնել նոր առաքման մեթոդ')

@section('content_header')
    <ol class="breadcrumb mb-3">
        <li class="breadcrumb-item"><a href="/">Գլխավոր</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.shipping-types.index') }}">Առաքման մեթոդներ</a></li>
        <li class="breadcrumb-item active">{{ $record ? 'Խմբագրել առաքման մեթոդը' : 'Ավելացնել նոր առաքման մեթոդ' }}</li>
    </ol>
    <h1 class="mb-2">{{ $record ? 'Խմբագրել առաքման մեթոդը' : 'Ավելացնել նոր բաններ' }}</h1>
@stop

@section('content')
    <form action="{{ $record ? route('admin.shipping-types.update',['shipping_type'=>$record->id]) : route('admin.shipping-types.store') }}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-md-7">
                <div class="card card-danger card-outline">
                    <div class="card-body">
                        @if($record)
                            @method('PUT')
                            <input name="id" type="hidden" value="{{ $record->id }}"/>
                            <img src="{{ $record->image_link }}" alt="image" style="max-height:150px;max-width: 100%;">
                        @endif
                        <div class="text-right mb-2">
                            <x-adminlte-input-switch name="cash" label="Օգտագործել վճարման կանխիկ տարբերակը" :checked="old('cash') ?? $record && $record->cash == 1"/>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <x-adminlte-input name="name" label="Անուն" value="{{ old('name') ?? ($record ? $record->name : '') }}" data-required="true"/>
                            </div>
                            <div class="col-md-3">
                                <x-adminlte-input name="image" label="Նկար" type="file" data-required="true"/>
                            </div>
                            <div class="col-md-3">
                                <x-adminlte-select name="status" label="Կարգավիճակ" data-required="true">
                                    <x-adminlte-options :options="$statuses" :selected="old('status') ?? ($record ? [$record->status] : [])"/>
                                </x-adminlte-select>
                            </div>
                        </div>
                        <x-adminlte-textarea name="description" id="editor" label="Նկարագրություն" data-required="true">{{ old('description') ?? ($record ? $record->description : '') }}</x-adminlte-textarea>
                    </div>
                </div>
            </div>
            <div class="col-md-5">
                <div class="card card-secondary card-outline">
                    <div class="card-body">
                        <div class="mt-4">
                            <ul class="nav nav-tabs customization-tabs" id="tab" role="tablist">
                                @foreach($areas as $k => $area)
                                    <li class="nav-item">
                                        <a class="nav-link{{ $k == 0 ? ' active' : '' }}" id="{{$k}}-tab" data-toggle="pill" href="#tab-{{$k}}" role="tab">{{ $area }}</a>
                                    </li>
                                @endforeach
                            </ul>
                            <div class="tab-content py-3" id="tabContent">
                                @foreach($areas as $k => $area)
                                    <div class="tab-pane fade{{ $k == 0 ? ' active show' : '' }} shipping-item" id="tab-{{$k}}" role="tabpanel" data-id="{{$k}}">
                                        <x-adminlte-input name="area[{{$k}}][time]" label="Առաքման ժամանակ" value="{{ old('area['.$k.'][time]') ?? $record?->areas[$k]?->time }}"/>
                                        <x-adminlte-input-switch name="rates" class="free-shipping" id="rates-{{ $k }}" label="Անվճար առաքում" :checked="old('rates') ?? !$record || count($record->areas[$k]?->rates) == 0" data-url="{{ route('admin.shipping.free','') }}"/>
                                        <div class="shipping-rate">
                                            @if($record && count($record->areas[$k]?->rates) > 0)
                                                @include('admin.includes.shipping-price',['k' => $k])
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="text-right">
                            <a href="{{ route('admin.shipping-types.index') }}" class="btn btn-outline-secondary btn-sm mr-3">Չեղարկել</a>
                            <x-adminlte-button class="btn-sm" type="submit" label="Պահպանել" theme="outline-danger" icon="fas fa-lg fa-save"/>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
@stop

