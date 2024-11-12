@extends('layouts.admin')
@section('content')
    <div class="container mt-5">
        <div class="row justify-content-center ">
            <div class="col-md-11">
                <h1>Products</h1>
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
                                        <input type="text" name="price" class="form-control"
                                            placeholder="Product price" required>
                                    </div>
                                    <div class="form-group">
                                        <input type="file" name="cover" class="form-control"
                                            placeholder="Product cover" required>
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
                <!-- Edit Product Modal -->
                <div class="modal fade" id="editModal" data-backdrop="static" data-keyboard="false" tabindex="-1"
                    role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="editModalLabel">Edit Product</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form id="editForm" method="post" enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')@csrf
                                    <div class="form-group">
                                        <input type="text" name="name" class="form-control" placeholder="Product name"
                                            required>
                                    </div>
                                    <div class="form-group">
                                        <input type="text" name="description" class="form-control"
                                            placeholder="Product description" required>
                                    </div>
                                    <div class="form-group">
                                        <input type="text" name="price" class="form-control"
                                            placeholder="Product price" required>
                                    </div>
                                    <div class="form-group">
                                        <input type="file" name="cover" class="form-control"
                                            placeholder="Product cover" required>

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

                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-primary" id="saveChangesBtn">Save Changes</button>
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
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
                                    <button type="button" class="btn btn-warning btn-edit" data-toggle="modal"
                                        data-target="#editModal">
                                        <i class="fas fa-edit"></i> Edit
                                    </button>
                                    <a href="{{ route('products.show', ['product' => $product->id]) }}"
                                        class="btn btn-info mx-2">
                                        <i class="fas fa-eye"></i> Show
                                    </a>
                                    <form action="{{ route('products.destroy', ['product' => $product->id]) }}"
                                        method="post">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">
                                            <i class="fas fa-trash-alt"></i> Delete
                                        </button>
                                    </form>
                                </td>

                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            $('.btn-edit').on('click', function() {
                var ProductName = $(this).closest("tr").find(".product-name").text();
                $('#editModal input[name="name"]').val(ProductName);
                var ProductDescription = $(this).closest("tr").find(".product-description").text();
                $('#editModal input[name="description"]').val(ProductDescription);
                var ProductPrice = $(this).closest("tr").find(".product-price").text();
                $('#editModal input[name="price"]').val(ProductPrice);

                var ProductCategory = $(this).closest("tr").find(".product-category_id").text().trim();
                $('#editModal select[name="category_id"] option').filter(function() {
                    return $(this).text().trim() === ProductCategory;
                }).prop('selected', true);

                var ProductId = $(this).closest('tr').data('product-id');
                $('#editForm').attr('action', '/products/' + ProductId);
                $('#editModal').modal('show');
            });

            $('#saveChangesBtn').on('click', function() {
                $('#editForm').submit();
                $('#editModal').modal('hide');
            });

            $('#editModal').on('hidden.bs.modal', function() {
                $('body').removeClass('modal-open');
                $('.modal-backdrop').remove();
            });
        });
    </script>
@endsection
