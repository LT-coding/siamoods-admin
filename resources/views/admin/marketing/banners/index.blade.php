@extends('adminlte::page')

@section('title', 'Բաններ')

@section('content_header')
    <ol class="breadcrumb mb-3">
        <li class="breadcrumb-item"><a href="/">Գլխավոր</a></li>
        <li class="breadcrumb-item active">Բաններ</li>
    </ol>
    <h1 class="mb-2">Բաններ <a href="{{ route('admin.banners.create') }}" class="btn btn-outline-danger btn-sm ml-3 float-sm-right" title="Ավելացնել">Ավելացնել</a></h1>
@stop

@section('content')
    @php
        $heads = [
            ['label' => '#', 'width' => 6],
            'Անուն',
            'Նկար',
            ['label' => 'Կարգավիճակ', 'width' => 15],
            ['label' => 'Ստեղծման ամսաթիվ', 'width' => 20],
            ['label' => '', 'no-export' => true, 'width' => 7],
        ];

        $config = [
            'processing' => true,
            'serverSide' => true,
            'ajax' => [
                'url' => route('admin.banners.get')
            ],
            'columns' => [null, null, null, null, null, ['orderable' => false]],
        ];
    @endphp

    <x-adminlte-datatable id="data-table" :heads="$heads" :config="$config"/>
@stop
