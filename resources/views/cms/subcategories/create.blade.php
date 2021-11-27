
@extends('cms.parent')
@section('title','subcategory create')
@section('page-big-title','subcategory')
@section('page-main-title','categories')
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
            <h3 class="card-title">Subcategory Create</h3>
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
                <label for="name">name </label>
                <input type="text" class="form-control" id="name"  placeholder="Enter name">
              </div>
              <div class="form-group">
                <label>Description</label>
                <textarea class="form-control" id="description" rows="3" placeholder="Enter ..."></textarea>
              </div>
              <div class="form-group">
                <div class="custom-control custom-switch">
                  <input type="checkbox" class="custom-control-input" id="status">
                  <label class="custom-control-label" for="status">Visible</label>
                </div>
              </div>

            <div class="card-footer">
              {{--  <button type="button" onclick="store()" class="btn btn-primary">Submit</button>  --}}

              <a href="#" onclick="store()"  class="btn btn-info">submit</i></a>

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
function store() {
    axios.post('/admin/subcategories',{
        name:document.getElementById('name').value,
        category_id:document.getElementById('category_id').value,
        description:document.getElementById('description').value,
        status:document.getElementById('status').checked,
    }).then(function (response) {
            // handle success
            console.log(response);
            document.getElementById('create-form').reset();
            toastr.success(response.data.message);
            window.location.href = '/admin/subcategories/create';
        }).catch(function (error) {
            // handle error
            console.log(error);
            toastr.error(error.response.data.message);
        })

}
</script>
@endsection
