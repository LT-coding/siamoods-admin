@extends('adminlte::page')

@section('title', $record ? 'Խմբագրել' : 'Ավելացնել նոր պիտակ')

@section('content_header')
    <ol class="breadcrumb mb-3">
        <li class="breadcrumb-item"><a href="/">Գլխավոր</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.labels.index') }}">Պիտակներ</a></li>
        <li class="breadcrumb-item active">{{ $record ? 'Խմբագրել' : 'Ավելացնել նոր պիտակ' }}</li>
    </ol>
    <h1 class="mb-2">{{ $record ? 'Խմբագրել' : 'Ավելացնել նոր պիտակ' }}</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-md-9">
            <div class="card card-danger card-outline">
                <div class="card-body">
                    <form action="{{ $record ? route('admin.labels.update',['label'=>$record->id]) : route('admin.labels.store') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        @if($record)
                            @method('PUT')
                            <input name="id" type="hidden" value="{{ $record->id }}"/>
                        @endif
                        <div class="row">
                            <div class="col-md-7">
                                <x-adminlte-input name="name" label="Անուն" value="{{ old('name') ?? ($record ? $record->name : '') }}" data-required="true"/>
                            </div>
                            <div class="col-md-5">
                                <x-adminlte-select name="status" label="Կարգավիճակ" data-required="true">
                                    <x-adminlte-options :options="$statuses" :selected="old('status') ?? ($record ? [$record->status] : [])"/>
                                </x-adminlte-select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-4">
                                <x-adminlte-select class="form-select label-type-select" name="position" label="Դիրք" data-required="true">
                                    <x-adminlte-options :options="\App\Enums\PositionType::positions()" :selected="old('position') ?? ($record ? [$record->position] : [])"/>
                                </x-adminlte-select>
                            </div>
                            <div class="col-md-4">
                                <x-adminlte-select class="form-select label-type" name="type" label="Տեսակ" data-required="true">
                                    <x-adminlte-options :options="\App\Enums\LabelType::types()" :selected="old('type') ?? ($record ? [$record->type] : [])"/>
                                </x-adminlte-select>
                            </div>
                            <div class="col-sm-12">
                                <div class="graph-label" style="display: {{ $record && $record->type != 0 ? 'none' : 'block' }}">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <x-adminlte-input type="file" id="label-image" name="media" label="Պիտակ" data-required="true"/>
                                        </div>
                                    </div>
                                </div>
                                <div style="display: {{ $record && $record->type == 0 ? 'none' : 'block' }}" class="text-label">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <x-adminlte-input class="form-control label-input" name="media_text[text]" label="Պիտակ" value="{{ old('media_text[text]') ?? ($record && $record->media_json ? $record->media_json->text : '') }}" data-required="true"/>
                                        </div>
                                        <div class="col-md-4">
                                            <x-adminlte-input type="color" class="form-control txt-color" name="media_text[color]" label="Տեքստի գույն" value="{{ old('media_text[color]') ?? ($record && $record->media_json ? $record->media_json->color : '#ffffff') }}" data-required="true"/>
                                        </div>
                                        <div class="col-md-4">
                                            <x-adminlte-input type="color" class="form-control bg-color" name="media_text[background_color]" label="Պիտակի գույն" value="{{ old('media_text[background_color]') ?? ($record && $record->media_json ? $record->media_json->background_color : '#0b2e7a') }}" data-required="true"/>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <x-adminlte-textarea name="description" label="Նկարագրություն">{{ old('description') ?? ($record ? $record->description : '') }}</x-adminlte-textarea>
                        <div class="text-right">
                            <a href="{{ route('admin.labels.index') }}" class="btn btn-outline-secondary btn-sm mr-3">Չեղարկել</a>
                            <x-adminlte-button class="btn-sm" type="submit" label="Պահպանել" theme="outline-danger" icon="fas fa-lg fa-save"/>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card card-secondary card-outline">
                <div class="card-body">
                    @if($record)
                        <div class="col-lg-3 d-flex">
                            <div class="card label-display">
                                <div class="pr-label label-position-{{ $record->position }}">
                                    <div class="preview-label" style="display: {{ $record->type !=0 ? 'none' : 'block' }}">
                                        <img src="{{ $record->type == 0 && !$record->media_json ? $record->media : '#'}}" class="img_preview-label" alt="label">
                                    </div>
                                    <div class="preview-text" style="display:{{ $record->type == 0 ? 'none' :'block' }}">
                                        <p class="lb-text" style="color: {{ $record->media_json ? $record->media_json->color:''}}; background-color: {{ $record->media_json ? $record->media_json->background_color : '' }}">{{ $record->media_json ? $record->media_json->text : '' }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="col-lg-3 d-flex">
                            <div class="card label-display">
                                <div class="pr-label label-position-0">
                                    <div class="preview-label" style="display: none">
                                        <img src="#" class="img_preview-label" alt="label">
                                    </div>
                                    <div class="preview-text" style="display: none">
                                        <p class="lb-text"></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@stop

