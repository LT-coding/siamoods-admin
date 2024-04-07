@extends('adminlte::page')

@section('title', 'Հաշիվներ')

@section('content_header')
    <ol class="breadcrumb mb-3">
        <li class="breadcrumb-item"><a href="/">Գլխավոր</a></li>
        <li class="breadcrumb-item active">Հաշիվներ</li>
    </ol>
    <h1 class="mb-2">Հաշիվներ</h1>
@stop

@section('content')
    @php
        $heads = [
            ['label' => '#', 'width' => 6],
            'Անուն',
            ['label' => 'Հեռախոսահամար', 'width' => 20],
            ['label' => 'Էլ․ հասցե', 'width' => 35],
            ['label' => 'Գրանցման ամսաթիվ', 'width' => 15],
//            ['label' => '', 'no-export' => true, 'width' => 5],
        ];

        $config = [
            'data' => [],
            'order' => [[0, 'desc']],
            'columns' => [null, null, null, null, ['orderable' => true]],
        ];

        foreach ($records as $item) {
            $email = '<a href="mailto:"'.$item->email.'>'.$item->email.'</a>';
//            $btnDetails = '<a href="'.route('admin.accounts.show',['account'=>$item->id]).'" class="text-info mx-1" title="Details"><i class="fa fa-lg fa-fw fa-eye"></i></a>';
            $row = [$item->id, $item->full_name, $item->phone, $email, $item->registered];
            $config['data'] [] = $row;
        }
    @endphp

    <x-adminlte-datatable id="data-table" :heads="$heads" :config="$config"/>
@stop
