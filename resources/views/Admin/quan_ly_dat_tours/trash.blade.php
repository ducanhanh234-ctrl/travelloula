@extends('layouts.admin')

@section('content')

<style>
    body {
        background: #f5f7fb;
    }

    .page-title {
        font-size: 32px;
        font-weight: 700;
    }

    .page-desc {
        color: #6c757d;
        margin-bottom: 30px;
    }

    .table-card {
        background: #fff;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 2px 10px rgba(0,0,0,.05);
    }

    .table th {
        background: #f8f9fa;
        font-size: 14px;
        font-weight: 600;
        vertical-align: middle;
    }

    .table td {
        vertical-align: middle;
    }

    .tour-name {
        font-weight: 600;
        color: #333;
    }

    .booking-code {
        font-size: 12px;
        color: #888;
    }

    .btn-action {
        border-radius: 8px;
    }

    .empty-data {
        text-align: center;
        padding: 60px 0;
        color: #999;
    }

    .deleted-date {
        color: #dc3545;
        font-size: 13px;
    }
</style>

<div class="container-fluid">

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button"
                class="btn-close"
                data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show">
            {{ session('error') }}
            <button type="button"
                class="btn-close"
                data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="page-title">
                Thùng rác Booking
            </h2>

            <p class="page-desc">
                Danh sách các booking đã bị xóa mềm
            </p>
        </div>

        <a href="{{ route('Admin.quan_ly_dat_tour.index') }}"
            class="btn btn-primary">
            <i class="fas fa-arrow-left"></i>
            Quay lại danh sách
        </a>
    </div>

    <div class="table-card">
        <table class="table table-hover mb-0">

            <thead>
                <tr>
                    <th>MÃ BOOKING</th>
                    <th>TOUR</th>
                    <th>KHÁCH HÀNG</th>
                    <th>TỔNG TIỀN</th>
                    <th>NGÀY XÓA</th>
                    <th width="220">THAO TÁC</th>
                </tr>
            </thead>

            <tbody>

                @forelse($bookings as $booking)

                    <tr>

                        <td>
                            <div class="booking-code">
                                {{ $booking->ma_dat_tour }}
                            </div>
                        </td>

                        <td>
                            <div class="tour-name">
                                {{ $booking->tour?->ten_tour ?? 'Không có tour' }}
                            </div>
                        </td>

                        <td>
                            {{ $booking->ten_khach_chinh ?? '-' }}
                        </td>

                        <td>
                            <strong>
                                {{ number_format($booking->tong_tien,0,',','.') }} đ
                            </strong>
                        </td>

                        <td>
                            <span class="deleted-date">
                                {{ $booking->deleted_at?->format('d/m/Y H:i') }}
                            </span>
                        </td>

                        <td>

                            <div class="d-flex gap-2">

                                {{-- Khôi phục --}}
                                <form action="{{ route('Admin.dat_tours.restore',$booking->id) }}"
                                    method="POST">

                                    @csrf

                                    <button type="submit"
                                        class="btn btn-success btn-sm btn-action">

                                        <i class="fas fa-undo"></i>
                                        Khôi phục

                                    </button>

                                </form>

                                {{-- Xóa vĩnh viễn --}}
                                <form action="{{ route('Admin.dat_tours.forceDelete',$booking->id) }}"
                                    method="POST"
                                    onsubmit="return confirm('Xóa vĩnh viễn booking này?')">

                                    @csrf
                                    @method('DELETE')

                                    <button type="submit"
                                        class="btn btn-danger btn-sm btn-action">

                                        <i class="fas fa-trash-alt"></i>
                                        Xóa

                                    </button>

                                </form>

                            </div>

                        </td>

                    </tr>

                @empty

                    <tr>
                        <td colspan="6">
                            <div class="empty-data">
                                Chưa có booking nào trong thùng rác
                            </div>
                        </td>
                    </tr>

                @endforelse

            </tbody>

        </table>

        @if($bookings->hasPages())
            <div class="p-3">
                {{ $bookings->links() }}
            </div>
        @endif

    </div>

</div>

@endsection
