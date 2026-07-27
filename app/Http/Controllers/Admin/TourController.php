<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BangGiaTour;
use App\Models\DanhMuc;
use App\Models\DanhSachTour;
use App\Models\NhatKyTour;
use App\Models\HinhAnhTour;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class TourController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:tours.view')->only(['index', 'show']);
        $this->middleware('permission:tours.create')->only(['create', 'store']);
        $this->middleware('permission:tours.edit')->only(['edit', 'update']);
        $this->middleware('permission:tours.delete')->only(['destroy']);
    }


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

        return view('Admin.tours.create', compact('danhMucs'));
    }

    public function store(Request $request)
    {
        $request->merge([
            'ten_tour' => trim($request->ten_tour),
            'dia_diem_khoi_hanh' => trim($request->dia_diem_khoi_hanh),
            'diem_den' => trim($request->diem_den),
        ]);

        $request->validate([
            'ten_tour' => 'required|string|max:255|unique:danh_sach_tours,ten_tour',

            'danh_muc_id' => 'required|exists:danh_mucs,id',


            'anh_dai_dien' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',

            'hinh_anh.*' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',

            'gia_tour' => 'required|numeric|min:0',

            'gia_nguoi_lon' => 'required|numeric|min:0|lte:gia_tour',

            'gia_tre_em' => 'required|numeric|min:0|lt:gia_nguoi_lon',


            'so_ngay' => 'required|integer|min:1|max:30',

            'so_dem' => 'required|integer|min:0|lt:so_ngay',

            'dia_diem_khoi_hanh' => 'required|string|max:255',

            'diem_den' => 'required|string|max:255',

            'so_khach_toi_da' => 'required|integer|min:1|max:500',

            'tieu_chuan_khach_san' => 'nullable|string|max:255',

            'mo_ta' => 'required|string|min:20',

            'tong_quan_lich_trinh' => 'required|string|min:20',

            'dich_vu_bao_gom' => 'required|string|min:10',

            'dich_vu_khong_bao_gom' => 'nullable|string',

            'trang_thai' => 'required|in:active,inactive',
        ], [
            'ten_tour.required' => 'Vui lòng nhập tên tour.',

            'danh_muc_id.required' => 'Vui lòng chọn danh mục.',
            'danh_muc_id.exists' => 'Danh mục không tồn tại.',

            'anh_dai_dien.required' => 'Vui lòng chọn ảnh đại diện.',
            'anh_dai_dien.image' => 'File phải là hình ảnh.',
            'anh_dai_dien.mimes' => 'Ảnh chỉ được phép là jpg, jpeg, png hoặc webp.',
            'anh_dai_dien.max' => 'Ảnh tối đa 2MB.',

            'gia_tour.required' => 'Vui lòng nhập giá niêm yết.',
            'gia_tour.numeric' => 'Giá niêm yết phải là số.',
            'gia_tour.min' => 'Giá niêm yết phải lớn hơn hoặc bằng 0.',

            'gia_nguoi_lon.required' => 'Vui lòng nhập giá người lớn.',
            'gia_nguoi_lon.numeric' => 'Giá người lớn phải là số.',
            'gia_nguoi_lon.lte' => 'Giá người lớn không được lớn hơn giá niêm yết.',

            'gia_tre_em.required' => 'Vui lòng nhập giá trẻ em.',
            'gia_tre_em.numeric' => 'Giá trẻ em phải là số.',
            'gia_tre_em.lte' => 'Giá trẻ em không được lớn hơn giá người lớn.',

            'so_ngay.required' => 'Vui lòng chọn số ngày.',
            'so_dem.required' => 'Vui lòng chọn số đêm.',
            'so_dem.lt' => 'Số đêm phải nhỏ hơn số ngày.',

            'dia_diem_khoi_hanh.required' => 'Vui lòng nhập điểm khởi hành.',

            'diem_den.required' => 'Vui lòng nhập điểm đến.',

            'so_khach_toi_da.required' => 'Vui lòng nhập số khách tối đa.',
            'so_khach_toi_da.min' => 'Số khách tối đa phải lớn hơn 0.',

            'mo_ta.required' => 'Vui lòng nhập mô tả.',
            'mo_ta.min' => 'Mô tả phải có ít nhất 20 ký tự.',

            'tong_quan_lich_trinh.required' => 'Vui lòng nhập tổng quan lịch trình.',

            'dich_vu_bao_gom.required' => 'Vui lòng nhập dịch vụ bao gồm.',

            'trang_thai.required' => 'Vui lòng chọn trạng thái.',
        ]);

        DB::beginTransaction();

        try {

            $data = $request->except([
                '_token',
                'so_ngay',
                'so_dem',
                'hinh_anh'
            ]);

            $data['thoi_luong'] = $request->so_ngay . ' ngày ' . $request->so_dem . ' đêm';

            if ($request->hasFile('anh_dai_dien')) {

                $data['anh_dai_dien'] = $request
                    ->file('anh_dai_dien')
                    ->store('tours', 'public');
            }
            $data['duong_dan'] = Str::slug($request->ten_tour);
            $tour = DanhSachTour::create($data);
            BangGiaTour::create([

                'tour_id' => $tour->id,

                'ten_bang_gia' => 'Giá thường',

                'ngay_bat_dau' => now(),

                'ngay_ket_thuc' => now()->addYears(20),

                'phan_tram_tang' => 0,

                'gia_nguoi_lon' => $tour->gia_nguoi_lon,

                'gia_tre_em' => $tour->gia_tre_em,

            ]);

            // Lưu ảnh đại diện
            HinhAnhTour::create([
                'tour_id' => $tour->id,
                'duong_dan_anh' => $data['anh_dai_dien'],
                'la_anh_dai_dien' => true,
                'thu_tu_hien_thi' => 0,
            ]);

            // Lưu nhiều ảnh
            if ($request->hasFile('hinh_anh')) {

                foreach ($request->file('hinh_anh') as $index => $image) {

                    $path = $image->store('tours', 'public');

                    HinhAnhTour::create([
                        'tour_id' => $tour->id,
                        'duong_dan_anh' => $path,
                        'la_anh_dai_dien' => false,
                        'thu_tu_hien_thi' => $index + 1,
                    ]);
                }
            }

            NhatKyTour::create([
                'tour_id' => $tour->id,
                'nguoi_dung_id' => Auth::id(),
                'hanh_dong' => 'Tạo tour',
                'du_lieu_cu' => null,
                'du_lieu_moi' => json_encode($tour),
                'dia_chi_ip' => request()->ip(),
            ]);

            DB::commit();

            return redirect()
                ->route('Admin.tours.index')
                ->with('success', 'Thêm tour thành công!');
        } catch (\Exception $e) {

            DB::rollBack();

            return back()
                ->withInput()
                ->with('error', $e->getMessage());
        }
    }

    public function show($id)
    {
        $tour = DanhSachTour::with([
            'danhMuc',
            'hinhAnhs'
        ])->findOrFail($id);

        return view('Admin.tours.show', compact('tour'));
    }

    public function edit(DanhSachTour $tour)
    {
        $danhMucs = DanhMuc::all();

        $tour->load('hinhAnhs');

        return view('Admin.tours.edit', compact('tour', 'danhMucs'));
    }

    public function update(Request $request, DanhSachTour $tour)
    {
        $request->merge([
            'ten_tour' => trim($request->ten_tour),
            'dia_diem_khoi_hanh' => trim($request->dia_diem_khoi_hanh),
            'diem_den' => trim($request->diem_den),
        ]);

        $request->validate([
            'ten_tour' => 'required|string|max:255|unique:danh_sach_tours,ten_tour,' . $tour->id,

            'danh_muc_id' => 'required|exists:danh_mucs,id',


            'anh_dai_dien' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',

            'hinh_anh.*' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',

            'gia_tour' => 'required|numeric|min:0',

            'gia_nguoi_lon' => 'required|numeric|min:0|lte:gia_tour',


            'gia_tre_em' => 'required|numeric|min:0|lt:gia_nguoi_lon',

            'so_ngay' => 'required|integer|min:1',

            'so_dem' => 'required|integer|min:0|lt:so_ngay',

            'dia_diem_khoi_hanh' => 'required',

            'diem_den' => 'required',

            'so_khach_toi_da' => 'required|integer|min:1',

            'mo_ta' => 'required',

            'tong_quan_lich_trinh' => 'required',

            'dich_vu_bao_gom' => 'required',

            'trang_thai' => 'required',
        ]);

        DB::beginTransaction();

        try {

            $duLieuCu = $tour->toArray();

            $data = $request->except([
                '_token',
                '_method',
                'so_ngay',
                'so_dem',
                'hinh_anh'
            ]);

            $data['thoi_luong'] = $request->so_ngay . ' ngày ' . $request->so_dem . ' đêm';

            // Cập nhật ảnh đại diện
            if ($request->hasFile('anh_dai_dien')) {

                if (
                    $tour->anh_dai_dien &&
                    Storage::disk('public')->exists($tour->anh_dai_dien)
                ) {

                    Storage::disk('public')->delete($tour->anh_dai_dien);
                }

                $path = $request->file('anh_dai_dien')
                    ->store('tours', 'public');

                $data['anh_dai_dien'] = $path;

                HinhAnhTour::where('tour_id', $tour->id)
                    ->update([
                        'la_anh_dai_dien' => false
                    ]);

                $cover = HinhAnhTour::where('tour_id', $tour->id)
                    ->where('duong_dan_anh', $tour->anh_dai_dien)
                    ->first();

                if ($cover) {

                    $cover->update([
                        'duong_dan_anh' => $path,
                        'la_anh_dai_dien' => true
                    ]);

                } else {

                    HinhAnhTour::create([
                        'tour_id' => $tour->id,
                        'duong_dan_anh' => $path,
                        'la_anh_dai_dien' => true,
                        'thu_tu_hien_thi' => 0,
                    ]);
                }
            }

            if ($request->hasFile('hinh_anh')) {

                $thuTu = HinhAnhTour::where('tour_id', $tour->id)->max('thu_tu_hien_thi') ?? 0;

                foreach ($request->file('hinh_anh') as $image) {

                    $path = $image->store('tours', 'public');

                    HinhAnhTour::create([
                        'tour_id' => $tour->id,
                        'duong_dan_anh' => $path,
                        'la_anh_dai_dien' => false,
                        'thu_tu_hien_thi' => ++$thuTu,
                    ]);
                }
            }

            NhatKyTour::create([
                'tour_id' => $tour->id,
                'nguoi_dung_id' => Auth::id(),
                'hanh_dong' => 'Cập nhật tour',
                'du_lieu_cu' => json_encode($duLieuCu),
                'du_lieu_moi' => json_encode($tour->fresh()),
                'dia_chi_ip' => request()->ip(),
            ]);

            DB::commit();

            return redirect()
                ->route('Admin.tours.index')
                ->with('success', 'Cập nhật tour thành công.');

        } catch (\Exception $e) {

            DB::rollBack();

            return back()
                ->withInput()
                ->with('error', $e->getMessage());
        }
    }

    public function destroy(DanhSachTour $tour)
    {
        DB::beginTransaction();

        try {

            // Xóa ảnh đại diện
            if (
                $tour->anh_dai_dien &&
                Storage::disk('public')->exists($tour->anh_dai_dien)
            ) {

                Storage::disk('public')->delete($tour->anh_dai_dien);
            }

            // Xóa tất cả ảnh chi tiết
            foreach ($tour->hinhAnhs as $image) {

                if (Storage::disk('public')->exists($image->duong_dan_anh)) {

                    Storage::disk('public')->delete($image->duong_dan_anh);
                }

                $image->delete();
            }

            // Ghi log
            NhatKyTour::create([
                'tour_id' => $tour->id,
                'nguoi_dung_id' => Auth::id(),
                'hanh_dong' => 'Xóa tour',
                'du_lieu_cu' => json_encode($tour),
                'du_lieu_moi' => null,
                'dia_chi_ip' => request()->ip(),
            ]);

            $tour->delete();

            DB::commit();

            return redirect()
                ->route('Admin.tours.index')
                ->with('success', 'Đã xóa tour thành công.');

        } catch (\Exception $e) {

            DB::rollBack();

            return back()->with('error', $e->getMessage());
        }
    }
    public function deleteImage($id)
    {
        $image = HinhAnhTour::findOrFail($id);

        if ($image->la_anh_dai_dien) {
            return back()->with('error', 'Không thể xóa ảnh đại diện.');
        }

        if (Storage::disk('public')->exists($image->duong_dan_anh)) {
            Storage::disk('public')->delete($image->duong_dan_anh);
        }

        $image->delete();

        return back()->with('success', 'Đã xóa ảnh.');
    }

}

