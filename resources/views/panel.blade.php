<!DOCTYPE html>
<html lang="en">
<head>
    <title>Click Stream</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/materialize.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/styles.css') }}">
    @yield('styles')

</head>
<body>
<header>
    <ul id="slide-out" class="side-nav fixed">
        <div class="center-align"><img src="{{ asset('img/cstream.jpg') }}" id="logo" class="responsive-img"></div>
        <li @yield('general')>
            <a href="{{ url('/') }}"><span>Reporte  General</span></a>
        </li>
        <li @yield('web')>
            <a href="{{ url('reporte-web') }}"><span>Reporte-Sistema web</span></a>
        </li>
        <li @yield('software')>
            <a href="{{ url('reporte-software') }}"><span>Reporte-Software</span></a>
        </li>
        <li @yield('other')>
            <a href="{{ url('reporte-otros') }}"><span>Reporte-Otros</span></a>
        </li>
    </ul>
    <a href="#" data-activates="slide-out" class="button-collapse">
        <i class="large material-icons">menu</i>
    </a>
</header>
<main>
    <div class="row">
        <h4 class="center-align">@yield('title')</h4>
    </div>
    <div clss="container">
        @yield('content')
    </div>
</main>

<script type="text/javascript" src="{{ asset('js/jquery.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/materialize.js') }}"></script>
<script type="text/javascript">
    $('.button-collapse').sideNav();
    $('.collapsible').collapsible();
</script>

@yield('scripts')

</body>
</html>