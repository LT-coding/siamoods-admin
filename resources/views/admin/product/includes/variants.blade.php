@if($variants)
    @php
        $heads = [
                'Code',
                'Variant Image',
                'Variant Name',
                ['label' => 'Actions', 'no-export' => true, 'width' => 20],
            ];

            $config = [
                'data' => [],
                'order' => [[0, 'asc']],
                'columns' => [null, null, null, ['orderable' => true]],
            ];

            foreach ($variants as $variant) {
                $row = [$variant->id];
                $img = '<img src="'.$variant->image.'" alt="'.$variant->name.'" style="max-width: 100px;max-height: 100px;">';
                $btnView = '<a href="'.$variant->url.'" class="text-info mx-1" title="View" target="_blank"><i class="fa fa-lg fa-fw fa-eye"></i></a>';
                $btnDetails = '<a href="'.route('admin.variants.edit',['product'=>$record->id, 'variant'=>$variant->id]).'" class="text-olive mx-1" title="Edit"><i class="fa fa-lg fa-fw fa-pen"></i></a>';
                $btnDelete = '<a href="#" data-action="'.route('admin.variants.destroy',['product'=>$record->id, 'variant'=>$variant->id]).'" class="text-danger btn-remove" title="Delete"><i class="fa fa-lg fa-fw fa-trash"></i></a>';
                $row = [$variant->code,$img,$variant->name,$btnView.$btnDetails.$btnDelete];
                $config['data'] [] = $row;
            }
    @endphp

    <x-adminlte-datatable id="data-table" :heads="$heads" :config="$config"/>
@endif
