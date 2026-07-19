<?php

namespace App\Http\Controllers;

use App\Mail\HoaDonMail;
use App\Mail\ThanhToanThanhCong;
use App\Models\DatTour;
use App\Models\ThanhToan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Services\HoaDonService;

class ThanhToanController extends Controller
{
    public function index(Request $request)
    {
        $query = ThanhToan::with([
            'datTour.tour',
            'datTour.khachHangs',
            'nguoiDung'
        ])->whereHas('datTour');
        $tongDoanhThu = ThanhToan::where(
            'trang_thai',
            'da_thanh_toan'
        )
            ->sum('so_tien');
        $daThanhToan = ThanhToan::where(
            'trang_thai',
            'da_thanh_toan'
        )
            ->count();
        $dangXuLy = ThanhToan::where(
            'trang_thai',
            'cho_thanh_toan'
        )
            ->count();
        $hoanTien = ThanhToan::where(
            'trang_thai',
            'hoan_tien'
        )
            ->count();
        // Text search
        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('ma_giao_dich', 'like', "%{$search}%")
                    ->orWhere('phuong_thuc_thanh_toan', 'like', "%{$search}%")
                    ->orWhereHas('nguoiDung', function ($sub) use ($search) {
                        $sub->where('name', 'like', "%{$search}%");
                    })
                    ->orWhereHas('datTour.tour', function ($sub) use ($search) {
                        $sub->where('ten_tour', 'like', "%{$search}%");
                    });
            });
        }

        // Status filter
        if ($request->filled('status')) {
            $query->where('trang_thai', $request->status);
        }

        $thanh_toans = $query
            ->latest()
            ->paginate(10)
            ->withQueryString();
        return view(
            'Admin.thanh_toan.index',

            compact('thanh_toans', 'tongDoanhThu', 'daThanhToan', 'dangXuLy', 'hoanTien')
        );
    }
    public function show($id)
    {
        $thanh_toan = ThanhToan::with([
            'datTour.tour',
            'datTour.khachHangs',
            'nguoiDung'
        ])->findOrFail($id);

        return view('Admin.thanh_toan.show', compact('thanh_toan'));
    }
    public function editStatus($id)
    {
        $thanhToan = ThanhToan::findOrFail($id);

        return view(

            'Admin.thanh_toan.edit_status',

            compact('thanhToan')
        );
    }

    public function updateStatus(Request $request, $id)
    {
        try {
            $request->validate([
                'status' => 'required|string',
                'ghi_chu' => 'nullable|string'
            ]);

            $thanhToan = ThanhToan::findOrFail($id);

            $thanhToan->update([
                'trang_thai' => $request->status,
                'ghi_chu' => $request->ghi_chu,
            ]);

            return redirect()

                ->route('Admin.thanh_toans.index')

                ->with('success', 'Cập nhật trạng thái thành công');
        } catch (\Exception $e) {
            return redirect()
                ->route('Admin.thanh_toans.index',)
                ->with('error', 'Cập nhật trạng thái thất bại: ' . $e->getMessage());
        }
    }
    public function destroy($id)
    {
        $thanh_toan = ThanhToan::query()->findOrFail($id);
        $thanh_toan->delete();

        return redirect()->route('Admin.thanh_toans.index')->with('success', 'Xóa thành công');
    }
    public function createPayment($id)
    {
        $datTour = DatTour::findOrFail($id);

        if ($datTour->trang_thai == 'da_thanh_toan') {
            return back()->with('error', 'Đơn này đã được thanh toán.');
        }

        $vnp_TmnCode    = config('services.vnpay.tmn_code');
        $vnp_HashSecret = trim(config('services.vnpay.hash_secret'));
        $vnp_Url        = config('services.vnpay.url');
        $vnp_ReturnUrl  = config('services.vnpay.return_url');

        // Mã giao dịch
        $vnp_TxnRef = $datTour->ma_dat_tour . '_' . time();

        $inputData = [
            "vnp_Version"    => "2.1.0",
            "vnp_TmnCode"    => $vnp_TmnCode,
            "vnp_Amount"     => (int)($datTour->tong_tien * 100),
            "vnp_Command"    => "pay",
            "vnp_CreateDate" => date("YmdHis"),
            "vnp_CurrCode"   => "VND",
            "vnp_IpAddr"     => "127.0.0.1",
            "vnp_Locale"     => "vn",
            "vnp_OrderInfo"  => "Thanh toan don " . $datTour->ma_dat_tour,
            "vnp_OrderType"  => "billpayment",
            "vnp_ReturnUrl"  => $vnp_ReturnUrl,
            "vnp_TxnRef"     => $vnp_TxnRef,
            "vnp_ExpireDate" => date("YmdHis", strtotime("+15 minutes")),
        ];

        ksort($inputData);

        $query = "";
        $hashData = "";
        $i = 0;

        foreach ($inputData as $key => $value) {

            if ($i == 1) {
                $hashData .= '&' . urlencode($key) . "=" . urlencode($value);
            } else {
                $hashData .= urlencode($key) . "=" . urlencode($value);
                $i = 1;
            }

            $query .= urlencode($key) . "=" . urlencode($value) . '&';
        }

        $vnpSecureHash = hash_hmac(
            "sha512",
            $hashData,
            $vnp_HashSecret
        );

        $paymentUrl = $vnp_Url .
            "?" .
            $query .
            "vnp_SecureHash=" .
            $vnpSecureHash;

        // Cập nhật giao dịch đã tạo trước đó
        $payment = ThanhToan::where('dat_tour_id', $datTour->id)->first();

        if ($payment) {
            $payment->update([
                'ma_giao_dich' => $vnp_TxnRef
            ]);
        }

        return redirect($paymentUrl);
    }
    public function vnpayReturn(Request $request)
    {
        $vnp_HashSecret = trim(config('services.vnpay.hash_secret'));

        $inputData = $request->all();

        if (!isset($inputData['vnp_SecureHash'])) {
            return redirect()
                ->route('client.home')
                ->with('error', 'Không nhận được chữ ký từ VNPAY.');
        }

        $vnp_SecureHash = $inputData['vnp_SecureHash'];

        unset($inputData['vnp_SecureHash']);
        unset($inputData['vnp_SecureHashType']);

        ksort($inputData);

        $hashData = "";

        $i = 0;

        foreach ($inputData as $key => $value) {

            if ($i == 1) {
                $hashData .= '&' . urlencode($key) . '=' . urlencode($value);
            } else {
                $hashData .= urlencode($key) . '=' . urlencode($value);
                $i = 1;
            }
        }

        $secureHash = hash_hmac(
            'sha512',
            $hashData,
            $vnp_HashSecret
        );

        if ($secureHash !== $vnp_SecureHash) {

            return redirect()
                ->route('client.home')
                ->with('error', 'Sai chữ ký bảo mật.');
        }

        $payment = ThanhToan::where(
            'ma_giao_dich',
            $request->vnp_TxnRef
        )->first();

        if (!$payment) {

            return redirect()
                ->route('client.home')
                ->with('error', 'Không tìm thấy giao dịch.');
        }
        $thanhToan = $payment;
        $datTour = $payment->datTour;
        if (
            $request->vnp_ResponseCode == "00" &&
            $request->vnp_TransactionStatus == "00"
        ) {
            $payment->update([

                'trang_thai' => 'da_thanh_toan',

                'thoi_gian_thanh_toan' => now(),

                'ghi_chu' => 'Thanh toán thành công qua VNPAY'
            ]);

            $payment->datTour->update([

                'so_tien_da_thanh_toan' => $payment->so_tien,

                'trang_thai' => 'da_thanh_toan'
            ]);
            // ====== TẠO HÓA ĐƠN PDF ======
            $hoaDonService = new HoaDonService();
            $hoaDonService->taoHoaDon($payment);

            // ====== GỬI EMAIL ======
            Mail::to($payment->datTour->NguoiDung->email)
                ->send(new HoaDonMail($payment));

            return redirect()
                ->route('home')
                ->with('success', 'Thanh toán thành công.');
        }

        $payment->update([

            'trang_thai' => 'that_bai',

            'ghi_chu' => 'Thanh toán thất bại'
        ]);

        return redirect()
            ->route('home')
            ->with('error', 'Thanh toán thất bại.');
    }
    public function paymentHistory()
    {
        $payments = ThanhToan::with('datTour')

            ->where('nguoi_dung_id', auth()->id())

            ->latest()

            ->paginate(10);

        return view(
            'client.thanh_toan.history',
            compact('payments')
        );
    }
    public function guiHoaDon($id)
    {
        $payment = ThanhToan::findOrFail($id);

        Mail::to($payment->datTour->NguoiDung->email)
            ->send(new HoaDonMail($payment));

        return back()->with('success', 'Đã gửi lại hóa đơn.');
    }
}
