@extends('usuario.principa_usul')
@section('content')

<div class="d-flex justify-content-center alert alert-primary" role="alert">
    <h1 >Perfil Usuario</h1>
</div>
<br>
<figure class="figure">
  <img src="{{url('dist/img/avatar5.png')}}" class="figure-img img-fluid rounded" alt="cargando imagen..." width="100px" height="150px">
</figure>
<br>
<form>

{{$dat[0]->email}}

  
@endsection