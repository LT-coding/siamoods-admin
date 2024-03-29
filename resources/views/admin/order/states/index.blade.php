@extends('adminlte::page')

@section('title', __('State Taxes') )

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="mb-2">{{ __('State Taxes') }}</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="/">Գլխավոր</a></li>
                <li class="breadcrumb-item active">{{ __('States') }}</li>
            </ol>
        </div>
    </div>
@stop

@section('content')
    @php
        $heads = [
                'Title',
                'Abbr',
                'Country',
                ['label' => 'Tax (%)', 'width' => 20],
                ['label' => '', 'no-export' => true, 'width' => 8],
            ];

            $config = [
                'data' => [],
                'order' => [[2, 'asc']],
                'columns' => [null, null, null, null, ['orderable' => true]],
            ];

            foreach ($records as $record) {
                $row = [$record->id];
                $tax = '<form method="post" action="'.route('admin.states.update',['state' => $record->id]).'" id="state_'.$record->id.'">'
                        . '<input type="hidden" name="_method" value="PUT">'
                        . '<input name="_token" type="hidden" value="'.csrf_token().'" autocomplete="off"/>'
                        . '<input name="id" type="hidden" value="'.$record->id.'"/>'
                        . '<input name="tax" type="number" step=0.0001 value="'.$record->tax.'" class="form-control"/>'
                        .'</form>';
                $btnSave = '<button type="submit" form="state_'.$record->id.'" class="btn btn-success" title="Save"><i class="fa fa-lg fa-fw fa-save"></i></button>';
                $row = [$record->title,$record->postal,$record->country,$tax,$btnSave];
                $config['data'] [] = $row;
            }
    @endphp

    <x-adminlte-datatable id="data-table" :heads="$heads" :config="$config"/>
@stop
