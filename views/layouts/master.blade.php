@php

    use Modules\WebsiteBase\app\Services\WebsiteService;

    /** @var WebsiteService $websiteService */
    $websiteService = app(WebsiteService::class);

    $isStoreVisibleForUser = $websiteService->isStoreVisibleForUser();

    $_currentLocale = \Illuminate\Support\Facades\App::currentLocale();
    if ($_currentLocale === 'en') {
        $_trans = json_encode(app('system_base')->getTranslations());
    } else {
        $_trans = json_encode(app('system_base')->getTranslations(['en', $_currentLocale]));
    }

    // @todo: or do just the current locale by:
    // $_trans = json_encode(app('system_base')->getTranslations([$_currentLocale]));

@endphp<!DOCTYPE html>
{{--<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">--}}
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title') - {{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap">
    {{--        <link rel="icon" href="{{ themes('images/icons8-online-shop-48.png') }}">--}}
    <link rel="icon" href="{{ \Modules\SystemBase\app\Services\ThemeService::getAssetUrl('assets/images/icons8-market-64.png') }}">

    @livewireStyles

    {{--Where to place the translations for javascript? Have to be before init of jumbleSale/messageBox--}}
    <script type="text/javascript">
        var appData = {!! app('php_to_js')->toJson() !!};
        var translations = {!! $_trans !!};
        var currentLocale = '{{ $_currentLocale }}';
        var messageBoxConfig = {!! json_encode(config('message-boxes')) !!};
        var currentUser = {!! \Illuminate\Support\Facades\Auth::check() ? json_encode(\Illuminate\Support\Facades\Auth::user()) : '{}' !!};
    </script>

    {{--    Themes and Modules included by mercy-builds see "resources/js/app.js" --}}
    {{--    Scripts --}}
    @vite([
        'resources/css/app.css',
        'resources/js/app.js',
    ])

</head>
<body class="font-sans antialiased">
<div class="min-h-screen bg-gray-100 {{ session()->has('admin_user_id') ? 'bg-danger' : '' }}"

     {{--             Its working but no needed currently--}}
     {{--             x-data="{ ... jumbleSale.jumbleSale(), ... { current_user : currentUser } }"--}}

     x-data="new jumbleSale.JumbleSale()"
     x-init="start()"
>

    @include('components.message-box')

    @include('inc.header')

    <!-- Page Heading -->
    @if (isset($header))
        <header class="bg-white shadow">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8 bg-banner">
                {{ $header }}
                @include('inc.breadcrumbs')
            </div>
        </header>
    @endif

    <!-- Page Content -->
    <main>
        {{ $slot }}
    </main>

    @include('inc.footer')
</div>

@livewireScripts
</body>
</html>
