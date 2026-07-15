@extends('Layouts.guide')

@section('content')
    <div class="container">
        <div class="card shadow">
            <div class="card-header bg-success text-white">
                <h4 class="mb-0">
                    <i class="fas fa-edit me-2"></i>
                    Chỉnh sửa báo cáo sự cố
                </h4>
                <small class="text-white-50">
                    Cập nhật thông tin báo cáo sự cố trong quá trình dẫn tour.
                </small>
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

                <div class="alert alert-light border">
                    <div class="row">
                        <div class="col-md-6">
                            <strong>Mã báo cáo:</strong>
                            #BC{{ str_pad($baoCao->id, 5, '0', STR_PAD_LEFT) }}
                        </div>

                        <div class="col-md-6">
                            <strong>Ngày tạo:</strong>
                            {{ $baoCao->created_at->format('d/m/Y H:i') }}
                        </div>
                    </div>
                </div>

                <form action="{{ route('Guide.baocaosuco.update', $baoCao->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label class="form-label fw-bold text-success">
                            <i class="fas fa-calendar-alt me-1"></i>
                            Lịch khởi hành
                        </label>

                        <select name="lich_khoi_hanh_id" class="form-select" required>
                            <option value="">
                                -- Chọn lịch khởi hành --
                            </option>

                            @foreach($lichKhoiHanhs as $lich)
                                <option value="{{ $lich->id }}" {{ old('lich_khoi_hanh_id', $baoCao->lich_khoi_hanh_id) == $lich->id ? 'selected' : '' }}>
                                    {{ $lich->tour->ten_tour }}
                                    -
                                    {{ \Carbon\Carbon::parse($lich->ngay_khoi_hanh)->format('d/m/Y') }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold text-success">
                            <i class="fas fa-heading me-1"></i>
                            Tiêu đề
                        </label>

                        <input type="text" name="tieu_de" class="form-control"
                            value="{{ old('tieu_de', $baoCao->tieu_de) }}" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold text-success">
                            <i class="fas fa-tags me-1"></i>
                            Loại sự cố
                        </label>

                        <select name="loai_su_co" class="form-select">
                            <option value="khach_hang" {{ old('loai_su_co', $baoCao->loai_su_co) == 'khach_hang' ? 'selected' : '' }}>
                                Khách hàng
                            </option>

                            <option value="phuong_tien" {{ old('loai_su_co', $baoCao->loai_su_co) == 'phuong_tien' ? 'selected' : '' }}>
                                Phương tiện
                            </option>

                            <option value="thoi_tiet" {{ old('loai_su_co', $baoCao->loai_su_co) == 'thoi_tiet' ? 'selected' : '' }}>
                                Thời tiết
                            </option>

                            <option value="lich_trinh" {{ old('loai_su_co', $baoCao->loai_su_co) == 'lich_trinh' ? 'selected' : '' }}>
                                Lịch trình
                            </option>

                            <option value="khac" {{ old('loai_su_co', $baoCao->loai_su_co) == 'khac' ? 'selected' : '' }}>
                                Khác
                            </option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold text-success">
                            <i class="fas fa-exclamation-circle me-1"></i>
                            Mức độ
                        </label>

                        <select name="muc_do" class="form-select" required>
                            <option value="thap" {{ old('muc_do', $baoCao->muc_do) == 'thap' ? 'selected' : '' }}>
                                Thấp
                            </option>

                            <option value="trung_binh" {{ old('muc_do', $baoCao->muc_do) == 'trung_binh' ? 'selected' : '' }}>
                                Trung bình
                            </option>

                            <option value="cao" {{ old('muc_do', $baoCao->muc_do) == 'cao' ? 'selected' : '' }}>
                                Cao
                            </option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold text-success">
                            <i class="fas fa-align-left me-1"></i>
                            Nội dung
                        </label>

                        <textarea name="noi_dung" rows="6" class="form-control"
                            required>{{ old('noi_dung', $baoCao->noi_dung) }}</textarea>
                    </div>

                    <div class="d-flex justify-content-end">
                        <a href="{{ route('Guide.baocaosuco.index') }}" class="btn btn-secondary me-2">
                            Quay lại
                        </a>

                        <button type="submit" class="btn btn-warning">
                            <i class="fas fa-save"></i>
                            Cập nhật báo cáo
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
