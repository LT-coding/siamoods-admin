@extends('adminlte::page')

@section('title', $styleText)

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0">{{ $styleText }} <a href="{{ route('admin.additions.create',['style' => $style]) }}" class="btn btn-primary btn-sm" title="Add"><i class="fa fa-lg fa-fw fa-plus"></i></a></h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="/">{{ __('Dashboard') }}</a></li>
                <li class="breadcrumb-item active">{{ $styleText }}</li>
            </ol>
        </div>
    </div>
@stop

@section('content')
    @php
        $heads = [
            ['label' => ucfirst($style) . ' Type Title', 'width' => 20],
            ucfirst($style) . 's',
             ['label' => 'Actions', 'no-export' => true, 'width' => 8]
        ];

        $config = [
            'data' => [],
            'order' => [[0, 'asc']],
            'columns' => [null, null, ['orderable' => true]],
        ];

        foreach ($records as $item) {
            $row = [$item->id];
            $images = '';
            foreach ($item->images()->limit(10)->get() as $image) {
                $images .= '<img src="'.$image->image_link.'" alt="image" style="max-height:70px;margin-right:7px;">';
            }
            $btnDetails = '<a href="'.route('admin.additions.edit',['style' => $style,'addition'=>$item->id]).'" class="text-olive mx-1" title="Edit"><i class="fa fa-lg fa-fw fa-pen"></i></a>';
            $btnDelete = '<a href="#" data-action="'.route('admin.additions.destroy',['style' => $style,'addition'=>$item->id]).'" class="text-danger mx-1 btn-remove" title="Delete"><i class="fa fa-lg fa-fw fa-trash"></i></a>';
            $row = [$item->title, $images, $btnDetails.$btnDelete];
            $config['data'] [] = $row;
        }
    @endphp

    <x-adminlte-datatable id="data-table" :heads="$heads" :config="$config"/>
@stop
