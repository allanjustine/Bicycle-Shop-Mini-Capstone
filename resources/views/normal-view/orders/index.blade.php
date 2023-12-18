@extends('normal-view.layout.base')

@section('title')
    | My Oders
@endsection

@section('content')
    <div class="container py-5">
        @if (session('message'))
            <div class="alert alert-success alert-dismissible fade show text-center mt-5" role="alert">
                {{ session('message') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show text-center mt-5" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <div class="row d-flex justify-content-center my-4">
            <div class="col-md-10">
                <div class="card mb-4">
                    <div class="card-header py-3">
                        <h5 class="mb-0">Request order</h5>
                        <hr>
                        <p class="mb-0"><strong>SHOP Location:</strong> 5852 Quitzon Ville Apt. 075Deonmouth, CT 29659</p>
                    </div>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Bicycle request</th>
                                <th></th>
                                <th>Price</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($orders as $order)
                                <tr>
                                    <td><img src="{{ Storage::url($order->product->image) }}"
                                            alt="{{ $order->product->name }}" class="img-thumbnail rounded-circle"
                                            style="max-width: 80px; max-height: 80px;"></td>
                                    <td><strong>{{ $order->product->name }}</strong></td>
                                    <td>{{ $order->product->price }}</td>
                                    <td>{{ $order->status }}</td>
                                    <td>
                                        @if ($order->status == 'Pending')
                                            <form action="{{ route('order.cancel', $order->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-danger" type="submit">Cancel</button>
                                            </form>
                                        @elseif($order->status == 'Confirmed')
                                            <span class="btn btn-success">Request confirmed</span>
                                            <p class="text-danger">Note: You cannot cancel your request at this moment.
                                                Please pay your order request to our shop so we can <strong>PAID</strong>
                                                your order request status.</p>
                                        @else
                                            <span class="btn btn-success">Paid</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center">No request</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
