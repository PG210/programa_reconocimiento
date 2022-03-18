@extends('usuario.principa_usul')
@section('content')
<div class="alert alert-success text-center" role="alert">
 Enviar Reconocimientos
</div>
<br>

<div class="container-fluid">
    <div class="row" id="map_section">
        <div class="col-12">
        <form>
          <div class="form-row">
            <div class="col-11">
              <input type="search" class="form-control" placeholder="Nombre a buscar" aria-label="Search"> 
            </div>
            <div class="col">
            <button class="btn btn-outline-success " type="submit">Search</button>
            </div>
          </div>
        </form>
        </div>
    </div>
</div>
@endsection