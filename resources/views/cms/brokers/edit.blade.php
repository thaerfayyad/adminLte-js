
@extends('cms.parent')
@section('title','broker edit')
@section('page-big-title','broker')
@section('page-main-title','brokers')
@section('page-sub-title','edit')
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
            <h3 class="card-title">Broker  Edit</h3>
          </div>
          <!-- /.card-header -->
          <!-- form start -->
          <form id="create-form">
            <div class="card-body">
              <div class="form-group">
                <label for="name">name </label>
                <input type="text" class="form-control" id="name" value="{{$broker->name}}" placeholder="Enter name">
              </div>
              <div class="form-group">
                <label for="email">Email </label>
                <input type="email" class="form-control" id="email" value="{{$broker->email}}"  placeholder="Enter email">
              </div>
            <div class="card-footer">
                  {{--  <a href="#" onclick="update('{{ $broker->id }}')"  class="btn btn-info">submit</i></a>  --}}
                  <button type="button"  onclick="update('{{ $broker->id }}')"  class="btn btn-info">update</button>

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

function update(id) {
    axios.put('/admin/brokers/'+id,{
        name:document.getElementById('name').value,
        email:document.getElementById('email').value,
    }).then(function (response) {
            // handle success
            console.log(response);
            toastr.success(response.data.message);
        }).catch(function (error) {
            // handle error
            console.log(error);
            toastr.error(error.response.data.message);
        })

}
</script>
@endsection
