<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'My App')</title>
</head>
<body>

    <nav>
        <!-- Navigation bar -->
        <a href="{{ route('lang.switch', 'en') }}">English</a> |
        <a href="{{ route('lang.switch', 'bn') }}">বাংলা</a>
    </nav>

    <div class="container">
        @yield('content')
    </div>

    <footer>
        <!-- Footer -->
    </footer>

</body>
</html>
