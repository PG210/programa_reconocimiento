@extends('usuario.principa_usul')
@section('content')
<div class="alert text-center titulo" role="alert">
 <h3>GESTIÓN DE AREAS Y CARGOS </h3>
</div>
<div class="row letraform">
   <div class="col-md-5">
     <button type="button" class="btn" data-toggle="modal" data-target="#staticBackdrop" style="background-color:#5959D1; color:#FFF;">
        <i class="fas fa-pen-alt"></i>&nbsp;Areas
    </button>
    </div>
    <div class="col-md-3">
      <a type="button" href="{{route('vistacargo')}}" class="btn float-none" style="margin-top:3px; background-color:#FFBD03; color:#FFF;"> <i class="fas fa-pen-alt"></i>&nbsp;Cargos</a>
    </div>
    <div class="col-md-4">
      <a type="button" href="{{route('vincular_jefes')}}" class="btn float-right" style="background-color:#5959D1; color:white;"><i class="fas fa-users"></i>&nbsp;Vincular Jefes</a>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
       <!---#################-->
          <!-- Button trigger modal -->
                <!-- Modal -->
                <form id="formulario" method="post">
                @csrf
                <div class="modal fade" id="staticBackdrop" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                    <div class="modal-header titulo">
                        <h5 class="modal-title" id="staticBackdropLabel">Formulario Areas</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body letraform">
                        <!--##############-->
                            
                            <div class="form-row">
                                <div class="col">
                                <input type="text" id="nombre" class="form-control" placeholder="Nombre" required> 
                                </div>
                            </div>
                        <!----############--->
                    </div>
                    <div class="modal-footer letraform">
                        <button type="submit" class="btn confirmar">Guardar</button>
                        <button type="button" class="btn salir" data-dismiss="modal">Cancelar</button>
                    </div>
                    </div>
                </div>
                </div>
                </form>
       <!--##################--->
      <br>
      @if(Session::has('mensaje'))
        <br>
        <div class="alert alert-info alert-dismissible fade show letraform" role="alert">
        <strong>{{Session::get('mensaje')}}</strong> 
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        </div>
        @endif
        @if(Session::has('mensajeerror'))
        <br>
        <div class="alert alert-danger alert-dismissible fade show letraform" role="alert">
        <strong>{{Session::get('mensajeerror')}}</strong> 
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        </div>
        @endif
      <br>
      <table class="table letraform">
        <thead class="tablaheader">
            <tr>
            <th scope="col">No</th>
            <th scope="col">Area</th>
            <th scope="col">Acción</th>
            <th scope="col">
                <form id="listar" method="post">
                @csrf
                <input type="text" id="infor" value="1" hidden>
                <button type="submit"><i class="fas fa-list"></i></button>
                <form>
            </th>
            </tr>
        </thead>
        <tbody id="datos">
        </tbody>
        <tbody id="datosdos">
        </tbody>
        </table>
      <div id="table" class="letraform"> </div>
    </div>
</div>

<!--instanciar el ajax para quitar el error no definido-->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
<script>
  /*tomamos la información del formulario y la enviamos a la ruta y de la ruta al controlador*/
  $('#formulario').submit(function(e){
    e.preventDefault();
    var nombre=$('#nombre').val();
    var cur=$('#datos').val();
    var _token = $('input[name=_token]').val();

    $.ajax({
      url:"{{route('guardararea')}}",
      type: "POST",
      data:{
        nombre:nombre,
        _token:_token
      }, 
      success:function(response){
        if(response){
          $('#formulario')[0].reset();
          toastr.success('El registro se ingreso correctamente.', 'Nuevo Registro', {timeOut:3000});
          //setTimeout(refrescar, 1000);
        }
      },
      error:function(jqXHR, response){
        if(jqXHR.status==422){
          toastr.warning('Datos Repetidos!.', 'Area ya está registrada!', {timeOut:3000});
        }
     }
    }).done(function(res){
      var arreglo = JSON.parse(res);
      var conta=0;
      $("#datosdos").empty();
      $("#datos").empty();
     for(var x=0; x<arreglo.length; x++){
        conta+=1;
        var valor = '<tr>' +
        '<td>' + conta +'</td>' +
        '<td>' +  arreglo[x].nombre + '</td>' +
        '<td><a href="/eliminar/area/' + arreglo[x].id + '" type="submit" id="eliminar" class="btn btn-danger"> <i class="fas fa-trash-alt"></i></a></td>' +
        '</tr>';
        $('#datos').append(valor);
      }

    });
  });
 </script> 
 <script>
  /*tomamos la información del formulario y la enviamos a la ruta y de la ruta al controlador*/
  $('#listar').submit(function(e){
    e.preventDefault();
    var infor=$('#infor').val();
    var _token = $('input[name=_token]').val();

    $.ajax({
      url:"{{route('consultararea')}}",
      type: "POST",
      data:{
        infor:infor,
        _token:_token
      }, 
    }).done(function(res){
      
      var arreglo = JSON.parse(res);
      var conta=0;
      $("#datosdos").empty();
      $("#datos").empty();
     for(var x=0; x<arreglo.length; x++){
        conta+=1;
        var valor = '<tr>' +
        '<td>' + conta +'</td>' +
        '<td>' +  arreglo[x].nombre + '</td>' +
        '<td><a href="/eliminar/area/' + arreglo[x].id + '" type="submit" id="eliminar" class="btn btn-danger"> <i class="fas fa-trash-alt"></i></a></td>' +
        '</tr>';
        $("#datosdos").append(valor);
      }

    });
  });
 </script> 
@endsection