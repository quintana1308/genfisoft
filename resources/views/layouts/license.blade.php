<!DOCTYPE html>
<html lang="en">
    
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta charset="utf-8" />
    <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('paper') }}/img/logotipo-genfinsoft.png">
    <link rel="icon" type="image/png" href="{{ asset('paper') }}/img/logotipo-genfinsoft.png">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

    <title>
        {{ __('Genfinsoft | Sistema') }}
    </title>
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no'
        name='viewport' />
    <!--     Fonts and icons     -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Montserrat:wght@400;600;700;800&display=swap" rel="stylesheet" />
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" rel="stylesheet">
    <!-- CSS Files -->
    <link href="{{ asset('paper') }}/css/bootstrap.min.css" rel="stylesheet" />
    <link href="{{ asset('paper') }}/css/paper-dashboard.css?v=2.0.0" rel="stylesheet" />
    <!-- CSS Just for demo purpose, don't include it in your project -->
    <link href="{{ asset('paper') }}/demo/demo.css" rel="stylesheet" />
    <!-- GenFinSoft Modern Design System -->
    <link href="{{ asset('css') }}/genfisoft-modern.css" rel="stylesheet" />
    <!-- Sunflower Theme - Paleta de colores personalizada -->
    <link href="{{ asset('css') }}/sunflower-theme.css" rel="stylesheet" />
    <!-- Modern Components - Componentes modernos adicionales -->
    <link href="{{ asset('css') }}/modern-components.css" rel="stylesheet" />
    <!-- Visual Overrides - Sobrescrituras visuales completas -->
    <link href="{{ asset('css') }}/visual-overrides.css" rel="stylesheet" />

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
</head>

<body class="{{ $class ?? 'login-page' }}">
    
    <!-- Solo el contenido, sin navegación -->
    <div class="wrapper wrapper-full-page">
        <div class="full-page section-image" filter-color="black" data-image="{{ asset('paper') . '/' . ($backgroundImagePath ?? 'img/bg/fabio-mangione.jpg') }}">
            @yield('content')
            @include('layouts.footer')
        </div>
    </div>

    <!--   Core JS Files   -->
    <script src="{{ asset('paper') }}/js/core/jquery.min.js"></script>
    <script src="{{ asset('paper') }}/js/core/popper.min.js"></script>
    <script src="{{ asset('paper') }}/js/core/bootstrap.min.js"></script>
    <script src="{{ asset('paper') }}/js/plugins/perfect-scrollbar.jquery.min.js"></script>
    <!-- Chart JS -->
    <script src="{{ asset('paper') }}/js/plugins/chartjs.min.js"></script>
    <!--  Notifications Plugin    -->
    <script src="{{ asset('paper') }}/js/plugins/bootstrap-notify.js"></script>
    <!-- Control Center for Now Ui Dashboard: parallax effects, scripts for the example pages etc -->
    <script src="{{ asset('paper') }}/js/paper-dashboard.min.js?v=2.0.0" type="text/javascript"></script>
    <!-- Paper Dashboard DEMO methods, don't include it in your project! -->
    <script src="{{ asset('paper') }}/demo/demo.js"></script>

    <script>
        const base_url = "{{ url('/') }}";
    </script>

    @stack('scripts')
</body>

</html>
