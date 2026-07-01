@extends('Layouts.admin')

@section('content')
    <div class="container-fluid">

        <div class="card">

            <div class="card-header d-flex justify-content-between">

                <h4>Cập nhật Tour</h4>

                <a href="{{ route('Admin.tours.index') }}" class="btn btn-secondary">
                    Quay lại
                </a>

            </div>

            <div class="card-body">

                <form action="{{ route('Admin.tours.update', $tour) }}" method="POST" enctype="multipart/form-data">

                    @csrf
                    @method('PUT')

                    <div class="row">

                        <div class="col-md-6">

                            <label>Tên Tour</label>

                            <input type="text" name="ten_tour" class="form-control mb-3"
                                value="{{ old('ten_tour', $tour->ten_tour) }}">

                        </div>

                        <div class="col-md-6">

                            <label>Danh mục</label>

                            <select name="danh_muc_id" class="form-control mb-3">

                                @foreach ($danhMucs as $item)
                                    <option value="{{ $item->id }}"
                                        {{ $tour->danh_muc_id == $item->id ? 'selected' : '' }}>

                                        {{ $item->ten_danh_muc }}

                                    </option>
                                @endforeach

                            </select>

                        </div>

                    </div>

                    <label>Ảnh đại diện</label>

                    @if ($tour->anh_dai_dien)
                        <div class="mb-3">

                            <img src="{{ asset('storage/' . $tour->anh_dai_dien) }}" class="img-thumbnail shadow"
                                style="width:220px;height:150px;object-fit:cover">

                        </div>
                    @endif

                    <input type="file" name="anh_dai_dien" id="anh_dai_dien" class="form-control">

                    <img id="preview" class="img-thumbnail mt-3" style="display:none;width:220px;">

                    <div class="row">

                        <div class="row">

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Giá tour (Giá niêm yết)</label>

                                <input type="number" name="gia_tour" class="form-control"
                                    value="{{ old('gia_tour', $tour->gia_tour ?? '') }}">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Giá người lớn</label>

                                <input type="number" name="gia_nguoi_lon" class="form-control"
                                    value="{{ old('gia_nguoi_lon', $tour->gia_nguoi_lon ?? '') }}">
                            </div>

                        </div>

                        <div class="row">

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Giá trẻ em</label>

                                <input type="number" name="gia_tre_em" class="form-control"
                                    value="{{ old('gia_tre_em', $tour->gia_tre_em ?? '') }}">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Giá em bé</label>

                                <input type="number" name="gia_em_be" class="form-control"
                                    value="{{ old('gia_em_be', $tour->gia_em_be ?? '') }}">
                            </div>

                        </div>

                        @php
                            preg_match('/(\d+)\s*ngày/', $tour->thoi_luong, $ngayMatch);
                            preg_match('/(\d+)\s*đêm/', $tour->thoi_luong, $demMatch);

                            $soNgay = $ngayMatch[1] ?? 1;
                            $soDem = $demMatch[1] ?? 0;
                        @endphp

                        <div class="col-md-2">

                            <label class="form-label">
                                Số ngày
                            </label>

                            <select name="so_ngay" class="form-select mb-3">

                                @for ($i = 1; $i <= 30; $i++)
                                    <option value="{{ $i }}" {{ $soNgay == $i ? 'selected' : '' }}>
                                        {{ $i }} ngày
                                    </option>
                                @endfor

                            </select>

                        </div>

                        <div class="col-md-2">

                            <label class="form-label">
                                Số đêm
                            </label>

                            <select name="so_dem" class="form-select mb-3">

                                @for ($i = 0; $i <= 29; $i++)
                                    <option value="{{ $i }}" {{ $soDem == $i ? 'selected' : '' }}>
                                        {{ $i }} đêm
                                    </option>
                                @endfor

                            </select>

                        </div>

                        <div class="col-md-4">

                            <label>Số khách tối đa</label>

                            <input type="number" name="so_khach_toi_da" class="form-control mb-3"
                                value="{{ $tour->so_khach_toi_da }}">

                        </div>

                    </div>

                    <div class="row">

                        <div class="col-md-6">

                            <label>Điểm khởi hành</label>

                            <input type="text" name="dia_diem_khoi_hanh" class="form-control mb-3"
                                value="{{ $tour->dia_diem_khoi_hanh }}">

                        </div>

                        <div class="col-md-6">

                            <label>Điểm đến</label>

                            <input type="text" name="diem_den" class="form-control mb-3" value="{{ $tour->diem_den }}">

                        </div>

                    </div>

                    {{-- <label>Phương tiện</label>

                    <input type="text" name="phuong_tien" class="form-control mb-3" value="{{ $tour->phuong_tien }}"> --}}

                    <label>Tiêu chuẩn khách sạn</label>

                    <input type="text" name="tieu_chuan_khach_san" class="form-control mb-3"
                        value="{{ $tour->tieu_chuan_khach_san }}">

                    <label>Mô tả</label>

                    <textarea name="mo_ta" rows="4" class="form-control mb-3">{{ $tour->mo_ta }}</textarea>

                    <label>Tổng quan lịch trình</label>

                    <textarea name="tong_quan_lich_trinh" rows="4" class="form-control mb-3">{{ $tour->tong_quan_lich_trinh }}</textarea>

                    <label>Dịch vụ bao gồm</label>

                    <textarea name="dich_vu_bao_gom" rows="4" class="form-control mb-3">{{ $tour->dich_vu_bao_gom }}</textarea>

                    <label>Dịch vụ không bao gồm</label>

                    <textarea name="dich_vu_khong_bao_gom" rows="4" class="form-control mb-3">{{ $tour->dich_vu_khong_bao_gom }}</textarea>

                    <label>Trạng thái</label>

                    <select name="trang_thai" class="form-control mb-4">

                        <option value="active" {{ $tour->trang_thai == 'active' ? 'selected' : '' }}>
                            Hoạt động
                        </option>

                        <option value="inactive" {{ $tour->trang_thai == 'inactive' ? 'selected' : '' }}>
                            Ngừng hoạt động
                        </option>

                    </select>

                    <div class="d-flex justify-content-end gap-2 mt-4">

                        <a href="{{ route('Admin.tours.index') }}" class="btn btn-secondary">

                            Hủy

                        </a>

                        <button class="btn btn-primary">

                            <i class="fas fa-save"></i>

                            Cập nhật Tour

                        </button>

                    </div>

                </form>

            </div>

        </div>

    </div>
@endsection
<script>
    document.getElementById('so_ngay').addEventListener('change', function() {

        let ngay = parseInt(this.value);

        let dem = Math.max(ngay - 1, 0);

        let text = ngay + ' ngày ' + dem + ' đêm';

        document.getElementById('thoi_luong_hien_thi').value = text;

        document.getElementById('thoi_luong').value = text;

    });
    document.getElementById('anh_dai_dien').onchange = function(e) {

        let file = e.target.files[0];

        if (file) {

            preview.src = URL.createObjectURL(file);

            preview.style.display = 'block';

        }

    }
</script>
