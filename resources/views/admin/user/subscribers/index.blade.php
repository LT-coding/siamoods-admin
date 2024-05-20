@extends('adminlte::page')

@section('title', 'Բաժանորդագրություն')

@section('content_header')
    <ol class="breadcrumb mb-3">
        <li class="breadcrumb-item"><a href="/">Գլխավոր</a></li>
        <li class="breadcrumb-item active">Բաժանորդագրություն</li>
    </ol>
    <h1 class="mb-2">Բաժանորդագրություն</h1>
@stop

@section('content')
    @php
        $heads = [
            ['label' => '#', 'width' => 6],
            ['label' => 'Էլ․ հասցե', 'width' => 80],
            ['label' => 'Կարգավիճակ'],
        ];

        $config = [
            'ajax' => [
                'url' => route('admin.subscribers.get')
            ],
            'columns' => [null, null, ['orderable' => true]],
        ];
    @endphp

    <x-adminlte-datatable id="data-table" :heads="$heads" :config="$config"/>

    <form action="{{ url('admin/subscribers') }}" method="post" class="form-status">
        @csrf
        @method('PUT')
    </form>
@stop

