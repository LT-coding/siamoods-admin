@extends('adminlte::page')

@section('title', 'Ծանուցումներ')

@section('content_header')
    <ol class="breadcrumb mb-3">
        <li class="breadcrumb-item"><a href="/">Գլխավոր</a></li>
        <li class="breadcrumb-item active">Ծանուցումներ</li>
    </ol>
    <h1 class="mb-2">Ծանուցումներ</h1>
@stop

@section('content')
    @php
        $heads = [
            ['label' => '#', 'width' => 6],
            ['label' => 'Վերնագիր', 'width' => 25],
            ['label' => 'Նամակ', 'width' => 60],
            'Տեսակ',
            ['label' => '', 'no-export' => true, 'width' => 5],
        ];

        $config = [
            'ajax' => [
                'url' => route('admin.notifications.get')
            ],
            'order' => [[0, 'desc']],
            'columns' => [null, null, null, ['orderable' => false], ['orderable' => false]],
        ];
    @endphp

    <x-adminlte-datatable id="data-table" :heads="$heads" :config="$config"/>
@stop

