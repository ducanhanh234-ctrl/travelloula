@extends('layouts.admin')

@section('content')
<div class="post-create-page">

    <div class="post-hero">
        <div>
            <a href="{{ route('Admin.bai_viets.index') }}" class="back-link">
                <i class="fa-solid fa-arrow-left"></i>
                Quay lại danh sách
            </a>

            <span class="hero-badge">
                <i class="fa-regular fa-newspaper"></i>
                Quản trị bài viết
            </span>

            <h2>Thêm bài viết mới</h2>

            <p>
                Tạo bài viết tin tức, kinh nghiệm du lịch hoặc nội dung giới thiệu
                để hiển thị ngoài trang Client.
            </p>
        </div>

        <div class="hero-icon">
            <i class="fa-solid fa-pen-nib"></i>
        </div>
    </div>

    <form action="{{ route('Admin.bai_viets.store') }}"
          method="POST"
          enctype="multipart/form-data"
          class="post-form">
        @csrf

        <div class="form-layout">

            <div class="main-card">
                <div class="card-heading">
                    <div>
                        <h3>Nội dung bài viết</h3>
                        <p>Nhập tiêu đề, mô tả ngắn và nội dung chi tiết</p>
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
                           value="{{ old('tieu_de') }}"
                           placeholder="Ví dụ: Kinh nghiệm chuẩn bị hành lý khi đi du lịch"
                           class="@error('tieu_de') is-invalid @enderror">

                    @error('tieu_de')
                        <div class="error-text">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label>Đường dẫn</label>

                    <input type="text"
                           name="duong_dan"
                           value="{{ old('duong_dan') }}"
                           placeholder="Để trống hệ thống sẽ tự tạo từ tiêu đề">

                    <small>
                        Ví dụ: kinh-nghiem-chuan-bi-hanh-ly-khi-di-du-lich
                    </small>

                    @error('duong_dan')
                        <div class="error-text">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label>Mô tả ngắn</label>

                    <textarea name="mo_ta_ngan"
                              rows="4"
                              placeholder="Nhập mô tả ngắn để hiển thị ở danh sách bài viết">{{ old('mo_ta_ngan') }}</textarea>

                    @error('mo_ta_ngan')
                        <div class="error-text">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label>Nội dung bài viết</label>

                    <textarea name="noi_dung"
                              rows="18"
                              placeholder="Nhập nội dung chi tiết bài viết">{{ old('noi_dung') }}</textarea>

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
                            <option value="1" @selected(old('trang_thai', 1) == 1)>Hiển thị</option>
                            <option value="0" @selected(old('trang_thai') == 0)>Ẩn</option>
                        </select>

                        @error('trang_thai')
                            <div class="error-text">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label>Tác giả</label>

                        <input type="text"
                               name="tac_gia"
                               value="{{ old('tac_gia', 'Admin') }}"
                               placeholder="Admin">
                    </div>
                </div>

                <div class="side-card">
                    <div class="card-heading small">
                        <div>
                            <h3>Ảnh đại diện</h3>
                            <p>Ảnh hiển thị ngoài trang bài viết</p>
                        </div>

                        <i class="fa-regular fa-image"></i>
                    </div>

                    <label class="upload-box">
                        <input type="file"
                               name="anh_dai_dien"
                               accept="image/*"
                               class="@error('anh_dai_dien') is-invalid @enderror">

                        <div class="upload-icon">
                            <i class="fa-solid fa-cloud-arrow-up"></i>
                        </div>

                        <strong>Chọn ảnh tải lên</strong>
                        <span>JPG, PNG, WEBP. Tối đa 4MB.</span>
                    </label>

                    @error('anh_dai_dien')
                        <div class="error-text">{{ $message }}</div>
                    @enderror
                </div>

                <div class="action-card">
                    <a href="{{ route('Admin.bai_viets.index') }}" class="btn-cancel">
                        <i class="fa-solid fa-xmark"></i>
                        Hủy
                    </a>

                    <button type="submit" class="btn-save">
                        <i class="fa-solid fa-floppy-disk"></i>
                        Lưu bài viết
                    </button>
                </div>

            </aside>

        </div>
    </form>
</div>

<style>
.post-create-page{
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

.form-layout{
    display:grid;
    grid-template-columns:minmax(0,1fr) 360px;
    gap:24px;
    align-items:start;
}

.main-card,
.side-card,
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

.upload-box{
    min-height:190px;
    padding:24px;
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
    width:58px;
    height:58px;
    border-radius:22px;
    display:flex;
    align-items:center;
    justify-content:center;
    background:#eff6ff;
    color:#2563eb;
    font-size:26px;
    margin-bottom:14px;
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
}

@media(max-width:720px){
    .post-create-page{
        padding:18px;
    }

    .post-hero{
        padding:24px;
        border-radius:24px;
    }

    .post-hero h2{
        font-size:28px;
    }

    .hero-icon{
        width:70px;
        height:70px;
        border-radius:24px;
        font-size:28px;
    }

    .main-card,
    .side-card{
        padding:20px;
        border-radius:22px;
    }
}
</style>
@endsection