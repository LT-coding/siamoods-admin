@extends('adminlte::page')

@section('title', 'Ապրանքներ')

@section('content_header')
    <ol class="breadcrumb mb-3">
        <li class="breadcrumb-item"><a href="/">Գլխավոր</a></li>
        <li class="breadcrumb-item active">Ապրանքներ</li>
    </ol>
    <h1 class="mb-2">Ապրանքներ</h1>
@stop

@section('content')
    @php
        $heads = [
            ['label' => '#', 'width' => 6],
            'HaySell',
            'Անուն / Կոդ',
            'Կատեգորիա',
            ['label' => 'Նկար', 'width' => 10],
            'Գին (֏)',
            'Քանակ',
            ['label' => '', 'no-export' => true, 'width' => 8],
        ];

        $config = [
            'data' => [],
            'order' => [[0, 'desc']],
            'columns' => [null, null, null, null, null, null, null, ['orderable' => false]],
        ];

        foreach ($records as $item) {
            $row = [$item->id];
            $img = $item->general_image?->image ? '<img src="'.$item->general_image->image.'" alt="image" style="max-height:100px;">' : '-';
            $btnDetails = '<a href="'.route('admin.products.edit',['product'=>$item->id]).'" class="text-info mx-1" title="Խմբագրել"><i class="fa fa-lg fa-fw fa-pen"></i></a>';
            $btnDelete = '<a href="#" data-action="'.route('admin.products.destroy',['product'=>$item->id]).'" class="text-danger btn-remove" title="Հեռացնել"><i class="fa fa-lg fa-fw fa-trash"></i></a>';
            $row = [$item->id,$item->articul,$item->item_name,$item->category?->name,$img,$item->price?->price ?? 0,$item->balance?->balance ?? 0,$btnDetails.$btnDelete];
            $config['data'] [] = $row;
        }
    @endphp

    <x-adminlte-datatable id="data-table" :heads="$heads" :config="$config"/>
@stop
