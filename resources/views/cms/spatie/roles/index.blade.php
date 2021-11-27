@extends('cms.parent')
@section('title', 'Roles')
@section('page-big-title','roles')
@section('page-main-title','Roles')
@section('page-sub-title','index')
@section('styles')

@endsection
@section('content')
<div class="card-body table-responsive p-0" style="word-break: break-all" >
    <table class="table table-hover text-nowrap border">
      <thead>
        <tr>
          <th>ID</th>
          <th>Name</th>
          <th>Permissions</th>
          <th>Guard name</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
          @foreach ($roles as $role )
      <tr>
          <td>{{ $loop->iteration }}</td>
          <td>{{ $role->name }}</td>
          <td><a href="{{ route('admin.roles.show',$role->id) }}" class="btn btn-block btn-primary" >({{ $role->permissions_count }})Permissions</a></td>
          <td> <span class="badge bg-success"> {{$role->guard_name }}</span></td>
          <td>{{ $role->created_at }}</td>
          <td>
              <a href="{{ route('admin.roles.edit',$role->id) }}" class="btn btn-info"> <i class="fas fa-edit"> </i></a>
              <a href="#" onclick="confirmDestroy('{{ $role->id }}' ,this)"  class="btn btn-danger"><i class="fas fa-trash"></i></a>
          </td>
      </tr>
          @endforeach


      </tbody>
    </table>
  </div>
@endsection
@section('scripts')
  <script>
      function confirmDestroy(id, reference){
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
          }).then((result) => {
            if (result.isConfirmed) {
                destroy(id, reference);

            }
          });
      }
      function destroy(id, reference) {
        //JS axios
        axios.delete('/admin/roles/'+id)
            .then(function (response) {
            // handle success
            console.log(response);
            reference.closest('tr').remove();
            showMessage(response.data);
            })
            .catch(function (error) {
            // handle error
            console.log(error);
            showMessage(error.response.data);
            })
      }
      function showMessage(data) {
        Swal.fire({
            icon: data.icon,
            title: data.title,
            showConfirmButton: false,
            timer: 1500
          });
      }
  </script>
@endsection
