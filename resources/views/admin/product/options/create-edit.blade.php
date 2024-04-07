@extends('adminlte::page')

@section('title', $record ? __('Update Option') . ' | ' . $record->title : __('Create Option'))

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="mb-2">{{ $record ? __('Update Option') .  ' | ' . $record->title : __('Create Option') }}</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="/">Գլխավոր</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.options.index') }}">{{ __('Options') }}</a></li>
                <li class="breadcrumb-item active">{{ $record ? __('Update Option') : __('Create Option') }}</li>
            </ol>
        </div>
    </div>
@stop

@section('content')
    <form action="{{ $record ? route('admin.options.update',['option'=>$record->id]) : route('admin.options.store') }}" method="post">
        <div class="row">
            <div class="col-md-8">
                <div class="card card-danger card-outline">
                    <div class="card-body">
                        @csrf
                        @if($record)
                            @method('PUT')
                            <input name="id" type="hidden" value="{{ $record->id }}"/>
                        @endif
                        <div class="text-right">
                            <x-adminlte-input-switch name="show_in_filter" label="{{ __('Show in Filter') }}" :checked="old('show_in_filter') ?? $record && $record->show_in_filter == 1"/>
                        </div>
                        <x-adminlte-input name="title" label="Title" value="{{ old('title') ?? ($record ? $record->title : '') }}"/>
                        @if($errors->has('code'))
                            <span class="invalid-feedback d-block" role="alert">
                                <strong>{{ $errors->first('code') }}</strong>
                            </span>
                        @endif
                        <div class="text-right">
                            <x-adminlte-button class="btn-sm" type="submit" label="Պահպանել" theme="outline-danger" icon="fas fa-lg fa-save"/>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
@stop

