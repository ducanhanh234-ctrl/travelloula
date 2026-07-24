@extends('layouts.admin')

@section('title', 'Quản lý đặt Tour')

@section('content')
<style>
    :root {
        --booking-primary: #315be8;
        --booking-primary-dark: #244bd2;
        --booking-primary-light: #edf4ff;
        --booking-purple: #5b4dea;

        --booking-text-dark: #172b4d;
        --booking-text-main: #344563;
        --booking-text-muted: #6b7895;
        --booking-text-light: #98a2b3;

        --booking-border: #dce6f5;
        --booking-border-light: #e8eef8;

        --booking-white: #ffffff;
        --booking-soft: #f5f8ff;
        --booking-hover: #f3f7ff;

        --booking-success: #08754a;
        --booking-success-bg: #eaf9f1;

        --booking-warning: #ae6c0d;
        --booking-warning-bg: #fff7e8;

        --booking-danger: #c13d55;
        --booking-danger-bg: #fff0f3;

        --booking-info: #2855ce;
        --booking-info-bg: #edf4ff;

        --booking-neutral: #66738b;
        --booking-neutral-bg: #f1f4f8;
    }

    .booking-management-page {
        padding: 24px 0;
        color: var(--booking-text-dark);
    }

    /* Header trang */
    .booking-page-top {
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 16px;
        flex-wrap: wrap;
    }

    .booking-page-heading {
        display: flex;
        align-items: center;
        gap: 13px;
    }

    .booking-page-icon {
        width: 47px;
        height: 47px;
        flex-shrink: 0;
        color: var(--booking-primary);
        background: var(--booking-primary-light);
        border: 1px solid #cfe0ff;
        border-radius: 12px;
        font-size: 18px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }

    .booking-page-heading h3 {
        margin: 0;
        color: #173576;
        font-size: 23px;
        font-weight: 750;
        letter-spacing: -0.2px;
    }

    .booking-page-heading p {
        margin: 6px 0 0;
        color: var(--booking-text-muted);
        font-size: 14px;
    }

    .booking-page-actions {
        display: flex;
        align-items: center;
        gap: 9px;
        flex-wrap: wrap;
    }

    .btn-page-action {
        min-height: 41px;
        padding: 9px 16px;
        border: 1px solid transparent;
        border-radius: 9px;
        font-size: 13px;
        font-weight: 700;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 7px;
        transition: all 0.18s ease;
    }

    .btn-page-action:hover {
        text-decoration: none;
        transform: translateY(-1px);
    }

    .btn-add-booking {
        color: var(--booking-white);
        background: linear-gradient(135deg,
                #315be8 0%,
                #3c6df0 55%,
                #594bea 100%);
        border-color: #315be8;
        box-shadow: 0 6px 16px rgba(49, 91, 232, 0.23);
    }

    .btn-add-booking:hover {
        color: var(--booking-white);
        background: linear-gradient(135deg,
                #264ed4 0%,
                #315edc 55%,
                #4d40d8 100%);
        border-color: #264ed4;
        box-shadow: 0 8px 20px rgba(49, 91, 232, 0.3);
    }

    .btn-trash {
        color: #bd4057;
        background: var(--booking-danger-bg);
        border-color: #efc7cf;
    }

    .btn-trash:hover {
        color: var(--booking-white);
        background: #dc4c64;
        border-color: #dc4c64;
        box-shadow: 0 6px 15px rgba(220, 76, 100, 0.22);
    }

    /* Thông báo */
    .booking-alert {
        margin-bottom: 18px;
        padding: 14px 16px;
        color: var(--booking-success);
        background: var(--booking-success-bg);
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
    .booking-stats-grid {
        margin-bottom: 20px;
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: 14px;
    }

    .booking-stat-card {
        position: relative;
        min-height: 108px;
        padding: 17px;
        overflow: hidden;
        background: var(--booking-white);
        border: 1px solid var(--booking-border);
        border-radius: 12px;
        box-shadow: 0 6px 20px rgba(28, 65, 139, 0.07);
        display: flex;
        align-items: center;
        gap: 14px;
        transition: all 0.18s ease;
    }

    .booking-stat-card::after {
        position: absolute;
        right: -26px;
        bottom: -35px;
        width: 90px;
        height: 90px;
        content: "";
        background: rgba(49, 91, 232, 0.045);
        border-radius: 50%;
    }

    .booking-stat-card:hover {
        border-color: #c4d7f6;
        box-shadow: 0 9px 24px rgba(38, 76, 148, 0.11);
        transform: translateY(-2px);
    }

    .booking-stat-icon {
        position: relative;
        z-index: 2;
        width: 45px;
        height: 45px;
        flex-shrink: 0;
        border: 1px solid transparent;
        border-radius: 12px;
        font-size: 16px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }

    .stat-primary .booking-stat-icon {
        color: var(--booking-primary);
        background: var(--booking-primary-light);
        border-color: #cfe0ff;
    }

    .stat-info .booking-stat-icon {
        color: #24669e;
        background: #ebf7ff;
        border-color: #c9e7fa;
    }

    .stat-purple .booking-stat-icon {
        color: #7751c9;
        background: #f4efff;
        border-color: #dfd2fa;
    }

    .stat-success .booking-stat-icon {
        color: var(--booking-success);
        background: var(--booking-success-bg);
        border-color: #c5ead8;
    }

    .booking-stat-content {
        position: relative;
        z-index: 2;
        min-width: 0;
    }

    .booking-stat-value {
        color: #24417d;
        font-size: 23px;
        font-weight: 800;
        line-height: 1.1;
    }

    .booking-stat-value.revenue {
        font-size: 19px;
    }

    .booking-stat-label {
        margin-top: 7px;
        color: var(--booking-text-muted);
        font-size: 11px;
        font-weight: 650;
    }

    /* Card chính */
    .booking-card {
        position: relative;
        overflow: hidden;
        background: var(--booking-white);
        border: 1px solid #d8e4f6;
        border-radius: 15px;
        box-shadow: 0 8px 30px rgba(28, 65, 139, 0.1);
    }

    .booking-card::before {
        position: absolute;
        top: 0;
        right: 0;
        left: 0;
        z-index: 3;
        height: 4px;
        content: "";
        background: linear-gradient(90deg,
                #2458e7,
                #3478ef,
                #18c7e7,
                #5947e9);
    }

    .booking-card-header {
        position: relative;
        min-height: 115px;
        padding: 24px;
        overflow: hidden;
        color: var(--booking-white);
        background: linear-gradient(120deg,
                #2856df 0%,
                #316cec 55%,
                #5b49e8 100%);
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 16px;
    }

    .booking-card-header::before {
        position: absolute;
        right: -50px;
        bottom: -105px;
        width: 235px;
        height: 235px;
        content: "";
        border: 21px solid rgba(255, 255, 255, 0.07);
        border-radius: 50%;
    }

    .booking-card-header::after {
        position: absolute;
        top: -85px;
        right: 115px;
        width: 175px;
        height: 175px;
        content: "";
        background: rgba(255, 255, 255, 0.045);
        border-radius: 50%;
    }

    .booking-card-heading {
        position: relative;
        z-index: 2;
        display: flex;
        align-items: center;
        gap: 14px;
    }

    .booking-card-icon {
        width: 46px;
        height: 46px;
        flex-shrink: 0;
        color: var(--booking-white);
        background: rgba(255, 255, 255, 0.16);
        border: 1px solid rgba(255, 255, 255, 0.3);
        border-radius: 12px;
        box-shadow: 0 7px 18px rgba(20, 43, 128, 0.2);
        font-size: 18px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }

    .booking-card-heading h4 {
        margin: 0;
        color: var(--booking-white);
        font-size: 20px;
        font-weight: 750;
    }

    .booking-card-heading p {
        margin: 6px 0 0;
        color: rgba(255, 255, 255, 0.82);
        font-size: 12px;
    }

    .booking-total {
        position: relative;
        z-index: 2;
        min-width: 105px;
        padding: 12px 15px;
        color: var(--booking-white);
        background: rgba(255, 255, 255, 0.14);
        border: 1px solid rgba(255, 255, 255, 0.25);
        border-radius: 11px;
        text-align: center;
    }

    .booking-total strong {
        display: block;
        font-size: 22px;
        line-height: 1;
    }

    .booking-total span {
        display: block;
        margin-top: 5px;
        font-size: 10px;
        opacity: 0.85;
    }

    .booking-card-body {
        padding: 22px;
    }

    /* Bộ lọc */
    .booking-filter-box {
        margin-bottom: 20px;
        padding: 16px;
        background: var(--booking-soft);
        border: 1px solid #d8e4f6;
        border-radius: 11px;
    }

    .booking-filter-title {
        margin-bottom: 13px;
        color: #29457d;
        font-size: 13px;
        font-weight: 750;
        display: flex;
        align-items: center;
        gap: 7px;
    }

    .booking-filter-title i {
        color: var(--booking-primary);
    }

    .booking-filter-form {
        display: grid;
        grid-template-columns:
            minmax(280px, 1fr) minmax(210px, 280px) auto auto;
        gap: 10px;
        align-items: end;
    }

    .booking-filter-field label {
        margin-bottom: 6px;
        color: #40537a;
        font-size: 12px;
        font-weight: 700;
        display: block;
    }

    .booking-filter-control {
        position: relative;
    }

    .booking-filter-icon {
        position: absolute;
        top: 50%;
        left: 12px;
        z-index: 2;
        color: #7686a5;
        font-size: 12px;
        pointer-events: none;
        transform: translateY(-50%);
    }

    .booking-filter-form .form-control,
    .booking-filter-form .form-select {
        width: 100%;
        min-height: 40px;
        color: #344563;
        background: var(--booking-white);
        border: 1px solid #ccd9ed;
        border-radius: 8px;
        font-size: 13px;
        box-shadow: none;
    }

    .booking-filter-control .form-control {
        padding-left: 34px;
    }

    .booking-filter-form .form-control::placeholder {
        color: #9ca8bd;
    }

    .booking-filter-form .form-control:focus,
    .booking-filter-form .form-select:focus {
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
        cursor: pointer;
        text-decoration: none;
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
        color: var(--booking-white);
        background: linear-gradient(135deg,
                #315be8,
                #584be8);
        border-color: #315be8;
        box-shadow: 0 4px 11px rgba(49, 91, 232, 0.2);
    }

    .btn-filter:hover {
        color: var(--booking-white);
        background: linear-gradient(135deg,
                #264ed4,
                #4c40d7);
    }

    .btn-reset {
        color: #53698f;
        background: var(--booking-white);
        border-color: #ccd9ed;
    }

    .btn-reset:hover {
        color: #304d83;
        background: #eaf1fb;
        border-color: #b9c9e0;
    }

    /* Bảng */
    .booking-table-wrapper {
        width: 100%;
        overflow-x: auto;
        border: 1px solid var(--booking-border);
        border-radius: 11px;
    }

    .booking-table-wrapper::-webkit-scrollbar {
        height: 8px;
    }

    .booking-table-wrapper::-webkit-scrollbar-track {
        background: #f2f5fa;
    }

    .booking-table-wrapper::-webkit-scrollbar-thumb {
        background: #c5d2e5;
        border-radius: 999px;
    }

    .booking-table {
        width: 100%;
        min-width: 1350px;
        margin-bottom: 0;
        vertical-align: middle;
    }

    .booking-table thead th {
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

    .booking-table tbody td {
        padding: 14px;
        color: #4d5d7d;
        border-bottom: 1px solid var(--booking-border-light);
        font-size: 12px;
        line-height: 1.55;
        vertical-align: middle;
    }

    .booking-table tbody tr:last-child td {
        border-bottom: none;
    }

    .booking-table tbody tr {
        transition:
            background-color 0.18s ease,
            box-shadow 0.18s ease;
    }

    .booking-table tbody tr:hover {
        background: var(--booking-hover);
        box-shadow: inset 3px 0 0 #3a67ea;
    }

    .booking-table th:nth-child(1),
    .booking-table td:nth-child(1) {
        width: 155px;
        text-align: center;
    }

    .booking-table th:nth-child(2),
    .booking-table td:nth-child(2) {
        width: 285px;
    }

    .booking-table th:nth-child(3),
    .booking-table td:nth-child(3) {
        width: 145px;
        text-align: center;
    }

    .booking-table th:nth-child(4),
    .booking-table td:nth-child(4) {
        width: 190px;
        text-align: right;
    }

    .booking-table th:nth-child(5),
    .booking-table td:nth-child(5) {
        width: 190px;
    }

    .booking-table th:nth-child(6),
    .booking-table td:nth-child(6) {
        width: 140px;
        text-align: center;
    }

    .booking-table th:nth-child(7),
    .booking-table td:nth-child(7) {
        width: 165px;
        text-align: center;
    }

    .booking-table th:nth-child(8),
    .booking-table td:nth-child(8) {
        width: 110px;
        text-align: center;
    }

    /* Ngày */
    .departure-date {
        color: #29457d;

        font-size: 12px;
        font-weight: 750;
        white-space: nowrap;
    }

    .departure-date i {
        margin-right: 5px;
        color: #4d72da;
        font-size: 10px;
    }

    .booking-created-date {
        margin-top: 4px;
        color: #8b97aa;
        font-size: 10px;
        white-space: nowrap;
    }

    /* Tour và khách */
    .booking-tour-name {
        max-width: 250px;
        overflow: hidden;
        color: #233f7a;
        font-size: 12px;
        font-weight: 750;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .booking-code {
        margin-top: 4px;
        color: #6d7d9a;
        font-family: monospace;
        font-size: 10px;
        font-weight: 700;
    }

    .booking-customer {
        margin-top: 5px;
        color: #536584;
        font-size: 10px;
        display: flex;
        align-items: center;
        gap: 5px;
    }

    .booking-customer i {
        color: #6f84b3;
    }

    /* Số khách */
    .passenger-summary {
        padding: 6px 10px;
        color: #3158ce;
        background: #edf4ff;
        border: 1px solid #cfe0ff;
        border-radius: 999px;
        font-size: 10px;
        font-weight: 750;

        white-space: nowrap;
        display: inline-flex;
        align-items: center;
        gap: 5px;
    }

    .passenger-legend {
        margin-top: 5px;
        color: #8b97aa;
        font-size: 9px;
    }

    /* Doanh thu */
    .booking-revenue {
        color: var(--booking-success);
        font-size: 12px;
        font-weight: 800;
        white-space: nowrap;
    }

    .booking-paid {
        margin-top: 4px;
        color: #7c899f;
        font-size: 10px;
        white-space: nowrap;
    }

    /* HDV */
    .booking-guide {
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .guide-icon {
        width: 32px;
        height: 32px;
        flex-shrink: 0;
        color: #315be8;
        background: #edf4ff;
        border: 1px solid #cfe0ff;
        border-radius: 8px;
        font-size: 11px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }

    .guide-name {
        max-width: 140px;
        overflow: hidden;
        color: #40537a;
        font-size: 11px;
        font-weight: 700;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .empty-value {
        color: var(--booking-text-light);
        font-size: 10px;
        font-style: italic;
    }

    /* Nguồn booking */
    .booking-source {
        padding: 5px 10px;
        border: 1px solid transparent;
        border-radius: 999px;
        font-size: 9px;
        font-weight: 750;
        white-space: nowrap;
        display: inline-flex;
        align-items: center;
        gap: 5px;
    }

    .badge-website {
        color: #2855ce;
        background: #edf4ff;
        border-color: #c9dcff;
    }

    .badge-sale {
        color: #8650b1;
        background: #f7efff;
        border-color: #e2cff3;
    }

    /* Trạng thái */
    .booking-status {
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

    .departure-date i {
        margin-right: 5px;
        color: #4d72da;
        font-size: 10px;
    }

    .booking-created-date {
        margin-top: 4px;
        color: #8b97aa;
        font-size: 10px;
        white-space: nowrap;
    }

    /* Tour và khách */
    .booking-tour-name {
        max-width: 250px;
        overflow: hidden;
        color: #233f7a;
        font-size: 12px;
        font-weight: 750;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .booking-code {
        margin-top: 4px;
        color: #6d7d9a;
        font-family: monospace;
        font-size: 10px;
        font-weight: 700;
    }

    .booking-customer {
        margin-top: 5px;
        color: #536584;
        font-size: 10px;
        display: flex;
        align-items: center;
        gap: 5px;
    }

    .booking-customer i {
        color: #6f84b3;
    }

    /* Số khách */
    .passenger-summary {
        padding: 6px 10px;
        color: #3158ce;
        background: #edf4ff;
        border: 1px solid #cfe0ff;
        border-radius: 999px;
        font-size: 10px;
        font-weight: 750;
        white-space: nowrap;
        display: inline-flex;
        align-items: center;
        gap: 5px;
    }

    .passenger-legend {
        margin-top: 5px;
        color: #8b97aa;
        font-size: 9px;
    }

    /* Doanh thu */
    .booking-revenue {
        color: var(--booking-success);
        font-size: 12px;
        font-weight: 800;
        white-space: nowrap;
    }

    .booking-paid {
        margin-top: 4px;
        color: #7c899f;
        font-size: 10px;
        white-space: nowrap;
    }

    /* HDV */
    .booking-guide {
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .guide-icon {
        width: 32px;
        height: 32px;
        flex-shrink: 0;
        color: #315be8;
        background: #edf4ff;
        border: 1px solid #cfe0ff;
        border-radius: 8px;
        font-size: 11px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }

    .guide-name {
        max-width: 140px;
        overflow: hidden;
        color: #40537a;
        font-size: 11px;
        font-weight: 700;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .empty-value {
        color: var(--booking-text-light);
        font-size: 10px;
        font-style: italic;
    }

    /* Nguồn booking */
    .booking-source {
        padding: 5px 10px;
        border: 1px solid transparent;
        border-radius: 999px;
        font-size: 9px;
        font-weight: 750;
        white-space: nowrap;
        display: inline-flex;
        align-items: center;
        gap: 5px;
    }

    .badge-website {
        color: #2855ce;
        background: #edf4ff;
        border-color: #c9dcff;
    }

    .badge-sale {
        color: #8650b1;
        background: #f7efff;
        border-color: #e2cff3;
    }

    /* Trạng thái */
    .booking-status {
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

    .badge-cho_xac_nhan {
        color: var(--booking-warning);
        background: var(--booking-warning-bg);
        border-color: #f1dba9;
    }

    .badge-da_xac_nhan {
        color: var(--booking-info);
        background: var(--booking-info-bg);
        border-color: #c9dcff;
    }

    .badge-da_thanh_toan {
        color: var(--booking-success);
        background: var(--booking-success-bg);
        border-color: #c5ead8;
    }

    .badge-da_huy {
        color: var(--booking-danger);
        background: var(--booking-danger-bg);
        border-color: #f0c9d1;
    }

    .badge-hoan_thanh {
        color: var(--booking-neutral);
        background: var(--booking-neutral-bg);
        border-color: #dce2ea;
    }

    /* Nút thao tác */
    .booking-actions {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 5px;
    }

    .booking-actions form {
        margin: 0;
        display: inline-flex;
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
        color: var(--booking-white);
        background: #3867e5;
        border-color: #3867e5;
    }

    .btn-soft-delete {
        color: var(--booking-warning);
        background: var(--booking-warning-bg);
        border-color: #f1dba9;
    }

    .btn-soft-delete:hover {
        color: var(--booking-white);
        background: #e39a25;
        border-color: #e39a25;
    }

    /* Không có dữ liệu */
    .booking-empty-row {
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
        font-size: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
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

    /* Footer */
    .booking-card-footer {
        padding: 16px 22px;
        background: #fafcff;
        border-top: 1px solid var(--booking-border);
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 16px;
    }

    .booking-result-info {
        color: var(--booking-text-muted);
        font-size: 11px;
    }

    .booking-card-footer .pagination {
        margin: 0;
        gap: 4px;
    }

    .booking-card-footer .page-link {
        min-width: 34px;
        height: 34px;
        padding: 6px 10px;
        color: #3158ce;
        background: var(--booking-white);
        border: 1px solid #d6e1f2;
        border-radius: 7px !important;
        font-size: 12px;
        box-shadow: none;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .booking-card-footer .page-link:hover {
        color: var(--booking-white);
        background: #416ce5;
        border-color: #416ce5;
    }

    .booking-card-footer .page-item.active .page-link {
        color: var(--booking-white);
        background: linear-gradient(135deg,
                #315be8,
                #584be8);
        border-color: #315be8;
    }

    @media (max-width: 1100px) {
        .booking-stats-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }

        .booking-filter-form {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }

        .btn-filter-action {
            width: 100%;
        }
    }

    @media (max-width: 768px) {
        .booking-management-page {
            padding: 14px 0;
        }

        .booking-page-top {
            align-items: stretch;
            flex-direction: column;
        }

        .booking-page-heading h3 {
            font-size: 20px;
        }

        .booking-page-actions {
            width: 100%;
        }

        .btn-page-action {
            flex: 1;
        }

        .booking-card {
            border-radius: 11px;
        }

        .booking-card-header {
            min-height: 105px;
            padding: 20px 18px;
        }

        .booking-card-body {
            padding: 16px;
        }

        .booking-filter-form {
            grid-template-columns: 1fr;
        }

        .booking-card-footer {
            align-items: stretch;
            flex-direction: column;
        }

        .booking-result-info {
            text-align: center;
        }
    }

    @media (max-width: 520px) {
        .booking-stats-grid {
            grid-template-columns: 1fr;
        }

        .booking-page-actions {
            flex-direction: column;
        }

        .btn-page-action {
            width: 100%;
        }

        .booking-card-header {
            align-items: flex-start;
            flex-direction: column;
        }
    }

</style>

<div class="container-fluid booking-management-page">
    @if (session('success'))
    <div class="booking-alert">
        <i class="fas fa-check-circle"></i>
        {{ session('success') }}
    </div>
    @endif

    <div class="booking-page-top">
        <div class="booking-page-heading">
            <span class="booking-page-icon">
                <i class="fas fa-suitcase"></i>
            </span>

            <div>
                <h3>Quản lý đặt Tour</h3>

                <p>
                    Theo dõi booking, khách hàng, thanh toán và trạng thái
                    đặt Tour.
                </p>
            </div>
        </div>

        <div class="booking-page-actions">
            <a href="{{ route('Admin.dat_tours.create') }}" class="btn-page-action btn-add-booking">
                <i class="fas fa-plus"></i>
                Thêm booking thủ công
            </a>

            <a href="{{ route('Admin.dat_tours.trash') }}" class="btn-page-action btn-trash">
                <i class="fas fa-trash"></i>
                Thùng rác
            </a>
        </div>
    </div>

    <div class="booking-stats-grid">
        <div class="booking-stat-card stat-primary">
            <span class="booking-stat-icon">
                <i class="fas fa-clipboard-list"></i>
            </span>

            <div class="booking-stat-content">
                <div class="booking-stat-value">
                    {{ $totalBookings ?? 0 }}
                </div>

                <div class="booking-stat-label">
                    Tổng booking
                </div>
            </div>
        </div>

        <div class="booking-stat-card stat-info">
            <span class="booking-stat-icon">
                <i class="fas fa-globe"></i>
            </span>

            <div class="booking-stat-content">
                <div class="booking-stat-value">
                    {{ $websiteBookings ?? 0 }}
                </div>

                <div class="booking-stat-label">
                    Booking từ Website
                </div>
            </div>
        </div>

        <div class="booking-stat-card stat-purple">
            <span class="booking-stat-icon">
                <i class="fas fa-user-tie"></i>
            </span>

            <div class="booking-stat-content">
                <div class="booking-stat-value">
                    {{ $saleBookings ?? 0 }}
                </div>

                <div class="booking-stat-label">
                    Booking từ Sale
                </div>
            </div>
        </div>

        <div class="booking-stat-card stat-success">
            <span class="booking-stat-icon">
                <i class="fas fa-money-bill-wave"></i>
            </span>

            <div class="booking-stat-content">
                <div class="booking-stat-value revenue">
                    {{ $revenue ?? '0 đ' }}
                </div>

                <div class="booking-stat-label">
                    Tổng doanh thu
                </div>
            </div>
        </div>
    </div>

    <div class="booking-card">
        <div class="booking-card-header">
            <div class="booking-card-heading">
                <span class="booking-card-icon">
                    <i class="fas fa-list-alt"></i>
                </span>

                <div>
                    <h4>Danh sách booking</h4>

                    <p>
                        Quản lý thông tin Tour, khách hàng và thanh toán.
                    </p>
                </div>
            </div>

            <div class="booking-total">
                <strong>
                    {{ isset($bookings) ? $bookings->total() : 0 }}
                </strong>

                <span>Booking</span>
            </div>
        </div>

        <div class="booking-card-body">
            <div class="booking-filter-box">
                <div class="booking-filter-title">
                    <i class="fas fa-filter"></i>
                    Bộ lọc tìm kiếm
                </div>

                <form action="{{ route('Admin.quan_ly_dat_tour.index') }}" method="GET" class="booking-filter-form">
                    <div class="booking-filter-field">
                        <label for="keyword">
                            Từ khóa
                        </label>

                        <div class="booking-filter-control">
                            <i class="fas fa-search booking-filter-icon"></i>

                            <input type="text" name="keyword" id="keyword" class="form-control" placeholder="Tên Tour, mã booking hoặc khách hàng..." value="{{ $filters['keyword'] ?? '' }}" autocomplete="off">
                        </div>
                    </div>

                    <div class="booking-filter-field">
                        <label for="status">
                            Trạng thái
                        </label>

                        <select name="status" id="status" class="form-select">
                            <option value="">
                                Tất cả trạng thái
                            </option>

                            @foreach ($statuses as $value => $label)
                            <option value="{{ $value }}" @selected(($filters['status'] ?? '' )==$value)>
                                {{ $label }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <button type="submit" class="btn-filter-action btn-filter">
                        <i class="fas fa-search"></i>
                        Tìm kiếm
                    </button>

                    <a href="{{ route('Admin.quan_ly_dat_tour.index') }}" class="btn-filter-action btn-reset">
                        <i class="fas fa-redo-alt"></i>
                        Đặt lại
                    </a>
                </form>
            </div>

            <div class="booking-table-wrapper">
                <table class="table booking-table">
                    <thead>
                        <tr>
                            <th>Ngày khởi hành</th>
                            <th>Tour và khách</th>
                            <th>Số lượng L/T/E</th>
                            <th>Doanh thu</th>
                            <th>Phụ trách / HDV</th>
                            <th>Nguồn booking</th>
                            <th>Trạng thái</th>
                            <th>Thao tác</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($bookings ?? [] as $booking)
                        <tr>
                            <td>
                                @php
                                $ngayKhoiHanh = $booking->lichKhoiHanh?->ngay_khoi_hanh;
                                @endphp

                                <div class="departure-date">
                                    <i class="fas fa-calendar-alt"></i>

                                    {{ $ngayKhoiHanh ? \Carbon\Carbon::parse($ngayKhoiHanh)->format('d/m/Y') : 'Chưa có lịch khởi hành' }}
                                </div>

                                <div class="booking-created-date">
                                    Đặt:
                                    {{ $booking->ngay_dat ? \Carbon\Carbon::parse($booking->ngay_dat)->format('d/m/Y') : '—' }}
                                </div>
                            </td>

                            <td>
                                <div class="booking-tour-name" title="{{ $booking->tour?->ten_tour ?? '—' }}">
                                    {{ $booking->tour?->ten_tour ?? '—' }}
                                </div>

                                <div class="booking-code">
                                    {{ $booking->ma_dat_tour ?: 'Không có mã' }}
                                </div>

                                <div class="booking-customer">
                                    <i class="fas fa-user"></i>

                                    {{ $booking->ten_khach_chinh ?: 'Chưa có khách chính' }}
                                </div>
                            </td>

                            <td>
                                <span class="passenger-summary">
                                    <i class="fas fa-users"></i>


                                    {{ $booking->so_nguoi_lon }}
                                    /
                                    {{ $booking->so_tre_em }}
                                    /
                                    {{ $booking->so_em_be }}
                                </span>

                                <div class="passenger-legend">
                                    Lớn / Trẻ em / Em bé
                                </div>

                            </td>

                            <td>
                                <div class="booking-revenue">
                                    {{ number_format($booking->tong_tien, 0, ',', '.') }}
                                    đ
                                </div>

                                @if ($booking->so_tien_da_thanh_toan < $booking->tong_tien)
                                    <div class="booking-paid">
                                        Đã thanh toán:
                                        {{ number_format($booking->so_tien_da_thanh_toan, 0, ',', '.') }}
                                        đ
                                    </div>
                                    @endif
                            </td>

                            <td>
                                @if ($booking->lichKhoiHanh?->huongDanVien)
                                <div class="booking-guide">
                                    <span class="guide-icon">
                                        <i class="fas fa-user-tie"></i>
                                    </span>

                                    <span class="guide-name" title="{{ $booking->lichKhoiHanh->huongDanVien->ho_ten }}">
                                        {{ $booking->lichKhoiHanh->huongDanVien->ho_ten }}
                                    </span>
                                </div>
                                @else
                                <span class="empty-value">
                                    Chưa phân công
                                </span>
                                @endif
                            </td>

                            <td>
                                <span class="booking-source badge-{{ $booking->nguon_booking ?? 'website' }}">
                                    <i class="fas fa-link"></i>

                                    {{ $booking->nguon_booking_label }}
                                </span>
                            </td>

                            <td>
                                <span class="booking-status badge-{{ $booking->trang_thai }}">
                                    <span class="status-dot"></span>

                                    {{ $booking->trangThaiDatTour() }}
                                </span>
                            </td>

                            <td>
                                <div class="booking-actions">
                                    <a href="{{ route('Admin.dat_tours.show', $booking->id) }}" class="btn-table-action btn-view" title="Xem chi tiết">
                                        <i class="fas fa-eye"></i>
                                    </a>

                                    <form action="{{ route('Admin.dat_tours.destroy', $booking->id) }}" method="POST" onsubmit="return confirm('Chuyển booking này vào thùng rác?');">
                                        @csrf
                                        @method('DELETE')

                                        <button type="submit" class="btn-table-action btn-soft-delete" title="Chuyển vào thùng rác">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="booking-empty-row">
                                <div class="empty-state-icon">
                                    <i class="fas fa-suitcase"></i>
                                </div>

                                <div class="empty-state-title">
                                    Chưa có dữ liệu booking
                                </div>

                                <div class="empty-state-text">
                                    Không tìm thấy booking phù hợp với
                                    điều kiện tìm kiếm.
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        @if (isset($bookings))
        <div class="booking-card-footer">
            <div class="booking-result-info">
                @if ($bookings->total() > 0)
                Hiển thị {{ $bookings->firstItem() }}
                đến {{ $bookings->lastItem() }}
                trong tổng số {{ $bookings->total() }} booking
                @else
                Không có booking nào
                @endif
            </div>

            @if ($bookings->hasPages())
            {{ $bookings->withQueryString()->links() }}
            @endif
        </div>
        @endif
    </div>
</div>
@endsection
