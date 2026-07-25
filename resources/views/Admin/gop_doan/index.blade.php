@extends('layouts.admin')

@section('title', 'Đề xuất gộp đoàn')

@section('content')

    <div class="container-fluid">

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="d-flex justify-content-between align-items-center mb-4">

            <div>

                <h3 class="fw-bold mb-1">
                    <i class="fas fa-object-group text-primary me-2"></i>
                    Đề xuất gộp đoàn tự động
                </h3>

                <small class="text-muted">
                    Các nhóm dưới đây được AI đề xuất có thể gộp.
                    Sau khi tạo yêu cầu, việc quản lý sẽ thực hiện tại trang "Lịch sử gộp đoàn".
                </small>

            </div>

            <div class="d-flex gap-2">

                <a href="{{ route('Admin.gop-doan.thu-cong') }}" class="btn btn-success">
                    <i class="fas fa-hand-paper me-1"></i>
                    Gộp đoàn thủ công
                </a>

                <a href="{{ route('Admin.gop-doan.lich-su') }}" class="btn btn-outline-primary">
                    <i class="fas fa-history me-1"></i>
                    Lịch sử gộp đoàn
                </a>

            </div>

        </div>

        <div class="row mb-4">

            <div class="col-md-3">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">

                        <div class="text-muted mb-1">
                            Đề xuất gộp
                        </div>

                        <h3 class="fw-bold text-primary">

                            <i class="fas fa-lightbulb me-2"></i>

                            {{ count($deXuats) }}

                        </h3>

                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">

                        <div class="text-muted mb-1">
                            Tổng khách
                        </div>

                        <h3 class="fw-bold text-success">

                            <i class="fas fa-users me-2"></i>
                            {{ collect($deXuats ?? [])->sum('tong_khach') }}
                        </h3>

                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">

                        <div class="text-muted mb-1">
                            Xe sau khi gộp
                        </div>

                        <h3 class="fw-bold text-warning">

                            <i class="fas fa-bus me-2"></i>
                            {{ count($deXuats) }}
                        </h3>

                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">

                        <div class="text-muted mb-1">
                            Điểm trung bình
                        </div>

                        <h3 class="fw-bold text-danger">

                            <i class="fas fa-star me-2"></i>

                            {{ count($deXuats) ? round(collect($deXuats)->avg('diem')) : 0 }}

                        </h3>

                    </div>
                </div>
            </div>

        </div>

        <div class="card border-0 shadow-lg rounded-4">

            <div class="card-body">

                <table class="table table-hover align-middle mb-0">

                    <thead class="bg-light" style="font-size:14px">
                        <tr>
                            <th width="20%">Tour</th>
                            <th width="25%">Các lịch đề xuất gộp</th>
                            <th>Tổng khách</th>
                            <th>Điểm</th>
                            <th>Lý do</th>
                            <th width="160">Tạo yêu cầu</th>
                        </tr>

                    </thead>

                    <tbody>

                        @forelse($deXuats as $item)
                            <tr>

                                <td>
                                    <div class="fw-bold">

                                        <i class="fas fa-map-marked-alt text-primary me-1"></i>

                                        @php
                                            $first = collect($item['nhom'])->first();
                                            $tour = $first?->tour;
                                        @endphp

                                        {{ $tour?->ten_tour ?? 'Không có tour' }}

                                    </div>

                                    <div class="mt-2">

                                        <span class="badge bg-info">
                                            {{ count($item['nhom']) }} lịch
                                        </span>

                                    </div>
                                </td>
                                <td>

                                    @foreach ($item['nhom'] as $lich)
                                        <div class="card mb-2 border-start border-4 border-primary shadow-sm">

                                            <div class="card-body py-2">

                                                <div class="d-flex justify-content-between">

                                                    <div>

                                                        <strong>
                                                            <i class="fas fa-calendar-alt text-primary"></i>
                                                            #{{ $lich->id }}
                                                        </strong>

                                                        <br>

                                                        <small class="text-muted">
                                                            {{ \Carbon\Carbon::parse($lich->ngay_khoi_hanh)->format('d/m/Y') }}
                                                            →
                                                            {{ \Carbon\Carbon::parse($lich->ngay_ket_thuc)->format('d/m/Y') }}
                                                        </small>

                                                        <div class="small text-secondary mt-1">
                                                            <i class="fas fa-user-friends"></i>
                                                            {{ $lich->so_cho_con_lai }} chỗ còn trống
                                                        </div>

                                                    </div>

                                                    <div class="text-end">

                                                        <span class="badge bg-success">
                                                            {{ $lich->so_cho_da_dat }}/{{ $lich->so_cho }}
                                                        </span>

                                                    </div>

                                                </div>

                                            </div>

                                        </div>
                                    @endforeach

                                </td>

                                <td class="text-center">

                                    <h4 class="fw-bold text-primary mb-2">

                                        <i class="fas fa-users me-1"></i>

                                        {{ $item['tong_khach'] }}

                                    </h4>

                                    <span class="badge bg-primary rounded-pill px-3 py-2">

                                        <i class="fas fa-bus me-1"></i>

                                        Xe {{ $item['tong_khach'] <= 14 ? 14 : ($item['tong_khach'] <= 27 ? 27 : 43) }} chỗ

                                    </span>

                                </td>

                                <td class="text-center">

                                    @php
                                        $color = 'danger';

                                        if ($item['diem'] >= 90) {
                                            $color = 'success';
                                        } elseif ($item['diem'] >= 75) {
                                            $color = 'warning';
                                        }
                                    @endphp

                                    <span class="badge rounded-pill bg-{{ $color }} fs-6 px-3 py-2">

                                        <i class="fas fa-star me-1"></i>

                                        AI {{ $item['diem'] }}/100
                                    </span>
                                    @if ($item['diem'] >= 90)
                                        <div class="mt-2">

                                            <span class="badge bg-danger">

                                                <i class="fas fa-fire me-1"></i>

                                                Ưu tiên

                                            </span>

                                        </div>
                                    @endif

                                    <div class="progress mt-2" style="height:7px">

                                        @php
                                            $progressColor = 'bg-danger';

                                            if ($item['diem'] >= 90) {
                                                $progressColor = 'bg-success';
                                            } elseif ($item['diem'] >= 75) {
                                                $progressColor = 'bg-warning';
                                            }
                                        @endphp

                                        <div class="progress-bar {{ $progressColor }}" style="width:{{ $item['diem'] }}%">
                                        </div>

                                    </div>

                                    <div class="mt-2">

                                        @if ($item['diem'] >= 90)
                                            <span class="badge bg-success">

                                                Khuyến nghị cao

                                            </span>
                                        @elseif($item['diem'] >= 75)
                                            <span class="badge bg-warning text-dark">

                                                Khuyến nghị

                                            </span>
                                        @else
                                            <span class="badge bg-secondary">

                                                Có thể gộp

                                            </span>
                                        @endif

                                    </div>

                                </td>

                                <td>

                                    <div class="d-flex flex-column gap-2">

                                        @foreach ($item['ly_do'] as $lyDo)
                                            <span class="badge bg-light text-dark border text-start p-2">

                                                {{ $lyDo }}

                                            </span>
                                        @endforeach

                                    </div>

                                </td>

                                <td class="text-center">

                                    {{-- FORM TẠO YÊU CẦU --}}
                                    <form action="{{ route('Admin.gop-doan.ai.store') }}" method="POST">
                                        @csrf

                                        @foreach ($item['nhom'] as $lich)
                                            <input type="hidden" name="lich_ids[]" value="{{ $lich->id }}">
                                        @endforeach

                                        <input type="hidden" name="ly_do_de_xuat"
                                            value="{{ implode(' | ', $item['ly_do']) }}">

                                        <button class="btn btn-success btn-sm rounded-pill px-4 shadow"
                                            onclick="return confirm('Tạo yêu cầu gộp đoàn?')">

                                            <i class="fas fa-plus-circle me-1"></i>

                                            Tạo yêu cầu

                                        </button>

                                    </form>

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="6" class="text-center">

                                    Không có đề xuất gộp đoàn

                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>

@endsection
