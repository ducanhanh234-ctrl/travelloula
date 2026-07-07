@extends('layouts.app')

@section('title', 'Điều khoản hoàn hủy tour - Travelloula')

@section('content')

<section class="terms-page">
    <div class="terms-container">

        <div class="terms-hero">
            <span>
                <i class="fa-solid fa-file-contract"></i>
                Chính sách dịch vụ
            </span>

            <h1>Điều khoản hoàn hủy tour du lịch</h1>

            <p>
                Quy định về hoàn hủy, thay đổi tour, thanh toán và các trường hợp phát sinh
                trong quá trình khách hàng đặt tour tại Travelloula.
            </p>
        </div>

        <div class="terms-layout">

            <aside class="terms-sidebar">
                <h3>Mục lục</h3>

                <a href="#pham-vi">1. Phạm vi áp dụng</a>
                <a href="#huy-tour">2. Chính sách hủy tour</a>
                <a href="#thay-doi-tour">3. Chính sách thay đổi tour</a>
                <a href="#cong-ty-huy">4. Trường hợp công ty hủy tour</a>
                <a href="#bat-kha-khang">5. Trường hợp bất khả kháng</a>
                <a href="#hoan-tien">6. Thời gian hoàn tiền</a>
                <a href="#quy-trinh">7. Quy trình yêu cầu hủy tour</a>
                <a href="#thanh-toan">8. Điều khoản thanh toán</a>
                <a href="#quy-dinh-chung">9. Quy định chung</a>
            </aside>

            <div class="terms-content">

                <section id="pham-vi" class="terms-card">
                    <h2>1. Phạm vi áp dụng</h2>

                    <p>
                        Điều khoản hoàn hủy này áp dụng đối với tất cả các tour du lịch được khách hàng
                        đặt thông qua website của công ty. Khi xác nhận đặt tour và thanh toán, khách hàng
                        được xem là đã đọc, hiểu và đồng ý với các điều khoản dưới đây.
                    </p>
                </section>

                <section id="huy-tour" class="terms-card">
                    <h2>2. Chính sách hủy tour của khách hàng</h2>

                    <p>
                        Khách hàng có quyền yêu cầu hủy tour trước ngày khởi hành. Mức phí hủy được áp dụng như sau:
                    </p>

                    <div class="policy-table">
                        <div class="policy-row">
                            <strong>Hủy từ 15 đến dưới 30 ngày trước ngày khởi hành</strong>
                            <span>Hoàn lại 90% tổng giá trị tour</span>
                        </div>

                        <div class="policy-row">
                            <strong>Hủy từ 07 đến dưới 15 ngày trước ngày khởi hành</strong>
                            <span>Hoàn lại 70% tổng giá trị tour</span>
                        </div>

                        <div class="policy-row">
                            <strong>Hủy từ 03 đến dưới 07 ngày trước ngày khởi hành</strong>
                            <span>Hoàn lại 40% tổng giá trị tour</span>
                        </div>

                        <div class="policy-row danger">
                            <strong>Hủy trong vòng 03 ngày trước ngày khởi hành hoặc không có mặt đúng giờ</strong>
                            <span>Không hoàn tiền</span>
                        </div>
                    </div>

                    <p>
                        Thời gian hủy tour được tính từ thời điểm công ty xác nhận đã nhận được yêu cầu hủy
                        bằng văn bản hoặc qua email.
                    </p>
                </section>

                <section id="thay-doi-tour" class="terms-card">
                    <h2>3. Chính sách thay đổi tour</h2>

                    <p>Khách hàng có thể yêu cầu thay đổi ngày khởi hành hoặc chuyển sang tour khác nếu:</p>

                    <ul>
                        <li>Yêu cầu được gửi trước ít nhất 15 ngày so với ngày khởi hành.</li>
                        <li>Tour mới còn chỗ.</li>
                        <li>Khách hàng thanh toán phần chênh lệch nếu có hoặc được hoàn phần chênh lệch theo chính sách của công ty.</li>
                    </ul>

                    <p>
                        Mỗi đơn đặt tour chỉ được hỗ trợ thay đổi tối đa một lần.
                    </p>
                </section>

                <section id="cong-ty-huy" class="terms-card">
                    <h2>4. Trường hợp công ty hủy tour</h2>

                    <p>Công ty có quyền hủy tour trong các trường hợp sau:</p>

                    <ul>
                        <li>Không đủ số lượng khách tối thiểu để tổ chức.</li>
                        <li>Thiên tai, dịch bệnh, chiến tranh hoặc các sự kiện bất khả kháng.</li>
                        <li>Yêu cầu của cơ quan nhà nước có thẩm quyền.</li>
                    </ul>

                    <p>Trong trường hợp này, khách hàng sẽ được lựa chọn:</p>

                    <ul>
                        <li>Chuyển sang tour khác có giá trị tương đương.</li>
                        <li>Hoàn lại 100% số tiền đã thanh toán nếu không có nhu cầu tiếp tục sử dụng dịch vụ.</li>
                    </ul>
                </section>

                <section id="bat-kha-khang" class="terms-card">
                    <h2>5. Trường hợp bất khả kháng</h2>

                    <p>
                        Các sự kiện như thiên tai, bão lũ, động đất, dịch bệnh, chiến tranh, đình công,
                        thay đổi chính sách của cơ quan quản lý hoặc các trường hợp ngoài khả năng kiểm soát
                        của các bên được xem là sự kiện bất khả kháng.
                    </p>

                    <p>
                        Trong các trường hợp này, công ty sẽ cố gắng hỗ trợ khách hàng tối đa để đổi lịch
                        hoặc bảo lưu tour. Việc hoàn tiền nếu có sẽ được thực hiện sau khi trừ các chi phí
                        mà công ty đã thanh toán cho các nhà cung cấp dịch vụ và không thể thu hồi.
                    </p>
                </section>

                <section id="hoan-tien" class="terms-card">
                    <h2>6. Thời gian hoàn tiền</h2>

                    <ul>
                        <li>Tiền hoàn sẽ được chuyển về đúng tài khoản hoặc phương thức thanh toán mà khách hàng đã sử dụng.</li>
                        <li>Thời gian xử lý hoàn tiền từ 07 đến 15 ngày làm việc, tùy thuộc vào ngân hàng hoặc đơn vị thanh toán.</li>
                        <li>Mọi chi phí phát sinh liên quan đến giao dịch ngân hàng nếu có sẽ được thực hiện theo quy định của ngân hàng hoặc đơn vị thanh toán.</li>
                    </ul>
                </section>

                <section id="quy-trinh" class="terms-card">
                    <h2>7. Quy trình yêu cầu hủy tour</h2>

                    <p>Để yêu cầu hủy tour, khách hàng cần cung cấp:</p>

                    <ul>
                        <li>Mã đơn đặt tour.</li>
                        <li>Họ và tên người đặt tour.</li>
                        <li>Số điện thoại hoặc email đã đăng ký.</li>
                        <li>Lý do hủy tour.</li>
                    </ul>

                    <p>
                        Yêu cầu hủy chỉ được xem là hợp lệ sau khi công ty xác nhận bằng email
                        hoặc thông báo chính thức trên hệ thống.
                    </p>
                </section>

                <section id="thanh-toan" class="terms-card">
                    <h2>8. Điều khoản thanh toán</h2>

                    <ol>
                        <li>
                            Khi xác nhận đặt tour, khách hàng có trách nhiệm thanh toán trước 30%
                            tổng giá trị tour tiền cọc để giữ chỗ và xác nhận đăng ký tour.
                        </li>

                        <li>
                            70% giá trị tour còn lại phải được khách hàng thanh toán đầy đủ trong thời hạn
                            không quá 07 ngày kể từ ngày kết thúc tour.
                        </li>

                        <li>
                            Trường hợp khách hàng không thanh toán đúng thời hạn nêu trên mà không có thỏa thuận khác
                            bằng văn bản với công ty, công ty có quyền:
                            <ul>
                                <li>Yêu cầu khách hàng thanh toán toàn bộ số tiền còn thiếu.</li>
                                <li>Tạm ngừng hoặc từ chối cung cấp các dịch vụ hậu mãi, xuất hóa đơn hoặc các quyền lợi liên quan cho đến khi khách hàng hoàn thành nghĩa vụ thanh toán.</li>
                                <li>Thực hiện các biện pháp thu hồi công nợ theo quy định của pháp luật.</li>
                            </ul>
                        </li>

                        <li>
                            Mọi khoản thanh toán được thực hiện thông qua các phương thức do công ty công bố
                            trên website hoặc theo hướng dẫn của nhân viên tư vấn.
                        </li>

                        <li>
                            Khách hàng được xem là hoàn thành nghĩa vụ thanh toán khi số tiền đã được ghi nhận
                            thành công vào tài khoản của công ty hoặc hệ thống xác nhận giao dịch thành công.
                        </li>
                    </ol>
                </section>

                <section id="quy-dinh-chung" class="terms-card">
                    <h2>9. Quy định chung</h2>

                    <ul>
                        <li>
                            Các chương trình khuyến mại, tour ưu đãi hoặc tour giảm giá đặc biệt có thể áp dụng
                            chính sách hoàn hủy riêng và sẽ được thông báo trước khi khách hàng thanh toán.
                        </li>

                        <li>
                            Công ty có quyền cập nhật hoặc điều chỉnh chính sách hoàn hủy để phù hợp với quy định
                            của pháp luật và tình hình kinh doanh. Những thay đổi sẽ không ảnh hưởng đến các đơn
                            đặt tour đã được xác nhận trước thời điểm cập nhật.
                        </li>

                        <li>
                            Mọi tranh chấp phát sinh liên quan đến việc hoàn hủy tour sẽ được ưu tiên giải quyết
                            bằng thương lượng. Nếu không đạt được thỏa thuận, tranh chấp sẽ được giải quyết theo
                            quy định của pháp luật Việt Nam.
                        </li>
                    </ul>
                </section>

            </div>
        </div>

    </div>
</section>

<style>
.terms-page{
    min-height:100vh;
    padding:86px 0 90px;
    background:
        radial-gradient(circle at 8% 8%, rgba(7,87,216,.15), transparent 30%),
        radial-gradient(circle at 92% 6%, rgba(255,214,41,.25), transparent 32%),
        linear-gradient(180deg,#f8fbff 0%,#eef6ff 58%,#f8fbff 100%);
}

.terms-container{
    width:min(1380px, calc(100% - 40px));
    margin:0 auto;
}

.terms-hero{
    padding:54px 58px;
    border-radius:34px;
    background:
        linear-gradient(135deg, rgba(255,255,255,.96), rgba(255,255,255,.88)),
        url('https://images.unsplash.com/photo-1500530855697-b586d89ba3ee?auto=format&fit=crop&w=1600&q=80') center/cover no-repeat;
    border:1px solid rgba(226,232,240,.95);
    box-shadow:0 28px 80px rgba(15,23,42,.12);
    margin-bottom:34px;
}

.terms-hero span{
    display:inline-flex;
    align-items:center;
    gap:9px;
    height:38px;
    padding:0 16px;
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
    max-width:900px;
    color:#0b1226;
    font-size:clamp(40px,4.4vw,62px);
    line-height:1.08;
    font-weight:1000;
    letter-spacing:-1.8px;
    text-transform:uppercase;
}

.terms-hero p{
    max-width:820px;
    margin:18px 0 0;
    color:#53627a;
    font-size:17px;
    line-height:1.75;
    font-weight:600;
}

.terms-layout{
    display:grid;
    grid-template-columns:310px 1fr;
    gap:28px;
    align-items:start;
}

.terms-sidebar{
    position:sticky;
    top:112px;
    padding:22px;
    border-radius:24px;
    background:#fff;
    border:1px solid #e2e8f0;
    box-shadow:0 18px 45px rgba(15,23,42,.08);
}

.terms-sidebar h3{
    margin:0 0 16px;
    color:#0f172a;
    font-size:22px;
    font-weight:1000;
}

.terms-sidebar a{
    display:flex;
    align-items:center;
    min-height:42px;
    padding:0 12px;
    border-radius:12px;
    color:#334155;
    font-size:14px;
    font-weight:850;
    text-decoration:none;
    transition:.22s ease;
}

.terms-sidebar a:hover{
    background:#eff6ff;
    color:#0757d8;
    transform:translateX(4px);
}

.terms-content{
    display:flex;
    flex-direction:column;
    gap:22px;
}

.terms-card{
    padding:32px 34px;
    border-radius:26px;
    background:#fff;
    border:1px solid #e2e8f0;
    box-shadow:0 18px 45px rgba(15,23,42,.08);
    scroll-margin-top:120px;
}

.terms-card h2{
    margin:0 0 18px;
    color:#0757d8;
    font-size:26px;
    line-height:1.3;
    font-weight:1000;
}

.terms-card p{
    margin:0 0 16px;
    color:#334155;
    font-size:16px;
    line-height:1.85;
    font-weight:600;
}

.terms-card p:last-child{
    margin-bottom:0;
}

.terms-card ul,
.terms-card ol{
    margin:12px 0 18px 22px;
    color:#334155;
}

.terms-card li{
    margin-bottom:10px;
    padding-left:4px;
    font-size:16px;
    line-height:1.75;
    font-weight:600;
}

.terms-card li::marker{
    color:#0757d8;
    font-weight:1000;
}

.policy-table{
    margin:18px 0 20px;
    border:1px solid #dbe7f5;
    border-radius:20px;
    overflow:hidden;
    background:#fff;
}

.policy-row{
    display:grid;
    grid-template-columns:1.5fr .8fr;
    gap:16px;
    padding:18px 20px;
    border-bottom:1px solid #e2e8f0;
    align-items:center;
}

.policy-row:last-child{
    border-bottom:0;
}

.policy-row strong{
    color:#0f172a;
    font-size:15px;
    font-weight:950;
    line-height:1.5;
}

.policy-row span{
    justify-self:end;
    padding:9px 14px;
    border-radius:999px;
    background:#ecfdf5;
    color:#047857;
    font-size:14px;
    font-weight:1000;
    white-space:nowrap;
}

.policy-row.danger span{
    background:#fff1f2;
    color:#e11d48;
}

@media(max-width:980px){
    .terms-layout{
        grid-template-columns:1fr;
    }

    .terms-sidebar{
        position:relative;
        top:0;
    }
}

@media(max-width:640px){
    .terms-page{
        padding:64px 0 72px;
    }

    .terms-container{
        width:calc(100% - 24px);
    }

    .terms-hero{
        padding:34px 24px;
        border-radius:24px;
    }

    .terms-hero h1{
        letter-spacing:-1px;
    }

    .terms-card{
        padding:24px 20px;
        border-radius:22px;
    }

    .terms-card h2{
        font-size:22px;
    }

    .policy-row{
        grid-template-columns:1fr;
    }

    .policy-row span{
        justify-self:start;
    }
}
</style>

@endsection