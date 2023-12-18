@extends('admin.layout.sidebar')

@section('content')
    <div class="container-fluid d-flex justify-content-center">

        <div class="col-lg-6 border rounded">
            <div class="m-3">
                <h3>Edit Product</h3>
                <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control" id="name" name="name"
                            value="{{ old('name', $product->name) }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="name" class="form-label">Category</label>
                        <select name="category_id" id="category_id" class="form-control">
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}"
                                    {{ $category->id == $product->category_id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="price" class="form-label">Price</label>
                        <input type="number" class="form-control" id="price" name="price"
                            value="{{ old('price', $product->price) }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control" id="description" name="description" rows="4">{{ old('description', $product->description) }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label for="image" class="form-label">Image</label>
                        <input type="file" class="form-control" id="image" name="image">
                    </div>

                    @if ($product->image)
                        <div class="mb-3">
                            <label>Current Image</label>
                            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}"
                                class="img-thumbnail" style="max-width: 200px; max-height: 200px;">
                        </div>
                    @endif

                    <button type="submit" class="btn btn-primary my-3">Update</button>
                    <button onclick="{ window.history.back() }" class="btn btn-secondary my-3 float-end">Back</button>
                </form>
            </div>
        </div>
    </div>
@endsection
