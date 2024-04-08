@extends('adminlte::page')

@section('title', 'Պրոմոկոդեր')

@section('content_header')
    <ol class="breadcrumb mb-3">
        <li class="breadcrumb-item"><a href="/">Գլխավոր</a></li>
        <li class="breadcrumb-item active">Պրոմոկոդեր</li>
    </ol>
    <h1 class="mb-2">Պրոմոկոդեր <a href="{{ route('admin.promotions.create') }}" class="btn btn-outline-danger btn-sm ml-3 float-sm-right" title="Ավելացնել">Ավելացնել</a></h1>
@stop

@section('content')
    @php
        $heads = [
            ['label' => '#', 'width' => 6],
            'Անուն',
            'Պրոմոկոդ',
            'Տեսակ',
            ['label' => 'Կարգավիճակ', 'width' => 15],
            ['label' => 'Ստեղծման ամսաթիվ', 'width' => 20],
            ['label' => '', 'no-export' => true, 'width' => 8],
        ];

        $config = [
            'data' => [],
            'order' => [[0, 'desc']],
            'columns' => [null, null, null, null, null, null, ['orderable' => false]],
        ];

        foreach ($records as $item) {
            $type = \App\Enums\PromotionType::promotions()[$item->type];
            $created = \Carbon\Carbon::createFromDate($item->created_at)->format('d.m.Y');
            $btnDetails = '<a href="'.route('admin.promotions.edit',['promotion'=>$item->id]).'" class="text-info mx-1" title="Խմբագրել"><i class="fa fa-lg fa-fw fa-pen"></i></a>';
            $btnDelete = $item->promo_code == 'ABCARD5' ? '' : '<a href="#" data-action="'.route('admin.promotions.destroy',['promotion'=>$item->id]).'" class="text-danger btn-remove" title="Հեռացնել"><i class="fa fa-lg fa-fw fa-trash"></i></a>';
            $row = [$item->id, $item->name, $item->promo_code, $type, $item->status_text, $created, $btnDetails.$btnDelete];
            $config['data'] [] = $row;
        }
    @endphp

    <x-adminlte-datatable id="data-table" :heads="$heads" :config="$config"/>
@stop
