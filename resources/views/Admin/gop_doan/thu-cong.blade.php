@extends('layouts.admin')

@section('title', 'Gộp đoàn thủ công')

@section('content')

    <div class="container-fluid">

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                {{ session('success') }}
                <button class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show">
                {{ session('error') }}
                <button class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        {{-- Header --}}
        <div class="d-flex justify-content-between align-items-center mb-4">

            <div>

                <h3 class="fw-bold mb-1">

                    <i class="fas fa-hand-paper text-success me-2"></i>

                    Gộp đoàn thủ công

                </h3>

                <small class="text-muted">

                    Chủ động lựa chọn các lịch khởi hành để tạo yêu cầu gộp đoàn.

                </small>

            </div>

            <div>

                <a href="{{ route('Admin.gop-doan.index') }}" class="btn btn-outline-primary">

                    <i class="fas fa-arrow-left me-1"></i>

                    Quay lại

                </a>

            </div>

        </div>

        {{-- Thống kê --}}
        <div class="row mb-4">

            <div class="col-md-4">

                <div class="card border-0 shadow-sm">

                    <div class="card-body">

                        <div class="text-muted">

                            Tour có thể gộp

                        </div>

                        <h3 class="fw-bold text-primary">

                            {{ $tours->count() }}

                        </h3>

                    </div>

                </div>

            </div>

            <div class="col-md-4">

                <div class="card border-0 shadow-sm">

                    <div class="card-body">

                        <div class="text-muted">

                            Lịch khả dụng

                        </div>

                        <h3 class="fw-bold text-success">

                            {{ $tours->sum(fn($t) => $t->lichHopLe->count()) }}

                        </h3>

                    </div>

                </div>

            </div>

            <div class="col-md-4">

                <div class="card border-0 shadow-sm">

                    <div class="card-body">

                        <div class="text-muted">

                            Đã chọn

                        </div>

                        <h3 class="fw-bold text-danger">

                            <span id="soLichDaChon">

                                0

                            </span>

                        </h3>

                    </div>

                </div>

            </div>

        </div>

        <form action="{{ route('Admin.gop-doan.thu-cong.store') }}" method="POST" id="formThuCong">

            @csrf

            @forelse($tours as $tour)

                <div class="card shadow mb-4">

                    <div class="card-header bg-primary text-white">

                        <div class="d-flex justify-content-between">

                            <strong>

                                {{ $tour->ten_tour }}

                            </strong>

                            <span>

                                {{ $tour->lichHopLe->count() }} lịch

                            </span>

                        </div>

                    </div>

                    <div class="card-body">

                        <div class="row">

                            @foreach ($tour->lichHopLe as $lich)
                                <div class="col-lg-4 mb-3">

                                    <label class="card h-100 border shadow-sm">

                                        <div class="card-body">

                                            <div class="form-check mb-2">

                                                <input class="form-check-input lich-checkbox" type="checkbox"
                                                    name="lich_ids[]" value="{{ $lich->id }}"
                                                    id="lich{{ $lich->id }}">

                                                <label class="form-check-label fw-bold" for="lich{{ $lich->id }}">
                                                    Lịch #{{ $lich->id }}
                                                </label>

                                            </div>

                                            <div class="form-check mb-3">

                                                <input class="form-check-input lich-chinh-radio" type="radio"
                                                    name="lich_chinh_id" value="{{ $lich->id }}"
                                                    id="radio{{ $lich->id }}" disabled>

                                                <label class="form-check-label text-success"
                                                    for="radio{{ $lich->id }}">
                                                    ⭐ Chọn làm lịch chính
                                                </label>

                                            </div>

                                            <hr>

                                            <div class="small">

                                                <div class="mb-2">

                                                    <i class="fas fa-calendar-alt text-primary"></i>

                                                    Khởi hành:

                                                    <strong>

                                                        {{ $lich->ngay_khoi_hanh->format('d/m/Y') }}

                                                    </strong>

                                                </div>

                                                <div class="mb-2">

                                                    <i class="fas fa-calendar-check text-success"></i>

                                                    Kết thúc:

                                                    <strong>

                                                        {{ $lich->ngay_ket_thuc->format('d/m/Y') }}

                                                    </strong>

                                                </div>

                                                <div class="mb-2">

                                                    <i class="fas fa-users text-info"></i>

                                                    Đã đặt:

                                                    <strong>

                                                        {{ $lich->so_cho_da_dat }}

                                                        /

                                                        {{ $lich->so_cho }}

                                                    </strong>

                                                </div>

                                                <div class="mb-2">

                                                    <i class="fas fa-chair text-warning"></i>

                                                    Còn lại:

                                                    <strong>

                                                        {{ $lich->so_cho_con_lai }}

                                                    </strong>

                                                </div>

                                                <div>

                                                    @php

                                                        $xe = 14;

                                                        if ($lich->so_cho_da_dat > 14) {
                                                            $xe = 27;
                                                        }

                                                        if ($lich->so_cho_da_dat > 27) {
                                                            $xe = 43;
                                                        }

                                                    @endphp

                                                    <span class="badge bg-success">

                                                        Xe {{ $xe }} chỗ

                                                    </span>

                                                </div>

                                            </div>

                                        </div>

                                    </label>

                                </div>
                            @endforeach

                        </div>

                    </div>

                </div>

            @empty

                <div class="alert alert-warning">

                    Không còn lịch nào đủ điều kiện để gộp.

                </div>

            @endforelse

            @if ($tours->count())
                <div class="card shadow">

                    <div class="card-header">

                        <strong>

                            Lý do gộp

                        </strong>

                    </div>

                    <div class="card-body">

                        <textarea class="form-control" rows="4" name="ly_do_de_xuat"
                            placeholder="Ví dụ: Gộp theo quyết định điều hành, tối ưu xe, tối ưu nhân sự..." required></textarea>

                    </div>

                    <div class="card-footer text-end">

                        <button class="btn btn-success btn-lg">

                            <i class="fas fa-check-circle me-1"></i>

                            Tạo yêu cầu gộp

                        </button>

                    </div>

                </div>
            @endif

        </form>

    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {

            const checkboxes = document.querySelectorAll(".lich-checkbox");
            const radios = document.querySelectorAll(".lich-chinh-radio");
            const counter = document.getElementById("soLichDaChon");

            function update() {

                let count = 0;

                checkboxes.forEach(cb => {

                    const radio = cb.closest(".card-body")
                        .querySelector(".lich-chinh-radio");

                    if (cb.checked) {

                        count++;

                        radio.disabled = false;

                    } else {

                        radio.disabled = true;
                        radio.checked = false;

                    }

                });

                counter.innerText = count;

                // Nếu chưa có radio nào được chọn
                const selectedRadio =
                    document.querySelector(".lich-chinh-radio:checked");

                if (!selectedRadio) {

                    const firstEnabled =
                        document.querySelector(".lich-chinh-radio:not(:disabled)");

                    if (firstEnabled) {

                        firstEnabled.checked = true;

                    }

                }

            }

            checkboxes.forEach(cb => {

                cb.addEventListener("change", update);

            });

            update();

            document
                .getElementById("formThuCong")
                .addEventListener("submit", function(e) {

                    const checked =
                        document.querySelectorAll(".lich-checkbox:checked");

                    if (checked.length < 2) {

                        e.preventDefault();

                        alert("Phải chọn tối thiểu 2 lịch.");

                        return;

                    }

                    const radio =
                        document.querySelector(".lich-chinh-radio:checked");

                    if (!radio) {

                        e.preventDefault();

                        alert("Bạn phải chọn lịch chính.");

                        return;

                    }

                });

        });
    </script>

@endsection
