<?php

namespace App\Http\Resources\Api\Product;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ReviewResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'name' => $this->name,
            'review' => $this->review,
            'rating' => $this->rating,
            'date' => Carbon::createFromFormat('Y-m-d H:i:s', $this->created_at)->format('d.m.Y')
        ];
    }
}
