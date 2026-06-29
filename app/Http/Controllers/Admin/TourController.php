<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DanhMuc;
use App\Models\DanhSachTour;
use App\Models\NhatKyTour;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class TourController extends Controller
{
    public function index(Request $request)
    {
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
            compact('tours', 'danhMucs')
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
            'gia_tour' => 'required|numeric',
        ]);

        $data = $request->all();

        if ($request->hasFile('anh_dai_dien')) {
            $data['anh_dai_dien'] =
                $request->file('anh_dai_dien')
                    ->store('tours', 'public');
        }

        $slug = Str::slug($request->ten_tour);

        $count = DanhSachTour::where(
            'duong_dan',
            'LIKE',
            "{$slug}%"
        )->count();

        $data['duong_dan'] = $count
            ? $slug . '-' . ($count + 1)
            : $slug;

        $tour = DanhSachTour::create($data);

        // GHI LOG TẠO TOUR
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

        return redirect()
            ->route('Admin.tours.index')
            ->with('success', 'Thêm tour thành công');
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
        $tour = DanhSachTour::findOrFail($id);

        // Lưu dữ liệu cũ
        $duLieuCu = json_encode(
            $tour->toArray(),
            JSON_UNESCAPED_UNICODE
        );

        $data = $request->all();

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

