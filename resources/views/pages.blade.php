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
        <div class="col col s10 offset-s1">
            <form action="" id="formReport">
                <div class="col s5">
                    <div class="input-field">
                        <select id="anual" name="anual">
                            <option value="0">Todos</option>
                            @foreach( $years as $year )
                                <option value="{{$year}}">{{$year}}</option>
                            @endforeach
                        </select>
                        <label>Selecione el año:</label>
                    </div>
                </div>
                <div class="col s5">
                    <div class="input-field">
                        <select id="meses" name="meses">
                            <option value="0">Todos</option>
                        </select>
                        <label>Selecione el mes:</label>
                    </div>
                </div>
                <div class="col s2">
                    <button type="submit" class="waves-effect waves-light btn filter">Reporte</button>
                </div>
            </form>
        </div>
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

            $('#anual').material_select();
            $('#meses').material_select();
            loadMonths();
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

        function loadMonths()
        {
            $('#anual').change(  function(){
                $year = $(this).val();

                $.getJSON('../month_year/'+$year, function(data)
                {
                    $('#meses').html('');
                    $.each(data.name,function(key,value)
                    {
                        $("#meses").append(" <option value='" + convert_month_number(value)+"'>" + value + "</option> ");
                    });
                    $('#meses').material_select()
                });
            });
        }

        function convert_month_number($month_name )
        {
            switch( $month_name ) {
                case 'Enero':      return 1;
                case 'Febrero':    return 2;
                case 'Marzo':      return 3;
                case 'Abril':      return 4;
                case 'Mayo':       return 5;
                case  'Junio':     return 6;
                case  'Julio':     return 7;
                case  'Agosto':    return 8;
                case  'Setiembre': return 9;
                case 'Octubre':    return 10;
                case  'Noviembre': return 11;
                case 'Diciembre':  return 12;
            }
        }
    </script>
@endsection

