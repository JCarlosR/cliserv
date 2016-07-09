@extends('panel')

@section('title', 'El producto y categoría más visitados')

@section('tendencia', 'class="activated"')

@section('content')
    <div class="row">
        @if(isset($product))
            <div class="col s12 m6">

                <div class="card">
                    <div class="card-image waves-effect waves-block waves-light">
                        <a href="http://cliserv.esy.es/es/{{$category[2]}}/{{$product[0]}}-{{$product[2]}}.html" target="_blank">
                            <img class="activator" src="http://cliserv.esy.es/{{$image}}-home_default/{{$product[2]}}.jpg">
                        </a><br>
                    </div>
                    <div class="card-content">
                        <span class="card-title activator grey-text text-darken-4">{{$product[1]}}<i class="material-icons right">more_vert</i></span>
                        <p><a href="#">This is a link</a></p>
                    </div>
                    <div class="card-reveal">
                        <span class="card-title grey-text text-darken-4">{{$product[1]}}<i class="material-icons right">close</i></span>
                        <p>Click on X to show</p>
                    </div>
                    <div class="card-action">
                        <div class="center center-align">
                            <a href="http://cliserv.esy.es/es/{{$category[2]}}/{{$product[0]}}-{{$product[2]}}.html" target="_blank">
                                Visitar producto
                            </a>
                        </div>
                    </div>
                </div>
                <!--
                <div class="card blue-grey darken-1">
                    <div class="card-content white-text">
                        <span class="card-title yellow-text text-darken-2">{{$product[1]}}</span>
                    </div>
                    <div class="card-action">
                        <div class="center center-align">
                            <a href="http://cliserv.esy.es/es/{{$category[2]}}/{{$product[0]}}-{{$product[2]}}.html" target="_blank">
                                <img src="http://cliserv.esy.es/{{$image}}-home_default/{{$product[2]}}.jpg" class="responsive-img">
                            </a><br>

                            <a href="http://cliserv.esy.es/es/{{$category[2]}}/{{$product[0]}}-{{$product[2]}}.html" target="_blank">
                                Visitar producto
                            </a>
                        </div>
                    </div>
                </div>
                -->
            </div>

            <div class="col s12 m6">
                <div class="card blue-grey darken-1">
                    <div class="card-content white-text">
                        <span class="card-title yellow-text text-darken-2">{{$category[1]}}</span>
                    </div>
                    <div class="card-action">
                        <div class="center center-align">
                            <a href="http://cliserv.esy.es/es/{{$category[0]}}-{{$category[2]}}" target="_blank">
                                <img src="http://cliserv.esy.es/c/{{$category[0]}}-category_default/{{$category[2]}}.jpg" class="responsive-img">
                            </a><br>
                            <a href="http://cliserv.esy.es/es/{{$category[0]}}-{{$category[2]}}" target="_blank">
                                Visitar categoría
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="col s12 m6">
                <div class="card blue-grey darken-1">
                    <div class="card-content white-text">
                        <span class="card-title yellow-text text-darken-2">No existen datos!</span>
                    </div>
                    <div class="card-action">
                    </div>
                </div>
            </div>
            <div class="col s12 m6">
                <div class="card blue-grey darken-1">
                    <div class="card-content white-text">
                        <span class="card-title yellow-text text-darken-2">No existen datos!</span>
                    </div>
                    <div class="card-action">
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection
