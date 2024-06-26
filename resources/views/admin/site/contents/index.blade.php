@extends('adminlte::page')

@section('title', $typeText)

@section('content_header')
    <ol class="breadcrumb mb-3">
        <li class="breadcrumb-item"><a href="/">Գլխավոր</a></li>
        <li class="breadcrumb-item active">{{ $typeText }}</li>
    </ol>
    <h1 class="mb-2">{{ $typeText }} <a href="{{ route('admin.contents.create', ['type' => $type]) }}" class="btn btn-outline-danger btn-sm float-sm-right" title="Ավելացնել">Ավելացնել</a></h1>
@stop

@section('content')
    @php
        $heads = $type == \App\Enums\ContentTypes::page->name ? [
            ['label' => '#', 'width' => 6],
            'Վերնագիր',
            ['label' => 'Կարգավիճակ', 'width' => 10],
            ['label' => 'Ստեղծման ամսաթիվ', 'width' => 20],
            ['label' => '', 'no-export' => true, 'width' => 8],
        ] : [
            ['label' => '#', 'width' => 6],
            'Վերնագիր',
            ['label' => 'Կարգավիճակ', 'width' => 8],
            ['label' => 'Ստեղծման ամսաթիվ', 'width' => 20],
            ['label' => 'Նկար', 'width' => 10],
            ['label' => '', 'no-export' => true, 'width' => 8],
        ];

        $config = [
            'ajax' => [
                'url' => route('admin.contents.get', ['type' => $type])
            ],
            'order' => [[0, 'desc']],
            'columns' => $type == \App\Enums\ContentTypes::page->name ? [null, null, null, null, ['orderable' => false]] : [null, null, null, null, ['orderable' => false], ['orderable' => false]],
        ];
    @endphp

    <x-adminlte-datatable id="data-table" :heads="$heads" :config="$config"/>
@stop
