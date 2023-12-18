@extends('admin.layout.sidebar')

@section('content')
    <div class="container-fluid">
        <h3 class="mb-4">Users</h3>
        <div class="col-sm-12">
            <a href="/admin/users/create" class="btn btn-primary mb-3 me-2 float-end">
                <i class="fa-solid fa-user-plus"></i> Add User
            </a>
        </div>
        <table class="table border rounded">
            <thead>
                <tr>
                    <th>ID.</th>
                    <th>Full Name</th>
                    <th>Email</th>
                    <th>Address</th>
                    <th>Role</th>
                    <th>Status</th>
                    <th>Action</th>

                </tr>
            </thead>
            <tbody>
                @forelse ($users as $user)
                    <tr>
                        <td>{{ $user->id }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->address }}</td>
                        <td>
                            @foreach ($user->roles as $role)
                                @if ($role->id === 1)
                                    <span>Admin</span>
                                @break

                            @else
                                <span>User</span>
                            @endif
                        @endforeach
                    </td>
                    <td>
                        @if ($user->email_verified_at != null)
                            <span>Verified</span>
                        @else
                            <span>Not Verified</span>
                        @endif
                    </td>
                    <td>
                        <form method="POST" action="{{ route('admin.user.delete', $user->id) }}">
                            @csrf
                            @method('DELETE')
                            <a href="/admin/users/update/{{ $user->id }}" class="btn btn-warning">Edit</a>
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="12" class="text-center">
                        No data found.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
    <div>
        {{ $users->links('pagination::bootstrap-5') }}
    </div>
</div>
@endsection
