@extends('adminlte::page')

@section('title', 'Հաշիվներ')

@section('content_header')
    <ol class="breadcrumb mb-3">
        <li class="breadcrumb-item"><a href="/">Գլխավոր</a></li>
        <li class="breadcrumb-item active">Հաշիվներ</li>
    </ol>
    <h1 class="mb-2">Հաշիվներ</h1>
@stop

@section('content')
    @php
        $heads = [
            ['label' => '#', 'width' => 6],
            'Անուն',
            ['label' => 'Հեռախոսահամար', 'width' => 20],
            ['label' => 'Էլ․ հասցե', 'width' => 30],
            ['label' => 'Գրանցման ամսաթիվ', 'width' => 20],
            ['label' => '', 'no-export' => true, 'width' => 5],
        ];

        $config = [
            'ajax' => [
                'url' => route('admin.accounts.get')
            ],
            'order' => [[0, 'desc']],
            'columns' => [null, null, null, null, null, ['orderable' => false]],
        ];
    @endphp

    <x-adminlte-datatable id="data-table" :heads="$heads" :config="$config"/>
@stop
