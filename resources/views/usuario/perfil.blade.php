@extends('usuario.principa_usul')
@section('content')
<!--####################################-->
    <div class="accordion" id="accordionExample" style="overflow-y: hidden;">
      <div class="card">
        <div class="card-header" id="headingOne">
          <div class="row">
           <div class="col-md-9">
            <h2 class="mb-0 letraform" style="color:black;">
              <button class="btn btn-block text-left " type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
              <i class="fas fa-address-card" style="font-size:25px;"></i>&nbsp;PERFIL DE USUARIO
              </button>
            </h2>
           </div>
           <div class="col-md-3 letraform">
             <!--modal-->
             <!-- Button trigger modal -->
                <a type="button" class="btn btn-info btn-sm float-right" data-toggle="modal" data-target="#modalPerfil">
                   <i class="fas fa-user-edit"></i>&nbsp; Editar
                </a>
                <!-- Modal -->
                <div class="modal fade" id="modalPerfil" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                  <div class="modal-dialog modal-lg modal-dialog-scrollable">
                    <div class="modal-content">
                      <div class="modal-header" style="background-color:#f1f3f3;">
                        <div class="row">
                          <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                            <h5 class="modal-title" id="exampleModalLabel">Información del usuario.</h5>
                          </div>
                          <div class="col-lg-12 col-md-12 col-sm-12 col-12 mt-2">
                             <span >Utilice el siguiente formulario para actualizar su información personal.</span>
                          </div>
                         </div>
                      </div>
                         <!---formulario-->
                      <form action="{{route('datosper')}}" method="POST" enctype="multipart/form-data" class="letraform mt-3">
                      <div class="modal-body">
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
                            <div class="form-group col-md-4">
                              <label for="inputAddress">Email</label>
                              <input type="email" class="form-control" id="inputAddress" name="correo"  value="{{$dat[0]->email}}">
                              </div>
                              <div class="form-group col-md-4">
                              <label for="inputAddress">Contraseña</label>
                              <input type="password" class="form-control" id="inputAddress" name="pass" placeholder="***************">
                              </div>
                              <div class="form-group col-md-4">
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
                      <div class="modal-footer">
                        <button type="button" class="btn btn-warning" data-dismiss="modal">Salir</button>
                        <button type="submit" class="btn btn-info">Actualizar</button>
                      </div>
                      </form>
                    </div>
                  </div>
                </div>
             <!--end modal -->
           </div>
        </div>
          <!---row-->
           <div class="row">
             <div class="col-12">
             @if(Session::has('mensaje'))
                  <div class="alert alert-info alert-dismissible fade show text-left mt-2" role="alert">
                  <strong>{{Session::get('mensaje')}}</strong> 
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                  </button>
                  </div>
              @endif
             </div>
           </div>
          <!--end row-->
        </div>
        <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionExample">
          <div class="card-body letraform">

          <!--############################vista perfil-->
          <figure class="figure" >
              <img src="{{asset('dist/imgperfil/'.$dat[0]->imagen)}}" class="figure-img img-fluid" alt="cargando imagen..." width="100px" height="150px" style=" border: 2px; border-radius: 50px; background-color:white;" >
           </figure>
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
              <div class="form-group col-md-4">
                <label for="inputCity">Rol</label>
                <input type="text" class="form-control" id="inputCity"   readonly="readonly" value="{{$dat[0]->descripcion}}">
              </div>
              <div class="form-group col-md-2">
                <label for="inputCity">Estado</label>
                <input type="text" class="form-control" id="inputCity"  readonly="readonly" value="{{$dat[0]->descrip}}">
              </div>
            </div>
         <br><br>
       <!--#############################--->
      </div>
    </div>
  </div>
</div>
<!---##################################3-->

  
@endsection