@extends('adminlte::page')

@section('title', $record ? __('Update ') . ucfirst($type) : __('Create ') . ucfirst($type))

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0">{{ $record ? __('Update ') . ucfirst($type) : __('Create ') . ucfirst($type) }}</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="/">Գլխավոր</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.contents.index', ['type' => $type]) }}">{{ $typeText }}</a></li>
                <li class="breadcrumb-item active">{{ $record ? __('Update') : __('Create') }}</li>
            </ol>
        </div>
    </div>
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
                                <div class="col-md-3">
                                    <x-adminlte-input name="image" label="{{ __('Image') }}" type="file"/>
                                </div>
                            @endif
                            <div class="col-md-{{ $type != \App\Enums\ContentTypes::page->name ? '7' : '10' }}">
                                <x-adminlte-input name="title" label="Title" value="{{ old('title') ?? ($record ? $record->title : '') }}"/>
                                @if($errors->has('slug'))
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $errors->first('slug') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="col-md-2">
                                <x-adminlte-select name="status" label="Status">
                                    <x-adminlte-options :options="$statuses" :selected="old('status') ?? ($record ? [$record->status] : [])"/>
                                </x-adminlte-select>
                            </div>
                        </div>
                        <x-adminlte-textarea name="description" id="editor" label="{{ __('Description') }}">{{ old('description') ?? ($record ? $record->description : '') }}</x-adminlte-textarea>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card card-olive card-outline">
                    <div class="card-body">
                        <x-adminlte-input name="meta_title" label="Meta Title" value="{{ old('meta_title') ?? ($record ? $record->meta_title : '') }}"/>
                        <x-adminlte-input name="meta_keywords" label="Meta Keywords" value="{{ old('meta_keywords') ?? ($record ? $record->meta_keywords : '') }}"/>
                        <x-adminlte-textarea name="meta_description" label="{{ __('Meta Description') }}">{{ old('meta_description') ?? ($record ? $record->meta_description : '') }}</x-adminlte-textarea>
                        <div class="text-right">
                            <x-adminlte-button class="btn-sm" type="submit" label="Պահպանել" theme="outline-danger" icon="fas fa-lg fa-save"/>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
@stop
