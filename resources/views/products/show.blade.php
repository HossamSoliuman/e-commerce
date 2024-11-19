@extends('layouts.admin')
@section('content')
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <h1 class="text-center mb-4">Product Details</h1>
                <div class="card">
                    <div class="card-header text-center bg-primary text-white">
                        <h3>{{ $product->name }}</h3>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <h5 class="mb-2"><strong>Description:</strong></h5>
                            <p>{{ $product->description }}</p>
                        </div>
                        <div class="mb-3">
                            <h5 class="mb-2"><strong>Price:</strong></h5>
                            <p>${{ number_format($product->price, 2) }}</p>
                        </div>
                        <div class="mb-3">
                            <h5 class="mb-2"><strong>Category:</strong></h5>
                            <p>{{ $product->category->name }}</p>
                        </div>
                        <div class="mb-3">
                            <h5 class="mb-2"><strong>Stock Status:</strong></h5>
                            <p>{{ $product->stock_status ? 'In Stock' : 'Out of Stock' }}</p>
                        </div>

                        <div class="mb-4 text-center">
                            <h5 class="mb-2"><strong>Cover Image:</strong></h5>
                            <img src="{{ asset($product->cover) }}" alt="{{ $product->name }}"
                                class="img-fluid rounded shadow-sm" style="max-height: 300px;">
                        </div>
                        <hr>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <h5><strong>Offer Enabled:</strong></h5>
                                <p>{{ $product->offer_enabled ? 'Yes' : 'No' }}</p>
                            </div>
                            <div class="col-md-6">
                                <h5><strong>Offer Content:</strong></h5>
                                <p>{{ $product->offer_content }}</p>
                            </div>
                        </div>
                        <div class="d-flex justify-content-between">
                            <button class="btn btn-warning" data-toggle="modal" data-target="#editModal">
                                <i class="fas fa-edit"></i> Edit Product
                            </button>
                            <form action="{{ route('products.destroy', ['product' => $product->id]) }}" method="post">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">
                                    <i class="fas fa-trash-alt"></i> Delete Product
                                </button>
                            </form>
                        </div>
                        <hr>
                        <h5><strong>Product Images:</strong></h5>
                        <div class="row">
                            @foreach ($product->productImages as $img)
                                <div class="col-md-3 mb-4">
                                    <div class="card shadow-sm">
                                        <img src="{{ asset($img->img) }}" alt="{{ $product->name }}"
                                            class="img-fluid rounded-top">
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
                        <form action="{{ route('product-images.store') }}" method="POST" enctype="multipart/form-data"
                            class="mt-4">
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
                        <a href="{{ route('products.index') }}" class="btn btn-secondary mt-3">
                            <i class="fas fa-arrow-left"></i> Back to Products
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="editModal" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog"
        aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="editModalLabel">Edit Product</h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="editForm" action="{{ route('products.update', $product->id) }}" method="post"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" name="name" class="form-control" value="{{ $product->name }}"
                                required>
                        </div>
                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea name="description" class="form-control" required>{{ $product->description }}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="price">Price</label>
                            <input type="text" name="price" class="form-control" value="{{ $product->price }}"
                                required>
                        </div>
                        <div class="form-group">
                            <label for="stock_status">Stock Status</label>
                            <select name="stock_status" class="form-control" required>
                                <option value="1" {{ $product->stock_status ? 'selected' : '' }}>In Stock</option>
                                <option value="0" {{ !$product->stock_status ? 'selected' : '' }}>Out of Stock
                                </option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="cover">Cover Image</label>
                            <input type="file" name="cover" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="category">Category</label>
                            <select name="category_id" class="form-control" required>
                                <option value="">Select a Category</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}"
                                        {{ $product->category_id == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="offer_enabled">Enable Offer</label>
                            <select name="offer_enabled" class="form-control" required>
                                <option value="1" {{ $product->offer_enabled ? 'selected' : '' }}>Yes</option>
                                <option value="0" {{ !$product->offer_enabled ? 'selected' : '' }}>No</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="offer_content">Offer Amount</label>
                            <input name="offer_content" type="number" class="form-control"
                                value="{{ $product->offer_content }}">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" onclick="$('#editForm').submit()">Save
                        Changes</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@endsection
