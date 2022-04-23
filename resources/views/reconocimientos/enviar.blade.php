@extends('usuario.principa_usul')
@section('content')
<div class="alert text-center" role="alert" style="background-color:#1bf9cd;">
  <h3>Enviar Reconocimientos</h3>
</div>
<br>
<!---Modal-para buscar-->
    <!-- Button trigger modal -->
    <div class="container">
    <div class="row">
        <div class="col-md-10">

        </div>
        <div class="col-md-2">
        <button type="button" class="btn float-right" data-toggle="modal" data-target="#staticBackdrop" style="background-color:#Ffbd03 ;">
        <i class="fas fa-search"></i> &nbsp; Buscar 
        </button>
        </div>
   </div>
</div>
        <!-- Modal -->
        <div class="modal fade" id="staticBackdrop" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-lg">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Buscar Usuario Por Nombre</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!---Buscar-->
                <div class="container-fluid">
                    <div class="row" id="map_section">
                        <div class="col-12">
                        <form action="#" id="search-form">
                                        @csrf
                                        <div class="row">
                                            <div class="col-12" id="search-wrapper">
                                                <input type="text" class="form-control w-100 m-0 search" placeholder="Ingrese el nombre a buscar ..." aria-label="Search">

                                                <div id="results">

                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                    <br>    
                                    <div id="post" class="mt-5"></div><!--retorna la informacion-->     
                                </div>
                        </div>
                </div>
                  
                <!---end buscar--->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Salir</button>
            </div>
            </div>
        </div>
        </div>
<!---End modal buscar-->
     <br>
<!--tabla de usuarios-->
<div class="container">
        <table class="table table-hover">
        <thead class="bg-primary">
            <tr>
            <th scope="col">No</th>
            <th scope="col">Nombre</th>
            <th scope="col">Apellido</th>
            <th scope="col">Dirección</th>
            <th scope="col">Imagen</th>
            <th scope="col">Acción</th>
            </tr>
        </thead>
        <tbody>
            <?php
              $conta=1;
            ?>
            @foreach($usu as $u)
            <tr>
            <th scope="row">{{$conta++}}</th>
            <td>{{$u->name}}</td>
            <td>{{$u->apellido}}</td>
            <td>{{$u->direccion}}</td>
            <td>
                <!--imagen-->
                <div class="user-panel mt-0 pb-0 mb-0 d-flex">
                        <div class="image">
                        <img src="{{ asset('dist/img/avatar.png')}}" class="img-circle elevation-2" alt="User Image">
                        </div>
                </div>
                <!---end imagen-->
            </td>
            <td>
             <a href="{{route('listareconocer',$u->id)}}" type="button" class="btn" style="color:#ffbd03;" data-toggle="tooltip" title="Enviar Reconocimiento"><i class="fas fa-award  fa-2x"></i></a>
            </td>
            </tr>
            @endforeach
        </tbody>
        </table>
     </div>
<!---end tabla usuarios--->

<script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js" integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous"></script>
<script>
        $(function ()
        {
            'use strict';

            $(document).on('keyup', '#search-form .search', function ()
            {
                if($(this).val().length > 0)
                {
                    var search = $(this).val();

                    $.get("{{ route('posts.search') }}", {search: search}, function (res)
                    {
                        $('#results').html(res);
                    });

                    return;
                }

                $('#results').empty();
            });

            $(document).on('click', '.post-link', function ()
            {
                var postId = $(this).data('id');

                $.get("{{ url('posts/show') }}", {id: postId}, function (res)
                {
                    $('#results').empty();
                    $('.search').val('');
                    $('#post').html(res);
                });
            });
        });
        </script>


@endsection
