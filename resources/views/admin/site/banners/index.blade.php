@extends('adminlte::page')

@section('title', __('Banners') )

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0">{{ __('Banners') }} <a href="{{ route('admin.banners.create') }}" class="btn btn-primary btn-sm" title="Add"><i class="fa fa-lg fa-fw fa-plus"></i></a></h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="/">{{ __('Dashboard') }}</a></li>
                <li class="breadcrumb-item active">{{ __('Banners') }}</li>
            </ol>
        </div>
    </div>
@stop

@section('content')
    @php
        $heads = [
            ['label' => 'Image', 'width' => 10],
            'Title',
            ['label' => 'Subtitle', 'width' => 40],
            ['label' => 'Status', 'width' => 10],
            ['label' => 'Location', 'width' => 10],
            ['label' => 'Actions', 'no-export' => true, 'width' => 8],
        ];

        $config = [
            'data' => [],
            'order' => [[0, 'asc']],
            'columns' => [null, null, null, null, null, ['orderable' => true]],
        ];

        foreach ($records as $item) {
            $img = '<img src="'.$item->image_link.'" alt="image" style="max-height:100px;">';
            $statusText = \App\Enums\StatusTypes::statusText($item->status);
            $btnDetails = '<a href="'.route('admin.banners.edit',['banner'=>$item->id]).'" class="text-olive mx-1" title="Edit"><i class="fa fa-lg fa-fw fa-pen"></i></a>';
            $btnDelete = '<a href="#" data-action="'.route('admin.banners.destroy',['banner'=>$item->id]).'" class="text-danger mx-1 btn-remove" title="Delete"><i class="fa fa-lg fa-fw fa-trash"></i></a>';
            $row = [$img, $item->title, $item->subtitle, $statusText, \App\Enums\BannerTypes::getConstants()[$item->type],$btnDetails.$btnDelete];
            $config['data'] [] = $row;
        }
    @endphp

    <x-adminlte-datatable id="data-table" :heads="$heads" :config="$config"/>
@stop
