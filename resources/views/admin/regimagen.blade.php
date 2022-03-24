@extends('usuario.principa_usul')
@section('content')
<form  action="{{route('ingresardat')}}" method="POST"  enctype="multipart/form-data">
    @csrf
  <div class="form-row">
  <div class="col-6">
      <label for="imgruta">Subir Imagen</label>
      <input type="file" class="form-control" id="imgruta" name="imgruta" placeholder="Imagen .jpg .png" required>
    </div>
    <div class="col-3">
      <label for="nombre">Nombre</label>
      <input type="text" class="form-control" id="nombre" name="nombre" required >
    </div>
    <div class="col-3">
       <label for="tipoimagen">Tipo Imagen</label>
       <select id="tipoimagen" name="tipoimagen"  class="form-control" required>
        @foreach($dat as $c)
        <option value="{{$c->id}}">{{$c->tipodes}}</option>
        @endforeach
      </select>
     
    </div>
  </div>
  <br>
  <button type="submit" class="btn btn-primary">Guardar</button>
</form>
@endsection