@extends('layouts.app')

@section('content')

<div class="container py-5">

    <div class="text-center mb-5">
        <h2 class="fw-bold text-primary">
            <i class="fa-solid fa-suitcase"></i>
            Tour đã đặt
        </h2>
        <p class="text-muted">
            Quản lý tất cả các tour bạn đã đặt
        </p>
    </div>

    @forelse($datTours as $booking)

    <div class="card shadow-sm border-0 rounded-4 mb-4">

        <div class="card-header bg-white d-flex justify-content-between align-items-center">

            <div>
                <strong>Mã đặt tour:</strong>
                <span class="text-primary fw-bold">
                    {{ $booking->ma_dat_tour }}
                </span>
            </div>

            <div>

                @if($booking->trang_thai=='cho_xac_nhan')

                    <span class="badge bg-warning text-dark px-3 py-2">
                        Chờ xác nhận
                    </span>

                @elseif($booking->trang_thai=='da_xac_nhan')

                    <span class="badge bg-info px-3 py-2">
                        Đã xác nhận
                    </span>

                @elseif($booking->trang_thai=='da_thanh_toan')

                    <span class="badge bg-success px-3 py-2">
                        Đã thanh toán
                    </span>

                @else

                    <span class="badge bg-danger px-3 py-2">
                        Đã hủy
                    </span>

                @endif

            </div>

        </div>

        <div class="card-body">

            <div class="row">

                <div class="col-md-4 text-center">

                    @if($booking->tour->anh_dai_dien)

                        <img src="{{ asset('storage/'.$booking->tour->anh_dai_dien) }}"
                             class="img-fluid rounded shadow-sm"
                             style="height:220px;width:100%;object-fit:cover;">

                    @else

                        <img src="https://placehold.co/500x300"
                             class="img-fluid rounded shadow-sm">

                    @endif

                </div>

                <div class="col-md-8">

                    <h3 class="fw-bold text-primary mb-3">
                        {{ $booking->tour->ten_tour }}
                    </h3>

                    <div class="row">

                        <div class="col-md-6 mb-2">
                            <i class="fa-solid fa-calendar text-primary"></i>
                            <strong>Khởi hành:</strong><br>
                            {{ optional($booking->lichKhoiHanh)->ngay_khoi_hanh }}
                        </div>

                        <div class="col-md-6 mb-2">
                            <i class="fa-solid fa-user text-primary"></i>
                            <strong>Người đặt:</strong><br>
                            {{ $booking->nguoiDung->name }}
                        </div>

                        <div class="col-md-6 mb-2">
                            <i class="fa-solid fa-phone text-success"></i>
                            <strong>SĐT:</strong><br>
                            {{ $booking->nguoiDung->phone }}
                        </div>

                        <div class="col-md-6 mb-2">
                            <i class="fa-solid fa-envelope text-danger"></i>
                            <strong>Email:</strong><br>
                            {{ $booking->nguoiDung->email }}
                        </div>

                        <div class="col-12 mt-2">

                            <i class="fa-solid fa-users text-warning"></i>

                            <strong>Số lượng:</strong>

                            {{ $booking->so_nguoi_lon }} Người lớn

                            |

                            {{ $booking->so_tre_em }} Trẻ em

                        </div>

                    </div>

                </div>

            </div>

        </div>

        <div class="card-footer bg-light">

            <div class="row align-items-center">

                <div class="col-md-6">

                    <h4 class="text-danger fw-bold mb-1">
                        {{ number_format($booking->tong_tien,0,',','.') }} đ
                    </h4>

                    <span class="text-success">
                        Đã thanh toán:
                        {{ number_format($booking->so_tien_da_thanh_toan,0,',','.') }} đ
                    </span>

                </div>

                <div class="col-md-6 text-md-end mt-3 mt-md-0">

                    <a href="{{route('tour_da_dat.show',$booking->id)}}"
                       class="btn btn-outline-primary me-2">
                        <i class="fa-solid fa-eye"></i>
                        Chi tiết
                    </a>

                    

                    

                    <form action="{{ route('tour_da_dat.destroy',$booking->id) }}"
      method="POST"
      class="d-inline"
      onsubmit="return confirm('Bạn có chắc chắn muốn hủy tour?')">

    @csrf
    @method('DELETE')

    <button class="btn btn-danger btn-sm">
        Hủy tour
    </button>

</form>

                   

                </div>

            </div>

        </div>

    </div>

    @empty

    <div class="alert alert-info text-center shadow-sm">

        <h5>Bạn chưa đặt tour nào.</h5>

    </div>

    @endforelse

</div>

@endsection

