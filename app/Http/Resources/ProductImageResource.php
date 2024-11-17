<?php

namespace App\Http\Resources;

use App\Models\ProductImage;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductImageResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'img' => filter_var($this->img, FILTER_VALIDATE_URL) ? $this->img : url($this->img),
        ];
    }
}
