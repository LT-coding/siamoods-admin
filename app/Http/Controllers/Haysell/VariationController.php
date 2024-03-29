<?php

namespace App\Http\Controllers\Haysell;

use App\Http\Controllers\Controller;
use App\Http\Requests\Haysell\VariationRequest;
use App\Models\Variation;

class VariationController extends Controller
{
    public function variations(VariationRequest $request): array
    {
        $data = $request->validated();
        $types = $data['variation'];
        foreach ($types as $type) {
            if ($type['deleted'] != 1) {
                $type['variation_type_id'] = $type['type_id'];
                Variation::query()->updateOrCreate(['id' => $type['id']],$type);
            }
        }

        return [
            'message' => 'Success!'
        ];
    }
}
