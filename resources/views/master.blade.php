<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>@yield('title')</title>

    <!-- Bootstrap -->
    <link href="{{ URL::asset('../app/assets/vendors/css/bootstrap.min.css')}}" rel="stylesheet">
    
    @yield('header')
    
  </head>
  <body>
    <div class="container">
        @yield('content')
    </div>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="{{ URL::asset('../app/assets/vendors/js/bootstrap.min.js')}}"></script>
    
    @yield('footer')
  </body>
</html>