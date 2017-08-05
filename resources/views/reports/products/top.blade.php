@extends('panel')

@section('title', 'Top de productos (%)')

@section('top-products','class="activated"')

@section('content')
    <div class="row">
        <form id="form">
            <div class="row">
                <div class="col s12 m4">
                    <div class="input-field">
                        <input type="date" class="datepicker" name="start_date" required>
                        <label>Fecha inicio</label>
                    </div>
                </div>
                <div class="col s12 m4">
                    <div class="input-field">
                        <input type="date" class="datepicker" name="end_date" required>
                        <label>Fecha fin</label>
                    </div>
                </div>
                <div class="col s12 m4">
                    <div class="row">
                        <div class="input-field col s12">
                            <input type="number" required min="1" name="top" class="tooltiped"
                                   data-position="top" data-delay="20" data-tooltip="Nro de productos en el TOP">
                            <label for="top">TOP</label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col s12 m12">
                    <button type="submit" class="waves-effect waves-light btn filter">Reporte</button>
                    <button type="button" class="waves-effect waves-light btn filter" title="Exportar a Excel" id="btnToExcel" disabled>
                        <i class="material-icons">&#xE2C0;</i> Excel
                    </button>
                    <button type="button" class="waves-effect waves-light btn filter" title="Exportar a PDF" id="btnToPdf" disabled>
                        <i class="material-icons">&#xE2C0;</i> PDF
                    </button>
                </div>
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

    <div id="modalSource" class="modal bottom-sheet">
        <div class="modal-content">
            <h4>Fuente de las visitas</h4>
            <p>De los <span id="spanTotal"></span> clics seleccionados:</p>
            <ul>
                <li><span id="spanMobile"></span> provienen desde dispositivos móviles.</li>
                <li><span id="spanDesktop"></span> provienen desde computadoras de escritorio.</li>
            </ul>
        </div>
        <div class="modal-footer">
            <a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat">Agree</a>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="//cdnjs.cloudflare.com/ajax/libs/Chart.js/2.4.0/Chart.min.js"></script>
    <script src="/reports/products/top.js"></script>
    <script>
        var $total, $mobile, $desktop;
        $(function () {
            $total = $('#spanTotal');
            $mobile = $('#spanMobile');
            $desktop = $('#spanDesktop');
        });
        $(document).on('click', '[data-desktop]', function () {
            var total = $(this).text();
            var mobile = $(this).data('mobile');
            var desktop = $(this).data('desktop');
            $total.text(total);
            $mobile.text(mobile);
            $desktop.text(desktop);
            $('#modalSource').modal('open');
        });
    </script>
@endsection