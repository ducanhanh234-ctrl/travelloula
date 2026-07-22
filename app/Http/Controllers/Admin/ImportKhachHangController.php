<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Imports\HanhKhachImport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ImportKhachHangController extends Controller
{
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv',
        ]);
        $import = new HanhKhachImport();
        Excel::import($import, $request->file('file'));
        return response()->json($import->rows);
    }
}
