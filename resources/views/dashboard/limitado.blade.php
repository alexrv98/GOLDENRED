@php
    $hora = now()->hour;
    if ($hora < 12) {
        $saludo = 'Buenos días';
        $emoji = '☀️';
    } elseif ($hora < 19) {
        $saludo = 'Buenas tardes';
        $emoji = '🌇';
    } else {
        $saludo = 'Buenas noches';
        $emoji = '🌙';
    }
@endphp

<x-layout bodyClass="g-sidenav-show bg-gray-100">
    <x-navbars.sidebar activePage='alt-dashboard'></x-navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        <x-navbars.navs.auth titlePage="Inicio" />

        <div class="container-fluid d-flex justify-content-center align-items-center" style="min-height: 70vh;">
            <div style="background: white; padding: 3rem 2rem; width: 100%; max-width: 1100px; text-align: center;">
                
                   <img src="https://cdn-icons-png.flaticon.com/128/4814/4814852.png"
                 alt="Welcome" width="90" height="90" class="mb-4">


                <h2 class="text-gray-800 font-weight-bold mb-3" style="font-size: 1.9rem;">
                    {{ $saludo }}, {{ auth()->user()->name }} {!! $emoji !!}
                </h2>

                <p class="text-muted mb-4" style="font-size: 1.1rem;">
                    Bienvenido(a) al sistema. Usa el menú lateral para comenzar tu jornada.
                </p>

                <div class="container-fluid d-flex justify-content-center align-items-center" style="max-width: 600px; text-align: center; ">
                <blockquote class="blockquote" style="font-style: italic; color: #6c757d; font-size: 1.1rem;">
                    "El secreto para salir adelante es comenzar." — Mark Twain
                </blockquote>
                </div>
            </div>
        </div>
    </main>
</x-layout>
