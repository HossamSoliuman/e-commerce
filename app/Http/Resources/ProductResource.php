<?php

namespace App\Http\Resources;

use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
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
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'price' => $this->price,
            'offer_enabled' => $this->offer_enabled,
            'offer_content' => $this->offer_content,
            'cover' => filter_var($this->cover, FILTER_VALIDATE_URL) ? $this->cover : url($this->cover),
            'category' => CategoryResource::make($this->whenLoaded('category')),
            'images' => ProductImageResource::collection($this->whenLoaded('productImages')),
            'created_at' => $this->created_at,
            'last_update' => $this->updated_at,
        ];
    }
}
