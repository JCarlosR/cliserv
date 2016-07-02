@extends('panel')

@section('title','Top de Productos')

@section('products','class="activated"')

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
        <form action="" id="formFecha">
            <div class="input-field col s5">
                <select name="cboyear">
                    <option value="" disabled selected>Seleccionar Año</option>
                    <option value="1">Todos</option>
                    <option value="2016">2016</option>
                    <option value="2015">2015</option>
                    <option value="2014">2014</option>
                </select>
                <label>Fecha Año</label>
            </div>
            <div class="input-field col s5 offset-s1">
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
            <div class="col s12">
                <button type="submit">Generar reporte</button>
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
    <script src="{{ asset('chartjs/Chart.bundle.js') }}"></script>

    <script>
        $(document).ready(function() {
            $('select').material_select();
        });

        var randomScalingFactor = function() {
            return (Math.random() > 0.5 ? 1.0 : -1.0) * Math.round(Math.random() * 100);
        };

        var ALLPRODUCTS = ["PRO 1", "PRO 2","PRO 3","PRO 4","PRO 5","PRO 6","PRO 7","PRO 8","PRO 9","PRO 10"];
        var FIRSTPRODUCTS = ["PRO 1", "PRO 2","PRO 3","PRO 4","PRO 5","PRO 6"];
        var ALLMONTHS = ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Setiembre", "October", "Noviembre", "Diciembre"];
        var LEGEND_ELEMENTS = "VISITAS";
        var DATAVALUES = [randomScalingFactor(), randomScalingFactor(), randomScalingFactor(), randomScalingFactor(), randomScalingFactor(), randomScalingFactor()];

        var randomColorFactor = function() {
            return Math.round(Math.random() * 255);
        };
        var randomColor = function() {
            return 'rgba(' + randomColorFactor() + ',' + randomColorFactor() + ',' + randomColorFactor() + ',.7)';
        };

        var barChartData = {
            labels: FIRSTPRODUCTS,
            datasets: [{
                label: LEGEND_ELEMENTS,
                backgroundColor: randomColor(),
                data: DATAVALUES
            }]

        };

        window.onload = function() {
            var ctx = document.getElementById("canvas").getContext("2d");
            window.myBar = new Chart(ctx, {
                type: 'bar',
                data: barChartData,
                options: {
                    // Elements options apply to all of the options unless overridden in a dataset
                    // In this case, we are setting the border of each bar to be 2px wide and green

                    responsive: true,
                    legend: {
                        position: 'right',
                    },
                    title: {
                        display: true,
                        text: 'Reporte Top Productos'
                    },
                    scales: {
                        xAxes: [{
                            scaleLabel: {
                                show: true,
                                labelString: 'Productos'
                            }
                        }],
                        yAxes: [{
                            scaleLabel: {
                                show: true,
                                labelString: 'Cantidad'
                            },
                            ticks: {
                                suggestedMin: 0 // minimum will be 0, unless there is a lower value.
                            }
                        }]
                    }
                }
            });

        };


        $('#formFecha').on('submit', function() {
            event.preventDefault();

            $('#loading').show();
            $('#canvas').slideUp();

            var countDataSet = {
                label: LEGEND_ELEMENTS,
                borderColor: randomColor(0.4),
                backgroundColor: randomColor(0.5),
                pointBorderColor: randomColor(0.7),
                pointBackgroundColor: randomColor(0.5),
                pointBorderWidth: 1,
                data: []
            };
            var params = $(this).serialize();
            $.getJSON('./clicks/products', params, function(data) {
                $('#loading').hide();
                $('#canvas').slideDown();
                barChartData.labels = data.products;
                barChartData.datasets = [];
                countDataSet.data = data.quantity;//data.quantity;
                barChartData.datasets.push(countDataSet);
                window.myBar.update();
            });
        });
    </script>

@endsection