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
            'Տեսակ',
            'Վերնագիր',
            ['label' => 'Նամակ', 'width' => 70],
            ['label' => '', 'no-export' => true, 'width' => 5],
        ];

        $config = [
            'data' => [],
            'order' => [[0, 'desc']],
            'columns' => [null, null, null, null, ['orderable' => false]],
        ];

        foreach ($records as $item) {
            $btnDetails = '<a href="'.route('admin.notifications.edit',['notification'=>$item->id]).'" class="text-info mx-1" title="Խմբագրել"><i class="fa fa-lg fa-fw fa-pen"></i></a>';
            $row = [$item->id, $types[$item->type], $item->title, $item->text, $btnDetails];
            $config['data'] [] = $row;
        }
    @endphp

    <x-adminlte-datatable id="data-table" :heads="$heads" :config="$config"/>
@stop

