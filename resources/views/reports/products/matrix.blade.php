@extends('panel')

@section('title', 'Matriz de horas pico')

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
            <div class="col s4">
                <button type="submit" class="waves-effect waves-light btn filter">Generar</button>
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
    <script src="/table-to-excel/index.js"></script>
    <script src="/reports/products/matrix.js"></script>
@endsection