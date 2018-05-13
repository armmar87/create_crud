<!DOCTYPE html>

<html>

<head>
    <meta charset="utf-8">
    <title>Hi</title>

</head>

<body>


<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12">
        <img height="150" src="{{asset('images/'.$product->image)}}">
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>Name:</strong>
            {{ $product->prod_name }}
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>Description:</strong>
            {{ $product->description }}
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>Price:</strong>
            {{ $product->price }}
        </div>
        <div class="form-group">
            <strong>Discount:</strong>
            {{ $product->discount }}
        </div>
        <div class="form-group">
            <strong>Quantity:</strong>
            {{ $product->quantity }}
        </div>
    </div>
</div>



</body>

</html>