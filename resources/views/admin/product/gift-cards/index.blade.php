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
            'data' => [],
            'order' => [[0, 'desc']],
            'columns' => [null, null, null, null, null, null, null, null, null],
        ];

        foreach ($records as $item) {
            $row = [$item->id,$item->unique_id,$item->sender,$item->senderUser->email,$item->recipient,$item->recipientUser->email,$item->amount,$item->spend,$item->exist];
            $config['data'] [] = $row;
        }
    @endphp

    <x-adminlte-datatable id="data-table" :heads="$heads" :config="$config"/>
@stop
