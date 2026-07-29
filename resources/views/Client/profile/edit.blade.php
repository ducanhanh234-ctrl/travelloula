@extends('layouts.app')

@section('title', 'Chỉnh sửa hồ sơ')

@section('content')
    <section class="py-5" style="background: #f4f7fc;">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-8">

                    <div class="card border-0 shadow rounded-4">
                        <div class="card-body p-4 p-lg-5">

                            <div class="mb-4">
                                <h3 class="fw-bold text-primary mb-1">
                                    <i class="fas fa-user-pen me-2"></i>
                                    Chỉnh sửa hồ sơ
                                </h3>

                                <p class="text-muted mb-0">
                                    Cập nhật thông tin cá nhân của bạn.
                                </p>
                            </div>

                            <form action="{{ route('client.profile.update') }}"
                                method="POST"
                                enctype="multipart/form-data">

                                @csrf
                                @method('PUT')

                                <div class="row g-3">

                                    <div class="col-12 text-center mb-3">

                                        @if ($user->avatar)
                                            <img id="avatarPreview"
                                                src="{{ Storage::url($user->avatar) }}"
                                                class="rounded-circle border shadow-sm"
                                                width="130"
                                                height="130"
                                                style="object-fit: cover;">
                                        @else
                                            <img id="avatarPreview"
                                                src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&size=130"
                                                class="rounded-circle border shadow-sm"
                                                width="130"
                                                height="130"
                                                style="object-fit: cover;">
                                        @endif

                                    </div>

                                    <div class="col-12">
                                        <label class="form-label fw-semibold">
                                            Ảnh đại diện
                                        </label>

                                        <input type="file"
                                            name="avatar"
                                            id="avatar"
                                            accept=".jpg,.jpeg,.png,.webp"
                                            class="form-control @error('avatar') is-invalid @enderror">

                                        <small class="text-muted">
                                            Hỗ trợ JPG, PNG, WEBP, dung lượng tối đa 2 MB.
                                        </small>

                                        @error('avatar')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">
                                            Họ và tên
                                        </label>

                                        <input type="text"
                                            name="name"
                                            value="{{ old('name', $user->name) }}"
                                            class="form-control @error('name') is-invalid @enderror"
                                            required>

                                        @error('name')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">
                                            Email
                                        </label>

                                        <input type="email"
                                            value="{{ $user->email }}"
                                            class="form-control"
                                            disabled>

                                        <small class="text-muted">
                                            Email đăng nhập không thể tự thay đổi.
                                        </small>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">
                                            Số điện thoại
                                        </label>

                                        <input type="text"
                                            name="phone"
                                            value="{{ old('phone', $user->phone) }}"
                                            class="form-control @error('phone') is-invalid @enderror"
                                            placeholder="Ví dụ: 0912345678">

                                        @error('phone')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                    <div class="col-12">
                                        <label class="form-label fw-semibold">
                                            Địa chỉ
                                        </label>

                                        <textarea name="address"
                                            rows="3"
                                            class="form-control @error('address') is-invalid @enderror"
                                            placeholder="Nhập địa chỉ của bạn">{{ old('address', $user->address) }}</textarea>

                                        @error('address')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                </div>

                                <div class="d-flex justify-content-end gap-2 mt-4">

                                    <a href="{{ route('client.profile.show') }}"
                                        class="btn btn-light border px-4">

                                        Hủy

                                    </a>

                                    <button type="submit"
                                        class="btn btn-primary px-4">

                                        <i class="fas fa-save me-1"></i>
                                        Lưu thay đổi

                                    </button>

                                </div>

                            </form>

                            @if ($user->avatar)
                                <form action="{{ route('client.profile.avatar.delete') }}"
                                    method="POST"
                                    class="text-end mt-3"
                                    onsubmit="return confirm('Bạn có chắc muốn xóa ảnh đại diện?')">

                                    @csrf
                                    @method('DELETE')

                                    <button type="submit"
                                        class="btn btn-outline-danger btn-sm">

                                        <i class="fas fa-trash me-1"></i>
                                        Xóa ảnh đại diện

                                    </button>

                                </form>
                            @endif

                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>

    <script>
        document.getElementById('avatar')?.addEventListener('change', function(event) {
            const file = event.target.files[0];

            if (!file) {
                return;
            }

            document.getElementById('avatarPreview').src =
                URL.createObjectURL(file);
        });
    </script>
@endsection
