<!DOCTYPE html>
<html class="text-bg-info" data-bs-theme="light" lang="ru" style="font-family: Roboto, sans-serif;">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Бумбатл</title>
    <link rel="stylesheet" href="{{ asset('assets/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto&amp;display=swap">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto+Condensed&amp;display=swap">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto+Flex&amp;display=swap">
    <link rel="stylesheet" href="{{ asset('assets/css/bs-theme-overrides.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/Navbar-Right-Links-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/styles.css') }}">
</head>

<body
    class="d-flex d-xxl-flex flex-column align-items-center align-items-sm-center align-items-md-center align-items-lg-center justify-content-xxl-center align-items-xxl-center pt-0"
    style="font-family: 'Roboto Flex', sans-serif;margin-right: 0px;">

    @include('layouts.components.header')

    @yield('content')

    @include('layouts.components.footer')

    <script src="{{ asset('assets/bootstrap/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/js/main.js') }}"></script>

    <!-- Настройка CSRF-токена для AJAX-запросов -->
    <script>
        // Получаем CSRF-токен из мета-тега
        const token = document.head.querySelector('meta[name="csrf-token"]');

        // Настройка для Axios
        if (window.axios) {
            window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
            window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
        }

        // Настройка для jQuery (если используется)
        if (window.jQuery) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': token.content
                }
            });
        }
    </script>

    @stack('scripts')
</body>
</html>
