<?php

namespace App\Http\Controllers\Haysell;

use App\Http\Controllers\Controller;
use App\Http\Requests\Haysell\GeneralCategoryRequest;
use App\Services\Haysell\GeneralCategoryService;

class GeneralCategoryController extends Controller
{

    /**
     * @param GeneralCategoryService $service
     */
    public function __construct(private readonly GeneralCategoryService $service)
    {
        //
    }
    public function general_categories(GeneralCategoryRequest $request): array
    {
        $data = $request->validated();
        $items = $data['category_headers'];
        $this->service->createOrUpdateRecord($items);

        return [
            'message' => 'Success!'
        ];
    }
}
