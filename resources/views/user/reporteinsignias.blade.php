@extends('usuario.principa_usul')
@section('content')
<div class="alert text-center" role="alert" style="background-color:#1bf9cd;">
  <h3>Reconocimientos Recibidos</h3>
</div>
<br>                 
   <div class="card-deck">
       @foreach($recibido as $c)
        <div class="card" style="width: 18rem;">
        <div class="card-body">
            <!--imagen-->
            <div class="user-panel mt-0 pb-0 mb-0 d-flex image">
                    
                      <img src="{{ asset('dist/img/avatar.png')}}" class="img-circle elevation-2" alt="User Image">
                      &nbsp;&nbsp;&nbsp;&nbsp;<h5 class="card-title">De:<b> {{$c->nombre}} {{$c->apellido}} </b></h5><br>
                   
             </div>
             <!---end imagen-->
            <hr>
            <img src="{{asset('imgpremios/'.$c->img)}}" class="card-img-top" alt="..."> 
            <h3>Te reconozco por: </h3>
            <p class="card-text">
                {{$c->nomcat}}
            </p>
            <hr>
            <h3>Detalle: </h3>
            <p class="card-text">
                {{$c->descat}}
            </p>
            <hr>
        </div>
        <ul class="list-group list-group-flush">
            
            <li class="list-group-item">Puntos: {{$c->puntos}}</li>
        </ul>
        <div class="card-body">
            <div class="row">
                <div class="col-6">
                
                </div>
                <div class="col-6">
                <!-- <button type="submit" class="btn" style="background-color:#08FFD5; float:right;">Enviar</button>-->
                {{$c->fecha}}
                </div>
           </div>
        </div>
        </div>
        @endforeach
      </div>
@endsection
