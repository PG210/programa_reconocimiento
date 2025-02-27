@extends('usuario.principa_usul')
@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
 <div class="container"> 
  <div class="row mb-2">
   <div class="col-sm-8">
    <h1 class="m-0">Registros de insignias</h1>
   </div>
   <!-- /.col -->
   <div class="col-sm-4">
    <ol class="breadcrumb float-sm-right">
     <li class="breadcrumb-item"><a href="#">Inicio</a></li>
     <li class="breadcrumb-item active">Registros de insignias</li>
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
<form action="{{route('registroinsignias')}}" method="POST"  enctype="multipart/form-data" class="letraform">
@csrf
<div class="row mb-2">
<div class="col-md-3">
    <!-- Profile Image -->
    <div class="card card-primary card-outline">
                    <div class="card-body box-profile">
                        <div class="text-center">
                      
                        <p>Opciones</p>

                        
  <button type="button" class="btn btn-primary w-100  mb-3  ver" data-toggle="modal" data-target="#visualizar">Visualizar</button>
  <button type="button" class="btn btn-primary w-100  mb-3 " data-toggle="modal" data-target="#puntosconfig">Puntos</button>

                          
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
    </div>
    </div>
  <div class="col-md-9">
    
  <div class="card card-primary card-outline">
  <div class="card-body box-profile">

  <div class="form-row">
    <div class="form-group col-md-6">
      <label for="nombre">Nombre</label>
      <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Nombre" required>
    </div>
    <div class="form-group col-md-6">
      <!---Seleccion-->
      <label for="descripcion">Nivel</label>
        <select class="form-control" id="descripcion" name="descripcion" required>
          <option value="Oro" selected>Oro</option>
          <option value="Plata">Plata</option>
          <option value="Bronce">Bronce</option>
        </select>
      <!--end Seleccion-->
    </div>
  </div>
  <div class="form-row">
  <div class="form-group col-md-6">
      <!---Seleccion-->
      <label for="categoria">Categoria</label>
        <select class="form-control" id="categoria" name="categoria" required>
        <option value="puntos">Insignia de puntos</option>
        @foreach($categ as $ca)
          <option value="{{$ca->id}}">{{$ca->descripcion}}</option>
        @endforeach
        </select>
      <!--end Seleccion-->
    </div>
   <div class="form-group col-md-6">
    <label for="puntos">{{$nompuntos->descripcion}}</label>
    <input type="number" class="form-control" id="puntos" name="puntos" placeholder="Ejm: 100" min="0" required>
   </div>
   
  </div>

  <div class="form-group">
  <!---Colapso-->
  <label for="inputState">Elegir Recompensa</label>
  <div class="accordion" id="accordionExample">
  <div class="card">
    <div class="card-header p-1" id="headingTwo">
      <div class="mb-0"> <p class="float-left"></p>
    <a class="btn btn-link btn-block text-right collapsed" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
    <i class="fas fa-angle-double-down"></i>
    </a>
      </>
    </div>
    <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
      <div class="card-body">
        <!--tabla-->
        <!--tabla para ver los valores-->
        <div class="table-responsive">
        <table class="table table-hover table-estadisticas">
              <thead class="tablaheader">
              <tr>
                <th scope="col" class="text-center">No</th>
                <th scope="col">Nombre</th>
                <th scope="col">Descripción</th>
                <th scope="col">Imagen</th>
                <th scope="col" class="text-center">Seleccionar</th>
              </tr>
            </thead>
            <tbody>
            @php
              $con = 1;
            @endphp
            @foreach($pre as $c)
                <tr>
                  <th scope="row">{{$con++}}</th>
                  <td>{{$c->name}}</td>
                  <td>{{$c->descripcion}}</td>
                  <td>
                    <div class="text-center">
                    <img src="{{asset('imgpremios/'.$c->rutaimagen)}}" class="rounded" alt="..."  width= "50px" height="50px" >
                  </div>
                </td>
                <td class="text-center">
                <div>
                  <input type="radio" id="contactChoice1" name="premio" value="{{$c->id}}" required>
                  <label for="contactChoice1"> </label>
                </div>
                </td>
                <!--  <td><button type="button" class="btn btn-success">Actualizar</button></td>
                  <td><button type="button" class="btn btn-danger">Eliminar</button></td>
                 -->
                </tr>
             @endforeach
            </tbody>
          </table>
          </div>
        <!--end tabla-->
        <!--end tabla-->
      </div>
    </div>
  </div>
</div>


  <!---end colapso-->
  </div>
  
  <div class="form-group">
    <label for="img">Seleccionar Imagen</label>
    <input type="file" class="form-control form-control-file" name="img" id="img" required>
  </div>

  <button type="submit" class="btn btn-primary w-100  mb-3 confirmar">Registrar</button>
</form>

</div>
</div>
   <!-- /.col -->
  </div>
  <!-- /.row -->
 </div>
 <!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<div class="modal fade" id="visualizar" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title titulo" id="exampleModalLabel">Insignias Registradas</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body letraform">
        <!--tabla para ver los valores-->
         <div class="table-responsive">
            <table class="table table-hover table-estadisticas">
              <thead class="tablaheader">
              <tr>
                <th scope="col" class="text-center" style="width: 50px">No</th>
                <th scope="col">Nombre</th>
                <th scope="col">Nivel</th>
                <th scope="col">Puntos</th>
                <th scope="col">Imagen</th>
                <th scope="col">Recompensa</th>
                <th scope="col">Tipo</th>
                <th scope="col" class="text-center" style="width: 100px">Acción</th>
              </tr>
            </thead>
            <tbody>
            @if($b == 1)
                @php
                  $con = 1;
                @endphp
              @foreach($insignia as $c)
                <tr>
                  <th scope="row">{{$con++}}</th>
                  <td>{{$c->name}}</td>
                  <td>{{$c->descripcion}}</td>
                  <td>{{$c->puntos}}</td>
                  <td>
                    <div class="text-center">
                    <img src="{{asset('imgpremios/'.$c->rutaimagen)}}" class="rounded" alt="..."  width= "50px" height="50px" >
                  </div>
                </td>
                 <td>{{$c->prenom}}</td>
                 <td>
                 @if($c->tipo == 1)
                   <span>Insignia puntos</span>
                 @else 
                   <span>Insignia categoría</span>
                 @endif
                 </td>
                 <td class="text-center" style="width: 100px">
                  <div class="btn-group" role="group" aria-label="Basic outlined example">
                    <a type="button" class="btn btn-outline-primary btn-sm" href="{{route('actualizarinsignia',$c->id)}}"><i class="fas fa-edit"></i></a>
                    <a type="button" class="btn btn-outline-danger btn-sm" href="{{route('deleteinsignia',$c->id)}}"><i class="fas fa-trash"></i></a>
                  </div>
                </td>
                </tr>
             @endforeach
            @else
            <div class="alert alert-warning text-center" role="alert">
              ¡Ups! No hay registros disponibles
              <span>No se encontraron insignias registradas. Por favor, agrega uno nuevo.</span>
            </div>
            @endif
               
            </tbody>
          </table>
          </div>
        <!--end tabla-->
      </div>
      <div class="modal-footer  letraform">
        <button type="button" class="btn btn-default salir" data-dismiss="modal">Salir</button>
      </div>
    </div>
  </div>
</div>
<!--=====================================-->
<div class="modal fade" id="puntosconfig" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title titulo" id="exampleModalLabel">Configurar nombres de los puntos</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="{{route('modpuntos')}}" method="POST">
        @csrf
      <div class="modal-body letraform">
       <p>Nota: En este apartado puede configurar el nombre para los puntos.<p>
          <div class="form-group">
            <label class="col-form-label">Nombre:</label>
            <input type="text" class="form-control" id="nompunto" name="nompunto" value="{{$nompuntos->descripcion}}" required>
          </div>
      </div>
      <div class="modal-footer justify-content-between letraform">
       
        <button type="button" class="btn btn-default salir" data-dismiss="modal">Salir</button>
        <button type="submit" class="btn btn-success confirmar">Guardar</button>
      </div>
      </form>
    </div>
  </div>
</div>
@endsection