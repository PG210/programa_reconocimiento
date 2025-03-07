@extends('usuario.principa_usul')
@section('content')

<!-- Content Header (Page header) -->
<div class="content-header">
	<div class="container">
		<div class="row mb-2">
			<div class="col-sm-8">
				<h1 class="m-0">Recompensas en ReconoSER</h1> 
			</div>
			<!-- /.col -->
			<div class="col-sm-4">
				<ol class="breadcrumb float-sm-right">
					<li class="breadcrumb-item"><a href="#">Inicio</a></li>
					<li class="breadcrumb-item active">Recompensas entregadas</li>
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
            <div class="col-12 col-md-3">
                <div class="row">
                    <div class="col-12">
                        <!-- small box -->
                        <div class="small-box bg-success">
                        
                        <div class="inner">
                            <a href="{{route('entregados')}}" type="button" style="color: var(--dark);">
                            <h3>150</h3>

                            <p>Recompensas entregadas</p>
                            </a>  
                        </div>
                        <div class="icon">
                            
                            <i class="fas fa-hand-holding-heart"></i>
                        </div>
                        
                        <a href="/reporte/insignias/excel/2" type="button" class="small-box-footer">Descargar reporte <i class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <!-- ./col -->

                    <div class="col-12">
                        <!-- small box -->
                        <div class="small-box bg-warning">
                        <div class="inner">
                            <a href="/reporte/recompensas" type="button" style="color: var(--dark);">
                            <h3>150</h3>

                            <p>Recompensas sin entregar</p>
                            </a>
                        </div>
                        <div class="icon">
                            <i class="fas fa-exclamation"></i>
                        </div>
                        <a href="/reporte/insignias/excel/1" type="button" class="small-box-footer">Descargar reporte <i class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <!-- ./col -->
                </div>
            </div>
            <div class="col-12 col-md-9">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Recompensas entregadas</h3>

                        <div class="card-tools">
                        <!---========= buscador =============-->
                        <div class="input-group " style="width: 210px;">
                            <input type="text" name="table_search" class="form-control" id="searchTerm" onkeyup="doSearch()" placeholder="Buscar...">
                        </div>
                        <!---========= / buscador =============-->
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body table-responsive p-0">
                    <!--table de informacion-->
                        <div class="table-responsive">
                            <table class="table table-hover table-estadisticas">
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
        </div>
    </div>
@endsection