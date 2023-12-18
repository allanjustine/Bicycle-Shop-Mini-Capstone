@extends('admin.layout.sidebar')

@section('content')
    <div class="container">
        <h3 class="mb-4">Update user</h3>
        <div class="d-flex justify-content-center">
            <div class="card col-md-6">
                <div class="card-body px-4 py-5 px-md-5">
                    <form method="POST" action="{{ route('admin.user.update', $user->id) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="col-md-12 mb-4">
                            <div class="form-outline">
                                <input type="text" id="name"
                                    class="form-control @error('name') is-invalid @enderror" name="name"
                                    value="{{ $user->name }}" autocomplete="name" autofocus />
                                <label class="form-label" for="name">Full name</label>
                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-12 mb-4">
                            <div class="form-outline">
                                <input type="email" id="email"
                                    class="form-control @error('email') is-invalid @enderror" name="email"
                                    value="{{ $user->email }}" autocomplete="email" autofocus />
                                <label class="form-label" for="email">Email address</label>
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-12 mb-4">
                            <div class="form-outline">
                                <input type="text" id="address"
                                    class="form-control @error('address') is-invalid @enderror" name="address"
                                    value="{{ $user->address }}" autocomplete="address" autofocus />
                                <label class="form-label" for="address">Address</label>
                                @error('address')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>


                        <div class="col-md-12 mb-4">
                            <div class="form-outline">
                                <select name="roles" id="roles"
                                    class="form-select @error('roles') is-invalid @enderror" name="roles"
                                    autocomplete="roles" autofocus>
                                    <option selected hidden value="">Select Roles</option>
                                    <option disabled>Select Roles</option>
                                    @foreach ($roles as $role)
                                        <option value="{{ $role->name }}"
                                            @if ($user->roles->first()->name == $role->name) selected @endif>
                                            {{ $role->name }}</option>
                                    @endforeach
                                </select>
                                <label class="form-label" for="roles">Roles</label>
                                @error('roles')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary btn-block">
                            Update user
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
