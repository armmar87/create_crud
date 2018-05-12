@extends('products.layout')

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Laravel CRUD </h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-success" href="{{ route('products.create') }}"> Create New Product</a>
                <a class="btn btn-primary" href="{{ url('/export_csv') }}"> Export Csv</a>
            </div>
        </div>
    </div>


    <div class="row" style="margin: 20px 0">
        <div class="col-lg-4">
            <form action="{{ url('/search')}}" method="POST">
                @csrf
                <div class="input-group">
                     <span class="input-group-btn">
                        <button class="btn btn-secondary" type="submit">Go!</button>
                     </span>
                     <input type="text" class="form-control" name="search" placeholder="Search ...">
                </div>
            </form>
        </div>

        <div class="col-lg-4">
            <form action="{{ url('/search_to_price')}}" method="POST">
                @csrf

                <span class="input-group-btn">
                    <input type="text" name="from" class="form-control mb-2 mr-sm-2 mb-sm-0" id="inlineFormInput" placeholder="From">
                </span>
                <span class="input-group-btn">
                    <input type="text" style="margin: 0 5px;" name="to" class="form-control mb-2 mr-sm-2 mb-sm-0" id="inlineFormInput" placeholder="To">
                </span>

                <span class="input-group-btn">
                    <button class="btn btn-secondary" type="submit">Price</button>
                </span>

            </form>
        </div>
    </div>


    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif


    <table class="table table-bordered">
        <tr>
            <th>No</th>
            <th>Image</th>
            <th>Name</th>
            <th>Description</th>
            <th>Price</th>
            <th width="280px">Action</th>
        </tr>

        @foreach ($products as $key => $product)

            <tr>
                <td>{{ $key+1 }}</td>
                <td><img height="40" src="{{asset('images/'.$product->image)}}"></td>
                <td>{{ $product->prod_name }}</td>
                <td>{{ $product->description}}</td>
                <td>{{ $product->price}}</td>
                <td>
                    <form action="{{ route('products.destroy',$product->id) }}" method="POST">

                        <a class="btn btn-info" href="{{ route('products.show',$product->id) }}">Show</a>

                        <a class="btn btn-primary" href="{{ route('products.edit',$product->id) }}">Edit</a>

                        @csrf
                        @method('DELETE')

                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </table>


    {{--{!! $products->links() !!}--}}


@endsection