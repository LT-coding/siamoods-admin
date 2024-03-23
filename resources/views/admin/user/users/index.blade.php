@extends('adminlte::page')

@section('title', 'Ադմինիստրացիա' )

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0">Ադմինիստրացիա
                <a href="{{ route('admin.users.create') }}" class="btn btn-outline-danger btn-sm ml-3" title="Ավելացնել">Ավելացնել</a></h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="/">Գլխավոր</a></li>
                <li class="breadcrumb-item active">Ադմինիստրացիա</li>
            </ol>
        </div>
    </div>
@stop

@section('content')
    @php
        $heads = [
            '#',
            'Անուն',
            ['label' => 'Էլ․ հասցե', 'width' => 35],
            ['label' => 'Դեր', 'width' => 15],
            ['label' => 'Կարգավիճակ', 'width' => 15],
            ['label' => '', 'no-export' => true, 'width' => 8],
        ];

        $headTheme = "test";

        $config = [
            'data' => [],
            'order' => [[0, 'asc']],
            'columns' => [null, null, null, null, null, ['orderable' => true]],
        ];

        foreach ($records as $item) {
            $email = '<a href="mailto:"'.$item->email.'>'.$item->email.'</a>';
            $btnDetails = '<a href="'.route('admin.users.edit',['user'=>$item->id]).'" class="text-info mx-1" title="Խմբագրել"><i class="fa fa-lg fa-fw fa-pen"></i></a>';
            $btnDelete = '<a href="#" data-action="'.route('admin.users.destroy',['user'=>$item->id]).'" class="text-danger btn-remove" title="Հեռացնել"><i class="fa fa-lg fa-fw fa-trash"></i></a>';
            $row = [$item->id, $item->full_name, $email, $item->role_name, $item->status_text, $btnDetails.$btnDelete];
            $config['data'] [] = $row;
        }
    @endphp

    <x-adminlte-datatable id="data-table" :heads="$heads" :config="$config"/>
@stop
