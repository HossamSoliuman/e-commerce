<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\ProductResource;
use App\Models\Category;

class ProductController extends controller
{
    public function index()
    {
        $products = Product::with('category')->get();
        $categories = Category::all();
        return view('products.index', compact('products', 'categories'));
    }

    public function store(StoreProductRequest $request)
    {
        $validData = $request->validated();
        $validData['cover'] = $this->uploadFile($validData['cover'], Product::PathToStoredImages);
        $product = Product::create($validData);
        return to_route('products.index');
    }

    public function show(Product $product)
    {
        $categories = Category::all();
        $product->load('productImages');
        return view('products.show', compact('product', 'categories'));
    }

    public function update(UpdateProductRequest $request, Product $product)
    {
        $validData = $request->validated();
        if ($request->hasFile('cover')) {
            $this->deleteFile($product->cover);
            $validData['cover'] = $this->uploadFile($request->file('cover'), Product::PathToStoredImages);
        }
        $product->update($validData);
        return to_route('products.show', ['product' => $product->id]);
    }

    public function destroy(Product $product)
    {
        $this->deleteFile($product->cover);
        $product->delete();
        return to_route('products.index');
    }

    public function apiList()
    {
        $categories = Category::with('products')->get();
        return $this->apiResponse(CategoryResource::collection($categories));
    }

    public function apiShow(Product $product)
    {
        $product->load('category', 'productImages');
        return $this->apiResponse(ProductResource::make($product));
    }
}
