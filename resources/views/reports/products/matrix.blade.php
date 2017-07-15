@extends('panel')

@section('title', 'Top de productos (%)')

@section('top-products','class="activated"')

@section('content')
    <div class="row">
        <form id="form">
            <div class="col s5">
                <div class="input-field">
                    <input type="date" class="datepicker" name="start_date" required>
                    <label>Fecha inicio</label>
                </div>
            </div>
            <div class="col s5">
                <div class="input-field">
                    <input type="date" class="datepicker" name="end_date" required>
                    <label>Fecha fin</label>
                </div>
            </div>
            <div class="col s2">
                <button type="submit" class="waves-effect waves-light btn filter">Generar</button>
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
                        <th>Hora</th>
                        <th>Domingo</th>
                        <th>Lunes</th>
                        <th>Martes</th>
                        <th>Miércoles</th>
                        <th>Jueves</th>
                        <th>Viernes</th>
                        <th>Sábado</th>
                    </tr>
                    </thead>
                    <tbody id="productsTop">

                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        var $loading, $productsTop, $productsTable;
        $(document).ready(function() {
            $loading = $('#loading');
            $productsTop = $('#productsTop');
            $productsTable = $('#productsTable');

            // $('select').material_select();
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

            $.getJSON('/top/horas/matriz', params, function (mt) {
                $loading.slideUp('slow');

                var htmlRows = '';
                // iterate the days for each hour interval
                for (var h=0; h<24; ++h) { // 24 hours
                    htmlRows += '<tr>' +
                        '<td>'+h+' - '+(h+1)+'</td>';
                    for (var d=0; d<7; ++d) // 7 days
                        htmlRows += '<td>'+mt[d][h].q+' ('+mt[d][h].p+' %)</td>';

                    htmlRows += '</tr>';
                }

                $productsTop.html(htmlRows);
                $productsTable.show();
            });
        });
    </script>
@endsection