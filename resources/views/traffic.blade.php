@extends('panel')

@section('title','Reporte tráfico')

@section('other','class="activated"')

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
        <div class="col s12">
            <canvas id="canvas"></canvas>
            <progress id="animationProgress" max="1" value="0"></progress>
        </div>
        <br>
        <br>
        <div class="col s12">
            <button id="showByDevice">Ver por dispositivo</button>
            <button id="showByUsers">Ver por tipo de usuario</button>
        </div>
        <div class="col s12">
            <button id="randomizeData">Randomizar Datos</button>
            <button id="removeDataset">Remove Dataset</button>
            <button id="addData">Add Data</button>
            <button id="removeData">Remove Data</button>
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
        var ALLMONTHS = ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Setiembre", "October", "Noviembre", "Diciembre"];
        var FIRSTMONTHS = ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio"];
        var USER_LABELS = ["Usuarios", "No usuarios"];
        var DEVICE_LABELS = ["Desktop", "Mobile"];

        // Random color
        var randomColorFactor = function() {
            return Math.round(Math.random() * 255);
        };
        var randomColor = function(opacity) {
            return 'rgba(' + randomColorFactor() + ',' + randomColorFactor() + ',' + randomColorFactor() + ',' + (opacity || '.3') + ')';
        };

        var $progress = $('#animationProgress');

        var config = {
            type: 'line',
            data: {
                labels: FIRSTMONTHS,
                datasets: [{
                    label: USER_LABELS[0],
                    data: [],
                    fill: false,
                    borderDash: [5, 5]
                }, {
                    label: USER_LABELS[1],
                    data: []
                }]
            },
            options: {
                title:{
                    display: true,
                    text: "REPORTE DE TRÁFICO DE VISITAS"
                },
                animation: {
                    duration: 2000,
                    onProgress: function(animation) {
                        $progress.attr({
                            value: animation.animationObject.currentStep / animation.animationObject.numSteps
                        });
                    },
                    onComplete: function(animation) {
                        window.setTimeout(function() {
                            $progress.attr({
                                value: 0
                            });
                        }, 2000);
                    }
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
        };

        $('#randomizeData').click(function() {
            $.each(config.data.datasets, function(i, dataset) {
                dataset.data = dataset.data.map(function() {
                    return randomScalingFactor();
                });

            });

            window.myLine.update();
        });

        $('#showByDevice').click(function() {
            config.data.datasets = [];

            var desktopDataSet = {
                label: DEVICE_LABELS[0],
                borderColor: randomColor(0.4),
                backgroundColor: randomColor(0.5),
                pointBorderColor: randomColor(0.7),
                pointBackgroundColor: randomColor(0.5),
                pointBorderWidth: 1,
                data: []
            };
            var mobileDataSet = {
                label: DEVICE_LABELS[1],
                borderColor: randomColor(0.4),
                backgroundColor: randomColor(0.5),
                pointBorderColor: randomColor(0.7),
                pointBackgroundColor: randomColor(0.5),
                pointBorderWidth: 1,
                data: []
            };

            $.getJSON('../clicks/device_type', function(data) {
                desktopDataSet.data = data.desktop;
                config.data.datasets.push(desktopDataSet);

                mobileDataSet.data = data.mobile;
                config.data.datasets.push(mobileDataSet);

                window.myLine.update();
            });
        });

        $('#showByUsers').click(function() {
            config.data.datasets = [];

            var userDataSet = {
                label: USER_LABELS[0],
                borderColor: randomColor(0.4),
                backgroundColor: randomColor(0.5),
                pointBorderColor: randomColor(0.7),
                pointBackgroundColor: randomColor(0.5),
                pointBorderWidth: 1,
                data: []
            };
            var visitorDataSet = {
                label: USER_LABELS[1],
                borderColor: randomColor(0.4),
                backgroundColor: randomColor(0.5),
                pointBorderColor: randomColor(0.7),
                pointBackgroundColor: randomColor(0.5),
                pointBorderWidth: 1,
                data: []
            };

            $.getJSON('../clicks/user', function(data) {
                userDataSet.data = data.users;
                config.data.datasets.push(userDataSet);

                visitorDataSet.data = data.visitors;
                config.data.datasets.push(visitorDataSet);

                window.myLine.update();
            });
        });


        $('#removeDataset').click(function() {
            config.data.datasets.splice(0, 1);
            window.myLine.update();
        });

        $('#addData').click(function() {
            if (config.data.datasets.length > 0) {
                var month = ALLMONTHS[config.data.labels.length % ALLMONTHS.length];
                config.data.labels.push(month);

                $.each(config.data.datasets, function(i, dataset) {
                    dataset.data.push(randomScalingFactor());
                });

                window.myLine.update();
            }
        });

        $('#removeData').click(function() {
            config.data.labels.splice(-1, 1); // remove the label first

            config.data.datasets.forEach(function(dataset, datasetIndex) {
                dataset.data.pop();
            });

            window.myLine.update();
        });
    </script>
@endsection