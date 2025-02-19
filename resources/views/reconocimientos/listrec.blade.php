@extends('usuario.principa_usul')
@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
	<div class="container">
		<div class="row mb-2">
			<div class="col-sm-8">
				<h1 class="m-0">{{ Auth::user()->name }}, es hora de reconocer!</h1>
			</div>
			<!-- /.col -->
			<div class="col-sm-4">
				<ol class="breadcrumb float-sm-right">
					<li class="breadcrumb-item"><a href="#">Inicio</a></li>
					<li class="breadcrumb-item active">Inicio</li>
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
		<div class="col-md-6">
    
    <div class="card card-primary">
          <div class="card-body">
          <div class="">
                          <p class="mb-2">1. ¿A quienes quieres reconocer?:</p>
                          <!--mensaje de recomendacion-->
                          <button type="button" id="botoncolab" class="btn w-100 btn-outline-primary letraform" data-toggle="modal" data-target="#listaUsers" data-step="3">
                            <i class="fas fa-users"></i>  Colaboradores
                          </button>
                          <!---=======Personas seleccionadas==========-->
                          <div id="colab" style="display:none;">
                              <div class="letraform">
                                <label>Colaboradores elegidos</label>
                              </div>
                          </div>
                          <div id="seleccionados"></div>
                          <!---=============-->
                        <div class="row letraform">
                          <div class="col-md-12">
                          <div id="sugerir"></div>
                           
                          </div>
                        </div>
                        <!-----#######################---->
                        <div class="row letraform">
                          <div class="col-md-12">
                          <div id="sinsugerir"></div>
                        </div>
                        </div>
                        <!----End mensajes de recomendacion--->
                        </div>

                        <!--modal para elegir los usuarios-->
                        <!-- Button trigger modal -->

                      <!-- Modal -->
                      <div class="modal fade" id="listaUsers" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-scrollable modal-lg">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h5 class="modal-title letraform" id="exampleModalLabel">Elige a quien(es) quieres reconocer</h5>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                            </div>
                            <div class="modal-body letraform">
                              <!--listado de usuarios-->
                              <!--================================-->
                              <div class="row">
                                <div class="col-12 text-end">
                                    <input type="text" class="form-control" id="searchTerm" onkeyup="doSearch()" placeholder="Buscar...">
                                </div>
                              </div>
                              <div class="table-responsive">
                              <table class="table" id="tablaDate">
                                <thead>
                                  <tr>
                                    <th></th>
                                    <th>Nombres</th>
                                    <th>Perfil</th>
                                  </tr>
                                </thead>
                                <tbody>
                                  @foreach($usu as $usuario)
                                  <tr>
                                    <td><input type="checkbox" class="persona" name="usuariosSel[]" value="{{ $usuario->id }}" atrib-name="{{ $usuario->name }} {{ $usuario->apellido }}"></td>
                                    <td>{{ $usuario->name }} {{ $usuario->apellido }}</td>
                                    <td>
                                    <div class="user-panel">
                                      <div class="image">
                                        @if($usuario->imagen!=null && $usuario->imagen != 'ruta')
                                          <img src="{{asset('dist/imgperfil/'.$usuario->imagen)}}" class="img-circle elevation-1" alt="User Image" style="padding-bottom:2px;">
                                        @endif
                                        @if($usuario->imagen==null || $usuario->imagen == 'ruta')
                                        <img src="{{asset('dist/imgperfil/perfil_no_borrar.jpeg')}}" class="img-circle elevation-1" alt="User Image" style="padding-bottom:2px;" >
                                        @endif
                                        </div>
                                      </div>
                                    </td>
                                  </tr>
                                  @endforeach
                                  <tr class='noSearch hide'>
                                    <td colspan="3"></td>
                                  </tr>
                                </tbody>
                              </table>
                              </div>
                              <!--lista users-->
                            </div>
                            <div class="modal-footer">
                              <button type="button" class="btn btn-warning" data-dismiss="modal" id="mostrarSeleccionados"><i class="fas fa-sign-out-alt"></i>Aceptar</button>
                            </div>
                          </div>
                        </div>
                      </div>
                 <!---end modal--->
          </div>
      </div>
      
          <div class="card card-primary">
          <div class="card-body">
          2. ¿Porqué quieres reconocer?:
          <h3 class="titulo-reconocimiento"></h3>
          <div class="row reconocimientos">
            <!-- /card -->
            @if($categoria->isEmpty())
                <option>Sin Categorias</option>
            @else
                @foreach($categoria as $cate)
                  <a href="#" class="col-6 ">
                    <div class="card card-outline card-primary">
                      <div class="card-body">
                        <h3 class="titulo-reconocimiento">
                        {{ e($cate->descripcion) }} id = {{ $cate->id }}
                        </h3>
                       {{ $cate->especificacion }}
                      </div>
                    </div>
                  </a>
                @endforeach
            @endif

            <!-- /card -->
            <a href="#" class="col-6 ">
              <div class="card card-outline card-primary">
                <div class="card-body">
                  <h3 class="titulo-reconocimiento">
                  Otro
                  </h3>
                  Un reconocimiento especial que no encaja en las categorías anteriores, pero merece ser valorado.
                </div>
              </div>
              </a>
            <!-- /.card -->
          </div>
          <form id="categoria" method="post" class="letraform">
            @csrf
              <div class="row">
                <div class="col-md-12">
                  <select id="categor" class="form-control custom-select" name="categor" data-step="1">
                      <option value=" ">Elegir...</option>
                      @if($categoria->isEmpty())
                          <option>Sin Categoría</option>
                      @else
                          @foreach($categoria as $cate)
                              <option value="{{ $cate->id }}">{{ e($cate->descripcion) }}</option>
                          @endforeach
                      @endif
                    </select>
                  </div>
                  <!--end seleccionar--->
              </div>
          </form>
          </div>
      </div>
      </div>  
    <div class="col-md-6">
      <form method="POST" id="formudatos" name="formudatos">
      @csrf
                  <div class="card card-primary card-widget">
										<div class="card-header py-2 px-3">
											<div class="w-100 text-right text-puntos">
                      <i class="fas fa-star text-warning"></i><span> {{$nompuntos->descripcion}}: </span><span class="punto"></span>
                      </div>	
                      <div class="w-100 text-center">
                        <!--foto medalla -->
												<img class="medallas" src="/dist/img/medalla_1.png" alt="medallas">
                        <div id="imagen" class="imagen"></div>
                        <span class="text-center"><h4 class="nomcate letratarjeta1"><h4></span>
											</div>
											<!-- /.user-block -->
										</div>
										<div class="card-body">
											<div class="user-block w-100">
                        
                        <div class="mb-3">
                          <form id="comportamiento" method="post" class="letraform">
                          @csrf
                            <span class="mb-2">3. ¿Qué comportamiento quieres destacar?:</span>
                            <select id="slt-cursos" class="form-control custom-select " data-step="2"></select>
                          </form>
                        </div>
                        <div class="mb-3">
                          <span class="mb-2">4. Deja un mensaje especial para esa persona:</span><!--was-validated  is-invalid-->
                          <div class="letraform was-validated">
                            <textarea class="form-control  letratarjeta1 is-invalid" id="detexto" name="detexto" placeholder="Ingrese un detalle de reconocimiento" minlength="30" data-step="4" required></textarea>
                          </div>
                        </div>

                        <div class="text-center">
                        <select id="stl-compor" class="form-control custom-select" name="idcat" hidden></select>
                        <button type="submit" id="enviar" class="btn btn-warning font-weight-bold btn w-100 confirmar letraform" data-step="5">Envia tu reconocimiento</button>
                        </div>

											</div>
										</div>
									</div>


                  Asi se ve tu reconocimiento:
                  <div class="card card-primary card-widget">
										<div class="card-header py-4">
											<div class="w-100 text-center">
												<span class="text-center"><h4>🎉 Buen trabajo Manuel Castrillón</h4></span>
											</div>
											<!-- /.user-block -->
                       <!--foto medalla -->
												<img class="medallas-muro" src="/dist/img/medalla_1.png" alt="medallas">
										</div>
										<div class="card-body">
											<div class="user-block w-100">
												<!--foto de perfil -->
												<img class="profile-user-img img-circle loaded" src="/dist/imgperfil/perfil_no_borrar.jpeg" alt="User Avatar">
												<span class="username h4 nomcate letratarjeta1"></span>
												<span class="description">Por: &nbsp;{{Auth::user()->name}} {{Auth::user()->apellido}} | 28 August, 2024  </span>
											</div>

										</div>
										<div class="card-body pt-0">
                    <p class="compor letratarjeta1"></p>
										</div>
									</div>
      </form>
    </div>
  </div>
</div>
 <!--manejar datatables -->
<ul class="nav nav-tabs" id="myTab" role="tablist" style="background-color:#1ED5F4; color:black;">
</ul>
<div class="tab-content" id="myTabContent">
  <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
   <!--texto 1-->
   <div class="row">
   <div class="col-md-5">
      <br>
     <!--seleccionar-->
     <div class="container">
     <form id="categoria" method="post" class="letraform">
        @csrf
         <div class="row">
            <div class="col-md-12 textotarjeta">
                <label>&nbsp;&nbsp;Categoría</label>
            </div>
           </div>
           <div class="row mt-3">
            <div class="col-md-12">
                <select id="categor" class="form-control custom-select" name="categor" data-step="1">
                  <option value=" ">Elegir...</option>
                  @if($categoria->isEmpty())
                      <option>Sin Categoría</option>
                  @else
                      @foreach($categoria as $cate)
                          <option value="{{ $cate->id }}">{{ e($cate->descripcion) }}</option>
                      @endforeach
                  @endif
                </select>
              </div>
              <!--end seleccionar--->
        </div>
      </form>
     </div>
      <br><br>
      <div class="container">
        <form id="comportamiento" method="post" class="letraform">
        @csrf
        <div class="row">
           <div class="col-md-12 textotarjeta">
             <label>&nbsp;&nbsp;Comportamiento</label>
            </div>
          </div>
          <!--=======================-->
          <div class="row mt-3">
            <div class="col-md-12">
               <select id="slt-cursos" class="form-control" data-step="2"></select>
            </div>
          </div>
        </form>
      </div>
      <!--mensaje de recomendacion-->
      <button type="button" id="botoncolab" class="btn btn-outline-primary mt-4 letraform" data-toggle="modal" data-target="#listaUsers" data-step="3">
        <i class="fas fa-users"></i>  Colaboradores
      </button>
      <!---=======Personas seleccionadas==========-->
      <div class="row mt-3 mb-3 mt-4" id="colab" style="display:none;">
          <div class="col-md-12 textotarjeta letraform">
             <label>Colaboradores elegidos</label>
          </div>
      </div>
      <div id="seleccionados"></div>
      <!---=============-->
    <div class="row letraform">
      <div class="col-md-12">
      <div id="sugerir"></div>
     </div>
    </div>
    <!-----#######################---->
    <div class="row letraform">
      <div class="col-md-12">
      <div id="sinsugerir"></div>
     </div>
    </div>
    <!----End mensajes de recomendacion--->
   </div>
    
  <div class="col-md-7">
   <div class="container">
   <form method="POST" id="formudatos" name="formudatos">
     @csrf
   <br> 
   <div class="card-deck">
        <div class="card" style="width: 18rem;">
        <div class="card-body">
            <div class="row">
              <div class="col-lg-9 col-md-12">
               <div class="user-panel d-flex"> 
                 <!--modal para elegir los usuarios-->
                    <!-- Button trigger modal -->

                      <!-- Modal -->
                      <div class="modal fade" id="listaUsers" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-scrollable modal-lg">
                          <div class="modal-content">
                            <div class="modal-header" style="background-color:#15AFBA; color:white;">
                              <h5 class="modal-title letraform" id="exampleModalLabel">ELEGIR COLABORADORES</h5>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                            </div>
                            <div class="modal-body letraform">
                              <!--listado de usuarios-->
                              <!--================================-->
                              <div class="row">
                                <div class="col-12 text-end">
                                    <input type="text" class="form-control" id="searchTerm" onkeyup="doSearch()" placeholder="Buscar...">
                                </div>
                              </div>
                              <div class="table-responsive">
                              <table class="table" id="tablaDate">
                                <thead>
                                  <tr>
                                    <th></th>
                                    <th>Nombres</th>
                                    <th>Perfil</th>
                                  </tr>
                                </thead>
                                <tbody>
                                  @foreach($usu as $usuario)
                                  <tr>
                                    <td><input type="checkbox" class="persona" name="usuariosSel[]" value="{{ $usuario->id }}" atrib-name="{{ $usuario->name }} {{ $usuario->apellido }}"></td>
                                    <td>{{ $usuario->name }} {{ $usuario->apellido }}</td>
                                    <td>
                                    <div class="user-panel mt-0 pb-0 mb-0 d-flex">
                                      <div class="image">
                                        @if($usuario->imagen!=null && $usuario->imagen != 'ruta')
                                          <img src="{{asset('dist/imgperfil/'.$usuario->imagen)}}" class="img-circle elevation-1" alt="User Image" style="padding-bottom:2px;">
                                        @endif
                                        @if($usuario->imagen==null || $usuario->imagen == 'ruta')
                                        <img src="{{asset('dist/imgperfil/perfil_no_borrar.jpeg')}}" class="img-circle elevation-1" alt="User Image" style="padding-bottom:2px;" >
                                        @endif
                                        </div>
                                      </div>
                                    </td>
                                  </tr>
                                  @endforeach
                                  <tr class='noSearch hide'>
                                    <td colspan="3"></td>
                                  </tr>
                                </tbody>
                              </table>
                              </div>
                              <!--lista users-->
                            </div>
                            <div class="modal-footer">
                              <button type="button" class="btn btn-warning" data-dismiss="modal" id="mostrarSeleccionados"><i class="fas fa-sign-out-alt"></i>Aceptar</button>
                            </div>
                          </div>
                        </div>
                      </div>
                 <!---end modal--->
               </div>
              </div>
              <div class="col-lg-3 col-md-12 mt-1 letratarjeta1">
               <span> {{$nompuntos->descripcion}}: </span><span class="punto"></span><i class="fas fa-star" style="color:#FFC107;"></i>
              </div>
            </div>
            <hr>
            <div id="imagen" class="imagen">
            </div>
            <h3 class="letratarjeta2 textotarjeta mt-3">Te reconozco por:</h3> 
            <h5 class="nomcate letratarjeta1"><h5>
            <hr>
            <h3 class="letratarjeta2 textotarjeta">Comportamiento:</h3>
            <h5 class="compor letratarjeta1"><h5>
            <hr>
            <h3 class="letratarjeta2 textotarjeta">Detalle:</h3>
            <!---############--->
            <div class="mb-3 was-validated letraform">
              <textarea class="form-control is-invalid mt-3 letratarjeta1" id="detexto" name="detexto" placeholder="Ingrese un detalle de reconocimiento" minlength="30" data-step="4" required></textarea>
            </div>
            <!--##########  -->
            <hr>
            <div class="row">
                <div class="col-lg-12 col-md-12">
                  <h5 class="letratarjeta2 textotarjeta"><b>De:&nbsp;{{Auth::user()->name}} {{Auth::user()->apellido}}</h5>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-7"></div>
                <div class="col-5 text-center">
                <select id="stl-compor" class="form-control custom-select" name="idcat" hidden></select>
                 <button type="submit" id="enviar" class="btn confirmar letraform float-right" data-step="5">Enviar</button>
                </div>
           </div>
        </div>
        </div>
    
      </div>
    </form>
   </div>
      </div>
   </div>
      <!---end_texto 1-->
  </div>
  <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
   <!---texto 2-->
      <br>  
     
   <!--end texto 2-->
  </div>
  <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">

     <!--texto 3-->
  </div>
</div>

<!--Ajax enviar respuesta--->
<!--instanciar el ajax para quitar el error no definido-->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
<script src="{{ asset('js/formulario.js')}}"></script>
<script src="{{ asset('js/buscador.js')}}"></script>
<script src="{{ asset('dist/js/lazy.js')}}"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    introJs().setOptions({
            nextLabel: 'Siguiente',
            prevLabel: 'Anterior',
            skipLabel: 'Omitir',
            doneLabel: 'Listo',
        steps: [
            { 
                element: document.querySelector('#categor'),
                intro: "Selecciona la categoría en la que deseas reconocer a alguien."
            },
            {
                element: document.querySelector('#slt-cursos'),
                intro: "Selecciona un comportamiento."
            },
            {
                element: document.querySelector('#botoncolab'),
                intro: "Selecciona uno o varios colaboradores a quienes quieras reconocer."
            },
            {
                element: document.querySelector('#detexto'),
                intro: "Aquí escribe un mensaje resaltando la actitud positiva de los colaboradores."
            },
            {
                element: document.querySelector('#enviar'),
                intro: "Envía el mensaje.",
                position: 'left'
            }
        ]
    }).start();
});
</script>
<script>
     $(document).ready(function() {
            $('#mostrarSeleccionados').click(function() {
                var seleccionados = [];
                $('input.persona:checked').each(function() {
                    seleccionados.push($(this).attr('atrib-name'));
                });
                // imprimir los datos
                $('#seleccionados').empty(); // Limpiar contenido previo
                $.each(seleccionados, function(index, nombre) {
                    $('#seleccionados').append('<h5><b>' + nombre + '<b></h5>');
                });
                // validar el label
                if (seleccionados.length > 0) {
                    $('#colab').show();
                } else {
                    $('#colab').hide();
                }
            });
        });  
</script>
@endsection
