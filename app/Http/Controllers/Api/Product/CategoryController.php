<?php

namespace App\Http\Controllers\Api\Product;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\Product\CategoryResource;
use App\Http\Resources\Api\Product\CategoryMenuResource;
use App\Http\Resources\Api\Product\CategoryShortResource;
use App\Models\Category;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class CategoryController extends Controller
{
    public function getCategories(string $showLocation=null): AnonymousResourceCollection|CategoryMenuResource
    {
        $categoryQuery = Category::query()->orderBy('created_at','desc');

        if ($showLocation) {
            $categoryQuery->where($showLocation,1)->limit(5);

            if ($showLocation == 'show_in_menu') {
                $data = [
                    'all_products' => Category::query()->orderBy('created_at','desc')->whereNull('parent_id')->get(),
                    'menu_categories' => $categoryQuery->get(),
                ];
                return new CategoryMenuResource($data);
            }

        } else {
            $categoryQuery->whereNull('parent_id');
        }

        $categories = $categoryQuery->get();

        return CategoryShortResource::collection($categories);
    }

    public function getCategory(string $slug): CategoryResource
    {
        $category = Category::query()->where('slug',$slug)->firstOrFail();

        return new CategoryResource($category);
    }
}
