<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'JourneySnap') }}</title>

    <!-- <link rel="icon" href="{{ asset('path/a/tu/favicon.ico') }}" type="image/x-icon"> -->

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- Incluir Tailwind CSS -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">

    <!-- Estilos Leaflet API Maps  -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />

    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">



    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>
<body>
    <div id="app">
        <!-- Header -->
        <nav class="navbar navbar-expand-md navbar-light shadow-sm headerprincipal">
            <div class="container d-flex justify-content-between">
                <!-- Logo -->
                <a class="navbar-brand logo" href="{{ url('/home') }}">
                    {{ config('app.name', 'JourneySnap') }}
                </a>

                <!-- Right Side Of Navbar -->
                <ul class="navbar-nav ms-auto d-flex align-items-center">
                    <!-- Authentication Links -->
                    @guest
                        @if (Route::has('login'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                        @endif
                        @if (Route::has('register'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                            </li>
                        @endif
                    @else
                        <!-- Botón '+' para crear una publicación -->
                        <li class="nav-item me-3">
                            <a href="{{ route('posts.create') }}" class="bg-green-500 text-white px-3 py-2 rounded-full text-center flex items-center" title="Crear Publicación">
                                <span class="text-lg font-bold">+</span>
                            </a>
                        </li>

                        <!-- Bloque: Imagen Perfil + Usuario -->
                        <li class="nav-item dropdown d-flex align-items-center">
                            <!-- Enlace a la página de perfil -->
                            <a href="{{ route('profile.index') }}" class="nav-link p-0 me-2" role="button" aria-haspopup="true" aria-expanded="false">
                                <!-- Imagen Perfil -->
                                <div class="rounded-full h-10 w-10 bg-white">
                                    <img src="{{ Auth::user()->imagen_perfil 
                                                ? asset('storage/' . Auth::user()->imagen_perfil) 
                                                : asset('storage/icon.profile.png') }}" 
                                        alt="Imagen Perfil" class="rounded-full h-full w-full object-cover">
                                </div>
                            </a>

                            <a id="navbarDropdown" class="nav-link dropdown-toggle text-white" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                {{ '@' . Auth::user()->username }}
                            </a>

                            <div class="dropdown-menu dropdown-menu-end dropdown-menu-md-start" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </div>
                        </li>
                    @endguest
                </ul>
            </div>
        </nav>
        <!-- End Header -->

        <main class="py-4">
            @yield('content')
        </main>
    </div>

    <!-- Incluir el footer desde el directorio layouts -->
    @include('partials.footer')

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz4fnFO9gybby7tv9Q6QAurZD0RuFWN6NRN8e+a3/5PAJpDsmPZ+pG3moC" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" integrity="sha384-cu2ke4kfT9Ep05+kmF1/sIc13skzo5aU/pt/SHoJ1iGlp+Rns7Npy0f0skF9MzTt" crossorigin="anonymous"></script>
</body>
</html>
