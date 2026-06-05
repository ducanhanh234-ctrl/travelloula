@extends('layouts.app')

@section('content')
    <section class="hero">
        <div class="hero-content">
            <h2>Khám phá thế giới cùng</h2>
            <h1>TRAVELLOULA</h1>
            <p>Đây là trang demo hiển thị Header và Footer.</p>
        </div>
    </section>

    <main class="about-main">
        <section class="about-hero">
            <div class="container about-hero-inner">
                <div class="about-text">
                    <h2>Về Travelloula</h2>
                    <h3>Chúng tôi tạo nên những hành trình đáng nhớ</h3>
                    <p>Travelloula là đơn vị lữ hành chuyên nghiệp, cung cấp tour trong nước và quốc tế với dịch vụ trọn gói, tư vấn tận tâm và giá cả cạnh tranh. Chúng tôi tập trung xây dựng trải nghiệm an toàn, thoải mái và giàu cảm xúc cho mọi hành trình.</p>
                    <div class="about-stats">
                        <div>
                            <strong>1.200+</strong>
                            <span>Tour trọn gói</span>
                        </div>
                        <div>
                            <strong>15.000+</strong>
                            <span>Hành khách hài lòng</span>
                        </div>
                        <div>
                            <strong>24/7</strong>
                            <span>Hỗ trợ khách hàng</span>
                        </div>
                    </div>
                </div>
                <div class="about-image">
                    <img src="https://images.unsplash.com/photo-1501785888041-af3ef285b470?auto=format&fit=crop&w=1000&q=80" alt="Về Travelloula">
                </div>
            </div>
        </section>

        <section class="about-values container">
            <div class="values-grid">
                <div class="value-item">
                    <h4>Tầm nhìn</h4>
                    <p>Trở thành thương hiệu du lịch được tin cậy hàng đầu, kết nối khách hàng với những trải nghiệm du lịch ý nghĩa.</p>
                </div>
                <div class="value-item">
                    <h4>Sứ mệnh</h4>
                    <p>Cung cấp dịch vụ du lịch chất lượng, an toàn và trọn vẹn, giúp khách hàng khám phá và thưởng thức cuộc sống.</p>
                </div>
                <div class="value-item">
                    <h4>Giá trị cốt lõi</h4>
                    <p>Uy tín, tận tâm, sáng tạo và luôn đặt khách hàng làm trung tâm.</p>
                </div>
            </div>
        </section>
    </main>
@endsection