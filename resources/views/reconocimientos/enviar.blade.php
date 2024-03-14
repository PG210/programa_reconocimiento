@extends('usuario.principa_usul')
@section('content')
<div class="container">
<div class="alert text-center titulo" role="alert" >
  <h3>ENVIAR RECONOCIMIENTOS</h3>
</div>
</div>
<br>

@if(Session::has('messajeinfo'))
        <br>
        <div class="alert alert-info alert-dismissible fade show" role="alert">
        <strong>{{Session::get('messajeinfo')}}</strong> 
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        </div>
@endif
<!---Modal-para buscar-->
       <div class="container">
       <form id="buscar" class="letraform">
       @csrf
        <div class="form-row">
            <div class="col-11">
            <input type="text" class="form-control" placeholder="Ingrese Nombre" id="dato">
            </div>
            <div class="col-1">
            <button class="btn btn-primary float-right" type="submit"><i class="fas fa-search"></i></button>
            </div>
        </div>
        </form>
        </div>
<!---End modal buscar-->
     <br>
<!--tabla de usuarios-->
<div class="table-responsive">
        <table class="table table-hover letraform">
        <thead class="tablaheader">
            <tr>
            <th scope="col">No</th>
            <th scope="col">Nombre</th>
            <th scope="col">Apellido</th>
            <th scope="col">Dirección</th>
            <th scope="col">Imagen</th>
            <th scope="col">Acción</th>
            </tr>
        </thead>
        <tbody id="tablaocu">
            <?php
              $conta=1;
            ?>
            @foreach($usu as $u)
            <tr>
            <th scope="row">{{$conta++}}</th>
            <td>{{$u->name}}</td>
            <td>{{$u->apellido}}</td>
            <td>{{$u->direccion}}</td>
            <td>
                <div class="user-panel mt-0 pb-0 mb-0 d-flex">
                <div class="image">
                  @if($u->imagen!=null && $u->imagen != 'ruta')
                    <img src="{{asset('dist/imgperfil/'.$u->imagen)}}" class="img-circle elevation-1" alt="User Image" style="padding-bottom:2px;">
                  @endif
                  @if($u->imagen==null || $u->imagen == 'ruta')
                  <img src="{{asset('dist/imgperfil/perfil_no_borrar.jpeg')}}" class="img-circle elevation-1" alt="User Image" style="padding-bottom:2px;" >
                  @endif
                  </div>
                </div>
                <!--imagen-->
                <!---end imagen-->
            </td>
            <td>
             <a href="{{route('listareconocer')}}" type="button" class="btn" style="color:#ffbd03;" data-toggle="tooltip" title="Enviar Reconocimiento"><i class="fas fa-award  fa-2x"></i></a>
            </td>
            </tr>
            @endforeach
        </tbody>
        <!---mostrar la tabla de los datos de ajax-->
         
         <tbody id="tablamostrar"></tbody>
       
        <!--muestra los datos de la tabla de jax-->
        </table>
        {{ $usu->links() }}
     </div>
<!---end tabla usuarios--->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
<script>
  /*tomamos la información del formulario y la enviamos a la ruta y de la ruta al controlador*/
  $('#buscar').submit(function(e){
    e.preventDefault();
    var dato=$('#dato').val();
    console.log(dato);
    var _token = $('input[name=_token]').val();
    $.ajax({
      url:"{{route('buscar_usuario')}}",
      type: "POST",
      data:{
        dato:dato,
        _token:_token,
      }
    }).done(function(response){
       var arreglo = JSON.parse(response);
       var conta=0;
       $("#tablaocu").hide();
       $("#tablamostrar").empty();
       if(arreglo.length!=0){
            for(var x=0; x<arreglo.length; x++){
            conta+=1;
            if(arreglo[x].imagen!=null){
                var valor = '<tr>' +
                '<td>' + conta +'</td>' +
                '<td>' +  arreglo[x].name + '</td>' +
                '<td>' +  arreglo[x].apellido + '</td>' +
                '<td>' +  arreglo[x].direccion + '</td>' +
                '<td> <img src="/dist/imgperfil/' +arreglo[x].imagen+ ' " class="img-circle elevation-1" alt="User Image" style="padding-bottom:2px; width:50px; height: 50px;">&nbsp;&nbsp;</td>' +
                '<td> <a href="/reconocimientos/usuario/'+arreglo[x].id+'" type="button" class="btn" style="color:#ffbd03;" data-toggle="tooltip" title="Enviar Reconocimiento"><i class="fas fa-award  fa-2x"></i></a></td>' +
                '</tr>';
            }else{
              var valor = '<tr>' +
                '<td>' + conta +'</td>' +
                '<td>' +  arreglo[x].name + '</td>' +
                '<td>' +  arreglo[x].apellido + '</td>' +
                '<td>' +  arreglo[x].direccion + '</td>' +
                '<td> <img src="/dist/imgperfil/perfil_no_borrar.jpeg" class="img-circle elevation-1" alt="User Image" style="padding-bottom:2px; width:50px; height: 50px;">&nbsp;&nbsp;</td>' +
                '<td> <a href="/reconocimientos/usuario/'+arreglo[x].id+'" type="button" class="btn" style="color:#ffbd03;" data-toggle="tooltip" title="Enviar Reconocimiento"><i class="fas fa-award  fa-2x"></i></a></td>' +
                '</tr>';
            }
            $('#tablamostrar').append(valor);
        }
       }else{
        $("#tablaocu").show();
        $("#tablamostrar").empty();
        toastr.warning('Lo sentimos!', 'Datos no encontrados', {timeOut:3000});
       }
         
    }).fail(function(jqXHR, response){
        $("#tablaocu").show();
        $("#tablamostrar").empty();
        toastr.warning('Lo sentimos!', 'Datos no encontrados', {timeOut:3000});
       
      });
  });
 </script> 



@endsection

   
