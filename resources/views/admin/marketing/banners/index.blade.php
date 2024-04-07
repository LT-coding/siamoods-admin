@extends('adminlte::page')

@section('title', 'Բաններ')

@section('content_header')
    <ol class="breadcrumb mb-3">
        <li class="breadcrumb-item"><a href="/">Գլխավոր</a></li>
        <li class="breadcrumb-item active">Բաններ</li>
    </ol>
    <h1 class="mb-2">Բաններ <a href="{{ route('admin.banners.create') }}"
                               class="btn btn-outline-danger btn-sm ml-3 float-sm-right" title="Ավելացնել">Ավելացնել</a>
    </h1>
@stop

@section('content')
    @php
        $heads = [
            ['label' => '#', 'width' => 6],
            'Անուն',
            'Տեսակ',
            ['label' => 'Կարգավիճակ', 'width' => 15],
            ['label' => 'Ստեղծման ամսաթիվ', 'width' => 15],
            ['label' => '', 'no-export' => true, 'width' => 8],
        ];

        $headTheme = "test";

        $config = [
            'data' => [],
            'order' => [[0, 'asc']],
            'columns' => [null, null, null, null, null, ['orderable' => false]],
        ];

        foreach ($records as $item) {
            $type = $item->type ? \App\Enums\BannerTypes::text : \App\Enums\BannerTypes::graph;
            $created = \Carbon\Carbon::createFromDate($item->created_at)->format('d.m.Y');
            $btnDetails = '<a href="'.route('admin.banners.edit',['banner'=>$item->id]).'" class="text-info mx-1" title="Խմբագրել"><i class="fa fa-lg fa-fw fa-pen"></i></a>';
            $btnDelete = '<a href="#" data-action="'.route('admin.banners.destroy',['banner'=>$item->id]).'" class="text-danger btn-remove" title="Հեռացնել"><i class="fa fa-lg fa-fw fa-trash"></i></a>';
            $row = [$item->id, $item->name, $type, $item->status_text, $created, $btnDetails.$btnDelete];
            $config['data'] [] = $row;
        }
    @endphp

    <x-adminlte-datatable id="data-table" :heads="$heads" :config="$config"/>
@stop
