@extends('principal')
@section('content')
<main role="main" class="container my-5 letrap forms">
    <div class="row">
       <div class="col-lg-12 col-md-12 col-12 text-center">
          <h4 class="my-5">Error 500: Error Interno del Servidor</h4>
          <p>Lo sentimos, algo salió mal en el servidor.</p>
          <a href="{{ url('/inicio') }}">Volver al inicio</a>
       </div>
    </div>
</main>
@endsection