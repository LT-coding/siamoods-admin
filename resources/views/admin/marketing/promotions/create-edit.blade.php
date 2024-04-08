@extends('adminlte::page')

@section('title', $record ? 'Խմբագրել' : 'Ավելացնել նոր պրոմոկոդ')

@section('content_header')
    <ol class="breadcrumb mb-3">
        <li class="breadcrumb-item"><a href="/">Գլխավոր</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.promotions.index') }}">Պրոմոկոդեր</a></li>
        <li class="breadcrumb-item active">{{ $record ? 'Խմբագրել' : 'Ավելացնել նոր պրոմոկոդ' }}</li>
    </ol>
    <h1 class="mb-2">{{ $record ? 'Խմբագրել' : 'Ավելացնել նոր պրոմոկոդ' }}</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-md-9">
            <div class="card card-danger card-outline">
                <div class="card-body">
                    <form action="{{ $record ? route('admin.promotions.update',['promotion'=>$record->id]) : route('admin.promotions.store') }}" method="post">
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
                                <x-adminlte-input name="promo_code" label="Պրոմոկոդ" value="{{ old('promo_code') ?? ($record ? $record->promo_code : '') }}" data-required="true" data-readonly="{{ $record && $record->promo_code == 'ABCARD5' ? 'true' : '' }}"/>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <x-adminlte-select name="status" label="Կարգավիճակ" data-required="true">
                                    <x-adminlte-options :options="$statuses" :selected="old('status') ?? ($record ? [$record->status] : [])"/>
                                </x-adminlte-select>
                            </div>
                            <div class="col-sm-4">
                                <x-adminlte-select class="form-select pro-type-select" name="type" label="Տեսակ" data-required="true">
                                    <x-adminlte-options :options="\App\Enums\PromotionType::promotions()" :selected="old('type') ?? ($record ? [$record->type] : [])"/>
                                </x-adminlte-select>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group" style="margin-top: 30px;">
                                    <div class="input-group pro-type pro-type-1" style="display: {{ $record && $record->type == 1 ? 'flex' : 'none' }}">
                                        <span class="input-group-text">%</span>
                                        <input type="number" min="0" max="100" class="form-control" name="value" value="{{ $record && $record->type == 1 ? $record->value : '' }}">
                                    </div>
                                    <div class="input-group pro-type pro-type-2" style="display: {{ $record && $record->type == 2 ? 'flex' : 'none' }}">
                                        <span class="input-group-text">֏</span>
                                        <input type="number" step="0.01" class="form-control" name="value" value="{{ $record && $record->type == 2 ? $record->value : '' }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <x-adminlte-textarea name="description" label="Նկարագրություն">{{ old('description') ?? ($record ? $record->description : '') }}</x-adminlte-textarea>
                        <div class="row">
                            <div class="col-md-3">
                                <x-adminlte-input name="from" label="Հասանելի է սկսած" type="date" value="{{ old('from') ?? ($record ? $record->from : '') }}"/>
                            </div>
                            <div class="col-md-3">
                                <x-adminlte-input name="to" label="Հասանելի է մինչև" type="date" value="{{ old('to') ?? ($record ? $record->to : '') }}"/>
                            </div>
                        </div>
                        <div class="text-right">
                            <x-adminlte-button class="btn-sm" type="submit" label="Պահպանել" theme="outline-danger" icon="fas fa-lg fa-save"/>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop

