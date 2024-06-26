@extends('adminlte::page')

@section('title', 'Պատվերներ')

@section('content_header')
    <ol class="breadcrumb mb-3">
        <li class="breadcrumb-item"><a href="/">Գլխավոր</a></li>
        <li class="breadcrumb-item active">Պատվերներ</li>
    </ol>
    <div class="d-flex justify-content-between align-items-center mb-2">
        <h1>Պատվերներ</h1>
        <div class="date-filter d-flex justify-content-between align-items-center">
            <form method="{{ url()->current() }}" class="d-flex">
                <input type="date" class="form-control mr-1" name="from" value="{{ \Request::get('from') ?? '' }}"/>
                <input type="date" class="form-control mr-1" name="to" value="{{ \Request::get('to') ?? '' }}"/>
                <input type="submit" value="Ֆիլտրել" class="btn btn-success btn-sm mr-1"/>
                <a href="{{ url()->current() }}" class="btn btn-danger btn-sm d-flex align-items-center"><i class="fas fa-times"></i></a>
            </form>
        </div>
    </div>
@stop

@section('content')
    @php
        $heads = [
                ['label' => '#', 'width' => 6],
                ['label' => 'Կարգավիճակ', 'width' => 16],
                'Ամսաթիվ',
                'Հաճախորդ',
                'Հեռախոսահամար',
                'Փոստ. ինդեքս',
                'Ընդամենը',
                'Վճարման մեթոդ',
                ['label' => '', 'no-export' => true, 'width' => 8],
            ];

            $config = [
                'ajax' => [
                    'url' => route('admin.orders.get', ['from' => Request::get('from') ?? null, 'to' => Request::get('to') ?? null])
                ],
                'order' => [[0, 'desc']],
                'columns' => [null, null, null, null, null, null, null, null, ['orderable' => false]],
            ];
    @endphp

    <x-adminlte-datatable id="orders-data-table" :heads="$heads" :config="$config"/>
@stop
