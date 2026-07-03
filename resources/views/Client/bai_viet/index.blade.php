@extends('layouts.app')

@section('content')
    <div class="container py-5">

        <div class="row">

            <!-- Sidebar trái -->
            <div class="col-lg-3">

                <!-- Danh mục -->
                <div class="card shadow-sm border-0 mb-4 p-2">
                    <div class="card-header bg-white border-0 pb-0">
                        <h5 class="fw-bold mb-0 text-dark">
                            Danh mục
                        </h5>
                    </div>

                    <div class="list-group list-group-flush mt-3">
                        <a href="#" class="list-group-item list-group-item-action active-category">
                            🌍 <span class="ms-2">Điểm đến</span>
                        </a>

                        <a href="#" class="list-group-item list-group-item-action">
                            🎒 <span class="ms-2">Kinh nghiệm</span>
                        </a>

                        <a href="#" class="list-group-item list-group-item-action">
                            🍜 <span class="ms-2">Ẩm thực</span>
                        </a>

                        <a href="#" class="list-group-item list-group-item-action">
                            📷 <span class="ms-2">Check-in</span>
                        </a>
                    </div>
                </div>

                <!-- Bài viết nổi bật -->
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-header bg-white border-0 pb-0">
                        <h5 class="fw-bold mb-0 text-dark">
                            Bài nổi bật
                        </h5>
                    </div>

                    <div class="card-body">
                        <div class="mb-3 highlight-item pb-2 border-bottom">
                            <a href="#" class="text-decoration-none text-dark fw-semibold small">
                                Top 10 địa điểm đẹp nhất Việt Nam
                            </a>
                        </div>

                        <div class="mb-3 highlight-item pb-2 border-bottom">
                            <a href="#" class="text-decoration-none text-dark fw-semibold small">
                                Checklist hành lý du lịch cần thiết
                            </a>
                        </div>

                        <div class="highlight-item">
                            <a href="#" class="text-decoration-none text-dark fw-semibold small">
                                Mẹo săn vé máy bay giá rẻ từ A-Z
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Form đăng ký nhận tin (Newsletter) -->
                <div class="card newsletter-card text-white border-0 p-4 mb-4 shadow-sm">
                    <h5 class="fw-bold mb-2">Đăng ký nhận tin ✉️</h5>
                    <p class="small text-white-50 mb-3">Nhận cẩm nang du lịch mới nhất hàng tuần hoàn toàn miễn phí.</p>
                    <div class="input-group">
                        <input type="email" class="form-control border-0 rounded-start-pill ps-3"
                            placeholder="Email của bạn...">
                        <button class="btn btn-dark rounded-end-pill px-3 fw-bold" type="button">Gửi</button>
                    </div>
                </div>

            </div>

            <!-- Khối nội dung chính bên phải -->
            <div class="col-lg-9">

                <div class="row g-4">

                    @for ($i = 1; $i <= 6; $i++)
                        <div class="col-md-6">

                            <!-- Đã thêm class post-card ở đây để kích hoạt CSS của bạn -->
                            <div class="card border-0 shadow-sm h-100 post-card">
                                <div class="overflow-hidden">
                                    <img src="https://picsum.photos/500/300?random={{ $i }}"
                                        class="card-img-top card-img-hover" alt="Travel Image">
                                </div>

                                <div class="card-body d-flex flex-column justify-content-between p-4">
                                    <div>
                                        <h5 class="fw-bold text-dark mb-2 line-clamp-2">
                                            Top địa điểm du lịch không thể bỏ lỡ 2026
                                        </h5>
                                        <p class="text-muted small mb-4 line-clamp-3">
                                            Khám phá những địa điểm tuyệt đẹp, những trải nghiệm văn hóa độc đáo đang chờ
                                            đón bước chân bạn trong năm nay...
                                        </p>
                                    </div>

                                    <a href="{{ route('Client.bai_viet.detail', $i) }}"
                                        class="btn btn-outline-primary rounded-pill fw-semibold w-100 py-2">
                                        Xem chi tiết
                                    </a>
                                </div>
                            </div>

                        </div>
                    @endfor

                </div>

                <!-- Thanh phân trang (Pagination) hiện đại -->
                <div class="d-flex justify-content-center mt-5">
                    <nav aria-label="Page navigation">
                        <ul class="pagination pagination-custom mb-0">
                            <li class="page-item disabled">
                                <a class="page-link" href="#" tabindex="-1" aria-disabled="true">
                                    <i class="bi bi-chevron-left"></i> Trước
                                </a>
                            </li>
                            <li class="page-item active"><a class="page-link" href="#">1</a></li>
                            <li class="page-item"><a class="page-link" href="#">2</a></li>
                            <li class="page-item"><a class="page-link" href="#">3</a></li>
                            <li class="page-item">
                                <a class="page-link" href="#">Sau <i class="bi bi-chevron-right"></i></a>
                            </li>
                        </ul>
                    </nav>
                </div>

            </div>

        </div>

    </div>

    <style>
        /* Cấu trúc nền tảng */
        body {
            background: #f4f6fa;
            font-family: 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
        }

        .card {
            border-radius: 20px;
        }

        /* Tối ưu Sidebar hiệu ứng mượt mà */
        .list-group-item {
            border: none !important;
            border-radius: 12px !important;
            margin-bottom: 6px;
            padding: 12px 16px;
            color: #495057;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .list-group-item-action:hover {
            background-color: #eef2ff !important;
            color: #0d6efd;
            transform: translateX(5px);
        }

        .active-category {
            background-color: #0d6efd !important;
            color: white !important;
        }

        .highlight-item a {
            transition: color 0.2s ease;
        }

        .highlight-item a:hover {
            color: #0d6efd !important;
        }

        /* Sửa và tối ưu Post-Card theo CSS gốc của bạn */
        .post-card {
            border-radius: 20px;
            overflow: hidden;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .post-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 15px 30px rgba(13, 110, 253, 0.08) !important;
        }

        .post-card img {
            height: 220px;
            object-fit: cover;
            transition: transform 0.5s ease;
        }

        .post-card:hover .card-img-hover {
            transform: scale(1.05);
            /* Hiệu ứng zoom nhẹ ảnh khi di chuột vào card */
        }

        /* Khối nhận bản tin lung linh hơn */
        .newsletter-card {
            border-radius: 20px;
            background: linear-gradient(135deg, #0d6efd 0%, #00c6ff 100%);
        }

        .newsletter-card .form-control:focus {
            box-shadow: none;
        }

        /* Giới hạn số dòng tiêu đề/mô tả tránh vỡ Layout */
        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .line-clamp-3 {
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        /* Custom Phân trang (Pagination) mềm mại */
        .pagination-custom .page-link {
            color: #495057;
            border: none;
            background: #fff;
            margin: 0 4px;
            border-radius: 10px !important;
            padding: 10px 18px;
            font-weight: 600;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.03);
            transition: all 0.2s ease;
        }

        .pagination-custom .page-link:hover {
            background: #eef2ff;
            color: #0d6efd;
        }

        .pagination-custom .page-item.active .page-link {
            background: #0d6efd;
            color: #fff;
            box-shadow: 0 4px 12px rgba(13, 110, 253, 0.25);
        }

        .pagination-custom .page-item.disabled .page-link {
            background: #e9ecef;
            color: #adb5bd;
            box-shadow: none;
        }
    </style>
@endsection
