
@extends('cms.parent')
@section('title','city create')
@section('page-big-title','city')
@section('page-main-title','cities')
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
            <h3 class="card-title">City Create</h3>
          </div>
          <!-- /.card-header -->
          <!-- form start -->
          <form id="create-form">
            <div class="card-body">
              <div class="form-group">
                <label for="name">name </label>
                <input type="text" class="form-control" id="name"  placeholder="Enter name">
              </div>
              <div class="form-group">
                <label for="address"><address</address> </label>
                <input type="text" class="form-control" id="address"  placeholder="Enter address">
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
    axios.post('/admin/cities',{
        name:document.getElementById('name').value,
        address:document.getElementById('address').value,
    }).then(function (response) {
            // handle success
            console.log(response);
            document.getElementById('create-form').reset();
            toastr.success(response.data.message);
        }).catch(function (error) {
            // handle error
            console.log(error);
            toastr.error(error.response.data.message);
        })

}
</script>
@endsection
