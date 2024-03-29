<?php

namespace App\Http\Controllers\Haysell;

use App\Http\Controllers\Controller;
use App\Http\Requests\Haysell\DetailRequest;
use App\Services\Haysell\DetailService;

class DetailController extends Controller
{
    /**
     * @param DetailService $service
     */
    public function __construct(private readonly DetailService $service)
    {
        //
    }
    public function details(DetailRequest $request): array
    {
        $data = $request->validated();
        $items = $data['detail_headers'];
        $this->service->createOrUpdateRecord($items);

        return [
            'message' => 'Success!'
        ];
    }
}
