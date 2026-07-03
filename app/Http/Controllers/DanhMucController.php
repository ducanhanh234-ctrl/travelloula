<?php


namespace App\Http\Controllers;


use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\Models\DanhMuc;



class DanhMucController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:danh_mucs.view')->only(['index', 'show']);
        $this->middleware('permission:danh_mucs.create')->only(['create', 'store']);
        $this->middleware('permission:danh_mucs.edit')->only(['edit', 'update']);
        $this->middleware('permission:danh_mucs.delete')->only(['destroy']);
    }

    public function index(Request $request)
    {


        $keyword=$request->keyword;



        $danhMucs = DanhMuc::when($keyword,function($query)use($keyword){


            $query->where(
                'ten_danh_muc',
                'like',
                '%'.$keyword.'%'
            );


        })

        ->orderBy('id','desc')

        ->paginate(5);



        return view(

            'Admin.danh_mucs.index',

            compact(
                'danhMucs',
                'keyword'
            )

        );


    }





    public function create()
    {


        return view(
            'Admin.danh_mucs.create'
        );


    }







    public function store(Request $request)
    {


        $data=$request->validate([


            'ten_danh_muc'
            =>'required|max:100',


            'trang_thai'
            =>'required'


        ]);



        DanhMuc::create($request->all());



        return redirect()

        ->route('Admin.danh_mucs.index')

        ->with(
            'success',
            'Thêm danh mục thành công'
        );


    }








    public function show(DanhMuc $danh_muc)
    {


        return view(

            'Admin.danh_mucs.show',

            [
                'danhMuc'=>$danh_muc
            ]

        );


    }








    public function edit(DanhMuc $danh_muc)
    {
        $danhMuc=$danh_muc;

        return view(

            'Admin.danh_mucs.edit',
    compact('danhMuc')

        );


    }









    public function update(
        Request $request,
        DanhMuc $danh_muc
    )
    {



        $request->validate([


            'ten_danh_muc'
            =>'required|max:100'


        ]);



        $danh_muc->update(
            $request->all()
        );



        return redirect()

        ->route('Admin.danh_mucs.index')

        ->with(
            'success',
            'Cập nhật thành công'
        );



    }









    public function destroy(DanhMuc $danh_muc)
    {



        try{


            $danh_muc->delete();



            return back()

            ->with(
                'success',
                'Xóa danh mục thành công'
            );



        }


        catch(\Exception $e){



            return back()

            ->with(
                'error',
                'Không thể xóa vì danh mục đang được sử dụng'
            );


        }


    }


}