
@extends('cms.parent')
@section('title','subcategory edit')
@section('page-big-title','subcategory')
@section('page-main-title','categories')
@section('page-sub-title','edit')
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
            <h3 class="card-title">Edit Subcategory</h3>
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
                            <option value="{{ $category->id }}" {{ $subcategory->id == $category->id ? 'selected' :'' }} >{{ $category->name }}</option>
                            @endforeach

                        </select>
                    </div>
                <div class="form-group">
                    <label for="name">name </label>
                    <input type="text" class="form-control" id="name" value="{{ $subcategory->name }}"  placeholder="Enter name">
                </div>
                <div class="form-group">
                    <label>Description</label>
                    <textarea class="form-control" id="description" rows="3" placeholder="Enter ...">{{ $subcategory->description }}</textarea>
                </div>
                <div class="form-group">
                    <div class="custom-control custom-switch">
                    <input type="checkbox" class="custom-control-input" id="status" @if($subcategory->status) checked @endif>
                    <label class="custom-control-label" for="status">Visible</label>
                    </div>
                </div>

                <div class="card-footer">
                {{--  <button type="button" onclick="store()" class="btn btn-primary">Submit</button>  --}}

                <a href="#" onclick="update('{{ $subcategory->id }}')"  class="btn btn-info">update</i></a>

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
function update(id) {
    axios.put('/admin/subcategories/'+id,{
        name:document.getElementById('name').value,
        category_id:document.getElementById('category_id').value,
        description:document.getElementById('description').value,
        status:document.getElementById('status').checked,
    }).then(function (response) {
            // handle success
            console.log(response);
           window.location.href ='/admin/subcategories';
            toastr.success(response.data.message);
        }).catch(function (error) {
            // handle error
            console.log(error);
            toastr.error(error.response.data.message);
        })

}
</script>
@endsection
