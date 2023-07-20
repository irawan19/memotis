@php($ambil_konfigurasi_aplikasis = \App\Models\Master_konfigurasi_aplikasi::first())
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <base href="./">
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
        <meta name="description" content="{{$ambil_konfigurasi_aplikasis->deskripsi_konfigurasi_aplikasis}}">
        <meta name="author" content="{{$ambil_konfigurasi_aplikasis->nama_konfigurasi_aplikasis}}">
        <meta name="keyword" content="{{$ambil_konfigurasi_aplikasis->keywords_konfigurasi_aplikasis}}">
        <title>Dashboard {{$ambil_konfigurasi_aplikasis->nama_konfigurasi_aplikasis}}</title>
	    <link rel="icon" type="image/png" href="{{URL::asset('storage/'.$ambil_konfigurasi_aplikasis->icon_konfigurasi_aplikasis)}}" sizes="any" />
	    <meta name="_token" content="{{ csrf_token() }}">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body>
        <div class="font-sans text-gray-900 antialiased">
            {{ $slot }}
        </div>
    </body>
</html>
