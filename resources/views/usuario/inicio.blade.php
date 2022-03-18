@extends('usuario.principa_usul')
@section('content')
<div class="card-deck">
  <div class="card">
    <img src="{{ asset('imgcomportamiento/img3.png')}}" class="card-img-top "  alt="..."  height="345px";>
    <div class="card-body">
      <h2 class="card-title"><b>Gana Insignias</b></h2>
      <p class="card-text">This is a longer card with supporting text below as a natural lead-in to additional</p>
      <p class="card-text"><button type="button" class="btn btn-primary">Ingresar</button></p>
    </div>
  </div>
  <div class="card">
    <img src="{{ asset('imgcomportamiento/img4.jpg')}}" class="card-img-top img-fluid" alt="..." >
    <div class="card-body">
      <h5 class="card-title"><b>Envia Reconocimientos</b></h5>
      <p class="card-text">This card has supporting text below as a natural lead-in to additional content.</p>
      <p class="card-text"><button type="button" class="btn btn-primary">Ingresar</button></p>
    </div>
  </div>
  <div class="card">
    <img src="{{ asset('imgcomportamiento/img2.jpg')}}" class="card-img-top img-fluid" alt="...">
    <div class="card-body">
      <h5 class="card-title"><b>Gana Reconocimientos</b></h5>
      <p class="card-text">This is a wider card with supporting text below as a natural lead-in to </p>
      <p class="card-text"><button type="button" class="btn btn-primary">Ingresar</button></p>
    </div>
  </div>
</div>
@endsection