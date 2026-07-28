<!doctype html>
<html lang="id">
  <head>
    <meta charset="UTF-8">
    <title>@yield('title')</title>
    <link rel="icon" type="image/png" href="{{ asset('mebius.png') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
  </head>
  <body>
    
        <div class="container">

            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            @yield('content')
        </div>
  </body>
</html>