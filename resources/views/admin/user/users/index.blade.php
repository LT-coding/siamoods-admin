@extends('adminlte::page')

@section('title', 'Ադմինիստրացիա')

@section('content_header')
    <ol class="breadcrumb mb-3">
        <li class="breadcrumb-item"><a href="/">Գլխավոր</a></li>
        <li class="breadcrumb-item active">Ադմինիստրացիա</li>
    </ol>
    <h1 class="mb-2">Ադմինիստրացիա <a href="{{ route('admin.users.create') }}" class="btn btn-outline-danger btn-sm ml-3 float-sm-right" title="Ավելացնել">Ավելացնել</a></h1>
@stop

@section('content')
    @php
        $heads = [
            ['label' => '#', 'width' => 6],
            'Անուն',
            ['label' => 'Էլ․ հասցե', 'width' => 35],
            ['label' => 'Դեր', 'width' => 15],
            ['label' => 'Կարգավիճակ', 'width' => 15],
            ['label' => '', 'no-export' => true, 'width' => 8],
        ];

        $config = [
            'processing' => true,
            'serverSide' => true,
            'ajax' => [
                'url' => route('admin.users.get')
            ],
            'columns' => [null, null, null, null, null, ['orderable' => false]],
        ];
    @endphp

    <x-adminlte-datatable id="data-table" :heads="$heads" :config="$config"/>
@stop
