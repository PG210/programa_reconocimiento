@extends('usuario.principa_usul')
@section('content')
<ul class="nav nav-tabs" id="myTab" role="tablist" style="background-color:#1ED5F4; color:black;">
</ul>
<div class="tab-content" id="myTabContent">
  <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
   <!--texto 1-->
   <div class="row">
   <div class="col-md-5">
      <br>
     <!--seleccionar-->
     <div class="container">
     <form id="categoria" method="post" class="letraform">
        @csrf
        <div class="row">
           <div class="col-md-12">
              <i class="fas fa-list-alt" style="color:#468DF9; font-size:24px;"></i>&nbsp;&nbsp;<label for="inputState">Categoria</label>
                <select id="categor" class="form-control" name="categor">
                  <option value=" ">Elegir...</option>
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
        </div>
      </form>
     </div>
      <br><br>
      <div class="container">
      
        <form id="comportamiento" method="post" class="letraform">
        @csrf
        <div class="row">
           <div class="col-md-12">
           <i class="fas fa-list-alt" style="color:#468DF9; font-size:24px;"></i>&nbsp;&nbsp;<label>Comportamiento</label>
              <select id="slt-cursos" class="form-control">
              </select>
            </div>
          </div>
        </form>
      </div>
      <!--mensaje de recomendacion-->
      <br><br>
    <div class="row letraform">
      <div class="col-md-12">
      <div id="sugerir"></div>
     </div>
    </div>
    <!-----#######################---->
    <div class="row letraform">
      <div class="col-md-12">
      <div id="sinsugerir"></div>
     </div>
    </div>
    <!----End mensajes de recomendacion--->
   </div>
    
  <div class="col-md-7">
   <div class="container">
   <form method="post" id="formudatos" name="formudatos">
     @csrf
   <br> 
   <div class="card-deck">
       
        <div class="card" style="width: 18rem;">
        <div class="card-body">
            <div class="row">
              <div class="col-md-9">
               <div class="user-panel d-flex"> 
               <div class="image">
              @if($usu[0]->imagen!=null && $usu[0]->imagen != 'ruta')
                 <img src="{{asset('dist/imgperfil/'.$usu[0]->imagen)}}" class="img-circle elevation-1" alt="User Image" style="padding-bottom:2px; width:4.1rem; height: auto;">
                  @endif
                  @if($usu[0]->imagen==null || $usu[0]->imagen == 'ruta')
                  <img src="{{asset('dist/imgperfil/perfil_no_borrar.jpeg')}}" class="img-circle elevation-1" alt="User Image"  style="padding-bottom:2px; width:4.1rem; height: auto;" >
                @endif
               </div>
              </div>
              <h3 class="card-title letratarjeta1"><em>Para:</em><b> {{$usu[0]->name}} {{$usu[0]->apellido}} </b></h3><br>
              </div>
              <div class="col-md-3 letratarjeta1">
                <div class="punto" >

                </div>
              </div>
            </div>
            <hr>
            <div id="imagen" class="imagen">
            </div>
            <h3 class="letratarjeta2"><em>Te reconozco por:</em></h3> 
            <p class="card-text">

            <h4 class="nomcate letratarjeta2" style="background-color:#1ED5F4">  <h4>

            </p>
            <hr>
            <h3 class="letratarjeta2"><em>Comportamiento:</em></h3>
            <h4 class="compor letratarjeta2" style="background-color:#1ED5F4">  <h4>
            <hr>
            <h3 class="letratarjeta2"><em>Detalle:</em></h3>
            <!---############--->
            <div class="mb-3 was-validated letraform">
              <textarea class="form-control is-invalid" id="detexto" name="detexto" placeholder="Ingrese un detalle de reconocimiento" required></textarea>
            </div>
            <!--##########  -->
            <hr>
        </div>
        <ul class="list-group list-group-flush letratarjeta1">
            
            <li class="list-group-item"><em>De: </em><b>{{Auth::user()->name}}</b></li>

        </ul>
        <div class="card-body">
            <div class="row">
                <div class="col-7"></div>
                <div class="col-5 text-center">
                  <input type="text" class="form-control" id="idusu" name="idusu" value="{{$usu[0]->id}}" hidden>
                  <a href="/reconocimientos/enviar" type="button" class="btn salir letraform"  style="margin-left:0.8em; margin-bottom:10px;">Volver</a>
                 <!-- <input type="text" class="form-control idcompor" id="idcompor" name="idcompor" value>-->
                 <select id="stl-compor" class="form-control" hidden></select>
                 <button type="submit" class="btn confirmar letraform float-right">Enviar</button>
                </div>
           </div>
        </div>
        </div>
    
      </div>
    </form>
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
    var detexto = $('#detexto').val();
    var _token = $('input[name=_token]').val(); //token de seguridad
    if(idcat != null){
      $.ajax({
      type: "POST",
      url:"{{route('envrecat')}}",
      
      data:{
        idusu:idusu,
        idcat:idcat,
        detexto:detexto,
        _token:_token
      }, 
        success:function(response){
          var dat = JSON.parse(response);
          console.log(dat);
          $("#sugerir").empty();
          if(dat.length!=0){
          $('#formudatos')[0].reset();
          toastr.success('El envió de reconocimiento fue exitosó', 'Nuevo Reconocimiento', {timeOut:3000});
          //setTimeout(refrescar, 2000);
          for(var i=0; i<dat.length; i++){
            var resul= '<div class="alert alert-info alert-dismissible fade show" role="alert">'+
                '<strong><i class="fas fa-laugh-beam fa-2x" style="color:#FCFF24;"></i> &nbsp;Sugerencia! Reconoce a :'+
                  '<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="/reconocimientos/usuario/'+ dat[i].id +'">' + dat[i].name + '&nbsp;' + dat[i].apellido + '</a></strong>'+
                   '<button type="button" class="close" data-dismiss="alert" aria-label="Close">'+
                  '<span aria-hidden="true">&times;</span>'+
                '</button>'+
              '</div>';
              $('#sugerir').append(resul);
            }
          }else{
           
              $("#sugerir").empty();
              $('#formudatos')[0].reset();
              toastr.success('El envió de reconocimiento fue exitosó', 'Nuevo Reconocimiento', {timeOut:3000});

              var er = '<div class="alert alert-warning alert-dismissible fade show" role="alert">'+
                        '<strong><i class="fas fa-laugh-beam fa-2x" style="color:#FCFF24;"></i> &nbsp;No hay sugerencias!'+
                          '<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</strong>'+
                          '<button type="button" class="close" data-dismiss="alert" aria-label="Close">'+
                          '<span aria-hidden="true">&times;</span>'+
                        '</button>'+
                      '</div>';
                      $('#sugerir').append(er);

          }
      }
    }).fail(function(jqXHR, response){
          $("#sugerir").empty();
          $('#formudatos')[0].reset();
          toastr.success('El envió de reconocimiento fue exitosó', 'Nuevo Reconocimiento', {timeOut:3000});

	        var er = '<div class="alert alert-warning alert-dismissible fade show" role="alert">'+
                    '<strong><i class="fas fa-laugh-beam fa-2x" style="color:#FCFF24;"></i> &nbsp;No hay sugerencias!'+
                      '<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</strong>'+
                      '<button type="button" class="close" data-dismiss="alert" aria-label="Close">'+
                      '<span aria-hidden="true">&times;</span>'+
                    '</button>'+
                  '</div>';
          $('#sugerir').append(er);
        });
    }else{
      toastr.warning('Elige una categoria y un comportamiento.', 'Datos vacios!', {timeOut:3000});
      
    }
  });
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
  $('#categoria').on('change', function(){
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
      cursos.find('option').remove();
      var arreglo = JSON.parse(res);
        arreglo.unshift({id: 0, nombre: 'Elegir ...'});//agrega el elegir al inicio
        console.log(arreglo);
        //var t = '<option>Elegir ....</option>';
      for(var x=0; x<arreglo.length; x++){
          t='<option value="' + arreglo[x].id + '">' + arreglo[x].nombre  + '</option>';
         //todo+='<td>'+arreglo[x].nombre+'</td>'; 
         cursos.append(t);
      }
     
    });
  });
 </script> 

<!---script para consultar comportamiento--->
      <script>
        /*tomamos la información del formulario y la enviamos a la ruta y de la ruta al controlador*/
        $('#slt-cursos').on('change', function(){
          var compor= $("#stl-compor");//sirve para almacenar y limpiar el select
          var imagen = $('#imagen');//sirve para que las imagenes no se junten o dupliquen
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
