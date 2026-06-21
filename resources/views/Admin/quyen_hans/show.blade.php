@extends('layouts.admin')

@section('content')
<div class="container py-4">
    <h3>Chi tiết quyền</h3>

    <div class="card">
        <div class="card-body">
            <dl class="row mb-0">
                <dt class="col-sm-3">Tên kỹ thuật</dt>
                <dd class="col-sm-9">{{ $quyenHan->ten }}</dd>

                <dt class="col-sm-3">Tên hiển thị</dt>
                <dd class="col-sm-9">{{ $quyenHan->ten_hien_thi }}</dd>

                <dt class="col-sm-3">Mô đun</dt>
                <dd class="col-sm-9">{{ $quyenHan->mo_dun }}</dd>

                <dt class="col-sm-3">Mô tả</dt>
                <dd class="col-sm-9">{{ $quyenHan->mo_ta }}</dd>

                <dt class="col-sm-3">Trạng thái</dt>
                <dd class="col-sm-9">{{ $quyenHan->trang_thai ? 'Kích hoạt' : 'Không kích hoạt' }}</dd>
            </dl>

            <div class="mt-4">
                @php $currentUser = auth()->user(); @endphp
                @if($currentUser && $currentUser->hasPermission('permissions.edit'))
                    <a href="{{ route('Admin.quyen-hans.edit', $quyenHan->id) }}" class="btn btn-warning">Sửa</a>
                @endif
                <a href="{{ route('Admin.quyen-hans.index') }}" class="btn btn-secondary">Quay lại</a>
            </div>
        </div>
    </div>
</div>
@endsection
