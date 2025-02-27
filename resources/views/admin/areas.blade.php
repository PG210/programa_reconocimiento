@extends('usuario.principa_usul')
@section('content')
<style>
  .placa {
    background-color:#e0e0e0; /* Gris claro */
    border: 1px solid #dee2e6; /* Borde gris claro */
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Sombra */
    border-radius: 5px; /* Bordes redondeados (opcional) */
}
</style>
<!-- Content Header (Page header) -->
<div class="content-header">
 <div class="container"> 
  <div class="row mb-2">
   <div class="col-sm-8">
    <h1 class="m-0">Configuración de la empresa</h1>
   </div>
   <!-- /.col -->
   <div class="col-sm-4">
    <ol class="breadcrumb float-sm-right">
     <li class="breadcrumb-item"><a href="#">Inicio</a></li>
     <li class="breadcrumb-item active">Empresa</li>
    </ol>
   </div>
   <!-- /.col -->
  </div>
  <!-- /.row -->
 </div>
 <!-- /.container-fluid -->
</div>
<!-- /.content-header -->

@if(Auth::user()->superadmin!=0)
<!---licencias-->
<div class="container">    
<form action="{{route('reglicencias')}}" method="post">
@csrf 
    <div class="row mb-3">
      
      <div class="col-lg-4 col-12"> 
        <div class="col-12">
					<!-- small box -->
					<div class="small-box bg-warning">
						<div class="inner">
							<p class="m-0">Licencias</p>
							
              @if(isset($licencias->numlicencia))
                <h5>{{$totaluser}} / {{ $licencias->numlicencia }}</h5>
              @endif
							<p class="m-0"><b>0</b> Licencias disponibles.</p>
						</div>
						<div class="icon">
							<i class="ion ion-person-add"></i>
						</div>
						<a href="#" class="small-box-footer">Comprar más <i class="fas fa-arrow-circle-right"></i></a>
					</div>
				</div>
      </div>
      <div class="col-lg-8 col-12">
      <div class="card p-4 mb-2">
          <div class="form-row" style="align-items: flex-end;">
            <div class="form-group col-md-3">
              <label for="inputPassword4">Ocupadas</label>
              <input type="number" min="0" value="{{$totaluser}}" class="form-control" id="ocupadas" name="ocupadas" readonly>
            </div>
            <div class="form-group col-md-3">
              <label for="inputEmail4">Asignadas</label>
              <input type="number" min="{{$totaluser}}" value="{{ $licencias->numlicencia ?? '' }}" class="form-control" id="asig" name="asig" required>
            </div>
            <div class="form-group col-md-3">
              <label for="vencimiento">Vencimiento </label>
              <input type="date" class="form-control" min="{{$date}}" value="{{ \Carbon\Carbon::parse($licencias->vencimiento ?? '')->format('Y-m-d') }}" id="vencimiento" name="vencimiento" required>
            </div>
            <div class="form-group col-md-3 mt-4">
              <button type="submit"  class="btn btn-primary w-100">Modificar</button>
            </div>
          </div>
        </form>
      </div></div>
    </div>
</div>
<!-- end licencias -->
 @endif

  <!--##################--->
  @if(Session::has('mensaje'))
        <div class="alert alert-info alert-dismissible fade show letraform" role="alert">
        <strong>{{Session::get('mensaje')}}</strong> 
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        </div>
        @endif
        @if(Session::has('mensajeerror'))
        <div class="alert alert-danger alert-dismissible fade show letraform" role="alert">
        <strong>{{Session::get('mensajeerror')}}</strong> 
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        </div>
        @endif

<div class="container">
<div class="row mb-2">
  <div class="col-12">
    
  <div class="card">

                    <div class="card-header">
                       <!---- buttons group -->
                      <div class="btn-group" role="group" aria-label="Basic example">
                        <button type="button" class="btn" data-toggle="modal" data-target="#staticBackdrop" style="background-color:#5959D1; color:#FFF;">
                            <i class="fas fa-pen-alt"></i>&nbsp;Areas
                        </button>
                        <a type="button" href="{{route('vistacargo')}}" class="btn" style="background-color:#FFBD03; color:#FFF;"> <i class="fas fa-pen-alt"></i>&nbsp;Cargos</a>
                        <a type="button" href="{{route('vincular_jefes')}}" class="btn btn-info" style="color:white;"><i class="fas fa-users"></i>&nbsp;Vincular Jefes</a>
                      </div>
                      <!--- end buttons group---->
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
            <th scope="col" class="text-center" style="width: 100px">No.</th>
            <th scope="col">Área</th>
            <th scope="col" class="text-center" style="width: 100px">Acción</th>
            </tr>
        </thead>
        <tbody>
          @foreach($areas as $area)
            <tr>
              <td class="text-center">{{$area->id}}</td>
              <td>{{$area->nombre}}</td>
              <td class="text-center"><!-- Colocar una ventana modal que pregunte si esta seguro de eliminar la área-->
                      <div class="btn-group">
                        <a href="/eliminar/area/{{$area->id}}" type="submit" class="btn btn-outline-danger btn-sm"> <i class="fas fa-trash-alt"></i></a>
                        
                      </div>
                      
              </td>
            </tr>
          @endforeach
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
  <!-- /.row -->
 </div>
 <!-- /.container-fluid -->

</div>


<div class="container row letraform">
   
</div>
<div class="row">
    <div class="col-md-12">
       <!---#################-->
          <!-- Button trigger modal -->
                <!-- Modal -->
                <form action="{{route('guardararea')}}" method="post">
                @csrf
                <div class="modal fade" id="staticBackdrop" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                    <div class="modal-header titulo">
                        <h5 class="modal-title" id="staticBackdropLabel">Adicionar una nueva área</h5>
                        
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body letraform">
                      <p>Escriba la área de la empresa que desea crear en el sistema</p>
                        <!--##############-->
                            
                            <div class="form-row">
                                <div class="col">
                                <input type="text" id="nombre" name="nombre" class="form-control" placeholder="Nombre" required> 
                                </div>
                            </div>
                        <!----############--->
                    </div>
                    <div class="modal-footer justify-content-between">
                      <button type="button" class="btn btn-default salir" data-dismiss="modal">Cerrar</button>
                      <button type="submit" class="btn btn-success confirmar">Adicionar</button>
                    </div>
                    </div>
                </div>
                </div>
                </form>
      
      
    </div>
</div>
@endsection