@extends('layouts.app')

@section('title', 'Quên mật khẩu')

@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-5 col-md-7">

                <div class="card border-0 shadow rounded-4">
                    <div class="card-body p-4 p-lg-5">

                        <div class="text-center mb-4">
                            <div class="mb-3">
                                <i class="fas fa-lock-open fa-3x text-primary"></i>
                            </div>

                            <h3 class="fw-bold">
                                Quên mật khẩu
                            </h3>

                            <p class="text-muted mb-0">
                                Nhập email đã đăng ký. Hệ thống sẽ gửi cho bạn
                                liên kết để đặt lại mật khẩu.
                            </p>
                        </div>

                        @if (session('success'))
                            <div class="alert alert-success">
                                <i class="fas fa-circle-check me-2"></i>
                                {{ session('success') }}
                            </div>
                        @endif

                        <form action="{{ route('password.email') }}"
                            method="POST">

                            @csrf

                            <div class="mb-4">
                                <label for="email"
                                    class="form-label fw-semibold">
                                    Địa chỉ email
                                </label>

                                <div class="input-group">
                                    <span class="input-group-text bg-white">
                                        <i class="fas fa-envelope text-primary"></i>
                                    </span>

                                    <input type="email"
                                        name="email"
                                        id="email"
                                        class="form-control @error('email') is-invalid @enderror"
                                        value="{{ old('email') }}"
                                        placeholder="Nhập email của bạn"
                                        autocomplete="email"
                                        required>

                                    @error('email')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            <button type="submit"
                                class="btn btn-primary w-100 py-2 fw-bold">

                                <i class="fas fa-paper-plane me-2"></i>
                                Gửi liên kết đặt lại mật khẩu

                            </button>

                        </form>

                        <div class="text-center mt-4">
                            <a href="{{ route('login') }}"
                                class="text-decoration-none">

                                <i class="fas fa-arrow-left me-1"></i>
                                Quay lại đăng nhập

                            </a>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
