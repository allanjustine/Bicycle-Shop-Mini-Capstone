@extends('admin.layout.sidebar')
@section('content')
    <div class="container-fluid">
        <a href="/admin/orders/create" class="btn btn-primary float-end my-3">Add Orders</a>
        <h3>Requests</h3>
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
                @foreach ($orders as $order)
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
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
