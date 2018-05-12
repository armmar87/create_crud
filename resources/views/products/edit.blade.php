@extends('products.layout')


@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Edit Product</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-primary" href="{{ route('products.index') }}"> Back</a>
            </div>
        </div>
    </div>


    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Whoops!</strong> There were some problems with your input.<br><br>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('products.update',$product->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <ul class="nav nav-tabs" role="tablist">
            @foreach($languges as $key => $language)
                <li class="nav-item">
                    <a class="nav-link {{($key==0)?'active':''}}" href="#lang_{{$language->code}}" role="tab" data-toggle="tab">{{$language->name}}</a>
                </li>
            @endforeach
        </ul>

        <div class="row">


            <div class="tab-content">
                @foreach($languges as $key => $language)
                    @foreach($product->products_t as $code => $product_t)
                        @if($language->code == $product_t->code)
                            <div role="tabpanel" class="tab-pane fade in {{($key==0)?'active':''}}" id="lang_{{$language->code}}">
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <strong>Name:</strong>
                                        <input type="text" name="name_{{$language->code}}" class="form-control" placeholder="Name" value="{{$product_t->name}}">
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <strong>Description:</strong>
                                        <textarea class="form-control" style="height:150px" name="description_{{$language->code}}" placeholder="Description" >{{$product_t->description}}
                                        </textarea>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endforeach
                @endforeach
            </div>


            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Price:</strong>
                    <input type="text" class="form-control" name="price" placeholder="Price" value="{{$product->price}}">
                </div>
            </div>

            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Discount:</strong>
                    <input type="text" class="form-control" name="discount" placeholder="Discount" value="{{$product->discount}}">
                </div>
            </div>

            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Quantity:</strong>
                    <input type="text" class="form-control" name="quantity" placeholder="Quantity" value="{{$product->quantity}}">
                </div>
            </div>

            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <img height="100" src="{{asset('images/'.$product->image)}}">
                </div>
            </div>

            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Image:</strong>
                    <input type="file" class="form-control" name="image">
                </div>
            </div>


            <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </div>
    </form>


@endsection