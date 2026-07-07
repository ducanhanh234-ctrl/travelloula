<?php

namespace App\Http\Controllers;

use App\Models\TrangDieuKhoan;
use Illuminate\Http\Request;

class TrangDieuKhoanController extends Controller
{
    public function edit()
    {
        $trangDieuKhoan = TrangDieuKhoan::firstOrCreate(
            [
                'duong_dan' => 'dieu-khoan',
            ],
            [
                'tieu_de' => 'Điều khoản hoàn hủy tour du lịch',
                'noi_dung' => $this->noiDungMacDinh(),
                'trang_thai' => 1,
            ]
        );

        return view('Admin.trang_dieu_khoans.edit', compact('trangDieuKhoan'));
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'tieu_de' => 'required|string|max:255',
            'noi_dung' => 'nullable|string',
            'trang_thai' => 'required|in:0,1',
        ], [
            'tieu_de.required' => 'Vui lòng nhập tiêu đề.',
            'tieu_de.max' => 'Tiêu đề không được vượt quá 255 ký tự.',
            'trang_thai.required' => 'Vui lòng chọn trạng thái.',
            'trang_thai.in' => 'Trạng thái không hợp lệ.',
        ]);

        $trangDieuKhoan = TrangDieuKhoan::firstOrCreate(
            [
                'duong_dan' => 'dieu-khoan',
            ],
            [
                'tieu_de' => 'Điều khoản hoàn hủy tour du lịch',
                'noi_dung' => '',
                'trang_thai' => 1,
            ]
        );

        $trangDieuKhoan->update([
            'tieu_de' => $data['tieu_de'],
            'noi_dung' => $data['noi_dung'] ?? '',
            'trang_thai' => $data['trang_thai'],
        ]);

        return redirect()
            ->route('Admin.trang_dieu_khoans.edit')
            ->with('success', 'Cập nhật trang điều khoản thành công.');
    }

    private function noiDungMacDinh()
    {
        return "ĐIỀU KHOẢN HOÀN HỦY TOUR DU LỊCH

1. Phạm vi áp dụng
Điều khoản hoàn hủy này áp dụng đối với tất cả các tour du lịch được khách hàng đặt thông qua website của công ty. Khi xác nhận đặt tour và thanh toán, khách hàng được xem là đã đọc, hiểu và đồng ý với các điều khoản dưới đây.

2. Chính sách hủy tour của khách hàng
Khách hàng có quyền yêu cầu hủy tour trước ngày khởi hành. Mức phí hủy được áp dụng như sau:
- Hủy từ 15 đến dưới 30 ngày trước ngày khởi hành: Hoàn lại 90% tổng giá trị tour.
- Hủy từ 07 đến dưới 15 ngày trước ngày khởi hành: Hoàn lại 70% tổng giá trị tour.
- Hủy từ 03 đến dưới 07 ngày trước ngày khởi hành: Hoàn lại 40% tổng giá trị tour.
- Hủy trong vòng 03 ngày trước ngày khởi hành hoặc không có mặt đúng giờ: Không hoàn tiền.

Thời gian hủy tour được tính từ thời điểm công ty xác nhận đã nhận được yêu cầu hủy bằng văn bản hoặc qua email.

3. Chính sách thay đổi tour
Khách hàng có thể yêu cầu thay đổi ngày khởi hành hoặc chuyển sang tour khác nếu:
- Yêu cầu được gửi trước ít nhất 15 ngày so với ngày khởi hành.
- Tour mới còn chỗ.
- Khách hàng thanh toán phần chênh lệch nếu có hoặc được hoàn phần chênh lệch theo chính sách của công ty.

Mỗi đơn đặt tour chỉ được hỗ trợ thay đổi tối đa một lần.

4. Trường hợp công ty hủy tour
Công ty có quyền hủy tour trong các trường hợp sau:
- Không đủ số lượng khách tối thiểu để tổ chức.
- Thiên tai, dịch bệnh, chiến tranh hoặc các sự kiện bất khả kháng.
- Yêu cầu của cơ quan nhà nước có thẩm quyền.

Trong trường hợp này, khách hàng sẽ được lựa chọn:
- Chuyển sang tour khác có giá trị tương đương.
- Hoàn lại 100% số tiền đã thanh toán nếu không có nhu cầu tiếp tục sử dụng dịch vụ.

5. Trường hợp bất khả kháng
Các sự kiện như thiên tai, bão lũ, động đất, dịch bệnh, chiến tranh, đình công, thay đổi chính sách của cơ quan quản lý hoặc các trường hợp ngoài khả năng kiểm soát của các bên được xem là sự kiện bất khả kháng.

Trong các trường hợp này, công ty sẽ cố gắng hỗ trợ khách hàng tối đa để đổi lịch hoặc bảo lưu tour. Việc hoàn tiền nếu có sẽ được thực hiện sau khi trừ các chi phí mà công ty đã thanh toán cho các nhà cung cấp dịch vụ và không thể thu hồi.

6. Thời gian hoàn tiền
- Tiền hoàn sẽ được chuyển về đúng tài khoản hoặc phương thức thanh toán mà khách hàng đã sử dụng.
- Thời gian xử lý hoàn tiền từ 07 đến 15 ngày làm việc, tùy thuộc vào ngân hàng hoặc đơn vị thanh toán.
- Mọi chi phí phát sinh liên quan đến giao dịch ngân hàng nếu có sẽ được thực hiện theo quy định của ngân hàng hoặc đơn vị thanh toán.

7. Quy trình yêu cầu hủy tour
Để yêu cầu hủy tour, khách hàng cần cung cấp:
- Mã đơn đặt tour.
- Họ và tên người đặt tour.
- Số điện thoại hoặc email đã đăng ký.
- Lý do hủy tour.

Yêu cầu hủy chỉ được xem là hợp lệ sau khi công ty xác nhận bằng email hoặc thông báo chính thức trên hệ thống.

8. Điều khoản thanh toán
1. Khi xác nhận đặt tour, khách hàng có trách nhiệm thanh toán trước 30% tổng giá trị tour để giữ chỗ và xác nhận đăng ký tour.
2. 70% giá trị tour còn lại phải được khách hàng thanh toán đầy đủ trong thời hạn không quá 07 ngày kể từ ngày kết thúc tour.
3. Trường hợp khách hàng không thanh toán đúng thời hạn nêu trên mà không có thỏa thuận khác bằng văn bản với công ty, công ty có quyền:
- Yêu cầu khách hàng thanh toán toàn bộ số tiền còn thiếu.
- Tạm ngừng hoặc từ chối cung cấp các dịch vụ hậu mãi, xuất hóa đơn hoặc các quyền lợi liên quan cho đến khi khách hàng hoàn thành nghĩa vụ thanh toán.
- Thực hiện các biện pháp thu hồi công nợ theo quy định của pháp luật.
4. Mọi khoản thanh toán được thực hiện thông qua các phương thức do công ty công bố trên website hoặc theo hướng dẫn của nhân viên tư vấn.
5. Khách hàng được xem là hoàn thành nghĩa vụ thanh toán khi số tiền đã được ghi nhận thành công vào tài khoản của công ty hoặc hệ thống xác nhận giao dịch thành công.

9. Quy định chung
- Các chương trình khuyến mại, tour ưu đãi hoặc tour giảm giá đặc biệt có thể áp dụng chính sách hoàn hủy riêng và sẽ được thông báo trước khi khách hàng thanh toán.
- Công ty có quyền cập nhật hoặc điều chỉnh chính sách hoàn hủy để phù hợp với quy định của pháp luật và tình hình kinh doanh. Những thay đổi sẽ không ảnh hưởng đến các đơn đặt tour đã được xác nhận trước thời điểm cập nhật.
- Mọi tranh chấp phát sinh liên quan đến việc hoàn hủy tour sẽ được ưu tiên giải quyết bằng thương lượng. Nếu không đạt được thỏa thuận, tranh chấp sẽ được giải quyết theo quy định của pháp luật Việt Nam.";
    }
}