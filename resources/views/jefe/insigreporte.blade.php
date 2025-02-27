@extends('usuario.principa_usul')
@section('content')
<style>
    img.zoom {
        width: 50px;
        height: 50px;
        -webkit-transition: all .2s ease-in-out;
        -moz-transition: all .2s ease-in-out;
        -o-transition: all .2s ease-in-out;
        -ms-transition: all .2s ease-in-out;
    }
    
    .transition {
        -webkit-transform: scale(3.0); 
        -moz-transform: scale(3.0);
        -o-transform: scale(3.0);
        transform: scale(3.0);
    }
</style>


<!--###################################-->

<!-- Content Header (Page header) -->
<div class="content-header">
	<div class="container">
		<div class="row mb-2"> 
			<div class="col-sm-8">
				<h1 class="m-0">Listado de Insignias a Obtener</h1>
			</div>
			<!-- /.col -->
			<div class="col-sm-4">
				<ol class="breadcrumb float-sm-right">
					<li class="breadcrumb-item"><a href="#">Inicio</a></li>
					<li class="breadcrumb-item active">Recompensas</li>
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
			<div class="col-sm-12">
            <div class="card">

                <div class="card-header">
                Mostrar
                <select class="form-select" id="recordsPerPage" onchange="changeRows()">
                    <option value="5">5 registros</option>
                    <option value="10" selected>10 registros</option>
                    <option value="25">25 registros</option>
                    <option value="50">50 registros</option>
                    </select> registros por página
                <div class="card-tools">
                    <div class="" style="display: flex;justify-content: space-around;gap: 10px;">
                    <div class="" style="width: 200px;">
                        <input class="form-control mr-sm-4" type="text" id="search" placeholder="Buscar por nombres...">
                    </div>
                    </div>
                </div>
                </div>
                <!-- /.card-header -->
                <div class="px-3">
                <div class="table-responsive">
<table class="table table-hover table-estadisticas">
  <thead class="tablaheader">
    <tr>
      <th scope="col">No</th>
      <th scope="col">Nombre</th>
      <th scope="col">Nivel</th>
      <th scope="col">Puntos</th>
      <th scope="col">Insignia</th>
      <th scope="col">Tipo recompensa</th>
      <th scope="col">Descripción</th>
      <th scope="col">Recompensa</th>
    </tr>
  </thead>
  <tbody><!---idinsig -->
   <?php
    $conta=1;
   ?>
   @if($b==1)
    @foreach($coninsig as $c)
    <tr>
      <th scope="row">{{$conta++}}</th>
      <td>{{$c->name}}</td>
      <td>{{$c->descripcion}}</td>
      <td>{{$c->puntos}}</td>
      <td> 
          <div class="text-center">
                    <img src="{{asset('imgpremios/'.$c->imginsig)}}" class="rounded zoom" alt="..."  width= "50px" height="50px" >
          </div>
      </td>
      <td>{{$c->nompre}}</td>
      <td>{{$c->despremio}}</td>
      <td>
          <div class="text-center">
                    <img src="{{asset('imgpremios/'.$c->imgpre)}}" class="rounded zoom" alt="..."  width= "50px" height="50px" >
          </div>     
      </td>
    </tr>
   @endforeach
   @endif
  </tbody>
</table>
</div>
                </div>


                <div class="card-footer clearfix">
                <div class="row">
                    <div class="col-sm-12 col-md-7">
                    <div class="dataTables_info">Showing 1 to 10 of 57 entries</div>
                    </div>
                    <div class="col-sm-12 col-md-5">
                    <div class="">
                        <ul class="pagination m-0">
                        <li class="paginate_button page-item previous disabled" id="example2_previous"><a href="#" aria-controls="example2" data-dt-idx="0" tabindex="0" class="page-link">Previous</a></li>
                        <li class="paginate_button page-item active"><a href="#" aria-controls="example2" data-dt-idx="1" tabindex="0" class="page-link">1</a></li>
                        <li class="paginate_button page-item "><a href="#" aria-controls="example2" data-dt-idx="2" tabindex="0" class="page-link">2</a></li>
                        <li class="paginate_button page-item "><a href="#" aria-controls="example2" data-dt-idx="3" tabindex="0" class="page-link">3</a></li>
                        <li class="paginate_button page-item "><a href="#" aria-controls="example2" data-dt-idx="4" tabindex="0" class="page-link">4</a></li>
                        <li class="paginate_button page-item "><a href="#" aria-controls="example2" data-dt-idx="5" tabindex="0" class="page-link">5</a></li>
                        <li class="paginate_button page-item "><a href="#" aria-controls="example2" data-dt-idx="6" tabindex="0" class="page-link">6</a></li>
                        <li class="paginate_button page-item next" id="example2_next"><a href="#" aria-controls="example2" data-dt-idx="7" tabindex="0" class="page-link">Next</a></li>
                        </ul>
                    </div>
                    </div>
                </div>
                </div>
                </div>
                <!-- /.card-body -->
            </div>
        <!-- /.col -->
	    </div>
	<!-- /.row -->
</div>
<!-- /.container -->

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
    <script>
    $(document).ready(function(){
        $('.zoom').hover(function() {
            $(this).addClass('transition');
        }, function() {
            $(this).removeClass('transition');
        });
    });
    </script>
@endsection