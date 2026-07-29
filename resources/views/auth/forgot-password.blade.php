@extends('layouts.app')

@section('title', 'Quên mật khẩu')

@section('content')
    <style>
        .forgot-password-page {
            min-height: calc(100vh - 140px);
            position: relative;
            overflow: hidden;
            padding: 70px 0;
            display: flex;
            align-items: center;
            background:
                radial-gradient(
                    circle at 12% 18%,
                    rgba(39, 112, 245, 0.11),
                    transparent 30%
                ),
                radial-gradient(
                    circle at 88% 82%,
                    rgba(100, 72, 230, 0.11),
                    transparent 32%
                ),
                linear-gradient(
                    135deg,
                    #f8faff 0%,
                    #edf4ff 48%,
                    #f8f7ff 100%
                );
        }

        .forgot-password-page::before,
        .forgot-password-page::after {
            content: "";
            position: absolute;
            border-radius: 50%;
            pointer-events: none;
        }

        .forgot-password-page::before {
            width: 340px;
            height: 340px;
            top: -185px;
            left: -145px;
            background: rgba(48, 95, 226, 0.07);
        }

        .forgot-password-page::after {
            width: 285px;
            height: 285px;
            right: -130px;
            bottom: -140px;
            background: rgba(95, 68, 224, 0.08);
        }

        .forgot-password-wrapper {
            position: relative;
            z-index: 2;
        }

        .forgot-password-card {
            overflow: hidden;
            background: rgba(255, 255, 255, 0.97);
            border: 1px solid rgba(215, 225, 243, 0.95);
            border-radius: 24px;
            box-shadow:
                0 24px 60px rgba(28, 58, 115, 0.14),
                0 4px 14px rgba(28, 58, 115, 0.05);
        }

        .forgot-card-header {
            min-height: 128px;
            position: relative;
            overflow: hidden;
            padding: 27px 30px;
            display: flex;
            align-items: center;
            color: #fff;
            background: linear-gradient(
                120deg,
                #1268ee 0%,
                #237eee 55%,
                #6047e6 100%
            );
        }

        .forgot-card-header::before,
        .forgot-card-header::after {
            content: "";
            position: absolute;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.08);
        }

        .forgot-card-header::before {
            width: 190px;
            height: 190px;
            top: -118px;
            right: 38px;
        }

        .forgot-card-header::after {
            width: 125px;
            height: 125px;
            right: -42px;
            bottom: -67px;
        }

        .forgot-header-content {
            position: relative;
            z-index: 2;
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .forgot-icon-box {
            width: 60px;
            height: 60px;
            flex: 0 0 60px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            background: rgba(255, 255, 255, 0.15);
            border: 1px solid rgba(255, 255, 255, 0.28);
            border-radius: 17px;
            font-size: 25px;
            box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.15);
        }

        .forgot-card-header h3 {
            color: #fff;
            margin-bottom: 5px;
            font-size: 24px;
            font-weight: 800;
        }

        .forgot-card-header p {
            color: rgba(255, 255, 255, 0.84);
            margin-bottom: 0;
            font-size: 13px;
            line-height: 1.55;
        }

        .forgot-card-body {
            padding: 32px;
        }

        .forgot-notice {
            padding: 13px 15px;
            display: flex;
            align-items: flex-start;
            gap: 10px;
            color: #315174;
            background: #f3f7ff;
            border: 1px solid #dbe6fa;
            border-radius: 12px;
            font-size: 12px;
            line-height: 1.55;
            margin-bottom: 24px;
        }

        .forgot-notice i {
            color: #2f67df;
            margin-top: 2px;
        }

        .forgot-alert {
            display: flex;
            align-items: flex-start;
            gap: 10px;
            padding: 14px 15px;
            border: 0;
            border-radius: 12px;
            font-size: 12px;
            line-height: 1.55;
            box-shadow: 0 5px 15px rgba(31, 74, 126, 0.06);
        }

        .forgot-alert-success {
            color: #087956;
            background: #e9f8f2;
            border: 1px solid #c0e8d7;
        }

        .forgot-alert-danger {
            color: #be3e52;
            background: #fff0f2;
            border: 1px solid #f0c9d0;
        }

        .forgot-label {
            color: #243d68;
            margin-bottom: 8px;
            font-size: 13px;
            font-weight: 700;
        }

        .forgot-input-group {
            position: relative;
        }

        .forgot-input-icon {
            width: 47px;
            position: absolute;
            top: 1px;
            bottom: 1px;
            left: 1px;
            z-index: 5;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #6e84aa;
            border-radius: 11px 0 0 11px;
            pointer-events: none;
            transition: color 0.2s ease;
        }

        .forgot-control {
            min-height: 51px;
            padding: 11px 15px 11px 46px;
            color: #263e65;
            background: #fbfcff;
            border: 1px solid #d7e0ef;
            border-radius: 12px;
            font-size: 13px;
            box-shadow: none;
            transition: all 0.2s ease;
        }

        .forgot-control:focus {
            color: #1f365d;
            background: #fff;
            border-color: #3570e8;
            box-shadow: 0 0 0 4px rgba(53, 112, 232, 0.11);
        }

        .forgot-input-group:focus-within .forgot-input-icon {
            color: #2468e8;
        }

        .forgot-control::placeholder {
            color: #a0aec3;
        }

        .forgot-control.is-invalid {
            border-color: #dc5368;
            background-image: none;
        }

        .forgot-hint {
            margin-top: 7px;
            color: #8491a8;
            font-size: 11px;
            line-height: 1.5;
        }

        .forgot-submit-btn {
            min-height: 51px;
            width: 100%;
            position: relative;
            overflow: hidden;
            color: #fff;
            background: linear-gradient(
                105deg,
                #1568ed 0%,
                #287cef 62%,
                #5b48e4 100%
            );
            border: 0;
            border-radius: 12px;
            font-size: 14px;
            font-weight: 800;
            box-shadow: 0 10px 22px rgba(34, 103, 231, 0.23);
            transition: all 0.2s ease;
        }

        .forgot-submit-btn::before {
            content: "";
            width: 70px;
            height: 140%;
            position: absolute;
            top: -20%;
            left: -100px;
            transform: rotate(18deg);
            background: rgba(255, 255, 255, 0.16);
            transition: left 0.45s ease;
        }

        .forgot-submit-btn:hover {
            color: #fff;
            transform: translateY(-2px);
            box-shadow: 0 14px 28px rgba(34, 103, 231, 0.29);
        }

        .forgot-submit-btn:hover::before {
            left: calc(100% + 40px);
        }

        .forgot-submit-btn:disabled {
            cursor: not-allowed;
            opacity: 0.72;
            transform: none;
            box-shadow: none;
        }

        .forgot-back-link {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            color: #52709d;
            font-size: 12px;
            font-weight: 700;
            text-decoration: none;
            transition: all 0.18s ease;
        }

        .forgot-back-link:hover {
            color: #1d65e7;
            transform: translateX(-2px);
        }

        .forgot-security-row {
            margin-top: 24px;
            padding-top: 20px;
            display: flex;
            justify-content: center;
            gap: 18px;
            color: #8896ac;
            border-top: 1px solid #e7ecf4;
            font-size: 10px;
        }

        .forgot-security-row span {
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }

        .invalid-feedback {
            margin-top: 7px;
            font-size: 11px;
            font-weight: 600;
        }

        @media (max-width: 575.98px) {
            .forgot-password-page {
                padding: 35px 12px;
                align-items: flex-start;
            }

            .forgot-card-header {
                min-height: auto;
                padding: 23px 20px;
            }

            .forgot-header-content {
                align-items: flex-start;
            }

            .forgot-icon-box {
                width: 51px;
                height: 51px;
                flex-basis: 51px;
                font-size: 21px;
            }

            .forgot-card-header h3 {
                font-size: 20px;
            }

            .forgot-card-body {
                padding: 24px 20px;
            }

            .forgot-security-row {
                align-items: center;
                flex-direction: column;
                gap: 7px;
            }
        }
    </style>

    <section class="forgot-password-page">
        <div class="container forgot-password-wrapper">
            <div class="row justify-content-center">
                <div class="col-xl-5 col-lg-6 col-md-8">

                    <div class="forgot-password-card">

                        {{-- Header --}}
                        <div class="forgot-card-header">

                            <div class="forgot-header-content">

                                <div class="forgot-icon-box">
                                    <i class="fas fa-lock-open"></i>
                                </div>

                                <div>
                                    <h3>Quên mật khẩu?</h3>

                                    <p>
                                        Nhập email đã đăng ký để nhận liên kết
                                        đặt lại mật khẩu.
                                    </p>
                                </div>

                            </div>

                        </div>

                        {{-- Nội dung --}}
                        <div class="forgot-card-body">

                            <div class="forgot-notice">

                                <i class="fas fa-circle-info"></i>

                                <span>
                                    Hệ thống sẽ gửi một liên kết bảo mật đến email
                                    của bạn. Liên kết chỉ có hiệu lực trong một
                                    khoảng thời gian nhất định.
                                </span>

                            </div>

                            {{-- Thông báo thành công --}}
                            @if (session('success'))
                                <div class="alert forgot-alert forgot-alert-success mb-4">

                                    <i class="fas fa-circle-check mt-1"></i>

                                    <div>
                                        <strong>Đã gửi liên kết</strong>

                                        <div class="mt-1">
                                            {{ session('success') }}
                                        </div>
                                    </div>

                                </div>
                            @endif

                            {{-- Thông báo lỗi chung --}}
                            @if (session('error'))
                                <div class="alert forgot-alert forgot-alert-danger mb-4">

                                    <i class="fas fa-circle-exclamation mt-1"></i>

                                    <div>
                                        <strong>Không thể gửi email</strong>

                                        <div class="mt-1">
                                            {{ session('error') }}
                                        </div>
                                    </div>

                                </div>
                            @endif

                            <form action="{{ route('password.email') }}"
                                method="POST"
                                id="forgotPasswordForm">

                                @csrf

                                <div class="mb-4">

                                    <label for="email" class="forgot-label">
                                        Địa chỉ email
                                    </label>

                                    <div class="forgot-input-group">

                                        <span class="forgot-input-icon">
                                            <i class="fas fa-envelope"></i>
                                        </span>

                                        <input type="email"
                                            name="email"
                                            id="email"
                                            class="form-control forgot-control
                                                @error('email') is-invalid @enderror"
                                            value="{{ old('email') }}"
                                            placeholder="Ví dụ: nguyenvana@gmail.com"
                                            autocomplete="email"
                                            autofocus
                                            required>

                                    </div>

                                    @error('email')
                                        <div class="invalid-feedback d-block">

                                            <i class="fas fa-circle-exclamation me-1"></i>

                                            {{ $message }}

                                        </div>
                                    @enderror

                                    <div class="forgot-hint">
                                        Hãy nhập đúng email đã dùng khi đăng ký tài khoản.
                                    </div>

                                </div>

                                <button type="submit"
                                    class="btn forgot-submit-btn"
                                    id="forgotSubmitButton">

                                    <i class="fas fa-paper-plane me-2"></i>

                                    Gửi liên kết đặt lại mật khẩu

                                </button>

                            </form>

                            <div class="text-center mt-4">

                                <a href="{{ route('login') }}"
                                    class="forgot-back-link">

                                    <i class="fas fa-arrow-left"></i>

                                    Quay lại đăng nhập

                                </a>

                            </div>

                            <div class="forgot-security-row">

                                <span>
                                    <i class="fas fa-lock"></i>
                                    Liên kết được bảo mật
                                </span>

                                <span>
                                    <i class="fas fa-shield-halved"></i>
                                    Không chia sẻ mật khẩu
                                </span>

                            </div>

                        </div>

                    </div>

                </div>
            </div>
        </div>
    </section>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('forgotPasswordForm');
            const emailInput = document.getElementById('email');
            const submitButton = document.getElementById('forgotSubmitButton');

            if (!form || !submitButton) {
                return;
            }

            form.addEventListener('submit', function(event) {
                const email = emailInput.value.trim();

                if (!email) {
                    event.preventDefault();

                    alert('Vui lòng nhập địa chỉ email.');

                    emailInput.focus();
                    return;
                }

                submitButton.disabled = true;

                submitButton.innerHTML =
                    '<i class="fas fa-spinner fa-spin me-2"></i>' +
                    'Đang gửi liên kết...';
            });
        });
    </script>
@endsection
