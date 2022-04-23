@extends('usuario.principa_usul')
@section('content')
<div class="alert text-center" role="alert" style="background-color:#1bf9cd;">
  <h3>Insignias Obtenidas</h3>
</div>
<br>

<div class="container-fluid">
  <div class="row" id="map_section">
    <div class="col-12">
      <form action="#" id="search-form">
      <table class="table table-success">
        <thead>
          <tr>
            <th scope="col">#</th>
            <th scope="col">Recompensa</th>
            <th scope="col">Insignia</th>
            <th scope="col">Puntos Acu.</th>
            <th scope="col">Fecha</th>
            <th scope="col">Opciones</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            @foreach($rec as $r)
            <th scope="row">{{$r->idre}}</th>
            <td>{{$r->nompre}}</td>
            <td>{{$r->insignia}}</td>
            <td> {{$r->pun_insig + $r->puncom }}</td>
            <td>{{$r->fecha}}</td>
            <td>
              <!-- Button trigger modal -->
              <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal{{$r->idre}}">
              <i class="icon-nav fas fa-eye"></i>
              </button>
              <!-- Modal -->
              <div class="modal fade" id="exampleModal{{$r->idre}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-xl">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="exampleModalLabel">Detalles Reconocimiento</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body">
                      <div class="container">
                        <div class="row">
                          <div class="col-6 col-md-4">
                            <div class="card" style="width: 18rem;">
                              <img src="/img/premios.png" class="card-img-top" alt="...">
                              <div class="card-body">
                                <h4>Premio adquirido</h4>
                                <p class="card-text">{{$r->nompre}} - {{$r->despre}} </p>
                                <p class="card-text">Puntos Obtenidos por premio: {{$r->punpre}}</p>
                              </div>
                            </div>
                          </div>
                          <div class="col-6 col-md-4">
                            <div class="card" style="width: 18rem;">
                              <img src="/img/insignia.jpg" class="card-img-top" alt="...">
                              <div class="card-body">
                                <h4>Insignia adquirida</h4>
                                <p class="card-text">{{$r->insignia}} - {{$r->desinsig}}</p>
                                <p class="card-text">Puntos Obtenidos por insignia: {{$r->pun_insig}}</p>
                              </div>
                            </div>
                          </div>
                          <div class="col-6 col-md-4">
                            <div class="card" style="width: 18rem;">
                              <img src="/img/insignia.jpg" class="card-img-top" alt="...">
                              <div class="card-body">
                                <h4>Reconocimiento</h4>
                                <p class="card-text">Comportamiento: {{$r->descom}} </p>
                                <p class="card-text">Puntos acumulados: {{$r->pun_insig + $r->puncom }}</p>
                                <p class="card-text">Fecha: {{$r->fecha}} </p>
                              </div>
                            </div>
                          </div>
                          <div class="col-6 col-md-12">
                            <h5>Reconocimiento ingresado por: {{$r->nomus}} {{$r->apeus}}</h5>
                          </div>
                        </div>
                      </div>
                      
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-warning" data-dismiss="modal">Aceptar</button>
                    </div>
                  </div>
                </div>
              </div>

            </td>
          </tr>
          
@endforeach
        </tbody>
      </table>
      </form>              
    </div>
  </div>
</div>



@endsection
