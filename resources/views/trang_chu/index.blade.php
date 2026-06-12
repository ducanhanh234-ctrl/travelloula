@extends('layouts.app')

@section('content')

<style>
*{
    margin:0;
    padding:0;
    box-sizing:border-box;
}

body{
    font-family:'Segoe UI',sans-serif;
    background:#f4f8fb;
}

.hero{
    height:100vh;
    background:
    linear-gradient(rgba(0,0,0,.5),rgba(0,0,0,.5)),
    url('https://images.unsplash.com/photo-1507525428034-b723cf961d3e?auto=format&fit=crop&w=1920&q=80');
    background-size:cover;
    background-position:center;
    display:flex;
    justify-content:center;
    align-items:center;
    text-align:center;
    color:#fff;
}

.hero-content h2{
    font-size:32px;
    font-weight:300;
}

.hero-content h1{
    font-size:80px;
    color:#ffd700;
    margin:15px 0;
    text-shadow:0 5px 15px rgba(0,0,0,.4);
}

.hero-content p{
    max-width:700px;
    margin:auto;
    font-size:18px;
}

.btn-primary{
    display:inline-block;
    margin-top:25px;
    background:#00bcd4;
    color:#fff;
    text-decoration:none;
    padding:14px 30px;
    border-radius:50px;
    transition:.3s;
}

/* .btn-primary:hover{
    background:#0097a7;
} */

.section{
    padding:90px 0;
}

.container{
    width:90%;
    max-width:1200px;
    margin:auto;
}

.section-title{
    text-align:center;
    font-size:42px;
    color:#0f172a;
    margin-bottom:50px;
}

.tours-grid{
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(280px,1fr));
    gap:30px;
}

.tour-card{
    background:#fff;
    border-radius:20px;
    overflow:hidden;
    box-shadow:0 10px 30px rgba(0,0,0,.08);
    transition:.4s;
}

.tour-card:hover{
    transform:translateY(-10px);
}

.cover{
    position:relative;
    height:250px;
    overflow:hidden;
}

.cover img{
    width:100%;
    height:100%;
    object-fit:cover;
    transition:.5s;
}

.tour-card:hover img{
    transform:scale(1.1);
}

.tour-price{
    position:absolute;
    top:15px;
    right:15px;
    background:#ff5722;
    color:#fff;
    padding:8px 15px;
    border-radius:30px;
    font-weight:bold;
}

.tour-card-body{
    padding:25px;
}

.tour-tag{
    display:inline-block;
    background:#e0f7fa;
    color:#0097a7;
    padding:6px 12px;
    border-radius:20px;
    margin-bottom:15px;
}

.tour-card-body h3{
    margin-bottom:10px;
}

.tour-card-body p{
    color:#64748b;
}

.tour-card-footer{
    margin-top:20px;
    display:flex;
    justify-content:space-between;
    align-items:center;
}

.tour-card-footer span{
    color:#ff5722;
    font-size:22px;
    font-weight:bold;
}

.btn-secondary{
    text-decoration:none;
    background:#00bcd4;
    color:white;
    padding:10px 16px;
    border-radius:10px;
}

.features{
    background:white;
    padding:90px 0;
}

.feature-grid{
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(250px,1fr));
    gap:25px;
}

.feature-box{
    background:#fff;
    padding:30px;
    text-align:center;
    border-radius:20px;
    box-shadow:0 10px 25px rgba(0,0,0,.08);
}

.feature-box h3{
    margin-bottom:15px;
    color:#00bcd4;
}

.review-section{
    padding:90px 0;
    background:#eef7fb;
}

.review-grid{
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(300px,1fr));
    gap:25px;
}

.review-card{
    background:#fff;
    padding:30px;
    border-radius:20px;
    box-shadow:0 10px 25px rgba(0,0,0,.08);
}

.review-card h4{
    margin-top:15px;
    color:#00bcd4;
}
</style>

<main>

<section class="hero">
    <div class="hero-content">
        <h2>Khám phá thế giới cùng</h2>
        <h1>TRAVELLOULA</h1>
        <p>
            Trải nghiệm những hành trình tuyệt vời, khám phá các điểm đến nổi tiếng
            cùng dịch vụ du lịch chuyên nghiệp.
        </p>

        <a href="#" class="btn-primary">Đặt Tour Ngay</a>
    </div>
</section>

<section class="section">
    <div class="container">

        <h2 class="section-title">Tour Nổi Bật</h2>

        <div class="tours-grid">

            <!-- Tour 1 -->
            <article class="tour-card">
                <div class="cover">
                    <img src="https://images.unsplash.com/photo-1507525428034-b723cf961d3e?auto=format&fit=crop&w=800&q=80">
                    <div class="tour-price">3.990.000₫</div>
                </div>

                <div class="tour-card-body">
                    <div class="tour-tag">Tour nghỉ dưỡng</div>
                    <h3>Đà Nẵng - Hội An 4N3Đ</h3>
                    <p>Khám phá phố cổ, biển Mỹ Khê và Bà Nà Hills.</p>

                    <div class="tour-card-footer">
                        <span>3.990.000₫</span>
                        <a href="#" class="btn-secondary">Chi tiết</a>
                    </div>
                </div>
            </article>

            <!-- Tour 2 -->
            <article class="tour-card">
                <div class="cover">
                    <img src="https://images.unsplash.com/photo-1513628253939-010e64ac66cd?auto=format&fit=crop&w=800&q=80">
                    <div class="tour-price">2.290.000₫</div>
                </div>

                <div class="tour-card-body">
                    <div class="tour-tag">Tour khám phá</div>
                    <h3>Hạ Long 3N2Đ</h3>
                    <p>Du thuyền trên vịnh Hạ Long và thưởng thức hải sản.</p>

                    <div class="tour-card-footer">
                        <span>2.290.000₫</span>
                        <a href="#" class="btn-secondary">Chi tiết</a>
                    </div>
                </div>
            </article>

            <!-- Tour 3 -->
            <article class="tour-card">
                <div class="cover">
                    <img src="https://images.unsplash.com/photo-1493558103817-58b2924bce98?auto=format&fit=crop&w=800&q=80">
                    <div class="tour-price">5.450.000₫</div>
                </div>

                <div class="tour-card-body">
                    <div class="tour-tag">Tour biển đảo</div>
                    <h3>Phú Quốc 5N4Đ</h3>
                    <p>Resort cao cấp và trải nghiệm lặn biển ngắm san hô.</p>

                    <div class="tour-card-footer">
                        <span>5.450.000₫</span>
                        <a href="#" class="btn-secondary">Chi tiết</a>
                    </div>
                </div>
            </article>

        </div>
    </div>
</section>

<section class="features">
    <div class="container">
        <h2 class="section-title">Vì Sao Chọn Travelloula?</h2>

        <div class="feature-grid">
            <div class="feature-box">
                <h3>✈ Tour Chất Lượng</h3>
                <p>Lịch trình hấp dẫn và dịch vụ chuyên nghiệp.</p>
            </div>

            <div class="feature-box">
                <h3>💰 Giá Tốt</h3>
                <p>Chi phí hợp lý cùng nhiều ưu đãi hấp dẫn.</p>
            </div>

            <div class="feature-box">
                <h3>🛡 An Toàn</h3>
                <p>Đội ngũ hướng dẫn viên giàu kinh nghiệm.</p>
            </div>

            <div class="feature-box">
                <h3>📞 Hỗ Trợ 24/7</h3>
                <p>Luôn sẵn sàng hỗ trợ khách hàng mọi lúc.</p>
            </div>
        </div>
    </div>
</section>

<section class="review-section">
    <div class="container">
        <h2 class="section-title">Khách Hàng Đánh Giá</h2>

        <div class="review-grid">
            <div class="review-card">
                <p>"Tour rất tuyệt vời, dịch vụ chuyên nghiệp."</p>
                <h4>Nguyễn Văn A</h4>
            </div>

            <div class="review-card">
                <p>"Giá tốt, lịch trình hợp lý và hướng dẫn viên nhiệt tình."</p>
                <h4>Trần Thị B</h4>
            </div>

            <div class="review-card">
                <p>"Tôi sẽ tiếp tục đặt tour tại Travelloula."</p>
                <h4>Lê Văn C</h4>
            </div>
        </div>
    </div>
</section>

</main>

@endsection
