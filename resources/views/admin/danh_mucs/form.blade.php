<div class="mb-3">

<label>
Tên danh mục
</label>


<input

name="ten_danh_muc"

class="form-control"

value="{{old('ten_danh_muc',$danhMuc->ten_danh_muc??'')}}">


</div>



<div class="mb-3">


<label>Mô tả</label>


<textarea

name="mo_ta"

class="form-control">

{{old('mo_ta',$danhMuc->mo_ta??'')}}

</textarea>


</div>




<div class="mb-3">


<label>Hình ảnh</label>


<input

name="hinh_anh"

class="form-control"

value="{{old('hinh_anh',$danhMuc->hinh_anh??'')}}">


</div>




<div class="mb-3">


<label>Trạng thái</label>


<select

name="trang_thai"

class="form-select">


<option value="active">

Active

</option>


<option value="inactive">

Inactive

</option>


</select>


</div>