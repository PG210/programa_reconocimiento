@extends('usuario.principa_usul')
@section('content')
<style>
  .textotarjeta{
    background-color:#082e41;
    color:white;
    padding: 5px;
    border-radius:10px;
  }
  .introjs-skipbutton {
    background-color:yellow;
    border-radius:10px;
    color:black;
    font-size: 20px;
  }
</style>
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
                <select id="categor" class="form-control" name="categor" data-step="1">
                  <option value=" ">Elegir...</option>
                    @if($b==0)
                    <option>Sin Categoría</option>
                    @endif
                    @if($b==1)
                      @foreach($categoria as $cate)
                      <option value="{{$cate->id}}">{{$cate->descripcion}}</option>
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
      <br><br>
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
                      <button type="button" id="botoncolab" class="btn btn-outline-primary  letraform" data-toggle="modal" data-target="#listaUsers" data-step="3">
                      <i class="fas fa-users"></i> Puntos
                      </button>
                 
                      <!-- Modal -->
                      <div class="modal fade" id="listaUsers" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-scrollable">
                          <div class="modal-content">
                            <div class="modal-header" style="background-color:#15AFBA; color:white;">
                              <h5 class="modal-title letraform" id="exampleModalLabel">ELEGIR COLABORADORES</h5>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                            </div>
                            <div class="modal-body letraform">
                              <!--listado de usuarios-->
                              <div class="row">
                                <div class="col-12 text-end">
                                    <input type="text" class="form-control" id="searchTerm" onkeyup="doSearch()" placeholder="Buscar...">
                                </div>
                              </div>
                              <!--================================-->
                              <div class="table-responsive">
                              <table class="table" id="tablaDate">
                                <thead>
                                  <tr>
                                    <th></th>
                                    <th>Nombres</th>
                                    <th>imagen</th>
                                  </tr>
                                </thead>
                                <tbody>
                                  @foreach($usu as $usuario)
                                  <tr>
                                    <td><input type="checkbox" name="usuariosSel[]" value="{{ $usuario->id }}" aria-label="Checkbox for following text input"></td>
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
                              <button type="button" class="btn btn-warning" data-dismiss="modal"><i class="fas fa-sign-out-alt"></i>Aceptar</button>
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
                <select id="stl-compor" class="form-control" name="idcat" hidden></select>
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
@endsection
