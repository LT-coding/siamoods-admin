@extends('adminlte::page')

@section('title', 'Առաքման մեթոդներ')

@section('content_header')
    <ol class="breadcrumb mb-3">
        <li class="breadcrumb-item"><a href="/">Գլխավոր</a></li>
        <li class="breadcrumb-item active">Առաքման մեթոդներ</li>
    </ol>
    <h1 class="mb-2">Առաքման մեթոդներ <a href="{{ route('admin.shipping-types.create') }}" class="btn btn-outline-danger btn-sm float-sm-right" title="Ավելացնել">Ավելացնել</a></h1>
@stop

@section('content')
    @php
        $heads = [
                ['label' => '#', 'width' => 6],
                'Անուն',
                ['label' => 'Կարգավիճակ', 'width' => 10],
                ['label' => 'Ստեղծման ամսաթիվ', 'width' => 20],
                'Նկար',
                ['label' => '', 'no-export' => true, 'width' => 8],
            ];

            $config = [
                'ajax' => [
                    'url' => route('admin.shipping-types.get')
                ],
                'order' => [[0, 'desc']],
                'columns' => [null, null, null, null, ['orderable' => false], ['orderable' => false]],
            ];
    @endphp

    <x-adminlte-datatable id="data-table" :heads="$heads" :config="$config"/>
@stop
