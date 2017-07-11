@extends('panel')

@section('title', 'Top de productos (%)')

@section('top-products','class="activated"')

@section('content')
    <div class="row">
        <form id="form">
            <div class="col s5">
                <div class="input-field">
                    <select name="cboyear">
                        <option value="" disabled selected>Seleccionar Año</option>
                        <option value="1">Todos</option>
                        <option value="2017">2017</option>
                    </select>
                    <label>Fecha Año</label>
                </div>
            </div>
            <div class="col s5">
                <div class="input-field">
                    <select name="cbomonth">
                        <option value="" disabled selected>Seleccionar Mes</option>
                        <option value="0">Todos</option>
                        <option value="1">Enero</option>
                        <option value="2">Febrero</option>
                        <option value="3">Marzo</option>
                        <option value="4">Abril</option>
                        <option value="5">Mayo</option>
                        <option value="6">Junio</option>
                        <option value="7">Julio</option>
                        <option value="8">Agosto</option>
                        <option value="9">Setiembre</option>
                        <option value="10">Octubre</option>
                        <option value="11">Noviembre</option>
                        <option value="12">Diciembre</option>
                    </select>
                    <label>Fecha Mes</label>
                </div>
            </div>
            <div class="col s2">
                <button type="submit" class="waves-effect waves-light btn filter">Reporte</button>
            </div>
        </form>
        <br>
        <br>
        <div class="row">
            <div class="col s12">
                <div id="loading" class="center-align" style="display: none;">
                    <img src="{{ asset('img/loading.svg') }}" alt="Cargando">
                    <p>Cargando ...</p>
                </div>
                <canvas id="canvas" style="display: none;"></canvas>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            $('select').material_select();
        });

        $('#form').on('submit', function() {
            event.preventDefault();


            var params = $(this).serialize();
            $.getJSON('./clicks/products', params, function(data) {

            });
        });
    </script>

@endsection