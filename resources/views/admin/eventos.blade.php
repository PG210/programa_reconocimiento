@extends('usuario.principa_usul') 
@section('content')
<style>
  .placa {
      background-color:#e0e0e0; /* Gris claro */
      border: 1px solid #dee2e6; /* Borde gris claro */
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Sombra */
      border-radius: 5px; /* Bordes redondeados (opcional) */
    }
  
    .buttonAct {
      background-color: transparent;
      color: var(--dark);
      border: 0;
      font-size: 0.8rem;
      padding: 0 !important;
      display: flow;
  }
  
</style>

<!-- Content Header (Page header) -->
<div class="content-header">
  <div class="container">
    <div class="row mb-2">
      <div class="col-sm-8">
        <h1 class="m-0">Celebraciones especiales</h1>
      </div>
      <!-- /.col -->
      <div class="col-sm-4">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="#">Inicio</a></li>
          <li class="breadcrumb-item active">Celebraciones especiales</li>
        </ol>
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->
  </div>
  <!-- /.container-fluid -->
</div>
<!-- /.content-header -->
<div class="container">
  <div class="row mb-2">
    <div class="col-12">
      <div class="card card-primary card-outline">
        <div class="card-body box-profile" style="display: flex; align-items: center; gap: 15px;">
          <p class="m-0">Selecciona si deseas mostrar los cumpleaños y quinquenios en la vista de usuario. </p>
     
          <div class="float-right custom-control custom-switch custom-switch-lg">
              <input type="checkbox" class="custom-control-input" id="customSwitch1" 
                  data-url="{{ route('activeCumple') }}" {{ isset($estado) && $estado->estado == 1 ? 'checked' : '' }}>
              <label class="custom-control-label" for="customSwitch1">Activar</label>
          </div>
        </div>
      </div>

      <div class="card card-primary card-tabs">
        <div class="card-header p-0 pt-1">
          <ul class="nav nav-tabs" id="custom-tabs-two-tab" role="tablist">
            <li class="pt-2 px-3">
              <h3 class="card-title">Mensajes:</h3></li>
            <li class="nav-item">
              <a class="nav-link active" id="custom-tabs-two-home-tab" data-toggle="pill" href="#custom-tabs-two-home" role="tab" aria-controls="custom-tabs-two-home" aria-selected="true">Cumpleaños</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" id="custom-tabs-two-profile-tab" data-toggle="pill" href="#custom-tabs-two-profile" role="tab" aria-controls="custom-tabs-two-profile" aria-selected="false">Antigüedad</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" id="custom-tabs-two-messages-tab" data-toggle="pill" href="#custom-tabs-two-messages" role="tab" aria-controls="custom-tabs-two-messages" aria-selected="false">Proximas celebraciones en: {{$monthName}} </a>
            </li>
          </ul>
        </div>
        <div class="card-body">
          <div class="tab-content" id="custom-tabs-two-tabContent">

            <div class="tab-pane fade show active" id="custom-tabs-two-home" role="tabpanel" aria-labelledby="custom-tabs-two-home-tab">
              <!--- formulario --->
              

                <form action="{{route('happybirthday')}}" method="POST" enctype="multipart/form-data">
                  @csrf
                  <div class="form-row">
                  <div class="form-group col-md-12"><h5>Crea un mensaje de cumpleaños:</h5></div>
                    <div class="form-group col-md-3">
                      <label for="file">1. Imagen (Default):</label> 
                      <p>Elige la imagen que aparecerá </p>
                      @if(isset($cumple->imagen))
                        <img src="{{ asset('dist/eventos/' . $cumple->imagen) }}" class="w-100 img-thumbnail" alt="..."> 
                      @endif
                      <input type="file" class="form-control" id="file" name="file" accept="image/*">
                    </div>
                    <div class="form-group col-md-9">
                      <label for="descrip">2. Descripción:</label> @if(isset($cumple->descrip))
                      <p>Escribe el mensaje que deseas mostrar en la notificación de cumpleaños. </p>
                      <textarea class="form-control text-sm" id="descrip" name="descrip" rows="7" required>{{$cumple->descrip}} </textarea> @endif
                    </div>
                  </div>
                  <button type="submit" class="btn btn-primary float-right"><i class="fas fa-save"></i> Guardar</button>
                </form>
                <!---end formulario-->
                <!--- datos de la db-->
            </div>

            <div class="tab-pane fade" id="custom-tabs-two-profile" role="tabpanel" aria-labelledby="custom-tabs-two-profile-tab">
              <div class="row">
              <div class="col-md-12">
                  <h5>Crea un mensaje de antigüedad:
                  <!-- Button trigger modal -->
              <button type="button" class="btn btn-primary text-right " data-toggle="modal" data-target="#agregarevento">
                <i class="fas fa-plus"></i> Agregar
              </button></h5>

              <!-- Modal -->
              <div class="modal fade" id="agregarevento" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                  <div class="modal-content">
                    <div class="modal-header">
                    <h4 class="modal-title" style="color: #333333"> Agregar Nuevo Mensaje de antigüedad</h4>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
                    </div>
                    <!---- formulario de antiguedad-->
                    <form action="{{route('antique')}}" method="POST" enctype="multipart/form-data">
                      @csrf
                      <div class="modal-body">
                        <div class="form-row">
                        
                          <div class="form-group col-md-6">
                            <label for="nom">Nombre</label>
                            <input type="text" class="form-control" id="nom" name="nom">
                          </div>
                          <div class="form-group col-md-6">
                            <label for="tem">Tiempo (años)</label>
                            <input type="number" class="form-control" id="tem" name="tem" min="1">
                          </div>
                        </div>
                        <div class="form-row">
                          <div class="form-group col-md-6">
                            <label for="imagen">Imagen</label>
                            <input type="file" class="form-control" id="imagen" name="imagen" accept="image/*">
                          </div>
                          <div class="form-group col-md-6">
                            <label for="des">Descripción</label>
                            <textarea type="text" class="form-control" id="des" name="des"></textarea>
                          </div>
                        </div>
                      </div>
                      <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default " data-dismiss="modal">Salir</button>
                        <button type="submit" class="btn btn-success">Adicionar</button>
                      </div>
                    </form>
                    <!-- end antiguedad-->
                  </div>
                </div>
              </div>
              <!---=============================--->
              </div>
                <div class="col-md-3">
                  <label for="im">Imagen</label>
                </div>
                <div class="col-md-6">
                  <label for="desc">Descripción</label>
                </div>
                <div class="col-md-2">
                  <label for="tim">Tiempo (Años)</label>
                </div>
                <div class="col-md-1">
                  <label for="del">Acción</label>
                </div>
              </div>
              @foreach($ant as $anti)
              <div class="form-row mt-2">
                <div class="form-group col-md-3">
                  <img src="{{ asset('dist/eventos/' . $anti->imagen) }}" class="img-thumbnail" alt="...">
                </div>
                <div class="form-group col-md-6">
                  <textarea class="form-control text-sm text-justify" rows="7">{{$anti->descrip}} </textarea>
                </div>
                <div class="form-group col-md-2">
                  <p class="form-control text-sm">{{$anti->tiempo}} </p>
                </div>
                <div class="form-group col-md-1">
                 
                  <!---modal para confirmacion-->
                  <button type="button" class="btn btn-outline-danger btn-sm" data-toggle="modal" data-target="#deleteIm{{ $anti->id }}">
                    <i class="fas fa-trash-alt"></i>
                  </button>
                  <div class="modal fade" id="deleteIm{{ $anti->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                      <div class="modal-dialog">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h5 class="modal-title" id="exampleModalLabel">Mensaje de confirmación</h5>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                              </button>
                            </div>
                            <div class="modal-body text-left">
                            <p>
                            ¿Estás seguro de que deseas eliminar este mensaje?
                            </p>
                            </div>
                            <div class="modal-footer justify-content-between">
                              <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                              <form action="{{route('deletevento')}}" method="POST">
                                @csrf
                                <input type="hidden" value="{{ $anti->id }}" name="idant" id="idant{{ $anti->id }}">
                                <button type="submit" class="btn btn-success">Eliminar</button>
                              </form>
                            </div>
                          </div>
                      </div>
                  </div>
                  <!--end modal confirmacion-->


                </div>
              </div>
              @endforeach
              <!--==================================-->
            </div>

            <div class="tab-pane fade" id="custom-tabs-two-messages" role="tabpanel" aria-labelledby="custom-tabs-two-messages-tab">
              <!--- colaboradores que cumplen años este mes -->
              @foreach($usuarios as $usu)
              <div class="user-panel pb-3 d-flex">
                <div class="image">
                  <img src="{{ asset('dist/imgperfil/' . $usu->imagen) }}" class="img-circle elevation-2" alt="User Image">
                </div>
                <div class="info">
                  <a type="button" class="d-block text-black" data-toggle="tooltip" data-html="true" title="
                  <div class='card bg-blue'>
                    <div class='card-body'>
                      <h6 class='card-text text-left'>Cargo: {{$usu->cargo}} </h6>
                      <h6 class='card-text text-left'>Area: {{$usu->area}}</h6>
                    </div>
                  </div>
                  ">
                    {{$usu->name}} {{$usu->apellido}} @if($usu->estado == 1) <i class="fas fa-birthday-cake" style="color: #FFD700;"></i> @endif
                  </a>
                          <span class="text-sm">
                    {{ \Carbon\Carbon::parse($usu->fecha_cumple ?? '')->isoFormat('dddd, D [de] MMMM') }}
                  </span>
                </div>
              </div>
              @endforeach
              <!---end iteracion-->
              <!--- iteracion para aniversarios -->
              @foreach($aniversario as $aniv)
              <div class="user-panel pb-3 d-flex">
                <div class="image">
                  <img src="{{ asset('dist/imgperfil/' . $aniv->imagen) }}" class="img-circle elevation-2" alt="User Image">
                </div>
                <div class="info">
                  <a type="button" class="d-block text-black" data-toggle="tooltip" data-html="true" title="
                      <div class='card bg-blue'>
                        <div class='card-body'>
                          <h6 class='card-text text-left'>Cargo: {{$aniv->cargo}} </h6>
                          <h6 class='card-text text-left'>Area: {{$aniv->area}}</h6>
                        </div>
                      </div>
                      ">
                    {{$aniv->name}} {{$aniv->apellido}} <i class="fas fa-gift" style="font-size: 24px; color: #ff0000;"></i> 
                    @if($datehoy < $aniv->fecha_aniversario)
                        {{$aniv->total_anios + 1}} Año(s) en la empresa.
                    @else
                        {{$aniv->total_anios}} Año(s) en la empresa.
                    @endif
                  </a>
                  <span class="text-sm">
                    {{ \Carbon\Carbon::parse($aniv->fecha_aniversario ?? '')->isoFormat('dddd, D [de] MMMM') }}
                  </span>
                  </div>
              </div>
              @endforeach
              <!--- end iteracion --->
            </div>
          
          </div>
        </div>
        <!-- /.card -->
      </div>

      
    </div>
  </div>
</div>

<script src="{{ asset('js/estado.js')}}"></script>
@endsection