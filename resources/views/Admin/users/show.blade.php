@extends('layouts.admin')
@section('content')
<div class="container">
    <h3>Chi tiết người dùng</h3>
    <div class="card">
        <div class="card-body">
            <p><strong>Tên:</strong> {{ $user->name }}</p>
            <p><strong>Email:</strong> {{ $user->email }}</p>
            <p><strong>Điện thoại:</strong> {{ $user->phone }}</p>
            <p><strong>Địa chỉ:</strong> {{ $user->address }}</p>
            <p><strong>Loại tài khoản:</strong> {{ ucfirst($user->roleType()) }}</p>
            <p><strong>Vai trò:</strong> {{ $user->vaiTros->pluck('ten_vai_tro')->join(', ') }}</p>
            <p><strong>Ngày tạo:</strong> {{ $user->created_at }}</p>
            <p><strong>Cập nhật:</strong> {{ $user->updated_at }}</p>
        </div>
    </div>
    <a class="btn btn-secondary mt-3" href="{{ route('Admin.users.index') }}">Quay lại</a>
    <a class="btn btn-primary mt-3" href="{{ route('Admin.users.edit', $user->id) }}">Sửa</a>
</div>
@endsection
