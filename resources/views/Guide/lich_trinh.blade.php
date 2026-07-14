@extends('layouts.guide')

@section('title','Lịch trình tour')

@section('page-title','Lịch trình tour')

@section('styles')

<style>
    .timeline {

        position: relative;

        margin-left: 35px;

    }

    .timeline::before {

        content: '';

        position: absolute;

        left: 0;

        top: 0;

        bottom: 0;

        width: 3px;

        background: #22c55e;

    }

    .timeline-item {

        position: relative;

        padding-left: 35px;

        margin-bottom: 30px;

    }

    .timeline-dot {

        position: absolute;

        left: -9px;

        top: 6px;

        width: 18px;

        height: 18px;

        border-radius: 50%;

        background: #22c55e;

        border: 4px solid white;

        box-shadow: 0 0 0 2px #22c55e;

    }

    .time {

        font-weight: bold;

        color: #16a34a;

        font-size: 18px;

    }

</style>

@endsection

@section('content')

<div class="card">

    <div class="card-header d-flex justify-content-between align-items-center">

    <div>
        <h4 class="mb-0 fw-bold">
            {{ $tour->ten_tour }}
        </h4>

    </div>

    <a href="{{ url()->previous() }}" class="btn btn-outline-secondary">
        <i class="fas fa-arrow-left me-2"></i>
        Quay lại
    </a>

</div>

    <div class="card-body">

        @foreach($lichTrinhs->groupBy('ngay_thu') as $ngay=>$items)

        <h3 class="mb-4">

            Ngày {{ $ngay }}

        </h3>

        <div class="timeline">

            @foreach($items->sortBy('gio_bat_dau') as $item)

            <div class="timeline-item">

                <div class="timeline-dot"></div>

                <div class="time">

                    {{ \Carbon\Carbon::parse($item->gio_bat_dau)->format('H:i') }}

                    @if($item->gio_ket_thuc)

                    -

                    {{ \Carbon\Carbon::parse($item->gio_ket_thuc)->format('H:i') }}

                    @endif

                </div>

                <div class="card mt-2 shadow-sm">

                    <div class="card-body">

                        <h5>

                            {{ $item->tieu_de }}

                        </h5>

                        @if($item->dia_diem)

                        <p>

                            <i class="fas fa-location-dot text-danger"></i>

                            {{ $item->dia_diem }}

                        </p>

                        @endif

                        @if($item->hoat_dong)

                        <p>

                            {{ $item->hoat_dong }}

                        </p>

                        @endif

                        @if($item->bua_an)

                        <p>

                            🍽

                            {{ $item->bua_an }}

                        </p>

                        @endif

                        @if($item->thong_tin_khach_san)

                        <p>

                            🏨

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

</div>

@endsection
