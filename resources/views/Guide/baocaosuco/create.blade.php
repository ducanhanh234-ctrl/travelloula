@extends('Layouts.guide')

@section('content')

<div class="container">
    <div class="card shadow">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">
                Tạo báo cáo sự cố
            </h4>
        </div>

        <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('Guide.baocaosuco.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="form-label">
                        Lịch khởi hành
                    </label>

                    <select
                        name="lich_khoi_hanh_id"
                        class="form-select"
                        required>
                        <option value="">
                            -- Chọn lịch khởi hành --
                        </option>

                        @foreach($lichKhoiHanhs as $lich)
                            <option value="{{ $lich->id }}">
                                {{ $lich->tour->ten_tour }}
                                -
                                {{ \Carbon\Carbon::parse($lich->ngay_khoi_hanh)->format('d/m/Y') }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">
                        Tiêu đề
                    </label>

                    <input
                        type="text"
                        name="tieu_de"
                        class="form-control"
                        required>
                </div>

                <div class="mb-3">
                    <label class="form-label">
                        Loại sự cố
                    </label>

                    <select
                        name="loai_su_co"
                        class="form-select">
                        <option value="khach_hang">
                            Khách hàng
                        </option>

                        <option value="phuong_tien">
                            Phương tiện
                        </option>

                        <option value="thoi_tiet">
                            Thời tiết
                        </option>

                        <option value="lich_trinh">
                            Lịch trình
                        </option>

                        <option value="khac">
                            Khác
                        </option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">
                        Mức độ
                    </label>

                    <select
                        name="muc_do"
                        class="form-select">
                        <option value="thap">
                            Thấp
                        </option>

                        <option value="trung_binh">
                            Trung bình
                        </option>

                        <option value="cao">
                            Cao
                        </option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">
                        Nội dung
                    </label>

                    <textarea
                        name="noi_dung"
                        rows="6"
                        class="form-control"
                        required></textarea>
                </div>

                <div class="d-flex justify-content-end">
                    <a href="{{ route('Guide.baocaosuco.index') }}"
                       class="btn btn-secondary me-2">
                        Quay lại
                    </a>

                    <button
                        type="submit"
                        class="btn btn-primary">
                        Gửi báo cáo
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
