@extends('cms.parent')
@section('title', 'Admin')
@section('page-big-title','admins')
@section('page-main-title','Admin')
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

          <th>Email</th>
          <th>Create At</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>

          @foreach ($admins as $admin )
      <tr>
          <td>{{ $loop->iteration }}</td>
          <td>{{ $admin->name }}</td>

          <td>{{ $admin->email }}</td>
          {{--  <td> <span class="badge bg-success"> {{$admin->guard_name }}</span></td>  --}}
          <td>{{ $admin->created_at }}</td>
          @if(auth('admin')->user()->id != $admin->id)
          <td>
              <a href="{{ route('admin.admins.edit',$admin->id) }}" class="btn btn-info"> <i class="fas fa-edit"> </i></a>
              <a href="#" onclick="adminDestroy('{{ $admin->id }}' ,this)"  class="btn btn-danger"><i class="fas fa-trash"></i></a>
          </td>
          @endif
      </tr>
          @endforeach


      </tbody>
    </table>
  </div>
@endsection
@section('scripts')
  <script>
    function adminDestroy(id, reference) {
        confirmDestroy('/admin/admins', id, reference);
    }
  </script>
@endsection
