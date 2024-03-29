<?php

namespace App\Http\Controllers\Haysell;

use App\Http\Controllers\Controller;
use App\Http\Requests\Haysell\CategoryRequest;
use App\Services\Haysell\CategoryService;

class CategoryController extends Controller
{
    /**
     * @param CategoryService $service
     */
    public function __construct(private readonly CategoryService $service)
    {
        //
    }

    public function categories(CategoryRequest $request): array
    {
        $data = $request->validated();
        $items = $data['filters'];
        $this->service->createOrUpdateRecord($items);

        return [
            'message' => 'Success!'
        ];
    }
}
