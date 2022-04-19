@extends('usuario.principa_usul')
@section('content')
<ul class="nav nav-tabs" id="myTab" role="tablist" style="background-color:#1ED5F4; color:black;">
  <li class="nav-item" role="presentation">
    <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true" style="color:black;">Categoria</a>
  </li>
  <li class="nav-item" role="presentation">
    <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false" style="color:black;">Profile</a>
  </li>
  <li class="nav-item" role="presentation">
    <a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="false" style="color:black;">Contact</a>
  </li>
</ul>
<div class="tab-content" id="myTabContent">
  <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
   <!--texto 1-->
   <form method="post" id="formudatos" name="formudatos">
     @csrf
   <br> 
   <div class="card-deck">
       @foreach($cat as $c)
        <div class="card" style="width: 18rem;">
        <div class="card-body">
            <h5 class="card-title">Para:<b> {{$usu[0]->name}} {{$usu[0]->apellido}} </b></h5><br>
            <hr>
            <img src="{{asset('imgpremios/'.$c->rutaimagen)}}" class="card-img-top" alt="...">
            <h3>Te reconozco por: </h3>
            <p class="card-text">
                {{$c->nombre}}
            </p>
            <hr>
            <h3>Detalle: </h3>
            <p class="card-text">
                {{$c->descripcion}}
            </p>
            <hr>
        </div>
        <ul class="list-group list-group-flush">
            
            <li class="list-group-item">De: <b>{{Auth::user()->name}}</b></li>
        </ul>
        <div class="card-body">
            <div class="row">
                <div class="col-4">
                
                </div>
                <div class="col-4">
                
                </div>
                <div class="col-4">
                  <input type="text" class="form-control" id="idusu" name="idusu" value="{{$usu[0]->id}}" hidden>
                  <input type="text" class="form-control" id="idcat" name="idcat" value="{{$c->id}}" hidden>
                 <button type="submit" class="btn" style="background-color:#08FFD5; float:right;">Enviar</button>
                </div>
           </div>
        </div>
        </div>
        @endforeach
      </div>
    </form>
      <!---end_texto 1-->
  </div>
  <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
   <!---texto 2-->
      <br>  
     
   <!--end texto 2-->
  </div>
  <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">

     <!--texto 3-->
  </div>
</div>

<!--Ajax enviar respuesta--->
<!--instanciar el ajax para quitar el error no definido-->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
<script>
  /*tomamos la información del formulario y la enviamos a la ruta y de la ruta al controlador*/
  $('#formudatos').submit(function(e){
    e.preventDefault();
    var idusu=$('#idusu').val();
    var idcat=$('#idcat').val();
    var _token = $('input[name=_token]').val(); //token de seguridad
    $.ajax({
      type: "POST",
      url:"{{route('envrecat')}}",
      
      data:{
        idusu:idusu,
        idcat:idcat,
        _token:_token
      }, 
      success:function(response){
        if(response){
          $('#formudatos')[0].reset();
          toastr.success('El envió de reconocimiento fue exitosó', 'Nuevo Reconocimiento', {timeOut:3000});
        }
      }
    });
  });
 </script> 
 <script>
   function resetform() {
     $("form select").each(function() { this.selectedIndex = 0 });
     $("form input[type=text],form input[type=number]").each(function() { this.value = '' });
  }
 </script>
<!--end respuesta ajax-->
@endsection
