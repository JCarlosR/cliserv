@extends('panel')

@section('title', 'El producto y categoría más visitados')

@section('tendencia', 'class="activated"')

@section('content')
    <div class="row">
        @if(isset($product))
            <div class="col s12 m6">
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
                            <button class="waves-effect waves-light btn filter" id="product">Detalles</button>
                        </div>
                    </div>
                </div>
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
                            <button class="waves-effect waves-light btn filter" id="category">Detalles</button>
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

    <div id="modal" class="modal fade in">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Detalle de visitas</h4>
                </div>
                <table class="table table-stripped">
                    <thead>
                        <tr>
                            <th>Usuario</th>
                            <th>Ubicación</th>
                            <th>Género</th>
                            <th>Email</th>
                            <th>Visitas</th>
                        </tr>
                    </thead>
                    <tbody id="data">

                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('js/product_category_details.js') }} "></script>
@endsection