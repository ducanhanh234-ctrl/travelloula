@extends('layouts.app')

@section('title', 'Đặt lại mật khẩu')

@section('content')
    <style>
        .reset-password-page {
            min-height: calc(100vh - 140px);
            position: relative;
            overflow: hidden;
            padding: 70px 0;
            display: flex;
            align-items: center;
            background:
                radial-gradient(
                    circle at 10% 20%,
                    rgba(36, 112, 255, 0.10),
                    transparent 30%
                ),
                radial-gradient(
                    circle at 90% 80%,
                    rgba(100, 72, 230, 0.10),
                    transparent 32%
                ),
                linear-gradient(
                    135deg,
                    #f7faff 0%,
                    #eef4ff 48%,
                    #f8f7ff 100%
                );
        }

        .reset-password-page::before,
        .reset-password-page::after {
            content: "";
            position: absolute;
            border-radius: 50%;
            pointer-events: none;
        }

        .reset-password-page::before {
            width: 330px;
            height: 330px;
            top: -175px;
            left: -130px;
            background: rgba(47, 95, 232, 0.07);
        }

        .reset-password-page::after {
            width: 270px;
            height: 270px;
            right: -120px;
            bottom: -135px;
            background: rgba(91, 70, 225, 0.08);
        }

        .reset-password-wrapper {
            position: relative;
            z-index: 2;
        }

        .reset-password-card {
            overflow: hidden;
            background: rgba(255, 255, 255, 0.97);
            border: 1px solid rgba(215, 225, 243, 0.95);
            border-radius: 24px;
            box-shadow:
                0 24px 60px rgba(28, 58, 115, 0.14),
                0 4px 14px rgba(28, 58, 115, 0.05);
        }

        .reset-card-top {
            min-height: 122px;
            position: relative;
            overflow: hidden;
            padding: 26px 30px;
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

        .reset-card-top::before,
        .reset-card-top::after {
            content: "";
            position: absolute;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.08);
        }

        .reset-card-top::before {
            width: 180px;
            height: 180px;
            top: -110px;
            right: 35px;
        }

        .reset-card-top::after {
            width: 120px;
            height: 120px;
            right: -40px;
            bottom: -63px;
        }

        .reset-top-content {
            position: relative;
            z-index: 2;
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .reset-icon-box {
            width: 58px;
            height: 58px;
            flex: 0 0 58px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            background: rgba(255, 255, 255, 0.15);
            border: 1px solid rgba(255, 255, 255, 0.28);
            border-radius: 16px;
            font-size: 24px;
            box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.15);
        }

        .reset-card-top h3 {
            color: #fff;
            margin-bottom: 5px;
            font-size: 24px;
            font-weight: 800;
        }

        .reset-card-top p {
            color: rgba(255, 255, 255, 0.83);
            margin-bottom: 0;
            font-size: 13px;
            line-height: 1.55;
        }

        .reset-card-body {
            padding: 32px;
        }

        .reset-notice {
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

        .reset-notice i {
            color: #2f67df;
            margin-top: 2px;
        }

        .reset-label {
            color: #243d68;
            margin-bottom: 8px;
            font-size: 13px;
            font-weight: 700;
        }

        .reset-input-group {
            position: relative;
        }

        .reset-input-icon {
            width: 46px;
            position: absolute;
            top: 1px;
            bottom: 1px;
            left: 1px;
            z-index: 5;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #6e84aa;
            background: transparent;
            border-radius: 11px 0 0 11px;
            pointer-events: none;
        }

        .reset-control {
            min-height: 50px;
            padding: 11px 48px 11px 45px;
            color: #263e65;
            background: #fbfcff;
            border: 1px solid #d7e0ef;
            border-radius: 12px;
            font-size: 13px;
            box-shadow: none;
            transition: all 0.2s ease;
        }

        .reset-control:focus {
            color: #1f365d;
            background: #fff;
            border-color: #3570e8;
            box-shadow: 0 0 0 4px rgba(53, 112, 232, 0.11);
        }

        .reset-control[readonly] {
            color: #61718c;
            background: #f3f6fb;
            cursor: not-allowed;
        }

        .reset-control::placeholder {
            color: #a0aec3;
        }

        .reset-control.is-invalid {
            border-color: #dc5368;
            background-image: none;
        }

        .password-toggle {
            width: 43px;
            position: absolute;
            top: 1px;
            right: 1px;
            bottom: 1px;
            z-index: 6;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #7183a2;
            background: transparent;
            border: 0;
            border-radius: 0 11px 11px 0;
            transition: all 0.18s ease;
        }

        .password-toggle:hover {
            color: #2468e8;
            background: #f0f5ff;
        }

        .password-hint {
            margin-top: 7px;
            color: #8491a8;
            font-size: 11px;
            line-height: 1.5;
        }

        .password-strength {
            height: 5px;
            overflow: hidden;
            margin-top: 10px;
            background: #e9eef6;
            border-radius: 20px;
        }

        .password-strength-bar {
            width: 0;
            height: 100%;
            border-radius: 20px;
            transition: width 0.25s ease, background 0.25s ease;
        }

        .password-strength-text {
            min-height: 18px;
            margin-top: 6px;
            font-size: 11px;
            font-weight: 600;
        }

        .match-message {
            min-height: 18px;
            margin-top: 6px;
            font-size: 11px;
            font-weight: 600;
        }

        .reset-submit-btn {
            min-height: 50px;
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

        .reset-submit-btn::before {
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

        .reset-submit-btn:hover {
            color: #fff;
            transform: translateY(-2px);
            box-shadow: 0 14px 28px rgba(34, 103, 231, 0.29);
        }

        .reset-submit-btn:hover::before {
            left: calc(100% + 40px);
        }

        .reset-submit-btn:disabled {
            cursor: not-allowed;
            opacity: 0.7;
            transform: none;
            box-shadow: none;
        }

        .reset-back-link {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            color: #52709d;
            font-size: 12px;
            font-weight: 700;
            text-decoration: none;
            transition: color 0.18s ease;
        }

        .reset-back-link:hover {
            color: #1d65e7;
        }

        .reset-security-row {
            margin-top: 24px;
            padding-top: 20px;
            display: flex;
            justify-content: center;
            gap: 18px;
            color: #8896ac;
            border-top: 1px solid #e7ecf4;
            font-size: 10px;
        }

        .reset-security-row span {
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
            .reset-password-page {
                padding: 35px 12px;
                align-items: flex-start;
            }

            .reset-card-top {
                min-height: auto;
                padding: 23px 20px;
            }

            .reset-top-content {
                align-items: flex-start;
            }

            .reset-icon-box {
                width: 50px;
                height: 50px;
                flex-basis: 50px;
                font-size: 20px;
            }

            .reset-card-top h3 {
                font-size: 20px;
            }

            .reset-card-body {
                padding: 24px 20px;
            }

            .reset-security-row {
                align-items: center;
                flex-direction: column;
                gap: 7px;
            }
        }
    </style>

    <section class="reset-password-page">
        <div class="container reset-password-wrapper">
            <div class="row justify-content-center">
                <div class="col-xl-5 col-lg-6 col-md-8">

                    <div class="reset-password-card">

                        {{-- Header --}}
                        <div class="reset-card-top">

                            <div class="reset-top-content">

                                <div class="reset-icon-box">
                                    <i class="fas fa-key"></i>
                                </div>

                                <div>
                                    <h3>Đặt lại mật khẩu</h3>

                                    <p>
                                        Tạo mật khẩu mới để tiếp tục sử dụng tài khoản Travelloula.
                                    </p>
                                </div>

                            </div>

                        </div>

                        {{-- Nội dung --}}
                        <div class="reset-card-body">

                            <div class="reset-notice">
                                <i class="fas fa-shield-halved"></i>

                                <span>
                                    Mật khẩu mới nên có ít nhất 8 ký tự và không nên trùng
                                    với mật khẩu bạn từng sử dụng.
                                </span>
                            </div>

                            <form action="{{ route('password.update') }}"
                                method="POST"
                                id="resetPasswordForm">

                                @csrf

                                <input type="hidden"
                                    name="token"
                                    value="{{ $token }}">

                                {{-- Email --}}
                                <div class="mb-3">

                                    <label for="email" class="reset-label">
                                        Địa chỉ email
                                    </label>

                                    <div class="reset-input-group">

                                        <span class="reset-input-icon">
                                            <i class="fas fa-envelope"></i>
                                        </span>

                                        <input type="email"
                                            name="email"
                                            id="email"
                                            class="form-control reset-control
                                                @error('email') is-invalid @enderror"
                                            value="{{ old('email', $email) }}"
                                            autocomplete="email"
                                            readonly
                                            required>

                                    </div>

                                    @error('email')
                                        <div class="invalid-feedback d-block">
                                            <i class="fas fa-circle-exclamation me-1"></i>
                                            {{ $message }}
                                        </div>
                                    @enderror

                                </div>

                                {{-- Mật khẩu mới --}}
                                <div class="mb-3">

                                    <label for="password" class="reset-label">
                                        Mật khẩu mới
                                    </label>

                                    <div class="reset-input-group">

                                        <span class="reset-input-icon">
                                            <i class="fas fa-lock"></i>
                                        </span>

                                        <input type="password"
                                            name="password"
                                            id="password"
                                            class="form-control reset-control
                                                @error('password') is-invalid @enderror"
                                            placeholder="Nhập mật khẩu mới"
                                            autocomplete="new-password"
                                            minlength="8"
                                            required>

                                        <button type="button"
                                            class="password-toggle"
                                            data-password-toggle="password"
                                            aria-label="Hiện hoặc ẩn mật khẩu">

                                            <i class="fas fa-eye"></i>

                                        </button>

                                    </div>

                                    @error('password')
                                        <div class="invalid-feedback d-block">
                                            <i class="fas fa-circle-exclamation me-1"></i>
                                            {{ $message }}
                                        </div>
                                    @enderror

                                    <div class="password-hint">
                                        Nên kết hợp chữ hoa, chữ thường, số và ký tự đặc biệt.
                                    </div>

                                    <div class="password-strength">
                                        <div class="password-strength-bar"
                                            id="passwordStrengthBar">
                                        </div>
                                    </div>

                                    <div class="password-strength-text"
                                        id="passwordStrengthText">
                                    </div>

                                </div>

                                {{-- Xác nhận mật khẩu --}}
                                <div class="mb-4">

                                    <label for="password_confirmation"
                                        class="reset-label">

                                        Xác nhận mật khẩu mới

                                    </label>

                                    <div class="reset-input-group">

                                        <span class="reset-input-icon">
                                            <i class="fas fa-lock"></i>
                                        </span>

                                        <input type="password"
                                            name="password_confirmation"
                                            id="password_confirmation"
                                            class="form-control reset-control"
                                            placeholder="Nhập lại mật khẩu mới"
                                            autocomplete="new-password"
                                            minlength="8"
                                            required>

                                        <button type="button"
                                            class="password-toggle"
                                            data-password-toggle="password_confirmation"
                                            aria-label="Hiện hoặc ẩn mật khẩu xác nhận">

                                            <i class="fas fa-eye"></i>

                                        </button>

                                    </div>

                                    <div class="match-message"
                                        id="passwordMatchMessage">
                                    </div>

                                </div>

                                {{-- Submit --}}
                                <button type="submit"
                                    class="btn reset-submit-btn"
                                    id="resetSubmitButton">

                                    <i class="fas fa-circle-check me-2"></i>
                                    Cập nhật mật khẩu

                                </button>

                            </form>

                            <div class="text-center mt-4">

                                <a href="{{ route('login') }}"
                                    class="reset-back-link">

                                    <i class="fas fa-arrow-left"></i>
                                    Quay lại đăng nhập

                                </a>

                            </div>

                            <div class="reset-security-row">

                                <span>
                                    <i class="fas fa-lock"></i>
                                    Mật khẩu được mã hóa
                                </span>

                                <span>
                                    <i class="fas fa-shield-halved"></i>
                                    Bảo vệ thông tin cá nhân
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
            const password = document.getElementById('password');
            const confirmation = document.getElementById('password_confirmation');
            const strengthBar = document.getElementById('passwordStrengthBar');
            const strengthText = document.getElementById('passwordStrengthText');
            const matchMessage = document.getElementById('passwordMatchMessage');
            const form = document.getElementById('resetPasswordForm');
            const submitButton = document.getElementById('resetSubmitButton');

            document
                .querySelectorAll('[data-password-toggle]')
                .forEach(function(button) {
                    button.addEventListener('click', function() {
                        const inputId = button.dataset.passwordToggle;
                        const input = document.getElementById(inputId);
                        const icon = button.querySelector('i');

                        if (!input) {
                            return;
                        }

                        const isPassword = input.type === 'password';

                        input.type = isPassword ? 'text' : 'password';

                        icon.classList.toggle('fa-eye', !isPassword);
                        icon.classList.toggle('fa-eye-slash', isPassword);
                    });
                });

            function calculateStrength(value) {
                let score = 0;

                if (value.length >= 8) {
                    score++;
                }

                if (value.length >= 12) {
                    score++;
                }

                if (/[a-z]/.test(value) && /[A-Z]/.test(value)) {
                    score++;
                }

                if (/\d/.test(value)) {
                    score++;
                }

                if (/[^A-Za-z0-9]/.test(value)) {
                    score++;
                }

                return score;
            }

            function updatePasswordStrength() {
                const value = password.value;

                if (!value) {
                    strengthBar.style.width = '0';
                    strengthBar.style.background = 'transparent';
                    strengthText.textContent = '';
                    return;
                }

                const score = calculateStrength(value);

                const levels = [
                    {
                        width: '20%',
                        background: '#dc5368',
                        text: 'Mật khẩu rất yếu',
                        textColor: '#c84257'
                    },
                    {
                        width: '40%',
                        background: '#e37445',
                        text: 'Mật khẩu yếu',
                        textColor: '#c65e34'
                    },
                    {
                        width: '60%',
                        background: '#e2aa23',
                        text: 'Mật khẩu trung bình',
                        textColor: '#ac7c0a'
                    },
                    {
                        width: '80%',
                        background: '#2a9d75',
                        text: 'Mật khẩu khá mạnh',
                        textColor: '#187757'
                    },
                    {
                        width: '100%',
                        background: '#147d5b',
                        text: 'Mật khẩu mạnh',
                        textColor: '#0c6749'
                    }
                ];

                const level = levels[Math.max(0, score - 1)];

                strengthBar.style.width = level.width;
                strengthBar.style.background = level.background;
                strengthText.textContent = level.text;
                strengthText.style.color = level.textColor;
            }

            function updatePasswordMatch() {
                if (!confirmation.value) {
                    matchMessage.textContent = '';
                    confirmation.classList.remove('is-valid', 'is-invalid');
                    return;
                }

                if (password.value === confirmation.value) {
                    matchMessage.textContent = 'Mật khẩu xác nhận đã khớp.';
                    matchMessage.style.color = '#087956';

                    confirmation.classList.remove('is-invalid');
                    confirmation.classList.add('is-valid');
                } else {
                    matchMessage.textContent = 'Mật khẩu xác nhận chưa khớp.';
                    matchMessage.style.color = '#c43d52';

                    confirmation.classList.remove('is-valid');
                    confirmation.classList.add('is-invalid');
                }
            }

            password.addEventListener('input', function() {
                updatePasswordStrength();
                updatePasswordMatch();
            });

            confirmation.addEventListener('input', updatePasswordMatch);

            form.addEventListener('submit', function(event) {
                if (password.value.length < 8) {
                    event.preventDefault();

                    alert('Mật khẩu mới phải có ít nhất 8 ký tự.');

                    password.focus();
                    return;
                }

                if (password.value !== confirmation.value) {
                    event.preventDefault();

                    alert('Mật khẩu xác nhận không khớp.');

                    confirmation.focus();
                    return;
                }

                submitButton.disabled = true;
                submitButton.innerHTML =
                    '<i class="fas fa-spinner fa-spin me-2"></i>Đang cập nhật...';
            });
        });
    </script>
@endsection
