@extends('adminlte::page')

@section('title', __('Users') )

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0">{{ __('Users') }} <a href="{{ route('admin.users.create') }}" class="btn btn-primary btn-sm" title="Add"><i class="fa fa-lg fa-fw fa-plus"></i></a></h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="/">{{ __('Dashboard') }}</a></li>
                <li class="breadcrumb-item active">{{ __('Users') }}</li>
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
            ['label' => 'Role', 'width' => 15],
            ['label' => 'Actions', 'no-export' => true, 'width' => 8],
        ];

        $config = [
            'data' => [],
            'order' => [[0, 'asc']],
            'columns' => [null, null, null, null, null, ['orderable' => true]],
        ];

        foreach ($records as $item) {
            $btnDetails = '<a href="'.route('admin.users.edit',['user'=>$item->id]).'" class="text-olive mx-1" title="Edit"><i class="fa fa-lg fa-fw fa-pen"></i></a>';
            $btnDelete = '<a href="#" data-action="'.route('admin.users.destroy',['user'=>$item->id]).'" class="text-danger btn-remove" title="Delete"><i class="fa fa-lg fa-fw fa-trash"></i></a>';
            $row = [$item->id, $item->full_name, $item->phone_number, $item->email, $item->role_name, $btnDetails.$btnDelete];
            $config['data'] [] = $row;
        }
    @endphp

    <x-adminlte-datatable id="data-table" :heads="$heads" :config="$config"/>
@stop
