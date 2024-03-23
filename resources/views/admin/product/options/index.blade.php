@extends('adminlte::page')

@section('title', __('Options') )

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0">{{ __('Option') }} <a href="{{ route('admin.options.create') }}" class="btn btn-outline-danger btn-sm ml-3" title="Ավելացնել"><i class="fa fa-lg fa-fw fa-plus"></i></a></h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="/">Գլխավոր</a></li>
                <li class="breadcrumb-item active">{{ __('Option') }}</li>
            </ol>
        </div>
    </div>
@stop

@section('content')
    @php
        $heads = [
            '#',
            'Title',
            ['label' => 'Show in Filter', 'width' => 20],
            ['label' => '', 'no-export' => true, 'width' => 8],
        ];

        $config = [
            'data' => [],
            'order' => [[0, 'desc']],
            'columns' => [null, null, null, ['orderable' => true]],
        ];

        foreach ($records as $item) {
            $showInFilter = $item->show_in_filter ? '<span class="text-success">Yes</span>' : '<span class="text-danger">No</span>';
            $btnDetails = '<a href="'.route('admin.options.edit',['option'=>$item->id]).'" class="text-info mx-1" title="Խմբագրել"><i class="fa fa-lg fa-fw fa-pen"></i></a>';
            $btnDelete = '<a href="#" data-action="'.route('admin.options.destroy',['option'=>$item->id]).'" class="text-danger btn-remove" title="Հեռացնել"><i class="fa fa-lg fa-fw fa-trash"></i></a>';
            $row = [$item->id,$item->title,$showInFilter,$btnDetails.$btnDelete];
            $config['data'] [] = $row;
        }
    @endphp

    <x-adminlte-datatable id="data-table" :heads="$heads" :config="$config"/>
@stop
