<?php

namespace App\Http\Controllers;


use App\Http\Controllers\Controller;
use App\Models\Banner;

use Illuminate\Http\Request;


class BannerController extends Controller
{


    public function index(Request $request)
    {

        $keyword = $request->keyword;


        $banners = Banner::when($keyword,function($query) use($keyword){

            $query->where('tieu_de','like','%'.$keyword.'%')
                  ->orWhere('loai_banner','like','%'.$keyword.'%');

        })

        ->orderBy('id','desc')
        ->paginate(5);


        return view(
            'Admin.banners.index',
            compact('banners','keyword')
        );

    }




    public function create()
    {

        return view('Admin.banners.create');

    }





    public function store(Request $request)
    {


        $data=$request->validate([


            'tieu_de'=>'required|max:200',

            'hinh_anh'=>'required|max:500',

            'loai_banner'=>'required',

            'vi_tri_hien_thi'=>'required'


        ]);



        Banner::create($request->all());


        return redirect()

        ->route('Admin.banners.index')

        ->with('success','Thêm banner thành công');

    }







    public function show(Banner $banner)
    {


        return view(
            'Admin.banners.show',
            compact('banner')
        );

    }






    public function edit(Banner $banner)
    {


        return view(
            'Admin.banners.edit',
            compact('banner')
        );

    }






    public function update(Request $request,Banner $banner)
    {



        $request->validate([

            'tieu_de'=>'required|max:200',

            'hinh_anh'=>'required'

        ]);



        $banner->update($request->all());



        return redirect()

        ->route('Admin.banners.index')

        ->with('success','Cập nhật thành công');


    }







    public function destroy(Banner $banner)
    {


        try{


            $banner->delete();


            return back()

            ->with('success','Xóa banner thành công');


        }
        catch(\Exception $e){


            return back()

            ->with(
                'error',
                'Không thể xóa banner đang được sử dụng'
            );


        }


    }



}