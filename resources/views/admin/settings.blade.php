
@extends('usuario.principa_usul') 
@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
  <div class="container">
    <div class="row mb-2">
      <div class="col-sm-8">
        <h1 class="m-0">Configuración personalizada.</h1>
      </div>
      <!-- /.col -->
      <div class="col-sm-4">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="#">Inicio</a></li>
          <li class="breadcrumb-item active">Configuración</li>
        </ol>
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->
  </div>
  <!-- /.container-fluid -->
</div>
  <!---mensajes de alerta-->
  @if(Session::has('success'))
    <div class="alert alert-info alert-dismissible fade show letraform" role="alert">
    <strong>{{Session::get('success')}}</strong> 
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
    </div>
  @endif
  @if(Session::has('error'))
    <div class="alert alert-danger alert-dismissible fade show letraform" role="alert">
    <strong>{{Session::get('error')}}</strong> 
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
    </div>
  @endif 
  <!---end mesnajes de alert-->
<!-- /.content-header -->
<div class="container">
  <div class="row mb-2">
    <div class="col-12">

      <div class="card card-primary card-tabs">
        <div class="card-header p-0 pt-1">
          <ul class="nav nav-tabs" id="custom-tabs-two-tab" role="tablist">
           
            <li class="nav-item active">
              <a class="nav-link" id="custom-tabs-two-profile-tab" data-toggle="pill" href="#custom-tabs-two-profile" role="tab" aria-controls="custom-tabs-two-profile" aria-selected="false">Notificaciones</a>
            </li>
           
          </ul>
        </div>
        <div class="card-body">
          <div class="tab-content" id="custom-tabs-two-tabContent">

            <div class="tab-pane fade show active" id="custom-tabs-two-profile" role="tabpanel" aria-labelledby="custom-tabs-two-profile-tab">
              <div class="row">
              <div class="col-md-8 mb-3">
                  <h5>Crea una nueva configuración:
                  <!-- Button trigger modal -->
              <button type="button" class="btn btn-primary text-right " data-toggle="modal" data-target="#agregarevento">
                <i class="fas fa-plus"></i> Agregar
              </button></h5>

              <!-- Modal -->
              <div class="modal fade" id="agregarevento" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                  <div class="modal-content">
                    <div class="modal-header">
                    <h4 class="modal-title" style="color: #333333"> Agregar Nueva Configuración</h4>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <!---- formulario de antiguedad-->
                    <form action="{{route('register')}}" method="POST" enctype="multipart/form-data">
                      @csrf
                      <div class="modal-body">
                        <div class="form-row">
                          <div class="form-group col-md-12">
                            <label for="tipo">Tipo <i class="fas fa-info-circle" data-toggle="tooltip" data-placement="top" title="Seleccionar el tipo de configuración"></i></label>
                            <select class="form-control" id="tipo" name="tipo" required>
                                <option value="">Elegir ...</option>
                                <option value="1">Color</option> 
                                <option value="2">Logo externo</option>
                                <option value="3">Logo Interno</option>
                            </select>
                          </div>
                        </div>
                        <!--descrip-->
                        <div class="form-row tipo-campo" id="campoColor" style="display: none;">
                            <div class="form-group col-md-6">
                                <label for="key">Variable<i class="fas fa-info-circle" data-toggle="tooltip" data-placement="top" title="Agregar el nombre de la variable."></i></label> <!--tiempo de ingreso a la plataforma-->
                                <input type="text" class="form-control" id="key" name="key">
                            </div>
                            <div class="form-group col-md-6">
                             <label for="key">Color<i class="fas fa-info-circle" data-toggle="tooltip" data-placement="top" title="Agregar color."></i></label> <!--tiempo de ingreso a la plataforma-->
                            <div class="form-control">
                              <input type="color"  id="color" name="color">
                            </div>
                          </div>
                          <!--info-->
                            <a class="" data-toggle="collapse" href="#collapseInfo" role="button" aria-expanded="false" aria-controls="collapseExample">
                                Nota sobre variables.
                            </a>
                            <div class="collapse" id="collapseInfo">
                            <div class="card card-body">
                            <p>Nombres disponibles para crear una variable:</p>
                            <table border="1" cellpadding="8" cellspacing="0">
                            <tr>
                            <td>&nbsp; blue</td>
                            <td>&nbsp;white</td>
                            </tr>
                            <tr>
                            <td>&nbsp;indigo</td>
                            <td>&nbsp;gray</td>
                            </tr>
                            <tr>
                            <td>&nbsp;purple</td>
                            <td>&nbsp;gray-dark</td>
                            </tr>
                            <tr>
                            <td>&nbsp;pink</td>
                            <td>&nbsp;primary</td>
                            </tr>
                            <tr>
                            <td>&nbsp;red</td>
                            <td>&nbsp;secondary</td>
                            </tr>
                            <tr>
                            <td>&nbsp;orange</td>
                            <td>&nbsp;success</td>
                            </tr>
                            <tr>
                            <td>&nbsp;yellow</td>
                            <td>&nbsp;info</td>
                            </tr>
                            <tr>
                            <td>&nbsp;green</td>
                            <td>&nbsp;warning</td>
                            </tr>
                            <tr>
                            <td>&nbsp;teal</td>
                            <td>&nbsp;danger</td>
                            </tr>
                            <tr>
                            <td>&nbsp;cyan</td>
                            <td>&nbsp;light</td>
                            </tr>
                            <tr>
                            <td></td>
                            <td>&nbsp;dark</td>
                            </tr>
                            </table>
                            </div>
                            </div>
                          <!--end info-->
                        </div>
                        <!---end-->
                          <!--archivo-->
                          <div class="form-row" id="campoLogo" class="tipo-campo" style="display: none;">
                            <div class="form-group col-md-12">
                                <label for="key">Elegir Logo (dimensiones 220x50 px) <i class="fas fa-info-circle" data-toggle="tooltip" data-placement="top" title="Agregar logo o imagen."></i></label> <!--tiempo de ingreso a la plataforma-->
                                <input type="file" class="form-control" id="imagen" name="imagen" accept="image/*">
                            </div>
                        </div>
                        <!---end-->
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
              <!---boton de recargar-->
              <div class="col-md-4 mb-3">
                <a href="{{ route('updateConfig') }}" class="btn btn-outline-primary"><i class="fas fa-sync"></i> Actualizar</a>
              </div>
              <!---end boton-->
              
                <div class="col-md-3">
                  <label for="im">Tipo</label>
                </div>
                <div class="col-md-2">
                  <label for="desc">Variable</label>
                </div>
                <div class="col-md-2">
                  <label for="tim">Color</label>
                </div>
                <div class="col-md-3">
                  <label for="tim">Logo/Imagen</label>
                </div>
                <div class="col-md-2">
                  <label for="tim">Acción</label>
                </div>
              </div>
              @foreach($data as $dat)
              <div class="form-row mt-3">
                <div class="form-group col-md-3 form-control ">
                  @if($dat->tipo == 1)
                    <span>Color</span>
                  @elseif($dat->tipo == 2)
                    <span>Logo externo</span>
                  @else
                    <span>Logo interno </span>
                  @endif
                </div>
                <div class="form-group col-md-2">
                  <p class="form-control text-sm">
                    @if(!empty($dat->key))
                     <span>{{  $dat->key }}</span>
                    @else
                     <span>N/A</span>
                    @endif
                  </p>
                </div>
                <div class="form-group col-md-2">
                  <p class="form-control text-sm">
                    @if(!empty($dat->value))
                     <input type="color" value="{{ $dat->value }}" ><span>&nbsp;{{ $dat->value }}</span>
                    @else
                     <span>N/A</span>
                    @endif
                  </p>
                </div>
                <div class="form-group col-md-3">
                  <p class="form-control text-sm">
                    @if(!empty($dat->link))
                    <img src="{{ asset('dist/img/' .$dat->link) }}" class="img-thumbnail" alt="Cargando imagen ..." width="30%">
                    @else
                     <span> N/A</span>
                    @endif
                  </p>
                </div>
        
                <div class="form-group col-md-2">
              
                <!---modal para confirmacion-->
                <button type="button" class="btn btn-outline-danger btn-sm" data-toggle="modal" data-target="#deleteConfig{{ $dat->id }}">
                    <i class="fas fa-trash-alt"></i>
                </button>
               
                  <div class="modal fade" id="deleteConfig{{ $dat->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                            ¿Estás seguro de que deseas eliminar esta configuración?
                            </p>
                            </div>
                            <div class="modal-footer justify-content-between">
                              <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                              <form action="{{route('deleteConfig')}}" method="POST">
                                @csrf
                                <input type="hidden" value="{{ $dat->id }}" name="id" id="id{{ $dat->id }}">
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
          
          </div>
        </div>
        <!-- /.card -->
      </div>

      
    </div>
  </div>
</div>
<script src="{{ asset('js/color.js')}}"></script>
@endsection