{{-- @extends('layouts.app')

@section('content')

{{-- <style>
*{
    margin:0;
    padding:0;
    box-sizing:border-box;
}

body{
    font-family:'Poppins',sans-serif;
    overflow-x:hidden;
}

.register-page{
    min-height:100vh;
    display:flex;
    background:url('https://images.unsplash.com/photo-1500530855697-b586d89ba3ee')
    center center/cover no-repeat;
    position:relative;
}

.register-page::before{
    content:'';
    position:absolute;
    inset:0;
    background:rgba(0,0,0,.5);
}

.left-side{
    flex:1;
    display:flex;
    align-items:center;
    justify-content:center;
    color:white;
    position:relative;
    z-index:2;
}

.brand{
    max-width:650px;
    padding:40px;
}

.brand h1{
    font-size:70px;
    font-weight:800;
    margin-bottom:15px;
}

.brand p{
    font-size:22px;
    opacity:.9;
}

.right-side{
    width:550px;
    background:rgba(255,255,255,.12);
    backdrop-filter:blur(20px);
    border-left:1px solid rgba(255,255,255,.15);
    position:relative;
    z-index:2;
    display:flex;
    align-items:center;
}

.register-card{
    width:100%;
    padding:50px;
}

.register-title{
    color:#fff;
    font-size:34px;
    font-weight:700;
    margin-bottom:10px;
}

.register-subtitle{
    color:rgba(255,255,255,.8);
    margin-bottom:30px;
}

.form-group{
    margin-bottom:18px;
}

.form-label{
    color:#fff;
    display:block;
    margin-bottom:8px;
    font-weight:500;
}

.form-control{
    width:100%;
    height:52px;
    border:none;
    border-radius:12px;
    padding:0 18px;
    background:rgba(255,255,255,.15);
    color:#fff;
    transition:.3s;
}

.form-control::placeholder{
    color:rgba(255,255,255,.7);
}

.form-control:focus{
    outline:none;
    background:rgba(255,255,255,.25);
    box-shadow:0 0 0 3px rgba(255,255,255,.15);
}

.btn-register{
    width:100%;
    height:55px;
    border:none;
    border-radius:12px;
    background:#fbbf24;
    color:#111827;
    font-size:16px;
    font-weight:700;
    cursor:pointer;
    transition:.3s;
}

.btn-register:hover{
    transform:translateY(-3px);
    box-shadow:0 15px 30px rgba(251,191,36,.4);
}

.text-danger{
    color:#fecaca;
    font-size:13px;
    margin-top:4px;
}

.alert{
    border-radius:12px;
}

.login-link{
    text-align:center;
    margin-top:20px;
    color:white;
}

.login-link a{
    color:#fbbf24;
    text-decoration:none;
    font-weight:600;
}

.login-link a:hover{
    text-decoration:underline;
}

@media(max-width:991px){
    .left-side{
        display:none;
    }

    .right-side{
        width:100%;
    }
}
</style>

<div class="register-page">

    <div class="left-side">
        <div class="brand">
            <h1>TravelLoula</h1>
            <p>
                Tạo tài khoản để bắt đầu hành trình khám phá
                những điểm đến tuyệt vời cùng TravelLoula.
            </p>
        </div>
    </div>

    <div class="right-side">

        <div class="register-card">

            <div class="register-title">
                Đăng ký tài khoản
            </div>

            <div class="register-subtitle">
                Chào mừng bạn đến với TravelLoula
            </div>

            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <form method="POST" action="{{ route('register.perform') }}">
                @csrf

                <div class="form-group">
                    <label class="form-label">Họ và tên</label>
                    <input type="text"
                           name="name"
                           class="form-control"
                           placeholder="Nhập họ tên"
                           value="{{ old('name') }}">
                    <div class="text-danger">{{ $errors->first('name') }}</div>
                </div>

                <div class="form-group">
                    <label class="form-label">Email</label>
                    <input type="email"
                           name="email"
                           class="form-control"
                           placeholder="Nhập email"
                           value="{{ old('email') }}">
                    <div class="text-danger">{{ $errors->first('email') }}</div>
                </div>

                <div class="form-group">
                    <label class="form-label">Mật khẩu</label>
                    <input type="password"
                           name="password"
                           class="form-control"
                           placeholder="Nhập mật khẩu">
                    <div class="text-danger">{{ $errors->first('password') }}</div>
                </div>

                <div class="form-group">
                    <label class="form-label">Điện thoại</label>
                    <input type="text"
                           name="phone"
                           class="form-control"
                           placeholder="Nhập số điện thoại"
                           value="{{ old('phone') }}">
                </div>

                <div class="form-group">
                    <label class="form-label">Địa chỉ</label>
                    <input type="text"
                           name="address"
                           class="form-control"
                           placeholder="Nhập địa chỉ"
                           value="{{ old('address') }}">
                </div>

                <button type="submit" class="btn-register">
                    ĐĂNG KÝ TÀI KHOẢN
                </button>

                <div class="login-link">
                    Đã có tài khoản?
                    <a href="{{ route('login') }}">
                        Đăng nhập ngay
                    </a>
                </div>

            </form>

        </div>

    </div>

</div> --}}

{{-- @endsection --}}
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Đăng ký - Travelloula</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>
        input:-webkit-autofill,
        input:-webkit-autofill:hover,
        input:-webkit-autofill:focus,
        input:-webkit-autofill:active {
            -webkit-box-shadow: 0 0 0px 1000px rgba(255, 255, 255, 0.15) inset !important;
            box-shadow: 0 0 0px 1000px rgba(255, 255, 255, 0.15) inset !important;
            -webkit-text-fill-color: #ffffff !important;
            caret-color: white;
            border: 1px solid rgba(255, 255, 255, 0.3) !important;
            transition: background-color 9999s ease-in-out 0s;
        }

        .glass input:focus {
            outline: none;
            border-color: #22d3ee;
            box-shadow:
                0 0 0 2px rgba(34, 211, 238, 0.3),
                0 0 20px rgba(34, 211, 238, 0.2);
        }

        @keyframes floatBg {
            0% {
                transform: translateY(0) scale(1);
            }

            50% {
                transform: translateY(-20px) scale(1.05);
            }

            100% {
                transform: translateY(0) scale(1);
            }
        }

        @keyframes shake {

            0%,
            100% {
                transform: translateX(0);
            }

            25% {
                transform: translateX(-6px);
            }

            75% {
                transform: translateX(6px);
            }
        }

        @keyframes glowPulse {
            0% {
                filter: drop-shadow(0 0 5px rgba(34, 211, 238, 0.3));
            }

            50% {
                filter: drop-shadow(0 0 20px rgba(34, 211, 238, 0.7));
            }

            100% {
                filter: drop-shadow(0 0 5px rgba(34, 211, 238, 0.3));
            }
        }

        .logo-glow {
            animation: glowPulse 3s ease-in-out infinite;
        }

        .animate-float {
            animation: floatBg 12s ease-in-out infinite;
        }

        .shake {
            animation: shake 0.3s;
        }

        .glass {
            background: linear-gradient(135deg,
                    rgba(255, 255, 255, 0.15),
                    rgba(255, 255, 255, 0.05));
            backdrop-filter: blur(25px);
            border: 1px solid rgba(255, 255, 255, 0.25);
        }
    </style>
</head>

<body class="h-screen overflow-hidden relative text-white">

    <!-- BACKGROUND -->
    <div class="absolute inset-0">
        <img src="https://images.unsplash.com/photo-1507525428034-b723cf961d3e"
            class="w-full h-full object-cover animate-float scale-110">
    </div>

    <div class="absolute inset-0 bg-gradient-to-br from-black/60 via-black/40 to-black/70"></div>

    <!-- LOGO -->
    <div class="absolute top-10 left-10 z-20">
        <div class="absolute -inset-2 bg-cyan-400/20 blur-xl rounded-full"></div>
        <a href="/">
            <img src="{{ asset('images/logo/logo_ngang.png') }}"
                class="relative h-12 md:h-12 lg:h-16 object-contain
                logo-glow
                hover:scale-105 hover:drop-shadow-[0_0_25px_rgba(34,211,238,0.9)]
                transition duration-300">
        </a>
    </div>

    <!-- TOAST -->
    <div id="toast" class="fixed top-6 right-6 hidden px-5 py-3 rounded-xl bg-red-500 text-white shadow-lg z-50">
    </div>

    <!-- MAIN -->
    <div class="relative z-10 flex items-center justify-center h-full px-6 py-2">
        <div class="w-full max-w-7xl grid md:grid-cols-2 gap-16 items-center">

            <!-- LEFT (đẩy sát trái hơn) -->
            <div class="hidden md:block ml-10">
                <h1 class="text-5xl font-bold leading-tight mb-4">
                    Khám phá thế giới<br> dễ hơn bao giờ hết
                </h1>

                <p class="text-white/80 text-lg mb-6">
                    Đặt vé, khách sạn và tour du lịch chỉ trong vài giây.
                </p>

                <div class="flex gap-4 text-white/70 text-sm">
                    <span>✈️ Flights</span>
                    <span>🏨 Hotels</span>
                    <span>🧭 Tours</span>
                </div>
            </div>

            <!-- CARD -->
            <div id="card"
                class="glass rounded-3xl p-8 shadow-2xl
                hover:shadow-cyan-400/20 hover:shadow-2xl transition duration-300">

                <h2 class="text-2xl font-bold text-center mb-2">
                    Tạo tài khoản
                </h2>

                <div class="w-16 h-1 bg-gradient-to-r from-blue-500 to-cyan-400 mx-auto mb-4 rounded-full"></div>

                <form method="POST" action="{{ route('register') }}" id="form">
                    @csrf

                    <!-- GRID 2 CỘT -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                        <!-- LEFT COLUMN -->
                        <div>
                            <!-- NAME -->
                            <div class="mb-4 relative">
                                <label class="text-sm text-white/80">Họ tên</label>
                                <i class="fa-solid fa-user absolute left-3 top-10 text-white/50"></i>
                                <input type="text" name="name"
                                    class="w-full pl-10 pr-4 py-3 mt-1 rounded-xl bg-white/10 text-white border border-white/20
                                    focus:border-cyan-400 focus:ring-2 focus:ring-cyan-400
                                    focus:bg-white/20 hover:bg-white/20 transition duration-300">
                            </div>

                            <!-- EMAIL -->
                            <div class="mb-4 relative">
                                <label class="text-sm text-white/80">Email</label>
                                <i class="fa-solid fa-envelope absolute left-3 top-10 text-white/50"></i>
                                <input type="email" name="email"
                                    class="w-full pl-10 pr-4 py-3 mt-1 rounded-xl bg-white/10 text-white border border-white/20
                                    focus:border-cyan-400 focus:ring-2 focus:ring-cyan-400
                                    focus:bg-white/20 hover:bg-white/20 transition duration-300">
                            </div>

                            <!-- PHONE -->
                            <div class="mb-4 relative">
                                <label class="text-sm text-white/80">Số điện thoại</label>
                                <i class="fa-solid fa-phone absolute left-3 top-10 text-white/50"></i>
                                <input type="text" name="phone"
                                    class="w-full pl-10 pr-4 py-3 mt-1 rounded-xl bg-white/10 text-white border border-white/20
                                    focus:border-cyan-400 focus:ring-2 focus:ring-cyan-400
                                    focus:bg-white/20 hover:bg-white/20 transition duration-300">
                            </div>
                        </div>

                        <!-- RIGHT COLUMN -->
                        <div>
                            <!-- ADDRESS -->
                            <div class="mb-4 relative">
                                <label class="text-sm text-white/80">Địa chỉ</label>
                                <i class="fa-solid fa-location-dot absolute left-3 top-10 text-white/50"></i>
                                <input type="text" name="address"
                                    class="w-full pl-10 pr-4 py-3 mt-1 rounded-xl bg-white/10 text-white border border-white/20
                                    focus:border-cyan-400 focus:ring-2 focus:ring-cyan-400
                                    focus:bg-white/20 hover:bg-white/20 transition duration-300">
                            </div>

                            <!-- PASSWORD -->
                            <div class="mb-2 relative">
                                <label class="text-sm text-white/80">Mật khẩu</label>

                                <i class="fa-solid fa-lock absolute left-3 top-10 text-white/50"></i>

                                <input type="password" name="password" id="password"
                                    oninput="checkPasswordStrength(); checkMatch();"
                                    class="w-full pl-10 pr-10 py-3 mt-1 rounded-xl bg-white/10 text-white border border-white/20">

                                <div class="h-1 w-full bg-white/10 rounded mt-2 overflow-hidden">
                                    <div id="strength-bar" class="h-full w-0 transition-all duration-300"></div>
                                </div>

                                <p id="strength-text" class="text-xs text-white/60 mt-1"></p>

                                <i class="fa-solid fa-eye absolute right-3 top-10 cursor-pointer text-white/60"
                                    onclick="togglePassword('password', this)"></i>
                            </div>

                            <!-- CONFIRM -->
                            <div class="mb-4 relative">
                                <label class="text-sm text-white/80">Xác nhận mật khẩu</label>

                                <i class="fa-solid fa-lock absolute left-3 top-10 text-white/50"></i>

                                <input type="password" name="password_confirmation" id="confirm"
                                    oninput="checkMatch();"
                                    class="w-full pl-10 pr-10 py-3 mt-1 rounded-xl bg-white/10 text-white border border-white/20">

                                <p id="match-text" class="text-xs mt-1"></p>

                                <i class="fa-solid fa-eye absolute right-3 top-10 cursor-pointer text-white/60"
                                    onclick="togglePassword('confirm', this)"></i>
                            </div>
                        </div>
                    </div>

                    <!-- TERMS -->
                    <div class="mb-6 text-sm text-white/80">
                        <label class="flex items-start gap-2">
                            <input type="checkbox" id="terms" class="mt-1 accent-cyan-400">
                            <span>
                                Tôi đồng ý với
                                <a href="#" class="text-cyan-300 hover:underline">Điều khoản và chính sách bảo
                                    mật</a>
                            </span>
                        </label>
                    </div>

                    <!-- BUTTON -->
                    <button id="submitBtn"
                        class="w-full py-3 rounded-xl bg-gradient-to-r from-blue-500 to-cyan-400
                        hover:scale-[1.03] hover:shadow-lg hover:shadow-cyan-400/30 transition duration-300
                        flex items-center justify-center gap-2">

                        <span id="btnText">Đăng ký</span>
                        <i id="btnLoader" class="fa-solid fa-spinner fa-spin hidden"></i>
                    </button>
                </form>

                <p class="mt-6 text-center text-sm text-white/70">
                    Đã có tài khoản?
                    <a href="/login" class="text-cyan-300 hover:underline">Đăng nhập ngay</a>
                </p>
            </div>
        </div>
    </div>

    <script>
        function showToast(message, type = "error") {
            const toast = document.getElementById("toast");

            toast.classList.remove("hidden");
            toast.innerText = message;

            toast.className = "fixed top-6 right-6 px-5 py-3 rounded-xl text-white shadow-lg z-50";

            if (type === "success") {
                toast.classList.add("bg-green-500");
            } else {
                toast.classList.add("bg-red-500");
            }

            setTimeout(() => {
                toast.classList.add("hidden");
            }, 3000);
        }
    </script>
    <script>
        function checkPasswordStrength() {
            const password = document.getElementById("password").value;
            const bar = document.getElementById("strength-bar");
            const text = document.getElementById("strength-text");

            let score = 0;

            // ❌ 1. CHẶN pattern yếu (rất quan trọng)
            const weakPatterns = [
                /123456/,
                /password/i,
                /qwerty/i,
                /(.)\1{3,}/ // 4 ký tự giống nhau liên tiếp
            ];

            if (weakPatterns.some(p => p.test(password))) {
                score = 0;
            } else {
                // 🔢 2. LENGTH (rất quan trọng trong real system)
                if (password.length >= 6) score++;
                if (password.length >= 8) score++;
                if (password.length >= 12) score++;

                // 🔤 3. LOWERCASE
                if (/[a-z]/.test(password)) score++;

                // 🔠 4. UPPERCASE
                if (/[A-Z]/.test(password)) score++;

                // 🔢 5. NUMBER
                if (/[0-9]/.test(password)) score++;

                // 🔣 6. SYMBOL
                if (/[^A-Za-z0-9]/.test(password)) score++;
            }

            // 🎯 MAX SCORE = 7

            let level = {
                width: "0%",
                color: "bg-red-500",
                label: "Rất yếu"
            };

            if (score <= 1) {
                level = {
                    width: "20%",
                    color: "bg-red-500",
                    label: "Rất yếu"
                };
            } else if (score === 2) {
                level = {
                    width: "35%",
                    color: "bg-orange-400",
                    label: "Yếu"
                };
            } else if (score === 3) {
                level = {
                    width: "50%",
                    color: "bg-yellow-400",
                    label: "Bình thường"
                };
            } else if (score === 4) {
                level = {
                    width: "65%",
                    color: "bg-lime-400",
                    label: "Khá"
                };
            } else if (score === 5) {
                level = {
                    width: "80%",
                    color: "bg-green-400",
                    label: "Mạnh"
                };
            } else {
                level = {
                    width: "100%",
                    color: "bg-green-600",
                    label: "Rất mạnh 🔥"
                };
            }

            bar.style.width = level.width;
            bar.className = "h-full transition-all duration-300 " + level.color;
            text.innerText = "Độ mạnh mật khẩu: " + level.label;
        }
    </script>

    <script>
        function checkMatch() {
            const p1 = document.getElementById("password").value;
            const p2 = document.getElementById("confirm").value;
            const text = document.getElementById("match-text");

            if (p2.length === 0) {
                text.innerText = "";
                text.className = "text-xs mt-1 text-white/60";
                return;
            }

            if (p1 === p2) {
                text.innerText = "✔ Mật khẩu khớp";
                text.className = "text-green-400 text-xs mt-1";
            } else {
                text.innerText = "✖ Mật khẩu không khớp";
                text.className = "text-red-400 text-xs mt-1";
            }
        }
    </script>

    <script>
        function togglePassword(id, el) {
            const input = document.getElementById(id);

            if (!input) return;

            if (input.type === "password") {
                input.type = "text";
                el.classList.remove("fa-eye");
                el.classList.add("fa-eye-slash");
            } else {
                input.type = "password";
                el.classList.remove("fa-eye-slash");
                el.classList.add("fa-eye");
            }
        }
    </script>

</body>

</html>
