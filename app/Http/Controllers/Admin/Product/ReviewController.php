<?php

namespace App\Http\Controllers\Admin\Product;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    /**
     * Display a listing of the resource.
     */
    public function index(): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        return view('admin.product.reviews.index');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id): JsonResponse
    {
        $record = Review::query()->findOrFail($id);
        $record->update($request->except(['_token']));

        return response()->json([
            'status' => 200
        ]);
    }

    public function getRecords(Request $request): JsonResponse
    {
        $query = Review::query();

        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search['value'];
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%$search%")
                    ->orWhere('review', 'like', "%$search%")
                    ->orWhere('created_at', 'like', "%$search%");
            });
        }

        $totalRecords = $query->count();

        $start = $request->input('start', 0);
        $length = $request->input('length', 10);

        $records = $query->orderBy('id','desc')->offset($start)->limit($length)->get();

        $data = [];
        foreach ($records as $item) {
            if ($item->product) {
                $rating = $options = '';
                for ($i=0; $i<5; $i++) {
                    if ($i < $item->rating) {
                        $rating .= '<i class="fas fa-star ml-2"></i>';
                    } else {
                        $rating .= '<i class="far fa-star ml-2"></i>';
                    }
                }
                foreach(\App\Enums\ReviewStatus::reviews() as $key => $status) {
                    $selected = $item->status == $key ? 'selected' : '';
                    $options .= '<option value="'.$key.'" '.$selected.'>'.$status.'</option>';
                }
                $itemForm = '<form action="'.route('admin.reviews.update',$item->id).'">'
                    . '<input name="_token" type="hidden" value="'.csrf_token().'" autocomplete="off"/>'
                    . '<input type="hidden" name="id" value="'.$item->id.'">'
                    . '<input type="hidden" name="haysell_id" value="'.$item->haysell_id.'">'
                    . '<input type="hidden" name="rating" value="'.$item->rating.'">'
                    . '<input type="hidden" name="ip" value="'.$item->ip.'">'
                    . '<div class="d-flex justify-content-end mb-3">'
                    . '<a href="'.route('admin.products.edit',$item->product->id).'" target="_blank"> <b>'.$item->product->item_name.'</b> <i class="fa-sharp fa-solid fa-arrow-up-right-from-square"></i></a>'
                    . '<span class="ml-5">'
                    . $rating
                    . '</span>'
                    . '</div>'
                    . '<div class="row">'
                    . '<div class="col-md-6">'
                    . '<input type="text" value="'.$item->name.'" name="name" class="form-control mb-2 review-input">'
                    . '</div>'
                    . '<div class="col-md-3">'
                    . '<select class="form-control review-select" name="status">'.$options.'</select>'
                    . '</div>'
                    . '<div class="col-md-3 text-right">'
                    . '<span>'.$item->created_at.'</span>'
                    . '</div>'
                    . '</div>'
                    . '<textarea class="form-control mb-2 review-input" name="review" rows="4">'.$item->review.'</textarea>'
                    .'</form>';
                $row = [$item->id,$itemForm];
                $data[] = $row;
            }
        }

        return response()->json([
            'draw' => $request->input('draw'),
            'recordsTotal' => $totalRecords,
            'recordsFiltered' => $totalRecords,
            'data' => $data,
        ]);
    }
}
