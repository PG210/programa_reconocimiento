@extends('usuario.principa_usul')
@section('content')
<div class="accordion" id="accordionExample">
  <div class="card">
    <div class="card-header">
        <div class="row">
            <div class="col-4">
                <a href="/admin/votacion" class="btn text-left" type="button"  aria-controls="collapseOne">
                  <i class="fas fa-home" style="font-size:23px;"></i>
                </a>
            </div>
            <div class="col-8">
                <h4 class="text-left">Categoria: 
                    @if(isset($cat[0]))
                    {{$cat[0]->categoria}}
                    @endif
                </h4>
            </div>
        </div>
    </div>
    <div class="collapse show" aria-labelledby="headingOne">
      <div class="card-body">
       <!--table-->
       <table class="table">
            <thead style="background-color:#Ffbd03;">
                <tr>
                <th scope="col">No</th>
                <th scope="col">Periodo</th>
                <th scope="col">Imagen </th>
                <th scope="col">Nombre</th>
                <th scope="col">Apellido</th>
                <th scope="col">Cargo</th>
                <th scope="col">Area</th>
                <th scope="col">Votos</th>
                </tr>
            </thead>
            <tbody>
               <?php
                    $conta=1;
                ?>
                @foreach($cat as $c)
                 @if(isset($c->categoria))
                    <tr>
                    <th scope="row">{{$conta++}}</th>
                    <td>{{$c->anio}} - {{$c->periodo}}</td>
                    <td>
                        @if($c->imagen==NULL)
                        <div class="user-panel mt-0 pb-0 mb-0 d-flex">
                            <div class="image">
                            <img src="{{asset('dist/imgperfil/perfil_no_borrar.jpeg')}}" class="img-circle elevation-1" alt="User Image" style="padding-bottom:2px;" >
                            </div>
                        </div>
                        @endif
                        @if($c->imagen!=NULL)
                        <!--imagen-->
                        <div class="user-panel mt-0 pb-0 mb-0 d-flex">
                                <div class="image">
                                <img src="{{asset('dist/imgperfil/'.$c->imagen)}}" class="img-circle elevation-1" alt="User Image" style="padding-bottom:2px; width">
                                </div>
                        </div>
                        @endif
                    </td>
                    <td>{{$c->name}}</td>
                    <td>{{$c->apellido}}</td>
                    <td>{{$c->nomcar}}</td>
                    <td>{{$c->areanom}}</td>
                    <td>{{$c->total}}</td>
                    </tr>
                 @endif
                @endforeach
            </tbody>
            </table>
       <!--end table-->
    
      </div>
    </div>
  </div>
</div>
@endsection