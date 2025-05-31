<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Gestion Stock') }}</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Figtree:wght@400;600;700&display=swap" rel="stylesheet">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Animate.css -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

    

    <!-- Vite Assets -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'Figtree', sans-serif;
            background-color: #f8f9fa;
        }

        header.bg-white.shadow {
            background: linear-gradient(90deg, #fdfdfd, #f3f4f6);
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        }

        main {
            padding: 2rem 1rem;
            animation: fadeInUp 0.6s ease-in-out;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>
<body class="antialiased">
    <div class="min-vh-100 d-flex flex-column">

        <!-- Navigation selon rôle -->
        @auth
            @switch(Auth::user()->role)
                @case('vendeur')
                    @include('layouts.navigation-vendeur')
                    @break
                @case('responsable')
                    @include('layouts.navigation-responsable')
                    @break
                @default
                    @include('layouts.navigation') {{-- par défaut : gestionnaire --}}
            @endswitch
        @endauth

        <!-- Header -->
        @isset($header)
            <header class="bg-white shadow animate__animated animate__fadeInDown">
                <div class="container py-4">
                    {{ $header }}
                </div>
            </header>
        @endisset

        <!-- Main -->
        <main class="flex-fill container animate__animated animate__fadeInUp">
            {{ $slot }}
        </main>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    @stack('modals')
</body>
</html>
