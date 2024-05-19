@extends('adminlte::page')

@section('title', $record ? 'Խմբագրել ' . ucfirst($typeSingleText) .'ը' : 'Ավելացնել նոր '. ucfirst($typeSingleText))

@section('content_header')
    <ol class="breadcrumb mb-3">
        <li class="breadcrumb-item"><a href="/">Գլխավոր</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.contents.index', ['type' => $type]) }}">{{ $typeText }}</a></li>
        <li class="breadcrumb-item active">{{ $record ? 'Խմբագրել' : 'Ավելացնել' }}</li>
    </ol>
    <h1 class="mb-2">{{ $record ? 'Խմբագրել ' . ucfirst($typeSingleText) .'ը' : 'Ավելացնել նոր ' . ucfirst($typeSingleText) }}</h1>
@stop

@section('content')
    @php $statuses = \App\Enums\StatusTypes::statusList() @endphp
    <form action="{{ $record ? route('admin.contents.update',['type' => $type, 'content'=>$record->id]) : route('admin.contents.store', ['type' => $type]) }}" method="post" enctype="multipart/form-data">
        <div class="row">
            <div class="col-md-8">
                <div class="card card-danger card-outline">
                    <div class="card-body">
                        @csrf
                        @if($record)
                            @method('PUT')
                            <input name="id" type="hidden" value="{{ $record->id }}"/>
                            @if($type != \App\Enums\ContentTypes::page->name)
                                <img src="{{ $record->image_link }}" alt="image" style="max-height:150px;max-width: 100%;">
                            @endif
                        @endif
                        <input name="type" type="hidden" value="{{ $type }}"/>
                        <div class="row">
                            @if($type != \App\Enums\ContentTypes::page->name)
                                <div class="col-md-2">
                                    <x-adminlte-input name="image" label="Նկար" type="file"/>
                                </div>
                            @endif
                            <div class="col-md-{{ $type != \App\Enums\ContentTypes::page->name ? '7' : '9' }}">
                                <x-adminlte-input name="title" label="Վերնագիր" value="{{ old('title') ?? ($record ? $record->title : '') }}" data-required="true"/>
                                @if($errors->has('slug'))
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $errors->first('slug') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="col-md-3">
                                <x-adminlte-select name="status" label="Կարգավիճակ">
                                    <x-adminlte-options :options="$statuses" :selected="old('status') ?? ($record ? [$record->status] : [])"/>
                                </x-adminlte-select>
                            </div>
                        </div>
                        <x-adminlte-textarea name="description" id="editor" label="Բովանդակություն" data-required="true">{{ old('description') ?? ($record ? $record->description : '') }}</x-adminlte-textarea>
                        @if($type != \App\Enums\ContentTypes::page->name)
                            <div class="row">
                                <div class="col-md-3 ml-auto">
                                    <x-adminlte-input name="from" label="Հասանելի է սկսած" type="date" value="{{ old('from') ?? ($record ? $record->from : '') }}"/>
                                </div>
                                <div class="col-md-3">
                                    <x-adminlte-input name="to" label="Հասանելի է մինչև" type="date" value="{{ old('to') ?? ($record ? $record->to : '') }}"/>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card card-secondary card-outline">
                    <div class="card-body">
                        <x-adminlte-input name="url" label="URL" value="{{ old('url') ?? ($record ? $record->meta_url : '') }}" data-required="true"/>
                        <x-adminlte-input name="meta_title" label="Մետա վերնագիր" value="{{ old('meta_title') ?? ($record ? $record->meta_title : '') }}"/>
                        <x-adminlte-input name="meta_keywords" label="Մետա բանալի բառեր" value="{{ old('meta_keywords') ?? ($record ? $record->meta_keywords : '') }}"/>
                        <x-adminlte-textarea name="meta_description" label="Մետա նկարագրություն">{{ old('meta_description') ?? ($record ? $record->meta_description : '') }}</x-adminlte-textarea>
                        <div class="text-right">
                            <a href="{{ route('admin.contents.index', ['type' => $type]) }}" class="btn btn-outline-secondary btn-sm mr-3">Չեղարկել</a>
                            <x-adminlte-button class="btn-sm" type="submit" label="Պահպանել" theme="outline-danger" icon="fas fa-lg fa-save"/>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
@stop
