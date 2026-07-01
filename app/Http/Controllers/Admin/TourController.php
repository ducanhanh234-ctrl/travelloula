<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DanhMuc;
use App\Models\DanhSachTour;
use App\Models\NhatKyTour;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class TourController extends Controller
{
    public function index(Request $request)
    {
        // Thống kê
        $tongTour = DanhSachTour::count();

        $activeTour = DanhSachTour::where('trang_thai', 'active')->count();

        $inactiveTour = DanhSachTour::where('trang_thai', 'inactive')->count();

        $tongDanhMuc = DanhMuc::count();

        // Query danh sách
        $query = DanhSachTour::with('danhMuc');

        if ($request->filled('keyword')) {
            $query->where('ten_tour', 'like', '%' . $request->keyword . '%');
        }

        if ($request->filled('danh_muc_id')) {
            $query->where('danh_muc_id', $request->danh_muc_id);
        }

        if ($request->filled('trang_thai')) {
            $query->where('trang_thai', $request->trang_thai);
        }

        if ($request->sort_price == 'asc') {
            $query->orderBy('gia_tour', 'asc');
        } elseif ($request->sort_price == 'desc') {
            $query->orderBy('gia_tour', 'desc');
        } else {
            $query->latest();
        }

        $tours = $query->paginate(10);

        $danhMucs = DanhMuc::all();

        return view(
            'Admin.tours.index',
            compact(
                'tours',
                'danhMucs',
                'tongTour',
                'activeTour',
                'inactiveTour',
                'tongDanhMuc'
            )
        );
    }

    public function create()
    {
        $danhMucs = DanhMuc::all();


        return view(
            'Admin.tours.create',
            compact('danhMucs')
        );
    }

    public function store(Request $request)
    {
        $request->validate([
            'ten_tour' => 'required|max:255',
            'danh_muc_id' => 'required|exists:danh_mucs,id',
            

            'gia_tour' => 'required|numeric|min:0',
            'gia_nguoi_lon' => 'required|numeric|min:0',
            'gia_tre_em' => 'required|numeric|min:0',
            'gia_em_be' => 'required|numeric|min:0',

            'so_ngay' => 'required|integer|min:1|max:30',
            'so_dem' => 'required|integer|min:0|max:29',

            'diem_den' => 'required|max:255',
            'trang_thai' => 'required|in:active,inactive',

            'anh_dai_dien' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $data = $request->only([
            'ten_tour',
            'danh_muc_id',
            'gia_tour',
            'diem_den',
            'trang_thai',
            'mo_ta',
        ]);

        // Tự tạo thời lượng
        $data = $request->except([
            '_token',
            'so_ngay',
            'so_dem'
        ]);

        $data['thoi_luong'] = $request->so_ngay . ' ngày ' . $request->so_dem . ' đêm';
        if ($request->so_dem > $request->so_ngay) {
            return back()
                ->withInput()
                ->withErrors([
                    'so_dem' => 'Số đêm không được lớn hơn số ngày.'
                ]);
        }
        // Upload ảnh
        if ($request->hasFile('anh_dai_dien')) {

            $file = $request->file('anh_dai_dien');

            $fileName = time() . '_' .
                Str::slug($request->ten_tour) . '.' .
                $file->getClientOriginalExtension();

            $data['anh_dai_dien'] = $file->storeAs(
                'tours',
                $fileName,
                'public'
            );
        }

        // Tạo slug
        $slug = Str::slug($request->ten_tour);

        $data['duong_dan'] = $slug;

        $i = 1;

        while (
            DanhSachTour::where('duong_dan', $data['duong_dan'])->exists()
        ) {
            $data['duong_dan'] = $slug . '-' . $i++;
        }

        DB::transaction(function () use (&$tour, $data) {

            $tour = DanhSachTour::create($data);

            NhatKyTour::create([
                'tour_id' => $tour->id,
                'nguoi_dung_id' => Auth::id(),
                'hanh_dong' => 'Tạo tour',
                'du_lieu_cu' => null,
                'du_lieu_moi' => json_encode(
                    $tour->toArray(),
                    JSON_UNESCAPED_UNICODE
                ),
                'dia_chi_ip' => request()->ip(),
            ]);
        });

        return redirect()
            ->route('Admin.tours.index')
            ->with('success', 'Thêm tour thành công.');
    }

    public function show(DanhSachTour $tour)
    {
        return view(
            'Admin.tours.show',
            compact('tour')
        );
    }

    public function edit(DanhSachTour $tour)
    {
        $danhMucs = DanhMuc::all();

        return view(
            'Admin.tours.edit',
            compact(
                'tour',
                'danhMucs'
            )
        );
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'ten_tour' => 'required|max:255',
            'danh_muc_id' => 'required|exists:danh_mucs,id',
            



            'gia_tour' => 'required|numeric|min:0',
            'gia_nguoi_lon' => 'required|numeric|min:0',
            'gia_tre_em' => 'required|numeric|min:0',
            'gia_em_be' => 'required|numeric|min:0',


            'so_ngay' => 'required|integer|min:1|max:30',
            'so_dem' => 'required|integer|min:0|max:29',

            'diem_den' => 'required|max:255',
            'trang_thai' => 'required|in:active,inactive',

            'anh_dai_dien' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);
        $tour = DanhSachTour::with('danhMuc')->findOrFail($id);

        // Lưu dữ liệu cũ
        $duLieuCu = json_encode(
            $tour->toArray(),
            JSON_UNESCAPED_UNICODE
        );

        $data = $request->only([
            'ten_tour',
            'danh_muc_id',
            'gia_tour',
            'diem_den',
            'dia_diem_khoi_hanh',
            'phuong_tien',
            'tieu_chuan_khach_san',
            'so_khach_toi_da',
            'mo_ta',
            'tong_quan_lich_trinh',
            'dich_vu_bao_gom',
            'dich_vu_khong_bao_gom',
            'trang_thai',
        ]);

        $data = $request->except([
            '_token',
            '_method',
            'so_ngay',
            'so_dem'
        ]);

        $data['thoi_luong'] = $request->so_ngay . ' ngày ' . $request->so_dem . ' đêm';

        // Nếu có ảnh mới
        if ($request->hasFile('anh_dai_dien')) {

            if ($tour->anh_dai_dien) {
                Storage::disk('public')
                    ->delete($tour->anh_dai_dien);
            }

            $data['anh_dai_dien'] =
                $request->file('anh_dai_dien')
                    ->store('tours', 'public');
        }

        $tour->update($data);

        // GHI LOG CẬP NHẬT TOUR
        NhatKyTour::create([
            'tour_id' => $tour->id,
            'nguoi_dung_id' => Auth::id(),
            'hanh_dong' => 'Cập nhật tour',

            'du_lieu_cu' => $duLieuCu,

            'du_lieu_moi' => json_encode(
                $tour->fresh()->toArray(),
                JSON_UNESCAPED_UNICODE
            ),

            'dia_chi_ip' => request()->ip(),
        ]);

        return redirect()
            ->route('Admin.tours.index')
            ->with('success', 'Cập nhật tour thành công');
    }

    public function destroy(DanhSachTour $tour)
    {
        // dd('destroy chạy');
        // Lưu dữ liệu trước khi xóa
        $duLieuCu = json_encode(
            $tour->toArray(),
            JSON_UNESCAPED_UNICODE
        );

        // GHI LOG XÓA TOUR
        NhatKyTour::create([
            'tour_id' => $tour->id,
            'nguoi_dung_id' => Auth::id(),
            'hanh_dong' => 'Xóa tour',

            'du_lieu_cu' => $duLieuCu,

            'du_lieu_moi' => null,

            'dia_chi_ip' => request()->ip(),

        ]);
        // dd('đã ghi');
        if ($tour->anh_dai_dien) {
            Storage::disk('public')
                ->delete($tour->anh_dai_dien);
        }

        $tour->delete();

        return back()
            ->with('success', 'Xóa thành công');
    }
}
