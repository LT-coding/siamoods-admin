@extends('adminlte::page')

@section('title', $record ? 'Խմբագրել կատեգորիան' . ' | ' . $record->name : 'Ավելացնել կատեգորիա')

@section('content_header')
    <ol class="breadcrumb mb-3">
        <li class="breadcrumb-item"><a href="/">Գլխավոր</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.categories.index') }}">Կատեգորիաներ</a></li>
        <li class="breadcrumb-item active">{{ $record ? 'Խմբագրել կատեգորիան' : 'Ավելացնել կատեգորիա' }}</li>
    </ol>
    <h1 class="mb-2">{{ $record ? 'Խմբագրել կատեգորիան' .  ' | ' . $record->name : 'Ավելացնել կատեգորիա' }}</h1>
@stop

@section('content')
    <form action="{{ $record ? route('admin.categories.update',['category'=>$record->id]) : route('admin.categories.store') }}" method="post" enctype="multipart/form-data">
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
                            <div class="col-md-9">

                            </div>
                            <div class="col-md-3">
                                <x-adminlte-select name="status" label="Կարգավիճակ" data-required="true">
                                    <x-adminlte-options :options="\App\Enums\StatusTypes::statusList()" :selected="old('status') ? [old('status')] : ($record ? [$record->status] : [])"/>
                                </x-adminlte-select>
                            </div>
                        </div>
                        <x-adminlte-input name="meta_title" label="Մետա վերնագիր" value="{{ old('meta_title') ?? ($record ? $record->meta_title : '') }}"/>
                        <x-adminlte-input name="meta_keywords" label="Մետա բանալի բառեր" value="{{ old('meta_keywords') ?? ($record ? $record->meta_keywords : '') }}"/>
                        <x-adminlte-textarea name="meta_description" label="Մետա նկարագրություն">{{ old('meta_description') ?? ($record ? $record->meta_description : '') }}</x-adminlte-textarea>
                        <div class="text-right">
                            <a href="{{ route('admin.categories.index') }}" class="btn btn-outline-secondary btn-sm mr-3">Չեղարկել</a>
                            <x-adminlte-button class="btn-sm" type="submit" label="Պահպանել" theme="outline-danger" icon="fas fa-lg fa-save"/>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
@stop

