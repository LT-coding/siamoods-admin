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
    <div class="row">
        <div class="col-md-7">
            <div class="card card-danger card-outline">
                <div class="card-body">
                    <form action="{{ $record ? route('admin.shipping-types.update',['shipping_type'=>$record->id]) : route('admin.shipping-types.store') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        @if($record)
                            @method('PUT')
                            <input name="id" type="hidden" value="{{ $record->id }}"/>
                            <img src="{{ $record->image_link }}" alt="image" style="max-height:150px;max-width: 100%;">
                        @endif
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
                        <div class="text-right">
                            <x-adminlte-input-switch name="cash" label="Օգտագործել վճարման կանխիկ տարբերակը" :checked="old('cash') ?? $record && $record->cash == 1"/>
                        </div>
                        <x-adminlte-textarea name="description" id="editor" label="Նկարագրություն" data-required="true">{{ old('description') ?? ($record ? $record->description : '') }}</x-adminlte-textarea>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-5">
            <div class="card card-secondary card-outline">
                <div class="card-body">
                    <div class="row mt-4">
                        <div class="p-0 col-sm-3 nav flex-column nav-pills ship-buttons" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                            @foreach($areas as $k => $area)
                                <button class="nav-link {{ $k==0 ? 'active' : '' }}" id="v-pills-{{$k}}-tab" data-bs-toggle="pill" data-bs-target="#v-pills-{{$k}}" type="button" role="tab" aria-controls="v-pills-{{$k}}" aria-selected="{{ $k==0 }}">{{ $area }}</button>
                            @endforeach
                        </div>
                        <div class="col-sm-9 tab-content" id="v-pills-tabContent">
                            @foreach($areas as $k => $area)
                                <div class="tab-pane fade {{ $k==0 ? 'show active' : '' }} shipping-item" data-id="{{$k}}" id="v-pills-{{$k}}" role="tabpanel" aria-labelledby="v-pills-{{$k}}-tab">
                                    <x-adminlte-input name="area[{{$k}}][time]" label="Առաքման ժամանակ" value="{{ old('name') ?? $record?->areas[$k]?->time }}"/>

{{--                                    <div class="row">--}}
{{--                                        <label class="col-sm-3 form-label align-self-center mb-lg-0 text-end">Անվճար առաքում--}}
{{--                                        </label>--}}
{{--                                        <div class="col-sm-4">--}}
{{--                                            <input class="form-check-input free_shipping" type="checkbox" data-url="{{route('admin.shipping.free','')}}" {{count($record->areas[$k]->rates)==0?'checked':''}}>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                    <div class="shipping-rate">--}}
{{--                                        @if(count($record->areas[$k]->rates)>0)--}}
{{--                                            @include('admin.shipping_methods.shipping_area',['k'=>$k,'shipping_methods'=>$record])--}}
{{--                                        @endif--}}
{{--                                    </div>--}}
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
@stop

