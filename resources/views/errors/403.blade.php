@extends('layouts.admin')

@section('content')
<div class="permission-denied-page">
    <div class="permission-card">
        <div class="permission-icon">
            <i class="fas fa-lock"></i>
        </div>

        <h2>Không có quyền truy cập</h2>

        <p>
            Bạn không có quyền truy cập chức năng này.
            Vui lòng liên hệ quản trị viên để được cấp quyền.
        </p>

        <div class="permission-actions">
            <a href="{{ url()->previous() }}" class="btn-back">
                <i class="fas fa-arrow-left"></i>
                Quay lại
            </a>

            <a href="{{ route('Admin.dashboard') }}" class="btn-home">
                <i class="fas fa-home"></i>
                Về Dashboard
            </a>
        </div>
    </div>
</div>

<style>
.permission-denied-page {
    min-height: calc(100vh - 140px);
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 40px 16px;
}

.permission-card {
    width: 100%;
    max-width: 520px;
    background: #fff;
    border-radius: 24px;
    padding: 42px 34px;
    text-align: center;
    border: 1px solid #e5e7eb;
    box-shadow: 0 18px 45px rgba(15, 23, 42, .10);
}

.permission-icon {
    width: 86px;
    height: 86px;
    margin: 0 auto 22px;
    border-radius: 50%;
    background: #fee2e2;
    color: #dc2626;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 36px;
}

.permission-card h2 {
    margin: 0 0 12px;
    font-size: 28px;
    font-weight: 900;
    color: #111827;
}

.permission-card p {
    margin: 0 auto 28px;
    color: #6b7280;
    line-height: 1.7;
    max-width: 420px;
}

.permission-actions {
    display: flex;
    justify-content: center;
    gap: 12px;
    flex-wrap: wrap;
}

.btn-back,
.btn-home {
    min-width: 145px;
    height: 44px;
    padding: 0 18px;
    border-radius: 999px;
    font-weight: 800;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    transition: .25s;
}

.btn-back {
    background: #f3f4f6;
    color: #374151;
}

.btn-back:hover {
    background: #e5e7eb;
    color: #111827;
    transform: translateY(-2px);
}

.btn-home {
    background: #2563eb;
    color: #fff;
}

.btn-home:hover {
    background: #1d4ed8;
    color: #fff;
    transform: translateY(-2px);
}
</style>
@endsection
