@extends('usuario.principa_usul')
@section('content')
<style>
  .placa {
    background-color:#e0e0e0; /* Gris claro */
    border: 1px solid #dee2e6; /* Borde gris claro */
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Sombra */
    border-radius: 5px; /* Bordes redondeados (opcional) */
  }

  .buttonAct {
    background-color: white; 
    color: black; 
    border: 2px solid #04AA6D;
  }
</style>
<div class="row placa mb-3">
  <div class="col-lg-2 col-md-2 col-sm-2 col-2">
  </div>
  <div class="col-lg-8 col-md-8 col-sm-8 col-8">
      <div class="text-center titulo">
        <span> <h3>CELEBRACIONES ESPECIALES</h3></span>
      </div>
  </div>
  <div class="col-lg-2 col-md-2 col-sm-2 col-2 text-center letraform">
  @if(isset($estado))
    <form action="{{route('activeCumple')}}" method="POST" onsubmit="return confirm('¿Estás seguro que desea cambiar el estado de la vista?');">
        @csrf
        <input type="hidden" name="estado" id="estado" value="@if($estado->estado == 1) 0 @else 1 @endif">
        <button class="buttones buttonAct" type="submit" class="mt-2" data-toggle="tooltip" data-placement="top" title="Activar o desactivar la visualización de cumpleaños y quinquenios en la vista de usuario.">
          @if($estado->estado == 1) 
           <span> <i class="fas fa-toggle-on" style="font-size: 1.5em; color:green;"></i> Activado </span>
          @else
          <span> <i class="fas fa-toggle-off" style="font-size: 1.5em; color:gray;"></i> Desactivado </span>
          @endif
        </button>
    </form>
    @endif
  </div>
</div>

<div class="container row letraform">
   <div class="col-lg-6 col-md-6 col-sm-6 col-6 mt-2">
     <div class="text-center"><span class="badge-info p-2" style="border-radius:10px;">Cumpleaños</span></div>
     <!--- formulario --->
     <div class="container mt-4 p-2" style="border-radius:10px; background-color:#ebebeb;">
    
     <form action="{{route('happybirthday')}}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-row">
          <div class="form-group col-md-6">
            <label for="file">Imagen (Default)</label>
            @if(isset($cumple->imagen))
            <img src="{{ asset('dist/eventos/' . $cumple->imagen) }}" class="img-thumbnail" alt="...">
            @endif
            <input type="file" class="form-control" id="file" name="file" accept="image/*">
          </div>
          <div class="form-group col-md-6">
            <label for="descrip">Descripción</label>
            @if(isset($cumple->descrip))
             <textarea class="form-control text-sm" id="descrip" name="descrip" rows="7" required>{{$cumple->descrip}} </textarea>
            @endif
          </div>
        </div>
        <button type="submit" class="btn btn-primary btn-sm float-right mt-2"><i class="fas fa-save"></i> Guardar</button>
     </form>
    <!---end formulario-->
    <!--- datos de la db-->
    </div>
    <!---end data --------->
   </div>
   <div class="col-lg-6 col-md-6 col-sm-6 col-6 mt-2">
     <div class="text-center"><span class="badge-info p-2" style="border-radius:10px;">Antigüedad</span></div>
       <div class="container mt-4 p-2" style="border-radius:10px; background-color:#ebebeb;">
        <!-- Button trigger modal -->
        <button type="button" class="btn btn-primary btn-sm mb-3" data-toggle="modal" data-target="#agregarevento">
           <i class="fas fa-plus"></i> Agregar
        </button>

        <!-- Modal -->
        <div class="modal fade" id="agregarevento" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
             <!---- formulario de antiguedad-->
            <form action="{{route('antique')}}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="modal-body">
               <div class="form-row">
                  <div class="form-group col-md-6">
                    <label for="nom">Nombre</label>
                    <input type="text" class="form-control" id="nom" name="nom">
                  </div>
                  <div class="form-group col-md-6">
                    <label for="tem">Tiempo (años)</label>
                    <input type="number" class="form-control" id="tem" name="tem" min="1">
                  </div>
                </div>
                <div class="form-row">
                  <div class="form-group col-md-6">
                    <label for="imagen">Imagen</label>
                    <input type="file" class="form-control" id="imagen" name="imagen" accept="image/*">
                  </div>
                  <div class="form-group col-md-6">
                    <label for="des">Descripción</label>
                    <textarea type="text" class="form-control" id="des" name="des"></textarea>
                  </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-warning btn-sm" data-dismiss="modal">Salir</button>
                <button type="submit" class="btn btn-primary btn-sm"><i class="fas fa-save"></i> Guardar</button>
            </div>
            </form>
            <!-- end antiguedad-->
            </div>
        </div>
        </div>        
        <!---=============================--->
        <br>
        <div class="row">
            <div class="col-md-2">
              <label for="im">Imagen</label>
            </div>
            <div class="col-md-6">
              <label for="desc">Descripción</label>
            </div>
            <div class="col-md-2">
              <label for="tim">Tiempo (Años)</label>
            </div>
            <div class="col-md-2">
              <label for="del">Acción</label>
            </div>
        </div>
        @foreach($ant as $anti)
        <div class="form-row mt-2">
          <div class="form-group col-md-2">
            <img src="{{ asset('dist/eventos/' . $anti->imagen) }}" class="img-thumbnail" alt="...">
          </div>
          <div class="form-group col-md-6">
            <textarea class="form-control text-sm text-justify" rows="7">{{$anti->descrip}} </textarea>
          </div>
          <div class="form-group col-md-2">
            <p class="form-control text-sm">{{$anti->tiempo}} </p>
          </div>
          <div class="form-group col-md-2">
             <a href="{{route('deletevento', $anti->id)}}"  onclick="return confirm('¿Estás seguro de que deseas eliminar este registro?');" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></a>
          </div>
        </div>
        @endforeach
        <!--==================================-->
       </div>
   </div>
</div>

<!--- colaboradores que cumplen años este mes -->
<div class="letraform placa mt-2 mb-2">
   <span class="badge-info p-1" style="border-radius:10px;">Proximas celebraciones en: {{$monthName}} </span>
</div>
<div class="container row letraform">
   <div class="col-lg-12 col-md-12 col-sm-12 col-12 mt-2">
    <!--- iterar-->
  @foreach($usuarios as $usu)
   <div class="user-panel pb-3 d-flex">
        <div class="image">
           <img src="{{ asset('dist/imgperfil/' . $usu->imagen) }}" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a type="button" class="d-block text-black" data-toggle="tooltip" data-html="true" title="
          <div class='card bg-blue'>
            <div class='card-body'>
               <h6 class='card-text text-left'>Cargo: {{$usu->cargo}} </h6>
               <h6 class='card-text text-left'>Area: {{$usu->area}}</h6>
            </div>
          </div>
          ">
            {{$usu->name}} {{$usu->apellido}} @if($usu->estado == 1) <i class="fas fa-birthday-cake" style="color: #FFD700;"></i> @endif
           </a>
          <span class="text-sm">
            {{ \Carbon\Carbon::parse($usu->fecha_cumple ?? '')->isoFormat('dddd, D [de] MMMM') }}
          </span>
        </div>
      </div>
    @endforeach
      <!---end iteracion-->
      <!--- iteracion para aniversarios -->
    @foreach($aniversario as $aniv)
   <div class="user-panel pb-3 d-flex">
        <div class="image">
           <img src="{{ asset('dist/imgperfil/' . $aniv->imagen) }}" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a type="button" class="d-block text-black" data-toggle="tooltip" data-html="true" title="
          <div class='card bg-blue'>
            <div class='card-body'>
               <h6 class='card-text text-left'>Cargo: {{$aniv->cargo}} </h6>
               <h6 class='card-text text-left'>Area: {{$aniv->area}}</h6>
            </div>
          </div>
          ">
            {{$aniv->name}} {{$aniv->apellido}} <i class="fas fa-gift" style="font-size: 24px; color: #ff0000;"></i> 
             @if($datehoy < $aniv->fecha_aniversario)
                {{$aniv->total_anios + 1}} Año(s) en la empresa.
             @else
                {{$aniv->total_anios}} Año(s) en la empresa.
             @endif
           </a>
          <span class="text-sm">
            {{ \Carbon\Carbon::parse($aniv->fecha_aniversario ?? '')->isoFormat('dddd, D [de] MMMM') }}
          </span>
        </div>
      </div>
    @endforeach
      <!--- end iteracion --->
   </div>

</div>
<script> 
    $(function () {
      $('[data-toggle="tooltip"]').tooltip();
    });
  </script>
@endsection