@extends('adminlte::page')

@section('title', __('Shipping Methods') )

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0">{{ __('Shipping Methods') }} <a href="{{ route('admin.shipping-methods.create') }}" class="btn btn-outline-danger btn-sm ml-3" title="Ավելացնել">Ավելացնել</a></h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="/">Գլխավոր</a></li>
                <li class="breadcrumb-item active">{{ __('Shipping Methods') }}</li>
            </ol>
        </div>
    </div>
@stop

@section('content')
    @php
        $heads = [
                ['label' => 'Title', 'width' => 40],
                'Image',
                ['label' => '', 'no-export' => true, 'width' => 20],
            ];

            $config = [
                'data' => [],
                'order' => [[0, 'asc']],
                'columns' => [null, null, ['orderable' => true]],
            ];

            foreach ($records as $record) {
                $row = [$record->id];
                $img = '<img src="'.$record->image_link.'" alt="'.$record->title.'" style="max-width:100%;max-height:100px;">';
                $btnDetails = '<a href="'.route('admin.shipping-methods.edit',['shipping_method'=>$record->id]).'" class="text-info mx-1" title="Խմբագրել"><i class="fa fa-lg fa-fw fa-pen"></i></a>';
                $btnDelete = '<a href="#" data-action="'.route('admin.shipping-methods.destroy',['shipping_method'=>$record->id]).'" class="text-danger btn-remove" title="Հեռացնել"><i class="fa fa-lg fa-fw fa-trash"></i></a>';
                $row = [$record->title,$img,$btnDetails.$btnDelete];
                $config['data'] [] = $row;
            }
    @endphp

    <x-adminlte-datatable id="data-table" :heads="$heads" :config="$config"/>
@stop
