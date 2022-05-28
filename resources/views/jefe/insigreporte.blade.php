@extends('usuario.principa_usul')
@section('content')
<style>
    img.zoom {
        width: 50px;
        height: 50px;
        -webkit-transition: all .2s ease-in-out;
        -moz-transition: all .2s ease-in-out;
        -o-transition: all .2s ease-in-out;
        -ms-transition: all .2s ease-in-out;
    }
    
    .transition {
        -webkit-transform: scale(3.0); 
        -moz-transform: scale(3.0);
        -o-transform: scale(3.0);
        transform: scale(3.0);
    }
</style>
<!--###################################-->
<div class="container" style="background-color:#1ED5F4; padding-top:10px;  padding-bottom:10px;">
<div class="row">
    <div class="col-12 text-center">
     <h5>Listado De Insignias A Obtener</h5>
    </div>
</div>
</div>
<br>
<div class="table-responsive">
<table class="table table-bordered">
  <thead>
    <tr style="background-color:#FFBD03;">
      <th scope="col">No</th>
      <th scope="col">Nombre</th>
      <th scope="col">Nivel</th>
      <th scope="col">Categoria</th>
      <th scope="col">Puntos</th>
      <th scope="col">Insignia</th>
      <th scope="col">Descripcion</th>
      <th scope="col">Recomepensa</th>
    </tr>
  </thead>
  <tbody><!---idinsig -->
   <?php
    $conta=1;
   ?>
   @if($b==1)
    @foreach($coninsig as $c)
    <tr>
      <th scope="row">{{$conta++}}</th>
      <td>{{$c->name}}</td>
      <td>{{$c->descripcion}}</td>
      <td>{{$c->catdescrip}}</td>
      <td>{{$c->puntos}}</td>
      <td> 
          <div class="text-center">
                    <img src="{{asset('imgpremios/'.$c->imginsig)}}" class="rounded zoom" alt="..."  width= "50px" height="50px" >
          </div>
      </td>
      <td>{{$c->despremio}}</td>
      <td>
          <div class="text-center">
                    <img src="{{asset('imgpremios/'.$c->imgpre)}}" class="rounded zoom" alt="..."  width= "50px" height="50px" >
          </div>     
      </td>
    </tr>
   @endforeach
   @endif
  </tbody>
</table>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
    <script>
    $(document).ready(function(){
        $('.zoom').hover(function() {
            $(this).addClass('transition');
        }, function() {
            $(this).removeClass('transition');
        });
    });
    </script>
@endsection