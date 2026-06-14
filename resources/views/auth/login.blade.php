<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Đăng nhập - Travelloula</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>
        /* FIX AUTOFILL CHROME (EMAIL + PASSWORD + TEXT) */
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
                transform: translateY(0px) scale(1);
            }

            50% {
                transform: translateY(-20px) scale(1.05);
            }

            100% {
                transform: translateY(0px) scale(1);
            }
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
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

        .fade-in {
            animation: fadeInUp 0.8s ease-out;
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

<body class="h-screen overflow-hidden relative">

    <!-- BACKGROUND -->
    <div class="absolute inset-0">
        <img src="https://images.unsplash.com/photo-1507525428034-b723cf961d3e"
            class="w-full h-full object-cover animate-float scale-110">
    </div>

    <!-- ✅ UPGRADE BACKGROUND -->
    <div class="absolute inset-0 bg-gradient-to-br from-black/60 via-black/40 to-black/70"></div>

    <!-- LOGO TOP LEFT (GIỮ NGUYÊN) -->
    <div class="absolute top-10 left-10 z-20">
        <!-- glow nền -->
        <div class="absolute -inset-2 bg-cyan-400/20 blur-xl rounded-full"></div>

        <!-- logo -->
        <img src="{{ asset('images/logo/logo_ngang.png') }}"
            class="relative h-22 md:h-14 object-contain
               logo-glow
               drop-shadow-xl drop-shadow-[0_0_15px_rgba(34,211,238,0.5)]
               hover:scale-105 hover:drop-shadow-[0_0_25px_rgba(34,211,238,0.9)]
               transition duration-300">
    </div>

    <!-- MAIN -->
    <div class="relative z-10 flex items-center justify-center h-full px-6">

        <div class="w-full max-w-5xl grid md:grid-cols-2 gap-10 items-center">

            <!-- LEFT -->
            <div class="text-white hidden md:block fade-in">
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

            <!-- LOGIN CARD -->
            <div
                class="glass rounded-3xl p-8 md:p-10 shadow-2xl fade-in hover:shadow-cyan-400/20 hover:shadow-2xl transition">

                <!-- LOGO DỌC -->
                <div class="flex justify-center mt-0 mb-4">
                    <img src="{{ asset('images/logo/logo_doc.png') }}"
                        class="w-36 md:w-44 drop-shadow-lg hover:scale-105 hover:rotate-1 transition duration-300">
                </div>

                <h2 class="text-2xl font-bold text-center text-white mb-2">
                    Đăng nhập
                </h2>

                <!-- LINE DECOR -->
                <div class="w-16 h-1 bg-gradient-to-r from-blue-500 to-cyan-400 mx-auto mb-4 rounded-full"></div>

                <!-- ERROR -->
                @if ($errors->any())
                    <div class="mb-4 p-3 rounded-xl bg-red-500/20 text-red-200 text-sm border border-red-400/30">
                        <div class="font-semibold mb-1">Đăng nhập thất bại</div>
                        <div>{{ $errors->first() }}</div>
                    </div>
                @endif

                <!-- FORM -->
                <form method="POST" action="{{ route('login') }}" id="loginForm" autocomplete="off">
                    @csrf

                    <!-- EMAIL -->
                    <div class="mb-4 relative">
                        <label class="text-sm text-white/80">Email</label>
                        <i class="fa-solid fa-envelope absolute left-3 top-10 text-white/50"></i>

                        <input type="email" name="email" value="{{ old('email') }}" placeholder="Nhập email..."
                            class="w-full pl-10 pr-4 py-3 mt-1 rounded-xl bg-white/10 text-white
                        border border-white/20
                        focus:border-cyan-400 focus:ring-2 focus:ring-cyan-400
                        focus:bg-white/20 hover:bg-white/20
                        transition duration-300
                        @error('email') border-red-400 ring-red-400 @enderror">
                    </div>

                    <!-- PASSWORD -->
                    <div class="mb-4 relative">
                        <label class="text-sm text-white/80">Mật khẩu</label>
                        <i class="fa-solid fa-lock absolute left-3 top-10 text-white/50"></i>

                        <input type="password" name="password" id="password" placeholder="Nhập mật khẩu..."
                            class="w-full pl-10 pr-10 py-3 mt-1 rounded-xl bg-white/10 text-white
                        border border-white/20
                        focus:border-cyan-400 focus:ring-2 focus:ring-cyan-400
                        focus:bg-white/20 hover:bg-white/20
                        transition duration-300
                        @error('password') border-red-400 ring-red-400 @enderror">

                        <i class="fa-solid fa-eye absolute right-3 top-10 text-white/50 cursor-pointer"
                            onclick="togglePassword()"></i>
                    </div>

                    <!-- OPTIONS -->
                    <div class="flex justify-between text-sm text-white/70 mb-6">
                        <label class="flex items-center gap-2">
                            <input type="checkbox" name="remember" class="accent-cyan-400">
                            Ghi nhớ đăng nhập
                        </label>

                        <a href="#" class="hover:text-white">
                            Quên mật khẩu?
                        </a>
                    </div>

                    <!-- BUTTON -->
                    <button type="submit" id="loginBtn"
                        class="w-full py-3 rounded-xl bg-gradient-to-r from-blue-500 to-cyan-400
                    text-white font-semibold
                    hover:scale-[1.03] hover:shadow-lg hover:shadow-cyan-400/30
                    active:scale-95
                    transition duration-300 flex justify-center items-center gap-2">

                        <span id="btnText">Đăng nhập</span>

                        <svg id="spinner" class="hidden animate-spin h-5 w-5 text-white"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path>
                        </svg>
                    </button>
                </form>

                <p class="mt-6 text-center text-sm text-white/70">
                    Chưa có tài khoản?
                    <a href="/register" class="text-cyan-300 hover:underline">
                        Đăng ký ngay
                    </a>
                </p>
            </div>
        </div>
    </div>

    <script>
        function togglePassword() {
            const input = document.getElementById("password");
            input.type = input.type === "password" ? "text" : "password";
        }

        const form = document.getElementById("loginForm");
        const btn = document.getElementById("loginBtn");
        const spinner = document.getElementById("spinner");
        const text = document.getElementById("btnText");

        form.addEventListener("submit", function() {
            btn.disabled = true;
            btn.classList.add("opacity-70", "cursor-not-allowed");
            spinner.classList.remove("hidden");
            text.innerText = "Đang đăng nhập...";
        });
    </script>

</body>

</html>
