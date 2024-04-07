@extends('adminlte::page')

@section('title', 'Բաժանորդագրություն' )

@section('content_header')
    <ol class="breadcrumb mb-3">
        <li class="breadcrumb-item"><a href="/">Գլխավոր</a></li>
        <li class="breadcrumb-item active">Բաժանորդագրություն</li>
    </ol>
    <h1 class="mb-2">Բաժանորդագրություն</h1>
@stop

@section('content')
    @php
        $heads = [
            ['label' => '#', 'width' => 6],
            ['label' => 'Էլ․ հասցե', 'width' => 80],
            ['label' => 'Կարգավիճակ'],
        ];

        $config = [
            'data' => [],
            'order' => [[0, 'desc']],
            'columns' => [null, null, ['orderable' => false]],
        ];

        foreach ($records as $item) {
            $statusSelect = '<select name="status" class="form-control status-change" data-id="'.$item->id.'">';
            foreach ($statuses as $key => $value) {
                $selected = $key == $item->status ? 'selected' : '';
                $statusSelect .= '<option value="'.$key.'" '.$selected.'>'.$value->value.'</option>';
            }
            $statusSelect .= '</select>';

            $row = [$item->id, $item->email, $statusSelect];
            $config['data'] [] = $row;
        }
    @endphp

    <x-adminlte-datatable id="data-table" :heads="$heads" :config="$config"/>

    <form action="{{ url('admin/subscribers') }}" method="post" class="form-status">
        @csrf
        @method('PUT')
    </form>
@stop

