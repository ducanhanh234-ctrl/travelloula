@extends('Layouts.guide')

@section('title', 'Điểm danh đầu ngày')
@section('guide', 'Điểm danh đầu ngày')

@section('content')
    <div class="container-fluid">

        {{-- Thông tin đầu trang --}}
        <div class="card shadow-sm mb-4">
            <div class="card-body">
                <h4>Điểm danh trước khi bắt đầu Ngày {{ $ngayThu }}</h4>
                <p class="text-muted mb-0">
                    Tổng hành khách:
                    <strong>{{ $tongKhach }}</strong>
                </p>
            </div>
        </div>

        {{-- Danh sách hành khách --}}
        <div class="card shadow-sm">
            <div class="card-header">
                <strong>Danh sách hành khách</strong>
            </div>

            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead>
                            <tr>
                                <th width="60">STT</th>
                                <th>Họ tên</th>
                                <th>Giới tính</th>
                                <th>Quốc tịch</th>
                                <th width="220">Trạng thái</th>
                            </tr>
                        </thead>

                        <tbody>
                            @php
                                $stt = 1;
                            @endphp

                            @forelse ($datTours as $datTour)
                                @foreach ($datTour->khachHangs as $khach)
                                    @php
                                        $diemDanh = $diemDanhs[$khach->id] ?? null;
                                        $trangThai = $diemDanh->trang_thai ?? null;

                                        /*
                                         * Hỗ trợ cả trạng thái cũ và trạng thái mới:
                                         * - co_mat / da_check_in => Đã Check-in
                                         * - da_check_out         => Hoàn thành
                                         * - vang_mat             => Vắng mặt
                                         */
                                        $daCheckIn = in_array($trangThai, ['co_mat', 'da_check_in'], true);
                                        $daHoanThanh = $trangThai === 'da_check_out';
                                        $vangMat = $trangThai === 'vang_mat';
                                    @endphp

                                    <tr>
                                        <td>{{ $stt++ }}</td>

                                        <td>
                                            <strong>{{ $khach->ho_ten }}</strong>
                                        </td>

                                        <td>
                                            {{ $khach->gioi_tinh ?: 'Chưa cập nhật' }}
                                        </td>

                                        <td>
                                            {{ $khach->quoc_tich ?: 'Chưa cập nhật' }}
                                        </td>

                                        <td>
                                            @if ($daChot)
                                                {{-- Khi đã chốt: chỉ hiển thị kết quả --}}
                                                @if ($daHoanThanh)
                                                    <span class="badge bg-primary">
                                                        <i class="fas fa-check-double me-1"></i>
                                                        Hoàn thành
                                                    </span>

                                                @elseif ($daCheckIn)
                                                    <span class="badge bg-success">
                                                        <i class="fas fa-user-check me-1"></i>
                                                        Đã Check-in
                                                    </span>

                                                @elseif ($vangMat)
                                                    <span class="badge bg-danger">
                                                        <i class="fas fa-user-times me-1"></i>
                                                        Vắng mặt
                                                    </span>

                                                @else
                                                    <span class="badge bg-secondary">
                                                        <i class="fas fa-clock me-1"></i>
                                                        Chưa Check-in
                                                    </span>
                                                @endif
                                            @else
                                                {{-- Khi chưa chốt --}}
                                                @if ($daHoanThanh)
                                                    <span class="badge bg-primary">
                                                        <i class="fas fa-check-double me-1"></i>
                                                        Hoàn thành
                                                    </span>

                                                @else
                                                    <div class="d-flex align-items-center gap-3 flex-wrap">

                                                        <form
                                                            action="{{ route('Guide.checkin.luuDiemDanh') }}"
                                                            method="POST"
                                                            class="attendance-form m-0"
                                                        >
                                                            @csrf

                                                            <input
                                                                type="hidden"
                                                                name="khach_hang_dat_tour_id"
                                                                value="{{ $khach->id }}"
                                                            >

                                                            <input
                                                                type="hidden"
                                                                name="lich_khoi_hanh_id"
                                                                value="{{ $lichKhoiHanhId }}"
                                                            >

                                                            <input
                                                                type="hidden"
                                                                name="ngay_thu"
                                                                value="{{ $ngayThu }}"
                                                            >

                                                            <input
                                                                type="hidden"
                                                                name="trang_thai"
                                                                value="{{ $daCheckIn ? 'co_mat' : 'vang_mat' }}"
                                                                class="trang-thai-input"
                                                            >

                                                            <div class="form-check form-switch m-0">
                                                                <input
                                                                    class="form-check-input attendance-switch"
                                                                    type="checkbox"
                                                                    {{ $daCheckIn ? 'checked' : '' }}
                                                                    onchange="
                                                                        const form = this.closest('form');
                                                                        form.querySelector('.trang-thai-input').value =
                                                                            this.checked ? 'co_mat' : 'vang_mat';
                                                                        form.submit();
                                                                    "
                                                                >
                                                            </div>
                                                        </form>

                                                        @if ($daCheckIn)
                                                            <span class="badge bg-success">
                                                                <i class="fas fa-user-check me-1"></i>
                                                                Đã Check-in
                                                            </span>

                                                        @elseif ($vangMat)
                                                            <span class="badge bg-danger">
                                                                <i class="fas fa-user-times me-1"></i>
                                                                Vắng mặt
                                                            </span>

                                                        @else
                                                            <span class="badge bg-secondary">
                                                                <i class="fas fa-clock me-1"></i>
                                                                Chưa Check-in
                                                            </span>
                                                        @endif

                                                    </div>
                                                @endif
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted py-4">
                                        Chưa có hành khách trong lịch khởi hành này.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- Chốt điểm danh --}}
        <div class="card shadow-sm mt-4">
            <div class="card-header">
                <strong>Chốt điểm danh</strong>
            </div>

            <div class="card-body">
                <form action="{{ route('Guide.checkin.chotDiemDanh') }}" method="POST">
                    @csrf

                    <input
                        type="hidden"
                        name="lich_khoi_hanh_id"
                        value="{{ $lichKhoiHanhId }}"
                    >

                    <input
                        type="hidden"
                        name="ngay_thu"
                        value="{{ $ngayThu }}"
                    >

                    <div class="mb-3">
                        <label class="form-label">Ghi chú</label>

                        <textarea
                            name="ghi_chu"
                            class="form-control"
                            rows="4"
                            placeholder="Nhập ghi chú nếu có..."
                            {{ $daChot ? 'disabled' : '' }}
                        ></textarea>
                    </div>

                    @if (!$daChot)
                        <button
                            type="submit"
                            class="btn btn-success btn-lg px-5"
                            onclick="return confirm('Bạn có chắc muốn chốt điểm danh ngày này?');"
                        >
                            <i class="fas fa-check-circle me-2"></i>
                            Chốt điểm danh
                        </button>
                    @else
                        <button
                            type="button"
                            class="btn btn-secondary btn-lg px-5"
                            disabled
                        >
                            <i class="fas fa-lock me-2"></i>
                            Đã chốt điểm danh
                        </button>
                    @endif
                </form>
            </div>
        </div>

    </div>
@endsection
