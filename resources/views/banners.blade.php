@extends('layouts.admin')
@section('content')
    <div class="container mt-5">
        <div class="row justify-content-center mt-5">
            <div class="col-md-11">
                <h1>Banners</h1>
                <button type="button" class=" mb-3 btn btn-primary" data-toggle="modal" data-target="#staticBackdrop">
                    Create a new Banner
                </button>

                <!-- Creating Modal -->
                <div class="modal fade" id="staticBackdrop" data-backdrop="static" data-keyboard="false" tabindex="-1"
                    role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="staticBackdropLabel">New Banner</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form action="{{ route('banners.store') }}" method="post" enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-group">
                                        <input type="text" name="place" class="form-control" placeholder="Banner place"
                                            required>
                                    </div>
                                    <div class="form-group">
                                        <input type="file" name="image" class="form-control" placeholder="Banner image"
                                            required accept="images/*">
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
                            <th> Place</th>
                            <th> Image</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($banners as $banner)
                            <tr data-banner-id="{{ $banner->id }}">
                                <td class=" banner-place">{{ $banner->place }}</td>
                                <td class=" banner-image"><img src="{{ $banner->image }}" width="100px" alt="">
                                </td>
                                <td class="d-flex">
                                    <form action="{{ route('banners.destroy', ['banner' => $banner->id]) }}" method="post">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class=" ml-3 btn btn-danger">Delete</button>
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
                var BannerPlace = $(this).closest("tr").find(".banner-place").text();
                $('#editModal input[name="place"]').val(BannerPlace);
                var BannerImage = $(this).closest("tr").find(".banner-image").text();
                $('#editModal input[name="image"]').val(BannerImage);
                var BannerId = $(this).closest('tr').data('banner-id');
                $('#editForm').attr('action', '/banners/' + BannerId);
                $('#editModal').modal('show');
            });
            $('#saveChangesBtn').on('click', function() {
                $('#editForm').submit();
            });
        });
    </script>
@endsection
