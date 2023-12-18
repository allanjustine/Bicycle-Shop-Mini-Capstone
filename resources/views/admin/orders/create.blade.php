@extends('admin.layout.sidebar')

@section('content')
    <h3 class="mb-4">Create order</h3>
    <div class="d-flex justify-content-center">
        <div class="card col-md-6 shadow">
            <div class="card-body px-4 py-5 px-md-5">
                <form method="POST" action="{{ route('admin.orders.create') }}">
                    @csrf

                    <div class="col-md-12 mb-4">
                        <div class="form-outline">
                            <select name="user_id" id="user_id" class="form-select @error('user_id') is-invalid @enderror"
                                name="user_id" autocomplete="user_id" autofocus>
                                <option selected hidden value="">Select User</option>
                                <option disabled>Select User</option>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                @endforeach
                            </select>
                            <label class="form-label" for="user_id">Select User</label>
                            @error('user_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>The user field is required.</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-12 mb-4">
                        <div class="form-outline">
                            <select name="product_id" id="product_id"
                                class="form-select @error('product_id') is-invalid @enderror" name="product_id"
                                autocomplete="product_id" autofocus>
                                <option selected hidden value="">Select Category</option>
                                <option disabled>Select Category</option>
                                @foreach ($products as $product)
                                    <option value="{{ $product->id }}">{{ $product->name }}</option>
                                @endforeach
                            </select>
                            <label class="form-label" for="product_id">Select Category</label>
                            @error('product_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>The category field is required.</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-12 mb-4">
                        <div class="form-outline">
                            <select name="status" id="status" class="form-select @error('status') is-invalid @enderror"
                                name="status" autocomplete="status" autofocus>
                                <option selected hidden value="">Select status</option>
                                <option disabled>Select status</option>
                                <option value="Pending">Pending</option>
                                <option value="Paid">Paid</option>
                            </select>
                            <label class="form-label" for="status">Status</label>
                            @error('status')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary btn-block">
                        Create order
                    </button>
                    <a href="/admin/orders" class="btn btn-secondary float-end">Back</a>
                </form>
            </div>
        </div>
    </div>
@endsection
