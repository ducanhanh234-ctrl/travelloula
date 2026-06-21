@extends('layouts.admin')

@section('content')
<style>
.vehicle-page{
    background:#f8fafc;
    min-height:100vh;
    padding:20px 12px 40px;
    color:#0f172a;
    width:100%;
}

.vehicle-header{
    display:flex;
    justify-content:space-between;
    align-items:flex-start;
    margin-bottom:24px;
}

.vehicle-title-wrap{
    display:flex;
    align-items:center;
    gap:14px;
}

.vehicle-icon{
    width:48px;
    height:48px;
    border-radius:14px;
    background:#eff6ff;
    color:#2563eb;
    display:flex;
    align-items:center;
    justify-content:center;
    font-size:26px;
}

.vehicle-title{
    font-size:32px;
    font-weight:800;
    margin:0;
}

.vehicle-subtitle{
    color:#64748b;
    margin-top:6px;
    font-size:15px;
}

.btn-primary-custom{
    background:#3b82f6;
    color:#fff;
    padding:12px 22px;
    border-radius:10px;
    font-weight:700;
    text-decoration:none;
    transition:.2s;
    box-shadow:0 6px 14px rgba(59,130,246,.22);
}

.btn-primary-custom:hover{
    background:#2563eb;
    color:#fff;
    transform:translateY(-1px);
}

.filter-card{
    background:#fff;
    border:1px solid #e2e8f0;
    border-radius:14px;
    margin-bottom:26px;
    box-shadow:0 1px 4px rgba(15,23,42,.06);
    width:100%;
    overflow:hidden;
}

.filter-title{
    padding:18px 26px;
    border-bottom:1px solid #e5e7eb;
    font-size:18px;
    font-weight:800;
    display:flex;
    align-items:center;
    gap:10px;
}

.filter-body{
    padding:24px 26px 26px;
}

.filter-grid{
    display:grid;
    grid-template-columns:1.8fr 1.4fr 240px;
    gap:18px;
    align-items:center;
}

.form-control-custom{
    width:100%;
    height:50px;
    border:1px solid #d1d5db;
    border-radius:9px;
    padding:0 16px;
    font-size:15px;
    color:#0f172a;
    background:#fff;
}

.form-control-custom:focus{
    outline:none;
    border-color:#3b82f6;
    box-shadow:0 0 0 3px rgba(59,130,246,.15);
}

.btn-filter{
    height:50px;
    border:none;
    border-radius:9px;
    background:#3b82f6;
    color:#fff;
    font-weight:800;
    cursor:pointer;
    transition:.2s;
    display:flex;
    align-items:center;
    justify-content:center;
    gap:8px;
}

.btn-filter:hover{
    background:#2563eb;
}

.table-card{
    background:#fff;
    border:1px solid #e2e8f0;
    border-radius:16px;
    overflow:hidden;
    box-shadow:0 1px 3px rgba(15,23,42,.06);
    width:100%;
}

.table-header{
    padding:18px 24px;
    border-bottom:1px solid #e2e8f0;
    display:flex;
    justify-content:space-between;
    align-items:center;
}

.table-title{
    font-weight:800;
    font-size:18px;
}

.table-count{
    background:#eef2ff;
    color:#4f46e5;
    padding:6px 14px;
    border-radius:999px;
    font-size:13px;
    font-weight:800;
}

.vehicle-table{
    width:100%;
    border-collapse:collapse;
}

.vehicle-table thead{
    background:#f8fafc;
}

.vehicle-table th{
    padding:18px 20px;
    background:#f8fafc;
    border-bottom:1px solid #e2e8f0;
    text-transform:uppercase;
    letter-spacing:.05em;
    font-size:13px;
    font-weight:800;
    color:#475569;
    text-align:left;
}

.vehicle-table td{
    padding:20px;
    border-bottom:1px solid #edf2f7;
    vertical-align:middle;
    font-size:15px;
    color:#0f172a;
}

.vehicle-table tbody tr{
    transition:.2s;
}

.vehicle-table tbody tr:hover td{
    background:#f8fafc;
}

.plate{
    font-weight:900;
    color:#1e293b;
    font-size:16px;
}

.vehicle-color{
    color:#64748b;
    font-size:14px;
    margin-top:4px;
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
    padding:0;
}

.view{color:#06b6d4;}
.edit{color:#f59e0b;}
.delete{color:#ef4444;}

.pagination-box{
    padding:18px 24px;
    background:#fff;
}

.pagination{
    margin-bottom:0;
}

.pagination .page-link{
    border:none;
    border-radius:8px;
    margin:0 3px;
    color:#475569;
    font-weight:700;
}

.pagination .active .page-link{
    background:#3b82f6;
    color:#fff;
}

.pagination .page-link:hover{
    background:#e2e8f0;
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
    .vehicle-page{
        padding:20px 10px 32px;
    }

    .vehicle-header{
        flex-direction:column;
        gap:18px;
    }

    .filter-grid{
        grid-template-columns:1fr;
    }

    .table-card{
        overflow-x:auto;
    }

    .vehicle-table{
        min-width:1000px;
    }
}
</style>

<div class="vehicle-page">

    <div class="vehicle-header">
        <div>
            <div class="vehicle-title-wrap">
                <div class="vehicle-icon">🚐</div>

                <div>
                    <h1 class="vehicle-title">Quản lý xe</h1>
                    <div class="vehicle-subtitle">
                        Theo dõi phương tiện, tài xế và trạng thái vận hành
                    </div>
                </div>
            </div>
        </div>

        <a href="{{ route('Admin.phuong-tiens.create') }}" class="btn-primary-custom">
            + Thêm xe
        </a>
    </div>

    <form method="GET" action="{{ route('Admin.phuong-tiens.index') }}" class="filter-card">
        <div class="filter-title">
            <i class="fa fa-filter"></i>
            Bộ lọc tìm kiếm
        </div>

        <div class="filter-body">
            <div class="filter-grid">
                <input type="text"
                       name="keyword"
                       value="{{ request('keyword') }}"
                       class="form-control-custom"
                       placeholder="Tìm biển số, hãng xe, tài xế hoặc số điện thoại">

                <select name="trang_thai" class="form-control-custom">
                    <option value="">Tất cả trạng thái</option>

                    @foreach(\App\Models\PhuongTien::trangThaiList() as $key => $value)
                        <option value="{{ $key }}" @selected(request('trang_thai') == $key)>
                            {{ $value }}
                        </option>
                    @endforeach
                </select>

                <button type="submit" class="btn-filter">
                    <i class="fa fa-search"></i>
                    Tìm kiếm
                </button>
            </div>
        </div>
    </form>

    @if(session('success'))
        <div class="alert-success-custom">
            {{ session('success') }}
        </div>
    @endif

    <div class="table-card">
        <div class="table-header">
            <div class="table-title">
                🚐 Danh sách xe
            </div>

            <div class="table-count">
                {{ $phuongTiens->total() }} xe
            </div>
        </div>

        <table class="vehicle-table">
            <thead>
                <tr>
                    <th>Biển số</th>
                    <th>Loại xe</th>
                    <th>Hãng xe</th>
                    <th>Năm Sản Xuất</th>
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
                            <div class="vehicle-color">{{ $phuongTien->mau_xe }}</div>
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
                                   class="action-link view"
                                   title="Xem chi tiết">
                                    👁
                                </a>

                                <a href="{{ route('Admin.phuong-tiens.edit', $phuongTien->id) }}"
                                   class="action-link edit"
                                   title="Chỉnh sửa">
                                    ✏️
                                </a>

                                <form action="{{ route('Admin.phuong-tiens.destroy', $phuongTien->id) }}"
                                      method="POST"
                                      onsubmit="return confirm('Bạn có chắc muốn xóa xe này?')">
                                    @csrf
                                    @method('DELETE')

                                    <button class="action-btn delete" title="Xóa">
                                        🗑
                                    </button>
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