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
        @yield('title', 'Admin Dashboard - Travelloula')
    </title>

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

    {{-- CSS dự án --}}
    <link
        href="{{ asset('css/admin.css') }}"
        rel="stylesheet"
    >

    <link
        href="{{ asset('css/admin-modern.css') }}"
        rel="stylesheet"
    >

    <link
        href="{{ asset('css/dashboard-professional.css') }}"
        rel="stylesheet"
    >

    <link
        href="{{ asset('css/admin-tables.css') }}"
        rel="stylesheet"
    >

    <link
        href="{{ asset('css/admin-tables-fixed.css') }}"
        rel="stylesheet"
    >

    <link
        href="{{ asset('css/admin-icons.css') }}"
        rel="stylesheet"
    >

    <style>
        :root {
            --admin-primary-50: #edf4ff;
            --admin-primary-100: #dce8ff;
            --admin-primary-200: #c9d9ff;
            --admin-primary-500: #315be8;
            --admin-primary-600: #264ed4;
            --admin-primary-700: #1f43bb;

            --admin-purple: #5b4dea;
            --admin-cyan: #18b9dc;

            --admin-dark: #173576;
            --admin-text: #344563;
            --admin-muted: #6b7895;
            --admin-light: #98a2b3;

            --admin-gray-50: #f8faff;
            --admin-gray-100: #f3f6fb;
            --admin-gray-200: #e5ebf5;
            --admin-gray-300: #d1dbea;
            --admin-gray-400: #98a4b8;
            --admin-gray-500: #6b7895;
            --admin-gray-600: #4b5c78;
            --admin-gray-700: #344563;
            --admin-gray-800: #223654;
            --admin-gray-900: #172b4d;

            --admin-white: #ffffff;

            --admin-success: #08754a;
            --admin-success-bg: #eaf9f1;

            --admin-warning: #ae6c0d;
            --admin-warning-bg: #fff7e8;

            --admin-danger: #c13d55;
            --admin-danger-bg: #fff0f3;

            --admin-info: #1975a8;
            --admin-info-bg: #ebf8ff;

            --admin-border: #dce6f5;
            --admin-border-light: #e8eef8;

            --admin-shadow-sm:
                0 1px 2px rgba(24, 52, 103, 0.05);

            --admin-shadow:
                0 4px 16px rgba(28, 65, 139, 0.08);

            --admin-shadow-md:
                0 8px 28px rgba(28, 65, 139, 0.12);

            --admin-radius: 9px;
            --admin-radius-lg: 15px;

            --admin-sidebar-width: 280px;
            --admin-sidebar-collapsed-width: 80px;
            --admin-header-height: 70px;
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
            margin: 0;
            color: var(--admin-text);
            background: #f7f9fd;
            font-family: 'Inter', sans-serif;
            font-size: 14px;
            line-height: 1.6;
        }

        body.sidebar-mobile-open {
            overflow: hidden;
        }

        button,
        input,
        select,
        textarea {
            font-family: inherit;
        }

        a {
            text-decoration: none;
        }

        /* =========================
           SIDEBAR
        ========================= */

        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            z-index: 1000;

            width: var(--admin-sidebar-width);
            height: 100vh;

            overflow: hidden;

            background: var(--admin-white);
            border-right: 1px solid var(--admin-border);
            box-shadow: 2px 0 14px rgba(28, 65, 139, 0.05);

            display: flex;
            flex-direction: column;

            transition:
                width 0.3s ease,
                transform 0.3s ease;
        }

        .sidebar.collapsed {
            width: var(--admin-sidebar-collapsed-width);
        }

        /* Logo cố định */
        .sidebar-header {
            flex: 0 0 auto;
            padding: 14px;

            background: var(--admin-white);
            border-bottom: 1px solid var(--admin-border);
        }

        .sidebar-logo {
            min-height: 66px;
            padding: 10px;

            color: inherit;
            border-radius: 12px;

            display: flex;
            align-items: center;
            gap: 13px;

            transition:
                background-color 0.18s ease,
                transform 0.18s ease;
        }

        .sidebar-logo:hover {
            color: inherit;
            background: var(--admin-primary-50);
        }

        .logo-icon {
            width: 47px;
            height: 47px;
            flex-shrink: 0;

            color: var(--admin-white);

            background: linear-gradient(
                135deg,
                var(--admin-primary-500),
                var(--admin-purple)
            );

            border: 1px solid rgba(255, 255, 255, 0.28);
            border-radius: 12px;

            box-shadow: 0 7px 17px rgba(49, 91, 232, 0.23);

            font-size: 18px;

            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .logo-text {
            min-width: 0;

            display: flex;
            flex-direction: column;
        }

        .logo-title {
            color: #203b73;
            font-size: 20px;
            font-weight: 800;
            line-height: 1.1;
            white-space: nowrap;
        }

        .logo-subtitle {
            margin-top: 5px;

            color: var(--admin-muted);
            font-size: 10px;
            font-weight: 750;
            letter-spacing: 0.09em;
            text-transform: uppercase;
            white-space: nowrap;
        }

        /* Chỉ phần menu cuộn */
        .sidebar-nav {
            flex: 1 1 auto;
            min-height: 0;

            padding: 15px 0 28px;

            overflow-x: hidden;
            overflow-y: auto;

            overscroll-behavior: contain;

            scrollbar-width: thin;
            scrollbar-color: #b9c8e3 #f4f7fc;
        }

        .sidebar-nav::-webkit-scrollbar {
            width: 5px;
        }

        .sidebar-nav::-webkit-scrollbar-track {
            background: #f4f7fc;
        }

        .sidebar-nav::-webkit-scrollbar-thumb {
            background: #b9c8e3;
            border-radius: 999px;
        }

        .sidebar-nav::-webkit-scrollbar-thumb:hover {
            background: #8097bd;
        }

        /* =========================
           NHÓM MENU
        ========================= */

        .sidebar .nav-section {
            margin-bottom: 9px;
        }

        .sidebar .nav-section-toggle {
            width: calc(100% - 26px);
            min-height: 39px;
            margin: 0 13px 4px;
            padding: 8px 11px;

            color: #71809b;
            background: transparent;

            border: 1px solid transparent;
            border-radius: 8px;

            font-size: 10px;
            font-weight: 800;
            letter-spacing: 0.055em;
            text-align: left;
            text-transform: uppercase;

            cursor: pointer;

            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 9px;

            transition:
                color 0.18s ease,
                background-color 0.18s ease,
                border-color 0.18s ease;
        }

        .sidebar .nav-section-toggle:hover {
            color: var(--admin-primary-500);
            background: var(--admin-primary-50);
            border-color: #d5e2ff;
        }

        .sidebar .nav-section-toggle.has-active {
            color: var(--admin-primary-500);
            background: #f4f7ff;
            border-color: #dce6fb;
        }

        .sidebar .nav-section-toggle-left {
            min-width: 0;

            display: flex;
            align-items: center;
            gap: 8px;
        }

        .sidebar .nav-section-toggle-icon {
            width: 17px;
            flex-shrink: 0;

            color: #8392ad;
            font-size: 10px;
            text-align: center;
        }

        .sidebar .nav-section-toggle.has-active
        .nav-section-toggle-icon {
            color: var(--admin-primary-500);
        }

        .sidebar .nav-section-toggle-text {
            min-width: 0;

            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .sidebar .nav-section-arrow {
            flex-shrink: 0;

            color: #93a0b7;
            font-size: 9px;

            transition: transform 0.22s ease;
        }

        .sidebar .nav-section-menu {
            display: block;
        }

        .sidebar .nav-section.is-collapsed
        .nav-section-menu {
            display: none;
        }

        .sidebar .nav-section.is-collapsed
        .nav-section-arrow {
            transform: rotate(-90deg);
        }

        /* =========================
           LINK MENU
        ========================= */

        .sidebar .nav-item {
            margin: 2px 0;
        }

        .sidebar .nav-link {
            position: relative;

            min-height: 43px;
            margin: 3px 13px;
            padding: 10px 14px;

            overflow: hidden;

            color: #65738e;
            background: transparent;

            border: 1px solid transparent;
            border-radius: 9px;

            font-size: 12px;
            font-weight: 620;
            text-decoration: none;

            display: flex;
            align-items: center;
            gap: 11px;

            transition:
                color 0.18s ease,
                background-color 0.18s ease,
                border-color 0.18s ease,
                transform 0.18s ease;
        }

        .sidebar .nav-link:hover {
            color: var(--admin-primary-500);
            background: var(--admin-primary-50);
            border-color: #d5e2ff;

            text-decoration: none;
            transform: translateX(3px);
        }

        .sidebar .nav-link.active {
            color: var(--admin-primary-500);

            background: linear-gradient(
                90deg,
                #edf4ff 0%,
                #f1efff 100%
            );

            border-color: #cfdcff;
            font-weight: 750;
        }

        .sidebar .nav-link.active::before {
            position: absolute;
            top: 8px;
            bottom: 8px;
            left: -13px;

            width: 4px;
            content: "";

            background: linear-gradient(
                180deg,
                var(--admin-primary-500),
                var(--admin-purple)
            );

            border-radius: 0 8px 8px 0;
        }

        .sidebar .nav-icon {
            width: 21px;
            height: 21px;
            flex-shrink: 0;

            font-size: 13px;

            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .sidebar .nav-text {
            min-width: 0;

            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .sidebar .nav-badge {
            min-width: 22px;
            height: 20px;
            margin-left: auto;
            padding: 0 6px;

            color: var(--admin-white);
            border-radius: 999px;

            font-size: 9px;
            font-weight: 800;

            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .sidebar .nav-badge-danger {
            background: var(--admin-danger);
        }

        .sidebar .nav-badge-warning {
            color: #583600;
            background: #f5b83f;
        }

        .sidebar .nav-link-disabled {
            cursor: not-allowed;
            opacity: 0.55;
        }

        .sidebar .nav-link-disabled:hover {
            color: #65738e;
            background: transparent;
            border-color: transparent;
            transform: none;
        }

        /* =========================
           SIDEBAR THU GỌN
        ========================= */

        .sidebar.collapsed .sidebar-header {
            padding-right: 9px;
            padding-left: 9px;
        }

        .sidebar.collapsed .sidebar-logo {
            padding-right: 6px;
            padding-left: 6px;
            justify-content: center;
        }

        .sidebar.collapsed .logo-text,
        .sidebar.collapsed .nav-text,
        .sidebar.collapsed .nav-section-toggle,
        .sidebar.collapsed .nav-badge {
            display: none;
        }

        .sidebar.collapsed .nav-section {
            margin-bottom: 7px;
        }

        .sidebar.collapsed .nav-section-menu,
        .sidebar.collapsed
        .nav-section.is-collapsed
        .nav-section-menu {
            display: block;
        }

        .sidebar.collapsed .nav-link {
            min-height: 44px;
            margin-right: 11px;
            margin-left: 11px;
            padding-right: 10px;
            padding-left: 10px;

            justify-content: center;
        }

        .sidebar.collapsed .nav-link:hover {
            transform: none;
        }

        .sidebar.collapsed .nav-link.active::before {
            left: -11px;
        }

        .sidebar.collapsed .nav-icon {
            width: 23px;
            height: 23px;
            font-size: 14px;
        }

        /* Overlay mobile */
        .sidebar-overlay {
            position: fixed;
            inset: 0;
            z-index: 999;

            display: none;

            background: rgba(23, 43, 77, 0.46);
            backdrop-filter: blur(2px);
        }

        .sidebar-overlay.show {
            display: block;
        }

        /* =========================
           MAIN CONTENT
        ========================= */

        .main-content {
            min-height: 100vh;
            margin-left: var(--admin-sidebar-width);

            transition: margin-left 0.3s ease;
        }

        .sidebar.collapsed ~ .main-content {
            margin-left: var(--admin-sidebar-collapsed-width);
        }

        /* =========================
           HEADER
        ========================= */

        .header {
            position: sticky;
            top: 0;
            z-index: 100;

            height: var(--admin-header-height);
            padding: 0 28px;

            background: rgba(255, 255, 255, 0.96);
            border-bottom: 1px solid var(--admin-border);
            box-shadow: var(--admin-shadow-sm);

            backdrop-filter: blur(10px);

            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
        }

        .header-left,
        .header-right,
        .header-actions {
            min-width: 0;

            display: flex;
            align-items: center;
        }

        .header-left {
            gap: 15px;
        }

        .header-right {
            gap: 13px;
        }

        .header-actions {
            gap: 7px;
        }

        .sidebar-toggle {
            width: 40px;
            height: 40px;
            flex-shrink: 0;
            padding: 0;

            color: var(--admin-gray-600);
            background: var(--admin-white);

            border: 1px solid var(--admin-border);
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

        .sidebar-toggle:hover {
            color: var(--admin-primary-500);
            background: var(--admin-primary-50);
            border-color: var(--admin-primary-200);

            transform: translateY(-1px);
        }

        .breadcrumb {
            margin: 0;
            padding: 0;

            background: transparent;
            font-size: 12px;
        }

        .breadcrumb-item {
            color: var(--admin-muted);
        }

        .breadcrumb-item a {
            color: var(--admin-primary-500);
            font-weight: 650;
            text-decoration: none;
        }

        .breadcrumb-item a:hover {
            color: var(--admin-primary-600);
            text-decoration: underline;
        }

        .breadcrumb-item.active {
            max-width: 340px;

            overflow: hidden;

            color: #4b5c78;
            font-weight: 650;

            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .search-box {
            position: relative;
            width: 285px;
        }

        .search-icon {
            position: absolute;
            top: 50%;
            left: 13px;
            z-index: 2;

            color: var(--admin-gray-400);
            font-size: 12px;

            pointer-events: none;
            transform: translateY(-50%);
        }

        .search-input {
            width: 100%;
            min-height: 40px;
            padding: 9px 14px 9px 37px;

            color: var(--admin-text);
            background: var(--admin-gray-50);

            border: 1px solid var(--admin-gray-300);
            border-radius: 999px;

            font-size: 12px;
            outline: none;

            transition:
                background-color 0.18s ease,
                border-color 0.18s ease,
                box-shadow 0.18s ease;
        }

        .search-input::placeholder {
            color: var(--admin-gray-400);
        }

        .search-input:focus {
            background: var(--admin-white);
            border-color: var(--admin-primary-500);
            box-shadow: 0 0 0 3px rgba(49, 91, 232, 0.1);
        }

        .header-btn {
            position: relative;

            width: 39px;
            height: 39px;
            flex-shrink: 0;
            padding: 0;

            color: var(--admin-gray-600);
            background: var(--admin-white);

            border: 1px solid var(--admin-border);
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

        .header-btn:hover {
            color: var(--admin-primary-500);
            background: var(--admin-primary-50);
            border-color: var(--admin-primary-200);

            transform: translateY(-1px);
        }

        .notification-badge {
            position: absolute;
            top: -5px;
            right: -5px;

            min-width: 18px;
            height: 18px;
            padding: 0 4px;

            color: var(--admin-white);
            background: var(--admin-danger);

            border: 2px solid var(--admin-white);
            border-radius: 999px;

            font-size: 8px;
            font-weight: 800;

            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        /* =========================
           AVATAR
        ========================= */

        .user-menu-button {
            padding: 0 !important;

            background: transparent !important;
            border: none !important;
            box-shadow: none !important;
        }

        .user-avatar,
        .user-avatar-img {
            width: 42px;
            height: 42px;
            flex-shrink: 0;

            border-radius: 50%;
        }

        .user-avatar {
            color: var(--admin-white);

            background: linear-gradient(
                135deg,
                var(--admin-primary-500),
                var(--admin-purple)
            );

            border: 2px solid #dce6fb;
            box-shadow: 0 5px 13px rgba(49, 91, 232, 0.18);

            font-size: 14px;
            font-weight: 800;

            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .user-avatar-img {
            object-fit: cover;

            border: 2px solid #dce6fb;
            box-shadow: 0 5px 13px rgba(28, 65, 139, 0.12);
        }

        .user-dropdown {
            min-width: 260px;
            padding: 8px;

            border: 1px solid var(--admin-border) !important;
            border-radius: 13px;

            box-shadow:
                0 13px 36px rgba(28, 65, 139, 0.15) !important;
        }

        .user-dropdown .dropdown-item {
            padding: 10px 12px;

            color: var(--admin-gray-700);
            border-radius: 8px;

            font-size: 12px;
            font-weight: 600;
        }

        .user-dropdown .dropdown-item:hover {
            color: var(--admin-primary-500);
            background: var(--admin-primary-50);
        }

        .user-dropdown .dropdown-item.text-danger:hover {
            color: var(--admin-danger) !important;
            background: var(--admin-danger-bg);
        }

        /* =========================
           CONTENT
        ========================= */

        .content {
            min-height:
                calc(100vh - var(--admin-header-height));
        }

        .content-container {
            padding: 24px;
        }

        .content .card {
            overflow: hidden;

            background: var(--admin-white);

            border: 1px solid var(--admin-border);
            border-radius: var(--admin-radius-lg);

            box-shadow: var(--admin-shadow);

            transition: box-shadow 0.18s ease;
        }

        .content .card:hover {
            box-shadow: var(--admin-shadow-md);
        }

        .content .card-header {
            min-height: 57px;
            padding: 15px 18px;

            color: #24417d;
            background: #f1f6ff;

            border-bottom: 1px solid var(--admin-border);

            font-size: 14px;
            font-weight: 750;

            display: flex;
            align-items: center;
        }

        .content .card-body {
            padding: 20px;
        }

        .content .card-footer {
            padding: 15px 20px;

            background: #fafcff;
            border-top: 1px solid var(--admin-border);
        }

        /* Nút */
        .content .btn {
            min-height: 39px;
            padding: 8px 14px;

            border-radius: var(--admin-radius);

            font-size: 12px;
            font-weight: 700;
            white-space: nowrap;

            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 7px;

            transition:
                color 0.18s ease,
                background-color 0.18s ease,
                border-color 0.18s ease,
                transform 0.18s ease;
        }

        .content .btn:hover {
            transform: translateY(-1px);
        }

        .content .btn-primary {
            color: var(--admin-white);

            background: linear-gradient(
                135deg,
                var(--admin-primary-500),
                var(--admin-purple)
            );

            border-color: var(--admin-primary-500);

            box-shadow:
                0 5px 14px rgba(49, 91, 232, 0.2);
        }

        .content .btn-primary:hover {
            color: var(--admin-white);

            background: linear-gradient(
                135deg,
                var(--admin-primary-600),
                #4c40d7
            );

            border-color: var(--admin-primary-600);
        }

        .content .btn-secondary {
            color: #53698f;
            background: var(--admin-white);
            border-color: #ccd9ed;
        }

        .content .btn-secondary:hover {
            color: #304d83;
            background: #edf3fb;
            border-color: #b9c9e0;
        }

        /* Form */
        .content .form-control,
        .content .form-select {
            min-height: 42px;

            color: var(--admin-text);
            background-color: var(--admin-white);

            border: 1px solid #cfdaec;
            border-radius: var(--admin-radius);

            font-size: 13px;
            box-shadow: none;
        }

        .content .form-control:focus,
        .content .form-select:focus {
            border-color: var(--admin-primary-500);
            box-shadow:
                0 0 0 4px rgba(49, 91, 232, 0.1);
        }

        /* Table */
        .content .table {
            margin-bottom: 0;
            vertical-align: middle;
        }

        .content .table thead th {
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

        .content .table tbody td {
            padding: 13px 14px;

            color: #4d5d7d;

            border-bottom:
                1px solid var(--admin-border-light);

            font-size: 12px;
            vertical-align: middle;
        }

        .content .table tbody tr:hover {
            background: #f3f7ff;

            box-shadow:
                inset 3px 0 0 var(--admin-primary-500);
        }

        /* Pagination */
        .content .pagination {
            margin: 0;
            gap: 4px;
        }

        .content .page-link {
            min-width: 34px;
            height: 34px;
            padding: 6px 10px;

            color: #3158ce;
            background: var(--admin-white);

            border: 1px solid #d6e1f2;
            border-radius: 7px !important;

            font-size: 12px;
            box-shadow: none;

            display: flex;
            align-items: center;
            justify-content: center;
        }

        .content .page-link:hover {
            color: var(--admin-white);
            background: var(--admin-primary-500);
            border-color: var(--admin-primary-500);
        }

        .content .page-item.active .page-link {
            color: var(--admin-white);

            background: linear-gradient(
                135deg,
                var(--admin-primary-500),
                var(--admin-purple)
            );

            border-color: var(--admin-primary-500);
        }

        .content .page-item.disabled .page-link {
            color: #aab3c5;
            background: #f8f9fc;
        }

        /* Animation */
        @keyframes adminFadeIn {
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
            animation: adminFadeIn 0.3s ease-out;
        }

        /* =========================
           RESPONSIVE
        ========================= */

        @media (max-width: 1100px) {
            .search-box {
                width: 220px;
            }
        }

        @media (max-width: 1024px) {
            .sidebar {
                width: var(--admin-sidebar-width);
                transform: translateX(-100%);
            }

            .sidebar.open {
                transform: translateX(0);
            }

            .sidebar.collapsed {
                width: var(--admin-sidebar-width);
            }

            .sidebar.collapsed .logo-text,
            .sidebar.collapsed .nav-text,
            .sidebar.collapsed .nav-section-toggle,
            .sidebar.collapsed .nav-badge {
                display: initial;
            }

            .sidebar.collapsed .logo-text {
                display: flex;
            }

            .sidebar.collapsed .nav-section-toggle {
                display: flex;
            }

            .sidebar.collapsed .sidebar-logo,
            .sidebar.collapsed .nav-link {
                justify-content: flex-start;
            }

            .sidebar.collapsed
            .nav-section.is-collapsed
            .nav-section-menu {
                display: none;
            }

            .main-content,
            .sidebar.collapsed ~ .main-content {
                margin-left: 0;
            }

            .search-box {
                display: none;
            }
        }

        @media (max-width: 768px) {
            .header {
                padding: 0 15px;
            }

            .header-actions {
                display: none;
            }

            .content-container {
                padding: 15px;
            }

            .breadcrumb-item:first-child {
                display: none;
            }

            .breadcrumb-item +
            .breadcrumb-item::before {
                display: none;
            }

            .breadcrumb-item.active {
                max-width: 210px;

                color: #24417d;
                font-size: 13px;
                font-weight: 750;
            }
        }

        @media (max-width: 480px) {
            .header {
                gap: 8px;
            }

            .header-left {
                gap: 9px;
            }

            .sidebar {
                width: min(280px, 87vw);
            }

            .user-avatar,
            .user-avatar-img {
                width: 38px;
                height: 38px;
            }
        }
    </style>

    @stack('styles')
    @yield('styles')
</head>

<body>
    {{-- Sidebar --}}
    <aside
        class="sidebar"
        id="sidebar"
    >
        <div class="sidebar-header">
            <a
                href="{{ route('Admin.dashboard') }}"
                class="sidebar-logo"
                title="Travelloula Admin"
            >
                <span class="logo-icon">
                    <i class="fas fa-plane"></i>
                </span>

                <span class="logo-text">
                    <span class="logo-title">
                        Travelloula
                    </span>

                    <span class="logo-subtitle">
                        Quản trị viên
                    </span>
                </span>
            </a>
        </div>

        <nav class="sidebar-nav">
            {{-- Tổng quan --}}
            <div
                class="nav-section"
                data-nav-section="tong-quan"
            >
                <button
                    type="button"
                    class="nav-section-toggle"
                    aria-expanded="true"
                >
                    <span class="nav-section-toggle-left">
                        <i class="fas fa-home nav-section-toggle-icon"></i>

                        <span class="nav-section-toggle-text">
                            Tổng quan
                        </span>
                    </span>

                    <i class="fas fa-chevron-down nav-section-arrow"></i>
                </button>

                <div class="nav-section-menu">
                    <div class="nav-item">
                        <a
                            href="{{ route('Admin.dashboard') }}"
                            class="nav-link {{ request()->routeIs('Admin.dashboard') ? 'active' : '' }}"
                            title="Dashboard"
                        >
                            <span class="nav-icon">
                                <i class="fas fa-tachometer-alt"></i>
                            </span>

                            <span class="nav-text">
                                Dashboard
                            </span>
                        </a>
                    </div>

                    <div class="nav-item">
                        <a
                            href="{{ route('Admin.trang_dieu_khoans.edit') }}"
                            class="nav-link {{ request()->routeIs('Admin.trang_dieu_khoans*') ? 'active' : '' }}"
                            title="Điều khoản"
                        >
                            <span class="nav-icon">
                                <i class="fas fa-file-contract"></i>
                            </span>

                            <span class="nav-text">
                                Điều khoản
                            </span>
                        </a>
                    </div>
                </div>
            </div>

            {{-- Quản lý Tour --}}
            <div
                class="nav-section"
                data-nav-section="quan-ly-tour"
            >
                <button
                    type="button"
                    class="nav-section-toggle"
                    aria-expanded="true"
                >
                    <span class="nav-section-toggle-left">
                        <i class="fas fa-map-marked-alt nav-section-toggle-icon"></i>

                        <span class="nav-section-toggle-text">
                            Quản lý Tour
                        </span>
                    </span>

                    <i class="fas fa-chevron-down nav-section-arrow"></i>
                </button>

                <div class="nav-section-menu">
                    <div class="nav-item">
                        <a
                            href="{{ route('Admin.tours.index') }}"
                            class="nav-link {{ request()->routeIs('Admin.tours*') ? 'active' : '' }}"
                            title="Danh sách Tour"
                        >
                            <span class="nav-icon">
                                <i class="fas fa-map-marked-alt"></i>
                            </span>

                            <span class="nav-text">
                                Danh sách Tour
                            </span>
                        </a>
                    </div>

                    <div class="nav-item">
                        <a
                            href="{{ route('Admin.lich_trinh_tours.index') }}"
                            class="nav-link {{ request()->routeIs('Admin.lich_trinh_tours*') ? 'active' : '' }}"
                            title="Quản lý lịch trình"
                        >
                            <span class="nav-icon">
                                <i class="fas fa-calendar-alt"></i>
                            </span>

                            <span class="nav-text">
                                Quản lý lịch trình
                            </span>
                        </a>
                    </div>

                    <div class="nav-item">
                        <a
                            href="{{ route('Admin.lich-khoi-hanh.index') }}"
                            class="nav-link {{ request()->routeIs('Admin.lich-khoi-hanh*') ? 'active' : '' }}"
                            title="Quản lý khởi hành"
                        >
                            <span class="nav-icon">
                                <i class="fas fa-plane-departure"></i>
                            </span>

                            <span class="nav-text">
                                Quản lý khởi hành
                            </span>
                        </a>
                    </div>

                    <div class="nav-item">
                        <a
                            href="{{ route('Admin.gop-doan.index') }}"
                            class="nav-link {{ request()->routeIs('Admin.gop-doan*') ? 'active' : '' }}"
                            title="Gộp đoàn"
                        >
                            <span class="nav-icon">
                                <i class="fas fa-object-group"></i>
                            </span>

                            <span class="nav-text">
                                Gộp đoàn
                            </span>
                        </a>
                    </div>

                    <div class="nav-item">
                        <a
                            href="{{ route('Admin.phuong-tiens.index') }}"
                            class="nav-link {{ request()->routeIs('Admin.phuong-tiens*') ? 'active' : '' }}"
                            title="Quản lý xe"
                        >
                            <span class="nav-icon">
                                <i class="fas fa-bus"></i>
                            </span>

                            <span class="nav-text">
                                Quản lý xe
                            </span>
                        </a>
                    </div>

                    <div class="nav-item">
                        <a
                            href="{{ route('Admin.nhat_ky_tours.index') }}"
                            class="nav-link {{ request()->routeIs('Admin.nhat_ky_tours*') ? 'active' : '' }}"
                            title="Nhật ký Tour"
                        >
                            <span class="nav-icon">
                                <i class="fas fa-book"></i>
                            </span>

                            <span class="nav-text">
                                Nhật ký Tour
                            </span>
                        </a>
                    </div>
                </div>
            </div>

            {{-- Đặt Tour và vận hành --}}
            <div
                class="nav-section"
                data-nav-section="dat-tour-van-hanh"
            >
                <button
                    type="button"
                    class="nav-section-toggle"
                    aria-expanded="true"
                >
                    <span class="nav-section-toggle-left">
                        <i class="fas fa-briefcase nav-section-toggle-icon"></i>

                        <span class="nav-section-toggle-text">
                            Đặt Tour & Vận hành
                        </span>
                    </span>

                    <i class="fas fa-chevron-down nav-section-arrow"></i>
                </button>

                <div class="nav-section-menu">
                    <div class="nav-item">
                        <a
                            href="{{ route('Admin.quan_ly_dat_tour.index') }}"
                            class="nav-link {{ request()->routeIs('Admin.quan_ly_dat_tour*') ? 'active' : '' }}"
                            title="Quản lý đặt Tour"
                        >
                            <span class="nav-icon">
                                <i class="fas fa-calendar-check"></i>
                            </span>

                            <span class="nav-text">
                                Quản lý đặt Tour
                            </span>
                        </a>
                    </div>

                    <div class="nav-item">
                        <a
                            href="{{ route('Admin.phan-cong.index') }}"
                            class="nav-link {{ request()->routeIs('Admin.phan-cong*') ? 'active' : '' }}"
                            title="Quản lý phân công"
                        >
                            <span class="nav-icon">
                                <i class="fas fa-user-friends"></i>
                            </span>

                            <span class="nav-text">
                                Quản lý phân công
                            </span>
                        </a>
                    </div>
                </div>
            </div>

            {{-- Quản lý người dùng --}}
            <div
                class="nav-section"
                data-nav-section="nguoi-dung"
            >
                <button
                    type="button"
                    class="nav-section-toggle"
                    aria-expanded="true"
                >
                    <span class="nav-section-toggle-left">
                        <i class="fas fa-users-cog nav-section-toggle-icon"></i>

                        <span class="nav-section-toggle-text">
                            Quản lý người dùng
                        </span>
                    </span>

                    <i class="fas fa-chevron-down nav-section-arrow"></i>
                </button>

                <div class="nav-section-menu">
                    <div class="nav-item">
                        <a
                            href="{{ route('Admin.huong-dan-viens.index') }}"
                            class="nav-link {{ request()->routeIs('Admin.huong-dan-viens*') ? 'active' : '' }}"
                            title="Quản lý hướng dẫn viên"
                        >
                            <span class="nav-icon">
                                <i class="fas fa-user-tie"></i>
                            </span>

                            <span class="nav-text">
                                Quản lý HDV
                            </span>
                        </a>
                    </div>

                    <div class="nav-item">
                        <a
                            href="{{ route('Admin.users.index') }}"
                            class="nav-link {{ request()->routeIs('Admin.users*') ? 'active' : '' }}"
                            title="Người dùng"
                        >
                            <span class="nav-icon">
                                <i class="fas fa-user"></i>
                            </span>

                            <span class="nav-text">
                                Người dùng
                            </span>
                        </a>
                    </div>

                    <div class="nav-item">
                        <a
                            href="{{ route('Admin.khach-hang.index') }}"
                            class="nav-link {{ request()->routeIs('Admin.khach-hang*') ? 'active' : '' }}"
                            title="Quản lý khách hàng"
                        >
                            <span class="nav-icon">
                                <i class="fas fa-user-check"></i>
                            </span>

                            <span class="nav-text">
                                Quản lý khách hàng
                            </span>
                        </a>
                    </div>

                    <div class="nav-item">
                        <a
                            href="{{ route('Admin.vai-tros.index') }}"
                            class="nav-link {{ request()->routeIs('Admin.vai-tros*') ? 'active' : '' }}"
                            title="Vai trò"
                        >
                            <span class="nav-icon">
                                <i class="fas fa-user-tag"></i>
                            </span>

                            <span class="nav-text">
                                Vai trò
                            </span>
                        </a>
                    </div>

                    <div class="nav-item">
                        <a
                            href="{{ route('Admin.quyen-hans.index') }}"
                            class="nav-link {{ request()->routeIs('Admin.quyen-hans*') ? 'active' : '' }}"
                            title="Quyền"
                        >
                            <span class="nav-icon">
                                <i class="fas fa-key"></i>
                            </span>

                            <span class="nav-text">
                                Quyền
                            </span>
                        </a>
                    </div>

                    <div class="nav-item">
                        <a
                            href="{{ route('Admin.role-permissions.matrix') }}"
                            class="nav-link {{ request()->routeIs('Admin.role-permissions*') ? 'active' : '' }}"
                            title="Phân quyền"
                        >
                            <span class="nav-icon">
                                <i class="fas fa-th"></i>
                            </span>

                            <span class="nav-text">
                                Phân quyền
                            </span>
                        </a>
                    </div>
                </div>
            </div>

            {{-- Nội dung --}}
            <div
                class="nav-section"
                data-nav-section="noi-dung"
            >
                <button
                    type="button"
                    class="nav-section-toggle"
                    aria-expanded="true"
                >
                    <span class="nav-section-toggle-left">
                        <i class="fas fa-layer-group nav-section-toggle-icon"></i>

                        <span class="nav-section-toggle-text">
                            Nội dung
                        </span>
                    </span>

                    <i class="fas fa-chevron-down nav-section-arrow"></i>
                </button>

                <div class="nav-section-menu">
                    <div class="nav-item">
                        <a
                            href="{{ route('Admin.banners.index') }}"
                            class="nav-link {{ request()->routeIs('Admin.banners*') ? 'active' : '' }}"
                            title="Quản lý Banner"
                        >
                            <span class="nav-icon">
                                <i class="fas fa-image"></i>
                            </span>

                            <span class="nav-text">
                                Quản lý Banner
                            </span>
                        </a>
                    </div>

                    <div class="nav-item">
                        <a
                            href="{{ route('Admin.danh_mucs.index') }}"
                            class="nav-link {{ request()->routeIs('Admin.danh_mucs*') ? 'active' : '' }}"
                            title="Quản lý danh mục"
                        >
                            <span class="nav-icon">
                                <i class="fas fa-tags"></i>
                            </span>

                            <span class="nav-text">
                                Quản lý danh mục
                            </span>
                        </a>
                    </div>

                    <div class="nav-item">
                        <a
                            href="{{ route('Admin.danh_gias.index') }}"
                            class="nav-link {{ request()->routeIs('Admin.danh_gias*') ? 'active' : '' }}"
                            title="Quản lý đánh giá"
                        >
                            <span class="nav-icon">
                                <i class="fas fa-star"></i>
                            </span>

                            <span class="nav-text">
                                Quản lý đánh giá
                            </span>
                        </a>
                    </div>

                    <div class="nav-item">
                        <a
                            href="#"
                            class="nav-link nav-link-disabled"
                            title="Chức năng chưa có route"
                            onclick="return false;"
                        >
                            <span class="nav-icon">
                                <i class="fas fa-user-tie"></i>
                            </span>

                            <span class="nav-text">
                                Đánh giá hướng dẫn viên
                            </span>
                        </a>
                    </div>
                </div>
            </div>

            {{-- Thanh toán và báo cáo --}}
            <div
                class="nav-section"
                data-nav-section="thanh-toan-bao-cao"
            >
                <button
                    type="button"
                    class="nav-section-toggle"
                    aria-expanded="true"
                >
                    <span class="nav-section-toggle-left">
                        <i class="fas fa-chart-line nav-section-toggle-icon"></i>

                        <span class="nav-section-toggle-text">
                            Thanh toán & Báo cáo
                        </span>
                    </span>

                    <i class="fas fa-chevron-down nav-section-arrow"></i>
                </button>

                <div class="nav-section-menu">
                    <div class="nav-item">
                        <a
                            href="{{ route('Admin.thanh_toans.index') }}"
                            class="nav-link {{ request()->routeIs('Admin.thanh_toans*') ? 'active' : '' }}"
                            title="Quản lý thanh toán"
                        >
                            <span class="nav-icon">
                                <i class="fas fa-credit-card"></i>
                            </span>

                            <span class="nav-text">
                                Quản lý thanh toán
                            </span>
                        </a>
                    </div>

                    <div class="nav-item">
                        <a
                            href="{{ route('Admin.thong_ke.index') }}"
                            class="nav-link {{ request()->routeIs('Admin.thong_ke*') ? 'active' : '' }}"
                            title="Báo cáo và thống kê"
                        >
                            <span class="nav-icon">
                                <i class="fas fa-chart-bar"></i>
                            </span>

                            <span class="nav-text">
                                Báo cáo & Thống kê
                            </span>
                        </a>
                    </div>
                </div>
            </div>

            {{-- Hệ thống --}}
            <div
                class="nav-section"
                data-nav-section="he-thong"
            >
                <button
                    type="button"
                    class="nav-section-toggle"
                    aria-expanded="true"
                >
                    <span class="nav-section-toggle-left">
                        <i class="fas fa-cog nav-section-toggle-icon"></i>

                        <span class="nav-section-toggle-text">
                            Hệ thống
                        </span>
                    </span>

                    <i class="fas fa-chevron-down nav-section-arrow"></i>
                </button>

                <div class="nav-section-menu">
                    <div class="nav-item">
                        <a
                            href="#"
                            class="nav-link"
                            title="Thông báo"
                        >
                            <span class="nav-icon">
                                <i class="fas fa-bell"></i>
                            </span>

                            <span class="nav-text">
                                Thông báo
                            </span>

                            <span class="nav-badge nav-badge-danger">
                                3
                            </span>
                        </a>
                    </div>

                    <div class="nav-item">
                        <a
                            href="#"
                            class="nav-link"
                            title="Hỗ trợ khách hàng"
                        >
                            <span class="nav-icon">
                                <i class="fas fa-headset"></i>
                            </span>

                            <span class="nav-text">
                                Hỗ trợ khách hàng
                            </span>

                            <span class="nav-badge nav-badge-warning">
                                5
                            </span>
                        </a>
                    </div>
                </div>
            </div>
        </nav>
    </aside>

    {{-- Overlay mobile --}}
    <div
        class="sidebar-overlay"
        id="sidebarOverlay"
    ></div>

    {{-- Main --}}
    <div class="main-content">
        <header class="header">
            <div class="header-left">
                <button
                    class="sidebar-toggle"
                    id="sidebarToggle"
                    type="button"
                    title="Thu gọn hoặc mở menu"
                    aria-label="Thu gọn hoặc mở menu"
                    aria-controls="sidebar"
                    aria-expanded="true"
                >
                    <i class="fas fa-bars"></i>
                </button>

                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{ route('Admin.dashboard') }}">
                                Admin
                            </a>
                        </li>

                        @yield('breadcrumb')
                    </ol>
                </nav>
            </div>

            <div class="header-right">
                <div class="search-box">
                    <i class="fas fa-search search-icon"></i>

                    <input
                        type="text"
                        class="search-input"
                        placeholder="Tìm kiếm..."
                        autocomplete="off"
                    >
                </div>

                <div class="header-actions">
                    <button
                        class="header-btn"
                        title="Thông báo"
                        type="button"
                    >
                        <i class="fas fa-bell"></i>

                        <span class="notification-badge">
                            3
                        </span>
                    </button>

                    <button
                        class="header-btn"
                        title="Tin nhắn"
                        type="button"
                    >
                        <i class="fas fa-envelope"></i>

                        <span class="notification-badge">
                            5
                        </span>
                    </button>
                </div>

                <div class="user-menu dropdown">
                    <button
                        class="btn user-menu-button d-flex align-items-center"
                        type="button"
                        data-bs-toggle="dropdown"
                        aria-expanded="false"
                    >
                        @if (Auth::check() && Auth::user()->avatar)
                            <img
                                src="{{ asset('storage/' . Auth::user()->avatar) }}"
                                alt="{{ Auth::user()->name }}"
                                class="user-avatar-img"
                                onerror="
                                    this.style.display='none';
                                    this.nextElementSibling.style.display='inline-flex';
                                "
                            >

                            <span
                                class="user-avatar"
                                style="display:none;"
                            >
                                {{ strtoupper(
                                    substr(
                                        Auth::user()->name ?? 'A',
                                        0,
                                        1
                                    )
                                ) }}
                            </span>
                        @else
                            <span class="user-avatar">
                                {{ strtoupper(
                                    substr(
                                        Auth::user()->name ?? 'A',
                                        0,
                                        1
                                    )
                                ) }}
                            </span>
                        @endif
                    </button>

                    <ul
                        class="dropdown-menu dropdown-menu-end user-dropdown"
                    >
                        <li class="px-3 py-2">
                            <div class="fw-bold text-dark">
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
                            <a
                                class="dropdown-item"
                                href="{{ route('profile') }}"
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

        <main class="content">
            <div class="container-fluid content-container">
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
                document.getElementById('sidebar');

            const sidebarToggle =
                document.getElementById('sidebarToggle');

            const sidebarOverlay =
                document.getElementById('sidebarOverlay');

            if (!sidebar || !sidebarToggle) {
                return;
            }

            const sidebarStorageKey =
                'adminSidebarCollapsed';

            function isMobile() {
                return window.innerWidth <= 1024;
            }

            function updateSidebarToggleState() {
                const isExpanded = isMobile()
                    ? sidebar.classList.contains('open')
                    : !sidebar.classList.contains('collapsed');

                sidebarToggle.setAttribute(
                    'aria-expanded',
                    isExpanded ? 'true' : 'false'
                );
            }

            function openMobileSidebar() {
                sidebar.classList.add('open');

                if (sidebarOverlay) {
                    sidebarOverlay.classList.add('show');
                }

                document.body.classList.add(
                    'sidebar-mobile-open'
                );

                updateSidebarToggleState();
            }

            function closeMobileSidebar() {
                sidebar.classList.remove('open');

                if (sidebarOverlay) {
                    sidebarOverlay.classList.remove('show');
                }

                document.body.classList.remove(
                    'sidebar-mobile-open'
                );

                updateSidebarToggleState();
            }

            function applyDesktopSidebarState() {
                const isCollapsed =
                    localStorage.getItem(
                        sidebarStorageKey
                    ) === 'true';

                sidebar.classList.toggle(
                    'collapsed',
                    isCollapsed
                );

                updateSidebarToggleState();
            }

            if (isMobile()) {
                sidebar.classList.remove('collapsed');
                closeMobileSidebar();
            } else {
                applyDesktopSidebarState();
            }

            sidebarToggle.addEventListener(
                'click',
                function () {
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
                        sidebarStorageKey,
                        sidebar.classList.contains(
                            'collapsed'
                        )
                    );

                    updateSidebarToggleState();
                }
            );

            if (sidebarOverlay) {
                sidebarOverlay.addEventListener(
                    'click',
                    closeMobileSidebar
                );
            }

            document.addEventListener(
                'keydown',
                function (event) {
                    if (
                        event.key === 'Escape' &&
                        isMobile()
                    ) {
                        closeMobileSidebar();
                    }
                }
            );

            window.addEventListener(
                'resize',
                function () {
                    if (isMobile()) {
                        sidebar.classList.remove('collapsed');
                        closeMobileSidebar();
                        return;
                    }

                    closeMobileSidebar();
                    applyDesktopSidebarState();
                }
            );

            /* Đóng sidebar mobile khi bấm menu */
            const sidebarLinks =
                sidebar.querySelectorAll('.nav-link');

            sidebarLinks.forEach(function (link) {
                link.addEventListener(
                    'click',
                    function () {
                        if (
                            isMobile() &&
                            !this.classList.contains(
                                'nav-link-disabled'
                            )
                        ) {
                            closeMobileSidebar();
                        }
                    }
                );
            });

            /* Đóng/mở từng nhóm menu */
            const navigationSections =
                sidebar.querySelectorAll(
                    '.nav-section[data-nav-section]'
                );

            navigationSections.forEach(function (section) {
                const toggle =
                    section.querySelector(
                        '.nav-section-toggle'
                    );

                const activeLink =
                    section.querySelector(
                        '.nav-link.active'
                    );

                const sectionName =
                    section.dataset.navSection;

                if (!toggle || !sectionName) {
                    return;
                }

                const sectionStorageKey =
                    'adminNavSection_' + sectionName;

                let isCollapsed =
                    localStorage.getItem(
                        sectionStorageKey
                    ) === 'true';

                /*
                 * Nhóm chứa trang hiện tại
                 * luôn tự mở.
                 */
                if (activeLink) {
                    isCollapsed = false;

                    toggle.classList.add(
                        'has-active'
                    );
                }

                section.classList.toggle(
                    'is-collapsed',
                    isCollapsed
                );

                toggle.setAttribute(
                    'aria-expanded',
                    isCollapsed ? 'false' : 'true'
                );

                toggle.addEventListener(
                    'click',
                    function () {
                        /*
                         * Khi sidebar thu gọn trên desktop,
                         * tiêu đề nhóm đang bị ẩn.
                         */
                        if (
                            sidebar.classList.contains(
                                'collapsed'
                            ) &&
                            !isMobile()
                        ) {
                            return;
                        }

                        const collapsed =
                            section.classList.toggle(
                                'is-collapsed'
                            );

                        toggle.setAttribute(
                            'aria-expanded',
                            collapsed
                                ? 'false'
                                : 'true'
                        );

                        localStorage.setItem(
                            sectionStorageKey,
                            collapsed
                                ? 'true'
                                : 'false'
                        );
                    }
                );
            });

            /* Tự cuộn tới menu active */
            const activeLink =
                sidebar.querySelector('.nav-link.active');

            if (activeLink) {
                setTimeout(function () {
                    activeLink.scrollIntoView({
                        behavior: 'smooth',
                        block: 'center'
                    });
                }, 150);
            }

            updateSidebarToggleState();
        });
    </script>

    @yield('scripts')
    @stack('scripts')
</body>

</html>