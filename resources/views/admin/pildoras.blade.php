@extends('usuario.principa_usul') 
@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
  <div class="container">
    <div class="row mb-2">
      <div class="col-sm-8">
        <h1 class="m-0">Pildoras de Reconocimiento.</h1>
      </div>
      <!-- /.col -->
      <div class="col-sm-4">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="#">Inicio</a></li>
          <li class="breadcrumb-item active">Pildoras</li>
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
              <div class="col-md-12 mb-3">
                  <h5>Crea una nueva pildora:
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
                    <form action="{{route('newpildora')}}" method="POST">
                      @csrf
                      <div class="modal-body">
                        <div class="form-row">
                        
                          <div class="form-group col-md-6">
                            <label for="tipo">Asunto <i class="fas fa-info-circle" data-toggle="tooltip" data-placement="top" title="Asunto de la pildora de reconocimiento."></i></label>
                            <textarea class="form-control" id="asunto" name="asunto" rows="4" required></textarea>
                          </div>
                          <div class="form-group col-md-6">
                            <label for="tem">Link <i class="fas fa-info-circle" data-toggle="tooltip" data-placement="top" title="Agregar link a un blog, video, etc"></i></label> <!--tiempo de ingreso a la plataforma-->
                            <textarea class="form-control" id="link" name="link" rows="4" required></textarea>
                          </div>
                        </div>
                        <!--descrip-->
                        <div class="form-row">
                            <div class="col-md-12">
                             <label for="des">Descripción <i class="fas fa-info-circle" data-toggle="tooltip" data-placement="top" title="Describa el mensaje a enviar"></i></label>
                             <textarea name="descrip" id="descrip" rows="8" class="form-control">
                                {{ old('descrip') }}
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
                  <label for="im">Asunto</label>
                </div>
                <div class="col-md-3">
                  <label for="desc">Link</label>
                </div>
                <div class="col-md-4">
                  <label for="tim">Descripción</label>
                </div>
                <div class="col-md-2">
                  <label for="tim">Acción</label>
                </div>
              </div>
              @foreach($data as $dat)
              <div class="form-row mt-2">
                <div class="form-group col-md-3 form-control">
                  {!! $dat->asunto !!}
                </div>
                <div class="form-group col-md-3">
                  <p class="form-control text-sm">
                
                    <span>{{  $dat->link }}</span>
  
                  </p>
                </div>
                <div class="col-md-4">
                <div class="form-group form-control">
                  {!! $dat->descrip !!}
                </div>
                </div>
                <div class="form-group col-md-2">
              
                <!---modal para confirmacion-->
                <button type="button" class="btn btn-outline-danger btn-sm" data-toggle="modal" data-target="#deleteMen{{ $dat->id }}">
                    <i class="fas fa-trash-alt"></i>
                </button>
                <!--modal update-->
                <button type="button" class="btn btn-outline-info btn-sm" data-toggle="modal" data-target="#updatePildora{{ $dat->id }}">
                    <i class="fas fa-pencil-alt"></i>
                </button>
                 <!---modal update-->
                 <div class="modal fade" id="updatePildora{{ $dat->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                      <div class="modal-dialog modal-lg">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h5 class="modal-title" id="exampleModalLabel">Actualizar Datos</h5>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                              </button>
                            </div>
                            <form action="{{route('updatePildora')}}" method="POST">
                            @csrf
                            <div class="modal-body text-left">
                                <input type="hidden" value="{{ $dat->id }}" name="idup" id="id{{ $dat->id }}">
                                <div class="form-row">                 
                                  <div class="form-group col-md-6">
                                    <label for="tipo">Asunto <i class="fas fa-info-circle" data-toggle="tooltip" data-placement="top" title="Asunto de la pildora de reconocimiento."></i></label>
                                    <textarea class="form-control" id="asuntoup" name="asuntoup" rows="4" required>
                                        {{ $dat->asunto }}
                                    </textarea>
                                  </div>
                                  <div class="form-group col-md-6">
                                    <label for="tem">Link <i class="fas fa-info-circle" data-toggle="tooltip" data-placement="top" title="Agregar link a un blog, video, etc"></i></label> <!--tiempo de ingreso a la plataforma-->
                                    <textarea class="form-control" id="linkup" name="linkup" rows="4" required>
                                        {{ $dat->link }}
                                    </textarea>
                                  </div>
                                </div>
                                <!--descrip-->
                                <div class="form-row">
                                    <div class="col-md-12">
                                    <label for="des">Descripción <i class="fas fa-info-circle" data-toggle="tooltip" data-placement="top" title="Describa el mensaje a enviar"></i></label>
                                    <textarea name="descripup" id="descripup{{ $dat->id }}" rows="8" class="form-control">
                                        {!! $dat->descrip !!}
                                    </textarea>
                                    </div>
                                </div>
                                <!---end-->
                            </div>
                            <div class="modal-footer justify-content-between">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                                <button type="submit" class="btn btn-success">Guardar</button>
                            </div>
                            </form>
                          </div>
                      </div>
                  </div>
                 <!--end modal update-->
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
                            ¿Estás seguro de que deseas eliminar esta pildora?
                            </p>
                            </div>
                            <div class="modal-footer justify-content-between">
                              <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                              <form action="{{route('deletePildora')}}" method="POST">
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

<script src="https://cdn.ckeditor.com/4.22.1/standard/ckeditor.js"></script>
<script>
    CKEDITOR.replace('descrip');
    let datos = @JSON($data);
    if (Array.isArray(datos) && datos.length > 0) {
    const ids = datos.map(item => item.id);
    ids.forEach(id => {
      CKEDITOR.replace('descripup'+id);
    });
  }
</script>

@endsection