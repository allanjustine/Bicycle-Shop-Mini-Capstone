@extends('admin.layout.sidebar')
@section('content')
    <div class="container-fluid">
        <h2><strong>Admin Dashboard</strong></h2>
        <hr>
        <div class="container">
            <div class="row">
                <div class="col-lg-4 mb-3">
                    <div class="card" style="height: 15rem;">
                        <h1 class="card-title m-2">
                            Categories
                        </h1>
                        <div class="card-body text-center">
                            <div class="card-text">
                                <h2>{{ $categories->count() }}</h2>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 mb-3">
                    <div class="card" style="height: 15rem;">
                        <h1 class="card-title m-2">
                            Products
                        </h1>
                        <div class="card-body text-center">
                            <div class="card-text">
                                <h2>{{ $products->count() }}</h2>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 mb-3">
                    <div class="card" style="height: 15rem;">
                        <h1 class="card-title m-2">
                            Orders
                        </h1>
                        <div class="card-body text-center">
                            <div class="card-text">
                                <h2>{{ $orders->count() }}</h2>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 mb-3">
                    <div class="card" style="height: 15rem;">
                        <h1 class="card-title m-2">
                            Users
                        </h1>
                        <div class="card-body text-center">
                            <div class="card-text">
                                <h2>{{ $users->count() }}</h2>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 mb-3">
                    <div class="card" style="height: 15rem;">
                        <h1 class="card-title m-2">
                            Logs
                        </h1>
                        <div class="card-body text-center">
                            <div class="card-text">
                                <h2>{{ $logs->count() }}</h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
