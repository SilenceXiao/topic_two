<!DOCTYPE html>
<html>
  <head>
    <title>@yield('title', 'Weibo App') - Laravel 入门教程</title>
    <!-- <link rel="stylesheet" href="/css/app.css"> -->
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">
  </head>
  <body>

    @include('layouts.header')

    <div class="container">
      <div class="offset-md-1 col-md-10">
        @include('shared.message')
        @yield('content')
        @include('layouts.footer')
      </div>
    </div>
  </body>
</html>