@extends('usuario.principa_usul') @section('content')

<!-- Content Header (Page header) -->
<div class="content-header">
 <div class="container">
  <div class="row mb-2">
   <div class="col-sm-8">
    <h1 class="m-0">Control votaciones</h1>
   </div>
   <!-- /.col -->
   <div class="col-sm-4">
    <ol class="breadcrumb float-sm-right">
     <li class="breadcrumb-item"><a href="#">Inicio</a></li>
     <li class="breadcrumb-item active">Control votaciones</li>
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
  <div class="col-12">
   <!-- Acciones Rápidas del Administrador -->
   <div class="card p-4 mb-2">
    <h4 class="card-title mb-2" style="color: #716f6e;font-size: 1.5rem;font-weight: 600;">Acciones rapidas</h4>

    <div class="row">
     <div class="col-md-3">
      <div class="">
       <!--button-->
       @if(isset($es[0])) @if($es[0]->estado==2)
       <button type="button" class="btn btn-success w-100 mb-2" data-toggle="modal" data-target="#staticBackdrop">
       ✅ Habilitar
       </button>
       <!-- Button trigger modal -->
       <!-- Modal -->
       <form action="{{route('hab_votaciones')}}" method="POST">
        @csrf
        <div class="modal fade" id="staticBackdrop" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
         <div class="modal-dialog">
          <div class="modal-content">
           <div class="modal-header" style="background-color:#1ED5F4;">
            <h5 class="modal-title" id="staticBackdropLabel">Configuración de Votaciones</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
           </div>
           <div class="modal-body">
            <p>¿Seguro que quieres desactivar las votaciones?</p>
            <p>⚠️ Esto detendrá la participación del equipo en este periodo. Puedes reactivarlas en cualquier momento.</p>
            <div class="row">
             <div class="col-6">
              <label>Año</label>
              <input id="anio" name="anio" class="form-control" value="{{$anio}}" readonly="readonly" style="background-color:white;">
             </div>
             <div class="col-6">
              <label>Periodo</label>
              <select class="custom-select" id="per" name="per">
                                    <option selected>Elegir...</option>
                                    <option value="A">A</option>
                                    <option value="B">B</option>
                                </select>
              <input id="val" name="val" class="form-control" value="1" hidden>
             </div>
            </div>
           </div>
           <div class="modal-footer">
           <button type="button" class="btn btn-default salir" data-dismiss="modal">Cerrar</button>
           <button type="submit" class="btn btn-primary confirmar">Deshabilitar</button>
           </div>
          </div>
         </div>
        </div>
       </form>
       @endif @endif @if($total==0)
       <button type="button" class="btn btn-success w-100 mb-2" data-toggle="modal" data-target="#staticBackdrop">
            ✅ Habilitar
        </button>
       <!-- Button trigger modal -->
       <!-- Modal -->
       <form action="{{route('hab_votaciones')}}" method="POST">
        @csrf
        <div class="modal fade" id="staticBackdrop" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
         <div class="modal-dialog">
          <div class="modal-content">
           <div class="modal-header titulo">
            <h5 class="modal-title" id="staticBackdropLabel">Configuración de Votaciones</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
           </div>
           <div class="modal-body">
           <p>¿Seguro que quieres activar las votaciones?</p>
           <p>📅 Selecciona el año y el periodo para comenzar. 🚀</p>
            <div class="row">
             <div class="col-6">
              <label>Año</label>
              <input id="anio" name="anio" class="form-control" value="{{$anio}}" readonly="readonly">
             </div>
             <div class="col-6">
              <label>Periodo</label>
              <select class="custom-select" id="per" name="per">
                                    <option selected>Elegir...</option>
                                    <option value="A">A</option>
                                    <option value="B">B</option>
                                </select>
              <input id="val" name="val" class="form-control" value="1" hidden>
             </div>
            </div>
           </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default salir" data-dismiss="modal">Cerrar</button>
              <button type="submit" class="btn btn-success confirmar">Habilitar</button>
            </div>
          </div>
         </div>
        </div>
       </form>
       @endif
       <!--end modal-->
       @if(isset($es[0]->estado)==1)
       <button type="button" class="btn btn-danger w-100 mb-2 d-none d-sm-none d-md-block" data-toggle="modal" data-target="#staticBackdropvot1">
                                ❌ Deshabilitar
                        </button>
       <button type="button" class="btn btn-danger w-100 mb-2 d-block d-sm-block d-md-none" data-toggle="modal" data-target="#staticBackdropvot1">
                            Deshabilitar 
                        </button>
       <!-- Modal -->
       <div class="modal fade" id="staticBackdropvot1" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
         <div class="modal-content">
          <div class="modal-header titulo">
           <h5 class="modal-title" id="staticBackdropLabel">Deshabilitar Votaciones</h5>
           <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
          </div>
          <div class="modal-body">
           ¿Desea deshabilitar las votaciones {{$es[0]->anio}} {{$es[0]->periodo}}?
          </div>
          <div class="modal-footer">
           <a href="/deshab/votacion/{{$es[0]->ides}}/2" type="button" class="btn confirmar">Si</a>
           <button type="button" class="btn salir" data-dismiss="modal">No</button>
          </div>
         </div>
        </div>
       </div>
       <!--end modal-->
       @endif
      </div>
      <p class="small m-0 text-center">Activa o desactiva según lo que necesites.</p>
     </div>
     <div class="col-md-3">
      <!-- Button trigger modal -->
      <button type="button" class="btn btn-primary w-100 mb-2" data-toggle="modal" data-target="#filtrarcat">
                        🏆 Filtrar por Categoría
                        </button>
      <!--end buton-->
      <p class="small m-0 text-center">Descubre la categoria por periodos.</p>
     </div>
     <div class="col-md-3">
      <button type="button" class="btn btn-success w-100 mb-2" data-toggle="modal" data-target="#filtrarvotos">
                    🔍 Filtrar por Votos    
                    </button>
      <p class="small m-0 text-center">Descubre los votos por periodos.</p>
     </div>
     <div class="col-md-3">
        <!--generar excel de los datos -->
        <button type="button" class="btn btn-warning w-100 mb-2" data-toggle="modal" data-target="#excel">
        📁 Generar Reportes
        </button>
      <p class="small m-0 text-center">Descargar datos clave en Excel/PDF.</p>
     </div>
    </div>
   </div>
    <!-- Modales -->
    <div class="">
     <!--modal para reportes de excel-->
        <div class="modal fade" id="excel" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
         <div class="modal-dialog">
          <div class="modal-content">
           <div class="modal-header titulo">
            <h5 class="modal-title" id="exampleModalLabel">Generar reportes de votación</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
           </div>
           <form action="{{route('excelVotos')}}" method="POST">
            @csrf
            <div class="modal-body letraform">
             <!---inputs-->
             <div class="row">
                <p>📌 Selecciona el año, periodo y estado de votación para generar el informe con el total de votos recibidos. 🚀</p>
              <div class="col-6">
               <div class="form-group">
                <label for="exampleFormControlSelect1">Año</label>
                <select class="form-control" id="aniovot" name="aniovot">
                                   @foreach($esfil as $fil)
                                        @if(isset($fil->anio))
                                            <option val="{{$fil->anio}}">{{$fil->anio}}</option>
                                        @endif
                                    @endforeach
                                </select>
               </div>
              </div>
              <div class="col-6">
               <div class="form-group">
                <label for="exampleFormControlSelect1">Periodo</label>
                <select class="form-control" id="pervot" name="pervot">
                                <option value="A">A</option>
                                <option value="B">B</option>
                                </select>
               </div>
              </div>
             </div>
             <!--seleccion-->
             <div class="row">
              <div class="col-12">
               <div class="form-group">
                <label for="usuarios">Seleccionar estado de votación</label>
                <select class="form-control" id="usuarios" name="usuarios">
                                    <option value="1">Total de votos recibidos</option>
                                    <option value="2">Usuarios que han votado</option>
                                    <option value="3">Usuarios que no han votado</option>
                                </select>
               </div>
              </div>
             </div>
             <!--end inputs-->
            </div>
            <div class="modal-footer justify-content-between">
            <button type="button" class="btn btn-default salir" data-dismiss="modal">Salir</button>
            <button type="submit" class="btn btn-success confirmar"><i class="fas fa-download"></i>&nbsp;Descargar</button>
             
            </div>
           </form>
          </div>
         </div>
        </div>
        <!--- end reporte-->
        <form action="{{route('filtrarVotos')}}" method="post">
         @csrf
         <!-- Modal -->
         <div class="modal fade" id="filtrarvotos" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog">
           <div class="modal-content">
            <div class="modal-header titulo">
             <h5 class="modal-title" id="exampleModalLabel">Seleccionar Año y Periodo</h5>
             <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
            </div>
            <div class="modal-body letraform">
             <!---inputs-->
             <div class="row">
                <p>📌 Elige el periodo que deseas analizar y accede a la información relevante.</p>
              <div class="col-6">
               <div class="form-group">
                <label for="exampleFormControlSelect1">Año</label>
                <select class="form-control" id="aniofil" name="aniofil">
                                   @foreach($esfil as $fil)
                                        @if(isset($fil->anio))
                                            <option val="{{$fil->anio}}">{{$fil->anio}}</option>
                                        @endif
                                    @endforeach
                                </select>
               </div>
              </div>
              <div class="col-6">
               <div class="form-group">
                <label for="exampleFormControlSelect1">Periodo</label>
                <select class="form-control" id="peri" name="peri">
                                <option value="A">A</option>
                                <option value="B">B</option>
                                </select>
               </div>
              </div>
             </div>
             <!--end inputs-->
            </div>
            <div class="modal-footer justify-content-between">
            <button type="button" class="btn btn-default salir" data-dismiss="modal">Cerrar</button>
             @if(isset($esfil[0]->anio))
             <button type="submit" class="btn btn-success confirmar"><i class="fas fa-search"></i> Filtrar</button> @endif
            </div>
           </div>
          </div>
         </div>
        </form>
        <!--end filtrar-->
        <!--filtrar por categoria-->
        <!-- Button trigger modal -->
        <!-- Modal -->
        <form action="{{route('listaVot')}}" method="POST">
         @csrf
         <div class="modal fade" id="filtrarcat" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog">
           <div class="modal-content">
            <div class="modal-header titulo">
             <h5 class="modal-title" id="exampleModalLabel">Filtrar Votos Por Categoria</h5>
             <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
            </div>
            <div class="modal-body letraform">
             <!--mostrar categorias-->
             <div class="row">
              <div class="col-12">
                <p>📌 Selecciona la categoría, año y periodo para obtener los resultados que necesitas. </p>
               <div class="form-group">
                <label for="categoria">Categoria</label>
                <select class="form-control" id="categoria" name="categoria">
                                      @foreach($cat as $c)
                                        @if(isset($c->descripcion))
                                          <option value="{{$c->idcat}}">{{$c->descripcion}}</option>
                                        @endif
                                      @endforeach
                                    </select>
               </div>
              </div>
             </div>

             <div class="row">
              <div class="col-6">
               <div class="form-group">
                <label for="exampleFormControlSelect1">Año</label>
                <select class="form-control" id="anio" name="anio">
                                    
                                    @foreach($esfil as $fil)
                                        @if(isset($fil->anio))
                                            <option val="{{$fil->anio}}">{{$fil->anio}}</option>
                                        @endif
                                    @endforeach
                                    </select>
               </div>
              </div>
              <div class="col-6">
               <div class="form-group">
                <label for="exampleFormControlSelect1">Periodo</label>
                <select class="form-control" id="per" name="per">
                                    <option value="A">A</option>
                                    <option value="B">B</option>
                                    </select>
               </div>
              </div>
             </div>
             <!--end categorias-->
            </div>
            
            <div class="modal-footer justify-content-between">
             <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
             @if(isset($esfil[0]->anio))
             <button type="submit" class="btn btn-success"><i class="fas fa-search"></i> Filtrar</button> @endif
            </div>
           </div>
          </div>
         </div>
        </form>
        <!--end filtrar por categoria-->
    </div>
  </div>
 </div>

    <!-- errores -->
    @if(Session::has('mensajeEx'))
       <div class="col-12 letraform">
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
         <strong> {{ Session::get('mensajeEx') }}</strong>
         <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
       </div>
       @endif

       @if(Session::has('errorhab'))

       <div id="toastsContainerTopRight" class="toasts-top-right fixed">
              <div class="toast bg-warning fade show " role="alert" aria-live="assertive" aria-atomic="true">
                <div class="toast-header px-2 py-4">
                  <i class="mr-2 fas fa-x fa-lg"></i>
                  <strong class="mr-auto">{{Session::get('errorhab')}}</strong>
                  <small></small>
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">×</span>
                  </button>
                </div>
              </div>
             </div>
     @endif @if(Session::has('errorfitrar'))
            <div id="toastsContainerTopRight" class="toasts-top-right fixed">
              <div class="toast bg-warning fade show " role="alert" aria-live="assertive" aria-atomic="true">
                <div class="toast-header px-2 py-4">
                  <i class="mr-2 fas fa-x fa-lg"></i>
                  <strong class="mr-auto">{{Session::get('errorfitrar')}}</strong>
                  <small></small>
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">×</span>
                  </button>
                </div>
              </div>
             </div>
             
     @endif

       
 <div class="row mb-2">
  <div class="col-12">
    
<!---Aqui generar los usuarios que han votado -->
<h5 class="letraform mb-2">Postular Colaboradores</h5>
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
                        <form action="{{route('postularVot')}}" method="POST">
                            @csrf
                            <div class="table-responsive">
                            <table class="table table-hover table-estadisticas" id="votacion01">
                            <thead>
                            <tr>
                                <th scope="col">No</th>
                                <th scope="col">Nombres</th>
                                <th scope="col">Cargo</th>
                                <th scope="col">
                                <div class="text-center">
                                <button type="submit" class="btn btn-info btn-sm"><i class="fas fa-hand-pointer"></i> Postular</button>
                                </div>
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($users as $usu)
                            <tr>
                                <th scope="row">{{ $loop->iteration }}</th>
                                <td>{{$usu->name}} {{$usu->apellido}}</td>
                                <td>{{$usu->cargo}}</td>
                                <td>
                                    <div class=" text-center">
                                        <input class="" type="checkbox" value="{{$usu->idusu}}" id="defaultCheck1{{$usu->idusu}}" name="user[]" @if($usu->postulado == '1') checked @endif>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                            </tbody>
                            </table>
                            </div>
                        </form>
                        <!--end votos-->
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
<!-- /.content-header -->
<script>
 // Función para filtrar la tabla en base al input de búsqueda
 	    $('#search').on('keyup', function() {
 	        var value = $(this).val().toLowerCase();
 	        $('#votacion01 tbody tr').filter(function() {
 	            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
 	        });
 	    });
 	
 
</script>
@endsection