<div class="mb-3">

<label>Tiêu đề</label>

<input

name="tieu_de"

class="form-control"

value="{{old('tieu_de',$banner->tieu_de??'')}}">

</div>



<div class="mb-3">

<label>Mô tả</label>

<textarea

name="mo_ta"

class="form-control">

{{old('mo_ta',$banner->mo_ta??'')}}

</textarea>

</div>



<div class="mb-3">

<label>Hình ảnh</label>

<input

name="hinh_anh"

class="form-control"

value="{{old('hinh_anh',$banner->hinh_anh??'')}}">

</div>




<div class="mb-3">

<label>Loại banner</label>


<select name="loai_banner"

class="form-select">


<option value="hero">
Hero
</option>

<option value="promotion">
Promotion
</option>


<option value="category">
Category
</option>


<option value="featured">
Featured
</option>


</select>


</div>




<div class="mb-3">


<label>Vị trí</label>


<select name="vi_tri_hien_thi"

class="form-select">


<option>top</option>

<option>middle</option>

<option>bottom</option>

<option>sidebar</option>


</select>


</div>