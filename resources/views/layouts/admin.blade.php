<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Admin Dashboard - Travelloula')</title>

    <link rel="icon" type="image/x-icon" href="/favicon.ico">

    {{-- Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    {{-- Bootstrap --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    {{-- Icons --}}
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

    {{-- CSS riêng --}}
    <link href="{{ asset('css/admin.css') }}" rel="stylesheet">
    <link href="{{ asset('css/admin-modern.css') }}" rel="stylesheet">
    <link href="{{ asset('css/dashboard-professional.css') }}" rel="stylesheet">
    <link href="{{ asset('css/admin-tables.css') }}" rel="stylesheet">
    <link href="{{ asset('css/admin-tables-fixed.css') }}" rel="stylesheet">
    <link href="{{ asset('css/admin-icons.css') }}" rel="stylesheet">

    <style>
        :root {
            --primary-50: #EEF2FF;
            --primary-500: #6366F1;
            --primary-600: #4F46E5;

            --gray-50: #F9FAFB;
            --gray-100: #F3F4F6;
            --gray-200: #E5E7EB;
            --gray-300: #D1D5DB;
            --gray-400: #9CA3AF;
            --gray-500: #6B7280;
            --gray-600: #4B5563;
            --gray-700: #374151;
            --gray-800: #1F2937;
            --gray-900: #111827;

            --success-50: #ECFDF5;
            --success-500: #10B981;
            --success-600: #059669;

            --warning-50: #FFFBEB;
            --warning-500: #F59E0B;
            --warning-600: #D97706;

            --error-50: #FEF2F2;
            --error-500: #EF4444;
            --error-600: #DC2626;

            --info-50: #EFF6FF;
            --info-500: #3B82F6;
            --info-600: #2563EB;

            --shadow-sm: 0 1px 2px 0 rgb(0 0 0 / 0.05);
            --shadow: 0 1px 3px 0 rgb(0 0 0 / 0.1), 0 1px 2px -1px rgb(0 0 0 / 0.1);
            --shadow-md: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1);

            --radius: 0.5rem;
            --radius-lg: 1rem;

            --sidebar-width: 280px;
            --header-height: 70px;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--gray-50);
            color: var(--gray-900);
            font-size: 14px;
            line-height: 1.6;
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
            box-shadow: 0 0 0 1px #e5e7eb;
            transition: all 0.3s ease;
        }

        .sidebar.collapsed {
            width: 80px;
        }

        .sidebar-header {
            padding: 1rem;
            border-bottom: 1px solid #e5e7eb;
        }

        .sidebar-logo {
            display: flex;
            align-items: center;
            gap: 1rem;
            text-decoration: none;
            padding: 1rem;
            border-radius: 0.75rem;
            color: inherit;
        }

        .sidebar-logo:hover {
            background: #f8fafc;
        }

        .logo-icon {
            width: 3rem;
            height: 3rem;
            background: white;
            border-radius: 0.75rem;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #3b82f6;
            font-size: 1.5rem;
            box-shadow: 0 2px 8px rgba(0, 0, 0, .1);
            flex-shrink: 0;
        }

        .logo-text {
            display: flex;
            flex-direction: column;
        }

        .logo-title {
            font-size: 1.4rem;
            font-weight: 800;
            color: #1f2937;
            line-height: 1;
        }

        .logo-subtitle {
            font-size: .75rem;
            font-weight: 600;
            color: #6b7280;
            text-transform: uppercase;
            letter-spacing: .05em;
            margin-top: 4px;
        }

        .sidebar.collapsed .logo-text,
        .sidebar.collapsed .nav-text,
        .sidebar.collapsed .nav-section-title,
        .sidebar.collapsed .badge {
            display: none;
        }

        .sidebar-nav {
            padding: 1rem 0;
        }

        .nav-section {
            margin-bottom: 1.5rem;
        }

        .nav-section-title {
            padding: 0 1.5rem .5rem;
            font-size: .75rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .05em;
            color: #9ca3af;
        }

        .nav-item {
            margin: .25rem 0;
        }

        .nav-link {
            display: flex;
            align-items: center;
            gap: .75rem;
            padding: .75rem 1.5rem;
            color: #6b7280;
            text-decoration: none;
            font-weight: 500;
            border-radius: .5rem;
            margin: .25rem 1rem;
            transition: all .25s ease;
        }

        .nav-link:hover {
            background: #f3f4f6;
            color: #374151;
            transform: translateX(4px);
        }

        .nav-link.active {
            background: #eff6ff;
            color: #3b82f6;
            font-weight: 700;
        }

        .nav-icon {
            width: 20px;
            height: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .main-content {
            margin-left: var(--sidebar-width);
            min-height: 100vh;
            transition: margin-left .3s ease;
        }

        .sidebar.collapsed + .main-content {
            margin-left: 80px;
        }

        .header {
            height: var(--header-height);
            background: #fff;
            border-bottom: 1px solid var(--gray-200);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 2rem;
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
            gap: 1rem;
        }

        .sidebar-toggle {
            background: none;
            border: none;
            color: var(--gray-600);
            font-size: 1.25rem;
            cursor: pointer;
            padding: .5rem;
            border-radius: var(--radius);
        }

        .sidebar-toggle:hover {
            background: var(--gray-100);
            color: var(--gray-900);
        }

        .breadcrumb {
            margin-bottom: 0;
        }

        .search-box {
            position: relative;
            width: 300px;
        }

        .search-input {
            width: 100%;
            padding: .5rem 1rem .5rem 2.5rem;
            border: 1px solid var(--gray-300);
            border-radius: 999px;
            font-size: .875rem;
            background: var(--gray-50);
        }

        .search-input:focus {
            outline: none;
            border-color: var(--primary-500);
            background: #fff;
            box-shadow: 0 0 0 3px rgba(99, 102, 241, .1);
        }

        .search-icon {
            position: absolute;
            left: .85rem;
            top: 50%;
            transform: translateY(-50%);
            color: var(--gray-400);
        }

        .header-btn {
            background: none;
            border: none;
            color: var(--gray-600);
            font-size: 1.125rem;
            cursor: pointer;
            padding: .5rem;
            border-radius: var(--radius);
            position: relative;
        }

        .header-btn:hover {
            background: var(--gray-100);
            color: var(--gray-900);
        }

        .notification-badge {
            position: absolute;
            top: .2rem;
            right: .2rem;
            background: var(--error-500);
            color: white;
            font-size: .625rem;
            border-radius: 999px;
            min-width: 1.1rem;
            height: 1.1rem;
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
            background: #3b82f6;
            color: #fff;
            font-weight: 800;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .user-avatar-img {
            object-fit: cover;
            border: 2px solid #e5e7eb;
        }

        .content {
            padding: 0;
        }

        .card {
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow);
            border: 1px solid var(--gray-200);
        }

        .btn {
            display: inline-flex;
            align-items: center;
            gap: .5rem;
            border-radius: var(--radius);
            font-weight: 600;
            white-space: nowrap;
        }

        .table th {
            background: var(--gray-50);
            font-weight: 700;
            color: var(--gray-700);
        }

        .dropdown-menu {
            min-width: 250px;
            border-radius: 12px;
        }

        .dropdown-item {
            padding: 10px 15px;
        }

        .dropdown-item:hover {
            background: #f3f4f6;
        }

        .sidebar::-webkit-scrollbar {
            width: 4px;
        }

        .sidebar::-webkit-scrollbar-track {
            background: #f3f4f6;
        }

        .sidebar::-webkit-scrollbar-thumb {
            background: #d1d5db;
            border-radius: 2px;
        }

        .sidebar::-webkit-scrollbar-thumb:hover {
            background: #9ca3af;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .fade-in {
            animation: fadeIn 0.3s ease-out;
        }

        @media (max-width: 1024px) {
            .sidebar {
                transform: translateX(-100%);
            }

            .sidebar.open {
                transform: translateX(0);
            }

            .main-content {
                margin-left: 0;
            }

            .sidebar.collapsed + .main-content {
                margin-left: 0;
            }

            .search-box {
                width: 220px;
            }
        }

        @media (max-width: 768px) {
            .header {
                padding: 0 1rem;
            }

            .search-box {
                display: none;
            }

            .header-actions {
                display: none;
            }
        }
    </style>

    @stack('styles')
    @yield('styles')
</head>

<body>
    <aside class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <a href="{{ route('Admin.dashboard') }}" class="sidebar-logo">
                <div class="logo-icon">
                    <i class="fas fa-plane"></i>
                </div>

                <div class="logo-text">
                    <span class="logo-title">Travelloula</span>
                    <span class="logo-subtitle">Admin</span>
                </div>
            </a>
        </div>

        <nav class="sidebar-nav">
            {{-- Tổng quan --}}
            <div class="nav-section">
                <div class="nav-section-title">Tổng quan</div>

                <div class="nav-item">
                    <a href="{{ route('Admin.dashboard') }}"
                       class="nav-link {{ request()->routeIs('Admin.dashboard') ? 'active' : '' }}">
                        <div class="nav-icon">
                            <i class="fas fa-tachometer-alt"></i>
                        </div>
                        <span class="nav-text">Dashboard</span>
                    </a>
                </div>

                <div class="nav-item">
                    <a href="{{ route('Admin.trang_dieu_khoans.edit') }}"
                       class="nav-link {{ request()->routeIs('Admin.trang_dieu_khoans*') ? 'active' : '' }}">
                        <div class="nav-icon">
                            <i class="fas fa-file-contract"></i>
                        </div>
                        <span class="nav-text">Điều khoản</span>
                    </a>
                </div>
            </div>

            {{-- Quản lý Tours --}}
            <div class="nav-section">
                <div class="nav-section-title">Quản lý Tours</div>

                <div class="nav-item">
                    <a href="{{ route('Admin.tours.index') }}"
                       class="nav-link {{ request()->routeIs('Admin.tours*') ? 'active' : '' }}">
                        <div class="nav-icon">
                            <i class="fas fa-map-marked-alt"></i>
                        </div>
                        <span class="nav-text">Danh sách Tours</span>
                    </a>
                </div>

                <div class="nav-item">
                    <a href="{{ route('Admin.lich_trinh_tours.index') }}"
                       class="nav-link {{ request()->routeIs('Admin.lich_trinh_tours*') ? 'active' : '' }}">
                        <div class="nav-icon">
                            <i class="fas fa-calendar-alt"></i>
                        </div>
                        <span class="nav-text">Quản lý lịch trình</span>
                    </a>
                </div>

                <div class="nav-item">
                    <a href="{{ route('Admin.lich-khoi-hanh.index') }}"
                       class="nav-link {{ request()->routeIs('Admin.lich-khoi-hanh*') ? 'active' : '' }}">
                        <div class="nav-icon">
                            <i class="fas fa-plane-departure"></i>
                        </div>
                        <span class="nav-text">Quản lý Khởi hành</span>
                    </a>
                </div>

                <div class="nav-item">
                    <a href="{{ route('Admin.gop-doan.index') }}"
                       class="nav-link {{ request()->routeIs('Admin.gop-doan*') ? 'active' : '' }}">
                        <div class="nav-icon">
                            <i class="fas fa-object-group"></i>
                        </div>
                        <span class="nav-text">Gộp đoàn</span>
                    </a>
                </div>

                <div class="nav-item">
                    <a href="{{ route('Admin.phuong-tiens.index') }}"
                       class="nav-link {{ request()->routeIs('Admin.phuong-tiens*') ? 'active' : '' }}">
                        <div class="nav-icon">
                            <i class="fas fa-bus"></i>
                        </div>
                        <span class="nav-text">Quản lý xe</span>
                    </a>
                </div>

                <div class="nav-item">
                    <a href="{{ route('Admin.nhat_ky_tours.index') }}"
                       class="nav-link {{ request()->routeIs('Admin.nhat_ky_tours*') ? 'active' : '' }}">
                        <div class="nav-icon">
                            <i class="fas fa-book"></i>
                        </div>
                        <span class="nav-text">Nhật ký Tours</span>
                    </a>
                </div>
            </div>

            {{-- Đặt tour & vận hành --}}
            <div class="nav-section">
                <div class="nav-section-title">Đặt tour & Vận hành</div>

                <div class="nav-item">
                    <a href="{{ route('Admin.quan_ly_dat_tour.index') }}"
                       class="nav-link {{ request()->routeIs('Admin.quan_ly_dat_tour*') ? 'active' : '' }}">
                        <div class="nav-icon">
                            <i class="fas fa-calendar-check"></i>
                        </div>
                        <span class="nav-text">Quản lý Đặt tour</span>
                    </a>
                </div>

                <div class="nav-item">
                    <a href="{{ route('Admin.phan-cong.index') }}"
                       class="nav-link {{ request()->routeIs('Admin.phan-cong*') ? 'active' : '' }}">
                        <div class="nav-icon">
                            <i class="fas fa-user-friends"></i>
                        </div>
                        <span class="nav-text">Quản lý Phân Công</span>
                    </a>
                </div>
            </div>

            {{-- Quản lý Người dùng --}}
            <div class="nav-section">
                <div class="nav-section-title">Quản lý Người dùng</div>

                <div class="nav-item">
                    <a href="{{ route('Admin.huong-dan-viens.index') }}"
                       class="nav-link {{ request()->routeIs('Admin.huong-dan-viens*') ? 'active' : '' }}">
                        <div class="nav-icon">
                            <i class="fas fa-users"></i>
                        </div>
                        <span class="nav-text">Quản lý HDV</span>
                    </a>
                </div>

                <div class="nav-item">
                    <a href="{{ route('Admin.users.index') }}"
                       class="nav-link {{ request()->routeIs('Admin.users*') ? 'active' : '' }}">
                        <div class="nav-icon">
                            <i class="fas fa-user"></i>
                        </div>
                        <span class="nav-text">Người dùng</span>
                    </a>
                </div>

                <div class="nav-item">
                    <a href="{{ route('Admin.khach-hang.index') }}"
                       class="nav-link {{ request()->routeIs('Admin.khach-hang*') ? 'active' : '' }}">
                        <div class="nav-icon">
                            <i class="fas fa-user-check"></i>
                        </div>
                        <span class="nav-text">Quản lý Khách hàng</span>
                    </a>
                </div>

                <div class="nav-item">
                    <a href="{{ route('Admin.vai-tros.index') }}"
                       class="nav-link {{ request()->routeIs('Admin.vai-tros*') ? 'active' : '' }}">
                        <div class="nav-icon">
                            <i class="fas fa-user-tag"></i>
                        </div>
                        <span class="nav-text">Vai trò</span>
                    </a>
                </div>

                <div class="nav-item">
                    <a href="{{ route('Admin.quyen-hans.index') }}"
                       class="nav-link {{ request()->routeIs('Admin.quyen-hans*') ? 'active' : '' }}">
                        <div class="nav-icon">
                            <i class="fas fa-key"></i>
                        </div>
                        <span class="nav-text">Quyền</span>
                    </a>
                </div>

                <div class="nav-item">
                    <a href="{{ route('Admin.role-permissions.matrix') }}"
                       class="nav-link {{ request()->routeIs('Admin.role-permissions*') ? 'active' : '' }}">
                        <div class="nav-icon">
                            <i class="fas fa-th"></i>
                        </div>
                        <span class="nav-text">Phân quyền</span>
                    </a>
                </div>
            </div>

            {{-- Nội dung --}}
            <div class="nav-section">
                <div class="nav-section-title">Nội dung</div>

                <div class="nav-item">
                    <a href="{{ route('Admin.banners.index') }}"
                       class="nav-link {{ request()->routeIs('Admin.banners*') ? 'active' : '' }}">
                        <div class="nav-icon">
                            <i class="fas fa-image"></i>
                        </div>
                        <span class="nav-text">Quản lý Banner</span>
                    </a>
                </div>

                <div class="nav-item">
                    <a href="{{ route('Admin.danh_mucs.index') }}"
                       class="nav-link {{ request()->routeIs('Admin.danh_mucs*') ? 'active' : '' }}">
                        <div class="nav-icon">
                            <i class="fas fa-tags"></i>
                        </div>
                        <span class="nav-text">Quản lý Danh mục</span>
                    </a>
                </div>

                <div class="nav-item">
                    <a href="{{ route('Admin.danh_gias.index') }}"
                       class="nav-link {{ request()->routeIs('Admin.danh_gias*') ? 'active' : '' }}">
                        <div class="nav-icon">
                            <i class="fas fa-star"></i>
                        </div>
                        <span class="nav-text">Quản lý Đánh giá</span>
                    </a>
                </div>
            </div>

            {{-- Thanh toán & báo cáo --}}
            <div class="nav-section">
                <div class="nav-section-title">Thanh toán & Báo cáo</div>

                <div class="nav-item">
                    <a href="{{ route('Admin.thanh_toans.index') }}"
                       class="nav-link {{ request()->routeIs('Admin.thanh_toans*') ? 'active' : '' }}">
                        <div class="nav-icon">
                            <i class="fas fa-credit-card"></i>
                        </div>
                        <span class="nav-text">Quản lý Thanh toán</span>
                    </a>
                </div>

                <div class="nav-item">
                    <a href="{{ route('Admin.thong_ke.index') }}"
                       class="nav-link {{ request()->routeIs('Admin.thong_ke*') ? 'active' : '' }}">
                        <div class="nav-icon">
                            <i class="fas fa-chart-bar"></i>
                        </div>
                        <span class="nav-text">Báo cáo & Thống kê</span>
                    </a>
                </div>
            </div>

            {{-- Hệ thống --}}
            <div class="nav-section">
                <div class="nav-section-title">Hệ thống</div>

                <div class="nav-item">
                    <a href="#" class="nav-link">
                        <div class="nav-icon">
                            <i class="fas fa-bell"></i>
                        </div>
                        <span class="nav-text">Thông báo</span>
                        <span class="badge bg-danger ms-auto">3</span>
                    </a>
                </div>

                <div class="nav-item">
                    <a href="#" class="nav-link">
                        <div class="nav-icon">
                            <i class="fas fa-headset"></i>
                        </div>
                        <span class="nav-text">Hỗ trợ khách hàng</span>
                        <span class="badge bg-warning ms-auto">5</span>
                    </a>
                </div>

                <div class="nav-item">
                    <a href="#" class="nav-link">
                        <div class="nav-icon">
                            <i class="fas fa-cog"></i>
                        </div>
                        <span class="nav-text">Cài đặt hệ thống</span>
                    </a>
                </div>
            </div>
        </nav>
    </aside>

    <div class="main-content">
        <header class="header">
            <div class="header-left">
                <button class="sidebar-toggle" id="sidebarToggle" type="button">
                    <i class="fas fa-bars"></i>
                </button>

                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{ route('Admin.dashboard') }}">Admin</a>
                        </li>
                        @yield('breadcrumb')
                    </ol>
                </nav>
            </div>

            <div class="header-right">
                <div class="search-box">
                    <i class="fas fa-search search-icon"></i>
                    <input type="text" class="search-input" placeholder="Tìm kiếm...">
                </div>

                <div class="header-actions">
                    <button class="header-btn" title="Thông báo" type="button">
                        <i class="fas fa-bell"></i>
                        <span class="notification-badge">3</span>
                    </button>

                    <button class="header-btn" title="Tin nhắn" type="button">
                        <i class="fas fa-envelope"></i>
                        <span class="notification-badge">5</span>
                    </button>

                    <button class="header-btn" title="Cài đặt" type="button">
                        <i class="fas fa-cog"></i>
                    </button>
                </div>

                <div class="user-menu dropdown">
                    <button class="btn border-0 bg-transparent p-0 d-flex align-items-center"
                            type="button"
                            data-bs-toggle="dropdown"
                            aria-expanded="false">

                        @if (Auth::check() && Auth::user()->avatar)
                            <img src="{{ asset('storage/' . Auth::user()->avatar) }}"
                                 alt="{{ Auth::user()->name }}"
                                 class="user-avatar-img">
                        @else
                            <div class="user-avatar">
                                {{ strtoupper(substr(Auth::user()->name ?? 'A', 0, 1)) }}
                            </div>
                        @endif
                    </button>

                    <ul class="dropdown-menu dropdown-menu-end shadow border-0">
                        <li class="px-3 py-2">
                            <div class="fw-bold">
                                {{ Auth::user()->name ?? 'Administrator' }}
                            </div>

                            <small class="text-muted">
                                {{ Auth::user()->email ?? '' }}
                            </small>
                        </li>

                        <li>
                            <hr class="dropdown-divider">
                        </li>

                        <li>
                            <a class="dropdown-item" href="{{ route('profile') }}">
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
            <div class="container-fluid p-4">
                @yield('content')
            </div>
        </main>
    </div>

    {{-- JS --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const sidebarToggle = document.getElementById('sidebarToggle');
            const sidebar = document.getElementById('sidebar');

            if (sidebarToggle && sidebar) {
                const isCollapsed = localStorage.getItem('adminSidebarCollapsed') === 'true';

                if (isCollapsed) {
                    sidebar.classList.add('collapsed');
                }

                sidebarToggle.addEventListener('click', function () {
                    if (window.innerWidth <= 1024) {
                        sidebar.classList.toggle('open');
                    } else {
                        sidebar.classList.toggle('collapsed');

                        const collapsed = sidebar.classList.contains('collapsed');
                        localStorage.setItem('adminSidebarCollapsed', collapsed);
                    }
                });

                document.addEventListener('click', function (e) {
                    if (window.innerWidth <= 1024) {
                        if (!sidebar.contains(e.target) && !sidebarToggle.contains(e.target)) {
                            sidebar.classList.remove('open');
                        }
                    }
                });
            }
        });
    </script>

    @yield('scripts')
    @stack('scripts')
</body>
</html>
