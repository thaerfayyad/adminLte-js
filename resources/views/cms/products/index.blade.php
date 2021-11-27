@extends('cms.parent')
@section('title', 'Products')
@section('page-big-title','product')
@section('page-main-title','products')
@section('page-sub-title','index')
@section('styles')

@endsection
@section('content')
<div class="card-body table-responsive p-0" style="word-break: break-all" >
    <table class="table table-hover text-nowrap border">
      <thead>
        <tr>
          <th>ID</th>
          <th>Image</th>
          <th>Category</th>
          <th>Subcategory</th>
          <th>Name</th>
           <th>Descripions</th>
          <th>Status</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
          @foreach ($products as $product )
      <tr>
          <td>{{ $loop->iteration }}</td>
          {{--  <td  class="">
            {!! DNS1D::getBarcodeHTML('444', 'PHARMA') !!}
          </td>  --}}

          <td>
              @if(!$product->img == 0)

                <img class="img-circle img-bordered-sm"   src="{{url(Storage::url($product->img))}}" width="80" height="65" alt="User Image">

              @else
              <img class="img-circle img-bordered-sm" width="80" height="65"
              src="{{url(Storage::url('products/default.png'))}}" alt="User Image">
            @endif
            </td>
            <td>{{ @$product->subcategory->category->name }}</td>
          <td>{{ @$product->subcategory->name }}</td>
          <td>{{ $product->name }}</td>
          <td>{{ $product->description }}</td>
          <td> <span class="badge @if($product->status) bg-success @else bg-danger @endif  ">
              {{ $product->visibility  }}</span></td>

          <td>{{ $product->created_at }}</td>
          <td>
              <a href="{{ route('admin.products.edit',$product->id) }}" class="btn btn-info"> <i class="fas fa-edit"> </i></a>
              <a href="#" onclick="productDestroy('{{ $product->id }}' ,this)"  class="btn btn-danger"><i class="fas fa-trash"></i></a>
          </td>
      </tr>
          @endforeach

      </tbody>
    </table>
       {{-- Pagination --}}
       <div class="d-flex justify-content-center">
        <div class="small">
        {!! $products->links() !!}
        </div>

    </div>

  </div>
@endsection
@section('scripts')

    <script>
        function productDestroy(id, reference) {
            confirmDestroy('/admin/products', id, reference);
        }
    </script>
@endsection
