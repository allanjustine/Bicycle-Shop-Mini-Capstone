@extends('admin.layout.sidebar')
@section('content')
    <div class="container-fluid">
        <a href="/admin/categories/create" class="btn btn-primary float-end mt-3">Add Category</a>
        <h3>Categories</h3>
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($categories as $category)
                    <tr>
                        <td>{{ $category->id }}</td>
                        <td>{{ $category->name }}</td>
                        <td>{{ $category->description }}</td>
                        <td>
                            <a class="btn btn-warning" href="/admin/categories/update/{{ $category->id }}">Edit</a>
                            <form action="{{ route('admin.category.delete', $category->id) }}" method="POST"
                                style="display: inline;">
                                @csrf
                                @method('delete')
                                <button type="submit" class="btn btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach

            </tbody>
        </table>
    </div>
@endsection
