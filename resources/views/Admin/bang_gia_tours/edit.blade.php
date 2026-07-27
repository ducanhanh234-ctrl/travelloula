@extends('layouts.admin')

@section('title', 'Cập nhật Bảng giá Tour')

@section('content')
    @php
        $currentUser = auth()->user();
    @endphp

    <style>
        :root {
            --tour-primary: #315be8;
            --tour-primary-dark: #244bd2;
            --tour-primary-light: #edf4ff;
            --tour-purple: #5b4dea;
            --tour-cyan: #16c7e8;

            --tour-text-dark: #172b4d;
            --tour-text-main: #344563;
            --tour-text-muted: #6b7895;
            --tour-text-light: #98a2b3;

            --tour-border: #dce6f5;
            --tour-border-light: #e8eef8;

            --tour-white: #ffffff;
            --tour-hover: #f3f7ff;

            --tour-success: #149963;
            --tour-success-light: #eaf9f1;

            --tour-warning: #c98212;
            --tour-warning-light: #fff7e8;

            --tour-danger: #dc4c64;
            --tour-danger-light: #fff0f3;

            --tour-neutral: #68758c;
            --tour-neutral-light: #f1f4f8;
        }

        .tour-management-page {
            padding: 24px 0;
            color: var(--tour-text-dark);
        }

        /* Top header */
        .tour-page-top {
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            flex-wrap: wrap;
        }

        .tour-page-heading h3 {
            margin: 0;
            color: #173576;
            font-size: 23px;
            font-weight: 750;
            letter-spacing: -0.2px;
        }

        .tour-page-heading p {
            margin: 6px 0 0;
            color: var(--tour-text-muted);
            font-size: 14px;
        }

        .btn-back-tour {
            min-height: 41px;
            padding: 9px 16px;
            color: #53698f;
            background: var(--tour-white);
            border: 1px solid #ccd9ed;
            border-radius: 9px;
            box-shadow: 0 4px 12px rgba(16, 24, 40, 0.05);
            font-size: 13px;
            font-weight: 700;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 7px;
            transition: all 0.18s ease;
        }

        .btn-back-tour:hover {
            color: #304d83;
            background: #eaf1fb;
            border-color: #b9c9e0;
            text-decoration: none;
            transform: translateY(-1px);
        }

        /* Alerts */
        .tour-management-page .alert {
            margin-bottom: 18px;
            border: 1px solid transparent;
            border-radius: 10px;
            box-shadow: 0 4px 14px rgba(16, 24, 40, 0.05);
            font-size: 13px;
            font-weight: 600;
        }

        .tour-management-page .alert-danger {
            color: #a23449;
            background: #fff0f3;
            border-color: #f1cbd3;
        }

        /* Card Container */
        .tour-card {
            position: relative;
            overflow: hidden;
            background: var(--tour-white);
            border: 1px solid #d8e4f6;
            border-radius: 15px;
            box-shadow: 0 8px 30px rgba(28, 65, 139, 0.1);
        }

        .tour-card::before {
            position: absolute;
            top: 0;
            right: 0;
            left: 0;
            z-index: 3;
            height: 4px;
            content: "";
            background: linear-gradient(
                90deg,
                #2458e7,
                #3478ef,
                #18c7e7,
                #5947e9
            );
        }

        /* Header card */
        .tour-card-header {
            position: relative;
            min-height: 100px;
            padding: 22px 24px;
            overflow: hidden;
            color: var(--tour-white);
            background: linear-gradient(
                120deg,
                #2856df 0%,
                #316cec 55%,
                #5b49e8 100%
            );
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
        }

        .tour-card-header::before {
            position: absolute;
            right: -50px;
            bottom: -105px;
            width: 235px;
            height: 235px;
            content: "";
            border: 21px solid rgba(255, 255, 255, 0.07);
            border-radius: 50%;
        }

        .tour-header-content {
            position: relative;
            z-index: 2;
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .tour-header-icon {
            width: 46px;
            height: 46px;
            flex-shrink: 0;
            color: var(--tour-white);
            background: rgba(255, 255, 255, 0.16);
            border: 1px solid rgba(255, 255, 255, 0.3);
            border-radius: 12px;
            box-shadow: 0 7px 18px rgba(20, 43, 128, 0.2);
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .tour-header-icon i {
            font-size: 18px;
        }

        .tour-card-header h4 {
            margin: 0;
            color: var(--tour-white);
            font-size: 20px;
            font-weight: 750;
        }

        .tour-card-header p {
            margin: 4px 0 0;
            color: rgba(255, 255, 255, 0.82);
            font-size: 12px;
        }

        /* Form Body */
        .tour-card-body {
            padding: 28px;
            background: var(--tour-white);
        }

        .form-group-custom {
            margin-bottom: 20px;
        }

        .form-group-custom label {
            margin-bottom: 8px;
            color: #29457d;
            font-size: 13px;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .form-group-custom label i {
            color: var(--tour-primary);
            font-size: 12px;
        }

        .form-control-custom,
        .form-select-custom {
            width: 100%;
            min-height: 42px;
            padding: 9px 14px;
            color: #344563;
            background-color: var(--tour-white);
            border: 1px solid #ccd9ed;
            border-radius: 9px;
            font-size: 13px;
            box-shadow: none;
            transition: all 0.18s ease;
        }

        .form-control-custom:focus,
        .form-select-custom:focus {
            border-color: #4f78eb;
            box-shadow: 0 0 0 3px rgba(49, 91, 232, 0.1);
            outline: none;
        }

        .form-control-custom[readonly] {
            background-color: #f4f7fc;
            color: #24417d;
            font-weight: 750;
            border-color: #dce6f5;
        }

        /* Calculation Box Display */
        .calculated-price-box {
            padding: 16px;
            background: #f5f8ff;
            border: 1px dashed #b8cefc;
            border-radius: 11px;
            margin-top: 10px;
            margin-bottom: 20px;
        }

        .calculated-title {
            font-size: 12px;
            font-weight: 750;
            color: #24417d;
            margin-bottom: 12px;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        /* Action Buttons */
        .form-actions {
            margin-top: 28px;
            padding-top: 20px;
            border-top: 1px solid var(--tour-border-light);
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .btn-submit-tour {
            min-height: 42px;
            padding: 10px 24px;
            color: var(--tour-white);
            background: linear-gradient(
                135deg,
                #315be8 0%,
                #3c6df0 55%,
                #594bea 100%
            );
            border: 1px solid #315be8;
            border-radius: 9px;
            box-shadow: 0 6px 16px rgba(49, 91, 232, 0.23);
            font-size: 13px;
            font-weight: 700;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            transition: all 0.18s ease;
        }

        .btn-submit-tour:hover {
            color: var(--tour-white);
            background: linear-gradient(
                135deg,
                #264ed4 0%,
                #315edc 55%,
                #4d40d8 100%
            );
            border-color: #264ed4;
            box-shadow: 0 8px 20px rgba(49, 91, 232, 0.3);
            transform: translateY(-1px);
        }

        /* Responsive */
        @media (max-width: 768px) {
            .tour-management-page {
                padding: 14px 0;
            }

            .tour-page-top {
                align-items: stretch;
                flex-direction: column;
            }

            .btn-back-tour {
                width: 100%;
            }

            .tour-card-body {
                padding: 18px;
            }

            .form-actions {
                flex-direction: column-reverse;
            }

            .btn-submit-tour, .btn-back-tour {
                width: 100%;
            }
        }
    </style>

    <div class="container-fluid tour-management-page">
        <!-- Top header -->
        <div class="tour-page-top">
            <div class="tour-page-heading">
                <h3>Cập nhật Bảng giá Tour</h3>
                <p>Điều chỉnh thông tin khoảng thời gian, tỷ lệ điều chỉnh và hiển thị bảng giá tự động.</p>
            </div>

            <a href="{{ route('Admin.bang-gia-tours.index') }}" class="btn-back-tour">
                <i class="fas fa-arrow-left"></i>
                Quay lại danh sách
            </a>
        </div>

        <!-- Notification errors -->
        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-triangle me-2"></i>
                <strong>Đã có lỗi xảy ra!</strong> Vui lòng kiểm tra lại thông tin bên dưới.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Đóng"></button>
            </div>
        @endif

        <!-- Card content -->
        <div class="tour-card">
            <div class="tour-card-header">
                <div class="tour-header-content">
                    <span class="tour-header-icon">
                        <i class="fas fa-tags"></i>
                    </span>
                    <div>
                        <h4>Chỉnh sửa Bảng giá #{{ $bang_gia_tour->id }}</h4>
                        <p>Thay đổi dữ liệu và bấm "Cập nhật" để lưu thay đổi vào hệ thống.</p>
                    </div>
                </div>
            </div>

            <div class="tour-card-body">
                <form action="{{ route('Admin.bang-gia-tours.update', $bang_gia_tour) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="row">
                        <!-- Chọn Tour -->
                        <div class="col-md-6 form-group-custom">
                            <label for="tour_id">
                                <i class="fas fa-route"></i> Chọn Tour áp dụng
                            </label>
                            <select name="tour_id" id="tour_id" class="form-select-custom">
                                @foreach($tours as $tour)
                                    <option 
                                        value="{{ $tour->id }}"
                                        data-adult="{{ $tour->gia_nguoi_lon }}"
                                        data-child="{{ $tour->gia_tre_em }}"
                                        @selected((string)$bang_gia_tour->tour_id === (string)$tour->id)
                                    >
                                        {{ $tour->ten_tour }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Tên bảng giá -->
                        <div class="col-md-6 form-group-custom">
                            <label for="ten_bang_gia">
                                <i class="fas fa-pen"></i> Tên bảng giá
                            </label>
                            <input 
                                type="text" 
                                name="ten_bang_gia" 
                                id="ten_bang_gia"
                                class="form-control-custom"
                                placeholder="Ví dụ: Giá Tour Mùa Cao Điểm, Lễ Tết..."
                                value="{{ old('ten_bang_gia', $bang_gia_tour->ten_bang_gia) }}"
                                required
                            >
                        </div>

                        <!-- Ngày bắt đầu -->
                        <div class="col-md-6 form-group-custom">
                            <label for="ngay_bat_dau">
                                <i class="fas fa-calendar-alt"></i> Ngày bắt đầu
                            </label>
                            <input 
                                type="date" 
                                name="ngay_bat_dau" 
                                id="ngay_bat_dau"
                                class="form-control-custom"
                                value="{{ old('ngay_bat_dau', $bang_gia_tour->ngay_bat_dau) }}"
                                required
                            >
                        </div>

                        <!-- Ngày kết thúc -->
                        <div class="col-md-6 form-group-custom">
                            <label for="ngay_ket_thuc">
                                <i class="fas fa-calendar-check"></i> Ngày kết thúc
                            </label>
                            <input 
                                type="date" 
                                name="ngay_ket_thuc" 
                                id="ngay_ket_thuc"
                                class="form-control-custom"
                                value="{{ old('ngay_ket_thuc', $bang_gia_tour->ngay_ket_thuc) }}"
                                required
                            >
                        </div>

                        <!-- Phần trăm tăng -->
                        <div class="col-md-6 form-group-custom">
                            <label for="phan_tram_tang">
                                <i class="fas fa-percent"></i> Phần trăm tăng (%)
                            </label>
                            <input 
                                type="number" 
                                step="any"
                                id="phan_tram_tang" 
                                name="phan_tram_tang" 
                                class="form-control-custom"
                                placeholder="0"
                                value="{{ old('phan_tram_tang', $bang_gia_tour->phan_tram_tang) }}"
                            >
                        </div>

                        <!-- Trạng thái -->
                        <div class="col-md-6 form-group-custom">
                            <label for="trang_thai">
                                <i class="fas fa-toggle-on"></i> Trạng thái
                            </label>
                            <select name="trang_thai" id="trang_thai" class="form-select-custom">
                                <option value="active" @selected(old('trang_thai', $bang_gia_tour->trang_thai) === 'active')>
                                    Đang hoạt động
                                </option>
                                <option value="inactive" @selected(old('trang_thai', $bang_gia_tour->trang_thai) === 'inactive')>
                                    Ngừng hoạt động
                                </option>
                            </select>
                        </div>
                    </div>

                    <!-- Khung tính giá tự động -->
                    <div class="calculated-price-box">
                        <div class="calculated-title">
                            <i class="fas fa-calculator text-primary"></i> 
                            Ước tính giá chi tiết sau điều chỉnh (%)
                        </div>
                        <div class="row">
                            <div class="col-md-6 form-group-custom mb-0">
                                <label for="gia_nguoi_lon">Giá người lớn (Tạm tính)</label>
                                <input 
                                    type="text" 
                                    id="gia_nguoi_lon" 
                                    class="form-control-custom" 
                                    readonly
                                >
                            </div>
                            <div class="col-md-6 form-group-custom mb-0">
                                <label for="gia_tre_em">Giá trẻ em (Tạm tính)</label>
                                <input 
                                    type="text" 
                                    id="gia_tre_em" 
                                    class="form-control-custom" 
                                    readonly
                                >
                            </div>
                        </div>
                    </div>

                    <!-- Action buttons -->
                    <div class="form-actions">
                        <button type="submit" class="btn-submit-tour">
                            <i class="fas fa-save"></i>
                            Cập nhật Bảng giá
                        </button>
                        
                        <a href="{{ route('Admin.bang-gia-tours.index') }}" class="btn-back-tour">
                            Hủy bỏ
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const tour = document.getElementById('tour_id');
        const pt = document.getElementById('phan_tram_tang');
        const adult = document.getElementById('gia_nguoi_lon');
        const child = document.getElementById('gia_tre_em');

        function tinhGia() {
            if (!tour || !tour.options[tour.selectedIndex]) return;

            let option = tour.options[tour.selectedIndex];
            let giaNL = parseFloat(option.dataset.adult) || 0;
            let giaTE = parseFloat(option.dataset.child) || 0;
            let percent = parseFloat(pt.value) || 0;

            let valNL = giaNL + (giaNL * percent / 100);
            let valTE = giaTE + (giaTE * percent / 100);

            adult.value = valNL.toLocaleString('vi-VN') + " VNĐ";
            child.value = valTE.toLocaleString('vi-VN') + " VNĐ";
        }

        if (tour && pt) {
            tour.addEventListener('change', tinhGia);
            pt.addEventListener('input', tinhGia);
            pt.addEventListener('change', tinhGia);
            
            // Tự động tính toán khi vừa tải trang xong
            tinhGia();
        }
    });
</script>
@endsection