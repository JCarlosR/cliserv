<!DOCTYPE html>
<html lang="es">
<head>
    <title>Matriz de horas pico - Click Stream</title>
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
                <div class="col s4">
                    <button type="submit" class="waves-effect waves-light btn filter">Generar</button>
                    <button type="button" class="waves-effect waves-light btn filter" title="Exportar a Excel" id="btnToExcel" disabled>
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

    </div>
</main>

<script src="{{ asset('js/jquery.min.js') }}"></script>
<script src="/js/materialize.min.js"></script>

<script src="/table-to-excel/index.js"></script>
<script src="/reports/products/matrix.js"></script>

</body>
</html>
