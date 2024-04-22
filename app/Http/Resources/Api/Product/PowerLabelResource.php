<?php

namespace App\Http\Resources\Api\Product;

use App\Enums\LabelType;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PowerLabelResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'type' => LabelType::types()[$this->type],
            'position' => $this->position,
            'media' => $this->media
        ];
    }
}
