@extends('layouts.app')

@section('title', 'Đổi mật khẩu')

@section('content')
    <style>
        :root {
            --password-primary: #2563eb;
            --password-primary-dark: #1d4ed8;
            --password-secondary: #6847e6;
            --password-success: #0f9f72;
            --password-danger: #df4560;
            --password-warning: #e59b14;

            --password-text: #17345f;
            --password-text-soft: #64748f;
            --password-muted: #8b99af;
            --password-border: #dbe4f2;
        }

        .change-password-page {
            min-height: calc(100vh - 100px);
            position: relative;
            overflow: hidden;
            padding: 60px 0 80px;
            display: flex;
            align-items: center;
            background:
                radial-gradient(
                    circle at 8% 12%,
                    rgba(37, 99, 235, 0.13),
                    transparent 28%
                ),
                radial-gradient(
                    circle at 92% 85%,
                    rgba(104, 71, 230, 0.12),
                    transparent 30%
                ),
                linear-gradient(
                    135deg,
                    #f8faff 0%,
                    #edf4ff 48%,
                    #f8f7ff 100%
                );
        }

        .change-password-page::before,
        .change-password-page::after {
            content: "";
            position: absolute;
            border-radius: 50%;
            pointer-events: none;
        }

        .change-password-page::before {
            width: 350px;
            height: 350px;
            top: -205px;
            left: -150px;
            background: rgba(37, 99, 235, 0.07);
        }

        .change-password-page::after {
            width: 330px;
            height: 330px;
            right: -160px;
            bottom: -190px;
            background: rgba(104, 71, 230, 0.08);
        }

        .change-password-container {
            position: relative;
            z-index: 2;
        }

        .change-password-card {
            overflow: hidden;
            background: rgba(255, 255, 255, 0.97);
            border: 1px solid rgba(216, 226, 242, 0.96);
            border-radius: 26px;
            box-shadow:
                0 28px 70px rgba(30, 63, 120, 0.14),
                0 5px 18px rgba(30, 63, 120, 0.05);
            backdrop-filter: blur(12px);
        }

        /* Header */
        .change-password-header {
            min-height: 205px;
            position: relative;
            overflow: hidden;
            padding: 34px 38px;
            color: #fff;
            background:
                linear-gradient(
                    115deg,
                    #095bea 0%,
                    #1679ee 48%,
                    #6244e6 100%
                );
        }

        .change-password-header::before,
        .change-password-header::after {
            content: "";
            position: absolute;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.08);
        }

        .change-password-header::before {
            width: 280px;
            height: 280px;
            top: -175px;
            right: 90px;
        }

        .change-password-header::after {
            width: 185px;
            height: 185px;
            right: -55px;
            bottom: -100px;
        }

        .change-header-content {
            position: relative;
            z-index: 2;
        }

        .change-header-badge {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            padding: 7px 12px;
            margin-bottom: 15px;
            color: #fff;
            background: rgba(255, 255, 255, 0.14);
            border: 1px solid rgba(255, 255, 255, 0.25);
            border-radius: 22px;
            font-size: 11px;
            font-weight: 800;
            backdrop-filter: blur(8px);
        }

        .change-password-header h2 {
            color: #fff;
            margin-bottom: 8px;
            font-size: 29px;
            font-weight: 900;
            letter-spacing: -0.4px;
        }

        .change-password-header p {
            max-width: 610px;
            color: rgba(255, 255, 255, 0.84);
            margin-bottom: 0;
            font-size: 13px;
            line-height: 1.65;
        }

        /* Body */
        .change-password-body {
            position: relative;
            padding: 32px 38px 38px;
        }

        .security-notice {
            padding: 15px 17px;
            margin-bottom: 25px;
            display: flex;
            align-items: flex-start;
            gap: 11px;
            color: #315174;
            background: #f3f7ff;
            border: 1px solid #dbe6fa;
            border-radius: 14px;
            font-size: 11px;
            line-height: 1.6;
        }

        .security-notice i {
            color: var(--password-primary);
            margin-top: 2px;
        }

        .password-section {
            padding: 24px;
            background:
                linear-gradient(
                    145deg,
                    #ffffff 0%,
                    #fafcff 100%
                );
            border: 1px solid var(--password-border);
            border-radius: 18px;
            box-shadow: 0 7px 20px rgba(34, 65, 122, 0.05);
        }

        .password-section-heading {
            margin-bottom: 22px;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .password-section-icon {
            width: 44px;
            height: 44px;
            flex: 0 0 44px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--password-primary);
            background: #edf3ff;
            border: 1px solid #d2dfff;
            border-radius: 12px;
            font-size: 16px;
        }

        .password-section-heading h4 {
            color: var(--password-text);
            margin-bottom: 3px;
            font-size: 17px;
            font-weight: 900;
        }

        .password-section-heading p {
            color: var(--password-muted);
            margin-bottom: 0;
            font-size: 11px;
        }

        /* Input */
        .password-form-label {
            color: #2a4169;
            margin-bottom: 8px;
            font-size: 12px;
            font-weight: 800;
        }

        .password-required {
            color: var(--password-danger);
        }

        .password-input-wrapper {
            position: relative;
        }

        .password-input-icon {
            width: 46px;
            position: absolute;
            top: 1px;
            bottom: 1px;
            left: 1px;
            z-index: 4;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #7185a8;
            pointer-events: none;
        }

        .password-form-control {
            min-height: 51px;
            padding: 11px 48px 11px 45px;
            color: #263e65;
            background: #fbfcff;
            border: 1px solid #d7e0ee;
            border-radius: 12px;
            font-size: 13px;
            box-shadow: none;
            transition: all 0.2s ease;
        }

        .password-form-control:focus {
            color: #20375e;
            background: #fff;
            border-color: #3470e8;
            box-shadow: 0 0 0 4px rgba(52, 112, 232, 0.11);
        }

        .password-input-wrapper:focus-within .password-input-icon {
            color: var(--password-primary);
        }

        .password-form-control::placeholder {
            color: #a0adc1;
        }

        .password-form-control.is-invalid {
            border-color: var(--password-danger);
            background-image: none;
        }

        .password-toggle {
            width: 44px;
            position: absolute;
            top: 1px;
            right: 1px;
            bottom: 1px;
            z-index: 5;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #7485a2;
            background: transparent;
            border: 0;
            border-radius: 0 11px 11px 0;
            transition: all 0.18s ease;
        }

        .password-toggle:hover {
            color: var(--password-primary);
            background: #f0f5ff;
        }

        .password-hint {
            margin-top: 7px;
            color: var(--password-muted);
            font-size: 10px;
            line-height: 1.5;
        }

        .invalid-feedback {
            margin-top: 7px;
            font-size: 10px;
            font-weight: 700;
        }

        /* Strength */
        .password-strength {
            height: 6px;
            overflow: hidden;
            margin-top: 11px;
            background: #e8edf5;
            border-radius: 20px;
        }

        .password-strength-bar {
            width: 0;
            height: 100%;
            border-radius: 20px;
            transition: width 0.25s ease, background 0.25s ease;
        }

        .password-strength-text,
        .password-match-text {
            min-height: 18px;
            margin-top: 6px;
            font-size: 10px;
            font-weight: 700;
        }

        /* Buttons */
        .password-actions {
            margin-top: 25px;
            display: flex;
            justify-content: flex-end;
            gap: 11px;
            flex-wrap: wrap;
        }

        .password-btn-back,
        .password-btn-submit {
            min-height: 47px;
            padding: 10px 19px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 7px;
            border-radius: 11px;
            font-size: 12px;
            font-weight: 800;
            text-decoration: none;
            transition: all 0.2s ease;
        }

        .password-btn-back {
            color: #556987;
            background: #fff;
            border: 1px solid #cfdaea;
        }

        .password-btn-back:hover {
            color: var(--password-primary);
            background: #f4f7ff;
            border-color: #afc4ea;
            transform: translateY(-2px);
        }

        .password-btn-submit {
            min-width: 205px;
            color: #fff;
            background:
                linear-gradient(
                    105deg,
                    #2563eb 0%,
                    #3478ec 60%,
                    #6747e6 100%
                );
            border: 0;
            box-shadow: 0 10px 23px rgba(37, 99, 235, 0.23);
        }

        .password-btn-submit:hover {
            color: #fff;
            transform: translateY(-2px);
            box-shadow: 0 14px 29px rgba(37, 99, 235, 0.3);
        }

        .password-btn-submit:disabled {
            cursor: not-allowed;
            opacity: 0.7;
            transform: none;
            box-shadow: none;
        }

        .password-footer {
            margin-top: 24px;
            padding-top: 20px;
            display: flex;
            justify-content: center;
            gap: 20px;
            color: #7d8ca4;
            border-top: 1px solid #e5ebf4;
            font-size: 10px;
        }

        .password-footer span {
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        @media (max-width: 767.98px) {
            .change-password-page {
                padding: 30px 10px 45px;
                align-items: flex-start;
            }

            .change-password-header {
                min-height: 195px;
                padding: 27px 22px;
            }

            .change-password-header h2 {
                font-size: 24px;
            }

            .change-password-body {
                padding: 24px 20px 26px;
            }

            .password-section {
                padding: 19px;
            }

            .password-actions {
                flex-direction: column-reverse;
            }

            .password-btn-back,
            .password-btn-submit {
                width: 100%;
            }

            .password-footer {
                align-items: center;
                flex-direction: column;
                gap: 8px;
            }
        }

        @media (max-width: 479.98px) {
            .change-password-header h2 {
                font-size: 22px;
            }
        }
    </style>

    <section class="change-password-page">
        <div class="container change-password-container">
            <div class="row justify-content-center">
                <div class="col-xl-7 col-lg-8 col-md-10">

                    <div class="change-password-card">

                        {{-- Header --}}
                        <div class="change-password-header">
                            <div class="change-header-content">

                                <span class="change-header-badge">
                                    <i class="fas fa-shield-halved"></i>
                                    Bảo mật tài khoản
                                </span>

                                <h2>Đổi mật khẩu</h2>

                                <p>
                                    Cập nhật mật khẩu định kỳ để tăng cường bảo mật
                                    và bảo vệ thông tin tài khoản của bạn.
                                </p>

                            </div>
                        </div>

                        <div class="change-password-body">

                            <div class="security-notice">
                                <i class="fas fa-circle-info"></i>

                                <span>
                                    Mật khẩu mới nên có ít nhất 8 ký tự, bao gồm chữ hoa,
                                    chữ thường, chữ số và ký tự đặc biệt. Không nên sử dụng
                                    lại mật khẩu cũ.
                                </span>
                            </div>

                            <div class="password-section">

                                <div class="password-section-heading">

                                    <div class="password-section-icon">
                                        <i class="fas fa-key"></i>
                                    </div>

                                    <div>
                                        <h4>Thông tin mật khẩu</h4>

                                        <p>
                                            Xác nhận mật khẩu hiện tại trước khi thay đổi.
                                        </p>
                                    </div>

                                </div>

                                <form action="{{ route('client.profile.password.update') }}"
                                    method="POST"
                                    id="changePasswordForm">

                                    @csrf
                                    @method('PUT')

                                    {{-- Mật khẩu hiện tại --}}
                                    <div class="mb-3">

                                        <label for="current_password"
                                            class="password-form-label">

                                            Mật khẩu hiện tại
                                            <span class="password-required">*</span>

                                        </label>

                                        <div class="password-input-wrapper">

                                            <span class="password-input-icon">
                                                <i class="fas fa-lock"></i>
                                            </span>

                                            <input type="password"
                                                name="current_password"
                                                id="current_password"
                                                class="form-control password-form-control
                                                    @error('current_password') is-invalid @enderror"
                                                placeholder="Nhập mật khẩu hiện tại"
                                                autocomplete="current-password"
                                                required>

                                            <button type="button"
                                                class="password-toggle"
                                                data-password-toggle="current_password"
                                                aria-label="Hiện hoặc ẩn mật khẩu hiện tại">

                                                <i class="fas fa-eye"></i>

                                            </button>

                                        </div>

                                        @error('current_password')
                                            <div class="invalid-feedback d-block">
                                                <i class="fas fa-circle-exclamation me-1"></i>
                                                {{ $message }}
                                            </div>
                                        @enderror

                                    </div>

                                    {{-- Mật khẩu mới --}}
                                    <div class="mb-3">

                                        <label for="password"
                                            class="password-form-label">

                                            Mật khẩu mới
                                            <span class="password-required">*</span>

                                        </label>

                                        <div class="password-input-wrapper">

                                            <span class="password-input-icon">
                                                <i class="fas fa-key"></i>
                                            </span>

                                            <input type="password"
                                                name="password"
                                                id="password"
                                                class="form-control password-form-control
                                                    @error('password') is-invalid @enderror"
                                                placeholder="Nhập mật khẩu mới"
                                                autocomplete="new-password"
                                                minlength="8"
                                                required>

                                            <button type="button"
                                                class="password-toggle"
                                                data-password-toggle="password"
                                                aria-label="Hiện hoặc ẩn mật khẩu mới">

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
                                            Tối thiểu 8 ký tự. Nên kết hợp chữ hoa, chữ thường,
                                            số và ký tự đặc biệt.
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
                                    <div class="mb-2">

                                        <label for="password_confirmation"
                                            class="password-form-label">

                                            Xác nhận mật khẩu mới
                                            <span class="password-required">*</span>

                                        </label>

                                        <div class="password-input-wrapper">

                                            <span class="password-input-icon">
                                                <i class="fas fa-shield-halved"></i>
                                            </span>

                                            <input type="password"
                                                name="password_confirmation"
                                                id="password_confirmation"
                                                class="form-control password-form-control"
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

                                        <div class="password-match-text"
                                            id="passwordMatchText">
                                        </div>

                                    </div>

                                    <div class="password-actions">

                                        <a href="{{ route('client.profile.show') }}"
                                            class="password-btn-back">

                                            <i class="fas fa-arrow-left"></i>
                                            Quay lại hồ sơ

                                        </a>

                                        <button type="submit"
                                            class="password-btn-submit"
                                            id="changePasswordButton">

                                            <i class="fas fa-circle-check"></i>
                                            Cập nhật mật khẩu

                                        </button>

                                    </div>

                                </form>

                            </div>

                            <div class="password-footer">

                                <span>
                                    <i class="fas fa-lock text-primary"></i>
                                    Mật khẩu được mã hóa an toàn
                                </span>

                                <span>
                                    <i class="fas fa-shield-halved text-primary"></i>
                                    Không chia sẻ mật khẩu với người khác
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
            const form = document.getElementById('changePasswordForm');
            const currentPassword = document.getElementById('current_password');
            const password = document.getElementById('password');
            const confirmation = document.getElementById('password_confirmation');

            const strengthBar = document.getElementById('passwordStrengthBar');
            const strengthText = document.getElementById('passwordStrengthText');
            const matchText = document.getElementById('passwordMatchText');
            const submitButton = document.getElementById('changePasswordButton');

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

                        const hidden = input.type === 'password';

                        input.type = hidden ? 'text' : 'password';

                        icon.classList.toggle('fa-eye', !hidden);
                        icon.classList.toggle('fa-eye-slash', hidden);
                    });
                });

            function calculatePasswordStrength(value) {
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

                const score = calculatePasswordStrength(value);

                const levels = [
                    {
                        width: '20%',
                        background: '#df4560',
                        text: 'Mật khẩu rất yếu',
                        color: '#c93e56'
                    },
                    {
                        width: '40%',
                        background: '#e47737',
                        text: 'Mật khẩu yếu',
                        color: '#c6622f'
                    },
                    {
                        width: '60%',
                        background: '#e6a819',
                        text: 'Mật khẩu trung bình',
                        color: '#ad7b09'
                    },
                    {
                        width: '80%',
                        background: '#20a477',
                        text: 'Mật khẩu khá mạnh',
                        color: '#137a59'
                    },
                    {
                        width: '100%',
                        background: '#0f8a63',
                        text: 'Mật khẩu mạnh',
                        color: '#0a684b'
                    }
                ];

                const level = levels[Math.max(0, score - 1)];

                strengthBar.style.width = level.width;
                strengthBar.style.background = level.background;

                strengthText.textContent = level.text;
                strengthText.style.color = level.color;
            }

            function updatePasswordMatch() {
                if (!confirmation.value) {
                    matchText.textContent = '';
                    confirmation.classList.remove('is-valid', 'is-invalid');
                    return;
                }

                if (password.value === confirmation.value) {
                    matchText.textContent = 'Mật khẩu xác nhận đã khớp.';
                    matchText.style.color = '#0f8a63';

                    confirmation.classList.remove('is-invalid');
                    confirmation.classList.add('is-valid');
                } else {
                    matchText.textContent = 'Mật khẩu xác nhận chưa khớp.';
                    matchText.style.color = '#c93e56';

                    confirmation.classList.remove('is-valid');
                    confirmation.classList.add('is-invalid');
                }
            }

            password?.addEventListener('input', function() {
                updatePasswordStrength();
                updatePasswordMatch();
            });

            confirmation?.addEventListener('input', updatePasswordMatch);

            form?.addEventListener('submit', function(event) {
                if (!currentPassword.value.trim()) {
                    event.preventDefault();

                    alert('Vui lòng nhập mật khẩu hiện tại.');

                    currentPassword.focus();
                    return;
                }

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

                if (currentPassword.value === password.value) {
                    event.preventDefault();

                    alert('Mật khẩu mới không nên giống mật khẩu hiện tại.');

                    password.focus();
                    return;
                }

                submitButton.disabled = true;

                submitButton.innerHTML =
                    '<i class="fas fa-spinner fa-spin"></i>' +
                    ' Đang cập nhật...';
            });
        });
    </script>
@endsection
