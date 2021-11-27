
@extends('cms.parent')
@section('title','Products create')
@section('page-big-title','Products')
@section('page-main-title','Products')
@section('page-sub-title','create')
@section('styles')

@endsection
@section('content')
<!-- Main content -->
<section class="content">
  <div class="container-fluid">
    <div class="row">
      <!-- left column -->
      <div class="col-md-12">
        <!-- general form elements -->
        <div class="card card-primary">
          <div class="card-header">
            <h3 class="card-title">Products Create</h3>
          </div>
          <!-- /.card-header -->
          <!-- form start -->
          <form id="create-form">
            <div class="card-body">
                <div class="form-group">
                    <label for="name">Category </label>
                    <select class="form-control" name="" id="category_id">
                        <option value="">select the cotegory</option>
                        @foreach ($categories as $category )
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach

                    </select>
                </div>
                <div class="form-group">
                    <label for="name">Subcategory </label>
                    <select class="form-control" name="" id="subcategory_id">
                        <option value="">select the subcotegory</option>
                    </select>
                </div>
              <div class="form-group">
                <label for="name">name </label>
                <input type="text" class="form-control" id="name"  placeholder="Enter name">
              </div>
              <div class="form-group">
                <label>Description</label>
                <textarea class="form-control" id="description" rows="3" placeholder="Enter ..."></textarea>
              </div>

              <div class="form-group">
                <label>image</label>
                <input type="file" id="img" class="form-control image" >
              </div>

              <div class="form-group">
                <img src="{{ asset('admin_files/default.png') }}" style="width: 100px" class="img-thumbnail image-preview" alt="">
            </div>
            <div class="form-group">
                <div class="custom-control custom-switch">
                    <input type="checkbox" class="custom-control-input" id="status">
                    <label class="custom-control-label" for="status">Visible</label>
                </div>
            </div>

            <div class="card-footer">
              {{--  <button type="button" onclick="store()" class="btn btn-primary">Submit</button>  --}}

              <a href="#" onclick="performStore()"  class="btn btn-info">submit</i></a>

            </div>
          </form>
        </div>
       </div>
      </div>
    </div>
 </div>
</section>

@endsection
@section('scripts')
<script>
    $(".image").change(function () {

        if (this.files && this.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('.image-preview').attr('src', e.target.result);
            }

            reader.readAsDataURL(this.files[0]);
        }

    });
</script>
<script>
    $(document).ready(function() {
        $('#category_id').on('change',function() {
            var category_id = $(this).val();
            if(category_id){
               $.ajax({
                   url:'/admin/getSubcategory/'+category_id,
                   type:'GET',
                   success: function(data){
                       $('#subcategory_id').empty();
                       $.each(data, function (key, value) {
                            $('#subcategory_id').append('<option value=" ' + key + '">' + value + '</option>');
                        })
                   }
               });
            }else{
                console.log('AJAX load did not work');
                {{--  $('select[name="college"]').empty();  --}}
            }
        });
    });


</script>

<script>
function performStore() {
        let formData = new FormData();
        formData.append('name',document.getElementById('name').value);
        formData.append('description',document.getElementById('description').value);
        formData.append('subcategory_id',document.getElementById('subcategory_id').value);
        formData.append('status',document.getElementById('status').checked);

        formData.append('img', document.getElementById('img').files[0])
        store('/admin/products', formData),'/admin/products /create';

    }


</script>
@endsection
