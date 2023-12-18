@extends('admin.layout.sidebar')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-lg-6 border rounded m-3">
            <h3 class="py-3">Edit Category</h3>
            <form action="{{ route('admin.category.update', $category->id) }}" method="POST" class="m-2">
                @csrf
                @method('PUT')
                <div class="mb-3">
                <label for="name" class="form-label">Category Name</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ old('name', isset($category) ? $category->name : '') }}">
                </div>
                <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea rows="4" class="form-control" id="description" name="description">{{ old('name', isset($category) ? $category->description : '') }}</textarea>
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
                <button onclick="{ window.history.back() }" class="btn btn-primary float-end">Back</button>
                <button onclick="{ window.history.back() }" class="btn btn-secondary my-3 float-end">Back</button>
            </form>
        </div>

    </div>
</div>
@endsection

