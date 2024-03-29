<?php

namespace App\Http\Controllers\Haysell;

use App\Http\Controllers\Controller;
use App\Http\Requests\Haysell\VariationTypesRequest;
use App\Models\VariationType;

class VariationTypesController extends Controller
{
    public function variation_types(VariationTypesRequest $request): array
    {
        $data = $request->validated();
        $types = $data['variation_headers'];
        foreach ($types as $type) {
            VariationType::query()->updateOrCreate(['id' => $type['id']],$type);
        }

        return [
            'message' => 'Success!'
        ];
    }
}
