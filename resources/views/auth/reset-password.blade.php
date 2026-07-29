@extends('layouts.app')

@section('title', 'Đặt lại mật khẩu')

@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-5 col-md-7">

                <div class="card border-0 shadow rounded-4">
                    <div class="card-body p-4 p-lg-5">

                        <div class="text-center mb-4">
                            <div class="mb-3">
                                <i class="fas fa-key fa-3x text-primary"></i>
                            </div>

                            <h3 class="fw-bold">
                                Đặt lại mật khẩu
                            </h3>

                            <p class="text-muted mb-0">
                                Nhập mật khẩu mới cho tài khoản của bạn.
                            </p>
                        </div>

                        <form action="{{ route('password.update') }}"
                            method="POST">

                            @csrf

                            <input type="hidden"
                                name="token"
                                value="{{ $token }}">

                            <div class="mb-3">
                                <label for="email"
                                    class="form-label fw-semibold">
                                    Địa chỉ email
                                </label>

                                <input type="email"
                                    name="email"
                                    id="email"
                                    class="form-control @error('email') is-invalid @enderror"
                                    value="{{ old('email', $email) }}"
                                    autocomplete="email"
                                    required>

                                @error('email')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="password"
                                    class="form-label fw-semibold">
                                    Mật khẩu mới
                                </label>

                                <input type="password"
                                    name="password"
                                    id="password"
                                    class="form-control @error('password') is-invalid @enderror"
                                    placeholder="Tối thiểu 8 ký tự"
                                    autocomplete="new-password"
                                    required>

                                @error('password')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="password_confirmation"
                                    class="form-label fw-semibold">
                                    Xác nhận mật khẩu mới
                                </label>

                                <input type="password"
                                    name="password_confirmation"
                                    id="password_confirmation"
                                    class="form-control"
                                    placeholder="Nhập lại mật khẩu mới"
                                    autocomplete="new-password"
                                    required>
                            </div>

                            <button type="submit"
                                class="btn btn-primary w-100 py-2 fw-bold">

                                <i class="fas fa-circle-check me-2"></i>
                                Cập nhật mật khẩu

                            </button>

                        </form>

                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
