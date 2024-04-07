@extends('adminlte::page')

@section('title', __('Categories'))

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="mb-2">{{ __('Categories') }} <a href="{{ route('admin.categories.create') }}" class="btn btn-outline-danger btn-sm float-sm-right" title="Ավելացնել">Ավելացնել</a></h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="/">Գլխավոր</a></li>
                <li class="breadcrumb-item active">{{ __('Categories') }}</li>
            </ol>
        </div>
    </div>
@stop

@section('content')
    @php
        $heads = [
            ['label' => '#', 'width' => 6],
            'Title',
            'Parent Category',
            ['label' => 'Image', 'width' => 15],
            ['label' => 'URL', 'width' => 30],
            ['label' => 'Extra Shipping Price', 'width' => 15],
            ['label' => '', 'no-export' => true, 'width' => 8],
        ];

        $config = [
            'data' => [],
            'order' => [[0, 'asc']],
            'columns' => [null, null, null, null, null, null, ['orderable' => false]],
        ];

        foreach ($records as $item) {
            $img = '<img src="'.$item->image_link.'" alt="image" style="max-height:100px;">';
            $btnView = '<a href="'.$item->url.'" class="text-olivemx-1" title="Դիտել" target="_blank"><i class="fa fa-lg fa-fw fa-eye"></i></a>';
            $btnDetails = '<a href="'.route('admin.categories.edit',['category'=>$item->id]).'" class="text-info mx-1" title="Խմբագրել"><i class="fa fa-lg fa-fw fa-pen"></i></a>';
            $btnDelete = '<a href="#" data-action="'.route('admin.categories.destroy',['category'=>$item->id]).'" class="text-danger btn-remove" title="Հեռացնել"><i class="fa fa-lg fa-fw fa-trash"></i></a>';
            $row = [$item->id,$item->title,$item->parent?->title, $img, $item->url,$item->extra_shipping_price,$btnView.$btnDetails.$btnDelete];
            $config['data'] [] = $row;
        }
    @endphp

    <x-adminlte-datatable id="data-table" :heads="$heads" :config="$config"/>
@stop
