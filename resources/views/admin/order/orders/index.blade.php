@extends('adminlte::page')

@section('title', __('Orders') )

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="mb-2">{{ __('Orders') }}</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="/">Գլխավոր</a></li>
                <li class="breadcrumb-item active">{{ __('Orders') }}</li>
            </ol>
        </div>
    </div>
@stop

@section('content')
    @php
        $heads = [
                'Order #',
                ['label' => 'Client', 'width' => 30],
                'Payment Method',
                'Total',
                'Order Date',
                'Tracking time',
                'Status',
                ['label' => '', 'no-export' => true, 'width' => 8],
            ];

            $config = [
                'data' => [],
                'order' => [[0, 'desc']],
                'columns' => [null, null, null, null, null, null, null, ['orderable' => false]],
            ];

            foreach ($records as $record) {
                $row = [$record->id];
                $btnDetails = '<a href="'.route('admin.orders.edit',['order'=>$record->id]).'" class="text-info mx-1" title="Խմբագրել"><i class="fa fa-lg fa-fw fa-pen"></i></a>';
                $row = [$record->code,$record->user?$record->user->display_name:'Guest',
                        $record->payment_method,$record->currency.\App\Models\Product::formatPrice($record->total),
                        Carbon\Carbon::parse($record->paid_at)->format('d F, Y h:i'),
                        $record->tracking_time,
                        \App\Enums\OrderStatuses::getConstants()[$record->status],$btnDetails
                    ];
                $config['data'] [] = $row;
            }
    @endphp

    <x-adminlte-datatable id="data-table" :heads="$heads" :config="$config"/>
@stop
