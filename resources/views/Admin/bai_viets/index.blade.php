@extends('layouts.admin')

@section('content')
<div class="admin-blog-page">

    <div class="blog-hero">
        <div>
            <span class="hero-badge">
                <i class="fa-regular fa-newspaper"></i>
                Quản trị nội dung
            </span>

            <h2>Quản lý bài viết</h2>

            <p>
                Quản lý danh sách bài viết, tin tức và kinh nghiệm du lịch hiển thị ngoài website.
            </p>
        </div>

        <a href="{{ route('Admin.bai_viets.create') }}" class="btn-add">
            <i class="fa-solid fa-plus"></i>
            Thêm bài viết
        </a>
    </div>

    @if(session('success'))
        <div class="alert-success">
            <div class="alert-icon">
                <i class="fa-solid fa-check"></i>
            </div>

            <div>
                <strong>Thành công</strong>
                <p>{{ session('success') }}</p>
            </div>
        </div>
    @endif

    <form method="GET" action="{{ route('Admin.bai_viets.index') }}" class="filter-card">
        <div class="filter-title">
            <div>
                <h3>Bộ lọc tìm kiếm</h3>
                <p>Tìm nhanh bài viết theo tiêu đề, mô tả hoặc tác giả</p>
            </div>

            <i class="fa-solid fa-filter"></i>
        </div>

        <div class="filter-grid">
            <div class="filter-group">
                <label>Từ khóa</label>
                <div class="input-icon">
                    <i class="fa-solid fa-magnifying-glass"></i>
                    <input type="text"
                           name="keyword"
                           value="{{ request('keyword') }}"
                           placeholder="Nhập tiêu đề, mô tả hoặc tác giả...">
                </div>
            </div>

            <div class="filter-group">
                <label>Trạng thái</label>
                <select name="trang_thai">
                    <option value="">Tất cả trạng thái</option>
                    <option value="1" @selected(request('trang_thai') === '1')>Hiển thị</option>
                    <option value="0" @selected(request('trang_thai') === '0')>Ẩn</option>
                </select>
            </div>

            <div class="filter-actions">
                <button type="submit" class="btn-filter">
                    <i class="fa-solid fa-magnifying-glass"></i>
                    Tìm kiếm
                </button>

                <a href="{{ route('Admin.bai_viets.index') }}" class="btn-reset">
                    <i class="fa-solid fa-rotate-right"></i>
                    Làm mới
                </a>
            </div>
        </div>
    </form>

    <div class="stats-row">
        <div class="stat-card">
            <div class="stat-icon blue">
                <i class="fa-regular fa-newspaper"></i>
            </div>

            <div>
                <span>Tổng bài viết</span>
                <strong>{{ $baiViets->total() }}</strong>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon green">
                <i class="fa-solid fa-eye"></i>
            </div>

            <div>
                <span>Đang hiển thị</span>
                <strong>{{ $baiViets->where('trang_thai', 1)->count() }}</strong>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon orange">
                <i class="fa-solid fa-eye-slash"></i>
            </div>

            <div>
                <span>Đang ẩn</span>
                <strong>{{ $baiViets->where('trang_thai', 0)->count() }}</strong>
            </div>
        </div>
    </div>

    <div class="table-card">
        <div class="table-card-header">
            <div>
                <h3>Danh sách bài viết</h3>
                <p>Hiển thị {{ $baiViets->count() }} bài viết trong trang hiện tại</p>
            </div>
        </div>

        <div class="table-responsive">
            <table class="blog-table">
                <thead>
                    <tr>
                        <th width="70">#</th>
                        <th width="120">Ảnh</th>
                        <th>Bài viết</th>
                        <th width="160">Tác giả</th>
                        <th width="120">Lượt xem</th>
                        <th width="130">Trạng thái</th>
                        <th width="240">Thao tác</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($baiViets as $index => $baiViet)
                        <tr>
                            <td>
                                <span class="row-index">
                                    {{ $baiViets->firstItem() + $index }}
                                </span>
                            </td>

                            <td>
                                @if($baiViet->anh_dai_dien)
                                    <img class="post-thumb"
                                         src="{{ asset('storage/' . $baiViet->anh_dai_dien) }}"
                                         alt="{{ $baiViet->tieu_de }}">
                                @else
                                    <div class="post-no-image">
                                        <i class="fa-regular fa-image"></i>
                                    </div>
                                @endif
                            </td>

                            <td>
                                <div class="post-info">
                                    <div class="post-title">
                                        {{ $baiViet->tieu_de }}
                                    </div>

                                    <div class="post-slug">
                                        <i class="fa-solid fa-link"></i>
                                        {{ $baiViet->duong_dan }}
                                    </div>

                                    @if($baiViet->mo_ta_ngan)
                                        <div class="post-desc">
                                            {{ Str::limit($baiViet->mo_ta_ngan, 120) }}
                                        </div>
                                    @endif

                                    <div class="post-date">
                                        <i class="fa-regular fa-calendar"></i>
                                        {{ $baiViet->created_at?->format('d/m/Y H:i') }}
                                    </div>
                                </div>
                            </td>

                            <td>
                                <div class="author-box">
                                    <div class="author-avatar">
                                        {{ strtoupper(substr($baiViet->tac_gia ?? 'A', 0, 1)) }}
                                    </div>

                                    <span>{{ $baiViet->tac_gia ?? 'Admin' }}</span>
                                </div>
                            </td>

                            <td>
                                <span class="view-count">
                                    <i class="fa-regular fa-eye"></i>
                                    {{ number_format($baiViet->luot_xem) }}
                                </span>
                            </td>

                            <td>
                                @if($baiViet->trang_thai == 1)
                                    <span class="status active">
                                        <i class="fa-solid fa-circle-check"></i>
                                        Hiển thị
                                    </span>
                                @else
                                    <span class="status inactive">
                                        <i class="fa-solid fa-circle-minus"></i>
                                        Ẩn
                                    </span>
                                @endif
                            </td>

                            <td>
                                <div class="action-group">
                                    <a class="btn-action view" href="{{ route('Admin.bai_viets.show', $baiViet) }}">
                                        <i class="fa-regular fa-eye"></i>
                                        Xem
                                    </a>

                                    <a class="btn-action edit" href="{{ route('Admin.bai_viets.edit', $baiViet) }}">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                        Sửa
                                    </a>

                                    <form action="{{ route('Admin.bai_viets.destroy', $baiViet) }}"
                                          method="POST"
                                          onsubmit="return confirm('Bạn có chắc muốn xóa bài viết này không?')">
                                        @csrf
                                        @method('DELETE')

                                        <button class="btn-action delete" type="submit">
                                            <i class="fa-regular fa-trash-can"></i>
                                            Xóa
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7">
                                <div class="empty-box">
                                    <div class="empty-icon">
                                        <i class="fa-regular fa-newspaper"></i>
                                    </div>

                                    <strong>Chưa có bài viết nào</strong>

                                    <p>
                                        Hãy thêm bài viết đầu tiên để hiển thị tin tức, kinh nghiệm du lịch
                                        ngoài trang Client.
                                    </p>

                                    <a href="{{ route('Admin.bai_viets.create') }}">
                                        <i class="fa-solid fa-plus"></i>
                                        Thêm bài viết
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($baiViets->hasPages())
            <div class="pagination-box">
                {{ $baiViets->links() }}
            </div>
        @endif
    </div>
</div>

<style>
.admin-blog-page{
    min-height:100vh;
    padding:28px;
    background:
        radial-gradient(circle at 0% 0%, rgba(37,99,235,.09), transparent 30%),
        radial-gradient(circle at 100% 0%, rgba(14,165,233,.10), transparent 28%),
        #f8fafc;
}

.blog-hero{
    position:relative;
    overflow:hidden;
    display:flex;
    align-items:flex-end;
    justify-content:space-between;
    gap:24px;
    padding:34px;
    margin-bottom:24px;
    border-radius:28px;
    background:
        linear-gradient(135deg, rgba(255,255,255,.96), rgba(255,255,255,.88)),
        linear-gradient(135deg, #eff6ff, #f8fafc);
    border:1px solid rgba(226,232,240,.95);
    box-shadow:0 24px 70px rgba(15,23,42,.09);
}

.blog-hero::after{
    content:"";
    position:absolute;
    right:-90px;
    top:-110px;
    width:280px;
    height:280px;
    border-radius:999px;
    background:linear-gradient(135deg, rgba(37,99,235,.14), rgba(56,189,248,.16));
}

.blog-hero > *{
    position:relative;
    z-index:2;
}

.hero-badge{
    display:inline-flex;
    align-items:center;
    gap:9px;
    min-height:36px;
    padding:0 15px;
    border-radius:999px;
    background:#eff6ff;
    color:#2563eb;
    border:1px solid #bfdbfe;
    font-size:13px;
    font-weight:900;
    margin-bottom:14px;
}

.blog-hero h2{
    margin:0;
    color:#0f172a;
    font-size:34px;
    line-height:1.15;
    font-weight:1000;
    letter-spacing:-.8px;
}

.blog-hero p{
    margin:10px 0 0;
    max-width:720px;
    color:#64748b;
    font-size:15px;
    line-height:1.7;
    font-weight:600;
}

.btn-add{
    display:inline-flex;
    align-items:center;
    justify-content:center;
    gap:9px;
    min-height:46px;
    padding:0 20px;
    border-radius:15px;
    background:linear-gradient(135deg,#2563eb,#0ea5e9);
    color:#fff;
    text-decoration:none;
    font-weight:900;
    box-shadow:0 14px 28px rgba(37,99,235,.22);
    transition:.25s ease;
    white-space:nowrap;
}

.btn-add:hover{
    color:#fff;
    transform:translateY(-2px);
    box-shadow:0 18px 35px rgba(37,99,235,.30);
}

.alert-success{
    display:flex;
    align-items:flex-start;
    gap:14px;
    padding:16px 18px;
    border-radius:18px;
    background:#ecfdf5;
    border:1px solid #bbf7d0;
    color:#166534;
    box-shadow:0 12px 30px rgba(22,101,52,.08);
    margin-bottom:20px;
}

.alert-icon{
    width:34px;
    height:34px;
    border-radius:12px;
    display:flex;
    align-items:center;
    justify-content:center;
    background:#22c55e;
    color:#fff;
    flex-shrink:0;
}

.alert-success strong{
    display:block;
    font-size:15px;
    font-weight:1000;
    margin-bottom:2px;
}

.alert-success p{
    margin:0;
    font-weight:700;
}

.filter-card{
    padding:22px;
    margin-bottom:22px;
    border-radius:24px;
    background:#fff;
    border:1px solid #e2e8f0;
    box-shadow:0 18px 45px rgba(15,23,42,.07);
}

.filter-title{
    display:flex;
    align-items:flex-start;
    justify-content:space-between;
    gap:16px;
    margin-bottom:18px;
}

.filter-title h3{
    margin:0;
    color:#0f172a;
    font-size:20px;
    font-weight:1000;
}

.filter-title p{
    margin:4px 0 0;
    color:#64748b;
    font-size:14px;
    font-weight:600;
}

.filter-title > i{
    width:42px;
    height:42px;
    border-radius:15px;
    display:flex;
    align-items:center;
    justify-content:center;
    background:#eff6ff;
    color:#2563eb;
}

.filter-grid{
    display:grid;
    grid-template-columns:1fr 240px 270px;
    gap:16px;
    align-items:end;
}

.filter-group label{
    display:block;
    margin-bottom:8px;
    color:#334155;
    font-size:14px;
    font-weight:900;
}

.input-icon{
    position:relative;
}

.input-icon i{
    position:absolute;
    left:14px;
    top:50%;
    transform:translateY(-50%);
    color:#94a3b8;
    font-size:14px;
}

.filter-group input,
.filter-group select{
    width:100%;
    height:46px;
    border:1px solid #cbd5e1;
    border-radius:14px;
    background:#f8fafc;
    color:#0f172a;
    outline:none;
    font-size:14px;
    font-weight:600;
    transition:.22s ease;
}

.filter-group input{
    padding:0 14px 0 40px;
}

.filter-group select{
    padding:0 14px;
}

.filter-group input:focus,
.filter-group select:focus{
    background:#fff;
    border-color:#2563eb;
    box-shadow:0 0 0 4px rgba(37,99,235,.10);
}

.filter-actions{
    display:flex;
    gap:10px;
}

.btn-filter,
.btn-reset{
    height:46px;
    padding:0 16px;
    border-radius:14px;
    border:none;
    display:inline-flex;
    align-items:center;
    justify-content:center;
    gap:8px;
    text-decoration:none;
    font-size:14px;
    font-weight:900;
    transition:.22s ease;
}

.btn-filter{
    background:#2563eb;
    color:#fff;
    box-shadow:0 10px 20px rgba(37,99,235,.18);
}

.btn-filter:hover{
    background:#1d4ed8;
    transform:translateY(-1px);
}

.btn-reset{
    background:#f1f5f9;
    color:#334155;
    border:1px solid #e2e8f0;
}

.btn-reset:hover{
    background:#e2e8f0;
    color:#0f172a;
}

.stats-row{
    display:grid;
    grid-template-columns:repeat(3, minmax(0, 1fr));
    gap:16px;
    margin-bottom:22px;
}

.stat-card{
    display:flex;
    align-items:center;
    gap:14px;
    padding:18px;
    border-radius:22px;
    background:#fff;
    border:1px solid #e2e8f0;
    box-shadow:0 14px 35px rgba(15,23,42,.06);
}

.stat-icon{
    width:48px;
    height:48px;
    border-radius:17px;
    display:flex;
    align-items:center;
    justify-content:center;
    font-size:20px;
}

.stat-icon.blue{
    background:#eff6ff;
    color:#2563eb;
}

.stat-icon.green{
    background:#dcfce7;
    color:#16a34a;
}

.stat-icon.orange{
    background:#fff7ed;
    color:#ea580c;
}

.stat-card span{
    display:block;
    color:#64748b;
    font-size:13px;
    font-weight:800;
    margin-bottom:4px;
}

.stat-card strong{
    color:#0f172a;
    font-size:24px;
    line-height:1;
    font-weight:1000;
}

.table-card{
    overflow:hidden;
    border-radius:26px;
    background:#fff;
    border:1px solid #e2e8f0;
    box-shadow:0 22px 60px rgba(15,23,42,.08);
}

.table-card-header{
    display:flex;
    align-items:center;
    justify-content:space-between;
    padding:22px 24px;
    border-bottom:1px solid #e2e8f0;
    background:linear-gradient(180deg,#fff,#f8fafc);
}

.table-card-header h3{
    margin:0;
    color:#0f172a;
    font-size:21px;
    font-weight:1000;
}

.table-card-header p{
    margin:5px 0 0;
    color:#64748b;
    font-size:14px;
    font-weight:650;
}

.table-responsive{
    width:100%;
    overflow-x:auto;
}

.blog-table{
    width:100%;
    border-collapse:separate;
    border-spacing:0;
}

.blog-table thead{
    background:#f8fafc;
}

.blog-table th{
    padding:16px 18px;
    color:#475569;
    font-size:12px;
    text-align:left;
    white-space:nowrap;
    text-transform:uppercase;
    letter-spacing:.05em;
    font-weight:1000;
    border-bottom:1px solid #e2e8f0;
}

.blog-table td{
    padding:18px;
    color:#334155;
    vertical-align:middle;
    border-bottom:1px solid #eef2f7;
}

.blog-table tbody tr{
    transition:.2s ease;
}

.blog-table tbody tr:hover{
    background:#f8fbff;
}

.row-index{
    width:36px;
    height:36px;
    display:inline-flex;
    align-items:center;
    justify-content:center;
    border-radius:13px;
    background:#f1f5f9;
    color:#475569;
    font-size:13px;
    font-weight:1000;
}

.post-thumb{
    width:92px;
    height:68px;
    border-radius:16px;
    object-fit:cover;
    border:1px solid #e2e8f0;
    box-shadow:0 8px 18px rgba(15,23,42,.08);
}

.post-no-image{
    width:92px;
    height:68px;
    border-radius:16px;
    background:linear-gradient(135deg,#eff6ff,#f8fafc);
    color:#94a3b8;
    display:flex;
    align-items:center;
    justify-content:center;
    font-size:26px;
    border:1px dashed #cbd5e1;
}

.post-info{
    max-width:620px;
}

.post-title{
    color:#0f172a;
    font-size:16px;
    line-height:1.45;
    font-weight:1000;
    margin-bottom:6px;
}

.post-slug{
    display:inline-flex;
    align-items:center;
    gap:6px;
    max-width:100%;
    color:#2563eb;
    font-size:13px;
    line-height:1.4;
    font-weight:800;
    margin-bottom:7px;
    word-break:break-all;
}

.post-desc{
    margin-top:2px;
    color:#64748b;
    font-size:13px;
    line-height:1.6;
    font-weight:600;
}

.post-date{
    display:inline-flex;
    align-items:center;
    gap:6px;
    margin-top:8px;
    color:#94a3b8;
    font-size:12px;
    font-weight:800;
}

.author-box{
    display:flex;
    align-items:center;
    gap:10px;
}

.author-avatar{
    width:34px;
    height:34px;
    border-radius:50%;
    background:linear-gradient(135deg,#2563eb,#0ea5e9);
    color:#fff;
    display:flex;
    align-items:center;
    justify-content:center;
    font-size:13px;
    font-weight:1000;
}

.author-box span{
    color:#334155;
    font-weight:850;
}

.view-count{
    display:inline-flex;
    align-items:center;
    gap:7px;
    min-height:34px;
    padding:0 12px;
    border-radius:999px;
    background:#f8fafc;
    border:1px solid #e2e8f0;
    color:#475569;
    font-size:13px;
    font-weight:900;
}

.view-count i{
    color:#2563eb;
}

.status{
    display:inline-flex;
    align-items:center;
    justify-content:center;
    gap:7px;
    min-height:32px;
    padding:0 12px;
    border-radius:999px;
    font-size:12px;
    font-weight:1000;
    white-space:nowrap;
}

.status.active{
    background:#dcfce7;
    color:#166534;
    border:1px solid #bbf7d0;
}

.status.inactive{
    background:#f1f5f9;
    color:#475569;
    border:1px solid #e2e8f0;
}

.action-group{
    display:flex;
    align-items:center;
    gap:7px;
    flex-wrap:wrap;
}

.action-group form{
    margin:0;
}

.btn-action{
    min-height:35px;
    padding:0 11px;
    border-radius:11px;
    border:none;
    display:inline-flex;
    align-items:center;
    justify-content:center;
    gap:6px;
    color:#fff;
    text-decoration:none;
    font-size:12px;
    line-height:1;
    font-weight:1000;
    cursor:pointer;
    transition:.22s ease;
}

.btn-action:hover{
    color:#fff;
    transform:translateY(-1px);
}

.btn-action.view{
    background:#0ea5e9;
}

.btn-action.edit{
    background:#f59e0b;
}

.btn-action.delete{
    background:#ef4444;
}

.empty-box{
    padding:52px 20px;
    text-align:center;
    color:#64748b;
}

.empty-icon{
    width:76px;
    height:76px;
    margin:0 auto 16px;
    border-radius:28px;
    background:#eff6ff;
    color:#2563eb;
    display:flex;
    align-items:center;
    justify-content:center;
    font-size:34px;
}

.empty-box strong{
    display:block;
    color:#0f172a;
    font-size:22px;
    font-weight:1000;
    margin-bottom:8px;
}

.empty-box p{
    max-width:520px;
    margin:0 auto 18px;
    color:#64748b;
    line-height:1.7;
    font-weight:600;
}

.empty-box a{
    display:inline-flex;
    align-items:center;
    justify-content:center;
    gap:8px;
    min-height:42px;
    padding:0 18px;
    border-radius:999px;
    background:#2563eb;
    color:#fff;
    text-decoration:none;
    font-weight:900;
}

.pagination-box{
    padding:18px 22px;
    border-top:1px solid #e2e8f0;
    background:#f8fafc;
}

@media(max-width:1100px){
    .filter-grid{
        grid-template-columns:1fr;
    }

    .filter-actions{
        justify-content:flex-start;
    }

    .stats-row{
        grid-template-columns:1fr;
    }

    .blog-hero{
        align-items:flex-start;
        flex-direction:column;
    }
}

@media(max-width:720px){
    .admin-blog-page{
        padding:18px;
    }

    .blog-hero{
        padding:24px;
        border-radius:22px;
    }

    .blog-hero h2{
        font-size:28px;
    }

    .filter-card{
        padding:18px;
        border-radius:20px;
    }

    .filter-actions{
        flex-direction:column;
    }

    .btn-filter,
    .btn-reset{
        width:100%;
    }

    .table-card{
        border-radius:20px;
    }

    .table-card-header{
        padding:18px;
    }
}
</style>
@endsection