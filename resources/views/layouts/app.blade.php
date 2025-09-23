<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" href="{{ asset('images/gemarclogo.png') }}">
        <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Dashboard | Gemarc Enterprises Inc.')</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main class="min-h-screen">
              {{-- Header area (optional) --}}
              @if (isset($header))
                  <header class="border-bottom bg-white">
                      <div class="container py-3">
                          {{ $header }}
                      </div>
                  </header>
              @elseif (View::hasSection('header'))
                  <header class="border-bottom bg-white">
                      <div class="container py-3">
                          @yield('header')
                      </div>
                  </header>
              @endif

              {{-- Page content --}}
              <div class="container py-4">
                @if (isset($slot))
                    {{ $slot }}              {{-- component mode: <x-app-layout> --}}
                @else
                    @yield('content')        {{-- classic mode: @extends + @section --}}
                @endif
              </div>
            </main>
        </div>
</body>
@stack('scripts')
</html>
