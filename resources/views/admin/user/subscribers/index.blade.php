@extends('adminlte::page')

@section('title', 'Բաժանորդագրություն' )

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0">Բաժանորդագրություն</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="/">Գլխավոր</a></li>
                <li class="breadcrumb-item active">Բաժանորդագրություն</li>
            </ol>
        </div>
    </div>
@stop

@section('content')
    @php
        $heads = [
            '#',
            ['label' => 'Էլ․ հասցե', 'width' => 80],
            ['label' => 'Կարգավիճակ'],
        ];

        $config = [
            'data' => [],
            'order' => [[0, 'desc']],
            'columns' => [null, null, ['orderable' => true]],
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

