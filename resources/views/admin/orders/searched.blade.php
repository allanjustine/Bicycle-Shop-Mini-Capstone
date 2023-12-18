@extends('admin.layout.base')

@section('content')
    <div class="container">

        <div class="col-sm-12">
            <a href="/admin/orders/create" class="btn btn-primary mb-3 me-2 float-end">
                <i class="fa-solid fa-cart-circle-check"></i> Create Order
            </a>
            <form action="{{ route('admin.orders.search') }}" method="GET">
                @csrf
                <input type="search" name="search" class="form-control mb-3 mx-2 float-start" style="width: 198px;"
                    placeholder="Search">
                <button class="btn btn-primary"><i class="far fa-magnifying-glass"></i></button>
            </form>
        </div>
        @if ($search)
            <table class="table border rounded">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Bicycle Pick</th>
                        <th></th>
                        <th>Price</th>
                        <th>Customer</th>
                        <th>Address</th>
                        <th>Email</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($orders as $order)
                        <tr>
                            <td> {{ $order->id }} </td>
                            <td> <img src="{{ Storage::url($order->product->image) }}" alt="{{ $order->product->name }}"
                                    class="img-thumbnail rounded-circle" style="max-width: 80px; max-height: 80px;"></td>
                            <td>
                                {{ $order->product->name }}</td>
                            <td> {{ $order->product->price }} </td>
                            <td> {{ $order->user->name }} </td>
                            <td> {{ $order->user->address }} </td>
                            <td> {{ $order->user->email }} </td>
                            <td> {{ $order->status }} </td>

                            <td>
                                <form action=" {{ route('admin.ordres.confirm', $order->id) }}" method="post"
                                    style="display: inline;">
                                    @csrf
                                    @method('PUT')
                                    <input type="text" name="status" value="{{ $order->status }}" hidden>
                                    <input type="text" name="status" hidden value="{{ $order->status }}">
                                    @if ($order->status == 'Pending')
                                        <button type="submit" class="btn btn-success">
                                            Confirm request</button>
                                    @elseif ($order->status == 'Confirmed')
                                        <button type="submit" class="btn btn-success">
                                            Paid request</button>
                                    @else
                                        <a href="#" class="btn btn-success"> Paid</a>
                                    @endif
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="text-center">
                                No data found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        @else
            <div class="table-responsive">
                <table class="table table-hover table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Bicycle Pick</th>
                            <th></th>
                            <th>Price</th>
                            <th>Customer</th>
                            <th>Address</th>
                            <th>Email</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td colspan="9" class="text-center">
                                No data found.
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <button class="btn btn-dark" onclick="goBack()">Back <i class="far fa-arrow-left"></i></button>
        @endif
    </div>
@endsection
