<!doctype html>
<html lang="en">

<head>
    <title>Choto URL</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    {{-- SEO --}}
    <meta name="description" content="Make your long URL to short URL easily.">
    <meta name="keywords"
        content="choto url, url shortener, short url, url shortener free, url shortener google, url shortener custom, url shortener custom domain, url shortener custom link, url shortener custom name, url shortener custom url, url shortener c" />
    <meta name="author" content="Anik Kumar Nandi ">

    {{-- Add canonical meta --}}

    <link rel="canonical" href="{{ url('/') }}">

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="Choto URL">
    <meta property="og:url" content="{{ url('/') }}">
    <meta property="og:title" content="Choto URL">
    <meta property="og:description" content="Make your long URL to short URL easily.">
    <meta property="og:image" content="{{ asset('assets/img/featured_image.jpeg') }}">

    <!-- Twitter -->
    <meta property="twitter:card" content="Choto URL">
    <meta property="twitter:url" content="{{ url('/') }}">
    <meta property="twitter:title" content="Choto URL">
    <meta property="twitter:description" content="Make your long URL to short URL easily.">
    <meta property="twitter:image" content="{{ asset('assets/img/featured_image.jpeg') }}">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.lineicons.com/4.0/lineicons.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" />

    {{-- Add favicon --}}
    <link rel="shortcut icon" href="{{ asset('assets/img/favicon.png') }}" type="image/x-icon">
    {{-- Add font --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Agbalumo&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('assets/css/loader.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <style>
        body {
            background-color: #f5f5f5;
            background: url("{{ asset('assets/img/background.webp') }}");
            background-repeat: no-repeat;
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
        }
    </style>
</head>

<body>
    {{-- Main Content --}}
    @yield('content')

    <footer>
        <div class="row copyright-footer">
            <div class="col-md-">
                <p class="text-white">&copy; All Right Reserved by <a class="text-white" target="_blank"
                        href="https://www.linkedin.com/in/anikprogrammer/">Anik Kumar Nandi</a></p>
            </div>
        </div>

    </footer>


    {{-- Scripts --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js""></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.rawgit.com/davidshimjs/qrcodejs/gh-pages/qrcode.min.js"></script>

    @stack('scripts')

</body>

</html>
