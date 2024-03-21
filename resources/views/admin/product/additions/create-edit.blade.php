@extends('adminlte::page')

@section('title', $record ? __('Update ') . ucfirst($style) : __('Create ') . ucfirst($style))

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0">{{ $record ? __('Update ') . ucfirst($style) : __('Create ') . ucfirst($style) }}</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="/">{{ __('Dashboard') }}</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.additions.index', ['style' => $style]) }}">{{ $styleText }}</a></li>
                <li class="breadcrumb-item active">{{ $record ? __('Update ') . ucfirst($style) : __('Create ') . ucfirst($style) }}</li>
            </ol>
        </div>
    </div>
@stop

@section('content')
    <div class="row">
        <div class="col-md-6">
            <div class="card card-primary card-outline">
                <div class="card-body">
                    <form action="{{ $record ? route('admin.additions.update', ['style' => $style, 'addition'=>$record->id]) : route('admin.additions.store', ['style' => $style]) }}"
                          method="post" enctype="multipart/form-data"
                          class="{{ $style == \App\Enums\AdditionStyles::template->name ? ' saveCanvas' : '' }}"
                          data-success-url="{{ route('admin.additions.index', ['style' => $style]) }}"
                    >
                        @csrf
                        @if($record)
                            @method('PUT')
                            <input name="id" type="hidden" value="{{ $record->id }}"/>
                        @endif
                        <input name="style" type="hidden" value="{{ $style }}"/>
                        <div class="row">
                            <div class="col-md-12">
                                <x-adminlte-input name="title" label="{{ ucfirst($style) . ' Type Title' }}" value="{{ old('title') ?? ($record ? $record->title : '') }}"/>
                            </div>
                            <div class="col-md-12">
                                @include('admin.product.includes.'.$style)
                            </div>
                            <div class="col-md-12">
                                <div class="text-right">
                                    <x-adminlte-button class="btn-sm ajaxSave" type="button" label="Save" theme="outline-danger" icon="fas fa-lg fa-save"/>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            @if($record)
                @if($record->images()->count() > 0)
                    <div class="card card-info card-outline">
                        <div class="card-body">
                            <h4>{{ $styleText }}</h4>
                            <div class="row">
                                @foreach($record->images()->get() as $image)
                                    <div class="col-md-3">
                                        <img src="{{ $image->image_link }}" alt="{{ $record->title }}">
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif
            @endif
        </div>
    </div>
@stop
