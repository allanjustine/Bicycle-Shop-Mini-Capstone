@extends('admin.layout.sidebar')

@section('content')
    <div class="container">
        <div class="col-sm-12">
            <a href="/admin/products/create" class="btn btn-primary mb-3 me-2 float-end">
                <i class="fa-solid fa-boxes"></i> Add Product
            </a>
            <form action="{{ route('admin.products.search') }}" method="GET">
                @csrf
                <input type="search" name="search" class="form-control mb-3 mx-2 float-start" style="width: 198px;"
                    placeholder="Search">
                <button class="btn btn-primary"><i class="far fa-magnifying-glass"></i></button>
            </form>
        </div>
        @if ($search)
            <table class="table border rounded">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Price</th>
                        <th>Category</th>
                        <th>Image</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($products as $product)
                        <tr>
                            <td> {{ $product->id }} </td>
                            <td> {{ $product->name }} </td>
                            <td> {{ $product->description }} </td>
                            <td> &#8369;{{ $product->price }} </td>
                            <td> {{ $product->category->name }} </td>
                            <td>
                                <img src="{{ Storage::url($product->image) }}" alt="{{ $product->name }}"
                                    class="img-thumbnail rounded-circle" style="max-width: 150px; max-height: 150px;">
                            </td>
                            <td>
                                <a href="/admin/products/update/{{ $product->id }}" class="btn btn-warning">Edit</a>
                                <form action=" {{ route('admin.products.delete', $product->id) }}" method="post"
                                    style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center">
                                No data found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        @else
            <div class="table-responsive">
                <table class="table table-hover table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Description</th>
                            <th>Price</th>
                            <th>Category</th>
                            <th>Image</th>
                            <th>Action</th>

                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td colspan="7" class="text-center">
                                No data found.
                            </td>
                        </tr>
                    </tbody>
                </table>
                <button class="btn btn-dark" onclick="goBack()">Back <i class="far fa-arrow-left"></i></button>
            </div>
        @endif
    </div>
@endsection
