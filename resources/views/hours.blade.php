@extends('panel')

@section('title','Reporte por horas')

@section('hours','class="activated"')

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
        <div class="input-field col s4">
            <input id="start_date" name="start_date" type="date" class="datepicker">
            <label for="start_date">Fecha de inicio</label>
        </div>
        <div class="input-field col s4">
            <input id="start_hour" name="start_hour" type="number" min="0" max="23" class="validate" required>
            <label for="start_hour">Hora de inicio</label>
        </div>
        <div class="input-field col s4">
            <input id="end_hour" name="end_hour" type="number" min="0" max="23" class="validate" required>
            <label for="end_hour">Hora de fin</label>
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
        var DAY_NAMES = ["Day 0", "Day 1", "Day 2", "Day 3", "Day 4", "Day 5", "Day 6"];
        var USER_LABELS = ["Hombres", "Mujeres", "Unknown"];

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
                labels: DAY_NAMES,
                datasets: [{
                    label: USER_LABELS[0],
                    data: [], // [65, 59, 80, 81, 56, 55, 40],
                    fill: false,
                    borderDash: [5, 5]
                }, {
                    label: USER_LABELS[1],
                    data: [] // [45, 89, 20, 91, 26, 65, 30]
                }]
            },
            options: {
                title:{
                    display: true,
                    text: "REPORTE DE TRÁFICO POR HORAS"
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
                            labelString: 'Month'
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

            $('.datepicker').pickadate({
                selectMonths: true, // Creates a dropdown to control month
                selectYears: 15, // Creates a dropdown of 15 years to control year
                format: 'dd/mm/yyyy'
            });
        };

        $('#formReport').on('submit', function() {
            event.preventDefault();

            var start_date = $('#start_date').val();
            if (! start_date) {
                Materialize.toast('Ingrese una fecha de inicio', 4000);
                return;
            }

            $('#loading').show();
            $('#canvas').slideUp();

            var maleDataSet = {
                label: USER_LABELS[0],
                borderColor: randomColor(0.4),
                backgroundColor: randomColor(0.5),
                pointBorderColor: randomColor(0.7),
                pointBackgroundColor: randomColor(0.5),
                pointBorderWidth: 1,
                data: []
            };
            var femaleDataSet = {
                label: USER_LABELS[1],
                borderColor: randomColor(0.4),
                backgroundColor: randomColor(0.5),
                pointBorderColor: randomColor(0.7),
                pointBackgroundColor: randomColor(0.5),
                pointBorderWidth: 1,
                data: []
            };
            var unknownDataSet = {
                label: USER_LABELS[2],
                borderColor: randomColor(0.4),
                backgroundColor: randomColor(0.5),
                pointBorderColor: randomColor(0.7),
                pointBackgroundColor: randomColor(0.5),
                pointBorderWidth: 1,
                data: []
            };

            var params = $(this).serialize();

            $.getJSON('../clicks/hour', params, function(data) {
                $('#loading').hide();
                $('#canvas').slideDown();

                config.data.labels = data.days;

                config.data.datasets = [];

                maleDataSet.data = data.male;
                config.data.datasets.push(maleDataSet);

                femaleDataSet.data = data.female;
                config.data.datasets.push(femaleDataSet);

                unknownDataSet.data = data.unknown;
                config.data.datasets.push(unknownDataSet);

                window.myLine.update();
            });
        });
    </script>
@endsection