@extends('panel')

@section('title','Reporte de fuentes de visitas')

@section('pages','class="activated"')

@section('style')
    <style>
        canvas {
            -moz-user-select: none;
            -webkit-user-select: none;
            -ms-user-select: none;
        }
    </style>
@endsection

@section('content')
    <div class="row">
        <form action="" id="formReport">
            <div class="input-field col s6">
                <select name="anual">
                    <option value="" disabled selected>Escoja una opción</option>
                    <option value="2014">2014</option>
                    <option value="2015">2015</option>
                    <option value="2016">2016</option>
                </select>
                <label>Selecione el año:</label>
            </div>
            <div class="input-field col s6">
                <select name="meses">
                    <option value="" disabled selected>Escoja una opción</option>
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
                <label>Selecione el mes:</label>
            </div>
            <div class="col s12">
                <button type="submit">Generar reporte</button>
            </div>
        </form>
    </div>
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
@endsection

@section('scripts')
    <script src="{{ asset('chartjs/Chart.bundle.js') }}"></script>

    <script>
        var randomScalingFactor = function() {
            return Math.round(Math.random() * 100);
        };

        // Variables
        var PAGE_NAMES = ["Page 0", "Page 1", "Page 2", "Page 3", "Page 4", "Page 5", "Page 6"];
        var USER_LABELS = ["Páginas"];

        // Random color
        var randomColorFactor = function() {
            return Math.round(Math.random() * 255);
        };
        var randomColor = function(opacity) {
            return 'rgba(' + randomColorFactor() + ',' + randomColorFactor() + ',' + randomColorFactor() + ',' + (opacity || '.3') + ')';
        };

        var config = {
            type: 'bar',
            data: {
                labels: PAGE_NAMES,
                datasets: [{
                    label: USER_LABELS[0],
                    data: [], // [65, 59, 80, 81, 56, 55, 40],
                    fill: false,
                    borderDash: [5, 5]
                }]
            },
            options: {
                title:{
                    display: true,
                    text: "REPORTE DE FUENTES DE VISITAS"
                },
                animation: {
                    duration: 2000
                },
                tooltips: {
                    mode: 'label'
                },
                scales: {
                    xAxes: [{
                        scaleLabel: {
                            show: true,
                            labelString: 'Pages'
                        }
                    }],
                    yAxes: [{
                        scaleLabel: {
                            show: true,
                            labelString: 'Value'
                        },
                        ticks: {
                            suggestedMin: 0 // minimum will be 0, unless there is a lower value.
                        }
                    }]
                }
            }
        };

        $.each(config.data.datasets, function(i, dataset) {
            dataset.borderColor = randomColor(0.4);
            dataset.backgroundColor = randomColor(0.5);
            dataset.pointBorderColor = randomColor(0.7);
            dataset.pointBackgroundColor = randomColor(0.5);
            dataset.pointBorderWidth = 1;
        });

        window.onload = function() {
            var ctx = document.getElementById("canvas").getContext("2d");
            window.myLine = new Chart(ctx, config);

            $(document).ready(function() {
                $('select').material_select();
            });
        };

        $('#formReport').on('submit', function() {
            event.preventDefault();

            $('#loading').show();
            $('#canvas').slideUp();

            var pageDataSet = {
                label: USER_LABELS[0],
                borderColor: randomColor(0.4),
                backgroundColor: randomColor(0.5),
                pointBorderColor: randomColor(0.7),
                pointBackgroundColor: randomColor(0.5),
                pointBorderWidth: 1,
                data: []
            };

            var params = $(this).serialize();

            $.getJSON('../clicks/page', params, function(data) {
                $('#loading').hide();
                $('#canvas').slideDown();

                config.data.labels = data.dom;

                config.data.datasets = [];

                pageDataSet.data = data.quantity;
                config.data.datasets.push(pageDataSet);

                window.myLine.update();
            });
        });
    </script>
@endsection