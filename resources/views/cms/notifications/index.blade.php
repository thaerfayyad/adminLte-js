@extends('cms.parent')
@section('title', 'Notifications')
@section('page-big-title','Notifications')
@section('page-main-title','Notifications')
@section('page-sub-title','index')
@section('styles')

@endsection
@section('content')
<div class="card-body table-responsive p-0" style="word-break: break-all" >
    <table class="table table-hover text-nowrap border">
      <thead>
        <tr>
          <th>ID</th>
          <th>Tilte</th>
          <th>Read</th>
          <th>Send At</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
          @foreach ( Auth::user()->notifications as $notification )
      <tr>
          <td>{{ $loop->iteration }}</td>
          <td>{{ @$notification->data['title'] }}</td>
          <td> <span class="badge @if(is_null($notification->read_at))  bg-success  @else  bg-danger @endif  ">
            {{ $notification->read_at ?? 'New' }}</span></td>
          <td>{{ $notification->created_at }}</td>
          <td>
            <div class="btn-group">
                @if(is_null($notification->read_at))
                <a href="{{ route('admin.products-notifications.read',$notification->id) }}"  class="btn btn-info"> <i class="fas fa-check-double"> </i></a>
                @else
                <button href="{{ route('admin.products-notifications.read',$notification->id) }}"  class="btn btn-info" disabled> <i class="fas fa-check-double"> </i></button>
                @endif
                <a href="#" onclick="confirmDestroy('{{ $notification->id }}' ,this)"  class="btn btn-danger"><i class="fas fa-trash"></i></a>
            </div>
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
        axios.delete('/admin/notifications/'+id)
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
