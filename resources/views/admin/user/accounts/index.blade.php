@extends('adminlte::page')

@section('title', __('Accounts') )

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0">{{ __('Accounts') }}</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="/">{{ __('Dashboard') }}</a></li>
                <li class="breadcrumb-item active">{{ __('Accounts') }}</li>
            </ol>
        </div>
    </div>
@stop

@section('content')
    @php
        $heads = [
            'ID',
            'Full Name',
            ['label' => 'Phone', 'width' => 20],
            ['label' => 'Email', 'width' => 35],
            ['label' => 'Registered'],
            ['label' => 'Actions', 'no-export' => true, 'width' => 5],
        ];

        $config = [
            'data' => [],
            'order' => [[0, 'asc']],
            'columns' => [null, null, null, null, null, ['orderable' => true]],
        ];

        foreach ($records as $item) {
            $btnDetails = '<a href="'.route('admin.accounts.show',['account'=>$item->id]).'" class="text-info mx-1" title="Details"><i class="fa fa-lg fa-fw fa-eye"></i></a>';
            $row = [$item->id, $item->full_name, $item->phone_number, $item->email, $item->registered, $btnDetails];
            $config['data'] [] = $row;
        }
    @endphp

    <x-adminlte-datatable id="data-table" :heads="$heads" :config="$config"/>
@stop
