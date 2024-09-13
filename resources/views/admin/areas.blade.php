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
<div class="text-center titulo placa mb-3">
   <h3>ORGANIZACIÓN</h3>
</div>
@if(Auth::user()->superadmin!=0)
<!---licencias-->
<div class="container" style="background-color:#e0dede;">     
    <div class="row letraform mb-3">
      <div class="col-lg-12">
      <form action="{{route('reglicencias')}}" method="post">
        @csrf
          <div class="form-row">
            <div class="form-group col-md-2">
              <h5 class="text-left titulo mb-3 mt-3 badge badge-pill badge-info" style="b">Licencias</h5>
              @if(isset($licencias->numlicencia))
                <h6 class="text-left badge badge-pill badge-primary">{{$totaluser}} / {{ $licencias->numlicencia }}</h6>
              @endif
            </div>
            <div class="form-group col-md-2">
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
            <div class="form-group col-md-2 mt-4">
              <button type="submit"  class="btn btn-primary">Modificar</button>
            </div>
          </div>
        </form>
      </div>
    </div>
</div>
<!-- end licencias -->
 @endif
<div class="container row letraform">
    <!---- buttons group -->
    <div class="btn-group" role="group" aria-label="Basic example">
      <button type="button" class="btn" data-toggle="modal" data-target="#staticBackdrop" style="background-color:#5959D1; color:#FFF;">
          <i class="fas fa-pen-alt"></i>&nbsp;Areas
      </button>
      <a type="button" href="{{route('vistacargo')}}" class="btn" style="background-color:#FFBD03; color:#FFF;"> <i class="fas fa-pen-alt"></i>&nbsp;Cargos</a>
      <a type="button" href="{{route('vincular_jefes')}}" class="btn btn-info" style="color:white;"><i class="fas fa-users"></i>&nbsp;Vincular Jefes</a>
    </div>
    <!--- end buttons group---->
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
                        <h5 class="modal-title" id="staticBackdropLabel">Formulario Areas</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body letraform">
                        <!--##############-->
                            
                            <div class="form-row">
                                <div class="col">
                                <input type="text" id="nombre" name="nombre" class="form-control" placeholder="Nombre" required> 
                                </div>
                            </div>
                        <!----############--->
                    </div>
                    <div class="modal-footer letraform">
                        <button type="submit" class="btn confirmar">Guardar</button>
                        <button type="button" class="btn salir" data-dismiss="modal">Cancelar</button>
                    </div>
                    </div>
                </div>
                </div>
                </form>
       <!--##################--->
      @if(Session::has('mensaje'))
        <br>
        <div class="alert alert-info alert-dismissible fade show letraform" role="alert">
        <strong>{{Session::get('mensaje')}}</strong> 
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        </div>
        @endif
        @if(Session::has('mensajeerror'))
        <br>
        <div class="alert alert-danger alert-dismissible fade show letraform" role="alert">
        <strong>{{Session::get('mensajeerror')}}</strong> 
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        </div>
        @endif
      <table class="table letraform mt-3">
        <thead class="tablaheader">
            <tr>
            <th scope="col">No</th>
            <th scope="col">Area</th>
            <th scope="col">Acción</th>
            </tr>
        </thead>
        <tbody>
          @foreach($areas as $area)
            <tr>
              <td>{{$area->id}}</td>
              <td>{{$area->nombre}}</td>
              <td>
                 <a href="/eliminar/area/{{$area->id}}" type="submit" class="btn btn-danger"> <i class="fas fa-trash-alt"></i></a>
              </td>
            </tr>
          @endforeach
        </tbody>
        </table>
    </div>
</div>
@endsection