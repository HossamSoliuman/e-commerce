<?php

namespace App\Http\Controllers;

use App\Models\ProductImage;
use App\Http\Requests\StoreProductImageRequest;

class ProductImageController extends controller
{

    public function store(StoreProductImageRequest $request)
    {
        $validData = $request->validated();
        $validData['img'] = $this->uploadFile($validData['img'], ProductImage::PathToStoredImages);
        $productImage = ProductImage::create($validData);
        return to_route('products.show', ['product' => $productImage->product_id]);
    }


    public function destroy(ProductImage $productImage)
    {
        $this->deleteFile($productImage->img);
        $productImage->delete();
        return to_route('products.show', ['product' => $productImage->product_id]);
    }
}
