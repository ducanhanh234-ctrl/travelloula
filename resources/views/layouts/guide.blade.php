<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'HDV Dashboard - Travelloula')</title>

    <meta name="description" content="HDV Dashboard - Travelloula">
    <meta name="theme-color" content="#16a34a">

    <link rel="icon" type="image/x-icon" href="/favicon.ico">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

    <style>
        :root {
            --primary-50: #ecfdf5;
            --primary-100: #d1fae5;
            --primary-500: #16a34a;
            --primary-600: #15803d;

            --gray-50: #f9fafb;
            --gray-100: #f3f4f6;
            --gray-200: #e5e7eb;
            --gray-300: #d1d5db;
            --gray-500: #6b7280;
            --gray-600: #4b5563;
            --gray-700: #374151;
            --gray-900: #111827;

            --error-500: #ef4444;

            --shadow-sm: 0 1px 2px rgba(0, 0, 0, .05);
            --shadow: 0 1px 3px rgba(0, 0, 0, .1);
            --shadow-md: 0 4px 10px rgba(0, 0, 0, .1);

            --sidebar-width: 280px;
            --header-height: 70px;
            --radius: 10px;
            --radius-lg: 16px;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: var(--gray-50);
            color: var(--gray-900);
            font-size: 14px;
        }

        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            width: var(--sidebar-width);
            height: 100vh;
            background: #fff;
            z-index: 1000;
            overflow-y: auto;
            border-right: 1px solid var(--gray-200);
            transition: .3s;
        }

        .sidebar.collapsed {
            width: 80px;
        }

        .sidebar-header {
            padding: 16px;
            border-bottom: 1px solid var(--gray-200);
        }

        .sidebar-logo {
            display: flex;
            align-items: center;
            gap: 14px;
            text-decoration: none;
            padding: 12px;
            border-radius: var(--radius);
            color: var(--gray-900);
        }

        .sidebar-logo:hover {
            background: var(--primary-50);
        }

        .logo-icon {
            width: 48px;
            height: 48px;
            border-radius: 14px;
            background: var(--primary-50);
            color: var(--primary-500);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 22px;
            flex-shrink: 0;
        }

        .logo-text {
            display: flex;
            flex-direction: column;
        }

        .logo-title {
            font-size: 22px;
            font-weight: 800;
            line-height: 1;
        }

        .logo-subtitle {
            margin-top: 4px;
            font-size: 12px;
            color: var(--gray-500);
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .05em;
        }

        .sidebar.collapsed .logo-text,
        .sidebar.collapsed .nav-text,
        .sidebar.collapsed .nav-section-title {
            display: none;
        }

        .sidebar-nav {
            padding: 18px 0;
        }

        .nav-section {
            margin-bottom: 24px;
        }

        .nav-section-title {
            padding: 0 24px 8px;
            font-size: 12px;
            color: #9ca3af;
            font-weight: 700;
            text-transform: uppercase;
        }

        .nav-item {
            margin: 4px 0;
        }

        .nav-link {
            display: flex;
            align-items: center;
            gap: 12px;
            margin: 4px 14px;
            padding: 12px 16px;
            color: var(--gray-500);
            text-decoration: none;
            border-radius: var(--radius);
            font-weight: 600;
            transition: .2s;
        }

        .nav-link:hover,
        .nav-link.active {
            background: var(--primary-50);
            color: var(--primary-500);
        }

        .nav-icon {
            width: 22px;
            text-align: center;
            flex-shrink: 0;
        }

        .main-content {
            margin-left: var(--sidebar-width);
            min-height: 100vh;
            transition: .3s;
        }

        .sidebar.collapsed+.main-content {
            margin-left: 80px;
        }

        .header {
            height: var(--header-height);
            background: #fff;
            border-bottom: 1px solid var(--gray-200);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 28px;
            position: sticky;
            top: 0;
            z-index: 100;
            box-shadow: var(--shadow-sm);
        }

        .header-left,
        .header-right,
        .header-actions {
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .sidebar-toggle {
            border: none;
            background: var(--gray-100);
            color: var(--gray-600);
            width: 40px;
            height: 40px;
            border-radius: 50%;
            font-size: 18px;
        }

        .sidebar-toggle:hover {
            background: var(--primary-50);
            color: var(--primary-500);
        }

        .page-title {
            font-size: 18px;
            font-weight: 800;
        }

        .search-box {
            position: relative;
            width: 280px;
        }

        .search-input {
            width: 100%;
            padding: 9px 14px 9px 38px;
            border: 1px solid var(--gray-300);
            border-radius: 999px;
            background: var(--gray-50);
        }

        .search-input:focus {
            outline: none;
            border-color: var(--primary-500);
            background: #fff;
        }

        .search-icon {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--gray-500);
        }

        .header-btn {
            border: none;
            background: var(--gray-100);
            color: var(--gray-600);
            width: 40px;
            height: 40px;
            border-radius: 50%;
            position: relative;
        }

        .header-btn:hover {
            background: var(--primary-50);
            color: var(--primary-500);
        }

        .notification-badge {
            position: absolute;
            top: -4px;
            right: -4px;
            background: var(--error-500);
            color: #fff;
            font-size: 11px;
            min-width: 18px;
            height: 18px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .user-avatar,
        .user-avatar-img {
            width: 42px;
            height: 42px;
            border-radius: 50%;
        }

        .user-avatar {
            background: var(--primary-500);
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 800;
        }

        .user-avatar-img {
            object-fit: cover;
            border: 2px solid var(--gray-200);
        }

        .content {
            padding: 28px;
        }

        .card {
            border: 1px solid var(--gray-200);
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow);
        }

        .card-header {
            background: #fff;
            border-bottom: 1px solid var(--gray-200);
            font-weight: 700;
        }

        .btn {
            border-radius: var(--radius);
            font-weight: 600;
        }

        .btn-primary {
            background: var(--primary-500);
            border-color: var(--primary-500);
        }

        .btn-primary:hover {
            background: var(--primary-600);
            border-color: var(--primary-600);
        }

        .dropdown-menu {
            min-width: 250px;
            border-radius: 14px;
        }

        .dropdown-item {
            padding: 10px 16px;
        }

        @media (max-width: 1024px) {
            .sidebar {
                transform: translateX(-100%);
            }

            .sidebar.open {
                transform: translateX(0);
            }

            .main-content,
            .sidebar.collapsed+.main-content {
                margin-left: 0;
            }

            .search-box {
                display: none;
            }
        }

        @media (max-width: 768px) {
            .header {
                padding: 0 16px;
            }

            .content {
                padding: 16px;
            }

            .page-title {
                font-size: 16px;
            }
        }

    </style>

    @yield('styles')
</head>

<body>

    <aside class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <a href="" class="sidebar-logo">
                <div class="logo-icon">
                    <i class="fas fa-route"></i>
                </div>

                <div class="logo-text">
                    <span class="logo-title">Travelloula</span>
                    <span class="logo-subtitle">Hướng dẫn viên</span>
                </div>
            </a>
        </div>

        <nav class="sidebar-nav">
            <div class="nav-section">
                <div class="nav-section-title">Tổng quan</div>

                <div class="nav-item">
                    <a href="" class="nav-link active">
                        <div class="nav-icon">
                            <i class="fas fa-tachometer-alt"></i>
                        </div>
                        <span class="nav-text">Dashboard HDV</span>
                    </a>
                </div>
            </div>

            <div class="nav-section">
                <div class="nav-section-title">Tour của tôi</div>

                <div class="nav-item">
                    <a href="{{ route('Guide.tour-phan-cong.index') }}" class="nav-link">
                        <div class="nav-icon">
                            <i class="fas fa-map-marked-alt"></i>
                        </div>
                        <span class="nav-text">Tour được phân công</span>
                    </a>
                </div>

                <div class="nav-item">
                    <a href="" class="nav-link">
                        <div class="nav-icon">
                            <i class="fas fa-calendar-check"></i>
                        </div>
                        <span class="nav-text">Lịch khởi hành</span>
                    </a>
                </div>

                <div class="nav-item">
                    <a href="" class="nav-link">
                        <div class="nav-icon">
                            <i class="fas fa-users"></i>
                        </div>
                        <span class="nav-text">Danh sách khách</span>
                    </a>
                </div>
            </div>

            <div class="nav-section">
                <div class="nav-section-title">Nghiệp vụ</div>

                <div class="nav-item">
                    <a href="{{ route('Guide.checkin.index') }}" class="nav-link">
                        <div class="nav-icon">
                            <i class="fas fa-clipboard-check"></i>
                        </div>
                        <span class="nav-text">Check-in khách</span>
                    </a>
                </div>

                <div class="nav-item">
                    <a href="{{ route('Guide.nhatky.index') }}"
                        class="nav-link {{ request()->routeIs('Guide.nhatky.*') ? 'active' : '' }}">
                        <div class="nav-icon">
                            <i class="fas fa-book"></i>
                        </div>
                        <span class="nav-text">Nhật ký hướng dẫn viên</span>
                    </a>
                </div>

                <div class="nav-item">
                    <a href="{{ route('Guide.baocaosuco.index') }}"
                        class="nav-link {{ request()->routeIs('Guide.baocaosuco.*') ? 'active' : '' }}">
                        <div class="nav-icon">
                            <i class="fas fa-exclamation-circle"></i>
                        </div>
                        <span class="nav-text">
                            Báo cáo sự cố
                        </span>
                    </a>
                </div>
            </div>

            <div class="nav-section">
                <div class="nav-section-title">Tài khoản</div>

                <div class="nav-item">
                    <a href="" class="nav-link">
                        <div class="nav-icon">
                            <i class="fas fa-user"></i>
                        </div>
                        <span class="nav-text">Hồ sơ cá nhân</span>
                    </a>
                </div>
            </div>
        </nav>
    </aside>

    <div class="main-content">
        <header class="header">
            <div class="header-left">
                <button class="sidebar-toggle" id="sidebarToggle">
                    <i class="fas fa-bars"></i>
                </button>

                <div class="page-title">
                    @yield('page-title', 'Trang hướng dẫn viên')
                </div>
            </div>

            <div class="header-right">
                <div class="search-box">
                    <i class="fas fa-search search-icon"></i>
                    <input type="text" class="search-input" placeholder="Tìm kiếm...">
                </div>

                <div class="header-actions">
                    <button class="header-btn" title="Thông báo">
                        <i class="fas fa-bell"></i>
                        <span class="notification-badge">3</span>
                    </button>

                    <button class="header-btn" title="Tin nhắn">
                        <i class="fas fa-envelope"></i>
                        <span class="notification-badge">5</span>
                    </button>
                </div>

                <div class="user-menu dropdown">

                    <button class=" btn border-0 bg-transparent p-0 d-flex align-items-center" type="button"
                        data-bs-toggle="dropdown" aria-expanded="false">

                        @if (Auth::check() && Auth::user()->avatar)
                            <img src="{{ asset('storage/' . Auth::user()->avatar) }}" alt="{{ Auth::user()->name }}"
                                class="user-avatar-img">
                        @else
                            <div class="user-avatar">
                                {{ strtoupper(substr(Auth::user()->name ?? 'H', 0, 1)) }}
                        </div> @endif

                    </button>

                    <ul class="dropdown-menu dropdown-menu-end shadow border-0">
                        <li class="px-3 py-2">
                            <div class="fw-bold">
                                {{ Auth::user()->name ?? 'Hướng dẫn viên' }}
                            </div>

                            <small class="text-muted">
                                {{ Auth::user()->email ?? '' }}
                            </small>
                        </li>

                        <li>
                            <hr class="dropdown-divider">
                        </li>

                        <li>
                            <a class="dropdown-item" href="">
                                <i class="fas fa-user me-2"></i>
                                Hồ sơ cá nhân
                            </a>
                        </li>

                        <li>
                            <hr class="dropdown-divider">
                        </li>

                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="dropdown-item text-danger">
                                    <i class="fas fa-sign-out-alt me-2"></i>
                                    Đăng xuất
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </header>

        <main class="content">
            <div class="container-fluid p-0">
                @yield('content')
            </div>
        </main>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sidebarToggle = document.getElementById('sidebarToggle');
            const sidebar = document.getElementById('sidebar');

            if (sidebarToggle && sidebar) {
                sidebarToggle.addEventListener('click', function() {
                    if (window.innerWidth <= 1024) {
                        sidebar.classList.toggle('open');
                    } else {
                        sidebar.classList.toggle('collapsed');
                    }
                });
            }
        });

    </script>

    @yield('scripts')
</body>

</html>
