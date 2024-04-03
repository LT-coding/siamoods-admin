@if($sizes)
    @php
        $heads = [
                'Code',
                'Size',
                'Price ($)',
                'Quantity',
                ['label' => 'URL', 'width' => 40],
                ['label' => '', 'no-export' => true, 'width' => 8],
            ];

            $config = [
                'data' => [],
                'order' => [[0, 'asc']],
                'columns' => [null, null, null, null, null, ['orderable' => true]],
            ];

            foreach ($sizes as $size) {
                $row = [$size->id];
                $btnView = '<a href="'.$size->url.'" class="text-olivemx-1" title="Դիտել" target="_blank"><i class="fa fa-lg fa-fw fa-eye"></i></a>';
                $btnDetails = '<a href="'.route('admin.sizes.edit',['variant'=>$size->variant->id, 'size'=>$size->id]).'" class="text-info mx-1" title="Խմբագրել"><i class="fa fa-lg fa-fw fa-pen"></i></a>';
                $btnDelete = '<a href="#" data-action="'.route('admin.sizes.destroy',['variant'=>$size->variant->id, 'size'=>$size->id]).'" class="text-danger btn-remove" title="Հեռացնել"><i class="fa fa-lg fa-fw fa-trash"></i></a>';
                $row = [$size->code,$size->sizeName,\App\Models\Product::formatPrice($size->price),$size->quantity,$size->url,$btnView.$btnDetails.$btnDelete];
                $config['data'] [] = $row;
            }
    @endphp

    <x-adminlte-datatable id="data-table" :heads="$heads" :config="$config"/>
@endif
