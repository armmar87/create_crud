<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Untitled Document</title>
    <style>
        td{text-align:left !important; padding:10px !important;}
    </style>
</head>

<body>

<center style="width:100%; font-family:Tahoma, 'Arial AMU'; font-size:14px; line-height:20px;">
    <table border="0" cellspacing="0" cellpadding="0" width="100%" bgcolor="#f6f8fa" style="width:100%!important;min-width:100%!important; background:#f6f8fa; padding:40px;">
        <tr>
            <td>
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
                    <div style="padding:15px 0;">
                        <a href="{{url('/download_pdf?p=' . $product->id)}}" style="display:block; margin:0 auto; widt:100%; max-width:250px; text-align:center; font-weight:bold; padding:12px 15px; text-decoration:none; background:#FFA300; color:#FFF;">
                            Download pdf
                        </a>
                    </div>

                </div>

            </td>
        </tr>
    </table>
</center>

</body>
</html>
