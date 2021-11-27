@extends('cms.parent')
@section('title', 'User')
@section('page-big-title','permissions')
@section('page-main-title','Users')
@section('page-sub-title','index')
@section('styles')

<!-- iCheck for checkboxes and radio inputs -->
<link rel="stylesheet" href="{{ asset('admin_files/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">

@endsection
@section('content')
<div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">{{ $user->name }} Permissions</h3>

          <div class="card-tools">
            <div class="input-group input-group-sm" style="width: 150px;">
              <input type="text" name="table_search" class="form-control float-right" placeholder="Search">

              <div class="input-group-append">
                <button type="submit" class="btn btn-default">
                  <i class="fas fa-search"></i>
                </button>
              </div>
            </div>
          </div>
        </div>
        <!-- /.card-header -->
        <div class="card-body table-responsive p-0">

            <table class="table table-hover text-nowrap border">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Garud</th>
                        <th>Assigned</th>
                    </tr>
                </thead>
                <tbody>
                        @foreach ($permissions as $permission )
                            <tr>

                                <td>{{ $permission->name }}</td>
                                <td> <span class="badge bg-success">{{ $permission->guard_name }}</span></td>
                                <td>
                                    <div class="icheck-success d-inline">
                                        <input type="checkbox" onchange="updateUserPermission('{{ $user->id }}','{{ $permission->id }}')"
                                        @if($permission->assigned) checked="" @endif
                                        id="permission_{{$permission->id }}">
                                        <label for="permission_{{ $permission->id }}">
                                        </label>
                                    </div>
                                </td>
                            </tr>
                        @endforeach


                    </tbody>
            </table>

        </div>
        <!-- /.card-body -->
      </div>
      <!-- /.card -->
    </div>
  </div>
@endsection
@section('scripts')
  <script>
      function updateUserPermission(userId, permission) {
        //JS axios

        axios.put('/admin/users/'+userId+'/permissions',{
            permission_id:permission

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
