@extends('layouts.admin')

@section('title', 'Quản lý lịch khởi hành')

@section('content')
    <style>
        :root {
            --departure-primary: #315be8;
            --departure-primary-dark: #244bd2;
            --departure-primary-light: #edf4ff;
            --departure-purple: #5b4dea;
            --departure-cyan: #16c7e8;

            --departure-text-dark: #172b4d;
            --departure-text-main: #344563;
            --departure-text-muted: #6b7895;
            --departure-text-light: #98a2b3;

            --departure-border: #dce6f5;
            --departure-border-light: #e8eef8;

            --departure-white: #ffffff;
            --departure-soft: #f5f8ff;
            --departure-hover: #f3f7ff;

            --departure-success: #08754a;
            --departure-success-bg: #eaf9f1;

            --departure-warning: #ae6c0d;
            --departure-warning-bg: #fff7e8;

            --departure-danger: #c13d55;
            --departure-danger-bg: #fff0f3;

            --departure-info: #2855ce;
            --departure-info-bg: #edf4ff;

            --departure-neutral: #66738b;
            --departure-neutral-bg: #f1f4f8;

            --departure-dark: #374151;
            --departure-dark-bg: #eef0f4;
        }

        .departure-page {
            padding: 24px 0;
            color: var(--departure-text-dark);
        }

        /* Tiêu đề trang */
        .departure-page-top {
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            flex-wrap: wrap;
        }

        .departure-page-heading h3 {
            margin: 0;
            color: #173576;
            font-size: 23px;
            font-weight: 750;
            letter-spacing: -0.2px;
        }

        .departure-page-heading p {
            margin: 6px 0 0;
            color: var(--departure-text-muted);
            font-size: 14px;
        }

        .btn-add-departure {
            min-height: 41px;
            padding: 9px 16px;
            color: var(--departure-white);
            background: linear-gradient(
                135deg,
                #315be8 0%,
                #3c6df0 55%,
                #594bea 100%
            );
            border: 1px solid #315be8;
            border-radius: 9px;
            box-shadow: 0 6px 16px rgba(49, 91, 232, 0.23);
            font-size: 13px;
            font-weight: 700;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 7px;
            transition: all 0.18s ease;
        }

        .btn-add-departure:hover {
            color: var(--departure-white);
            background: linear-gradient(
                135deg,
                #264ed4 0%,
                #315edc 55%,
                #4d40d8 100%
            );
            border-color: #264ed4;
            box-shadow: 0 8px 20px rgba(49, 91, 232, 0.3);
            text-decoration: none;
            transform: translateY(-1px);
        }

        /* Thông báo */
        .departure-alert {
            margin-bottom: 18px;
            padding: 14px 16px;
            color: var(--departure-success);
            background: var(--departure-success-bg);
            border: 1px solid #bfead3;
            border-radius: 10px;
            box-shadow: 0 4px 14px rgba(16, 24, 40, 0.05);
            font-size: 13px;
            font-weight: 650;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        /* Thống kê */
        .departure-stats-grid {
            margin-bottom: 20px;
            display: grid;
            grid-template-columns: repeat(6, minmax(0, 1fr));
            gap: 12px;
        }

        .departure-stat-card {
            position: relative;
            min-height: 108px;
            padding: 16px;
            overflow: hidden;
            background: var(--departure-white);
            border: 1px solid var(--departure-border);
            border-radius: 12px;
            box-shadow: 0 6px 20px rgba(28, 65, 139, 0.07);
            display: flex;
            align-items: center;
            gap: 12px;
            transition:
                border-color 0.18s ease,
                box-shadow 0.18s ease,
                transform 0.18s ease;
        }

        .departure-stat-card::after {
            position: absolute;
            right: -30px;
            bottom: -40px;
            width: 92px;
            height: 92px;
            content: "";
            background: rgba(49, 91, 232, 0.045);
            border-radius: 50%;
        }

        .departure-stat-card:hover {
            border-color: #c4d7f6;
            box-shadow: 0 9px 24px rgba(38, 76, 148, 0.11);
            transform: translateY(-2px);
        }

        .departure-stat-icon {
            position: relative;
            z-index: 2;
            width: 42px;
            height: 42px;
            flex-shrink: 0;
            border: 1px solid transparent;
            border-radius: 11px;
            font-size: 15px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .stat-primary .departure-stat-icon {
            color: var(--departure-primary);
            background: var(--departure-primary-light);
            border-color: #cfe0ff;
        }

        .stat-success .departure-stat-icon {
            color: var(--departure-success);
            background: var(--departure-success-bg);
            border-color: #c5ead8;
        }

        .stat-warning .departure-stat-icon {
            color: var(--departure-warning);
            background: var(--departure-warning-bg);
            border-color: #f1dba9;
        }

        .stat-danger .departure-stat-icon {
            color: var(--departure-danger);
            background: var(--departure-danger-bg);
            border-color: #f0c9d1;
        }

        .stat-neutral .departure-stat-icon {
            color: var(--departure-neutral);
            background: var(--departure-neutral-bg);
            border-color: #dce2ea;
        }

        .stat-dark .departure-stat-icon {
            color: var(--departure-dark);
            background: var(--departure-dark-bg);
            border-color: #d7dce5;
        }

        .departure-stat-content {
            position: relative;
            z-index: 2;
            min-width: 0;
        }

        .departure-stat-value {
            color: #24417d;
            font-size: 22px;
            font-weight: 800;
            line-height: 1;
        }

        .departure-stat-label {
            margin-top: 7px;
            color: var(--departure-text-muted);
            font-size: 10px;
            font-weight: 650;
            line-height: 1.35;
        }

        /* Card chính */
        .departure-card {
            position: relative;
            overflow: hidden;
            background: var(--departure-white);
            border: 1px solid #d8e4f6;
            border-radius: 15px;
            box-shadow: 0 8px 30px rgba(28, 65, 139, 0.1);
        }

        .departure-card::before {
            position: absolute;
            top: 0;
            right: 0;
            left: 0;
            z-index: 3;
            height: 4px;
            content: "";
            background: linear-gradient(
                90deg,
                #2458e7,
                #3478ef,
                #18c7e7,
                #5947e9
            );
        }

        /* Header card */
        .departure-card-header {
            position: relative;
            min-height: 115px;
            padding: 24px;
            overflow: hidden;
            color: var(--departure-white);
            background: linear-gradient(
                120deg,
                #2856df 0%,
                #316cec 55%,
                #5b49e8 100%
            );
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
        }

        .departure-card-header::before {
            position: absolute;
            right: -50px;
            bottom: -105px;
            width: 235px;
            height: 235px;
            content: "";
            border: 21px solid rgba(255, 255, 255, 0.07);
            border-radius: 50%;
        }

        .departure-card-header::after {
            position: absolute;
            top: -85px;
            right: 115px;
            width: 175px;
            height: 175px;
            content: "";
            background: rgba(255, 255, 255, 0.045);
            border-radius: 50%;
        }

        .departure-card-heading {
            position: relative;
            z-index: 2;
            min-width: 0;
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .departure-card-icon {
            width: 46px;
            height: 46px;
            flex-shrink: 0;
            color: var(--departure-white);
            background: rgba(255, 255, 255, 0.16);
            border: 1px solid rgba(255, 255, 255, 0.3);
            border-radius: 12px;
            box-shadow: 0 7px 18px rgba(20, 43, 128, 0.2);
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .departure-card-icon i {
            font-size: 18px;
        }

        .departure-card-heading h4 {
            margin: 0;
            color: var(--departure-white);
            font-size: 20px;
            font-weight: 750;
        }

        .departure-card-heading p {
            margin: 6px 0 0;
            color: rgba(255, 255, 255, 0.82);
            font-size: 12px;
        }

        .departure-total {
            position: relative;
            z-index: 2;
            min-width: 112px;
            padding: 12px 15px;
            color: var(--departure-white);
            background: rgba(255, 255, 255, 0.14);
            border: 1px solid rgba(255, 255, 255, 0.25);
            border-radius: 11px;
            text-align: center;
            backdrop-filter: blur(4px);
        }

        .departure-total strong {
            display: block;
            font-size: 22px;
            line-height: 1;
        }

        .departure-total span {
            display: block;
            margin-top: 5px;
            font-size: 10px;
            opacity: 0.85;
        }

        .departure-card-body {
            padding: 22px;
        }

        /* Bộ lọc */
        .departure-filter-box {
            margin-bottom: 20px;
            padding: 16px;
            background: var(--departure-soft);
            border: 1px solid #d8e4f6;
            border-radius: 11px;
        }

        .departure-filter-title {
            margin-bottom: 13px;
            color: #29457d;
            font-size: 13px;
            font-weight: 750;
            display: flex;
            align-items: center;
            gap: 7px;
        }

        .departure-filter-title i {
            color: var(--departure-primary);
        }

        .departure-filter-form {
            display: grid;
            grid-template-columns:
                minmax(230px, 1fr)
                minmax(170px, 210px)
                minmax(155px, 185px)
                minmax(155px, 185px)
                auto
                auto;
            gap: 10px;
            align-items: end;
        }

        .departure-filter-field label {
            margin-bottom: 6px;
            color: #40537a;
            font-size: 12px;
            font-weight: 700;
            display: block;
        }

        .filter-control {
            position: relative;
        }

        .filter-icon {
            position: absolute;
            top: 50%;
            left: 12px;
            z-index: 2;
            color: #7686a5;
            font-size: 12px;
            pointer-events: none;
            transform: translateY(-50%);
        }

        .departure-filter-form .form-control,
        .departure-filter-form .form-select {
            width: 100%;
            min-height: 40px;
            color: #344563;
            background: var(--departure-white);
            border: 1px solid #ccd9ed;
            border-radius: 8px;
            font-size: 13px;
            box-shadow: none;
            transition:
                border-color 0.18s ease,
                box-shadow 0.18s ease;
        }

        .departure-filter-form .filter-control .form-control {
            padding-left: 34px;
        }

        .departure-filter-form .form-control::placeholder {
            color: #9ca8bd;
        }

        .departure-filter-form .form-control:focus,
        .departure-filter-form .form-select:focus {
            border-color: #4f78eb;
            outline: none;
            box-shadow: 0 0 0 3px rgba(49, 91, 232, 0.1);
        }

        .btn-filter-action {
            min-height: 40px;
            padding: 8px 14px;
            border: 1px solid transparent;
            border-radius: 8px;
            font-size: 12px;
            font-weight: 700;
            white-space: nowrap;
            text-decoration: none;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            transition: all 0.18s ease;
        }

        .btn-filter-action:hover {
            text-decoration: none;
            transform: translateY(-1px);
        }

        .btn-filter {
            color: var(--departure-white);
            background: linear-gradient(
                135deg,
                #315be8,
                #584be8
            );
            border-color: #315be8;
            box-shadow: 0 4px 11px rgba(49, 91, 232, 0.2);
        }

        .btn-filter:hover {
            color: var(--departure-white);
            background: linear-gradient(
                135deg,
                #264ed4,
                #4c40d7
            );
            box-shadow: 0 6px 14px rgba(49, 91, 232, 0.27);
        }

        .btn-reset {
            color: #53698f;
            background: var(--departure-white);
            border-color: #ccd9ed;
        }

        .btn-reset:hover {
            color: #304d83;
            background: #eaf1fb;
            border-color: #b9c9e0;
        }

        /* Bảng */
        .departure-table-wrapper {
            width: 100%;
            overflow-x: auto;
            border: 1px solid var(--departure-border);
            border-radius: 11px;
        }

        .departure-table-wrapper::-webkit-scrollbar {
            height: 8px;
        }

        .departure-table-wrapper::-webkit-scrollbar-track {
            background: #f2f5fa;
        }

        .departure-table-wrapper::-webkit-scrollbar-thumb {
            background: #c5d2e5;
            border-radius: 999px;
        }

        .departure-table {
            width: 100%;
            min-width: 1280px;
            margin-bottom: 0;
            color: var(--departure-text-dark);
            vertical-align: middle;
        }

        .departure-table thead th {
            padding: 14px;
            color: #24417d;
            background: #f1f6ff;
            border-top: none;
            border-bottom: 1px solid #d8e5f8;
            font-size: 10px;
            font-weight: 750;
            letter-spacing: 0.025em;
            text-transform: uppercase;
            white-space: nowrap;
        }

        .departure-table tbody td {
            padding: 13px 14px;
            color: #4d5d7d;
            border-bottom: 1px solid var(--departure-border-light);
            font-size: 12px;
            line-height: 1.55;
            vertical-align: middle;
        }

        .departure-table tbody tr:last-child td {
            border-bottom: none;
        }

        .departure-table tbody tr {
            transition:
                background-color 0.18s ease,
                box-shadow 0.18s ease;
        }

        .departure-table tbody tr:hover {
            background: var(--departure-hover);
            box-shadow: inset 3px 0 0 #3a67ea;
        }

        .departure-table th:nth-child(1),
        .departure-table td:nth-child(1) {
            width: 65px;
            text-align: center;
        }

        .departure-table th:nth-child(2),
        .departure-table td:nth-child(2) {
            width: 230px;
            text-align: left;
        }

        .departure-table th:nth-child(3),
        .departure-table td:nth-child(3) {
            width: 205px;
            text-align: left;
        }

        .departure-table th:nth-child(4),
        .departure-table td:nth-child(4) {
            width: 170px;
            text-align: center;
        }

        .departure-table th:nth-child(5),
        .departure-table td:nth-child(5) {
            width: 155px;
            text-align: center;
        }

        .departure-table th:nth-child(6),
        .departure-table td:nth-child(6) {
            width: 195px;
            text-align: right;
        }

        .departure-table th:nth-child(7),
        .departure-table td:nth-child(7) {
            width: 155px;
            text-align: center;
        }

        .departure-table th:nth-child(8),
        .departure-table td:nth-child(8) {
            width: 125px;
            text-align: center;
        }

        /* STT */
        .departure-index {
            min-width: 30px;
            height: 30px;
            padding: 0 8px;
            color: #3158ce;
            background: #edf3ff;
            border: 1px solid #d4e2ff;
            border-radius: 8px;
            font-size: 11px;
            font-weight: 750;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        /* Tour */
        .tour-name {
            max-width: 205px;
            overflow: hidden;
            color: #233f7a;
            font-size: 12px;
            font-weight: 750;
            text-overflow: ellipsis;
            white-space: nowrap;
            display: block;
        }

        .departure-code {
            margin-top: 4px;
            color: #8b97aa;
            font-size: 10px;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        /* Hướng dẫn viên */
        .guide-info {
            display: flex;
            align-items: center;
            gap: 9px;
        }

        .guide-avatar {
            width: 34px;
            height: 34px;
            flex-shrink: 0;
            color: var(--departure-white);
            background: linear-gradient(
                135deg,
                #315be8,
                #5b4dea
            );
            border-radius: 9px;
            box-shadow: 0 4px 10px rgba(49, 91, 232, 0.17);
            font-size: 12px;
            font-weight: 750;
            text-transform: uppercase;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .guide-name {
            max-width: 145px;
            overflow: hidden;
            color: #344563;
            font-size: 12px;
            font-weight: 700;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .guide-note {
            margin-top: 2px;
            color: #8b97aa;
            font-size: 9px;
        }

        .unassigned-badge {
            padding: 5px 9px;
            color: var(--departure-neutral);
            background: var(--departure-neutral-bg);
            border: 1px solid #dce2ea;
            border-radius: 999px;
            font-size: 9px;
            font-weight: 700;
            white-space: nowrap;
        }

        /* Thời gian */
        .departure-date {
            color: #40537a;
            font-size: 12px;
            font-weight: 700;
            white-space: nowrap;
        }

        .departure-date i {
            margin-right: 5px;
            color: #5f7fd3;
            font-size: 10px;
        }

        .departure-end-date {
            margin-top: 4px;
            color: #8b97aa;
            font-size: 10px;
            white-space: nowrap;
        }

        /* Số chỗ */
        .seat-badge {
            padding: 5px 9px;
            border: 1px solid transparent;
            border-radius: 999px;
            font-size: 9px;
            font-weight: 750;
            white-space: nowrap;
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }

        .seat-low {
            color: var(--departure-success);
            background: var(--departure-success-bg);
            border-color: #c5ead8;
        }

        .seat-medium {
            color: var(--departure-warning);
            background: var(--departure-warning-bg);
            border-color: #f1dba9;
        }

        .seat-high {
            color: var(--departure-danger);
            background: var(--departure-danger-bg);
            border-color: #f0c9d1;
        }

        .remaining-seat {
            margin-top: 5px;
            color: #8490a6;
            font-size: 10px;
        }

        .merged-note {
            margin-top: 5px;
            color: var(--departure-danger);
            font-size: 9px;
            font-weight: 650;
        }

        /* Giá */
        .adult-price {
            color: #3158ce;
            font-size: 11px;
            font-weight: 800;
            white-space: nowrap;
        }

        .child-price {
            margin-top: 4px;
            color: #7c899f;
            font-size: 10px;
            white-space: nowrap;
        }

        /* Trạng thái */
        .departure-status {
            padding: 5px 10px;
            border: 1px solid transparent;
            border-radius: 999px;
            font-size: 9px;
            font-weight: 750;
            white-space: nowrap;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 5px;
        }

        .status-dot {
            width: 6px;
            height: 6px;
            flex-shrink: 0;
            border-radius: 50%;
            background: currentColor;
        }

        .status-open {
            color: var(--departure-success);
            background: var(--departure-success-bg);
            border-color: #c5ead8;
        }

        .status-running {
            color: var(--departure-warning);
            background: var(--departure-warning-bg);
            border-color: #f1dba9;
        }

        .status-full {
            color: var(--departure-danger);
            background: var(--departure-danger-bg);
            border-color: #f0c9d1;
        }

        .status-ended {
            color: var(--departure-neutral);
            background: var(--departure-neutral-bg);
            border-color: #dce2ea;
        }

        .status-closed {
            color: var(--departure-info);
            background: var(--departure-info-bg);
            border-color: #c9dcff;
        }

        .status-cancelled,
        .status-merged {
            color: var(--departure-dark);
            background: var(--departure-dark-bg);
            border-color: #d7dce5;
        }

        /* Hành động */
        .departure-actions {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 5px;
            flex-wrap: nowrap;
        }

        .departure-actions form {
            display: inline-flex;
            margin: 0;
        }

        .btn-table-action {
            width: 30px;
            height: 30px;
            padding: 0;
            border: 1px solid transparent;
            border-radius: 7px;
            font-size: 11px;
            cursor: pointer;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            transition: all 0.16s ease;
        }

        .btn-table-action:hover {
            text-decoration: none;
            transform: translateY(-2px);
        }

        .btn-view {
            color: #2d5fd7;
            background: #eaf2ff;
            border-color: #c7dafe;
        }

        .btn-view:hover {
            color: var(--departure-white);
            background: #3867e5;
            border-color: #3867e5;
            box-shadow: 0 5px 12px rgba(56, 103, 229, 0.25);
        }

        .btn-edit {
            color: var(--departure-warning);
            background: var(--departure-warning-bg);
            border-color: #f1dba9;
        }

        .btn-edit:hover {
            color: var(--departure-white);
            background: #e39a25;
            border-color: #e39a25;
            box-shadow: 0 5px 12px rgba(227, 154, 37, 0.24);
        }

        .btn-delete {
            color: var(--departure-danger);
            background: var(--departure-danger-bg);
            border-color: #f0c9d1;
        }

        .btn-delete:hover {
            color: var(--departure-white);
            background: #df5067;
            border-color: #df5067;
            box-shadow: 0 5px 12px rgba(223, 80, 103, 0.23);
        }

        .btn-table-action:focus {
            outline: none;
            box-shadow: 0 0 0 3px rgba(49, 91, 232, 0.14);
        }

        /* Không có dữ liệu */
        .departure-empty-row {
            padding: 52px 20px !important;
            color: #8793aa !important;
            text-align: center !important;
        }

        .empty-state-icon {
            width: 52px;
            height: 52px;
            margin: 0 auto 12px;
            color: #3664dd;
            background: #edf3ff;
            border: 1px solid #d3e1ff;
            border-radius: 13px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .empty-state-icon i {
            font-size: 20px;
        }

        .empty-state-title {
            color: #506181;
            font-size: 14px;
            font-weight: 700;
        }

        .empty-state-text {
            margin-top: 4px;
            font-size: 12px;
        }

        /* Footer và phân trang */
        .departure-card-footer {
            padding: 16px 22px;
            background: #fafcff;
            border-top: 1px solid var(--departure-border);
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
        }

        .departure-result-info {
            color: var(--departure-text-muted);
            font-size: 11px;
        }

        .departure-card-footer .pagination {
            margin: 0;
            gap: 4px;
        }

        .departure-card-footer .page-link {
            min-width: 34px;
            height: 34px;
            padding: 6px 10px;
            color: #3158ce;
            background: var(--departure-white);
            border: 1px solid #d6e1f2;
            border-radius: 7px !important;
            font-size: 12px;
            box-shadow: none;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .departure-card-footer .page-link:hover {
            color: var(--departure-white);
            background: #416ce5;
            border-color: #416ce5;
        }

        .departure-card-footer .page-item.active .page-link {
            color: var(--departure-white);
            background: linear-gradient(
                135deg,
                #315be8,
                #584be8
            );
            border-color: #315be8;
        }

        .departure-card-footer .page-item.disabled .page-link {
            color: #aab3c5;
            background: #f8f9fc;
        }

        /* Responsive */
        @media (max-width: 1350px) {
            .departure-stats-grid {
                grid-template-columns: repeat(3, minmax(0, 1fr));
            }

            .departure-filter-form {
                grid-template-columns: repeat(3, minmax(0, 1fr));
            }

            .btn-filter-action {
                width: 100%;
            }
        }

        @media (max-width: 992px) {
            .departure-stats-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }

            .departure-filter-form {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }

        @media (max-width: 768px) {
            .departure-page {
                padding: 14px 0;
            }

            .departure-page-top {
                align-items: stretch;
                flex-direction: column;
            }

            .departure-page-heading h3 {
                font-size: 20px;
            }

            .btn-add-departure {
                width: 100%;
            }

            .departure-card {
                border-radius: 11px;
            }

            .departure-card-header {
                min-height: 105px;
                padding: 20px 18px;
            }

            .departure-card-body {
                padding: 16px;
            }

            .departure-filter-box {
                padding: 14px;
            }

            .departure-filter-form {
                grid-template-columns: 1fr;
            }

            .departure-card-footer {
                align-items: stretch;
                flex-direction: column;
            }

            .departure-result-info {
                text-align: center;
            }
        }

        @media (max-width: 520px) {
            .departure-stats-grid {
                grid-template-columns: 1fr;
            }

            .departure-card-header {
                align-items: flex-start;
                flex-direction: column;
            }

            .departure-total {
                min-width: 100px;
                padding: 10px 13px;
            }
        }
    </style>

    <div class="container-fluid departure-page fade-in">
        <div class="departure-page-top">
            <div class="departure-page-heading">
                <h3>Quản lý lịch khởi hành</h3>

                <p>
                    Theo dõi thời gian, số chỗ, giá bán và trạng thái các chuyến
                    khởi hành.
                </p>
            </div>

            <a
                href="{{ route('Admin.lich-khoi-hanh.create') }}"
                class="btn-add-departure"
            >
                <i class="fas fa-plus"></i>
                Thêm lịch mới
            </a>
        </div>

        @if (session('success'))
            <div class="departure-alert">
                <i class="fas fa-check-circle"></i>
                {{ session('success') }}
            </div>
        @endif

        <div class="departure-stats-grid">
            <div class="departure-stat-card stat-primary">
                <span class="departure-stat-icon">
                    <i class="fas fa-calendar-alt"></i>
                </span>

                <div class="departure-stat-content">
                    <div class="departure-stat-value">
                        {{ $data->total() }}
                    </div>

                    <div class="departure-stat-label">
                        Tổng lịch khởi hành
                    </div>
                </div>
            </div>

            <div class="departure-stat-card stat-success">
                <span class="departure-stat-icon">
                    <i class="fas fa-check"></i>
                </span>

                <div class="departure-stat-content">
                    <div class="departure-stat-value">
                        {{ $moBan }}
                    </div>

                    <div class="departure-stat-label">
                        Đang mở bán
                    </div>
                </div>
            </div>

            <div class="departure-stat-card stat-warning">
                <span class="departure-stat-icon">
                    <i class="fas fa-route"></i>
                </span>

                <div class="departure-stat-content">
                    <div class="departure-stat-value">
                        {{ $dangDienRa }}
                    </div>

                    <div class="departure-stat-label">
                        Đang diễn ra
                    </div>
                </div>
            </div>

            <div class="departure-stat-card stat-danger">
                <span class="departure-stat-icon">
                    <i class="fas fa-users-slash"></i>
                </span>

                <div class="departure-stat-content">
                    <div class="departure-stat-value">
                        {{ $hetCho }}
                    </div>

                    <div class="departure-stat-label">
                        Đã hết chỗ
                    </div>
                </div>
            </div>

            <div class="departure-stat-card stat-neutral">
                <span class="departure-stat-icon">
                    <i class="fas fa-flag-checkered"></i>
                </span>

                <div class="departure-stat-content">
                    <div class="departure-stat-value">
                        {{ $daKetThuc }}
                    </div>

                    <div class="departure-stat-label">
                        Đã kết thúc
                    </div>
                </div>
            </div>

            <div class="departure-stat-card stat-dark">
                <span class="departure-stat-icon">
                    <i class="fas fa-lock"></i>
                </span>

                <div class="departure-stat-content">
                    <div class="departure-stat-value">
                        {{ $daDong }}
                    </div>

                    <div class="departure-stat-label">
                        Đã đóng
                    </div>
                </div>
            </div>
        </div>

        <div class="departure-card">
            <div class="departure-card-header">
                <div class="departure-card-heading">
                    <span class="departure-card-icon">
                        <i class="fas fa-plane-departure"></i>
                    </span>

                    <div>
                        <h4>Danh sách lịch khởi hành</h4>

                        <p>
                            Quản lý lịch chạy, hướng dẫn viên, số chỗ và giá bán.
                        </p>
                    </div>
                </div>

                <div class="departure-total">
                    <strong>{{ $data->total() }}</strong>
                    <span>Lịch khởi hành</span>
                </div>
            </div>

            <div class="departure-card-body">
                <div class="departure-filter-box">
                    <div class="departure-filter-title">
                        <i class="fas fa-filter"></i>
                        Bộ lọc lịch khởi hành
                    </div>

                    <form
                        method="GET"
                        action="{{ route('Admin.lich-khoi-hanh.index') }}"
                        class="departure-filter-form"
                    >
                        <div class="departure-filter-field">
                            <label for="keyword">Tìm kiếm Tour</label>

                            <div class="filter-control">
                                <i class="fas fa-search filter-icon"></i>

                                <input
                                    type="text"
                                    name="keyword"
                                    id="keyword"
                                    class="form-control"
                                    placeholder="Nhập tên Tour..."
                                    value="{{ request('keyword') }}"
                                    autocomplete="off"
                                >
                            </div>
                        </div>

                        <div class="departure-filter-field">
                            <label for="status">Trạng thái</label>

                            <select
                                name="status"
                                id="status"
                                class="form-select"
                            >
                                <option value="">
                                    Tất cả trạng thái
                                </option>

                                <option
                                    value="Mở bán"
                                    @selected(request('status') === 'Mở bán')
                                >
                                    Mở bán
                                </option>

                                <option
                                    value="Đang diễn ra"
                                    @selected(request('status') === 'Đang diễn ra')
                                >
                                    Đang diễn ra
                                </option>

                                <option
                                    value="Hết chỗ"
                                    @selected(request('status') === 'Hết chỗ')
                                >
                                    Hết chỗ
                                </option>

                                <option
                                    value="Đã kết thúc"
                                    @selected(request('status') === 'Đã kết thúc')
                                >
                                    Đã kết thúc
                                </option>

                                <option
                                    value="Đã đóng"
                                    @selected(request('status') === 'Đã đóng')
                                >
                                    Đã đóng
                                </option>

                                <option
                                    value="Đã hủy"
                                    @selected(request('status') === 'Đã hủy')
                                >
                                    Đã hủy
                                </option>
                            </select>
                        </div>

                        <div class="departure-filter-field">
                            <label for="from_date">Từ ngày</label>

                            <input
                                type="date"
                                name="from_date"
                                id="from_date"
                                class="form-control"
                                value="{{ request('from_date') }}"
                            >
                        </div>

                        <div class="departure-filter-field">
                            <label for="to_date">Đến ngày</label>

                            <input
                                type="date"
                                name="to_date"
                                id="to_date"
                                class="form-control"
                                value="{{ request('to_date') }}"
                            >
                        </div>

                        <button
                            type="submit"
                            class="btn-filter-action btn-filter"
                        >
                            <i class="fas fa-search"></i>
                            Tìm kiếm
                        </button>

                        <a
                            href="{{ route('Admin.lich-khoi-hanh.index') }}"
                            class="btn-filter-action btn-reset"
                        >
                            <i class="fas fa-sync-alt"></i>
                            Làm mới
                        </a>
                    </form>
                </div>

                <div class="departure-table-wrapper">
                    <table class="table departure-table">
                        <thead>
                            <tr>
                                <th>STT</th>
                                <th>Tour</th>
                                <th>Hướng dẫn viên</th>
                                <th>Thời gian</th>
                                <th>Số chỗ</th>
                                <th>Giá</th>
                                <th>Trạng thái</th>
                                <th>Thao tác</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse ($data as $item)
                                @php
                                    $tyLe = $item->so_cho > 0
                                        ? ($item->so_cho_da_dat / $item->so_cho) * 100
                                        : 0;

                                    $seatClass = $tyLe < 50
                                        ? 'seat-low'
                                        : ($tyLe < 80
                                            ? 'seat-medium'
                                            : 'seat-high');

                                    $statusConfig = match ($item->trang_thai_hien_thi) {
                                        'Mở bán' => [
                                            'class' => 'status-open',
                                            'label' => 'Mở bán',
                                        ],
                                        'Đang diễn ra' => [
                                            'class' => 'status-running',
                                            'label' => 'Đang diễn ra',
                                        ],
                                        'Hết chỗ' => [
                                            'class' => 'status-full',
                                            'label' => 'Hết chỗ',
                                        ],
                                        'Đã kết thúc' => [
                                            'class' => 'status-ended',
                                            'label' => 'Đã kết thúc',
                                        ],
                                        'Đã đóng' => [
                                            'class' => 'status-closed',
                                            'label' => 'Đã đóng',
                                        ],
                                        'Đã hủy' => [
                                            'class' => 'status-cancelled',
                                            'label' => 'Đã hủy',
                                        ],
                                        default => [
                                            'class' => 'status-ended',
                                            'label' => $item->trang_thai_hien_thi ?: 'Không xác định',
                                        ],
                                    };
                                @endphp

                                <tr>
                                    <td>
                                        <span class="departure-index">
                                            {{ ($data->currentPage() - 1)
                                                * $data->perPage()
                                                + $loop->iteration }}
                                        </span>
                                    </td>

                                    <td>
                                        <span
                                            class="tour-name"
                                            title="{{ $item->tour->ten_tour ?? 'Không có Tour' }}"
                                        >
                                            {{ $item->tour->ten_tour ?? 'Không có Tour' }}
                                        </span>

                                        <span class="departure-code">
                                            <i class="fas fa-hashtag"></i>
                                            Lịch khởi hành {{ $item->id }}
                                        </span>
                                    </td>

                                    <td>
                                        @if ($item->huongDanVien)
                                            <div class="guide-info">
                                                <span class="guide-avatar">
                                                    {{ mb_strtoupper(
                                                        mb_substr(
                                                            $item->huongDanVien->ho_ten ?: 'H',
                                                            0,
                                                            1
                                                        )
                                                    ) }}
                                                </span>

                                                <div>
                                                    <div
                                                        class="guide-name"
                                                        title="{{ $item->huongDanVien->ho_ten }}"
                                                    >
                                                        {{ $item->huongDanVien->ho_ten }}
                                                    </div>

                                                    <div class="guide-note">
                                                        HDV phụ trách
                                                    </div>
                                                </div>
                                            </div>
                                        @else
                                            <span class="unassigned-badge">
                                                Chưa phân công
                                            </span>
                                        @endif
                                    </td>

                                    <td>
                                        <div class="departure-date">
                                            <i class="fas fa-calendar-alt"></i>

                                            {{ \Carbon\Carbon::parse(
                                                $item->ngay_khoi_hanh
                                            )->format('d/m/Y') }}
                                        </div>

                                        <div class="departure-end-date">
                                            đến
                                            {{ \Carbon\Carbon::parse(
                                                $item->ngay_ket_thuc
                                            )->format('d/m/Y') }}
                                        </div>
                                    </td>

                                    <td>
                                        <span class="seat-badge {{ $seatClass }}">
                                            <i class="fas fa-users"></i>

                                            {{ $item->so_cho_da_dat }}/{{ $item->so_cho }}
                                        </span>

                                        <div class="remaining-seat">
                                            Còn {{ $item->so_cho_con_lai }} chỗ
                                        </div>

                                        @if ($item->da_gop)
                                            <div class="merged-note">
                                                <i class="fas fa-code-branch"></i>
                                                Gộp vào lịch
                                                #{{ $item->gop_vao_lich_id }}
                                            </div>
                                        @endif
                                    </td>

                                    <td>
                                        <div class="adult-price">
                                            Người lớn:
                                            {{ number_format(
                                                $item->gia_nguoi_lon,
                                                0,
                                                ',',
                                                '.'
                                            ) }}₫
                                        </div>

                                        <div class="child-price">
                                            Trẻ em:
                                            {{ number_format(
                                                $item->gia_tre_em,
                                                0,
                                                ',',
                                                '.'
                                            ) }}₫
                                        </div>
                                    </td>

                                    <td>
                                        @if ($item->da_gop)
                                            <span class="departure-status status-merged">
                                                <span class="status-dot"></span>
                                                Đã gộp
                                            </span>
                                        @else
                                            <span class="departure-status {{ $statusConfig['class'] }}">
                                                <span class="status-dot"></span>
                                                {{ $statusConfig['label'] }}
                                            </span>
                                        @endif
                                    </td>

                                    <td>
                                        <div class="departure-actions">
                                            <a
                                                href="{{ route('Admin.lich-khoi-hanh.show', $item->id) }}"
                                                class="btn-table-action btn-view"
                                                title="Xem chi tiết"
                                            >
                                                <i class="fas fa-eye"></i>
                                            </a>

                                            <a
                                                href="{{ route('Admin.lich-khoi-hanh.edit', $item->id) }}"
                                                class="btn-table-action btn-edit"
                                                title="Chỉnh sửa"
                                            >
                                                <i class="fas fa-edit"></i>
                                            </a>

                                            <form
                                                action="{{ route('Admin.lich-khoi-hanh.destroy', $item->id) }}"
                                                method="POST"
                                            >
                                                @csrf
                                                @method('DELETE')

                                                <button
                                                    type="button"
                                                    class="btn-table-action btn-delete"
                                                    title="Xóa lịch khởi hành"
                                                >
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td
                                        colspan="8"
                                        class="departure-empty-row"
                                    >
                                        <div class="empty-state-icon">
                                            <i class="fas fa-calendar-times"></i>
                                        </div>

                                        <div class="empty-state-title">
                                            Chưa có lịch khởi hành
                                        </div>

                                        <div class="empty-state-text">
                                            Không tìm thấy dữ liệu phù hợp với
                                            điều kiện lọc.
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="departure-card-footer">
                <div class="departure-result-info">
                    @if ($data->total() > 0)
                        Hiển thị {{ $data->firstItem() }}
                        đến {{ $data->lastItem() }}
                        trong tổng số {{ $data->total() }} lịch khởi hành
                    @else
                        Không có lịch khởi hành nào
                    @endif
                </div>

                {{ $data->withQueryString()->links() }}
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            document
                .querySelectorAll('.btn-delete')
                .forEach(function (button) {
                    button.addEventListener('click', function () {
                        const form = this.closest('form');

                        if (!form) {
                            return;
                        }

                        if (typeof Swal !== 'undefined') {
                            Swal.fire({
                                title: 'Xóa lịch khởi hành?',
                                text: 'Dữ liệu sau khi xóa sẽ không thể khôi phục.',
                                icon: 'warning',
                                showCancelButton: true,
                                confirmButtonText: 'Xóa',
                                cancelButtonText: 'Hủy',
                                confirmButtonColor: '#dc4c64',
                                cancelButtonColor: '#6b7895',
                                reverseButtons: true
                            }).then(function (result) {
                                if (result.isConfirmed) {
                                    form.submit();
                                }
                            });

                            return;
                        }

                        if (
                            confirm(
                                'Bạn có chắc muốn xóa lịch khởi hành này?'
                            )
                        ) {
                            form.submit();
                        }
                    });
                });
        });
    </script>
@endsection
