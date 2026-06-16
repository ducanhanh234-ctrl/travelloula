@extends('layouts.app')

@section('content')

<div class="container py-5">

    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="#" class="text-decoration-none text-muted">Trang chủ</a></li>
            <li class="breadcrumb-item"><a href="#" class="text-decoration-none text-muted">Điểm đến</a></li>
            <li class="breadcrumb-item active fw-bold text-primary" aria-current="page">Top 10 địa điểm du lịch...</li>
        </ol>
    </nav>

    <div class="row g-4">

        <div class="col-lg-8">

            <div class="card border-0 shadow-sm p-lg-5 p-4 mb-5 article-card">
                
                <div class="mb-4">
                    <span class="badge bg-primary-subtle text-primary rounded-pill px-3 py-2 mb-3 fw-semibold">
                        🌍 Điểm đến
                    </span>
                    <h1 class="fw-bold text-dark mb-3" style="line-height: 1.4;">
                        Top 10 địa điểm du lịch tuyệt đẹp không thể bỏ lỡ trong năm 2026
                    </h1>
                    
                    <div class="d-flex align-items-center text-muted small">
                        <div class="d-flex align-items-center me-4">
                            <img src="https://i.pravatar.cc/150?img=11" alt="Author" class="rounded-circle me-2" width="30" height="30">
                            <span class="fw-semibold text-dark">Nguyễn Văn A</span>
                        </div>
                        <div class="me-4"><i class="bi bi-calendar3 me-1"></i> 15/06/2026</div>
                        <div><i class="bi bi-eye me-1"></i> 1,245 lượt xem</div>
                    </div>
                </div>

                <div class="mb-5 overflow-hidden rounded-4">
                    <img src="https://picsum.photos/1000/500?random=10" class="img-fluid w-100 object-fit-cover" alt="Cover Image" style="max-height: 450px;">
                </div>

                <div class="article-content text-secondary">
                    <p class="lead fw-normal text-dark mb-4">
                        Năm 2026 hứa hẹn sẽ là một năm bùng nổ của những chuyến đi khám phá. Nếu bạn đang tìm kiếm những vùng đất mới để "chữa lành" hay đơn giản là lưu lại những khung hình tuyệt đẹp, thì danh sách dưới đây chính là cẩm nang dành cho bạn.
                    </p>

                    <h3 class="fw-bold text-dark mt-5 mb-3">1. Vịnh Hạ Long - Bản giao hưởng của đá và nước</h3>
                    <p>
                        Không có gì ngạc nhiên khi Vịnh Hạ Long tiếp tục góp mặt trong danh sách này. Với hàng ngàn hòn đảo đá vôi kỳ vĩ vươn lên từ mặt nước xanh ngọc lục bảo, nơi đây mang đến một vẻ đẹp huyền bí mà không máy ảnh nào lột tả hết được.
                    </p>
                    
                    <figure class="figure w-100 my-4">
                        <img src="https://picsum.photos/800/400?random=11" class="figure-img img-fluid rounded-4 w-100" alt="...">
                        <figcaption class="figure-caption text-center mt-2">Vẻ đẹp hùng vĩ nhìn từ trên cao (Ảnh minh họa)</figcaption>
                    </figure>

                    <blockquote class="blockquote custom-blockquote p-4 my-5 bg-light rounded-4">
                        <p class="mb-0 fst-italic text-dark">"Đích đến của chúng ta không phải là một vùng đất, mà là một cách nhìn mới."</p>
                        <footer class="blockquote-footer mt-2">Henry Miller</footer>
                    </blockquote>

                    <h3 class="fw-bold text-dark mt-5 mb-3">2. Đà Lạt - Mùa sương mây giăng lối</h3>
                    <p>
                        Vẫn là cái se lạnh đặc trưng, nhưng Đà Lạt năm nay có thêm nhiều khu cắm trại glamping ẩn mình giữa rừng thông. Cảm giác thức dậy giữa tiếng chim hót và ngắm sương mù lấp ló qua tán lá sẽ làm dịu đi mọi mệt mỏi.
                    </p>
                </div>

                <hr class="my-5">

                <div class="d-flex flex-wrap align-items-center justify-content-between">
                    <div class="d-flex flex-wrap gap-2 mb-3 mb-md-0">
                        <span class="fw-bold text-dark me-2 d-flex align-items-center">Tags:</span>
                        <a href="#" class="tag-pill text-decoration-none">Du lịch</a>
                        <a href="#" class="tag-pill text-decoration-none">Việt Nam</a>
                        <a href="#" class="tag-pill text-decoration-none">Khám phá</a>
                    </div>
                    
                    <div class="d-flex align-items-center gap-2">
                        <span class="fw-bold text-dark me-2">Chia sẻ:</span>
                        <a href="#" class="btn btn-light btn-sm rounded-circle shadow-sm" style="width: 35px; height: 35px;"><i class="bi bi-facebook text-primary"></i></a>
                        <a href="#" class="btn btn-light btn-sm rounded-circle shadow-sm" style="width: 35px; height: 35px;"><i class="bi bi-twitter text-info"></i></a>
                        <a href="#" class="btn btn-light btn-sm rounded-circle shadow-sm" style="width: 35px; height: 35px;"><i class="bi bi-link-45deg text-dark"></i></a>
                    </div>
                </div>

            </div> <h4 class="fw-bold mb-4">Bài viết liên quan</h4>
            <div class="row g-4 mb-5">
                @for($i=1;$i<=2;$i++)
                <div class="col-md-6">
                    <div class="card border-0 shadow-sm h-100 post-card">
                        <div class="overflow-hidden">
                            <img src="https://picsum.photos/400/250?random={{$i+20}}" class="card-img-top card-img-hover" alt="Travel">
                        </div>
                        <div class="card-body p-3">
                            <h6 class="fw-bold text-dark mb-2 line-clamp-2">Lịch trình khám phá Tây Bắc 4 ngày 3 đêm tự túc</h6>
                            <a href="#" class="text-primary text-decoration-none small fw-semibold">Đọc tiếp <i class="bi bi-arrow-right"></i></a>
                        </div>
                    </div>
                </div>
                @endfor
            </div>

        </div>

        <div class="col-lg-4">
            
            <div class="card shadow-sm border-0 mb-4 p-4 text-center">
                <img src="https://i.pravatar.cc/150?img=11" alt="Author" class="rounded-circle mx-auto mb-3 border border-3 border-white shadow-sm" width="100" height="100">
                <h5 class="fw-bold mb-1">Nguyễn Văn A</h5>
                <p class="text-muted small mb-3">Travel Blogger / Nhiếp ảnh gia</p>
                <p class="small text-secondary mb-4">Đam mê xê dịch và ghi lại những khoảnh khắc đẹp của cuộc sống qua lăng kính máy ảnh. Hy vọng mang lại cảm hứng du lịch cho mọi người.</p>
                <button class="btn btn-outline-primary rounded-pill w-100 fw-semibold">Theo dõi tác giả</button>
            </div>

            <div class="card shadow-sm border-0 mb-4 p-2">
                <div class="card-header bg-white border-0 pb-0">
                    <h5 class="fw-bold mb-0 text-dark">Xem nhiều nhất</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3 highlight-item pb-2 border-bottom d-flex align-items-center">
                        <img src="https://picsum.photos/80/80?random=30" class="rounded-3 me-3" width="70" height="70" style="object-fit:cover;">
                        <a href="#" class="text-decoration-none text-dark fw-semibold small line-clamp-2">Checklist hành lý du lịch cần thiết cho người mới</a>
                    </div>
                    <div class="highlight-item d-flex align-items-center">
                        <img src="https://picsum.photos/80/80?random=31" class="rounded-3 me-3" width="70" height="70" style="object-fit:cover;">
                        <a href="#" class="text-decoration-none text-dark fw-semibold small line-clamp-2">Mẹo săn vé máy bay giá rẻ từ A-Z</a>
                    </div>
                </div>
            </div>

            <div class="card newsletter-card text-white border-0 p-4 mb-4 shadow-sm">
                <h5 class="fw-bold mb-2">Đăng ký nhận tin ✉️</h5>
                <p class="small text-white-50 mb-3">Nhận cẩm nang du lịch mới nhất hàng tuần.</p>
                <div class="input-group">
                    <input type="email" class="form-control border-0 rounded-start-pill ps-3" placeholder="Email...">
                    <button class="btn btn-dark rounded-end-pill px-3 fw-bold" type="button">Gửi</button>
                </div>
            </div>

        </div>

    </div>

</div>

<style>
/* Kế thừa nền tảng màu sắc */
body {
    background: #f4f6fa;
    font-family: 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
}

.card {
    border-radius: 20px;
}

/* Định dạng nội dung bài viết */
.article-content {
    font-size: 1.05rem;
    line-height: 1.8;
}

.article-content p {
    margin-bottom: 1.5rem;
}

/* Trích dẫn (Blockquote) đẹp mắt */
.custom-blockquote {
    border-left: 4px solid #0d6efd;
    background-color: #f8f9fa;
}

/* Tags */
.tag-pill {
    background-color: #eef2ff;
    color: #0d6efd;
    padding: 6px 14px;
    border-radius: 20px;
    font-size: 0.85rem;
    font-weight: 500;
    transition: all 0.2s ease;
}

.tag-pill:hover {
    background-color: #0d6efd;
    color: #fff;
}

/* Badge (nhãn) tùy biến */
.bg-primary-subtle {
    background-color: #eef2ff !important;
}

/* CSS kế thừa từ bản trước */
.post-card {
    border-radius: 20px;
    overflow: hidden;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.post-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 20px rgba(13, 110, 253, 0.08) !important;
}

.post-card img {
    height: 180px;
    object-fit: cover;
    transition: transform 0.5s ease;
}

.post-card:hover .card-img-hover {
    transform: scale(1.05);
}

.newsletter-card {
    background: linear-gradient(135deg, #0d6efd 0%, #00c6ff 100%);
}

.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;  
    overflow: hidden;
}

.highlight-item a {
    transition: color 0.2s ease;
}
.highlight-item a:hover {
    color: #0d6efd !important;
}
</style>

@endsection