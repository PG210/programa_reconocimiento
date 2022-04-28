@extends('usuario.principa_usul')
@section('content')
<ul class="nav nav-tabs" id="myTab" role="tablist" style="background-color:#1ED5F4; color:black;">
  <li class="nav-item" role="presentation">
    <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true" style="color:black;">Categoria</a>
  </li>
  <li class="nav-item" role="presentation">
    
  </li>
</ul>
<div class="tab-content" id="myTabContent">
  <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
   <!--texto 1-->
   <div class="row">
   <div class="col-md-5">
      <br>
     <!--seleccionar-->
     <form id="categoria" method="post">
        @csrf
        <div class="row">
           <div class="col-md-9">
              <i class="fas fa-list-alt" style="color:#468DF9;"></i>&nbsp;<label for="inputState">Categoria</label>
                <select id="categor" class="form-control" name="categor">
                  <option selected>Elegir...</option>
                  @if($b==0)
                  <option>Sin Categoria</option>
                  @endif
                  @if($b==1)
                    @foreach($categoria as $cate)
                    <option value="{{$cate->id}}">{{$cate->descripcion}}</option>
                    @endforeach
                  @endif
                </select>
              </div>
              <!--end seleccionar--->
              <div class="col-md-3">
                <label>Confirmar</label>
                <button type="submit" class="btn" style="color:#Ffbd03;"><i class="fas fa-check-circle fa-2x"></i></button>
             </div>
        </div>
      </form>
      <br>
      <div>
      
        <form id="comportamiento" method="post">
        @csrf
        <div class="row">
           <div class="col-md-9">
              <label>Comportamiento</label>
              <select id="slt-cursos" class="form-control"></select>
           </div>
           <div class="col-md-3">
                <label>Confirmar</label>
                <button type="submit" class="btn" style="color:#Ffbd03;"><i class="fas fa-check-circle fa-2x"></i></button>
          </div>
          </div>
        </form>
      </div>
      <!--mensaje de recomendacion-->
      <br><br>
    <div class="row">
      <div class="col-md-12">
      @if($c==1)
        <div class="alert alert-info alert-dismissible fade show" role="alert">
          <strong><i class="fas fa-laugh-beam fa-2x" style="color:#FCFF24;"></i> &nbsp;Sugerencia! Reconoce a :
            <br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</strong> {{$usuazar[0]->name}} {{$usuazar[0]->apellido}}
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
      @endif
     </div>
    </div>
    <!----End mensajes de recomendacion--->
   </div>
    
     <div class="col-md-6">
   <form method="post" id="formudatos" name="formudatos">
     @csrf
   <br> 
   <div class="card-deck">
       
        <div class="card" style="width: 18rem;">
        <div class="card-body">
            <div class="row">
              <div class="col-md-9">
              <h3 class="card-title"><em>Para:</em><b> {{$usu[0]->name}} {{$usu[0]->apellido}} </b></h3><br>
              </div>
              <div class="col-md-3">
                <div class="punto" ></div>
              </div>
            </div>
            <hr>
            <div id="imagen" class="imagen">
            </div>
            <h3><em>Te reconozco por:</em></h3> 
            <p class="card-text">

            <h4 class="nomcate" style="background-color:#1ED5F4">  <h4>

            </p>
            <hr>
            <h3><em>Comportamiento:</em></h3>
            <h4 class="compor" style="background-color:#1ED5F4">  <h4>
            <hr>
            <h3><em>Detalle:</em></h3>
            <p class="card-text">
            <h4 class="detalle" style="background-color:#1ED5F4">  <h4>
            </p>
            <hr>
        </div>
        <ul class="list-group list-group-flush">
            
            <li class="list-group-item"><em>De: </em><b>{{Auth::user()->name}}</b></li>
        </ul>
        <div class="card-body">
            <div class="row">
                <div class="col-4">
                
                </div>
                <div class="col-4">
                
                </div>
                <div class="col-4">
                  <input type="text" class="form-control" id="idusu" name="idusu" value="{{$usu[0]->id}}" hidden>
                  <a href="/reconocimientos/enviar" type="button" class="btn" style="background-color:blue; color:white;">Volver</a>
                 <!-- <input type="text" class="form-control idcompor" id="idcompor" name="idcompor" value>-->
                 <select id="stl-compor" class="form-control" hidden></select>
                 <button type="submit" class="btn" style="background-color:#08FFD5; float:right;">Enviar</button>
                </div>
           </div>
        </div>
        </div>
    
      </div>
    </form>
    <div class="col-md-1">
   </div>
      </div>
   </div>
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
    var idcat=$('#stl-compor').val();
    console.log(idcat);
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
          setTimeout(refrescar, 2000);
        }
      }
    });
  });
  function refrescar(){
    //Actualiza la página
    location.reload();
  }
 </script> 
 <script>
   function resetform() {
     $("form select").each(function() { this.selectedIndex = 0 });
     $("form input[type=text],form input[type=number]").each(function() { this.value = '' });
  }
 </script>
<!--end respuesta ajax-->

<script>
  /*tomamos la información del formulario y la enviamos a la ruta y de la ruta al controlador*/
  $('#categoria').submit(function(e){
    e.preventDefault();
    var idcate=$('#categor').val();
    var _token = $('input[name=_token]').val(); //token de seguridad
    var cursos = $("#slt-cursos");
    $.ajax({
      type: "POST",
      url:"{{route('filtrarcat')}}",
      data:{
        idcate:idcate,
        _token:_token
      } 
    }).done(function(res){
      console.dir(res);
      cursos.find('option').remove();
      var arreglo = JSON.parse(res);
      for(var x=0; x<arreglo.length; x++){
        // var todo='<tr><td>' + arreglo[x].id+'</td>';
         //todo+='<td>'+arreglo[x].nombre+'</td>';
         cursos.append('<option value="' + arreglo[x].id + '">' + arreglo[x].nombre  + '</option>');
      }
    });
  });
 </script> 

<!---script para consultar comportamiento--->
      <script>
        /*tomamos la información del formulario y la enviamos a la ruta y de la ruta al controlador*/
        $('#comportamiento').submit(function(e){
          e.preventDefault();
          var compor= $("#stl-compor");
          var imagen = $('#imagen');
          var idcom=$('#slt-cursos').val();
          var _token = $('input[name=_token]').val(); //token de seguridad
          $.ajax({
            type: "POST",
            url:"{{route('filtrarcomport')}}",
            data:{
              idcom:idcom,
              _token:_token
            } 
          }).done(function(res){
            console.dir(res);
            var arreglo = JSON.parse(res);
            compor.find('option').remove();
           // nombre.append(arreglo.nomcat);
          
          //
            for(var x=0; x<arreglo.length; x++){
              $('.nomcate').html(arreglo[x].descripcion);
              $('.compor').html(arreglo[x].nomcat);
              $('.detalle').html(arreglo[x].descom);
              $('.punto').html('<label> Puntos: ' + arreglo[x].puntos  + '</label>');
             
             // console.log(arreglo[x].rutaimagen);
              $('.imagen').html('<img class="card-img-top" src="/imgpremios/' + arreglo[x].rutaimagen + '" >');
              compor.append('<option value="' + arreglo[x].idcom + '">' +  arreglo[x].idcom + '</option>');
             // $('$idcompor').val(arreglo[x].idcom);
             // console.log(arreglo[x].nomcat);
              // var todo='<tr><td>' + arreglo[x].id+'</td>';
              //todo+='<td>'+arreglo[x].nombre+'</td>';
             // imagen.find('option').remove();  
            }
          });
        });
      </script> 
<!----final de script para consultar comportamiento--->
 <script>
   function resetform() {
     $("form select").each(function() { this.selectedIndex = 0 });
     $("form input[type=text],form input[type=number]").each(function() { this.value = '' });
  }
 </script>
<!--end respuesta ajax-->

@endsection
