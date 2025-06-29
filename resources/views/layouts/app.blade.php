<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>PsyHelp</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" integrity="sha512-yE0wlAoUwku3DqFSarCz4TjMiOUpKxKjqToDaV57lDK0bwUNfAjXLoKYK2qxOBeRDAUQQYf14Z88VlE0z8a4Yw==" crossorigin="anonymous" referrerpolicy="no-referrer" />


        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100 dark:bg-gray-900 pt-16">
        @include('layouts.navigation')

        @isset($header)
            <header class="bg-white dark:bg-gray-800 shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endisset

        <main>
            @yield('content')
            @if (session('success'))
                <div class="max-w-4xl mx-auto mt-4">
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                        {{ session('success') }}
                    </div>
                </div>
            @endif
        </main>
    </div>
</body>

<footer class="bg-gray-900 text-gray-300">
    <div class="max-w-7xl mx-auto px-4 py-12 grid md:grid-cols-4 gap-8">
        <!-- Логотип и описание -->
        <div>
            <h3 class="text-white text-xl font-bold mb-3">PsyHelp</h3>
            <p class="text-sm text-gray-400">Платформа для онлайн-консультаций с сертифицированными психологами.</p>
        </div>

        <!-- Быстрые ссылки -->
        <div>
            <h4 class="text-white font-semibold mb-4">Навигация</h4>
            <ul class="space-y-2 text-sm">
                <li><a href="{{ route('dashboard') }}" class="hover:text-white">Главная</a></li>
                <li><a href="{{ route('consultations.create') }}" class="hover:text-white">Записаться</a></li>
                <li><a href="#" class="hover:text-white">О нас</a></li>
                <li><a href="#" class="hover:text-white">Политика конфиденциальности</a></li>
            </ul>
        </div>

        <!-- Контакты -->
        <div>
            <h4 class="text-white font-semibold mb-4">Контакты</h4>
            <ul class="text-sm space-y-2">
                <li>Email: <a href="mailto:support@psyhelp.ru" class="hover:text-white">support@psyhelp.ru</a></li>
                <li>Телефон: <a href="tel:+79999999999" class="hover:text-white">+7 (999) 999-99-99</a></li>
                <li>Адрес: Москва, ул. Психологов, д. 1</li>
            </ul>
        </div>

        <!-- Соцсети -->
        <div>
            <h4 class="text-white font-semibold mb-4">Мы в соцсетях</h4>
            <div class="flex space-x-4 text-xl">
                <a href="#" class="hover:text-blue-400" aria-label="Twitter">
                    <i class="fab fa-twitter"></i>
                </a>
                <a href="#" class="hover:text-pink-500" aria-label="Instagram">
                    <i class="fab fa-instagram"></i>
                </a>
                <a href="#" class="hover:text-blue-500" aria-label="Telegram">
                    <i class="fab fa-telegram-plane"></i>
                </a>
                <a href="#" class="hover:text-blue-600" aria-label="VK">
                    <i class="fab fa-vk"></i>
                </a>
            </div>
        </div>
    </div>

    <div class="text-center text-sm text-gray-500 py-4 border-t border-gray-700">
        © {{ date('Y') }} PsyHelp. Все права защищены.
    </div>
</footer>


</html>
