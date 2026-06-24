@extends('layouts/admin_pro')

@section('content')
<style>
    .edit-user-page {
        padding: 24px 0;
    }

    .edit-user-card {
        border: none;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 4px 18px rgba(0, 0, 0, .08);
    }

    .edit-user-header {
        background: linear-gradient(135deg, #0d6efd, #5b9dff);
        color: #fff;
        padding: 20px 24px;
    }

    .edit-user-header h3 {
        margin: 0;
        font-size: 22px;
        font-weight: 700;
    }

    .edit-user-body {
        padding: 24px;
        background: #fff;
    }

    .form-label {
        font-weight: 600;
        color: #334155;
        margin-bottom: 8px;
    }

    .form-control,
    .form-select {
        border-radius: 10px;
        padding: 10px 14px;
        border: 1px solid #dbe2ea;
    }

    .form-control:focus,
    .form-select:focus {
        border-color: #0d6efd;
        box-shadow: 0 0 0 .15rem rgba(13, 110, 253, .15);
    }

    .text-danger {
        font-size: 13px;
        margin-top: 4px;
    }

    .btn-group-custom {
        display: flex;
        gap: 10px;
        margin-top: 20px;
    }

    .btn-group-custom .btn {
        min-width: 120px;
        border-radius: 8px;
        font-weight: 600;
    }

    .password-note {
        font-size: 13px;
        color: #6c757d;
        margin-top: 4px;
    }

    @media (max-width: 768px) {
        .edit-user-body {
            padding: 18px;
        }

        .btn-group-custom {
            flex-direction: column;
        }

        .btn-group-custom .btn {
            width: 100%;
        }
    }

</style>

<div class="container edit-user-page">
    <div class="card edit-user-card">

        <div class="edit-user-header">
            <h3>Chỉnh sửa tài khoản</h3>
        </div>

        <div class="edit-user-body">
            <form action="{{ route('Admin.users.update', $user->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label">Tên người dùng</label>
                    <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}">
                    <div class="text-danger">{{ $errors->first('name') }}</div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}">
                    <div class="text-danger">{{ $errors->first('email') }}</div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Mật khẩu mới</label>
                    <input type="password" name="password" class="form-control">
                    <div class="password-note">
                        Để trống nếu không muốn thay đổi mật khẩu.
                    </div>
                    <div class="text-danger">{{ $errors->first('password') }}</div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Điện thoại</label>
                    <input type="text" name="phone" class="form-control" value="{{ old('phone', $user->phone) }}">
                    <div class="text-danger">{{ $errors->first('phone') }}</div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Địa chỉ</label>
                    <input type="text" name="address" class="form-control" value="{{ old('address', $user->address) }}">
                    <div class="text-danger">{{ $errors->first('address') }}</div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Loại tài khoản</label>
                    <select name="is_active" class="form-select">
                        <option value="1" {{ old('is_active', $user->is_active) == 1 ? 'selected' : '' }}>
                            Client
                        </option>

                        <option value="2" {{ old('is_active', $user->is_active) == 2 ? 'selected' : '' }}>
                            Hướng dẫn viên
                        </option>

                        <option value="3" {{ old('is_active', $user->is_active) == 3 ? 'selected' : '' }}>
                            Admin
                        </option>
                    </select>

                    <div class="text-danger">
                        {{ $errors->first('is_active') }}
                    </div>
                </div>

                <div class="btn-group-custom">
                    <button type="submit" class="btn btn-primary">
                        Cập nhật
                    </button>

                    <a class="btn btn-secondary" href="{{ route('Admin.users.index') }}">
                        Hủy
                    </a>
                </div>

            </form>
        </div>
    </div>
</div>
@endsection
