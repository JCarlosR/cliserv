@extends('panel')

@section('title', 'Categorías más visitadas')

@section('categories', 'class="activated"')

@section('content')
    <div class="row">
        <div class="col col s10 offset-s1">
            <form action="{{ url('data_bar')  }}" method="GET" class="form-horizontal form-label-left">
                <div class="col s5">
                    <div class="input-field">
                        <select name="anio" id="anio">
                            <option value="0">Todos</option>
                            @foreach( $years as $year )
                                <option value="{{ $year  }}">{{ $year  }}</option>
                            @endforeach
                        </select>
                        <label>Año</label>
                    </div>
                </div>

                <div class="col s5">
                    <div class="input-field">
                        <select name="mes" id="mes">
                            <option value="0">Todos</option>
                        </select>
                        <label>Mes</label>
                    </div>
                </div>

                <div class="col s2">
                    <button class="waves-effect waves-light btn filter" id="graficar">Generar reporte</button>
                </div>
            </form>
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
    </div>
@endsection


@section('scripts')

    <script src="{{ asset('chartjs/Chart.js') }}"></script>
    <script src="{{ asset('js/barGraphic.js') }}"></script>

    <script type="text/javascript">
        $(document).ready(function() {
            $('#anio').material_select();
            $('#mes').material_select();
        });
    </script>
@endsection