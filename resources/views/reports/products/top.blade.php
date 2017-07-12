@extends('panel')

@section('title', 'Top de productos (%)')

@section('top-products','class="activated"')

@section('content')
    <div class="row">
        <form id="form">
            <div class="col s4">
                <div class="input-field">
                    <input type="date" class="datepicker" name="start_date" required>
                    <label>Fecha inicio</label>
                </div>
            </div>
            <div class="col s4">
                <div class="input-field">
                    <input type="date" class="datepicker" name="end_date" required>
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

        <div class="row">
            <div class="col s12">
                <div id="loading" class="center-align" style="display: none;">
                    <img src="{{ asset('img/loading.svg') }}" alt="Cargando">
                    <p>Cargando ...</p>
                </div>

                <table class="striped" id="productsTable">
                    <thead>
                    <tr>
                        <th>Producto</th>
                        <th># Clics</th>
                        <th>Porcentaje</th>
                    </tr>
                    </thead>
                    <tbody id="productsTop">

                    </tbody>
                </table>
            </div>
        </div>

        <div class="row">
            <div class="col s12">
                <canvas id="myChart"></canvas>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="//cdnjs.cloudflare.com/ajax/libs/Chart.js/2.4.0/Chart.min.js" />
    <script>
        var $loading, $productsTop, $productsTable;
        $(document).ready(function() {
            $loading = $('#loading');
            $productsTop = $('#productsTop');
            $productsTable = $('#productsTable');

            $('select').material_select();
            $('.datepicker').pickadate({
                selectMonths: false, // Creates a dropdown to control month
                selectYears: 3, // Creates a dropdown of 15 years to control year
                format: 'yyyy-mm-dd'
            });
            $('.tooltipped').tooltip();
        });

        $('#form').on('submit', function() {
            event.preventDefault();
            $loading.slideDown('slow');
            $productsTable.hide();

            var params = $(this).serialize();
            $.getJSON('/top/productos/data', params, function(data) {
                $loading.slideUp('slow');

                var htmlRows = '';
                var pairs = data.pairs;
                for (var i=0; i<pairs.length; ++i) {
                    htmlRows += '<tr>' +
                        '<td>'+pairs[i].product+'</td>' +
                        '<td>'+pairs[i].quantity+'</td>' +
                        '<td>'+pairs[i].percent+'</td>' +
                    '</tr>';
                }
                $productsTop.html(htmlRows);
                $productsTable.show();
                // console.log(data);
            });

            $.getJSON('/top/horas/data', params, function (data) {
                drawLineChart();
                console.log(data);
            });
        });

        function drawLineChart() {
            var ctx = document.getElementById('myChart').getContext('2d');

            new Chart(ctx, {
                type: 'line',

                data: {
                    labels: ["Lun", "Mar", "Mie", "Jue", "Vie", "Sáb", "Dom"],
                    datasets: [{
                        label: "Horas pico",
                        backgroundColor: 'rgb(255, 99, 132)',
                        borderColor: 'rgb(255, 99, 132)',
                        data: [14, 10, 5, 2, 20, 30, 45],
                    }]
                },

                options: {}
            });
        }
    </script>
@endsection