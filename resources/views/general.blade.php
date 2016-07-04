@extends('panel')

@section('title', 'Reporte general')

@section('content')
    <div class="row">
        <div class="col l12">
            <div class="col s12 m12 l10 offset-l1 center-align">
                <form id='form' action="{{ url('/general') }}" method="GET">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                    <div class="col s12 m6 l5">
                        <div class="col s6 m6 l6 fecha">
                            <span class="in-bold">Fecha inicial:</span>
                        </div>
                        <div class="col s6 m6 l6">
                            <input type="date" id="finicio" name="finicio" class="datepicker">
                        </div>
                    </div>
                    <div class="col s12 m6 l5">
                        <div class="col s6 m6 l6 fecha">
                            <span class="in-bold">Fecha final:</span>
                        </div>
                        <div class="col s6 m6 l6">
                            <input type="date" id="ffinal" name="ffinal" class="datepicker">
                        </div>
                    </div>
                    <div class="col s12 m12 l2 center-align">
                        <button class="waves-effect waves-light btn filter">Reporte</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<div class="row data">
    @if( isset($clicks))
        @foreach($clicks as $click)
            <div class="col s12 m6">
                <div class="card blue-grey darken-1">
                    <div class="card-content white-text">
                        <span class="card-title yellow-text text-darken-2">{{ $click->user_name }}</span>
                        <div class="card-action">
                            <p>Producto: {{ $click->product->name }}</p>
                            <p>Dispositivo: {{ $click->dispositivo }}</p>
                            <p>Procedencia: {{ $click->country.'-'.$click->city }}</p>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
        {!! $clicks->render() !!}
    @else
        <div class="col s12 m6">
            <div class="card blue-grey darken-1">
                <div class="card-content white-text">
                    <span class="card-title yellow-text text-darken-2">No existen datos!</span>
                    <div class="card-action">
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection


@section('scripts')
    <script type="text/javascript" src="{{ asset('js/tabla.js') }}"></script>
@endsection
