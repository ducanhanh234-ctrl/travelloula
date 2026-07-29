@extends('layouts.app')

@section('title', 'Đổi mật khẩu')

@section('content')
    <section class="py-5" style="background: #f4f7fc;">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-6">

                    <div class="card border-0 shadow rounded-4">
                        <div class="card-body p-4 p-lg-5">

                            <div class="text-center mb-4">
                                <i class="fas fa-key fa-3x text-primary mb-3"></i>

                                <h3 class="fw-bold">
                                    Đổi mật khẩu
                                </h3>

                                <p class="text-muted">
                                    Sử dụng mật khẩu mạnh để bảo vệ tài khoản.
                                </p>
                            </div>

                            <form action="{{ route('client.profile.password.update') }}"
                                method="POST">

                                @csrf
                                @method('PUT')

                                <div class="mb-3">
                                    <label class="form-label fw-semibold">
                                        Mật khẩu hiện tại
                                    </label>

                                    <input type="password"
                                        name="current_password"
                                        class="form-control @error('current_password') is-invalid @enderror"
                                        autocomplete="current-password"
                                        required>

                                    @error('current_password')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-semibold">
                                        Mật khẩu mới
                                    </label>

                                    <input type="password"
                                        name="password"
                                        class="form-control @error('password') is-invalid @enderror"
                                        autocomplete="new-password"
                                        required>

                                    @error('password')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="mb-4">
                                    <label class="form-label fw-semibold">
                                        Xác nhận mật khẩu mới
                                    </label>

                                    <input type="password"
                                        name="password_confirmation"
                                        class="form-control"
                                        autocomplete="new-password"
                                        required>
                                </div>

                                <button type="submit"
                                    class="btn btn-primary w-100 py-2 fw-bold">

                                    <i class="fas fa-circle-check me-1"></i>
                                    Cập nhật mật khẩu

                                </button>

                            </form>

                            <div class="text-center mt-4">
                                <a href="{{ route('client.profile.show') }}"
                                    class="text-decoration-none">

                                    <i class="fas fa-arrow-left me-1"></i>
                                    Quay lại hồ sơ

                                </a>
                            </div>

                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>
@endsection
