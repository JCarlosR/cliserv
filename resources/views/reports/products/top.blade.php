@extends('panel')

@section('title', 'Top de productos (%)')

@section('top-products','class="activated"')

@section('content')
    <div class="row">
        <form id="form">
            <div class="col s4">
                <div class="input-field">
                    <input type="date" class="datepicker" name="start_date">
                    <label>Fecha inicio</label>
                </div>
            </div>
            <div class="col s4">
                <div class="input-field">
                    <input type="date" class="datepicker" name="end_date">
                    <label>Fecha fin</label>
                </div>
            </div>
            <div class="col s2">
                <div class="row">
                    <div class="input-field col s12">
                        <input type="number" required min="1" name="top" class="tooltiped"
                            data-position="top" data-delay="20" data-tooltip="Nro de productos en el TOP">
                        <label for="top">TOP</label>
                    </div>
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
            $('.datepicker').pickadate({
                selectMonths: true, // Creates a dropdown to control month
                selectYears: 5 // Creates a dropdown of 15 years to control year
            });
            $('.tooltipped').tooltip();
        });

        $('#form').on('submit', function() {
            event.preventDefault();

            var params = $(this).serialize();
            $.getJSON('/top/productos/data', params, function(data) {
                console.log(data);
            });
        });
    </script>
@endsection