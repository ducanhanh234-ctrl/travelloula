@extends('layouts.admin')
@section('content')
<div class="container py-4">
    <h3>Chỉnh sửa vai trò</h3>

    <form action="{{ route('Admin.vai-tros.update', $vaiTro->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="form-label">Tên vai trò</label>
            <input type="text" name="ten_vai_tro" class="form-control" value="{{ old('ten_vai_tro', $vaiTro->ten_vai_tro) }}">
            <div class="text-danger">{{ $errors->first('ten_vai_tro') }}</div>
        </div>

        <div class="mb-3">
            <label class="form-label">Mô tả</label>
            <textarea name="mo_ta" class="form-control" rows="3">{{ old('mo_ta', $vaiTro->mo_ta) }}</textarea>
            <div class="text-danger">{{ $errors->first('mo_ta') }}</div>
        </div>

        <div class="mb-3">
            <label class="form-label">Quyền</label>
            <div class="row gy-2">
                @foreach($quyenHans as $quyenHan)
                    <div class="col-md-6">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="quyen_han_ids[]" value="{{ $quyenHan->id }}" id="quyen{{ $quyenHan->id }}"
                                {{ in_array($quyenHan->id, old('quyen_han_ids', $vaiTro->quyenHans->pluck('id')->toArray())) ? 'checked' : '' }}>
                            <label class="form-check-label" for="quyen{{ $quyenHan->id }}">{{ $quyenHan->ten_hien_thi }} ({{ $quyenHan->ten }})</label>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="text-danger">{{ $errors->first('quyen_han_ids') }}</div>
        </div>

        <button class="btn btn-primary">Cập nhật</button>
        <a class="btn btn-secondary" href="{{ route('Admin.vai-tros.index') }}">Hủy</a>
    </form>
</div>
@endsection
