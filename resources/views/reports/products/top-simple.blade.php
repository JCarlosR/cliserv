<!DOCTYPE html>
<html lang="es">
<head>
    <title>Top de productos - Click Stream</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="/css/materialize.min.css">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/styles.css') }}">
    <style>
    main { padding-left: 0; }
    </style>
</head>
<body>

<main>
    <div class="row teal lighten-2 white-text">
        <h4 class="center-align" id="title">Top de productos</h4>
    </div>
    <div class="container">
        <div class="row">
            <form id="form">
                <div class="col s12 m3">
                    <div class="input-field">
                        <input type="date" class="datepicker" name="start_date" required>
                        <label>Fecha inicio</label>
                    </div>
                </div>
                <div class="col s12 m3">
                    <div class="input-field">
                        <input type="date" class="datepicker" name="end_date" required>
                        <label>Fecha fin</label>
                    </div>
                </div>
                <div class="col s12 m2">
                    <div class="row">
                        <div class="input-field col s12">
                            <input type="number" required min="1" name="top" class="tooltiped"
                                data-position="top" data-delay="20" data-tooltip="Nro de productos en el TOP">
                            <label for="top">TOP</label>
                        </div>
                    </div>
                </div>
                <div class="col s12 m4">
                    <button type="submit" class="waves-effect waves-light btn filter">
                        Ver
                    </button>
                    <button type="button" class="waves-effect waves-light btn filter" title="Exportar a Excel" id="btnToExcel" disabled>
                        Exportar Excel
                    </button>
                    <button type="button" class="waves-effect waves-light btn filter" title="Exportar a PDF" id="btnToPdf" disabled>
                        Exportar PDF
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
    </div>
</main>

<script src="{{ asset('js/jquery.min.js') }}"></script>
<script src="/js/materialize.min.js"></script>

<script src="//cdnjs.cloudflare.com/ajax/libs/Chart.js/2.4.0/Chart.min.js"></script>
<script src="/reports/products/top.js"></script>

</body>
</html>