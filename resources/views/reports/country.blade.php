@extends('panel')

@section('title', 'Top por países')

@section('top-pais','class="activated"')

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
                    <button type="submit" class="waves-effect waves-light btn filter">Reporte</button>
                </div>
            </div>
        </form>

        <br>

        <div class="row">
            <div class="col s12">
                <table class="striped" id="productsTable">
                    <thead>
                    <tr>
                        <th>País</th>
                        <th>Interno</th>
                        <th>Externo</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($countries as $country)
                        <tr>
                            <td>{{ $country }}</td>
                            <td></td>
                            <td></td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </div>

@endsection
