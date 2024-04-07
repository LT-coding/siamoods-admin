@extends('adminlte::page')

@section('title', 'Ադմինիստրացիա')

@section('content_header')
    <ol class="breadcrumb mb-3">
        <li class="breadcrumb-item"><a href="/">Գլխավոր</a></li>
        <li class="breadcrumb-item active">Ադմինիստրացիա</li>
    </ol>
    <h1 class="mb-2">Ադմինիստրացիա <a href="{{ route('admin.users.create') }}" class="btn btn-outline-danger btn-sm ml-3 float-sm-right" title="Ավելացնել">Ավելացնել</a></h1>
@stop

@section('content')
    @php
        $heads = [
            ['label' => '#', 'width' => 6],
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
            'columns' => [null, null, null, null, null, ['orderable' => false]],
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
