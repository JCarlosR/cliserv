<!DOCTYPE html>
<html lang="en">
<head>
    <title>Click Stream</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="/css/materialize.min.css">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/styles.css') }}">
    @yield('styles')
</head>
<body>
<header>
    <ul id="slide-out" class="side-nav fixed">
        <li class="center-align @yield('general')">
            <a href="/">
                <img src="{{ asset('img/igadgets.jpg') }}" id="logo" class="responsive-img">
            </a>
        </li>
        {{--<li @yield('tendencia')>--}}
            {{--<a href="{{ url('tendencia') }}">--}}
                {{--<span>Tendencia Actual</span>--}}
            {{--</a>--}}
        {{--</li>--}}
        {{--<li @yield('mining')>--}}
            {{--<a href="{{ url('reporte/data-mining') }}">--}}
                {{--<span>Data mining</span>--}}
            {{--</a>--}}
        {{--</li>--}}
        {{--<li @yield('hours')>--}}
            {{--<a href="{{ url('reporte/horas') }}">--}}
                {{--<span>Reporte por horas</span>--}}
            {{--</a>--}}
        {{--</li>--}}
        <li @yield('other')>
            <a href="{{ url('reporte/trafico') }}">
                <span>Reporte de tráfico</span>
            </a>
        </li>
        <li @yield('categories')>
            <a href="{{ url('reporte-categorias') }}">
                <span>Categorías más visitadas</span>
            </a>
        </li>
        <li @yield('pages')>
            <a href="{{ url('reporte/pages') }}">
                <span>Fuentes de visitas</span>
            </a>
        </li>
        <li @yield('products')>
            <a href="{{ url('reporte-top10') }}">
                <span>Top productos (Barras)</span>
            </a>
        </li>
        <li @yield('top-productos')>
            <a href="{{ url('/top/productos') }}">
                <span>Top productos (# y %)</span>
            </a>
        </li>
        {{--<li @yield('page')>--}}
            {{--<a href="{{ url('metas') }}">--}}
                {{--<span>Meta</span>--}}
            {{--</a>--}}
        {{--</li>--}}
    </ul>
    <a href="#" data-activates="slide-out" class="button-collapse top-nav full hide-on-large-only">
        <i class="large material-icons">menu</i>
    </a>
</header>
<main>
    <div class="row teal lighten-2 white-text">
        <h4 class="center-align" id="title">@yield('title')</h4>
    </div>
    @yield('main-content')
    <div class="container">
        @yield('content')
    </div>
</main>

<script src="{{ asset('js/jquery.min.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.6/js/materialize.min.js"></script>
<script type="text/javascript">
    $('.button-collapse').sideNav();
    $('.collapsible').collapsible();
</script>

@yield('scripts')

</body>
</html>