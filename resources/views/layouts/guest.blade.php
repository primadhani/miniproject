<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href='https://fonts.googleapis.com/css?family=Quicksand:400,500,700&display=swap' rel='stylesheet'>
        <link href='https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,400;0,500;0,600;0,700;1,400;1,500;1,600;1,700&display=swap' rel='stylesheet'>

        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            /* Menggunakan Open Sans untuk font sans default */
            .font-sans {
                font-family: 'Open Sans', ui-sans-serif, system-ui, sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol", "Noto Color Emoji";
            }
            /* Menambahkan kelas font-display khusus Quicksand untuk judul/elemen penting */
            .font-display {
                font-family: 'Quicksand', sans-serif;
            }
            /* Warna dan style Dicoding yang diaplikasikan ke kelas-kelas custom */
            .dcd-btn-primary {
                background-color: #2d3e50; /* Warna biru Dicoding */
                border-color: #2d3e50;
                color: #fff;
                transition: background-color 0.15s ease-in-out;
            }
            .dcd-btn-primary:hover {
                background-color: #2d3e50;
                border-color: #2d3e50;
            }
            .dcd-link {
                color: #08768F;
                text-decoration: none;
            }
            .dcd-link:hover {
                color: #065b6e;
                text-decoration: underline;
            }
            .dcd-default-form {
                /* !!! KUNCI PERUBAHAN: Mengurangi padding input dari 0.75rem menjadi 0.5rem !!! */
                border-radius: 0.25rem;
                border: 1px solid #ced4da;
                padding: 0.5rem 0.5rem; /* Padding dikurangi agar input lebih kecil */
                font-size: 0.8rem;
                line-height: 1.5;
                box-shadow: none;
                transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
            }
            .dcd-default-form:focus {
                border-color: #80bdff;
                box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
            }
            /* Menyesuaikan ukuran font small dari Dicoding */
            .small {
                font-size: 87.5%;
            }
        </style>
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100">
            <div>
                <a href="/" wire:navigate>
                    <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
                </a>
            </div>

            <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
                {{ $slot }}
            </div>
        </div>
    </body>
</html>