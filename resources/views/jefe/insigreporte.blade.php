@extends('usuario.principa_usul')
@section('content')
    @include('usuario.datatables')

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

                    <!-- /.card-header -->
                    <div class="px-3 mt-3">
                        <div class="table-responsive">
                            <table class="table table-hover table-estadisticas" id="dataTable11">
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
                                    @if($b == 1)
                                        @foreach($coninsig as $c)
                                            <tr>
                                                <th scope="row">{{$loop->iteration}}</th>
                                                <td>{{$c->name}}</td>
                                                <td>{{$c->descripcion}}</td>
                                                <td>{{$c->puntos}}</td>
                                                <td>
                                                    <div class="text-center">
                                                        <img src="{{asset('imgpremios/' . $c->imginsig)}}" class="rounded zoom"
                                                            alt="..." width="50px" height="50px">
                                                    </div>
                                                </td>
                                                <td>{{$c->nompre}}</td>
                                                <td>{{$c->despremio}}</td>
                                                <td>
                                                    <div class="text-center">
                                                        <img src="{{asset('imgpremios/' . $c->imgpre)}}" class="rounded zoom"
                                                            alt="..." width="50px" height="50px">
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
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
    <script>
        //datatables
        $('#dataTable11').DataTable({
            "language": {
                "url": "https://cdn.datatables.net/plug-ins/1.10.24/i18n/Spanish.json"
            },
        });
    </script>
@endsection