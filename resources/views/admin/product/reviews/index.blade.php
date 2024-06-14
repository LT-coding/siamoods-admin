@extends('adminlte::page')

@section('title', 'Գնահատականներ և կարծիքներ')

@section('content_header')
    <ol class="breadcrumb mb-3">
        <li class="breadcrumb-item"><a href="/">Գլխավոր</a></li>
        <li class="breadcrumb-item active">Գնահատականներ և կարծիքներ</li>
    </ol>
    <h1 class="mb-2">Գնահատականներ և կարծիքներ</h1>
@stop

@section('content')
    @php
        $heads = [
            ['label' => '#', 'width' => 6],
            'Կարծիք'
        ];

        $config = [
            'ajax' => [
                'url' => route('admin.reviews.get')
            ],
            'order' => [[0, 'desc']],
            'columns' => [null, ['orderable' => false]],
        ];
    @endphp

    <x-adminlte-datatable id="data-table" :heads="$heads" :config="$config"/>
@stop
