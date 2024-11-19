@extends('layouts.admin')
@section('content')
    <div class="container mt-5">
        <div class="row justify-content-center ">
            <div class="col-md-11">
                <h1>Products</h1>
                @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
                <button type="button" class=" mb-3 btn btn-primary" data-toggle="modal" data-target="#staticBackdrop">
                    Create a new Product
                </button>

                <!-- Creating Modal -->
                <div class="modal fade" id="staticBackdrop" data-backdrop="static" data-keyboard="false" tabindex="-1"
                    role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="staticBackdropLabel">New Product</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form action="{{ route('products.store') }}" method="post" enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-group">
                                        <input type="text" name="name" class="form-control" placeholder="Product name"
                                            required>
                                    </div>
                                    <div class="form-group">
                                        <textarea type="text" name="description" class="form-control" placeholder="Product description" required></textarea>
                                    </div>
                                    <div class="form-group">
                                        <input type="double" name="price" class="form-control"
                                            placeholder="Product price" required>
                                    </div>
                                    <div class="form-group">
                                        <input type="file" name="cover" class="form-control" accept="image/*" required>
                                    </div>
                                    

                                    <div class="form-group">
                                        <label for="category">Category</label>
                                        <select name="category_id" class="form-control" required>
                                            <option value="">Select a Category</option>
                                            @foreach ($categories as $category)
                                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary">Submit</button>
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>


                <table class="table">
                    <thead>
                        <tr>
                            <th> Name</th>
                            <th> Description</th>
                            <th> Price</th>
                            <th> Category</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($products as $product)
                            <tr data-product-id="{{ $product->id }}">
                                <td class=" product-name">{{ $product->name }}</td>
                                <td class=" product-description">{{ Str::limit($product->description, 50, '...') }}</td>
                                <td class=" product-price">{{ $product->price }}</td>
                                <td class=" product-category_id">{{ $product->category->name }}</td>
                                <td class="d-flex">

                                    <a href="{{ route('products.show', ['product' => $product->id]) }}"
                                        class="btn btn-info mx-2">
                                        <i class="fas fa-eye"></i>
                                    </a>

                                </td>

                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
