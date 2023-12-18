@extends('admin.layout.sidebar')
@section('content')
    <div class="container-fluid">
        <a href="/admin/products/create" class="btn btn-primary float-end my-3">Add Products</a>
        <h3>Products</h3>
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
                @foreach ($products as $product)
                    <tr>
                        <td> {{ $product->id }} </td>
                        <td> {{ $product->name }} </td>
                        <td> {{ $product->description }} </td>
                        <td> &#8369;{{ $product->price }} </td>
                        <td> {{ $product->category->name }} </td>
                        <td>
                            <img src="{{ Storage::url($product->image) }}" alt="{{ $product->name }}" class="img-thumbnail rounded-circle"
                                style="max-width: 150px; max-height: 150px;">
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
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
