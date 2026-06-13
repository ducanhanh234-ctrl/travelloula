@extends('layouts.admin')
@section('content')
<div class="container">
    <h3>Quản lý người dùng</h3>
    <a class="btn btn-primary mb-3" href="{{ route('Admin.users.create') }}">Thêm mới</a>
    @if(session('success')) <div class="alert alert-success">{{ session('success') }}</div> @endif
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>Tên</th>
                <th>Email</th>
                <th>Điện thoại</th>
                <th>Loại</th>
                <th>Vai trò</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
            <tr>
                <td>{{ $user->id }}</td>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->phone }}</td>
                <td>{{ $user->roleType() }}</td>
                <td>{{ $user->vaiTros->pluck('ten_vai_tro')->join(', ') }}</td>
                <td>
                    <a class="btn btn-sm btn-info" href="{{ route('Admin.users.show', $user->id) }}">Xem</a>
                    <a class="btn btn-sm btn-secondary" href="{{ route('Admin.users.edit', $user->id) }}">Sửa</a>
                    <form action="{{ route('Admin.users.destroy', $user->id) }}" method="POST" style="display:inline" onsubmit="return confirm('Xóa tài khoản này?')">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm btn-danger">Xóa</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    {{ $users->links() }}
</div>
@endsection
