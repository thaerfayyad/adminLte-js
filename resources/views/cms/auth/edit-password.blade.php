
@extends('cms.parent')
@section('title','Password Edit')
@section('page-big-title','password')
@section('page-main-title','Password')
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
            <h3 class="card-title">Password Edit</h3>
          </div>
          <!-- /.card-header -->
          <!-- form start -->
            <form id="create-form">
                <div class="card-body">
                        <div class="form-group">
                             <label for="current_password">Current Password </label>
                            <input type="password" class="form-control" id="current_password"  placeholder="Enter current password">
                        </div>
                        <div class="form-group">
                              <label for="new_password">New Password </label>
                              <input type="password" class="form-control" id="new_password"  placeholder="Enter new password">
                        </div>

                            <div class="form-group">
                              <label for="new_password_confirmation"> New Password  Confirmation</label>
                              <input type="password" class="form-control" id="new_password_confirmation"  placeholder="Enter new password confirmation">
                            </div>
                <div class="card-footer">
                {{--  <button type="button" onclick="store()" class="btn btn-primary">Submit</button>  --}}
                <button type="button" onclick="updatePassword()" class="btn btn-primary">Update</button>
                {{-- <a href="#" onclick="updatePassword()" class="btn btn-info">submit</i></a> --}}

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
function updatePassword() {
    axios.put('/admin/update-password',{
        password:document.getElementById('current_password').value,
        new_password:document.getElementById('new_password').value,
        new_password_confirmation:document.getElementById('new_password_confirmation').value,
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
