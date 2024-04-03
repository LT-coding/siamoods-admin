@extends('adminlte::page')

@section('title', $typeText )

@section('content_header')
    <ol class="breadcrumb mb-3">
        <li class="breadcrumb-item"><a href="/">Գլխավոր</a></li>
        <li class="breadcrumb-item active">{{ $typeText }}</li>
    </ol>
    <h1 class="mb-2">{{ $typeText }} <a href="{{ route('admin.contents.create', ['type' => $type]) }}" class="btn btn-outline-danger btn-sm float-sm-right" title="Ավելացնել">Ավելացնել</a></h1>
@stop

@section('content')
    @php
        $heads = $type == \App\Enums\ContentTypes::page->name ? [
            ['label' => 'Title', 'width' => 25],
            ['label' => 'URL', 'width' => 40],
            ['label' => 'Created At', 'width' => 15],
            ['label' => 'Status', 'width' => 10],
            ['label' => '', 'no-export' => true, 'width' => 8],
        ] : [
            ['label' => 'Title', 'width' => 25],
            ['label' => 'Image', 'width' => 10],
            ['label' => 'URL', 'width' => 40],
            ['label' => 'Created At', 'width' => 10],
            ['label' => 'Status', 'width' => 8],
            ['label' => '', 'no-export' => true, 'width' => 8],
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
            $btnDetails = '<a href="'.route('admin.contents.edit',['type' => $type,'content'=>$item->id]).'" class="text-info mx-1" title="Խմբագրել"><i class="fa fa-lg fa-fw fa-pen"></i></a>';
            $btnDelete = '<a href="#" data-action="'.route('admin.contents.destroy',['type' => $type,'content'=>$item->id]).'" class="text-danger btn-remove" title="Հեռացնել"><i class="fa fa-lg fa-fw fa-trash"></i></a>';
            $row = $type == \App\Enums\ContentTypes::page->name
                ? [$item->title, $item->url, $createdAt, $statusText, $btnView.$btnDetails.$btnDelete]
                : [$item->title, $img, $item->url, $createdAt, $statusText, $btnView.$btnDetails.$btnDelete];
            $config['data'] [] = $row;
        }
    @endphp

    <x-adminlte-datatable id="data-table" :heads="$heads" :config="$config"/>
@stop
