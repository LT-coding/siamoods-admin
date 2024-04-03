@extends('adminlte::page')

@section('title', __('Products') )

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="mb-2">{{ __('Products') }} <a href="{{ route('admin.products.create') }}" class="btn btn-outline-danger btn-sm float-sm-right" title="Ավելացնել">Ավելացնել</a></h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="/">Գլխավոր</a></li>
                <li class="breadcrumb-item active">{{ __('Products') }}</li>
            </ol>
        </div>
    </div>
@stop

@section('content')
    @php
        $heads = [
            ['label' => '#', 'width' => 6],
            'Code',
            'Title',
            'Category',
            ['label' => 'Price ($)', 'width' => 8],
            ['label' => 'Image', 'width' => 10],
            ['label' => 'URL', 'width' => 35],
            ['label' => '', 'no-export' => true, 'width' => 8],
        ];

        $config = [
            'data' => [],
            'order' => [[0, 'desc']],
            'columns' => [null, null, null, null, null, null, null, ['orderable' => true]],
        ];

        foreach ($records as $item) {
            $row = [$item->id];
            $img = '<img src="'.$item->image.'" alt="image" style="max-height:100px;">';
            $btnView = '<a href="'.$item->url.'" class="text-olivemx-1" title="Դիտել" target="_blank"><i class="fa fa-lg fa-fw fa-eye"></i></a>';
            $btnDetails = '<a href="'.route('admin.products.edit',['product'=>$item->id]).'" class="text-info mx-1" title="Խմբագրել"><i class="fa fa-lg fa-fw fa-pen"></i></a>';
            $btnDelete = '<a href="#" data-action="'.route('admin.products.destroy',['product'=>$item->id]).'" class="text-danger btn-remove" title="Հեռացնել"><i class="fa fa-lg fa-fw fa-trash"></i></a>';
            $row = [$item->id,$item->code,$item->title,$item->category?->title,\App\Models\Product::formatPrice($item->price),$img,$item->url,$btnView.$btnDetails.$btnDelete];
            $config['data'] [] = $row;
        }
    @endphp

    <x-adminlte-datatable id="data-table" :heads="$heads" :config="$config"/>
@stop
