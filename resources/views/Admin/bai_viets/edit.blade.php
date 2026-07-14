@extends('layouts.admin')

@section('content')
<div class="post-edit-page">

    <div class="post-hero">
        <div>
            <a href="{{ route('Admin.bai_viets.index') }}" class="back-link">
                <i class="fa-solid fa-arrow-left"></i>
                Quay lại danh sách
            </a>

            <span class="hero-badge">
                <i class="fa-solid fa-pen-to-square"></i>
                Chỉnh sửa bài viết
            </span>

            <h2>Sửa bài viết</h2>

            <p>
                Cập nhật tiêu đề, nội dung, ảnh đại diện và trạng thái hiển thị của bài viết.
            </p>
        </div>

        <div class="hero-actions">
            <a href="{{ route('Admin.bai_viets.show', $baiViet) }}" class="btn-preview">
                <i class="fa-regular fa-eye"></i>
                Xem bài viết
            </a>

            <div class="hero-icon">
                <i class="fa-solid fa-file-pen"></i>
            </div>
        </div>
    </div>

    <form action="{{ route('Admin.bai_viets.update', $baiViet) }}"
          method="POST"
          enctype="multipart/form-data"
          class="post-form">
        @csrf
        @method('PUT')

        <div class="form-layout">

            <div class="main-card">
                <div class="card-heading">
                    <div>
                        <h3>Nội dung bài viết</h3>
                        <p>Chỉnh sửa tiêu đề, mô tả ngắn và nội dung chi tiết</p>
                    </div>

                    <i class="fa-solid fa-file-lines"></i>
                </div>

                <div class="form-group">
                    <label>
                        Tiêu đề bài viết
                        <span>*</span>
                    </label>

                    <input type="text"
                           name="tieu_de"
                           value="{{ old('tieu_de', $baiViet->tieu_de) }}"
                           placeholder="Nhập tiêu đề bài viết"
                           class="@error('tieu_de') is-invalid @enderror">

                    @error('tieu_de')
                        <div class="error-text">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label>Đường dẫn</label>

                    <input type="text"
                           name="duong_dan"
                           value="{{ old('duong_dan', $baiViet->duong_dan) }}"
                           placeholder="Để trống hệ thống sẽ tự tạo từ tiêu đề">

                    <small>
                        Đường dẫn hiện tại: {{ $baiViet->duong_dan }}
                    </small>

                    @error('duong_dan')
                        <div class="error-text">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label>Mô tả ngắn</label>

                    <textarea name="mo_ta_ngan"
                              rows="4"
                              placeholder="Nhập mô tả ngắn của bài viết">{{ old('mo_ta_ngan', $baiViet->mo_ta_ngan) }}</textarea>

                    @error('mo_ta_ngan')
                        <div class="error-text">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label>Nội dung bài viết</label>

                    <textarea name="noi_dung"
                              rows="18"
                              placeholder="Nhập nội dung chi tiết bài viết">{{ old('noi_dung', $baiViet->noi_dung) }}</textarea>

                    @error('noi_dung')
                        <div class="error-text">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <aside class="side-card-wrap">

                <div class="side-card">
                    <div class="card-heading small">
                        <div>
                            <h3>Cài đặt hiển thị</h3>
                            <p>Trạng thái và tác giả</p>
                        </div>

                        <i class="fa-solid fa-sliders"></i>
                    </div>

                    <div class="form-group">
                        <label>
                            Trạng thái
                            <span>*</span>
                        </label>

                        <select name="trang_thai" class="@error('trang_thai') is-invalid @enderror">
                            <option value="1" @selected(old('trang_thai', $baiViet->trang_thai) == 1)>Hiển thị</option>
                            <option value="0" @selected(old('trang_thai', $baiViet->trang_thai) == 0)>Ẩn</option>
                        </select>

                        @error('trang_thai')
                            <div class="error-text">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label>Tác giả</label>

                        <input type="text"
                               name="tac_gia"
                               value="{{ old('tac_gia', $baiViet->tac_gia) }}"
                               placeholder="Admin">
                    </div>
                </div>

                <div class="side-card">
                    <div class="card-heading small">
                        <div>
                            <h3>Ảnh đại diện</h3>
                            <p>Ảnh hiển thị ở danh sách và chi tiết bài viết</p>
                        </div>

                        <i class="fa-regular fa-image"></i>
                    </div>

                    @if($baiViet->anh_dai_dien)
                        <div class="current-image">
                            <img src="{{ asset('storage/' . $baiViet->anh_dai_dien) }}"
                                 alt="{{ $baiViet->tieu_de }}">

                            <div class="image-label">
                                <i class="fa-solid fa-image"></i>
                                Ảnh hiện tại
                            </div>
                        </div>
                    @else
                        <div class="no-current-image">
                            <i class="fa-regular fa-image"></i>
                            <span>Chưa có ảnh đại diện</span>
                        </div>
                    @endif

                    <label class="upload-box">
                        <input type="file"
                               name="anh_dai_dien"
                               accept="image/*"
                               class="@error('anh_dai_dien') is-invalid @enderror">

                        <div class="upload-icon">
                            <i class="fa-solid fa-cloud-arrow-up"></i>
                        </div>

                        <strong>Chọn ảnh mới</strong>
                        <span>JPG, PNG, WEBP. Tối đa 4MB.</span>
                    </label>

                    @error('anh_dai_dien')
                        <div class="error-text">{{ $message }}</div>
                    @enderror
                </div>

                <div class="info-card">
                    <div class="info-item">
                        <span>Ngày tạo</span>
                        <strong>{{ $baiViet->created_at?->format('d/m/Y H:i') }}</strong>
                    </div>

                    <div class="info-item">
                        <span>Cập nhật gần nhất</span>
                        <strong>{{ $baiViet->updated_at?->format('d/m/Y H:i') }}</strong>
                    </div>

                    <div class="info-item">
                        <span>Lượt xem</span>
                        <strong>{{ number_format($baiViet->luot_xem ?? 0) }}</strong>
                    </div>
                </div>

                <div class="action-card">
                    <a href="{{ route('Admin.bai_viets.index') }}" class="btn-cancel">
                        <i class="fa-solid fa-xmark"></i>
                        Hủy
                    </a>

                    <button type="submit" class="btn-save">
                        <i class="fa-solid fa-floppy-disk"></i>
                        Cập nhật bài viết
                    </button>
                </div>

            </aside>

        </div>
    </form>
</div>

<style>
.post-edit-page{
    min-height:100vh;
    padding:28px;
    background:
        radial-gradient(circle at 0% 0%, rgba(37,99,235,.09), transparent 30%),
        radial-gradient(circle at 100% 0%, rgba(14,165,233,.10), transparent 30%),
        #f8fafc;
}

.post-hero{
    position:relative;
    overflow:hidden;
    display:flex;
    align-items:center;
    justify-content:space-between;
    gap:24px;
    padding:34px;
    margin-bottom:26px;
    border-radius:30px;
    background:
        linear-gradient(135deg, rgba(255,255,255,.98), rgba(255,255,255,.90)),
        linear-gradient(135deg,#eff6ff,#f8fafc);
    border:1px solid #e2e8f0;
    box-shadow:0 24px 70px rgba(15,23,42,.09);
}

.post-hero::after{
    content:"";
    position:absolute;
    right:-90px;
    top:-100px;
    width:300px;
    height:300px;
    border-radius:999px;
    background:linear-gradient(135deg, rgba(37,99,235,.14), rgba(14,165,233,.16));
}

.post-hero > *{
    position:relative;
    z-index:2;
}

.back-link{
    display:inline-flex;
    align-items:center;
    gap:8px;
    margin-bottom:14px;
    color:#64748b;
    text-decoration:none;
    font-weight:900;
    font-size:14px;
}

.back-link:hover{
    color:#2563eb;
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
    font-weight:1000;
    margin-bottom:14px;
}

.post-hero h2{
    margin:0;
    color:#0f172a;
    font-size:36px;
    line-height:1.15;
    font-weight:1000;
    letter-spacing:-.9px;
}

.post-hero p{
    max-width:720px;
    margin:10px 0 0;
    color:#64748b;
    font-size:15px;
    line-height:1.7;
    font-weight:650;
}

.hero-actions{
    display:flex;
    align-items:center;
    gap:14px;
}

.hero-icon{
    width:88px;
    height:88px;
    border-radius:30px;
    display:flex;
    align-items:center;
    justify-content:center;
    background:linear-gradient(135deg,#2563eb,#0ea5e9);
    color:#fff;
    font-size:36px;
    box-shadow:0 20px 40px rgba(37,99,235,.25);
}

.btn-preview{
    display:inline-flex;
    align-items:center;
    justify-content:center;
    gap:9px;
    min-height:46px;
    padding:0 18px;
    border-radius:15px;
    background:#0ea5e9;
    color:#fff;
    text-decoration:none;
    font-weight:1000;
    box-shadow:0 14px 28px rgba(14,165,233,.22);
    transition:.22s ease;
    white-space:nowrap;
}

.btn-preview:hover{
    color:#fff;
    background:#0284c7;
    transform:translateY(-1px);
}

.form-layout{
    display:grid;
    grid-template-columns:minmax(0,1fr) 360px;
    gap:24px;
    align-items:start;
}

.main-card,
.side-card,
.info-card,
.action-card{
    background:#fff;
    border:1px solid #e2e8f0;
    border-radius:26px;
    box-shadow:0 20px 55px rgba(15,23,42,.08);
}

.main-card{
    padding:28px;
}

.side-card-wrap{
    position:sticky;
    top:92px;
    display:flex;
    flex-direction:column;
    gap:18px;
}

.side-card{
    padding:22px;
}

.card-heading{
    display:flex;
    align-items:flex-start;
    justify-content:space-between;
    gap:16px;
    padding-bottom:20px;
    margin-bottom:22px;
    border-bottom:1px solid #e2e8f0;
}

.card-heading.small{
    padding-bottom:16px;
    margin-bottom:18px;
}

.card-heading h3{
    margin:0;
    color:#0f172a;
    font-size:22px;
    font-weight:1000;
}

.card-heading.small h3{
    font-size:18px;
}

.card-heading p{
    margin:5px 0 0;
    color:#64748b;
    font-size:14px;
    font-weight:650;
}

.card-heading > i{
    width:44px;
    height:44px;
    border-radius:16px;
    display:flex;
    align-items:center;
    justify-content:center;
    background:#eff6ff;
    color:#2563eb;
    font-size:18px;
}

.form-group{
    margin-bottom:20px;
}

.form-group:last-child{
    margin-bottom:0;
}

.form-group label{
    display:block;
    color:#334155;
    font-size:14px;
    font-weight:1000;
    margin-bottom:9px;
}

.form-group label span{
    color:#ef4444;
}

.form-group input,
.form-group select,
.form-group textarea{
    width:100%;
    border:1px solid #cbd5e1;
    border-radius:15px;
    padding:13px 15px;
    color:#0f172a;
    outline:none;
    font-size:15px;
    background:#f8fafc;
    font-weight:600;
    transition:.22s ease;
}

.form-group input,
.form-group select{
    height:48px;
}

.form-group textarea{
    resize:vertical;
    line-height:1.75;
}

.form-group input:focus,
.form-group select:focus,
.form-group textarea:focus{
    background:#fff;
    border-color:#2563eb;
    box-shadow:0 0 0 4px rgba(37,99,235,.10);
}

.form-group small{
    display:block;
    margin-top:7px;
    color:#94a3b8;
    font-size:13px;
    font-weight:700;
}

.is-invalid{
    border-color:#ef4444 !important;
    background:#fff7f7 !important;
}

.error-text{
    margin-top:7px;
    color:#ef4444;
    font-size:13px;
    font-weight:800;
}

.current-image{
    position:relative;
    overflow:hidden;
    border-radius:22px;
    margin-bottom:16px;
    border:1px solid #e2e8f0;
    box-shadow:0 14px 28px rgba(15,23,42,.09);
}

.current-image img{
    display:block;
    width:100%;
    height:190px;
    object-fit:cover;
}

.image-label{
    position:absolute;
    left:12px;
    bottom:12px;
    display:inline-flex;
    align-items:center;
    gap:7px;
    min-height:32px;
    padding:0 12px;
    border-radius:999px;
    background:rgba(15,23,42,.78);
    color:#fff;
    font-size:12px;
    font-weight:1000;
    backdrop-filter:blur(6px);
}

.no-current-image{
    min-height:150px;
    border-radius:22px;
    border:2px dashed #cbd5e1;
    background:#f8fafc;
    color:#94a3b8;
    display:flex;
    flex-direction:column;
    align-items:center;
    justify-content:center;
    gap:10px;
    margin-bottom:16px;
    font-weight:900;
}

.no-current-image i{
    font-size:34px;
}

.upload-box{
    min-height:160px;
    padding:22px;
    border-radius:22px;
    border:2px dashed #cbd5e1;
    background:#f8fafc;
    display:flex !important;
    flex-direction:column;
    align-items:center;
    justify-content:center;
    text-align:center;
    cursor:pointer;
    transition:.25s ease;
}

.upload-box:hover{
    border-color:#2563eb;
    background:#eff6ff;
}

.upload-box input{
    display:none;
}

.upload-icon{
    width:54px;
    height:54px;
    border-radius:20px;
    display:flex;
    align-items:center;
    justify-content:center;
    background:#eff6ff;
    color:#2563eb;
    font-size:24px;
    margin-bottom:12px;
}

.upload-box:hover .upload-icon{
    background:#2563eb;
    color:#fff;
}

.upload-box strong{
    color:#0f172a;
    font-size:16px;
    font-weight:1000;
    margin-bottom:6px;
}

.upload-box span{
    color:#64748b;
    font-size:13px;
    line-height:1.5;
    font-weight:700;
}

.info-card{
    padding:18px;
}

.info-item{
    display:flex;
    align-items:center;
    justify-content:space-between;
    gap:12px;
    padding:13px 0;
    border-bottom:1px solid #e2e8f0;
}

.info-item:first-child{
    padding-top:0;
}

.info-item:last-child{
    padding-bottom:0;
    border-bottom:0;
}

.info-item span{
    color:#64748b;
    font-size:13px;
    font-weight:850;
}

.info-item strong{
    color:#0f172a;
    font-size:13px;
    font-weight:1000;
    text-align:right;
}

.action-card{
    padding:18px;
    display:grid;
    grid-template-columns:1fr;
    gap:12px;
}

.btn-cancel,
.btn-save{
    min-height:46px;
    padding:0 18px;
    border-radius:15px;
    display:inline-flex;
    align-items:center;
    justify-content:center;
    gap:9px;
    text-decoration:none;
    border:none;
    font-size:14px;
    font-weight:1000;
    transition:.22s ease;
}

.btn-cancel{
    background:#f1f5f9;
    color:#334155;
    border:1px solid #e2e8f0;
}

.btn-cancel:hover{
    background:#e2e8f0;
    color:#0f172a;
}

.btn-save{
    background:linear-gradient(135deg,#2563eb,#0ea5e9);
    color:#fff;
    cursor:pointer;
    box-shadow:0 14px 28px rgba(37,99,235,.22);
}

.btn-save:hover{
    transform:translateY(-1px);
    box-shadow:0 18px 35px rgba(37,99,235,.30);
}

@media(max-width:1100px){
    .form-layout{
        grid-template-columns:1fr;
    }

    .side-card-wrap{
        position:relative;
        top:0;
    }

    .post-hero{
        align-items:flex-start;
        flex-direction:column;
    }

    .hero-actions{
        width:100%;
        justify-content:space-between;
    }
}

@media(max-width:720px){
    .post-edit-page{
        padding:18px;
    }

    .post-hero{
        padding:24px;
        border-radius:24px;
    }

    .post-hero h2{
        font-size:28px;
    }

    .hero-actions{
        flex-direction:column;
        align-items:flex-start;
    }

    .hero-icon{
        width:70px;
        height:70px;
        border-radius:24px;
        font-size:28px;
    }

    .main-card,
    .side-card,
    .info-card{
        padding:20px;
        border-radius:22px;
    }
}
</style>
@endsection