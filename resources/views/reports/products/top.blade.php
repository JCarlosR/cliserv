@extends('panel')

@section('title', 'Top de productos (%)')

@section('top-products','class="activated"')

@section('content')
    <div class="row">
        <form id="form">
            <div class="col s6 m3">
                <div class="input-field">
                    <input type="date" class="datepicker" name="start_date" required>
                    <label>Fecha inicio</label>
                </div>
            </div>
            <div class="col s6 m3">
                <div class="input-field">
                    <input type="date" class="datepicker" name="end_date" required>
                    <label>Fecha fin</label>
                </div>
            </div>
            <div class="col s6 m2">
                <div class="row">
                    <div class="input-field col s12">
                        <input type="number" required min="1" name="top" class="tooltiped"
                            data-position="top" data-delay="20" data-tooltip="Nro de productos en el TOP">
                        <label for="top">TOP</label>
                    </div>
                </div>
            </div>
            <div class="col s6 m4">
                <button type="submit" class="waves-effect waves-light btn filter">Reporte</button>
                <button type="button" class="waves-effect waves-light btn filter" title="Exportar a Excel" id="btnToExcel">
                    <i class="material-icons">&#xE2C0;</i>
                </button>
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
    <script src="//cdnjs.cloudflare.com/ajax/libs/Chart.js/2.4.0/Chart.min.js"></script>
    <script src="/table-to-excel/index.js"></script>
    <script src="/reports/products/top.js"></script>
@endsection