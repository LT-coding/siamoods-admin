@php
    $heads = [
            'Order #',
            'Client',
            'Order Date',
            'Tracking time',
        ];

        $config = [
            'data' => [],
            'order' => [[0, 'desc']],
            'columns' => [null, null, null, ['orderable' => false]],
            'paging' => false,
            'lengthMenu' => false
        ];

        foreach ($records as $record) {
            $row = [$record->id];
            $row = [$record->code,$record->user?$record->user->display_name:'Guest',
                    Carbon\Carbon::parse($record->paid_at)->format('d F, Y h:i'),
                    $record->tracking_time,
                ];
            $config['data'] [] = $row;
        }
@endphp

<x-adminlte-datatable id="data-table" :heads="$heads" :config="$config" theme="info" striped hoverable/>
