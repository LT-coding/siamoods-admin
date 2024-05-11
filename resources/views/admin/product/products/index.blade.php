@extends('adminlte::page')

@section('title', 'Ապրանքներ')

@section('content_header')
    <ol class="breadcrumb mb-3">
        <li class="breadcrumb-item"><a href="/">Գլխավոր</a></li>
        <li class="breadcrumb-item active">Ապրանքներ</li>
    </ol>
    <h1 class="mb-2">Ապրանքներ</h1>
@stop

@section('content')
    @php
        $heads = [
            ['label' => '#', 'width' => 6],
            'HaySell',
            'Անուն / Կոդ',
            'Կատեգորիա',
            ['label' => 'Նկար', 'width' => 10],
            'Գին (֏)',
            'Քանակ',
            ['label' => '', 'no-export' => true, 'width' => 7],
        ];

        $config = [
            'processing' => true,
            'serverSide' => true,
            'ajax' => [
                'url' => route('admin.products.get')
            ],
            'columns' => [null, null, null, null, null, null, null, ['orderable' => false]],
        ];
    @endphp

    <x-adminlte-datatable id="data-table" :heads="$heads" :config="$config"/>
@stop
