@extends('layouts.app')

@section('content')
<style>
    .terms-client-page {
        background:
            radial-gradient(circle at top left, rgba(37, 99, 235, .06), transparent 35%),
            linear-gradient(180deg, #f8fafc 0%, #eef2f7 100%);
        min-height: 100vh;
        padding: 56px 0 80px;
        font-family: 'Segoe UI', Arial, sans-serif;
        color: #0f172a;
    }

    .terms-client-container {
        width: calc(100vw - 300px);
        max-width: 1320px;
        min-width: 980px;
        margin-left: auto;
        margin-right: auto;
    }

    .terms-hero {
        width: 100%;
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 22px;
        overflow: hidden;
        box-shadow: 0 18px 45px rgba(15, 23, 42, .08);
    }

    .terms-hero-header {
        padding: 44px 48px 40px;
        border-bottom: 1px solid #e2e8f0;
        background:
            linear-gradient(135deg, rgba(37, 99, 235, .08), rgba(79, 70, 229, .04)),
            #ffffff;
    }

    .terms-breadcrumb {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        color: #2563eb;
        font-size: 14px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: .08em;
        margin-bottom: 18px;
    }

    .terms-breadcrumb i {
        font-size: 15px;
    }

    .terms-title-row {
        display: flex;
        align-items: center;
        gap: 18px;
    }

    .terms-icon {
        width: 58px;
        height: 58px;
        border-radius: 18px;
        background: #eff6ff;
        color: #2563eb;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 26px;
        flex-shrink: 0;
        border: 1px solid #dbeafe;
    }

    .terms-title {
        font-size: 42px;
        line-height: 1.15;
        font-weight: 800;
        color: #020617;
        margin: 0;
        letter-spacing: -0.8px;
    }

    .terms-subtitle {
        margin-top: 14px;
        max-width: 820px;
        color: #64748b;
        font-size: 17px;
        line-height: 1.7;
    }

    .terms-content-wrap {
        padding: 42px 48px 52px;
    }

    .terms-content {
        color: #1e293b;
        font-size: 17px;
        line-height: 1.9;
        white-space: pre-line;
    }

    .terms-note {
        margin-top: 34px;
        padding: 18px 20px;
        border-radius: 14px;
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        color: #475569;
        font-size: 15px;
        line-height: 1.7;
    }

    .terms-actions {
        margin-top: 32px;
        display: flex;
        justify-content: flex-start;
        gap: 12px;
    }

    .terms-btn {
        min-height: 48px;
        padding: 0 22px;
        border-radius: 999px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 9px;
        text-decoration: none;
        font-size: 15px;
        font-weight: 700;
        transition: .2s ease;
    }

    .terms-btn-primary {
        background: linear-gradient(135deg, #0f4db8, #2563eb);
        color: #ffffff;
        box-shadow: 0 8px 18px rgba(37, 99, 235, .22);
    }

    .terms-btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 12px 24px rgba(37, 99, 235, .28);
    }

    .terms-btn-secondary {
        background: #ffffff;
        color: #334155;
        border: 1px solid #cbd5e1;
    }

    .terms-btn-secondary:hover {
        background: #f8fafc;
        color: #0f172a;
    }

    @media (max-width: 1400px) {
        .terms-client-page {
            padding: 50px 24px 76px;
        }

        .terms-client-container {
            width: 100%;
            max-width: 1180px;
            min-width: 0;
        }
    }

    @media (max-width: 900px) {
        .terms-client-page {
            padding: 36px 16px 60px;
        }

        .terms-hero-header {
            padding: 36px 28px 32px;
        }

        .terms-content-wrap {
            padding: 34px 28px 40px;
        }

        .terms-title {
            font-size: 34px;
        }

        .terms-title-row {
            align-items: flex-start;
        }
    }

    @media (max-width: 640px) {
        .terms-client-page {
            padding: 24px 12px 48px;
        }

        .terms-hero {
            border-radius: 18px;
        }

        .terms-hero-header {
            padding: 30px 22px 28px;
        }

        .terms-content-wrap {
            padding: 28px 22px 34px;
        }

        .terms-title-row {
            flex-direction: column;
            gap: 14px;
        }

        .terms-icon {
            width: 52px;
            height: 52px;
            font-size: 23px;
        }

        .terms-title {
            font-size: 30px;
        }

        .terms-content {
            font-size: 16px;
            line-height: 1.85;
        }

        .terms-actions {
            flex-direction: column;
        }

        .terms-btn {
            width: 100%;
        }
    }
</style>

<div class="terms-client-page">
    <div class="terms-client-container">
        <div class="terms-hero">
            <div class="terms-hero-header">
                <div class="terms-breadcrumb">
                    <i class="fas fa-file-contract"></i>
                    Điều khoản
                </div>

                <div class="terms-title-row">
                    <div class="terms-icon">
                        <i class="fas fa-scale-balanced"></i>
                    </div>

                    <div>
                        <h1 class="terms-title">
                            {{ $trangDieuKhoan->tieu_de }}
                        </h1>

                        <div class="terms-subtitle">
                            Vui lòng đọc kỹ các điều khoản sử dụng trước khi đặt tour và sử dụng dịch vụ của Travelloula.
                        </div>
                    </div>
                </div>
            </div>

            <div class="terms-content-wrap">
                <div class="terms-content">
                    {{ $trangDieuKhoan->noi_dung }}
                </div>

                <div class="terms-note">
                    Khi tiếp tục sử dụng website, quý khách được xem là đã đọc, hiểu và đồng ý với các điều khoản sử dụng của Travelloula.
                </div>

                <div class="terms-actions">
                    <a href="{{ url('/') }}" class="terms-btn terms-btn-primary">
                        <i class="fas fa-house"></i>
                        Về trang chủ
                    </a>

                    <a href="{{ url('/bai_viet') }}" class="terms-btn terms-btn-secondary">
                        <i class="fas fa-newspaper"></i>
                        Xem bài viết
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection