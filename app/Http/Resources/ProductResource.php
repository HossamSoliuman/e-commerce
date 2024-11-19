<?php

namespace App\Http\Resources;

use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    public function toArray($request)
    {
        $images = [['img' => filter_var($this->cover, FILTER_VALIDATE_URL) ? $this->cover : url($this->cover)]];

        if ($this->relationLoaded('productImages')) {
            $images = array_merge($images, ProductImageResource::collection($this->productImages)->toArray($request));
        }

        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'price' => $this->price,
            'offer_enabled' => $this->offer_enabled,
            'offer_content' => $this->offer_content,
            'Price_after_offer' => $this->Price_after_offer,
            'stock_status' => $this->stock_status,
            'cover' => filter_var($this->cover, FILTER_VALIDATE_URL) ? $this->cover : url($this->cover),
            'category' => CategoryResource::make($this->whenLoaded('category')),
            'images' => $images,
            'created_at' => $this->created_at,
            'last_update' => $this->updated_at,
        ];
    }
}
