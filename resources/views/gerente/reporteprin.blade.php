@extends('usuario.principa_usul')
@section('content')
    @include('usuario.datatables')

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
                        <li class="breadcrumb-item active">Recompensas sin entregar</li>
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
                                <a href="/gerente/informe/2" type="button" style="color: var(--dark);">
                                    <h3>
                                       @if(isset($totalentrega)) {{ $totalentrega }} @endif
                                    </h3>

                                    <p>Recompensas entregadas</p>
                                </a>
                            </div>
                            <div class="icon">

                                <i class="fas fa-hand-holding-heart"></i>
                            </div>

                            <a href="/gerente/insignias/excel/2" type="button" class="small-box-footer">Descargar reporte <i
                                    class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <!-- ./col -->

                    <div class="col-12">
                        <!-- small box -->
                        <div class="small-box bg-warning">
                            <div class="inner">
                                <a href="/gerente/informe/1" type="button" style="color: var(--dark);">
                                    <h3>
                                         @if(isset($totalsinentrega)) {{ $totalsinentrega }} @endif
                                    </h3>
                                    <p>Recompensas sin entregar</p>
                                </a>
                            </div>
                            <div class="icon">
                                <i class="fas fa-exclamation"></i>
                            </div>
                            <a href="/gerente/insignias/excel/1" type="button" class="small-box-footer">Descargar reporte <i
                                    class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <!-- ./col -->
                </div>
            </div>
            <div class="col-12 col-md-9">
                <div class="card">
                    <!-- /.card-header -->
                    <div class="card-body p-0">
                        <!--table de informacion-->
                        <div class="container table-responsive mt-3">
                            <table class="table table-hover table-estadisticas" id="tabla2">
                                <thead>
                                    <tr>
                                        <th scope="col">No</th>
                                        <th scope="col">Nombres</th>
                                        <th scope="col">Cargo</th>
                                        <th scope="col">Area</th>
                                        <th scope="col">Tipo recompensa</th>
                                        <th scope="col">Recompensa</th>
                                        <th scope="col">Estado</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(isset($datos))
                                            @foreach($datos as $dat)
                                            <!--idinsig  nominsig insigdes puntos imginsig
                                                imgpre categoria -->
                                                    <tr>
                                                        <th scope="row">{{$loop->iteration}}</th>
                                                        <td>{{$dat->nombre}} {{$dat->apellido}}</td>
                                                        <td>{{$dat->cargonom}}</td>
                                                        <td>{{$dat->areanom}}</td>
                                                        <td>{{$dat->nompre}}</td>
                                                        <td>{{$dat->despremio}}</td>
                                                        <td>
                                                            @if($dat->entregado == 1)
                                                                Sin entregar
                                                            @else
                                                                Entregado
                                                            @endif
                                                        </td>
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
        </div>
    </div>
    <!---end collapse-->
    <script>
        $('#tabla2').DataTable({
            "language": {
                "url": "https://cdn.datatables.net/plug-ins/1.10.24/i18n/Spanish.json"
            },
        });
    </script>
@endsection