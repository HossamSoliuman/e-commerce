@extends('layouts.admin')
@section('content')
    <div class="container mt-5">
        <div class="row justify-content-center mt-5">
            <div class="col-md-8">
                <h1>Product Details</h1>
                <div class="card mt-4">
                    <div class="card-header">
                        <h4>{{ $product->name }}</h4>
                    </div>
                    <div class="card-body">
                        <p><strong>Description:</strong> {{ $product->description }}</p>
                        <p><strong>Price:</strong> ${{ number_format($product->price, 2) }}</p>
                        <p><strong>Category:</strong> {{ $product->category->name }}</p>
                        <p><strong>Cover Image:</strong></p>
                        <img src="{{ asset($product->cover) }}" alt="{{ $product->name }}" class="img-fluid rounded mb-3"
                            style="max-height: 300px;">
                        <hr>
                        <p><strong>Product Images:</strong></p>
                        <div class="row">
                            @foreach ($product->productImages as $img)
                                <div class="col-md-3 mb-3">
                                    <div class="card">
                                        <img src="{{ asset($img->img) }}" alt="{{ $product->name }}"
                                            class="img-fluid rounded" style="max-height: 100px;">
                                        <div class="card-body text-center">
                                            <form action="{{ route('product-images.destroy', $img->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm">
                                                    <i class="fas fa-trash-alt"></i> Delete
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="card-footer">
                        <form action="{{ route('product-images.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            <div class="form-group">
                                <label for="img">Upload Product Image</label>
                                <input type="file" class="form-control" name="img" required accept="image/*">

                            </div>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-upload"></i> Upload Image
                            </button>
                        </form>
                        <a href="{{ route('products.index') }}" class="btn btn-secondary mt-2">
                            <i class="fas fa-arrow-left"></i> Back to Products
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
