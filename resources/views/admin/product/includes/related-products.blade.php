@if($relatedProducts)
    @php
        $heads = [
                ['label' => 'Title', 'width' => 40],
                'Image',
                'Additional Price',
                ['label' => '', 'no-export' => true, 'width' => 20],
            ];

            $config = [
                'data' => [],
                'order' => [[0, 'asc']],
                'columns' => [null, null, null, ['orderable' => false]],
            ];

            foreach ($relatedProducts as $product) {
                $row = [$product->id];
                $img = '<img src="'.$product->image_link.'" alt="'.$product->title.'" style="max-width:100%;max-height:100px;">';
                $btnDetails = '<a href="'.route('admin.related-products.edit',['product'=>$record->id, 'related_product'=>$product->id]).'" class="text-info mx-1" title="Խմբագրել"><i class="fa fa-lg fa-fw fa-pen"></i></a>';
                $btnDelete = '<a href="#" data-action="'.route('admin.related-products.destroy',['product'=>$record->id, 'related_product'=>$product->id]).'" class="text-danger btn-remove" title="Հեռացնել"><i class="fa fa-lg fa-fw fa-trash"></i></a>';
                $row = [$product->title,$img,$product->additional_price,$btnDetails.$btnDelete];
                $config['data'] [] = $row;
            }
    @endphp

    <x-adminlte-datatable id="related-data-table" :heads="$heads" :config="$config"/>
@endif
