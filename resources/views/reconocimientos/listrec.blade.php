@extends('usuario.principa_usul')
@section('content')
  <!-- Content Header (Page header) -->
  <!-- Token de seguridad de Laravel (debes incluirlo en la vista) -->
  <input type="hidden" name="_token" value="{{ csrf_token() }}">
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
        <button type="button" id="botoncolab" class="btn w-100 btn-outline-primary letraform" data-toggle="modal"
          data-target="#listaUsers" data-step="3">
          <i class="fas fa-users"></i> Colaboradores
        </button>
        <!---=======Personas seleccionadas==========-->
        <div id="colab" style="display:none;">
          <div class="letraform">
          <label>Colaboradores elegidos</label>
          </div>
        </div>
        <div id="seleccionados"></div>
        
        </div>

        <!--modal para elegir los usuarios-->
        <!-- Button trigger modal -->
      </div>
      </div>

      <div class="card card-primary">
      <div class="card-body" id="categoria">
        2. ¿Porqué quieres reconocer?:
        <h3 class="titulo-reconocimiento"></h3>
        <div class="row reconocimientos">
        <!-- /card -->
        @if($categoria->isEmpty())
      <option>Sin Categorias</option>
    @else
    @foreach($categoria as $cate)
      <a href="#" class="col-6 btn-filtrar" data-id="{{ $cate->id }}">
        <div class="card card-outline card-primary">
        <div class="card-body">
        <h3 class="titulo-reconocimiento">
        {{ e($cate->descripcion) }}
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

    </div>
    </div>
  </div>
  <!---modal de personas -->
  <!-- Modal  de sugerencias-->
  <div class="modal fade" id="modalSugerencia" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel"> ¡Gracias por Reconocer!</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <p>Tu reconocimiento hace la diferencia. 🙌</p>
          <p>¿Qué tal si aprovechas tu visita y reconoces también a  </p>
          <!---=============-->
          <div>
            <div class="list-group" id="sugerir"></div>
           </div>
        
        <!-----#######################---->
        <div class="row letraform">
          <div class="col-md-12">
          <div id="sinsugerir"></div>
          </div>
        </div>
        <!----End mensajes de recomendacion--->
        <p>¡Haz que su día sea especial! 💙😊</p>
        </div>
        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-edfault" data-dismiss="modal">Cerrar</button>
          <button type="button" class="btn btn-success" data-dismiss="modal" id="mostrarAleatorios">¡Reconocer ahora!</button>
        </div>
      </div>
    </div>
  </div>
  <!---end modal -->

  <div class="col-md-6">
      <form method="POST" id="formudatos" name="formudatos">
      @csrf
      <!-- Modal para enviar targeta-->
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
            <input type="text" class="form-control" id="searchTerm" onkeyup="doSearch()"
              placeholder="Buscar...">
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
                <td><input type="checkbox" class="persona" name="usuariosSel[]" value="{{ $usuario->id }}"
                atrib-name="{{ $usuario->name }} {{ $usuario->apellido }}"></td>
                <td>{{ $usuario->name }} {{ $usuario->apellido }}</td>
                <td>
                  <div class="user-panel">
                    <div class="image">
                      @if($usuario->imagen != null && $usuario->imagen != 'ruta')
                        <img src="{{asset('dist/imgperfil/' . $usuario->imagen)}}" class="img-circle elevation-1"
                        alt="User Image" style="padding-bottom:2px;">
                      @endif
                      @if($usuario->imagen == null || $usuario->imagen == 'ruta')
                        <img src="{{asset('dist/imgperfil/perfil_no_borrar.jpeg')}}"
                        class="img-circle elevation-1" alt="User Image" style="padding-bottom:2px;">
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
          <button type="button" class="btn btn-warning" data-dismiss="modal" id="mostrarSeleccionados"><i
            class="fas fa-sign-out-alt"></i>Aceptar</button>
          </div>
        </div>
        </div>
      </div>
      <!---end modal--->
      <div class="card card-primary card-widget">
        <div class="card-header py-2 px-3">
        <div class="w-100 text-right text-puntos">
          <i class="fas fa-star text-warning"></i><span> {{$nompuntos->descripcion}}: </span><span
          class="punto"></span>
        </div>
        <div class="w-100 text-center">
          <!--foto medalla -->
          <div id="imagen" class="imagen"></div>
          <span class="text-center">
          <h4 class="nomcate letratarjeta1">
            <h4>
          </span>
        </div>
        <!-- /.user-block -->
        </div>
        <div class="card-body">
        <div class="user-block w-100">

          <div class="mb-3" id="comportamientos">
          <span class="mb-2">3. ¿Qué comportamiento quieres destacar?:</span>
          <select id="slt-cursos" class="form-control custom-select " data-step="2"></select>
          </div>
          <div class="mb-3" id="mensaje">
          <span class="mb-2">4. Deja un mensaje especial para esa persona:</span><!--was-validated  is-invalid-->
          <div class="letraform"> <!--permite validacion cuadro rojo was-validated-->
            <textarea class="form-control  letratarjeta1 " id="detexto" name="detexto"
            placeholder="Ingrese un detalle de reconocimiento" minlength="30" data-step="4" required></textarea>
          </div>
          </div>

          <div class="text-center">
          <div id="seleccionados"></div>
          <select id="stl-compor" class="form-control custom-select" name="idcat" hidden></select>
          <button type="submit" id="enviar" class="btn btn-warning font-weight-bold btn w-100 confirmar letraform"
            data-step="5">Envia tu reconocimiento</button>
          </div>

        </div>
        </div>
      </div>
      </form>
      <!---informacion de  reconocimiento-->
      Asi se ve tu reconocimiento:
      <div class="card card-primary card-widget">
      <div class="card-header py-4">
        <div class="w-100 text-center">
        <span class="text-center">
          <h4>🎉 Buen trabajo Manuel Castrillón</h4>
        </span>
        </div>
        <!-- /.user-block -->
        <!--foto medalla -->
        <div class="imagen2"></div>
      </div>
      <div class="card-body">
        <div class="user-block w-100">
        <!--foto de perfil -->
        <img class="profile-user-img img-circle loaded" src="/dist/imgperfil/perfil_no_borrar.jpeg"
          alt="User Avatar">
        <span class="username h4 nomcate letratarjeta1" id="nomcate"></span>
        <span class="description">Por: &nbsp;{{Auth::user()->name}} {{Auth::user()->apellido}} | {{ $fecha }}
        <span class="compor letratarjeta1" id="compor"></span>
        
        </span>
        </div>

      </div>
      <div class="card-body pt-0 user-block w-100">
        <div id="preview" class="description" style="font-size: 0.9rem;"> </div> <!-- mensaje del textarea-->
      </div>
      <!--info-->
      </div>
      <!---End visualizacion de reconocimiento-->
    </div>
    </div>
  </div>
  <!--manejar datatables -->

  <!--Ajax enviar respuesta--->
  <!--instanciar el ajax para quitar el error no definido-->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
  <script src="{{ asset('js/formulario.js')}}"></script>
  <script src="{{ asset('js/buscador.js')}}"></script>
  <!--
  <script src="{{ asset('dist/js/lazy.js')}}"></script>-->
  <script>
    window.datausu = @JSON($datausu);
    
    document.addEventListener('DOMContentLoaded', function () {
    introJs().setOptions({
      nextLabel: 'Siguiente',
      prevLabel: 'Anterior',
      skipLabel: 'Omitir',
      doneLabel: 'Listo',
      steps: [
      {
        element: document.querySelector('#botoncolab'),
        intro: "Selecciona uno o varios colaboradores a quienes quieras reconocer."
      },
      {
        element: document.querySelector('#categoria'),
        intro: "Selecciona la categoría en la que deseas reconocer a alguien."
      },
      {
        element: document.querySelector('#comportamientos'),
        intro: "Selecciona un comportamiento."
      },
      {
        element: document.querySelector('#mensaje'),
        intro: "Aquí escribe un mensaje resaltando la actitud positiva de los colaboradores."
      },
      {
        element: document.querySelector('#enviar'),
        intro: "Envía tu reconocimiento.",
        position: 'left'
      }
      ]
    }).start();
    });
  </script>

@endsection