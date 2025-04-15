@extends('usuario.principa_usul') 
@section('content')


<!-- Content Header (Page header) -->
<div class="content-header">
  <div class="container">
    <div class="row mb-2">
      <div class="col-sm-8">
        <h1 class="m-0">Recordatorios de ingreso y reconocimiento.</h1>
      </div>
      <!-- /.col -->
      <div class="col-sm-4">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="#">Inicio</a></li>
          <li class="breadcrumb-item active">Notificaciones</li>
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
      <!--
      <div class="card card-primary card-outline">
        <div class="card-body box-profile" style="display: flex; align-items: center; gap: 15px;">
        <p class="m-0">Activa esta opción para enviar notificaciones automáticas de ingreso y reconocimientos.</p>
          <div class="float-right custom-control custom-switch custom-switch-lg">
             
          </div>
        </div>
      </div>--->

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
              <div class="col-md-12 mb-3">
                  <h5>Crea un mensaje de notificación:
                  <!-- Button trigger modal -->
              <button type="button" class="btn btn-primary text-right " data-toggle="modal" data-target="#agregarevento">
                <i class="fas fa-plus"></i> Agregar
              </button></h5>

              <!-- Modal -->
              <div class="modal fade" id="agregarevento" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                  <div class="modal-content">
                    <div class="modal-header">
                    <h4 class="modal-title" style="color: #333333"> Agregar Nuevo Mensaje</h4>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <!---- formulario de antiguedad-->
                    <form action="{{route('recordatorio')}}" method="POST">
                      @csrf
                      <div class="modal-body">
                        <div class="form-row">
                        
                          <div class="form-group col-md-6">
                            <label for="tipo">Tipo <i class="fas fa-info-circle" data-toggle="tooltip" data-placement="top" title="Seleccionar el tipo de mensaje"></i></label>
                            <select class="form-control" id="tipo" name="tipo" required>
                                <option value="">Elegir ...</option>
                                <option value="1">Inactividad en la plataforma</option> 
                                <option value="2">Uso de la plataforma</option>
                                <option value="3">Notificación para votar</option>
                            </select>
                          </div>
                          <div class="form-group col-md-6">
                            <label for="tem">Tiempo o frecuencia (dias) <i class="fas fa-info-circle" data-toggle="tooltip" data-placement="top" title="Número de días sin acceso a la plataforma o sin enviar reconocimientos"></i></label> <!--tiempo de ingreso a la plataforma-->
                            <select class="form-control" id="tem" name="tem" required>
                                <option value="">Elegir ...</option>
                                <option value="5">5</option>
                                <option value="7">7</option>
                                <option value="15">15</option>
                                <option value="20">20</option>
                                <option value="30">30</option>
                            </select>
                          </div>
                        </div>
                        <div class="form-row">
                          <div class="form-group col-md-6">
                            <label for="dias">Día <i class="fas fa-info-circle" data-toggle="tooltip" data-placement="top" title="Día de la semana en que se envía el mensaje"></i></label>
                            <select class="form-control" id="dia" name="dia" required>
                                <option value="">Elegir ...</option>
                                <option value="1">Lunes</option>
                                <option value="2">Martes</option>
                                <option value="3">Miercoles</option>
                                <option value="4">Jueves</option>
                                <option value="5">Viernes</option>
                            </select>
                          </div>
                          <div class="form-group col-md-6">
                            <label for="horas">Hora <i class="fas fa-info-circle" data-toggle="tooltip" data-placement="top" title="Hora del día en que se envía el mensaje"></i></label>
                            <input type="time" name="hora" id="hora" class="form-control" required>
                          </div>
                        </div>
                        <!--descrip-->
                        <div class="form-row">
                            <div class="col-md-12">
                             <label for="des">Descripción <i class="fas fa-info-circle" data-toggle="tooltip" data-placement="top" title="Describa el mensaje a enviar"></i></label>
                             <textarea name="contenido" id="contenido" rows="10" class="form-control">
                                {{ old('contenido') }}
                            </textarea>
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
              
                <div class="col-md-3">
                  <label for="im">Tipo</label>
                </div>
                <div class="col-md-4">
                  <label for="desc">Descripción</label>
                </div>
                <div class="col-md-2">
                  <label for="tim">Tiempo (Días)</label>
                </div>
                <div class="col-md-2">
                  <label for="tim">Dia y hora</label>
                </div>
                <div class="col-md-1">
                  <label for="del">Acción</label>
                </div>
              </div>
              @foreach($data as $dat)
              <div class="form-row mt-2">
                <div class="form-group col-md-3">
                  @if($dat->tipo == 1)
                    <p>Inactividad en la plataforma</p>
                  @elseif($dat->tipo == 2)
                    <p>Uso de la plataforma</p>
                  @elseif($dat->tipo == 3)
                    <p>Notificación para votar</p>
                  @endif
                </div>
                <div class="form-group col-md-4 form-control">
                  {!! $dat->contenido !!}
                </div>
                <div class="form-group col-md-2">
                  <p class="form-control text-sm">
                
                    <span>{{  $dat->tiempo }}</span>
  
                  </p>
                </div>
                <div class="form-group col-md-2">
                  <p class="form-control text-sm">
                  
                  @if($dat->dia == 1)
                     <span>Lunes</span> 
                  @elseif( $dat->dia == 2 )
                     <span>Martes</span>
                  @elseif( $dat->dia == 3 )
                     <span>Miércoles</span>
                  @elseif( $dat->dia == 4 )
                      <span>Jueves</span>
                  @elseif( $dat->dia == 5 )
                      <span>Viernes</span>
                  @endif
                  <span> - {{ \Carbon\Carbon::createFromFormat('H:i:s', $dat->hora)->format('g:i A') }} </span>
                  </p>
                </div>
                <div class="form-group col-md-1">
                <div class="float-right custom-control custom-switch custom-switch-lg">
                    <input type="checkbox" class="custom-control-input chekmensaje" id="chekmensaje{{ $dat->id }}" data-id="{{ $dat->id }}"
                        {{  $dat->activo == 1 ? 'checked' : '' }}>
                    <label class="custom-control-label" for="chekmensaje{{ $dat->id }}"></label>
                </div>
                <!---modal para confirmacion-->
                <button type="button" class="btn btn-outline-danger btn-sm" data-toggle="modal" data-target="#deleteMen{{ $dat->id }}">
                    <i class="fas fa-trash-alt"></i>
                </button>

                  <div class="modal fade" id="deleteMen{{ $dat->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                              <form action="{{route('deleteMensaje')}}" method="POST">
                                @csrf
                                <input type="hidden" value="{{ $dat->id }}" name="idmen" id="idmen{{ $dat->id }}">
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

<script src="{{ asset('js/mensaje.js')}}"></script>
<script src="https://cdn.ckeditor.com/4.22.1/standard/ckeditor.js"></script>
<script>
    CKEDITOR.replace('contenido');
</script>

@endsection