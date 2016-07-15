@extends('panel')

@section('title',"CLICKSTREAM'S REPORTS")

@section('content')
    <div class="container">
        <div class="row">
            <div class="col s8 offset-s2" style="font-size: 28px;">
                <b>Gestión de metas</b>
            </div>
        </div>
        <div class="row">
            <div class="col s6 offset-s3">
                <form id="form" method="post" action="">
                    <div class="row">
                        <div class="input-field col s8">
                            <i class="material-icons prefix">grade</i>
                            <input type="text" name="grade" id="grade">
                            <label for="icon_prefix">Meta</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s8">
                            <i class="material-icons prefix">phone</i>
                            <input type="text" name="phone" id="phone">
                            <label for="icon_telephone">Móvil</label>
                        </div>
                    </div>
                    <div class="row col s8">
                        <button class="btn waves-effect waves-light" type="submit" id="send">Modificar
                            <i class="material-icons right">send</i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
        <div class="col s6 offset-s3">
            <div class="card blue-grey darken-1">
                <div class="card-content white-text">
                    <span class="card-title yellow-text text-darken-2">Meta según tendencia!</span>
                </div>
                <div class="card-action" id="metas">
                    <div class="center center-align">
                        <h4>Meta: {{$meta}}</h4>
                        <h4>Meta: {{$celular}}</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script src="{{asset('js/metas.js')}}"></script>
@endsection