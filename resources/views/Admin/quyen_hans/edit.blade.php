@extends('layouts.admin')
@section('content')
<div class="container py-4">
    <h3>Chỉnh sửa quyền</h3>

    <form action="{{ route('Admin.quyen-hans.update', $quyenHan->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="form-label">Tên kỹ thuật</label>
            <input type="text" name="ten" class="form-control" value="{{ old('ten', $quyenHan->ten) }}">
            <div class="text-danger">{{ $errors->first('ten') }}</div>
        </div>

        <div class="mb-3">
            <label class="form-label">Tên hiển thị</label>
            <input type="text" name="ten_hien_thi" class="form-control" value="{{ old('ten_hien_thi', $quyenHan->ten_hien_thi) }}">
            <div class="text-danger">{{ $errors->first('ten_hien_thi') }}</div>
        </div>

        <div class="mb-3">
            <label class="form-label">Mô tả</label>
            <textarea name="mo_ta" class="form-control" rows="3">{{ old('mo_ta', $quyenHan->mo_ta) }}</textarea>
            <div class="text-danger">{{ $errors->first('mo_ta') }}</div>
        </div>

        <div class="mb-3">
            <label class="form-label">Mô đun</label>
            <input type="text" name="mo_dun" class="form-control" value="{{ old('mo_dun', $quyenHan->mo_dun) }}">
            <div class="text-danger">{{ $errors->first('mo_dun') }}</div>
        </div>

        <div class="mb-3 form-check">
            <input type="checkbox" class="form-check-input" name="trang_thai" id="trang_thai" value="1" {{ old('trang_thai', $quyenHan->trang_thai) ? 'checked' : '' }}>
            <label class="form-check-label" for="trang_thai">Kích hoạt</label>
        </div>

        <button class="btn btn-primary">Cập nhật</button>
        <a class="btn btn-secondary" href="{{ route('Admin.quyen-hans.index') }}">Hủy</a>
    </form>
</div>
@endsection
