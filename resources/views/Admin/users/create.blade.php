@extends('layouts/admin_pro')
@section('content')
<div class="container">
    <h3>Tạo tài khoản</h3>
    <form action="{{ route('Admin.users.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label class="form-label">Tên</label>
            <input type="text" name="name" class="form-control" value="{{ old('name') }}">
            <div class="text-danger">{{ $errors->first('name') }}</div>
        </div>
        <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" name="email" class="form-control" value="{{ old('email') }}">
            <div class="text-danger">{{ $errors->first('email') }}</div>
        </div>
        <div class="mb-3">
            <label class="form-label">Mật khẩu</label>
            <input type="password" name="password" class="form-control">
            <div class="text-danger">{{ $errors->first('password') }}</div>
        </div>
        <div class="mb-3">
            <label class="form-label">Điện thoại</label>
            <input type="text" name="phone" class="form-control" value="{{ old('phone') }}">
        </div>
        <div class="mb-3">
            <label class="form-label">Địa chỉ</label>
            <input type="text" name="address" class="form-control" value="{{ old('address') }}">
        </div>
        <div class="mb-3">
            <label class="form-label">Vai trò</label>
            <div>
                @foreach($vaiTros as $v)
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" name="vai_tro_ids[]" value="{{ $v->id }}" id="vai{{ $v->id }}">
                    <label class="form-check-label" for="vai{{ $v->id }}">{{ $v->ten_vai_tro }}</label>
                </div>
                @endforeach
            </div>
        </div>
        <div class="mb-3">
            <label class="form-label">Loại tài khoản</label>
            <select name="is_active" class="form-select">
                <option value="1" {{ old('is_active') == 1 ? 'selected' : '' }}>Client</option>
                <option value="2" {{ old('is_active') == 2 ? 'selected' : '' }}>Hướng dẫn viên</option>
                <option value="3" {{ old('is_active') == 3 ? 'selected' : '' }}>Admin</option>
            </select>
            <div class="text-danger">{{ $errors->first('is_active') }}</div>
        </div>
        <button class="btn btn-primary">Lưu</button>
        <a class="btn btn-secondary" href="{{ route('Admin.users.index') }}">Hủy</a>
    </form>
</div>
@endsection
