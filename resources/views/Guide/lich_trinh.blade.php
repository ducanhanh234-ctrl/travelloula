@extends('layouts.guide')

@section('title', 'Lịch trình tour')
@section('page-title', 'Lịch trình tour')

@section('styles')

<style>
    /* ==============================
       TIMELINE
    ============================== */

    .timeline {
        position: relative;
        margin-left: 20px;
        padding-left: 35px;
    }

    /* Đường dọc */
    .timeline::before {
        content: '';
        position: absolute;
        left: 0;
        top: 5px;
        bottom: 5px;
        width: 3px;
        background: #22c55e;
        border-radius: 10px;
    }

    /* Mỗi mốc thời gian */
    .timeline-item {
        position: relative;
        margin-bottom: 35px;
    }

    /* Chấm tròn */
    .timeline-dot {
        position: absolute;
        left: -43px;
        top: 5px;

        width: 18px;
        height: 18px;

        border-radius: 50%;
        background: #22c55e;

        border: 4px solid #fff;

        box-shadow: 0 0 0 2px #22c55e;

        z-index: 2;
    }

    /* Thời gian */
    .time {
        font-weight: 700;
        color: #16a34a;
        font-size: 18px;
        margin-bottom: 10px;
    }

    /* Card nội dung */
    .timeline-card {
        background: #fff;
        border: 1px solid #e5e7eb;
        border-radius: 10px;

        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);

        transition: all 0.2s ease;
    }

    .timeline-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.10);
    }

    .timeline-card .card-body {
        padding: 18px 20px;
    }

    .timeline-card h5 {
        margin-bottom: 12px;
        font-weight: 700;
        color: #1f2937;
    }

    .timeline-card p {
        margin-bottom: 8px;
        color: #4b5563;
    }

    .timeline-card p:last-child {
        margin-bottom: 0;
    }

    /* Tiêu đề ngày */
    .day-title {
        margin-bottom: 20px;
        font-weight: 700;
        color: #111827;
        padding-bottom: 10px;
        border-bottom: 1px solid #e5e7eb;
    }

    /* Responsive */
    @media (max-width: 768px) {

        .timeline {
            margin-left: 10px;
            padding-left: 25px;
        }

        .timeline-dot {
            left: -33px;
        }

        .time {
            font-size: 16px;
        }

        .timeline-card .card-body {
            padding: 15px;
        }
    }
</style>

@endsection

@section('content')

<div class="card">

```
{{-- HEADER --}}
<div class="card-header d-flex justify-content-between align-items-center">

    <div>
        <h4 class="mb-0 fw-bold">
            {{ $tour->ten_tour }}
        </h4>
    </div>

    <a href="{{ url()->previous() }}"
       class="btn btn-outline-secondary">

        <i class="fas fa-arrow-left me-2"></i>
        Quay lại

    </a>

</div>


{{-- CONTENT --}}
<div class="card-body">

    @foreach($lichTrinhs->groupBy('ngay_thu') as $ngay => $items)

        <h3 class="day-title">
            Ngày {{ $ngay }}
        </h3>


        <div class="timeline">

            @foreach($items->sortBy('gio_bat_dau') as $item)

                <div class="timeline-item">

                    {{-- CHẤM TIMELINE --}}
                    <div class="timeline-dot"></div>


                    {{-- THỜI GIAN --}}
                    <div class="time">

                        {{ \Carbon\Carbon::parse($item->gio_bat_dau)->format('H:i') }}

                        @if($item->gio_ket_thuc)

                            -
                            {{ \Carbon\Carbon::parse($item->gio_ket_thuc)->format('H:i') }}

                        @endif

                    </div>


                    {{-- NỘI DUNG --}}
                    <div class="timeline-card">

                        <div class="card-body">

                            {{-- TIÊU ĐỀ --}}
                            <h5>
                                {{ $item->tieu_de }}
                            </h5>


                            {{-- ĐỊA ĐIỂM --}}
                            @if($item->dia_diem)

                                <p>
                                    <i class="fas fa-location-dot text-danger me-2"></i>

                                    {{ $item->dia_diem }}
                                </p>

                            @endif


                            {{-- HOẠT ĐỘNG --}}
                            @if($item->hoat_dong)

                                <p>
                                    <i class="fas fa-person-walking me-2 text-primary"></i>

                                    {{ $item->hoat_dong }}
                                </p>

                            @endif


                            {{-- BỮA ĂN --}}
                            @if($item->bua_an)

                                <p>
                                    <i class="fas fa-utensils me-2 text-warning"></i>

                                    {{ $item->bua_an }}
                                </p>

                            @endif


                            {{-- KHÁCH SẠN --}}
                            @if($item->thong_tin_khach_san)

                                <p>
                                    <i class="fas fa-hotel me-2 text-info"></i>

                                    {{ $item->thong_tin_khach_san }}
                                </p>

                            @endif

                        </div>

                    </div>

                </div>

            @endforeach

        </div>

    @endforeach

</div>
```

</div>

@endsection
