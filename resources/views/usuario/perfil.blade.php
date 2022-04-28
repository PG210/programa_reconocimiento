@extends('usuario.principa_usul')
@section('content')
<!--####################################-->
    <div class="accordion" id="accordionExample" style="overflow-y: hidden;">
      <div class="card">
        <div class="card-header" id="headingOne">
          <div class="row">
            <div class="col-md-9">
            <h2 class="mb-0">
              <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
              <i class="fas fa-address-card"></i>&nbsp;Perfil Usuario
              </button>
            </h2>
           </div>
           <div class="col-md-3">
             <a href="{{route('usuarioeditar')}}" type="button" class="btn btn-info btn-sm float-right"><i class="fas fa-user-edit"></i>&nbsp; Editar</a>
           </div>
        </div>
        </div>
        <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionExample">
          <div class="card-body">
          <!--############################vista perfil-->
          <figure class="figure">
              <img src="{{asset('dist/imgperfil/'.$dat[0]->imagen)}}" class="figure-img img-fluid rounded" alt="cargando imagen..." width="100px" height="150px">
             
           </figure>
              <div class="form-row">
                <div class="form-group col-md-6">
                <label for="inputEmail4">Nombre</label>
                <input type="text" class="form-control" id="inputEmail4" readonly="readonly" value="{{$dat[0]->name}}">
              </div>
              <div class="form-group col-md-6">
                <label for="inputPassword4">Apellido</label>
                <input type="text" class="form-control" id="inputPassword4"  readonly="readonly" value="{{$dat[0]->apellido}}">
              </div>
            </div>
            <div class="form-row">
              <div class="form-group col-md-6">
                <label for="inputEmail4">Dirección</label>
                <input type="text" class="form-control" id="inputEmail4" readonly="readonly" value="{{$dat[0]->direccion}}">
              </div>
              <div class="form-group col-md-6">
                <label for="inputPassword4">Telefono</label>
                <input type="text" class="form-control" id="inputPassword4"  readonly="readonly" value="{{$dat[0]->telefono}}">
              </div>
            </div>
            <div class="form-group">
              <label for="inputAddress">Email</label>
              <input type="email" class="form-control" id="inputAddress"  readonly="readonly" value="{{$dat[0]->email}}">
            </div>
            <div class="form-row">
              <div class="form-group col-md-6">
                <label for="inputCity">Cargo</label>
                <input type="text" class="form-control" id="inputCity"  readonly="readonly" value="{{$dat[0]->nombre}}">
              </div>
              <div class="form-group col-md-4">
                <label for="inputCity">Rol</label>
                <input type="text" class="form-control" id="inputCity"   readonly="readonly" value="{{$dat[0]->descripcion}}">
              </div>
              <div class="form-group col-md-2">
                <label for="inputCity">Estado</label>
                <input type="text" class="form-control" id="inputCity"  readonly="readonly" value="{{$dat[0]->descrip}}">
              </div>
            </div>
         <br><br>
       <!--#############################--->
      </div>
    </div>
  </div>
</div>
<!---##################################3-->

  
@endsection