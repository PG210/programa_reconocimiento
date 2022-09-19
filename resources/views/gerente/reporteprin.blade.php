@extends('usuario.principa_usul')
@section('content')
<!--collapsed-->
        <div class="accordion" id="accordionExample">
        <div class="card">
            <div class="card-header" id="headingOne">
            <h2 class="mb-0">
                <div class="row titulo">
                    <div class="col-3">
                        <a href="/gerente/informe/1" class="btn btn-link btn-block text-left" type="button">
                        <i class="fas fa-tasks" style="font-size:22px;"></i>&nbsp;&nbsp;Listado sin entregar
                        </a>
                    </div>
                    <div class="col-3">
                        <a href="/gerente/insignias/excel/1" class="btn btn-link btn-block text-left" type="button">
                        <i class="fas fa-file-excel" style="font-size:22px;"></i>&nbsp;&nbsp;Reporte
                        </a>
                    </div>
                    <div class="col-3">
                       <a href="/gerente/informe/2" class="btn btn-link btn-block text-right" type="button">
                       <i class="fas fa-tasks" style="font-size:22px;"></i>&nbsp;&nbsp;Lista entregados
                        </a>
                    </div>
                    <div class="col-3">
                       <a href="/gerente/insignias/excel/2" class="btn btn-link btn-block text-right" type="button" >
                         <i class="fas fa-file-excel" style="font-size:22px;"></i>&nbsp;Reporte
                        </a>
                    </div>
               </div>
            </h2>
            </div>

            <div id="collapseOne" class="collapse show letraform" aria-labelledby="headingOne" data-parent="#accordionExample">
            <div class="card-body">
        <!--table de informacion-->
            <table class="table table-bordered table-responsive">
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
                @if($b==1)
                @foreach($datos as $dat)
               <!--idinsig  nominsig insigdes puntos imginsig
                imgpre categoria -->
               
                <tr>
                <th scope="row">{{$conta++}}</th>
                <td>{{$dat->nombre}} {{$dat->apellido}}</td>
                <td>{{$dat->cargonom}}</td>
                <td>{{$dat->areanom}}</td>
                <td>{{$dat->despremio}}</td>
                @if($dat->entregado==1)
                <td>Sin entregar</td>
                @endif
                @if($dat->entregado==2)
                <td>Entregado</td>
                @endif
                </tr>
                @endforeach
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