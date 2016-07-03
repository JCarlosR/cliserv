@extends('panel')

@section('title','Data mining')

@section('mining', 'class="activated"')

@section('main-content')
    <div class="row">
        <div class="col s12">
            <h5>Filtros por dimensión</h5>
        </div>
        <div class="col s12 m6 l2">
            <div class="card">
                <div class="card-content">
                    <span class="card-title">Producto</span>
                    <div class="row">
                        <div class="input-field col s12">
                            <select id="category_filter">

                            </select>
                            <label>Filtro por categoría</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col s12 m6 l4">
            <div class="card">
                <div class="card-content">
                    <span class="card-title">Cliente</span>
                    <div class="row">
                        <div class="input-field col s6">
                            <select>
                                <option value="" selected>Todos</option>
                                <option value="1">Hombre</option>
                                <option value="2">Mujer</option>
                                <option value="3">Desconocido</option>
                            </select>
                            <label>Filtro por género</label>
                        </div>
                        <div class="input-field col s6">
                            <select id="cbopaises">
                                <option value="0" selected>Todos</option>
                                @foreach($countries as $country)
                                <option value={{$country}}>{{$country}}</option>
                                @endforeach
                            </select>
                            <label>Filtro por país</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col s12 m6 l2">
            <div class="card">
                <div class="card-content">
                    <span class="card-title">Dispositivo</span>
                    <div class="row">
                        <div class="input-field col s12">
                            <select id="device_filter">
                                <option value="0" selected>Todos</option>
                                <option value="1">Desktop</option>
                                <option value="2">Mobile</option>
                            </select>
                            <label>Filtro por dispositivo</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col s12 m6 l4">
            <div class="card">
                <div class="card-content">
                    <span class="card-title">Fuente</span>
                    <div class="row">
                        <div class="input-field col s12">
                            <select id="source_filter">

                            </select>
                            <label>Fuente de visita</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col s12 m12">
            <div class="card">
                <div class="card-content">
                    <span class="card-title">Tiempo</span>
                    <div class="row">
                        <div class="input-field col s6">
                            <input id="start_hour" name="start_hour" type="number" min="0" max="23" class="validate" required>
                            <label for="start_hour">Hora de inicio</label>
                        </div>
                        <div class="input-field col s6">
                            <input id="end_hour" name="end_hour" type="number" min="0" max="23" class="validate" required>
                            <label for="end_hour">Hora de fin</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col s12">
                            <ul class="tabs">
                                <li class="tab col s3"><a class="active" href="#tab1">Año y mes</a></li>
                                <li class="tab col s3"><a href="#tab2">Rango</a></li>
                                <li class="tab col s3"><a href="#tab3">Días</a></li>
                            </ul>
                        </div>
                        <div id="tab1" class="col s12">
                            <div class="row">
                                <div class="input-field col s6">
                                    <select>
                                        <option value="" selected>Todos</option>
                                        <option value="1">2016</option>
                                        <option value="2">2017</option>
                                    </select>
                                    <label>Seleccione año</label>
                                </div>
                                <div class="input-field col s6">
                                    <select>
                                        <option value="" selected>Todos</option>
                                        <option value="1">Enero</option>
                                        <option value="2">Febrero</option>
                                    </select>
                                    <label>Seleccione mes</label>
                                </div>
                            </div>
                        </div>
                        <div id="tab2" class="col s12">
                            <div class="row">
                                <div class="input-field col s6">
                                    <input id="start_date" name="start_date" type="date" class="datepicker">
                                    <label for="start_date">Fecha de inicio</label>
                                </div>
                                <div class="input-field col s6">
                                    <input id="end_date" name="end_date" type="date" class="datepicker">
                                    <label for="end_date">Fecha de fin</label>
                                </div>
                            </div>
                        </div>
                        <div id="tab3" class="col s12">
                            <div class="input-field col s12">
                                <select id="day_filter">
                                    <option value="9" selected>Todos</option>
                                    <option value="1">Lunes</option>
                                    <option value="2">Martes</option>
                                    <option value="3">Miércoles</option>
                                    <option value="4">Jueves</option>
                                    <option value="5">Viernes</option>
                                    <option value="6">Sábado</option>
                                    <option value="0">Domingo</option>
                                    <option value="7">Entre semana</option>
                                    <option value="8">Fin de semana</option>
                                </select>
                                <label>Seleccione día(s)</label>
                            </div>
                        </div>
                    </div>


                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col s12">
            <h5>Presentación de datos</h5>
        </div>
        <div class="col s12 m6 l2">
            <div class="card">
                <div class="card-content">
                    <span class="card-title">Producto</span>
                    <p>
                        <input class="with-gap" type="radio" name="presentation" id="presentation_category" />
                        <label for="presentation_category">Categoría</label>
                    </p>
                    <p>
                        <input class="with-gap" type="radio" name="presentation" id="presentation_product" />
                        <label for="presentation_product">Producto</label>
                    </p>
                </div>
            </div>
        </div>
        <div class="col s12 m6 l2">
            <div class="card">
                <div class="card-content">
                    <span class="card-title">Cliente</span>
                    <p>
                        <input class="with-gap" type="radio" name="presentation" id="presentation_genre" />
                        <label for="presentation_genre">Género</label>
                    </p>
                    <p>
                        <input class="with-gap" type="radio" name="presentation" id="presentation_country" />
                        <label for="presentation_country">País</label>
                    </p>
                </div>
            </div>
        </div>
        <div class="col s12 m6 l2">
            <div class="card">
                <div class="card-content">
                    <span class="card-title">Dispositivo</span>
                    <p>
                        <input class="with-gap" type="radio" name="presentation" id="presentation_device" />
                        <label for="presentation_device">Tipo</label>
                    </p>
                </div>
            </div>
        </div>
        <div class="col s12 m6 l2">
            <div class="card">
                <div class="card-content">
                    <span class="card-title">Fuente</span>
                    <p>
                        <input class="with-gap" type="radio" name="presentation" id="presentation_origin" />
                        <label for="presentation_origin">Sitio web</label>
                    </p>
                </div>
            </div>
        </div>
        <div class="col s12 m6 l2">
            <div class="card">
                <div class="card-content">
                    <span class="card-title">Tiempo</span>
                    <p>
                        <input class="with-gap" type="radio" name="presentation" id="presentation_month" />
                        <label for="presentation_month">Mes</label>
                    </p>
                    <p>
                        <input class="with-gap" type="radio" name="presentation" id="presentation_day" />
                        <label for="presentation_day">Día</label>
                    </p>
                </div>
            </div>
        </div>
        <div class="col s12 m6 l2">
            <div class="card">
                <div class="card-content">
                    <span class="card-title">Generar</span>
                    <button class="btn waves-effect waves-light" type="button" name="action" id="btnGO">GO
                        <i class="material-icons right">send</i>
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('/js/data-mining.js') }}"></script>
@endsection
