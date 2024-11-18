<?php

namespace Database\Factories;

use App\Models\ProductImage;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductImageFactory extends Factory
{
    protected $model = ProductImage::class;

    public function definition()
    {
        $products = Product::all();
        return [
            'img' => $this->faker->imageUrl(640, 480, 'product', true),
            'product_id' => fake()->randomElement($products),
        ];
    }
}
