@extends('adminlte::page')

@section('title', 'Նվեր քարտեր')

@section('content_header')
    <ol class="breadcrumb mb-3">
        <li class="breadcrumb-item"><a href="/">Գլխավոր</a></li>
        <li class="breadcrumb-item active">Նվեր քարտեր</li>
    </ol>
    <h1 class="mb-2">Նվեր քարտեր</h1>
@stop

@section('content')
    @php
        $heads = [
            '#',
            'ID',
            'Նվիրողի անուն',
            'Նվիրողի Էլ․ հասցե',
            'Ստացողի անուն',
            'Ստացողի Էլ․ հասցե',
            'Գին (֏)',
            'Օգտագործված (֏)',
            'Հասանելի մնացորդ (֏)',
        ];

        $config = [
            'processing' => true,
            'serverSide' => true,
            'ajax' => [
                'url' => route('admin.gift-cards.get')
            ],
            'columns' => [null, null, null, null, null, null, null, null, null],
        ];
    @endphp

    <x-adminlte-datatable id="data-table" :heads="$heads" :config="$config"/>
@stop
