@extends('layouts.admin')

@section('content')
<style>
.vehicle-page{
    background:#f8fafc;
    min-height:100vh;
    padding:40px 48px;
    color:#0f172a;
}

.vehicle-header{
    display:flex;
    justify-content:space-between;
    align-items:flex-start;
    margin-bottom:30px;
}

.vehicle-title-wrap{
    display:flex;
    align-items:center;
    gap:14px;
}

.vehicle-icon{
    width:52px;
    height:52px;
    border-radius:14px;
    background:#eff6ff;
    color:#2563eb;
    display:flex;
    align-items:center;
    justify-content:center;
    font-size:28px;
}

.vehicle-title{
    font-size:38px;
    font-weight:800;
    margin:0;
    letter-spacing:-.8px;
}

.vehicle-subtitle{
    color:#64748b;
    margin-top:8px;
    font-size:16px;
}

.btn-primary-custom{
    background:#3b82f6;
    color:white;
    padding:13px 24px;
    border-radius:8px;
    text-decoration:none;
    font-weight:800;
    box-shadow:0 8px 18px rgba(59,130,246,.25);
}

.btn-primary-custom:hover{
    background:#2563eb;
    color:white;
}

.filter-card{
    background:white;
    border:1px solid #e2e8f0;
    border-radius:14px;
    padding:24px;
    margin-bottom:24px;
    box-shadow:0 1px 4px rgba(15,23,42,.05);
}

.filter-grid{
    display:grid;
    grid-template-columns:1fr 260px 170px;
    gap:22px;
    align-items:end;
}

.form-label-custom{
    display:block;
    font-weight:800;
    margin-bottom:8px;
}

.form-control-custom{
    width:100%;
    height:46px;
    border:1px solid #cbd5e1;
    border-radius:10px;
    padding:0 14px;
    font-size:15px;
}

.form-control-custom:focus{
    outline:none;
    border-color:#3b82f6;
    box-shadow:0 0 0 4px rgba(59,130,246,.12);
}

.btn-filter{
    height:46px;
    border:none;
    border-radius:10px;
    background:#3b82f6;
    color:white;
    font-weight:800;
}

.table-card{
    background:white;
    border:1px solid #e2e8f0;
    border-radius:14px;
    overflow:hidden;
    box-shadow:0 1px 4px rgba(15,23,42,.05);
}

.vehicle-table{
    width:100%;
    border-collapse:collapse;
}

.vehicle-table thead{
    background:#f8fafc;
}

.vehicle-table th{
    padding:17px 20px;
    border-bottom:1px solid #e2e8f0;
    text-transform:uppercase;
    letter-spacing:.06em;
    font-size:13px;
    font-weight:900;
    color:#334155;
    text-align:left;
}

.vehicle-table td{
    padding:22px 20px;
    border-bottom:1px solid #edf2f7;
    vertical-align:middle;
    font-size:15px;
}

.vehicle-table tr:hover td{
    background:#fbfdff;
}

.plate{
    font-weight:900;
    color:#1e293b;
    font-size:16px;
}

.driver-name{
    font-weight:800;
}

.driver-phone{
    color:#64748b;
    font-size:14px;
    margin-top:4px;
}

.badge-status{
    display:inline-block;
    padding:6px 14px;
    border-radius:999px;
    font-size:12px;
    font-weight:900;
    color:white;
    white-space:nowrap;
}

.bg-green{background:#10b981;}
.bg-blue{background:#3b82f6;}
.bg-yellow{background:#f59e0b;color:#111827;}
.bg-red{background:#ef4444;}
.bg-gray{background:#64748b;}

.actions{
    display:flex;
    gap:12px;
    align-items:center;
}

.action-link,
.action-btn{
    border:none;
    background:transparent;
    text-decoration:none;
    font-size:18px;
    cursor:pointer;
}

.view{color:#06b6d4;}
.edit{color:#f59e0b;}
.delete{color:#ef4444;}

.pagination-box{
    padding:18px 20px;
}

.alert-success-custom{
    background:#dcfce7;
    color:#166534;
    padding:14px 18px;
    border-radius:10px;
    font-weight:700;
    margin-bottom:20px;
}

.empty-row{
    text-align:center;
    color:#64748b;
    padding:35px;
}

@media(max-width:1100px){
    .vehicle-page{padding:28px 22px;}
    .vehicle-header{flex-direction:column;gap:18px;}
    .filter-grid{grid-template-columns:1fr;}
    .table-card{overflow-x:auto;}
    .vehicle-table{min-width:1000px;}
}
</style>

<div class="vehicle-page">

    <div class="vehicle-header">
        <div>
            <div class="vehicle-title-wrap">
                <div class="vehicle-icon">🚐</div>
                <h1 class="vehicle-title">Quản lý xe</h1>
            </div>
            <div class="vehicle-subtitle">
                Theo dõi phương tiện, tài xế và trạng thái vận hành
            </div>
        </div>

        <a href="{{ route('Admin.phuong-tiens.create') }}" class="btn-primary-custom">
            + Thêm xe
        </a>
    </div>

    <form method="GET" action="{{ route('Admin.phuong-tiens.index') }}" class="filter-card">
        <div class="filter-grid">
            <div>
                <label class="form-label-custom">Tìm kiếm</label>
                <input type="text"
                       name="keyword"
                       value="{{ request('keyword') }}"
                       class="form-control-custom"
                       placeholder="Biển số, hãng xe, tài xế hoặc số điện thoại">
            </div>

            <div>
                <label class="form-label-custom">Trạng thái</label>
                <select name="trang_thai" class="form-control-custom">
                    <option value="">Tất cả</option>
                    @foreach(\App\Models\PhuongTien::trangThaiList() as $key => $value)
                        <option value="{{ $key }}" @selected(request('trang_thai') == $key)>
                            {{ $value }}
                        </option>
                    @endforeach
                </select>
            </div>

            <button class="btn-filter">
                🔍 Lọc
            </button>
        </div>
    </form>

    @if(session('success'))
        <div class="alert-success-custom">
            {{ session('success') }}
        </div>
    @endif

    <div class="table-card">
        <table class="vehicle-table">
            <thead>
                <tr>
                    <th>Biển số</th>
                    <th>Loại xe</th>
                    <th>Hãng xe</th>
                    <th>Năm SX</th>
                    <th>Tài xế</th>
                    <th>Trạng thái</th>
                    <th>Thao tác</th>
                </tr>
            </thead>

            <tbody>
                @forelse($phuongTiens as $phuongTien)
                    <tr>
                        <td>
                            <div class="plate">{{ $phuongTien->bien_so_xe }}</div>
                            <div style="color:#64748b;font-size:14px;">{{ $phuongTien->mau_xe }}</div>
                        </td>

                        <td>{{ $phuongTien->loai_phuong_tien }}</td>
                        <td>{{ $phuongTien->hang_xe }}</td>
                        <td>{{ $phuongTien->nam_san_xuat }}</td>

                        <td>
                            <div class="driver-name">{{ $phuongTien->ten_tai_xe }}</div>
                            <div class="driver-phone">{{ $phuongTien->so_dien_thoai_tai_xe }}</div>
                        </td>

                        <td>
                            @switch($phuongTien->trang_thai)
                                @case(1)
                                    <span class="badge-status bg-green">Hoạt động</span>
                                    @break
                                @case(2)
                                    <span class="badge-status bg-blue">Đang chạy tour</span>
                                    @break
                                @case(3)
                                    <span class="badge-status bg-yellow">Bảo trì</span>
                                    @break
                                @case(4)
                                    <span class="badge-status bg-red">Đang sửa chữa</span>
                                    @break
                                @default
                                    <span class="badge-status bg-gray">Ngừng hoạt động</span>
                            @endswitch
                        </td>

                        <td>
                            <div class="actions">
                                <a href="{{ route('Admin.phuong-tiens.show', $phuongTien->id) }}"
                                   class="action-link view">👁</a>

                                <a href="{{ route('Admin.phuong-tiens.edit', $phuongTien->id) }}"
                                   class="action-link edit">✏️</a>

                                <form action="{{ route('Admin.phuong-tiens.destroy', $phuongTien->id) }}"
                                      method="POST"
                                      onsubmit="return confirm('Bạn có chắc muốn xóa xe này?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="action-btn delete">🗑</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="empty-row">
                            Chưa có xe nào.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="pagination-box">
            {{ $phuongTiens->links() }}
        </div>
    </div>
</div>
@endsection