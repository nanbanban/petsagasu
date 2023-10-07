<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>
            @if (isset($title))
                {{ $title . " | " . config('app.name', 'Laravel') }}
            @else
                {{ config('app.name', 'Laravel') }}
            @endif
        </title>
        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap">
        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body>
        <div class="flex flex-wrap justify-between mb-8">
            <div class="px-4 py-4">
                <a href="/" class="text-sm text-gray-700 dark:text-gray-500 underline">トップページ</a>
            </div>
            @if (Route::has('login'))
                <div class="px-4 py-4 text-right sm:block">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="text-sm text-gray-700 dark:text-gray-500 underline">ダッシュボード</a>
                    @else
                        <a href="{{ route('login') }}" class="text-sm text-gray-700 dark:text-gray-500 underline">ログイン</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="ml-4 text-sm text-gray-700 dark:text-gray-500 underline">会員登録</a>
                        @endif
                    @endauth
                </div>
            @endif
        </div>
        
        <div class="font-sans text-gray-900 antialiased px-4">
            <div class="max-w-2xl mx-auto prose">
                {{ $slot }}
            </div>
        </div>
        <footer class="text-white h-10 bg-green-700 text-center mt-10">
            <small class="leading-10">&copy; {{ config('app.name') }}</small>
        </footer>
    </body>
</html>