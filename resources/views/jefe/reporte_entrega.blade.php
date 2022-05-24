@extends('usuario.principa_usul')
@section('content')
<!--collapsed-->
        <div class="accordion" id="accordionExample">
        <div class="card">
            <div class="card-header" id="headingOne">
            <h2 class="mb-0">
                <div class="row">
                    <div class="col-3">
                        <a href="/reporte/recompensas" class="btn btn-link btn-block text-left" type="button">
                        <i class="fas fa-tasks"></i>&nbsp;Recompensas
                        </a>
                    </div>
                    <div class="col-3">
                        <a href="#" class="btn btn-link btn-block text-left" type="button">
                        <i class="fas fa-file-excel"></i>&nbsp;Reporte
                        </a>
                    </div>
                    <div class="col-3">
                       <a href="{{route('entregados')}}" class="btn btn-link btn-block text-right" type="button">
                       <i class="fas fa-tasks"></i>&nbsp;Lista entregados
                        </a>
                    </div>
                    <div class="col-3">
                       <a href="#" class="btn btn-link btn-block text-right" type="button" >
                         <i class="fas fa-file-excel"></i>&nbsp;Reporte
                        </a>
                    </div>
               </div>
            </h2>
            </div>

            <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionExample">
            <div class="card-body">
        <!--table de informacion-->
            <table class="table table-bordered">
            <thead>
                <tr>
                <th scope="col">No</th>
                <th scope="col">Nombres</th>
                <th scope="col">Cargo</th>
                <th scope="col">Area</th>
                <th scope="col">Recompensa</th>
                <th scope="col">Estado</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $conta=1;
                ?>
                @foreach($datos as $dat)
               <!--idinsig  nominsig insigdes puntos imginsig
                imgpre categoria -->
                <tr>
                <th scope="row">{{$conta++}}</th>
                <td>{{$dat->nombre}} {{$dat->apellido}}</td>
                <td>{{$dat->cargonom}}</td>
                <td>{{$dat->areanom}}</td>
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
                                                <h4 class="modal-title text-center" style="color:black; text-align: center;">
                                                    <span  class="text-center">¿Desea deshacer la entrega a: </span><br> <span style="background-color:yellow;"> {{$dat->nombre}} {{$dat->apellido}}</span> ?
                                                </h4>
                                                <br>
                                            </div>
                                           
                                            <div class="modal-footer">
                                                <a  class="btn btn-success" href="{{ route('entregar', $dat->idinsig) }}">Si</a>
                                                <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!---fin ventana deshabilitar--->

                </td>
                </tr>
                @endforeach
            </tbody>
            </table>
           <!---end table-->
            </div>
            </div>
        </div>
        </div>
<!---end collapse-->
@endsection