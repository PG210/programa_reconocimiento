@extends('usuario.principa_usul')
@section('content')

@if(Session::has('actualizadopre'))
<div class="alert alert-warning alert-dismissible fade show letraform" role="alert">
  <strong>{{Session::get('actualizadopre')}}</strong> 
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>
@endif

<form action="{{route('regpremioactu', $datos[0]->id)}}" method="POST" class="letraform"  enctype="multipart/form-data">
  @csrf
<!-- Content Header (Page header) -->
<div class="content-header">
 <div class="container"> 
  <div class="row mb-2">
   <div class="col-sm-8"> 
    <h1 class="m-0"><a href="/premios/reg" class="btn salir btn-default">&nbsp;&nbsp;Volver</a> Actualización recompensas</h1>
   </div>
   <!-- /.col -->
   <div class="col-sm-4">
    <ol class="breadcrumb float-sm-right">
     <li class="breadcrumb-item"><a href="#">Inicio</a></li>
     <li class="breadcrumb-item"><a href="#">Recomensas</a></li>
     <li class="breadcrumb-item active">Actualización recompensas</li>
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
<div class="row mb-2">
  <div class="col-12">
  <div class="card card-primary card-outline">
  <div class="card-body box-profile">
  <div class="form-row">
    <div class="form-group col-md-6">
      <label for="nombre">Nombre</label>
      <input type="text" class="form-control" id="nombre" name="nombre" value="{{$datos[0]->name}}" required>
    </div>
    <div class="form-group col-md-6">
      <label for="des">Descripción</label>
      <input type="text" class="form-control" id="des" name="des"  value="{{$datos[0]->descripcion}}" required>
    </div>
  </div>
  <div class="form-group">
     <label for="exampleFormControlFile1">Seleccionar Imagen</label>
    <input type="file" class="form-control-file form-control" id="img" name="img">
  </div>
  
  <button type="submit" class="btn btn-primary float-right  #confirmar">Actualizar</button>
</form>
<!--Modal visualizar imagenes-->
</div>
</div>
</div>
</div>
</div>

@endsection