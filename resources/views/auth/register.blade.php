@extends('normal-view.layout.base')


@section('content')
    <div class="container">
        <div class="row justify-content-center mt-5">
            <div class="card shadow-lg col-md-9 col-lg-6 bg-body-tertiary">
                <div class="p-4 p-md-5">
                    <h4 class="text-center mb-3">Sign Up</h4>
                    <form method="POST" action="{{ route('register') }}" class="mb-5">
                        @csrf
                        <div class="form-group mb-3">
                            <input type="text" class="form-control rounded" name="name" id="name"
                                placeholder="Full Name" required>
                        </div>
                        <div class="form-group mb-3">
                            <input type="text" class="form-control rounded" name="address" id="address"
                                placeholder="Address" required>
                        </div>
                        <div class="form-group mb-3">
                            <input type="email" class="form-control rounded" name="email" id="email"
                                placeholder="Email" required>
                        </div>
                        <div class="form-group mb-3">
                            <input type="password" class="form-control rounded" name="password" id="password"
                                placeholder="Password" required>
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group mb-3">
                            <input type="password" class="form-control rounded" name="password_confirmation"
                                id="password_confirmation" placeholder="Confirm password" required>
                        </div>

                        <div class="form-group text-center">
                            <button type="submit" class="form-control btn btn-primary rounded submit px-3">Sign Up</button>
                        </div>
                    </form>
                    <div class="text-center">
                        <p>
                            Already have an account?<a href="/login"> Login here</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
