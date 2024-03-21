@extends('adminlte::page')

@section('title', __('Subscribers') )

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0">{{ __('Subscribers') }}</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="/">{{ __('Dashboard') }}</a></li>
                <li class="breadcrumb-item active">{{ __('Subscribers') }}</li>
            </ol>
        </div>
    </div>
@stop

@section('content')
    @php
        $heads = [
            'ID',
            ['label' => 'Email', 'width' => 50],
            ['label' => 'Status'],
        ];

        $config = [
            'data' => [],
            'order' => [[0, 'asc']],
            'columns' => [null, null, ['orderable' => true]],
        ];

        foreach ($records as $item) {
            $row = [$item->id, $item->email, \App\Enums\StatusTypes::statusText($item->status)];
            $config['data'] [] = $row;
        }
    @endphp

    <x-adminlte-datatable id="data-table" :heads="$heads" :config="$config"/>
@stop

