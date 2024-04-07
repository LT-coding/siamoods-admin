@extends('adminlte::page')

@section('title', $record ? 'Խմբագրել' : 'Ավելացնել նոր բաններ')

@section('content_header')
    <ol class="breadcrumb mb-3">
        <li class="breadcrumb-item"><a href="/">Գլխավոր</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.banners.index') }}">Բաններ</a></li>
        <li class="breadcrumb-item active">{{ $record ? 'Խմբագրել' : 'Ավելացնել նոր բաններ' }}</li>
    </ol>
    <h1 class="mb-2">{{ $record ? 'Խմբագրել' : 'Ավելացնել նոր բաններ' }}</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-md-9">
            <div class="card card-danger card-outline">
                <div class="card-body">
                    <form action="{{ $record ? route('admin.banners.update',['banner'=>$record->id]) : route('admin.banners.store') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        @if($record)
                            @method('PUT')
                            <input name="id" type="hidden" value="{{ $record->id }}"/>
                            <img src="{{ $record->image_link }}" alt="image" style="max-height:150px;max-width: 100%;">
                        @endif
                        <div class="row">
                            <div class="col-md-8">
                                <x-adminlte-input name="name" label="Անուն" value="{{ old('name') ?? ($record ? $record->name : '') }}" data-required="true"/>
                            </div>
                            <div class="col-md-4">
                                <x-adminlte-select name="type" label="Տեսակ" data-required="true">
                                    <x-adminlte-options :options="$types" :selected="old('type') ?? ($record ? [$record->type] : [])"/>
                                </x-adminlte-select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <x-adminlte-input name="image" label="Բովանդակություն" type="file" data-required="true"/>
                            </div>
                            <div class="col-md-3">
                                <x-adminlte-select name="status" label="Կարգավիճակ" data-required="true">
                                    <x-adminlte-options :options="$statuses" :selected="old('status') ?? ($record ? [$record->status] : [])"/>
                                </x-adminlte-select>
                            </div>
                            <div class="col-md-6">
                                <x-adminlte-input name="url" label="URL" value="{{ old('url') ?? ($record ? $record->url : '') }}"/>
                            </div>
                        </div>
                        <x-adminlte-input-switch name="new_tab" label="Բացել նոր էջում" :checked="old('new_tab') ?? $record && $record->new_tab == 1"/>

                        <div class="text-right">
                            <x-adminlte-button class="btn-sm" type="submit" label="Պահպանել" theme="outline-danger" icon="fas fa-lg fa-save"/>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop

