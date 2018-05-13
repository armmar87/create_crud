<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Laravel CRUD Application</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-alpha/css/bootstrap.css" rel="stylesheet">
</head>
<body>

<div class="lang_container">
    @foreach($locations as $location)
        <a href="{{url('set-lang/' . $location->code)}}">{{$location->code}}</a>
    @endforeach
</div>

<div class="container">
    @yield('content')
</div>


<script src="{{ asset('js/jquery.min.js') }}"></script>
<script src="{{ asset('js/bootstrap.min.js') }}"></script>


</body>
</html>