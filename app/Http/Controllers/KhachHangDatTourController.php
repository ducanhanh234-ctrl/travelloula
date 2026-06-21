<?php
namespace App\Http\Controllers;

use App\Models\DatTour;
use App\Models\KhachHangDatTour; use Illuminate\Http\Request;
class KhachHangDatTourController extends Controller
{
 public function index(Request $request)
{
    $query = KhachHangDatTour::query();

    if ($request->filled('keyword')) {
        $keyword = $request->keyword;

        $query->where(function ($q) use ($keyword) {
            $q->where('ho_ten', 'like', "%{$keyword}%")
                ->orWhere('email', 'like', "%{$keyword}%")
                ->orWhere('so_dien_thoai', 'like', "%{$keyword}%");
        });
    }

    if ($request->filled('loai_hanh_khach')) {
        $query->where('loai_hanh_khach', $request->loai_hanh_khach);
    }

    $khachHangs = $query
        ->selectRaw('
            MAX(id) as id,
            ho_ten,
            email,
            so_dien_thoai,
            COUNT(*) as so_lan_dat,
            SUM(tong_tien) as tong_chi_tieu,
            MAX(created_at) as ngay_tham_gia
        ')
        ->groupBy('ho_ten', 'email', 'so_dien_thoai')
        ->orderByDesc('id')
        ->paginate(10)
        ->appends($request->query());

    return view('Admin.khach_hang_dat_tours.index', compact('khachHangs'));
}
    public function show($id)
    {
        $khachHang = KhachHangDatTour::findOrFail($id);

        $lichSuDatTours = KhachHangDatTour::with([
                'datTour.tour',
                'datTour.lichKhoiHanh'
            ])
            ->where(function ($query) use ($khachHang) {
                $query->where('email', $khachHang->email)
                    ->orWhere('so_dien_thoai', $khachHang->so_dien_thoai);
            })
            ->latest()
            ->get();

        $tongSoTour = $lichSuDatTours->count();
        $tongChiTieu = $lichSuDatTours->sum('tong_tien');
        $soLanCheckIn = $lichSuDatTours->where('da_check_in', true)->count();

        return view('Admin.khach_hang_dat_tours.show', compact(
            'khachHang',
            'lichSuDatTours',
            'tongSoTour',
            'tongChiTieu',
            'soLanCheckIn'
        ));
    }

    public function edit($id)
    {
        $khachHang = KhachHangDatTour::findOrFail($id);

        return view('Admin.khach_hang_dat_tours.edit', compact('khachHang'));
    }

    public function update(Request $request, $id)
    {
        $khachHang = KhachHangDatTour::findOrFail($id);

        $data = $request->validate([
            'ho_ten' => 'required|max:255',
            'gioi_tinh' => 'nullable|max:10',
            'nam_sinh' => 'nullable|integer|min:1900|max:' . date('Y'),
            'so_dien_thoai' => 'nullable|max:20',
            'email' => 'nullable|email|max:255',
            'so_giay_to' => 'nullable|max:50',
            'loai_giay_to' => 'nullable|max:20',
            'loai_hanh_khach' => 'required|max:20',
            'trang_thai_thanh_toan' => 'required|in:chua_thanh_toan,da_coc,thanh_toan_mot_phan,da_thanh_toan,hoan_tien,that_bai',
            'trang_thai_check_in' => 'required|in:chua_check_in,da_check_in',
            'so_tien_da_thanh_toan' => 'required|numeric|min:0',
            'tong_tien' => 'required|numeric|min:0',
            'yeu_cau_dac_biet' => 'nullable|string',
            'so_phong' => 'nullable|max:255',
            'loai_phong' => 'nullable|in:phong_don,phong_doi,phong_twin,phong_ba,phong_gia_dinh,phong_deluxe,phong_suite,phong_vip',
            'ghi_chu' => 'nullable|string',
        ]);

        $data['da_check_in'] = $request->trang_thai_check_in === 'da_check_in';

        if ($data['da_check_in']) {
            $data['thoi_gian_check_in'] = now();
            $data['thoi_gian_da_check_in'] = now();
        }

        $khachHang->update($data);

        return redirect()
            ->route('Admin.khach-hang.index')
            ->with('success', 'Cập nhật khách hàng thành công');
    }

    public function destroy($id)
    {
        $khachHang = KhachHangDatTour::findOrFail($id);
        $khachHang->delete();

        return redirect()
            ->route('Admin.khach-hang.index')
            ->with('success', 'Xóa khách hàng thành công');
    }
    public function create()
{
    $datTours = DatTour::orderByDesc('id')->get();

    return view('Admin.khach_hang_dat_tours.create', compact('datTours'));
}

public function store(Request $request)
{
    $data = $request->validate([
        'dat_tour_id' => 'required|exists:dat_tours,id',
        'ho_ten' => 'required|max:255',
        'gioi_tinh' => 'nullable|max:10',
        'nam_sinh' => 'nullable|integer|min:1900|max:' . date('Y'),
        'so_dien_thoai' => 'nullable|max:20',
        'email' => 'nullable|email|max:255',
        'so_giay_to' => 'nullable|max:50',
        'loai_giay_to' => 'nullable|max:20',
        'loai_hanh_khach' => 'required|max:20',
        'trang_thai_thanh_toan' => 'required|in:chua_thanh_toan,da_coc,thanh_toan_mot_phan,da_thanh_toan,hoan_tien,that_bai',
        'trang_thai_check_in' => 'required|in:chua_check_in,da_check_in',
        'so_tien_da_thanh_toan' => 'required|numeric|min:0',
        'tong_tien' => 'required|numeric|min:0',
        'yeu_cau_dac_biet' => 'nullable|string',
        'so_phong' => 'nullable|max:255',
        'loai_phong' => 'nullable|in:phong_don,phong_doi,phong_twin,phong_ba,phong_gia_dinh,phong_deluxe,phong_suite,phong_vip',
        'ghi_chu' => 'nullable|string',
    ]);

    $data['da_check_in'] = $request->trang_thai_check_in === 'da_check_in';

    if ($data['da_check_in']) {
        $data['thoi_gian_check_in'] = now();
        $data['thoi_gian_da_check_in'] = now();
    }

    KhachHangDatTour::create($data);

    return redirect()
        ->route('Admin.khach-hang.index')
        ->with('success', 'Thêm khách hàng thành công');
}
}
