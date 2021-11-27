
@extends('cms.parent')
@section('title','admin create')
@section('page-big-title','admin')
@section('page-main-title','admins')
@section('page-sub-title','create')
@section('styles')

<!-- Select2 -->
<link rel="stylesheet" href="{{ asset('admin_files/plugins/select2/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('admin_files/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
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
            <h3 class="card-title">Broker Create</h3>
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
                <label for="email">Email </label>
                <input type="email" class="form-control" id="email"  placeholder="Enter email">
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
<!-- Select2 -->
<script src="{{ asset('admin_files/plugins/select2/js/select2.full.min.js') }}"></script>
<script>
      //Initialize Select2 Elements
      $('#role').select2({
        theme: 'bootstrap4'
      })

function store() {
    axios.post('/admin/brokers',{
        name:document.getElementById('name').value,
        email:document.getElementById('email').value,
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
