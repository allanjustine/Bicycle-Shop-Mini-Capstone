@extends('normal-view.layout.base')

@section('content')

    @if ($search)
        <div id="carouselExampleIndicators" class="carousel slide">
            <div class="carousel-indicators">
                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active"
                    aria-current="true" aria-label="Slide 1"></button>
                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1"
                    aria-label="Slide 2"></button>
                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2"
                    aria-label="Slide 3"></button>
            </div>
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img src="https://d1nymbkeomeoqg.cloudfront.net/photos/26/22/383687_8457_XL.jpg" class="d-block w-100"
                        style="height: 450px; object-fit: cover;" alt="...">
                </div>
                <div class="carousel-item">
                    <img src="https://hips.hearstapps.com/hmg-prod/images/allbikes-1539286251.jpg?crop=0.987xw:1.00xh;0.00814xw,0&resize=1200:*"
                        class="d-block w-100" style="height: 450px; object-fit: cover;" alt="...">
                </div>
                <div class="carousel-item">
                    <img src="https://pedalandchain.co.uk/cdn/shop/collections/Schwinn_eVoyageur_Mid-Drive_Cruiser_Electric_Bike_5_Level_Pedal_Assist_Comfort_Frame2_600x.jpg?v=1692213835"
                        class="d-block w-100" style="height: 450px; object-fit: cover;" alt="...">
                </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators"
                data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators"
                data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>

        <div class="container-fluid mt-5">
            <div class="container">
                <h2>Featured Bicycles</h2>

                <div class="container">
                    <form class="d-flex ms-auto py-md-2" role="search" action="{{ route('searched') }}" method="GET">
                        @csrf
                        <input class="form-control me-2" name="search" type="search" placeholder="Search"
                            aria-label="Search" value="{{ $search }}">
                        <button class="btn btn-outline-success" type="submit">Search</button>
                    </form>
                    <hr>
                </div>
                <div class="container vehicleContainer mb-3">
                    <div class="row align-items-center">
                        @forelse ($products as $product)
                            <div class="col-lg-4 col-md-6 col-sm-12 mb-3" title="{{ $product->description }}">
                                <a href="#" class="card" href="" style="width: 100%; text-decoration:none;">

                                    <form method="post" action="{{ route('orders.create', $product->id) }}">
                                        @csrf
                                        {{-- @if (!Auth::user()) --}}
                                        {{-- @else --}}
                                        {{-- <input type="text" class="form-control" id="user_id" name="user_id" value="{{Auth::user()->id}}" hidden> --}}
                                        {{-- @endif --}}
                                        <input type="text" class="form-control" id="product_id" name="product_id"
                                            value="{{ $product->id }}" hidden>
                                        <input type="number" class="form-control" id="total_price" name="total_price"
                                            value="{{ $product->price }}" hidden>
                                        <input type="text" class="form-control" id="status" value="Pending"
                                            name="status" hidden>


                                        <img src="{{ asset('storage/' . $product->image) }}" class="card-img-top"
                                            style="height: 25rem; object-fit:cover">
                                        <div class="card-body">
                                            <h3 class="card-text">{{ $product->name }}</h3>
                                            <h5 class="card-text">&#8369;{{ number_format($product->price, 2) }}</h5>
                                            @if (!Auth::user())
                                                <button onclick='{{ url('/login') }}' class="btn btn-success my-2"><i
                                                        class="bi bi-cart-plus"></i> Request order</button>
                                            @else
                                                <button type="submit" class="btn btn-success my-2"><i
                                                        class="bi bi-cart-plus"></i>
                                                    Request order</button>
                                            @endif
                                        </div>
                                    </form>
                                </a>
                            </div>
                        @empty
                            <h5 class="text-center my-5">There's no products searched.</h5>
                        @endforelse
                    </div>
                </div>
            </div>
        @else
            <div id="carouselExampleIndicators" class="carousel slide">
                <div class="carousel-indicators">
                    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0"
                        class="active" aria-current="true" aria-label="Slide 1"></button>
                    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1"
                        aria-label="Slide 2"></button>
                    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2"
                        aria-label="Slide 3"></button>
                </div>
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <img src="https://d1nymbkeomeoqg.cloudfront.net/photos/26/22/383687_8457_XL.jpg"
                            class="d-block w-100" style="height: 450px; object-fit: cover;" alt="...">
                    </div>
                    <div class="carousel-item">
                        <img src="https://hips.hearstapps.com/hmg-prod/images/allbikes-1539286251.jpg?crop=0.987xw:1.00xh;0.00814xw,0&resize=1200:*"
                            class="d-block w-100" style="height: 450px; object-fit: cover;" alt="...">
                    </div>
                    <div class="carousel-item">
                        <img src="https://pedalandchain.co.uk/cdn/shop/collections/Schwinn_eVoyageur_Mid-Drive_Cruiser_Electric_Bike_5_Level_Pedal_Assist_Comfort_Frame2_600x.jpg?v=1692213835"
                            class="d-block w-100" style="height: 450px; object-fit: cover;" alt="...">
                    </div>
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators"
                    data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators"
                    data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
            <div class="container">
                <form class="d-flex ms-auto py-md-2" role="search" action="{{ route('searched') }}" method="GET">
                    @csrf
                    <input class="form-control me-2" name="search" type="search" placeholder="Search"
                        aria-label="Search">
                    <button class="btn btn-outline-success" type="submit">Search</button>
                </form>
            </div>
            <hr>
            <h5 class="text-center my-5">There's no products searched.</h5>
    @endif
@endsection
