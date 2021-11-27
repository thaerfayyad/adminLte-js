
@extends('cms.parent')
@section('title','category edit')
@section('page-big-title','category')
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
            <h3 class="card-title">Quick Example</h3>
          </div>
          <!-- /.card-header -->
            <!-- form start -->
            <form id="create-form">
                <div class="card-body">
                <div class="form-group">
                    <label for="name">name </label>
                    <input type="text" class="form-control" id="name" value="{{ $category->name }}"  placeholder="Enter name">
                </div>
                <div class="form-group">
                    <label>Description</label>
                    <textarea class="form-control" id="description" rows="3" placeholder="Enter ...">{{ $category->descriptions }}</textarea>
                </div>
                <div class="form-group">
                    <div class="custom-control custom-switch">
                    <input type="checkbox" class="custom-control-input" id="status" @if($category->status) checked @endif>
                    <label class="custom-control-label" for="status">Visible</label>
                    </div>
                </div>

                <div class="card-footer">
                {{--  <button type="button" onclick="store()" class="btn btn-primary">Submit</button>  --}}

                <a href="#" onclick="update('{{ $category->id }}')"  class="btn btn-info">update</i></a>

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
    axios.put('/admin/categories/'+id,{
        name:document.getElementById('name').value,
        description:document.getElementById('description').value,
        status:document.getElementById('status').checked,
    }).then(function (response) {
            // handle success
            console.log(response);
           window.location.href ='/admin/categories';
            toastr.success(response.data.message);
        }).catch(function (error) {
            // handle error
            console.log(error);
            toastr.error(error.response.data.message);
        })

}
</script>
@endsection
