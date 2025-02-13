@extends('usuario.principa_usul')
@section('content')

<!-- Content Header (Page header) -->
<div class="content-header">
	<div class="container">
		<div class="row mb-2">
			<div class="col-sm-8">
				<h1 class="m-0">Mis metricas</h1>
			</div>
			<!-- /.col -->
			<div class="col-sm-4">
				<ol class="breadcrumb float-sm-right">
					<li class="breadcrumb-item"><a href="#">Inicio</a></li>
					<li class="breadcrumb-item active">Mis metricas</li>
				</ol>
			</div>
			<!-- /.col -->
		</div>
		<!-- /.row -->
	</div>
	<!-- /.container-fluid -->
</div>
<!-- /.content-header -->
 
<!--collapsed-->
        <div class="accordion" id="accordionExample">
        <div class="card">
            <div class="card-header" id="headingOne">
            <h2 class="mb-0">
                <div class="row titulo">
                    <div class="col-3">
                        <a href="/reporte/recompensas" class="btn btn-link btn-block text-left" type="button">
                        <i class="fas fa-tasks" style="font-size:22px;"></i>&nbsp;&nbsp;Listado sin entregar
                        </a>
                    </div>
                    <div class="col-3">
                        <a href="/reporte/insignias/excel/1" class="btn btn-link btn-block text-left" type="button">
                        <i class="fas fa-file-excel" style="font-size:22px;"></i>&nbsp;&nbsp;Reporte
                        </a>
                    </div>
                    <div class="col-3">
                       <a href="{{route('entregados')}}" class="btn btn-link btn-block text-right" type="button">
                       <i class="fas fa-tasks" style="font-size:22px;"></i>&nbsp;&nbsp;Lista entregados
                        </a>
                    </div>
                    <div class="col-3">
                       <a href="/reporte/insignias/excel/2" class="btn btn-link btn-block text-right" type="button" >
                         <i class="fas fa-file-excel" style="font-size:22px;"></i>&nbsp;Reporte
                        </a>
                    </div>
               </div>
            </h2>
            </div>

            <div id="collapseOne" class="collapse show letraform" aria-labelledby="headingOne" data-parent="#accordionExample">
            <div class="card-body">
        <!--table de informacion-->
            <table class="table table-bordered">
            <thead>
                <tr>
                <th scope="col">No</th>
                <th scope="col">Nombres</th>
                <th scope="col">Insignia</th>
                <th scope="col">Tipo recompensa</th>
                <th scope="col">Recompensa</th>
                <th scope="col">Estado</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $conta=1;
                ?>
                @if($b==0)
                @foreach($datos as $dat)
               <!--idinsig  nominsig insigdes puntos imginsig
                imgpre categoria -->
                <tr>
                <th scope="row">{{$conta++}}</th>
                <td>{{$dat->nombre}} {{$dat->apellido}}</td>
                <td>{{$dat->nominsig}}</td>
                <td>{{$dat->nompre}}</td>
                <td>{{$dat->despremio}}</td>
                <td>Entregado</td>
                <td>
                   <!--#######################################3-->
                   <?php
                        if($dat->estado == 1){
                            ?>
                            <a type="button" data-toggle="modal" data-target="#cambiarPro{{$dat->idinsig}}" data-placement="bottom"  title="Deshabilitar"><i class="far fa-square"></i></a>
                            <?php
                        }else{
                            ?>
                            <a type="button" data-toggle="modal" data-target="#cambiarPro{{$dat->idinsig}}" data-placement="bottom"  title="Habilitar"><i class="fas fa-check-square" style="color:#1ED5F4;"></i></a>
                            <?php
                        }
                        ?>
                        <!-- Ventana modal para deshabilitar -->
                        <div class="modal fade" id="cambiarPro{{$dat->idinsig}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div style="background-color:white !important;">
                                                <br>
                                                <h5 class="modal-title text-center titulo" style="color:black; text-align: center;">
                                                    <span  class="text-center">¿Desea deshacer la entrega a: </span><br> <span style="background-color:yellow;"> {{$dat->nombre}} {{$dat->apellido}}</span> ?
                                                </h5>
                                                <br>
                                            </div>
                                           
                                            <div class="modal-footer">
                                                 <button type="button" class="btn salir" data-dismiss="modal">No</button>
                                                 <a  class="btn confirmar" href="{{ route('entregar', $dat->idinsig) }}">Si</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!---fin ventana deshabilitar--->

                </td>
                </tr>
                @endforeach
                @endif
                @if($b==1)
                <?php
                $con=1;
                for($i=0;$i<count($res);$i++) {

                    for($j=0;$j<count($res[$i]);$j++) {


                    echo '<tr>
                            <td>'.$con++.'</td>
                            <td>'.$res[$i][$j]->nombre." ".$res[$i][$j]->apellido.'</td>
                            <td>'.$res[$i][$j]->nominsig.'</td>
                            <td>'.$res[$i][$j]->nompre.'</td>
                            <td>'.$res[$i][$j]->despremio.'</td>
                            <td>'."Entregado".'</td>
                        </tr>';

                  }

                }
                ?>
                @endif
            </tbody>
            </table>
           <!---end table-->
            </div>
            </div>
        </div>
        </div>
<!---end collapse-->
@endsection