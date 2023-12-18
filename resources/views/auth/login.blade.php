@extends('normal-view.layout.base')

@section('content')
    @if (session('message'))
        <div class="row justify-content-center">
            <div class="col-lg-4 alert alert-success mt-3 text-center">{{ session('message') }} <button type="button"
                    class="btn-close float-end" data-bs-dismiss="alert" aria-label="Close"></button></div>
        </div>
    @endif

    @if (session('error'))
        <div class="row justify-content-center">
            <div class="col-lg-5 alert alert-danger mt-3 text-center">{{ session('error') }} <button type="button"
                    class="btn-close float-end" data-bs-dismiss="alert" aria-label="Close"></button></div>
        </div>
    @endif

    <div class="row justify-content-center mt-5">
        <div class="card shadow-lg col-md-9 col-lg-5">
            <div class="p-4 p-md-5">
                <div class="icon d-flex align-items-center justify-content-center">
                    <span class="mb-4"><i class="fa-solid fa-user fa-2xl" style="color: #00e00f;"></i>
                </div>
                <h3 class="text-center mb-4">Sign In</h3>
                <form action="{{ '/' }}" method="POST">
                    @csrf
                    <div class="form-group mb-3">
                        <input type="text" class="form-control rounded-left" name="email" id="email"
                            placeholder="Email" required>
                    </div>
                    <div class="form-group mb-3">
                        <input type="password" class="form-control rounded-left" name="password" id="password"
                            placeholder="Password" required>
                    </div>
                    <div class="form-group mb-4">
                        <button type="submit" class="form-control btn btn-primary rounded submit px-3">Login</button>
                    </div>
                </form>
                <div class="d-flex float-right mb-2">
                    <a href="{{ '/register' }}">Sign up for an account</a>
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection
