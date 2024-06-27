<?php

namespace App\Http\Controllers\Api\Product;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\Product\CategoryResource;
use App\Models\Category;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class CategoryController extends Controller
{
    public function getCategory(string $slug): CategoryResource
    {
        $category = Category::query()->where('slug',$slug)->firstOrFail();

        return new CategoryResource($category);
    }
}
