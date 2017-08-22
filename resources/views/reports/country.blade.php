@extends('panel')

@section('title', 'Top por países')

@section('top-pais','class="activated"')

@section('content')
    <div class="row">
        <form id="form">
            <div class="row">
                <div class="col s12 m4">
                    <div class="input-field">
                        <input type="date" class="datepicker" name="start_date" required value="{{ $start }}">
                        <label>Fecha inicio</label>
                    </div>
                </div>
                <div class="col s12 m4">
                    <div class="input-field">
                        <input type="date" class="datepicker" name="end_date" required value="{{ $end }}">
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
                            @if (isset($start) && isset($end))
                                <td>{{ (clone $query)->where('country_code', $country)->where('user_id', '<>', 0)->count() }}</td>
                                <td>{{ (clone $query)->where('country_code', $country)->where('user_id', 0)->count() }}</td>
                            @endif
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </div>
@endsection

@section('scripts')
    <script>
        $('.datepicker').pickadate({
            selectMonths: false, // Creates a dropdown to control month
            selectYears: 3, // Creates a dropdown of 15 years to control year
            format: 'yyyy-mm-dd'
        });
    </script>
@endsection
