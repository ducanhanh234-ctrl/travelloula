@extends('layouts.app')

@section('title', 'Danh sách yêu thích')

@section('content')

<style>
    .wishlist-page {
        background: linear-gradient(to right, #f5f7fa, #e8f1f8);
        min-height: 100vh;
    }

    .wishlist-card {
        border: none;
        border-radius: 20px;
        overflow: hidden;
        transition: all .3s ease;
    }

    .wishlist-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 15px 40px rgba(0, 0, 0, .15);
    }

    .tour-image {
        width: 100%;
        height: 240px;
        object-fit: cover;
    }

    .favorite-badge {
        position: absolute;
        top: 15px;
        left: 15px;
        background: #ff4d6d;
        color: white;
        padding: 8px 14px;
        border-radius: 50px;
        font-size: 13px;
    }

    .delete-btn {
        position: absolute;
        top: 15px;
        right: 15px;
        width: 42px;
        height: 42px;
        border-radius: 50%;
        border: none;
    }

    .price {
        color: #0d6efd;
        font-size: 28px;
        font-weight: 700;
    }

    .section-title {
        font-weight: 700;
        font-size: 2.2rem;
    }

    .tour-meta .badge {
        padding: 8px 12px;
        font-size: .85rem;
    }

    .explore-btn {
        border-radius: 50px;
        padding: 12px 24px;
    }

    .detail-btn {
        border-radius: 50px;
        padding: 12px;
    }

</style>

<div class="wishlist-page py-5">

    <div class="container">

        <!-- Tiêu đề -->
        <div class="d-flex justify-content-between align-items-center mb-5">

            <div>
                <h1 class="section-title mb-2">
                    ❤️ Danh sách yêu thích
                </h1>

                <p class="text-muted mb-0">
                    Những tour du lịch bạn đã lưu để xem lại sau.
                </p>
            </div>

            <a href="#" class="btn btn-primary explore-btn">
                <i class="fas fa-search me-2"></i>
                Khám phá thêm tour
            </a>

        </div>

        <!-- Danh sách tour -->
        <div class="row g-4">

            <!-- Tour 1 -->
            <div class="col-lg-6">

                <div class="card wishlist-card shadow-sm">

                    <div class="position-relative">

                        <img src="https://picsum.photos/700/400?1" class="tour-image" alt="">

                        <span class="favorite-badge">
                            <i class="fas fa-heart me-1"></i>
                            Yêu thích
                        </span>

                        <button class="btn btn-light delete-btn shadow-sm">
                            <i class="fas fa-trash text-danger"></i>
                        </button>

                    </div>

                    <div class="card-body">

                        <h4 class="fw-bold mb-3">
                            Tour Đông Bắc 5N4Đ:
                            Hà Nội - Hà Giang -
                            Cao Bằng - Ba Bể
                        </h4>

                        <div class="tour-meta mb-3">

                            <span class="badge bg-light text-dark border">
                                <i class="fas fa-map-marker-alt text-danger me-1"></i>
                                Đông Bắc
                            </span>

                            <span class="badge bg-light text-dark border">
                                <i class="fas fa-clock text-primary me-1"></i>
                                5 Ngày 4 Đêm
                            </span>

                        </div>

                        <div class="d-flex justify-content-between align-items-center mb-3">

                            <div>
                                <small class="text-muted">
                                    Giá từ
                                </small>

                                <div class="price">
                                    5.400.000đ
                                </div>
                            </div>

                            <div class="text-end">
                                <small class="text-muted">
                                    Thêm ngày
                                </small>

                                <div>
                                    02/12/2025
                                </div>
                            </div>

                        </div>

                        <a href="#" class="btn btn-primary w-100 detail-btn">
                            <i class="fas fa-eye me-2"></i>
                            Xem chi tiết tour
                        </a>

                    </div>

                </div>

            </div>

            <!-- Tour 2 -->
            <div class="col-lg-6">

                <div class="card wishlist-card shadow-sm">

                    <div class="position-relative">

                        <img src="https://picsum.photos/700/400?2" class="tour-image" alt="">

                        <span class="favorite-badge">
                            <i class="fas fa-heart me-1"></i>
                            Yêu thích
                        </span>

                        <button class="btn btn-light delete-btn shadow-sm">
                            <i class="fas fa-trash text-danger"></i>
                        </button>

                    </div>

                    <div class="card-body">

                        <h4 class="fw-bold mb-3">
                            Tour Yên Tử Trong Ngày:
                            Hà Nội - Yên Tử - Chùa Đồng
                        </h4>

                        <div class="tour-meta mb-3">

                            <span class="badge bg-light text-dark border">
                                <i class="fas fa-map-marker-alt text-danger me-1"></i>
                                Quảng Ninh
                            </span>

                            <span class="badge bg-light text-dark border">
                                <i class="fas fa-clock text-primary me-1"></i>
                                1 Ngày
                            </span>

                        </div>

                        <div class="d-flex justify-content-between align-items-center mb-3">

                            <div>
                                <small class="text-muted">
                                    Giá từ
                                </small>

                                <div class="price">
                                    960.000đ
                                </div>
                            </div>

                            <div class="text-end">
                                <small class="text-muted">
                                    Thêm ngày
                                </small>

                                <div>
                                    02/12/2025
                                </div>
                            </div>

                        </div>

                        <a href="#" class="btn btn-primary w-100 detail-btn">
                            <i class="fas fa-eye me-2"></i>
                            Xem chi tiết tour
                        </a>

                    </div>

                </div>

            </div>

            <!-- Tour 3 -->
            <div class="col-lg-6">

                <div class="card wishlist-card shadow-sm">

                    <div class="position-relative">

                        <img src="https://picsum.photos/700/400?3" class="tour-image" alt="">

                        <span class="favorite-badge">
                            <i class="fas fa-heart me-1"></i>
                            Yêu thích
                        </span>

                        <button class="btn btn-light delete-btn shadow-sm">
                            <i class="fas fa-trash text-danger"></i>
                        </button>

                    </div>

                    <div class="card-body">

                        <h4 class="fw-bold mb-3">
                            Tour Đà Nẵng 4N3Đ:
                            Đà Nẵng - Hội An - Bà Nà Hills
                        </h4>

                        <div class="tour-meta mb-3">

                            <span class="badge bg-light text-dark border">
                                <i class="fas fa-map-marker-alt text-danger me-1"></i>
                                Đà Nẵng
                            </span>

                            <span class="badge bg-light text-dark border">
                                <i class="fas fa-clock text-primary me-1"></i>
                                4 Ngày 3 Đêm
                            </span>

                        </div>

                        <div class="d-flex justify-content-between align-items-center mb-3">

                            <div>
                                <small class="text-muted">
                                    Giá từ
                                </small>

                                <div class="price">
                                    5.900.000đ
                                </div>
                            </div>

                            <div class="text-end">
                                <small class="text-muted">
                                    Thêm ngày
                                </small>

                                <div>
                                    02/12/2025
                                </div>
                            </div>

                        </div>

                        <a href="#" class="btn btn-primary w-100 detail-btn">
                            <i class="fas fa-eye me-2"></i>
                            Xem chi tiết tour
                        </a>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection
