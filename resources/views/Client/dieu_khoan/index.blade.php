@extends('layouts.app')

@section('title', ($trangDieuKhoan->tieu_de ?? 'Điều khoản') . ' - Travelloula')

@section('content')

@php
    $tieuDe = $trangDieuKhoan->tieu_de ?? 'Điều khoản';
    $noiDungGoc = trim($trangDieuKhoan->noi_dung ?? '');

    $sections = [];

    if (!empty($noiDungGoc)) {
        $noiDung = str_replace(["\r\n", "\r"], "\n", $noiDungGoc);
        $lines = array_values(array_filter(array_map('trim', explode("\n", $noiDung)), function ($line) {
            return $line !== '';
        }));

        $mainTitleFromContent = '';

        if (!empty($lines) && !preg_match('/^\d+\.\s+/', $lines[0])) {
            $mainTitleFromContent = $lines[0];
            array_shift($lines);
        }

        $currentSection = null;

        foreach ($lines as $line) {
            if (preg_match('/^\d+\.\s+/', $line)) {
                if ($currentSection) {
                    $sections[] = $currentSection;
                }

                $title = trim($line);
                $slug = \Illuminate\Support\Str::slug($title);

                if (empty($slug)) {
                    $slug = 'muc-' . (count($sections) + 1);
                }

                $currentSection = [
                    'title' => $title,
                    'slug' => $slug,
                    'lines' => [],
                ];
            } else {
                if (!$currentSection) {
                    $currentSection = [
                        'title' => $mainTitleFromContent ?: $tieuDe,
                        'slug' => 'noi-dung',
                        'lines' => [],
                    ];
                }

                $currentSection['lines'][] = $line;
            }
        }

        if ($currentSection) {
            $sections[] = $currentSection;
        }

        if (!empty($mainTitleFromContent)) {
            $tieuDe = $mainTitleFromContent;
        }
    }
@endphp

<section class="terms-page">
    <div class="terms-container">

        <div class="terms-hero">
            <div class="terms-hero-content">
                <span>
                    <i class="fa-solid fa-file-contract"></i>
                    Chính sách dịch vụ
                </span>

                <h1>{{ $tieuDe }}</h1>

                <p>
                    Quy định về hoàn hủy, thay đổi tour, thanh toán và các trường hợp phát sinh
                    trong quá trình khách hàng đặt tour tại Travelloula.
                </p>

                <div class="terms-hero-info">
                    <div>
                        <strong>{{ count($sections) }}</strong>
                        <small>Nội dung chính sách</small>
                    </div>

                    <div>
                        <strong>24/7</strong>
                        <small>Hỗ trợ khách hàng</small>
                    </div>

                    <div>
                        <strong>Minh bạch</strong>
                        <small>Quy định rõ ràng</small>
                    </div>
                </div>
            </div>
        </div>

        <div class="terms-layout">

            <aside class="terms-sidebar">
                <div class="terms-sidebar-head">
                    <i class="fa-solid fa-list-ul"></i>
                    <h3>Mục lục</h3>
                </div>

                <div class="terms-sidebar-list">
                    @if(!empty($sections))
                        @foreach($sections as $index => $section)
                            <a href="#{{ $section['slug'] }}">
                                <span>{{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}</span>
                                <p>{{ $section['title'] }}</p>
                            </a>
                        @endforeach
                    @else
                        <a href="#noi-dung">
                            <span>01</span>
                            <p>Nội dung điều khoản</p>
                        </a>
                    @endif
                </div>

                <div class="terms-sidebar-line"></div>

                <a class="terms-link-home" href="{{ route('Client.trang_chu.index') }}">
                    <i class="fa-solid fa-house"></i>
                    Về trang chủ
                </a>

                @if(Route::has('Client.danh_sach_tour.index'))
                    <a class="terms-link-home" href="{{ route('Client.danh_sach_tour.index') }}">
                        <i class="fa-solid fa-suitcase-rolling"></i>
                        Xem danh sách tour
                    </a>
                @endif
            </aside>

            <div class="terms-content">

                @if(!empty($sections))
                    @foreach($sections as $index => $section)
                        <section id="{{ $section['slug'] }}" class="terms-card">
                            <div class="terms-card-number">
                                {{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}
                            </div>

                            <div class="terms-card-main">
                                <h2>{{ $section['title'] }}</h2>

                                <div class="terms-text">
                                    @forelse($section['lines'] as $line)
                                        @php
                                            $line = trim($line);
                                            $cleanLine = ltrim($line, "-•o \t");
                                        @endphp

                                        @if(\Illuminate\Support\Str::startsWith($line, ['-', '•', 'o']))
                                            <div class="terms-bullet">
                                                <span>
                                                    <i class="fa-solid fa-check"></i>
                                                </span>

                                                <p>{{ $cleanLine }}</p>
                                            </div>
                                        @elseif(preg_match('/^\d+\.\s*/', $line))
                                            <div class="terms-order">
                                                <span>
                                                    <i class="fa-solid fa-circle-dot"></i>
                                                </span>

                                                <p>{{ $line }}</p>
                                            </div>
                                        @else
                                            <p>{{ $line }}</p>
                                        @endif
                                    @empty
                                        <p>Nội dung mục này đang được cập nhật.</p>
                                    @endforelse
                                </div>
                            </div>
                        </section>
                    @endforeach
                @else
                    <section id="noi-dung" class="terms-card terms-card-empty">
                        <div class="terms-empty">
                            <i class="fa-solid fa-circle-info"></i>

                            <div>
                                <strong>Nội dung điều khoản đang trống.</strong>

                                <p>
                                    Vui lòng vào trang quản trị để cập nhật nội dung điều khoản,
                                    sau đó quay lại trang này để kiểm tra.
                                </p>

                                @auth
                                    @if(Route::has('Admin.trang_dieu_khoans.edit'))
                                        <a href="{{ route('Admin.trang_dieu_khoans.edit') }}">
                                            Đi tới trang quản trị điều khoản
                                        </a>
                                    @endif
                                @endauth
                            </div>
                        </div>
                    </section>
                @endif

            </div>

        </div>

    </div>
</section>

<style>
.terms-page{
    min-height:100vh;
    padding:88px 0 96px;
    background:
        radial-gradient(circle at 8% 6%, rgba(7,87,216,.15), transparent 30%),
        radial-gradient(circle at 92% 5%, rgba(255,214,41,.24), transparent 32%),
        linear-gradient(180deg,#f8fbff 0%,#eef6ff 55%,#f8fbff 100%);
}

.terms-container{
    width:min(1380px, calc(100% - 40px));
    margin:0 auto;
}

.terms-hero{
    position:relative;
    overflow:hidden;
    padding:60px;
    border-radius:38px;
    background:
        linear-gradient(135deg, rgba(255,255,255,.97), rgba(255,255,255,.9)),
        url('https://images.unsplash.com/photo-1500530855697-b586d89ba3ee?auto=format&fit=crop&w=1600&q=80') center/cover no-repeat;
    border:1px solid rgba(226,232,240,.95);
    box-shadow:0 30px 85px rgba(15,23,42,.13);
    margin-bottom:34px;
}

.terms-hero::before{
    content:"";
    position:absolute;
    width:360px;
    height:360px;
    border-radius:999px;
    right:-120px;
    bottom:-130px;
    background:linear-gradient(135deg, rgba(7,87,216,.16), rgba(56,189,248,.16));
}

.terms-hero::after{
    content:"";
    position:absolute;
    width:180px;
    height:180px;
    border-radius:999px;
    right:110px;
    top:-70px;
    background:rgba(255,214,41,.24);
}

.terms-hero-content{
    position:relative;
    z-index:2;
}

.terms-hero span{
    display:inline-flex;
    align-items:center;
    gap:10px;
    height:42px;
    padding:0 18px;
    border-radius:999px;
    background:rgba(7,87,216,.10);
    border:1px solid rgba(7,87,216,.22);
    color:#0757d8;
    font-size:14px;
    font-weight:1000;
    margin-bottom:18px;
}

.terms-hero h1{
    margin:0;
    max-width:960px;
    color:#0b1226;
    font-size:clamp(40px,4.4vw,64px);
    line-height:1.08;
    font-weight:1000;
    letter-spacing:-1.8px;
    text-transform:uppercase;
}

.terms-hero p{
    max-width:850px;
    margin:18px 0 0;
    color:#53627a;
    font-size:17px;
    line-height:1.75;
    font-weight:650;
}

.terms-hero-info{
    display:flex;
    flex-wrap:wrap;
    gap:14px;
    margin-top:28px;
}

.terms-hero-info div{
    min-width:160px;
    padding:16px 18px;
    border-radius:20px;
    background:rgba(255,255,255,.78);
    border:1px solid rgba(226,232,240,.95);
    box-shadow:0 12px 30px rgba(15,23,42,.07);
}

.terms-hero-info strong{
    display:block;
    color:#0757d8;
    font-size:22px;
    line-height:1.2;
    font-weight:1000;
}

.terms-hero-info small{
    display:block;
    margin-top:5px;
    color:#64748b;
    font-size:13px;
    font-weight:800;
}

.terms-layout{
    display:grid;
    grid-template-columns:340px 1fr;
    gap:30px;
    align-items:start;
}

.terms-sidebar{
    position:sticky;
    top:112px;
    padding:22px;
    border-radius:28px;
    background:rgba(255,255,255,.96);
    border:1px solid #e2e8f0;
    box-shadow:0 18px 45px rgba(15,23,42,.08);
    backdrop-filter:blur(10px);
}

.terms-sidebar-head{
    display:flex;
    align-items:center;
    gap:12px;
    margin-bottom:18px;
}

.terms-sidebar-head i{
    width:42px;
    height:42px;
    display:flex;
    align-items:center;
    justify-content:center;
    border-radius:15px;
    background:#eff6ff;
    color:#0757d8;
    font-size:18px;
}

.terms-sidebar-head h3{
    margin:0;
    color:#0f172a;
    font-size:22px;
    font-weight:1000;
}

.terms-sidebar-list{
    display:flex;
    flex-direction:column;
    gap:8px;
}

.terms-sidebar-list a{
    display:grid;
    grid-template-columns:38px 1fr;
    align-items:flex-start;
    gap:10px;
    padding:11px 12px;
    border-radius:15px;
    color:#334155;
    text-decoration:none;
    transition:.22s ease;
}

.terms-sidebar-list a span{
    width:34px;
    height:34px;
    border-radius:12px;
    display:flex;
    align-items:center;
    justify-content:center;
    background:#f1f5f9;
    color:#0757d8;
    font-size:12px;
    font-weight:1000;
}

.terms-sidebar-list a p{
    margin:0;
    color:#334155;
    font-size:14px;
    line-height:1.45;
    font-weight:900;
}

.terms-sidebar-list a:hover{
    background:#eff6ff;
    transform:translateX(4px);
}

.terms-sidebar-list a:hover span{
    background:#0757d8;
    color:#fff;
}

.terms-sidebar-list a:hover p{
    color:#0757d8;
}

.terms-sidebar-line{
    height:1px;
    background:#e2e8f0;
    margin:16px 0;
}

.terms-link-home{
    display:flex;
    align-items:center;
    gap:10px;
    min-height:44px;
    padding:0 12px;
    border-radius:14px;
    color:#334155;
    font-size:14px;
    font-weight:900;
    text-decoration:none;
    transition:.22s ease;
}

.terms-link-home i{
    width:18px;
    color:#0757d8;
}

.terms-link-home:hover{
    background:#eff6ff;
    color:#0757d8;
    transform:translateX(4px);
}

.terms-content{
    display:flex;
    flex-direction:column;
    gap:24px;
}

.terms-card{
    position:relative;
    display:grid;
    grid-template-columns:82px 1fr;
    gap:24px;
    padding:36px 40px;
    border-radius:30px;
    background:#fff;
    border:1px solid #e2e8f0;
    box-shadow:0 18px 45px rgba(15,23,42,.08);
    scroll-margin-top:120px;
    overflow:hidden;
}

.terms-card::before{
    content:"";
    position:absolute;
    left:0;
    top:0;
    width:7px;
    height:100%;
    background:linear-gradient(180deg,#0757d8,#38bdf8);
}

.terms-card-number{
    width:70px;
    height:70px;
    border-radius:24px;
    background:linear-gradient(135deg,#0757d8,#38bdf8);
    color:#fff;
    display:flex;
    align-items:center;
    justify-content:center;
    font-size:22px;
    font-weight:1000;
    box-shadow:0 14px 28px rgba(7,87,216,.24);
}

.terms-card-main h2{
    margin:0 0 18px;
    color:#0757d8;
    font-size:28px;
    line-height:1.32;
    font-weight:1000;
}

.terms-text{
    color:#334155;
    font-size:17px;
    line-height:1.9;
    font-weight:650;
}

.terms-text > p{
    margin:0 0 15px;
}

.terms-bullet{
    display:flex;
    align-items:flex-start;
    gap:12px;
    margin:0 0 12px;
    padding:14px 16px;
    border-radius:17px;
    background:#f8fafc;
    border:1px solid #e2e8f0;
}

.terms-bullet span{
    width:25px;
    height:25px;
    border-radius:999px;
    background:#dcfce7;
    color:#16a34a;
    display:flex;
    align-items:center;
    justify-content:center;
    margin-top:3px;
    flex-shrink:0;
    font-size:12px;
}

.terms-bullet p{
    margin:0;
    color:#334155;
    font-weight:800;
}

.terms-order{
    display:flex;
    align-items:flex-start;
    gap:12px;
    margin:0 0 12px;
    padding:15px 16px;
    border-radius:17px;
    background:#eff6ff;
    border:1px solid #bfdbfe;
}

.terms-order span{
    color:#0757d8;
    margin-top:3px;
}

.terms-order p{
    margin:0;
    color:#1e3a8a;
    font-weight:850;
}

.terms-card-empty{
    grid-template-columns:1fr;
}

.terms-empty{
    display:flex;
    gap:16px;
    padding:24px;
    border-radius:18px;
    background:#fff7ed;
    border:1px solid #fed7aa;
    color:#c2410c;
}

.terms-empty i{
    font-size:28px;
    margin-top:2px;
}

.terms-empty strong{
    display:block;
    color:#9a3412;
    font-size:18px;
    font-weight:1000;
    margin-bottom:6px;
}

.terms-empty p{
    margin:0 0 12px;
    color:#c2410c;
    font-size:15px;
    line-height:1.7;
    font-weight:700;
}

.terms-empty a{
    display:inline-flex;
    align-items:center;
    justify-content:center;
    min-height:40px;
    padding:0 16px;
    border-radius:999px;
    background:#ea580c;
    color:#fff;
    text-decoration:none;
    font-size:14px;
    font-weight:900;
}

.terms-empty a:hover{
    background:#c2410c;
}

@media(max-width:1100px){
    .terms-layout{
        grid-template-columns:1fr;
    }

    .terms-sidebar{
        position:relative;
        top:0;
    }

    .terms-sidebar-list{
        display:grid;
        grid-template-columns:repeat(2, minmax(0, 1fr));
    }
}

@media(max-width:720px){
    .terms-page{
        padding:64px 0 72px;
    }

    .terms-container{
        width:calc(100% - 24px);
    }

    .terms-hero{
        padding:34px 24px;
        border-radius:26px;
    }

    .terms-hero h1{
        letter-spacing:-1px;
    }

    .terms-hero-info{
        display:grid;
        grid-template-columns:1fr;
    }

    .terms-sidebar-list{
        grid-template-columns:1fr;
    }

    .terms-card{
        grid-template-columns:1fr;
        padding:28px 22px;
        border-radius:24px;
    }

    .terms-card-number{
        width:58px;
        height:58px;
        border-radius:18px;
        font-size:20px;
    }

    .terms-card-main h2{
        font-size:23px;
    }

    .terms-text{
        font-size:16px;
    }

    .terms-empty{
        flex-direction:column;
    }
}
</style>

@endsection