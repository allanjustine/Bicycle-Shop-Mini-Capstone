@extends('admin.layout.sidebar')

@section('content')
    <div class="container-fluid">
        <div class="row d-flex justify-content-center">
            <div class="col-lg-6 border rounded m-3 shadow-lg">
                <h3 class="py-3">Create Category</h3>
                <form action="{{ route('admin.categories.create') }}" method="POST" class="m-2">
                    @csrf
                    <div class="mb-3">
                        <label for="name" class="form-label">Category Name</label>
                        <input type="text" class="form-control" id="name" name="name">
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea type="text" class="form-control" id="description" name="description"></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                    <a href="/admin/categories" class="btn btn-secondary float-end">Back</a>
                </form>
            </div>
        </div>
    </div>
@endsection
