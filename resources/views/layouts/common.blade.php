<!DOCTYPE HTML>
<html lang="ja">
    <head>
        <meta charset="UTF-8">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>@yield('title')</title>
        <link rel="stylesheet" href="/css/app.css">

        <script src="/js/app.js" defer></script>

        <!-- jQuery -->
        <script src="https://code.jquery.com/jquery-3.6.2.min.js" integrity="sha256-2krYZKh//PcchRtd+H+VyyQoZ/e3EcrkxhM8ycwASPA=" crossorigin="anonymous"></script>

        <!-- tablesorter -->
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery.tablesorter/2.31.3/js/jquery.tablesorter.min.js" defer></script>

        <!-- 自作のjsファイルも読み込ませることができます -->
        <script src="{{ asset('/js/alert.js') }}"></script>
        <script src="{{ asset('/js/async.search.js') }}" defer></script>
    </head>
    <body>
        <div id="app"></div>
        <header>
            @include('layouts.header')
        </header>
        <br>
        <div class="container">
            @yield('lineup')
        </div>
        <footer class="footer bg-dark  fixed-bottom">
            @include('layouts.footer')
        </footer>
    </body>
</html>
