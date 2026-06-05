@extends('layouts.app')

@section('content')

<section class="about-banner">
    <div class="overlay"></div>
    <div class="banner-content">
        <h1>Về Travelloula</h1>
        <p>Đồng hành cùng bạn trên mọi hành trình khám phá.</p>
    </div>
</section>

<main class="about-page">

```
<!-- Giới thiệu -->
<section class="about-section container">
    <h2>Giới Thiệu</h2>
    <p>
        Travelloula là đơn vị lữ hành chuyên cung cấp các tour du lịch trong nước
        và quốc tế. Chúng tôi mang đến những trải nghiệm du lịch chất lượng,
        an toàn và đáng nhớ với đội ngũ tư vấn viên, hướng dẫn viên chuyên nghiệp.
    </p>
</section>

<!-- Tầm nhìn -->
<section class="about-section container">
    <div class="grid-3">
        <div class="card">
            <h3>Tầm Nhìn</h3>
            <p>
                Trở thành thương hiệu du lịch uy tín hàng đầu Việt Nam,
                mang đến những hành trình chất lượng và khác biệt.
            </p>
        </div>

        <div class="card">
            <h3>Sứ Mệnh</h3>
            <p>
                Kết nối khách hàng với những điểm đến tuyệt vời,
                tạo nên những trải nghiệm đáng nhớ.
            </p>
        </div>

        <div class="card">
            <h3>Giá Trị Cốt Lõi</h3>
            <p>
                Uy tín - Chuyên nghiệp - Tận tâm - Sáng tạo.
            </p>
        </div>
    </div>
</section>

<!-- Chính sách -->
<section class="about-section container">
    <h2>Chính Sách Dịch Vụ</h2>

    <div class="policy-card">
        <h3>Chính Sách Hoàn/Hủy Tour</h3>
        <p>
            Khách hàng được hỗ trợ hoàn hoặc đổi lịch theo điều kiện của từng tour.
            Mọi thông tin về phí hủy sẽ được thông báo minh bạch trước khi đặt tour.
        </p>
    </div>

    <div class="policy-card">
        <h3>Chính Sách Bảo Mật</h3>
        <p>
            Travelloula cam kết bảo mật tuyệt đối thông tin cá nhân của khách hàng,
            không chia sẻ dữ liệu cho bên thứ ba khi chưa có sự đồng ý.
        </p>
    </div>

    <div class="policy-card">
        <h3>Chính Sách Chất Lượng</h3>
        <p>
            Chúng tôi luôn lựa chọn đối tác vận chuyển, khách sạn và dịch vụ
            đạt tiêu chuẩn nhằm đảm bảo trải nghiệm tốt nhất cho khách hàng.
        </p>
    </div>

    <div class="policy-card">
        <h3>Cam Kết Hỗ Trợ</h3>
        <p>
            Đội ngũ chăm sóc khách hàng hoạt động 24/7 để hỗ trợ khách hàng
            trong suốt quá trình đặt tour và tham gia hành trình.
        </p>
    </div>
</section>

<!-- Đội ngũ -->
<section class="about-section container">
    <h2>Đội Ngũ Travelloula</h2>

    <div class="team-grid">
        <div class="team-card">
            <h4>Hướng Dẫn Viên</h4>
            <p>Kinh nghiệm, nhiệt tình và am hiểu điểm đến.</p>
        </div>

        <div class="team-card">
            <h4>Tư Vấn Viên</h4>
            <p>Hỗ trợ khách hàng lựa chọn tour phù hợp nhất.</p>
        </div>

        <div class="team-card">
            <h4>Chăm Sóc Khách Hàng</h4>
            <p>Luôn đồng hành và giải quyết nhanh mọi yêu cầu.</p>
        </div>
    </div>
</section>
```

</main>

<style>
.about-banner{
    height:450px;
    background:url('https://images.unsplash.com/photo-1501785888041-af3ef285b470?auto=format&fit=crop&w=1600&q=80');
    background-size:cover;
    background-position:center;
    position:relative;
    display:flex;
    justify-content:center;
    align-items:center;
}

.about-banner .overlay{
    position:absolute;
    inset:0;
    background:rgba(0,0,0,.55);
}

.banner-content{
    position:relative;
    z-index:2;
    text-align:center;
    color:white;
}

.banner-content h1{
    font-size:60px;
    margin-bottom:15px;
}

.banner-content p{
    font-size:20px;
}

.about-page{
    background:#f8fafc;
    padding:70px 0;
}

.container{
    width:90%;
    max-width:1200px;
    margin:auto;
}

.about-section{
    margin-bottom:70px;
}

.about-section h2{
    text-align:center;
    margin-bottom:30px;
    color:#0f172a;
}

.grid-3{
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(280px,1fr));
    gap:25px;
}

.card,
.policy-card,
.team-card{
    background:white;
    padding:30px;
    border-radius:18px;
    box-shadow:0 8px 25px rgba(0,0,0,.08);
    transition:.3s;
}

.card:hover,
.policy-card:hover,
.team-card:hover{
    transform:translateY(-5px);
}

.policy-card{
    margin-bottom:20px;
}

.policy-card h3{
    color:#00a8cc;
    margin-bottom:10px;
}

.team-grid{
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(250px,1fr));
    gap:25px;
}

.team-card{
    text-align:center;
}

.team-card h4{
    margin-bottom:10px;
    color:#00a8cc;
}

</style>

@endsection
