@extends('usuario.principa_usul')
@section('content')
<!--####################################-->

<!-- Content Header (Page header) -->
<div class="content-header">
	<div class="container">
		<div class="row mb-2">
			<div class="col-sm-8">
				<h1 class="m-0">Tu Perfil</h1>
			</div>
			<!-- /.col -->
			<div class="col-sm-4">
				<ol class="breadcrumb float-sm-right">
					<li class="breadcrumb-item"><a href="#">Inicio</a></li>
					<li class="breadcrumb-item active">Perfil</li>
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
  <div class="row">
    <div class="col-md-3">
    <!-- Profile Image -->
    <div class="card card-primary card-outline">
                    <div class="card-body box-profile">
                        <div class="text-center">
                            @if(Auth::user()->imagen)
                            <img src="{{asset('dist/imgperfil/'.$dat[0]->imagen)}}"
                                class="profile-user-img img-fluid img-circle" alt="User profile picture"> @endif
                        </div>
                        <h3 class="profile-username text-center">{{ Auth::user()->name }} {{ Auth::user()->apellido }}</h3>
                        <p class="text-muted text-center">Cargo: {{ Auth::user()->cargo->nombre }} </p>
                        <ul class="list-group list-group-unbordered mb-3">
                          <p class="text-muted text-center">Estado: <span class="badge bg-success">{{$dat[0]->descrip}}</span> </p>
                        </ul>

                        <!--modal-->
                        <!-- Button trigger modal -->
                          <a type="button" class="btn btn-primary w-100" data-toggle="modal" data-target="#modalPerfil">
                            <i class="fas fa-user-edit"></i>&nbsp; Editar
                          </a>
                          <!-- Modal -->
                          <div class="modal fade" id="modalPerfil" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg modal-dialog-scrollable">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <div style="flex-direction: column;">
                                    <h5 class="modal-title" id="exampleModalLabel">¡Actualiza tu Información!</h5>
                                    <span>Completa este formulario y mantén tus datos siempre al día. 😊</span>
                                  </div>
                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                      <span aria-hidden="true">×</span>
                                    </button>
                                </div>
                                
                                  <!---formulario-->
                                <form action="{{route('datosper')}}" method="POST" enctype="multipart/form-data" class="letraform">
                                <div class="modal-body pt-2 pb-0">
                                    @csrf
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                          <label for="inputEmail4">Nombre</label>
                                          <input type="text" class="form-control" id="inputEmail4" name="nombre" value="{{$dat[0]->name}}">
                                        </div>
                                        <div class="form-group col-md-6">
                                          <label for="inputPassword4">Apellido</label>
                                          <input type="text" class="form-control" id="inputPassword4"  name="apellido" value="{{$dat[0]->apellido}}">
                                        </div>
                                      </div>
                                      <div class="form-row">
                                        <div class="form-group col-md-6">
                                          <label for="inputEmail4">Dirección</label>
                                          <input type="text" class="form-control" id="inputEmail4"name="direccion" value="{{$dat[0]->direccion}}">
                                        </div>
                                        <div class="form-group col-md-6">
                                          <label for="inputPassword4">Celular</label>
                                          <input type="text" class="form-control" id="inputPassword4" name="telf"  value="{{$dat[0]->telefono}}">
                                        </div>
                                      </div>
                                      <!--fechas--->
                                      <div class="form-row">
                                          <div class="form-group col-md-6">
                                            <label for="inputfechan">Fecha de nacimiento</label>
                                            <input type="date" class="form-control" id="inputfechan" name="inputfechan" value="{{$dat[0]->fecna}}">
                                          </div>
                                          <div class="form-group col-md-6">
                                            <label for="inputfechanv">Fecha de ingreso a la empresa</label>
                                            <input type="date" class="form-control" id="inputfechanv" name="inputfechanv" value="{{$dat[0]->fecingreso}}">
                                          </div>
                                        </div>
                                      <!---end fechas--->
                                      <div class="form-row">
                                      <div class="form-group col-md-6">
                                        <label for="inputAddress">Email</label>
                                        <input type="email" class="form-control" id="inputAddress" name="correo"  value="{{$dat[0]->email}}">
                                        </div>
                                        <div class="form-group col-md-6">
                                        <label for="inputAddress">Contraseña</label>
                                        <input type="password" class="form-control" id="inputAddress" name="pass" placeholder="***************">
                                        </div>
                                      </div>
                                      <div class="form-row"> 
                                        <div class="form-group col-md-12">
                                        <label for="exampleFormControlFile1">Seleccionar imagen de perfil</label>
                                        <input type="file" class="form-control" id="img" name="img" accept="image/*">
                                        <div id="error-message" class="text-danger mt-3"></div>
                                        </div>
                                      </div>
                                      <div class="row">
                                          <div class="col-md-6">
                                            <br>
                                          <input type="text" class="form-control" id="inputCity" name="id"   value="{{$dat[0]->id}}" hidden>
                                          </div>
                                          <div class="col-md-6">
                                            
                                          </div>
                                      </div>
                                </div>
                                <div class="modal-footer justify-content-between">
                                  <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                                  <button type="submit" class="btn btn-primary"><i class="fas fa-user-edit"></i>&nbsp; Actualizar</button>
                                </div>
                                </form>
                              </div>
                            </div>
                          </div>
                      <!--end modal -->
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
    </div>
    <div class="col-md-9">
        <!---row-->
        <div class="row">
             <div class="col-12">
             @if(Session::has('mensaje'))
             <div id="toastsContainerTopRight" class="toasts-top-right fixed">
              <div class="toast bg-success fade show " role="alert" aria-live="assertive" aria-atomic="true">
                <div class="toast-header px-2 py-4">
                  <i class="mr-2 fas fa-envelope fa-lg"></i>
                  <strong class="mr-auto">{{Session::get('mensaje')}}</strong>
                  <small></small>
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">×</span>
                  </button>
                </div>
              </div>
             </div>
              @endif
             </div>
        </div>
        <!--end row-->

        

        <!-- Profile Image -->
        <div class="card card-primary card-outline">
            <div class="card-body box-profile perfil-ok">
              <div class="form-row">
                  <div class="form-group col-md-6">
                  <label for="inputEmail4">Nombre</label>
                  <input type="text" class="form-control" id="inputEmail4" readonly="readonly" value="{{$dat[0]->name}}">
                </div>
                <div class="form-group col-md-6">
                  <label for="inputPassword4">Apellido</label>
                  <input type="text" class="form-control" id="inputPassword4"  readonly="readonly" value="{{$dat[0]->apellido}}">
                </div>
              </div>
              <div class="form-row">
                <div class="form-group col-md-6">
                  <label for="inputEmail4">Dirección</label>
                  <input type="text" class="form-control" id="inputEmail4" readonly="readonly" value="{{$dat[0]->direccion}}">
                </div>
                <div class="form-group col-md-6">
                  <label for="inputPassword4">Teléfono</label>
                  <input type="text" class="form-control" id="inputPassword4"  readonly="readonly" value="{{$dat[0]->telefono}}">
                </div>
              </div>
              <div class="form-group">
                <label for="inputAddress">Email</label>
                <input type="email" class="form-control" id="inputAddress"  readonly="readonly" value="{{$dat[0]->email}}">
              </div>
              <!---fechas -->
              <div class="form-row">
                <div class="form-group col-md-6">
                  <label for="inputfechan">Fecha de nacimiento</label>
                  <input type="date" class="form-control" id="inputfechan" readonly="readonly" value="{{$dat[0]->fecna}}">
                </div>
                <div class="form-group col-md-6">
                  <label for="inputfechanv">Fecha de ingreso a la empresa</label>
                  <input type="date" class="form-control" id="inputfechanv"  readonly="readonly" value="{{$dat[0]->fecingreso}}">
                </div>
              </div>
              <!--- end fechas-->
              <div class="form-row">
                <div class="form-group col-md-6">
                  <label for="inputCity">Cargo</label>
                  <input type="text" class="form-control" id="inputCity"  readonly="readonly" value="{{$dat[0]->nombre}}">
                </div>
                <div class="form-group col-md-6">
                  <label for="inputCity">Rol</label>
                  <input type="text" class="form-control" id="inputCity"   readonly="readonly" value="{{$dat[0]->descripcion}}">
                </div>
              </div>
              <div class="form-row">
                <div class="form-group col-md-12">
                  <label for="inputCity">Estado</label>
                  <input type="text" class="form-control" id="inputCity"  readonly="readonly" value="{{$dat[0]->descrip}}">
                </div>
              </div>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>
  </div>
</div>
   
<!---##################################3-->

  
@endsection