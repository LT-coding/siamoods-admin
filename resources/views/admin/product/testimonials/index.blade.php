@extends('adminlte::page')

@section('title', __('Testimonials') )

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="mb-2">{{ __('Testimonials') }}</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="/">Գլխավոր</a></li>
                <li class="breadcrumb-item active">{{ __('Testimonials') }}</li>
            </ol>
        </div>
    </div>
@stop

@section('content')
    @php
        $heads = [
            ['label' => '#', 'width' => 6],
            'Name',
            'Comment',
            ['label' => 'Rate', 'width' => 5],
            ['label' => 'Product', 'width' => 40],
            ['label' => '', 'no-export' => true, 'width' => 8],
        ];

        $config = [
            'data' => [],
            'order' => [[0, 'asc']],
            'columns' => [null, null, null, null, null, ['orderable' => true]],
        ];

        foreach ($records as $item) {
            $row = [$item->id];
            $btnView = '<a href="'.$item->product->url.'" class="text-olivemx-1" title="Դիտել" target="_blank"><i class="fa fa-lg fa-fw fa-eye"></i></a>';
            $row = [$item->id,$item->name,$item->comment,$item->rate,$item->product->title,$btnView];
            $config['data'] [] = $row;
        }
    @endphp

    <x-adminlte-datatable id="data-table" :heads="$heads" :config="$config"/>
@stop
