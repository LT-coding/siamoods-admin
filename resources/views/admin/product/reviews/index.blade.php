@extends('adminlte::page')

@section('title', 'Գնահատականներ և կարծիքներ')

@section('content_header')
    <ol class="breadcrumb mb-3">
        <li class="breadcrumb-item"><a href="/">Գլխավոր</a></li>
        <li class="breadcrumb-item active">Գնահատականներ և կարծիքներ</li>
    </ol>
    <h1 class="mb-2">Գնահատականներ և կարծիքներ</h1>
@stop

@section('content')
    @php
        $heads = [
            ['label' => '#', 'width' => 6],
            'Կարծիք'
        ];

        $config = [
            'data' => [],
            'order' => [[0, 'desc']],
            'columns' => [null, ['orderable' => false]],
        ];

        foreach ($records as $item) {
            if ($item->product) {
                $rating = $options = '';
                for ($i=0; $i<5; $i++) {
                    if ($i < $item->rating) {
                        $rating .= '<i class="fa-solid fa-star fs-4"></i>';
                    } else {
                        $rating .= '<i class="fa-regular fa-star fs-4"></i>';
                    }
                }
                foreach(\App\Enums\ReviewStatus::reviews() as $key => $status) {
                    $selected = $item->status == $key ? 'selected' : '';
                    $options .= '<option value="'.$key.'" '.$selected.'>'.$status.'</option>';
                }
                $itemForm = '<form>'
                        . '<input name="_token" type="hidden" value="'.csrf_token().'" autocomplete="off"/>'
                        . '<input type="hidden" name="id" value="'.$item->id.'">'
                        . '<input type="hidden" name="haysell_id" value="'.$item->haysell_id.'">'
                        . '<input type="hidden" name="rating" value="'.$item->rating.'">'
                        . '<input type="hidden" name="ip" value="'.$item->ip.'">'
                        . '<div class="d-flex justify-content-end">'
                        . '<div>'
                        . $rating
                        . '</div>'
                        . '</div>'
                        . '<input type="text" value="'.$item->name.'" name="name" class="form-control mb-2 review-input">'
                        . '<textarea class="form-control mb-2 review-input" name="review" rows="4">'.$item->review.'</textarea>'
                        . '<div class="d-flex align-items-center justify-content-center">'
                        . '<div class=" col-md-2">'
                        . '<select class="form-control review-select" name="status">'.$options.'</select>'
                        . '</div>'
                        . '<div class="col-md-5 offset-md-1">'
                        . '<a href="'.route('admin.products.edit',$item->product->id).'"> <b>'.$item->product->item_name.'</b> <i class="fa-sharp fa-solid fa-arrow-up-right-from-square"></i></a>'
                        . '</div>'
                        . '<div class="col-md-2 offset-md-2"><span>'.$item->created_at.'</span></div>'
                        . '</div>'
                        .'</form>';
                $row = [$item->id,$itemForm];
                $config['data'] [] = $row;
            }
        }
    @endphp

    <x-adminlte-datatable id="data-table" :heads="$heads" :config="$config"/>
@stop
