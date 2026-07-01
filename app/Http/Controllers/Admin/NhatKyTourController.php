<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\NhatKyTour;
use Illuminate\Http\Request;

class NhatKyTourController extends Controller
{
    public function index()
    {
        $nhatKys = NhatKyTour::with([
            'tour',
            'nguoiDung'
        ])->latest()->paginate(20);

        return view(
            'Admin.nhat_ky_tours.index',
            compact('nhatKys')
        );
    }
    public function show($id)
    {
        $nhatKy = NhatKyTour::with([
            'tour',
            'nguoiDung'
        ])->findOrFail($id);

        return view(
            'Admin.nhat_ky_tours.show',
            compact('nhatKy')
        );
    }
}
