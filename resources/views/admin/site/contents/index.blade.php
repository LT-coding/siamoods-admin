@extends('adminlte::page')

@section('title', $typeText )

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0">{{ $typeText }} <a href="{{ route('admin.contents.create', ['type' => $type]) }}" class="btn btn-primary btn-sm" title="Add"><i class="fa fa-lg fa-fw fa-plus"></i></a></h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="/">{{ __('Dashboard') }}</a></li>
                <li class="breadcrumb-item active">{{ $typeText }}</li>
            </ol>
        </div>
    </div>
@stop

@section('content')
    @php
        $heads = $type == \App\Enums\ContentTypes::page->name ? [
            ['label' => 'Title', 'width' => 25],
            ['label' => 'URL', 'width' => 40],
            ['label' => 'Created At', 'width' => 15],
            ['label' => 'Status', 'width' => 10],
            ['label' => 'Actions', 'no-export' => true, 'width' => 8],
        ] : [
            ['label' => 'Title', 'width' => 25],
            ['label' => 'Image', 'width' => 10],
            ['label' => 'URL', 'width' => 40],
            ['label' => 'Created At', 'width' => 15],
            ['label' => 'Status', 'width' => 10],
            ['label' => 'Actions', 'no-export' => true, 'width' => 8],
        ];

        $config = [
            'data' => [],
            'order' => $type == \App\Enums\ContentTypes::page->name ? [[2, 'desc']] : [[3, 'desc']],
            'columns' => $type == \App\Enums\ContentTypes::page->name ? [null, null, null, null, ['orderable' => true]] : [null, null, null, null, null, ['orderable' => true]],
        ];

        foreach ($records as $item) {
            $img = '<img src="'.$item->image_link.'" alt="image" style="max-height:100px;">';
            $statusText = \App\Enums\StatusTypes::statusText($item->status);
            $createdAt = \Carbon\Carbon::parse($item->created_at)->format('m/d/Y H:s');
            $btnView = '<a href="'.$item->url.'" class="text-info mx-1" title="View" target="_blank"><i class="fa fa-lg fa-fw fa-eye"></i></a>';
            $btnDetails = '<a href="'.route('admin.contents.edit',['type' => $type,'content'=>$item->id]).'" class="text-olive mx-1" title="Edit"><i class="fa fa-lg fa-fw fa-pen"></i></a>';
            $btnDelete = '<a href="#" data-action="'.route('admin.contents.destroy',['type' => $type,'content'=>$item->id]).'" class="text-danger btn-remove" title="Delete"><i class="fa fa-lg fa-fw fa-trash"></i></a>';
            $row = $type == \App\Enums\ContentTypes::page->name
                ? [$item->title, $item->url, $createdAt, $statusText, $btnView.$btnDetails.$btnDelete]
                : [$item->title, $img, $item->url, $createdAt, $statusText, $btnView.$btnDetails.$btnDelete];
            $config['data'] [] = $row;
        }
    @endphp

    <x-adminlte-datatable id="data-table" :heads="$heads" :config="$config"/>
@stop
