@extends('usuario.principa_usul')
@section('content')

@if(Auth::user()->id_rol!=1) <!--Logeado como administrador-->
<div class="card-deck">
<div class="card" style=" border: 2px; border-radius: 25px; background-color:white;">
    <img src="{{ asset('imgcomportamiento/reco.jpg')}}" class="card-img-top img-fluid" alt="..." style="border-top-left-radius: 25px 25px; border-top-right-radius: 25px 25px;">
    <div class="card-body">
      <div class="container"><h5 class="card-title letra1" style="padding-left:2em;" ><b>Envia Reconocimientos</b></h5></div><br><br>
      <p class="card-text" style="text-align: center;"><a href="/reconocimientos/enviar" type="button" class="btn confirmar letraform">Ingresar</a></p>
    </div>
  </div>
  <div class="card" style=" border: 2px; border-radius: 25px; background-color:white;">
    <img src="{{ asset('imgcomportamiento/premio1.jpg')}}" class="card-img-top img-fluid" alt="..." style="border-top-left-radius: 25px 25px; border-top-right-radius: 25px 25px;">
    <div class="card-body">
    <div class="container"><h5 class="card-title letra1" style="padding-left:2em;" ><b>Gana Reconocimientos</b></h5></div><br><br>
      <p class="card-text" style="text-align: center;"><a href="/reporte/insignias" type="button" class="btn confirmar letraform">Ingresar</a></p>
    </div>
  </div>
  <div class="card" style=" border: 2px; border-radius: 25px; background-color:white;">
    <img src="{{ asset('imgcomportamiento/premio2.jpg')}}" class="card-img-top "  alt="..."  height="345px"; style="border-top-left-radius: 25px 25px; border-top-right-radius: 25px 25px;">
    <div class="card-body">
    <div class="container"><h5 class="card-title letra1" style="padding-left:5em;" ><b>Gana Insignias</b></h5></div><br><br>
      <p class="card-text" style="text-align: center;"><a href="/reconocimientos/listar" type="button" class="btn confirmar letraform">Ingresar</a></p>
    </div>
  </div>
</div>
@endif
@if(Auth::user()->id_rol==1) <!--Logeado como administrador-->
<div class="card-deck">
  <div class="card" style=" border: 2px; border-radius: 25px; background-color:white;">
    <img src="{{ asset('imgcomportamiento/trabajoequipo1.jpg')}}" class="card-img-top "  alt="..." style="border-top-left-radius: 25px 25px; border-top-right-radius: 25px 25px;">
    <div class="card-body">
      <p class="card-text letra1" style="text-align: center;">
      <b>Categorias</b><br><br>
      <a href="/Categorias/registro" type="button" class="btn confirmar letraform">Ingresar</a></p>
    </div>
  </div>
  <div class="card" style=" border: 2px; border-radius: 25px; background-color:white;">
    <img src="{{ asset('imgcomportamiento/premio3.jpg')}}" class="card-img-top img-fluid d-none d-sm-none d-md-block" alt="..."  style="height: 75%; border-top-left-radius: 25px 25px; border-top-right-radius: 25px 25px;">
    <img src="{{ asset('imgcomportamiento/premio3.jpg')}}" class="card-img-top img-fluid d-block d-sm-block d-md-none" alt="..."  style="border-top-left-radius: 25px 25px; border-top-right-radius: 25px 25px;">
    <div class="card-body">
      <p class="card-text letra1" style="text-align: center;">
      <b>Insignias</b><br><br>
       <a href="/registro/insignias" type="button" class="btn confirmar letraform">Ingresar</a></p>
    </div>
  </div>
  <div class="card" style=" border: 2px; border-radius: 25px; background-color:white;">
    <img src="{{ asset('imgcomportamiento/empresa.jpg')}}" class="card-img-top img-fluid" style="border-top-left-radius: 25px 25px; border-top-right-radius: 25px 25px;">
    <div class="card-body">
      <p class="card-text letra1" style="text-align: center;">
       <b>Empresa</b><br><br>
      <a href="/areas/empresa" type="button" class="btn confirmar letraform">Ingresar</a></p>
    </div>
  </div>
</div>
@endif
@endsection