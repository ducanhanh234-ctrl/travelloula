<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <meta
        name="csrf-token"
        content="{{ csrf_token() }}"
    >

    <title>
        @yield('title', 'Hướng dẫn viên - Travelloula')
    </title>

    <meta
        name="description"
        content="Hệ thống quản lý dành cho hướng dẫn viên Travelloula"
    >

    <meta
        name="theme-color"
        content="#315be8"
    >

    <link
        rel="icon"
        type="image/x-icon"
        href="/favicon.ico"
    >

    {{-- Fonts --}}
    <link
        rel="preconnect"
        href="https://fonts.googleapis.com"
    >

    <link
        rel="preconnect"
        href="https://fonts.gstatic.com"
        crossorigin
    >

    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet"
    >

    {{-- Bootstrap --}}
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

    {{-- Font Awesome --}}
    <link
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"
        rel="stylesheet"
    >

    {{-- Bootstrap Icons --}}
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"
        rel="stylesheet"
    >

    <style>
        :root {
            --guide-primary-50: #eef4ff;
            --guide-primary-100: #dce8ff;
            --guide-primary-500: #315be8;
            --guide-primary-600: #264ed4;
            --guide-purple: #5b4dea;

            --guide-gray-50: #f9fafb;
            --guide-gray-100: #f3f4f6;
            --guide-gray-200: #e5e7eb;
            --guide-gray-300: #d1d5db;
            --guide-gray-400: #9ca3af;
            --guide-gray-500: #6b7280;
            --guide-gray-600: #4b5563;
            --guide-gray-700: #374151;
            --guide-gray-800: #1f2937;
            --guide-gray-900: #111827;

            --guide-success-50: #ecfdf5;
            --guide-success-500: #10b981;
            --guide-success-600: #059669;

            --guide-warning-50: #fffbeb;
            --guide-warning-500: #f59e0b;
            --guide-warning-600: #d97706;

            --guide-danger-50: #fef2f2;
            --guide-danger-500: #ef4444;
            --guide-danger-600: #dc2626;

            --guide-info-50: #eff6ff;
            --guide-info-500: #3b82f6;

            --guide-shadow-sm:
                0 1px 2px rgba(0, 0, 0, 0.05);

            --guide-shadow:
                0 1px 3px rgba(0, 0, 0, 0.1),
                0 1px 2px rgba(0, 0, 0, 0.06);

            --guide-shadow-md:
                0 4px 12px rgba(28, 65, 139, 0.11);

            --guide-radius: 8px;
            --guide-radius-lg: 16px;

            --guide-sidebar-width: 280px;
            --guide-sidebar-collapsed-width: 80px;
            --guide-header-height: 70px;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            min-height: 100vh;
            color: var(--guide-gray-900);
            background: var(--guide-gray-50);
            font-family: 'Inter', sans-serif;
            font-size: 14px;
            line-height: 1.6;
        }

        button,
        input,
        select,
        textarea {
            font-family: inherit;
        }

        /* =========================
           SIDEBAR
        ========================= */

        .guide-sidebar {
            position: fixed;
            top: 0;
            left: 0;
            z-index: 1000;

            width: var(--guide-sidebar-width);
            height: 100vh;

            overflow-x: hidden;
            overflow-y: auto;

            background: #ffffff;
            border-right: 1px solid var(--guide-gray-200);
            box-shadow: 1px 0 12px rgba(28, 65, 139, 0.04);

            transition:
                width 0.3s ease,
                transform 0.3s ease;
        }

        .guide-sidebar.collapsed {
            width: var(--guide-sidebar-collapsed-width);
        }

        .guide-sidebar-header {
            padding: 16px;
            border-bottom: 1px solid var(--guide-gray-200);
        }

        .guide-sidebar-logo {
            min-height: 70px;
            padding: 12px;

            color: inherit;
            text-decoration: none;

            border-radius: 12px;

            display: flex;
            align-items: center;
            gap: 14px;

            transition:
                background-color 0.18s ease,
                transform 0.18s ease;
        }

        .guide-sidebar-logo:hover {
            color: inherit;
            background: var(--guide-primary-50);
            text-decoration: none;
        }

        .guide-logo-icon {
            width: 48px;
            height: 48px;
            flex-shrink: 0;

            color: #ffffff;
            background: linear-gradient(
                135deg,
                var(--guide-primary-500),
                var(--guide-purple)
            );

            border-radius: 13px;
            box-shadow: 0 6px 16px rgba(49, 91, 232, 0.22);

            font-size: 20px;

            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .guide-logo-text {
            min-width: 0;

            display: flex;
            flex-direction: column;

            transition: opacity 0.2s ease;
        }

        .guide-logo-title {
            color: #1f2937;
            font-size: 21px;
            font-weight: 800;
            line-height: 1.1;
            white-space: nowrap;
        }

        .guide-logo-subtitle {
            margin-top: 5px;

            color: var(--guide-gray-500);
            font-size: 10px;
            font-weight: 700;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            white-space: nowrap;
        }

        .guide-sidebar.collapsed .guide-logo-text,
        .guide-sidebar.collapsed .guide-nav-text,
        .guide-sidebar.collapsed .guide-nav-section-title,
        .guide-sidebar.collapsed .guide-nav-badge {
            display: none;
        }

        .guide-sidebar.collapsed .guide-sidebar-header {
            padding-right: 10px;
            padding-left: 10px;
        }

        .guide-sidebar.collapsed .guide-sidebar-logo {
            padding-right: 6px;
            padding-left: 6px;
            justify-content: center;
        }

        .guide-sidebar-navigation {
            padding: 18px 0 30px;
        }

        .guide-nav-section {
            margin-bottom: 24px;
        }

        .guide-nav-section-title {
            padding: 0 24px 8px;

            color: var(--guide-gray-400);
            font-size: 11px;
            font-weight: 750;
            letter-spacing: 0.06em;
            text-transform: uppercase;
            white-space: nowrap;
        }

        .guide-nav-item {
            margin: 3px 0;
        }

        .guide-nav-link {
            position: relative;

            min-height: 45px;
            margin: 3px 14px;
            padding: 11px 15px;

            color: var(--guide-gray-500);
            text-decoration: none;

            border: 1px solid transparent;
            border-radius: 10px;

            font-size: 13px;
            font-weight: 600;

            display: flex;
            align-items: center;
            gap: 12px;

            transition:
                color 0.18s ease,
                background-color 0.18s ease,
                border-color 0.18s ease,
                transform 0.18s ease;
        }

        .guide-nav-link:hover {
            color: var(--guide-primary-500);
            background: var(--guide-primary-50);
            border-color: #d8e4ff;
            text-decoration: none;
            transform: translateX(3px);
        }

        .guide-nav-link.active {
            color: var(--guide-primary-500);
            background: linear-gradient(
                90deg,
                #edf4ff,
                #f2f0ff
            );

            border-color: #cfddff;
            font-weight: 750;
        }

        .guide-nav-link.active::before {
            position: absolute;
            top: 9px;
            bottom: 9px;
            left: -14px;

            width: 4px;
            content: "";

            background: linear-gradient(
                180deg,
                var(--guide-primary-500),
                var(--guide-purple)
            );

            border-radius: 0 8px 8px 0;
        }

        .guide-nav-icon {
            width: 22px;
            height: 22px;
            flex-shrink: 0;

            font-size: 14px;

            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .guide-nav-text {
            min-width: 0;

            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .guide-sidebar.collapsed .guide-nav-link {
            margin-right: 12px;
            margin-left: 12px;
            padding-right: 12px;
            padding-left: 12px;
            justify-content: center;
        }

        .guide-sidebar.collapsed .guide-nav-link.active::before {
            left: -12px;
        }

        .guide-nav-badge {
            min-width: 22px;
            height: 21px;
            margin-left: auto;
            padding: 0 6px;

            color: #ffffff;
            background: var(--guide-danger-500);

            border-radius: 999px;

            font-size: 9px;
            font-weight: 750;

            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        /* Scrollbar sidebar */
        .guide-sidebar::-webkit-scrollbar {
            width: 5px;
        }

        .guide-sidebar::-webkit-scrollbar-track {
            background: #f3f4f6;
        }

        .guide-sidebar::-webkit-scrollbar-thumb {
            background: #d1d5db;
            border-radius: 999px;
        }

        .guide-sidebar::-webkit-scrollbar-thumb:hover {
            background: #9ca3af;
        }

        /* =========================
           MAIN CONTENT
        ========================= */

        .guide-main-content {
            min-height: 100vh;
            margin-left: var(--guide-sidebar-width);

            transition: margin-left 0.3s ease;
        }

        .guide-sidebar.collapsed + .guide-main-content {
            margin-left: var(--guide-sidebar-collapsed-width);
        }

        /* =========================
           HEADER
        ========================= */

        .guide-header {
            position: sticky;
            top: 0;
            z-index: 100;

            height: var(--guide-header-height);
            padding: 0 32px;

            background: rgba(255, 255, 255, 0.96);
            border-bottom: 1px solid var(--guide-gray-200);
            box-shadow: var(--guide-shadow-sm);
            backdrop-filter: blur(10px);

            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
        }

        .guide-header-left,
        .guide-header-right,
        .guide-header-actions {
            min-width: 0;

            display: flex;
            align-items: center;
        }

        .guide-header-left {
            gap: 16px;
        }

        .guide-header-right {
            gap: 14px;
        }

        .guide-header-actions {
            gap: 7px;
        }

        .guide-sidebar-toggle {
            width: 40px;
            height: 40px;
            flex-shrink: 0;
            padding: 0;

            color: var(--guide-gray-600);
            background: #ffffff;

            border: 1px solid var(--guide-gray-200);
            border-radius: 9px;

            font-size: 16px;
            cursor: pointer;

            display: inline-flex;
            align-items: center;
            justify-content: center;

            transition:
                color 0.18s ease,
                background-color 0.18s ease,
                border-color 0.18s ease,
                transform 0.18s ease;
        }

        .guide-sidebar-toggle:hover {
            color: var(--guide-primary-500);
            background: var(--guide-primary-50);
            border-color: #cfddff;
            transform: translateY(-1px);
        }

        /* Breadcrumb */
        .guide-breadcrumb-wrapper {
            min-width: 0;
        }

        .guide-breadcrumb {
            margin: 0;
            padding: 0;

            background: transparent;

            font-size: 12px;

            display: flex;
            align-items: center;
            flex-wrap: wrap;
        }

        .guide-breadcrumb .breadcrumb-item {
            color: var(--guide-gray-500);
        }

        .guide-breadcrumb .breadcrumb-item a {
            color: var(--guide-primary-500);
            font-weight: 650;
            text-decoration: none;
        }

        .guide-breadcrumb .breadcrumb-item a:hover {
            color: var(--guide-primary-600);
            text-decoration: underline;
        }

        .guide-breadcrumb .breadcrumb-item.active {
            max-width: 350px;

            overflow: hidden;

            color: var(--guide-gray-600);
            font-weight: 650;

            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .guide-search-box {
            position: relative;
            width: 285px;
        }

        .guide-search-icon {
            position: absolute;
            top: 50%;
            left: 13px;
            z-index: 2;

            color: var(--guide-gray-400);
            font-size: 12px;

            pointer-events: none;
            transform: translateY(-50%);
        }

        .guide-search-input {
            width: 100%;
            min-height: 40px;
            padding: 9px 14px 9px 37px;

            color: var(--guide-gray-700);
            background: var(--guide-gray-50);

            border: 1px solid var(--guide-gray-300);
            border-radius: 999px;

            font-size: 12px;
            outline: none;

            transition:
                border-color 0.18s ease,
                background-color 0.18s ease,
                box-shadow 0.18s ease;
        }

        .guide-search-input::placeholder {
            color: var(--guide-gray-400);
        }

        .guide-search-input:focus {
            background: #ffffff;
            border-color: var(--guide-primary-500);
            box-shadow: 0 0 0 3px rgba(49, 91, 232, 0.1);
        }

        .guide-header-button {
            position: relative;

            width: 39px;
            height: 39px;
            flex-shrink: 0;
            padding: 0;

            color: var(--guide-gray-600);
            background: #ffffff;

            border: 1px solid var(--guide-gray-200);
            border-radius: 9px;

            font-size: 14px;
            cursor: pointer;

            display: inline-flex;
            align-items: center;
            justify-content: center;

            transition:
                color 0.18s ease,
                background-color 0.18s ease,
                border-color 0.18s ease,
                transform 0.18s ease;
        }

        .guide-header-button:hover {
            color: var(--guide-primary-500);
            background: var(--guide-primary-50);
            border-color: #cfddff;
            transform: translateY(-1px);
        }

        .guide-notification-badge {
            position: absolute;
            top: -5px;
            right: -5px;

            min-width: 18px;
            height: 18px;
            padding: 0 4px;

            color: #ffffff;
            background: var(--guide-danger-500);

            border: 2px solid #ffffff;
            border-radius: 999px;

            font-size: 8px;
            font-weight: 800;

            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        /* User */
        .guide-user-button {
            padding: 0 !important;

            background: transparent !important;
            border: none !important;
            box-shadow: none !important;
        }

        .guide-user-avatar,
        .guide-user-avatar-image {
            width: 42px;
            height: 42px;
            flex-shrink: 0;

            border-radius: 50%;
        }

        .guide-user-avatar {
            color: #ffffff;
            background: linear-gradient(
                135deg,
                var(--guide-primary-500),
                var(--guide-purple)
            );

            border: 2px solid #e0e8fa;
            box-shadow: 0 4px 12px rgba(49, 91, 232, 0.18);

            font-size: 14px;
            font-weight: 800;

            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .guide-user-avatar-image {
            object-fit: cover;

            border: 2px solid #dbe5f6;
            box-shadow: 0 4px 12px rgba(28, 65, 139, 0.12);
        }

        .guide-user-dropdown {
            min-width: 260px;
            padding: 8px;

            border: 1px solid var(--guide-gray-200) !important;
            border-radius: 13px;
            box-shadow: 0 12px 35px rgba(28, 65, 139, 0.14) !important;
        }

        .guide-user-dropdown .dropdown-item {
            padding: 10px 12px;

            color: var(--guide-gray-700);

            border-radius: 8px;

            font-size: 12px;
            font-weight: 600;
        }

        .guide-user-dropdown .dropdown-item:hover {
            color: var(--guide-primary-500);
            background: var(--guide-primary-50);
        }

        .guide-user-dropdown .dropdown-item.text-danger:hover {
            color: var(--guide-danger-600) !important;
            background: var(--guide-danger-50);
        }

        /* =========================
           CONTENT
        ========================= */

        .guide-content {
            min-height: calc(100vh - var(--guide-header-height));
        }

        .guide-content-container {
            padding: 24px;
        }

        /* Style chung giống Admin */
        .guide-content .card {
            overflow: hidden;

            background: #ffffff;
            border: 1px solid #d8e4f6;
            border-radius: var(--guide-radius-lg);
            box-shadow: var(--guide-shadow);

            transition: box-shadow 0.18s ease;
        }

        .guide-content .card:hover {
            box-shadow: var(--guide-shadow-md);
        }

        .guide-content .card-header {
            min-height: 56px;
            padding: 15px 18px;

            color: #24417d;
            background: #f1f6ff;

            border-bottom: 1px solid #dce6f5;

            font-size: 14px;
            font-weight: 750;

            display: flex;
            align-items: center;
        }

        .guide-content .card-body {
            padding: 20px;
        }

        .guide-content .card-footer {
            padding: 15px 20px;

            background: #fafcff;
            border-top: 1px solid #dce6f5;
        }

        .guide-content .btn {
            min-height: 39px;
            padding: 8px 14px;

            border-radius: var(--guide-radius);

            font-size: 12px;
            font-weight: 700;

            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 7px;

            transition:
                background-color 0.18s ease,
                border-color 0.18s ease,
                color 0.18s ease,
                transform 0.18s ease;
        }

        .guide-content .btn:hover {
            transform: translateY(-1px);
        }

        .guide-content .btn-primary {
            color: #ffffff;
            background: linear-gradient(
                135deg,
                var(--guide-primary-500),
                var(--guide-purple)
            );

            border-color: var(--guide-primary-500);
            box-shadow: 0 5px 14px rgba(49, 91, 232, 0.2);
        }

        .guide-content .btn-primary:hover {
            color: #ffffff;
            background: linear-gradient(
                135deg,
                var(--guide-primary-600),
                #4c40d7
            );

            border-color: var(--guide-primary-600);
        }

        .guide-content .btn-secondary {
            color: #53698f;
            background: #ffffff;
            border-color: #ccd9ed;
        }

        .guide-content .btn-secondary:hover {
            color: #304d83;
            background: #edf3fb;
            border-color: #b9c9e0;
        }

        .guide-content .form-control,
        .guide-content .form-select {
            min-height: 42px;

            color: #344563;
            background-color: #ffffff;

            border: 1px solid #cfdaec;
            border-radius: 9px;

            font-size: 13px;
            box-shadow: none;
        }

        .guide-content .form-control:focus,
        .guide-content .form-select:focus {
            border-color: #4f78eb;
            box-shadow: 0 0 0 4px rgba(49, 91, 232, 0.1);
        }

        .guide-content .table {
            margin-bottom: 0;
            vertical-align: middle;
        }

        .guide-content .table thead th {
            padding: 13px 14px;

            color: #24417d;
            background: #f7f9fd;

            border-top: none;
            border-bottom: 1px solid #d8e5f8;

            font-size: 10px;
            font-weight: 750;
            letter-spacing: 0.025em;
            text-transform: uppercase;
            white-space: nowrap;
        }

        .guide-content .table tbody td {
            padding: 13px 14px;

            color: #4d5d7d;

            border-bottom: 1px solid #e8eef8;

            font-size: 12px;
            vertical-align: middle;
        }

        .guide-content .table tbody tr:hover {
            background: #f3f7ff;
            box-shadow: inset 3px 0 0 var(--guide-primary-500);
        }

        .guide-content .pagination {
            margin-bottom: 0;
            gap: 4px;
        }

        .guide-content .page-link {
            min-width: 34px;
            height: 34px;
            padding: 6px 10px;

            color: #3158ce;
            background: #ffffff;

            border: 1px solid #d6e1f2;
            border-radius: 7px !important;

            font-size: 12px;
            box-shadow: none;

            display: flex;
            align-items: center;
            justify-content: center;
        }

        .guide-content .page-item.active .page-link {
            color: #ffffff;
            background: linear-gradient(
                135deg,
                var(--guide-primary-500),
                var(--guide-purple)
            );

            border-color: var(--guide-primary-500);
        }

        /* Animation */
        @keyframes guideFadeIn {
            from {
                opacity: 0;
                transform: translateY(8px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .fade-in {
            animation: guideFadeIn 0.3s ease-out;
        }

        /* Sidebar overlay mobile */
        .guide-sidebar-overlay {
            position: fixed;
            inset: 0;
            z-index: 999;

            display: none;

            background: rgba(17, 24, 39, 0.45);
            backdrop-filter: blur(2px);
        }

        .guide-sidebar-overlay.show {
            display: block;
        }

        /* =========================
           RESPONSIVE
        ========================= */

        @media (max-width: 1100px) {
            .guide-search-box {
                width: 220px;
            }
        }

        @media (max-width: 1024px) {
            .guide-sidebar {
                width: var(--guide-sidebar-width);
                transform: translateX(-100%);
            }

            .guide-sidebar.open {
                transform: translateX(0);
            }

            .guide-sidebar.collapsed {
                width: var(--guide-sidebar-width);
            }

            .guide-sidebar.collapsed .guide-logo-text,
            .guide-sidebar.collapsed .guide-nav-text,
            .guide-sidebar.collapsed .guide-nav-section-title,
            .guide-sidebar.collapsed .guide-nav-badge {
                display: initial;
            }

            .guide-sidebar.collapsed .guide-logo-text {
                display: flex;
            }

            .guide-sidebar.collapsed .guide-sidebar-logo,
            .guide-sidebar.collapsed .guide-nav-link {
                justify-content: flex-start;
            }

            .guide-main-content,
            .guide-sidebar.collapsed + .guide-main-content {
                margin-left: 0;
            }

            .guide-search-box {
                display: none;
            }
        }

        @media (max-width: 768px) {
            .guide-header {
                padding: 0 16px;
            }

            .guide-header-actions {
                display: none;
            }

            .guide-breadcrumb .breadcrumb-item:first-child {
                display: none;
            }

            .guide-breadcrumb .breadcrumb-item + .breadcrumb-item::before {
                display: none;
            }

            .guide-breadcrumb .breadcrumb-item.active {
                max-width: 220px;
                color: #24417d;
                font-size: 13px;
                font-weight: 750;
            }

            .guide-content-container {
                padding: 16px;
            }
        }

        @media (max-width: 480px) {
            .guide-header {
                gap: 10px;
            }

            .guide-header-left {
                gap: 10px;
            }

            .guide-user-avatar,
            .guide-user-avatar-image {
                width: 38px;
                height: 38px;
            }

            .guide-sidebar {
                width: min(280px, 86vw);
            }
        }
    </style>

    @stack('styles')
    @yield('styles')
</head>

<body>
    {{-- Sidebar --}}
    <aside
        class="guide-sidebar"
        id="guideSidebar"
    >
        <div class="guide-sidebar-header">
            <a
                href="{{ route('Guide.tour-phan-cong.index') }}"
                class="guide-sidebar-logo"
            >
                <span class="guide-logo-icon">
                    <i class="fas fa-route"></i>
                </span>

                <span class="guide-logo-text">
                    <span class="guide-logo-title">
                        Travelloula
                    </span>

                    <span class="guide-logo-subtitle">
                        Hướng dẫn viên
                    </span>
                </span>
            </a>
        </div>

        <nav class="guide-sidebar-navigation">
            {{-- Tổng quan --}}
            <div class="guide-nav-section">
                <div class="guide-nav-section-title">
                    Tổng quan
                </div>

                <div class="guide-nav-item">
                    <a
                        href="{{ route('Guide.tour-phan-cong.index') }}"
                        class="guide-nav-link
                            {{ request()->routeIs('Guide.tour-phan-cong.*')
                                ? 'active'
                                : ''
                            }}"
                        title="Dashboard hướng dẫn viên"
                    >
                        <span class="guide-nav-icon">
                            <i class="fas fa-tachometer-alt"></i>
                        </span>

                        <span class="guide-nav-text">
                            Dashboard HDV
                        </span>
                    </a>
                </div>
            </div>

            {{-- Tour của tôi --}}
            <div class="guide-nav-section">
                <div class="guide-nav-section-title">
                    Tour của tôi
                </div>

                <div class="guide-nav-item">
                    <a
                        href="{{ route('Guide.tour-phan-cong.index') }}"
                        class="guide-nav-link
                            {{ request()->routeIs('Guide.tour-phan-cong.*')
                                ? 'active'
                                : ''
                            }}"
                        title="Tour được phân công"
                    >
                        <span class="guide-nav-icon">
                            <i class="fas fa-map-marked-alt"></i>
                        </span>

                        <span class="guide-nav-text">
                            Tour được phân công
                        </span>
                    </a>
                </div>

                <div class="guide-nav-item">
                    <a
                        href="#"
                        class="guide-nav-link"
                        title="Lịch khởi hành"
                    >
                        <span class="guide-nav-icon">
                            <i class="fas fa-calendar-alt"></i>
                        </span>

                        <span class="guide-nav-text">
                            Lịch khởi hành
                        </span>
                    </a>
                </div>

                <div class="guide-nav-item">
                    <a
                        href="#"
                        class="guide-nav-link"
                        title="Danh sách khách"
                    >
                        <span class="guide-nav-icon">
                            <i class="fas fa-users"></i>
                        </span>

                        <span class="guide-nav-text">
                            Danh sách khách
                        </span>
                    </a>
                </div>
            </div>

            {{-- Nghiệp vụ --}}
            <div class="guide-nav-section">
                <div class="guide-nav-section-title">
                    Nghiệp vụ
                </div>

                <div class="guide-nav-item">
                    <a
                        href="{{ route('Guide.checkin.index') }}"
                        class="guide-nav-link
                            {{ request()->routeIs('Guide.checkin.*')
                                ? 'active'
                                : ''
                            }}"
                        title="Check-in khách"
                    >
                        <span class="guide-nav-icon">
                            <i class="fas fa-clipboard-check"></i>
                        </span>

                        <span class="guide-nav-text">
                            Check-in khách
                        </span>
                    </a>
                </div>

                <div class="guide-nav-item">
                    <a
                        href="{{ route('Guide.nhatky.index') }}"
                        class="guide-nav-link
                            {{ request()->routeIs('Guide.nhatky.*')
                                ? 'active'
                                : ''
                            }}"
                        title="Nhật ký hướng dẫn viên"
                    >
                        <span class="guide-nav-icon">
                            <i class="fas fa-book"></i>
                        </span>

                        <span class="guide-nav-text">
                            Nhật ký hướng dẫn viên
                        </span>
                    </a>
                </div>

                <div class="guide-nav-item">
                    <a
                        href="{{ route('Guide.baocaosuco.index') }}"
                        class="guide-nav-link
                            {{ request()->routeIs('Guide.baocaosuco.*')
                                ? 'active'
                                : ''
                            }}"
                        title="Báo cáo sự cố"
                    >
                        <span class="guide-nav-icon">
                            <i class="fas fa-exclamation-triangle"></i>
                        </span>

                        <span class="guide-nav-text">
                            Báo cáo sự cố
                        </span>
                    </a>
                </div>
            </div>

            {{-- Tài khoản --}}
            <div class="guide-nav-section">
                <div class="guide-nav-section-title">
                    Tài khoản
                </div>

                <div class="guide-nav-item">
                    <a
                        href="{{ route('Guide.profile') }}"
                        class="guide-nav-link
                            {{ request()->routeIs('Guide.profile')
                                ? 'active'
                                : ''
                            }}"
                        title="Hồ sơ cá nhân"
                    >
                        <span class="guide-nav-icon">
                            <i class="fas fa-user"></i>
                        </span>

                        <span class="guide-nav-text">
                            Hồ sơ cá nhân
                        </span>
                    </a>
                </div>

                <div class="guide-nav-item">
                    <a
                        href="#"
                        class="guide-nav-link"
                        title="Thông báo"
                    >
                        <span class="guide-nav-icon">
                            <i class="fas fa-bell"></i>
                        </span>

                        <span class="guide-nav-text">
                            Thông báo
                        </span>

                        <span class="guide-nav-badge">
                            3
                        </span>
                    </a>
                </div>
            </div>
        </nav>
    </aside>

    {{-- Overlay mobile --}}
    <div
        class="guide-sidebar-overlay"
        id="guideSidebarOverlay"
    ></div>

    {{-- Nội dung --}}
    <div class="guide-main-content">
        <header class="guide-header">
            <div class="guide-header-left">
                <button
                    type="button"
                    class="guide-sidebar-toggle"
                    id="guideSidebarToggle"
                    title="Thu gọn hoặc mở menu"
                    aria-label="Mở menu"
                >
                    <i class="fas fa-bars"></i>
                </button>

                <nav
                    class="guide-breadcrumb-wrapper"
                    aria-label="breadcrumb"
                >
                    <ol class="breadcrumb guide-breadcrumb">
                        <li class="breadcrumb-item">
                            <a
                                href="{{ route('Guide.tour-phan-cong.index') }}"
                            >
                                Hướng dẫn viên
                            </a>
                        </li>

                        @hasSection('breadcrumb')
                            @yield('breadcrumb')
                        @else
                            <li class="breadcrumb-item active">
                                @yield('guide', 'Trang hướng dẫn viên')
                            </li>
                        @endif
                    </ol>
                </nav>
            </div>

            <div class="guide-header-right">
                <div class="guide-search-box">
                    <i class="fas fa-search guide-search-icon"></i>

                    <input
                        type="text"
                        class="guide-search-input"
                        placeholder="Tìm kiếm..."
                        autocomplete="off"
                    >
                </div>

                <div class="guide-header-actions">
                    <button
                        type="button"
                        class="guide-header-button"
                        title="Thông báo"
                    >
                        <i class="fas fa-bell"></i>

                        <span class="guide-notification-badge">
                            3
                        </span>
                    </button>

                    <button
                        type="button"
                        class="guide-header-button"
                        title="Tin nhắn"
                    >
                        <i class="fas fa-envelope"></i>

                        <span class="guide-notification-badge">
                            5
                        </span>
                    </button>
                </div>

                <div class="dropdown">
                    <button
                        type="button"
                        class="btn guide-user-button d-flex align-items-center"
                        data-bs-toggle="dropdown"
                        aria-expanded="false"
                    >
                        @if (Auth::check() && Auth::user()->avatar)
                            <img
                                src="{{ asset('storage/' . Auth::user()->avatar) }}"
                                alt="{{ Auth::user()->name }}"
                                class="guide-user-avatar-image"
                                onerror="
                                    this.style.display='none';
                                    this.nextElementSibling.style.display='inline-flex';
                                "
                            >

                            <span
                                class="guide-user-avatar"
                                style="display:none;"
                            >
                                {{ strtoupper(
                                    substr(
                                        Auth::user()->name ?? 'H',
                                        0,
                                        1
                                    )
                                ) }}
                            </span>
                        @else
                            <span class="guide-user-avatar">
                                {{ strtoupper(
                                    substr(
                                        Auth::user()->name ?? 'H',
                                        0,
                                        1
                                    )
                                ) }}
                            </span>
                        @endif
                    </button>

                    <ul
                        class="dropdown-menu dropdown-menu-end guide-user-dropdown"
                    >
                        <li class="px-3 py-2">
                            <div class="fw-bold text-dark">
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
                            <a
                                class="dropdown-item"
                                href="{{ route('Guide.profile') }}"
                            >
                                <i class="fas fa-user me-2"></i>
                                Hồ sơ cá nhân
                            </a>
                        </li>

                        <li>
                            <hr class="dropdown-divider">
                        </li>

                        <li>
                            <form
                                method="POST"
                                action="{{ route('logout') }}"
                            >
                                @csrf

                                <button
                                    type="submit"
                                    class="dropdown-item text-danger"
                                >
                                    <i class="fas fa-sign-out-alt me-2"></i>
                                    Đăng xuất
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </header>

        <main class="guide-content">
            <div class="container-fluid guide-content-container">
                @yield('content')
            </div>
        </main>
    </div>

    {{-- SweetAlert --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    {{-- Bootstrap --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const sidebar =
                document.getElementById('guideSidebar');

            const sidebarToggle =
                document.getElementById('guideSidebarToggle');

            const sidebarOverlay =
                document.getElementById('guideSidebarOverlay');

            if (!sidebar || !sidebarToggle) {
                return;
            }

            const storageKey =
                'guideSidebarCollapsed';

            function isMobile() {
                return window.innerWidth <= 1024;
            }

            function closeMobileSidebar() {
                sidebar.classList.remove('open');

                if (sidebarOverlay) {
                    sidebarOverlay.classList.remove('show');
                }

                document.body.style.overflow = '';
            }

            function openMobileSidebar() {
                sidebar.classList.add('open');

                if (sidebarOverlay) {
                    sidebarOverlay.classList.add('show');
                }

                document.body.style.overflow = 'hidden';
            }

            if (!isMobile()) {
                const isCollapsed =
                    localStorage.getItem(storageKey) === 'true';

                if (isCollapsed) {
                    sidebar.classList.add('collapsed');
                }
            }

            sidebarToggle.addEventListener('click', function () {
                if (isMobile()) {
                    if (sidebar.classList.contains('open')) {
                        closeMobileSidebar();
                    } else {
                        openMobileSidebar();
                    }

                    return;
                }

                sidebar.classList.toggle('collapsed');

                localStorage.setItem(
                    storageKey,
                    sidebar.classList.contains('collapsed')
                );
            });

            if (sidebarOverlay) {
                sidebarOverlay.addEventListener(
                    'click',
                    closeMobileSidebar
                );
            }

            document.addEventListener('keydown', function (event) {
                if (
                    event.key === 'Escape' &&
                    isMobile()
                ) {
                    closeMobileSidebar();
                }
            });

            window.addEventListener('resize', function () {
                if (!isMobile()) {
                    closeMobileSidebar();

                    const isCollapsed =
                        localStorage.getItem(storageKey) === 'true';

                    sidebar.classList.toggle(
                        'collapsed',
                        isCollapsed
                    );

                    return;
                }

                sidebar.classList.remove('collapsed');
            });

            const sidebarLinks =
                sidebar.querySelectorAll('.guide-nav-link');

            sidebarLinks.forEach(function (link) {
                link.addEventListener('click', function () {
                    if (
                        isMobile() &&
                        this.getAttribute('href') !== '#'
                    ) {
                        closeMobileSidebar();
                    }
                });
            });
        });
    </script>

    @yield('scripts')
    @stack('scripts')
</body>

</html>
