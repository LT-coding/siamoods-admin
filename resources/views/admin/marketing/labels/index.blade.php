@extends('adminlte::page')

@section('title', 'Պիտակներ')

@section('content_header')
    <ol class="breadcrumb mb-3">
        <li class="breadcrumb-item"><a href="/">Գլխավոր</a></li>
        <li class="breadcrumb-item active">Պիտակներ</li>
    </ol>
    <h1 class="mb-2">Պիտակներ <a href="{{ route('admin.labels.create') }}" class="btn btn-outline-danger btn-sm ml-3 float-sm-right" title="Ավելացնել">Ավելացնել</a></h1>
@stop

@section('content')
    @php
        $heads = [
            ['label' => '#', 'width' => 6],
            'Անուն',
            ['label' => 'Կարգավիճակ', 'width' => 15],
            ['label' => 'Ստեղծման ամսաթիվ', 'width' => 20],
            'Տեսակ',
            ['label' => '', 'no-export' => true, 'width' => 8],
        ];

        $config = [
            'ajax' => [
                'url' => route('admin.labels.get')
            ],
            'order' => [[0, 'desc']],
            'columns' => [null, null, null, null, ['orderable' => false], ['orderable' => false]],
        ];
    @endphp

    <x-adminlte-datatable id="data-table" :heads="$heads" :config="$config"/>
@stop
