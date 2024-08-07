@extends('usuario.principa_usul')
@section('content')
<link href="https://rawgit.com/mervick/emojionearea/master/dist/emojionearea.min.css" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('css/emoticones.css')}}">
<script src="{{ asset('js/emoticones.js')}}"></script>
     <!-- Carga jQuery primero -->
    <!-- Carga los estilos y scripts de emojioneArea después -->
@if(Auth::user()->id_rol!=1) <!--Logeado como usuario-->
   <div class="container">
     <div class="row">
        <div class="col-lg-4 col-md-12">
           <!---card--->
             <div class="card mb-2 mt-2" style="border: 2px; border-radius: 25px; background-color:white;">
                <img src="{{ asset('dist/img/enviare.jpg')}}" class="card-img-top" alt="Cargando imagen ..." style="border-top-left-radius: 25px 25px; border-top-right-radius: 25px 25px;">
                <div class="card-body">
                  <h5 class="text-center letra1 mb-2"><b>Envia Reconocimientos</b></h5>
                  <p class="card-text" style="text-align: center;"><a href="{{route('listareconocer')}}" type="button" class="btn confirmar letraform">Ingresar</a></p>
                </div>
              </div>
           <!--card-->
        </div>
        <div class="col-lg-8">
          <div class="container scrolly" style=" border: 2px; border-radius: 25px; background-color:white;">
          <!---card-->
          @php
          $emoticones = [
                ['emoticon' => '👍', 'descrip' => 'Me gusta', 'cod'=> '1'],
                ['emoticon' => '😍', 'descrip' => 'Me encanta', 'cod'=> '2'],
                ['emoticon' => '😲', 'descrip' => 'Sorprendido', 'cod'=> '3'],
                ['emoticon' => '🤗', 'descrip' => 'Abrazo', 'cod'=> '4'],
            ];
          @endphp
          @foreach($detalle as $det)
          <div class="card mb-3 mt-3">
            <div class="row no-gutters">
              <div class="col-md-4 col-lg-4">
                <img src="{{asset('imgpremios/'.$det->img)}}" class="img-thumbnail"  alt="Cargando imagen ...">
              </div>
              <div class="col-md-8 col-lg-8">
                <div class="card-body">
                    <!--foto de perfil -->
                    <div  class="user-panel mt-0 pb-0 mb-0" style="white-space: normal;">
                      @if($det->imagenenv != 'ruta' && $det->imagenenv != '' )
                        <img src="{{asset('dist/imgperfil/'.$det->imagenenv)}}" class="img-circle elevation-1" alt="User Image" style="padding-bottom:2px;">
                      @else
                         <img src="{{asset('dist/imgperfil/perfil_no_borrar.jpeg')}}" class="img-circle elevation-1" alt="User Image" style="padding-bottom:2px;" >
                      @endif
                      <span> <b>&nbsp;&nbsp;{{ $det->nomenvia }} {{ $det->apenvia }}</b>&nbsp; reconocio a &nbsp;<b>{{ $det->nomrecibe }} {{ $det->aperecibe }}</b></span>
                      <p class="card-text mx-2"><small class="text-muted">{{ date('j F, Y', strtotime($det->fecha)) }}</small></p>
                  </div>
                  <p class="card-text m-2">{{ $det->det }} </p>
                  <!---reacciones-->
                  <div id="reac{{$det->idcat}}"></div>
                  <div id="reaccionesPHP{{$det->idcat}}"> 
                  @foreach($emoticonCounts as $emti)
                    @if($det->idcat == $emti->idrec)
                      @if($emti->idemot == 1)
                      👍<span class="badge badge-light">{{$emti->count}}</span>
                      @elseif($emti->idemot == 2)
                      😍<span class="badge badge-light">{{$emti->count}}</span>
                      @elseif($emti->idemot == 3)
                      😲<span class="badge badge-light">{{$emti->count}}</span>
                      @elseif($emti->idemot == 4)
                      🤗<span class="badge badge-light">{{$emti->count}}</span>
                      @endif
                    @endif
                  @endforeach
                  </div>
                  <!---===========-->
                  <button class="btn_reaccion mt-2" id="btn{{$det->idcat}}">
                  <span style="color:black;" id="text{{$det->idcat}}">
                      @php $usuarioMarcado = false; @endphp
                      @foreach($emoticonuser as $emtic)
                          @if($det->idcat == $emtic->idrec)
                              @if($emtic->idemot >= 1 && $emtic->idemot <= 4)
                                  {{$emtic->emoticon}}
                                  @php $usuarioMarcado = true; @endphp
                              @endif
                              @php break; @endphp
                          @endif
                      @endforeach

                      {{-- Si no se encontró un emoticón marcado por el usuario, muestra el icono de "like" gris --}}
                      @if (!$usuarioMarcado)
                          <i class="fas fa-thumbs-up" style="color:gray;"></i>
                      @endif
                  </span>      
    
                  <div class="reacciones">
                  @foreach($emoticones as $emot)
                      <div class="reaccion"> 
                        @php   
                        $idc= $det->idcat;
                        $emoticon = $emot['emoticon'];
                        $idemot = $emot['cod'];
                        @endphp
                          <a href="#" id="btnr{{$det->idcat}}"  onclick="selecEmot('<?= $idc ?>', '<?= $emoticon ?>', '<?= $idemot ?>');"><i style="font-style: normal!important;">{{$emot['emoticon']}}</i></a>
                          <span style="padding:3px; border-radius: 10px; background-color:white;">{{$emot['descrip']}}</span>
                      </div>
                  @endforeach              
                  </button>
                  <!--end reacciones-->
                   <!---obtener las personas que reaccionaron-->
                  <div class="dropdownnew">
                      <a type="button" onclick="myFunction('<?= $idc ?>')"><i class="fas fa-ellipsis-h"></i></a>
                      <div id="myDropdown{{$det->idcat}}" class="dropdownnew-content">
                        <input type="text" placeholder="Buscar.." id="myInput{{$det->idcat}}" class="myInput" onkeyup="filterFunction('<?= $idc ?>')">
                         <a id="em{{$det->idcat}}"></a>
                          @foreach($users as $usu)
                            @if($det->idcat == $usu->idrec)
                            <a href="#" id="usuario{{$det->idcat}}{{$usu->iduser}}"> {{$usu->emoticon}} {{$usu->name}} {{$usu->apellido}}</a>
                            @endif
                          @endforeach
                      </div>
                    </div>
                  <!---===================comentarios=================-->
                  <a data-toggle="collapse" href="#comentariosCollapse{{$det->idcat}}" role="button" aria-expanded="false" aria-controls="comentariosCollapse{{$det->idcat}}">
                   &nbsp;Comentarios
                  </a>
                <div class="collapse" id="comentariosCollapse{{$det->idcat}}">
                  <div class="card card-body mt-2">

                  @foreach($comentarios as $comentario)
                     @if($det->idcat == $comentario->idrec)
                        <div  class="user-panel mt-3 pb-0 mb-0" style="white-space: normal;">
                            @if($comentario->imagen != 'ruta' && $comentario->imagen != '' )
                              <img src="{{asset('dist/imgperfil/'.$comentario->imagen)}}" class="img-circle elevation-1" alt="User Image" style="padding-bottom:2px;">
                            @else
                              <img src="{{asset('dist/imgperfil/perfil_no_borrar.jpeg')}}" class="img-circle elevation-1" alt="User Image" style="padding-bottom:2px;" >
                            @endif
                            <span> <b>&nbsp;&nbsp;{{ $comentario->nombre }} {{ $comentario->apellido }}:</b>&nbsp;</b></span>
                            {{$comentario->comentario}}
                            <p class="card-text mx-2"><small class="text-muted">{{ date('j F, Y', strtotime($comentario->fecha)) }}</small></p>
                          </div>
                     @endif
                  @endforeach
                  <!-------------- formulario ----->
                  <div class="mt-3">
                  <form method="POST" action="{{route('comentario')}}">
                      @csrf
                      <div class="form-group">
                        <label for="contenido{{$det->idcat}}">Comentario</label>
                        <input type="text" class="form-control valorInput" name="valorInput" id='valorInput{{$det->idcat}}' value="{{$det->idcat}}" hidden>
                        <textarea type="text" class="form-control limpiararea contenido" name="contenido" id='contenido{{$det->idcat}}' required></textarea>
                      </div>
                        <button type="submit" class="btn btn-warning float-right">Enviar</button>
                    </form>
                    </div>
                    <!---end formulario --->
                 </div>
                 </div>
                  <!---=====================================-->
                </div>
              </div>
            </div>
          </div>
          @endforeach
           <!--end card-->
          </div>
        </div>
     </div>
   </div>
@endif
@if(Auth::user()->id_rol==1) <!--Logeado como administrador-->
<div class="card-deck">
  <div class="card" style=" border: 2px; border-radius: 25px; background-color:white;">
    <img src="{{ asset('dist/img/enviare.jpg')}}" class="card-img-top "  alt="..." style="border-top-left-radius: 25px 25px; border-top-right-radius: 25px 25px;">
    <div class="card-body">
      <p class="card-text letra1" style="text-align: center;">
      <b>Categorias</b><br><br>
      <a href="/Categorias/registro" type="button" class="btn confirmar letraform">Ingresar</a></p>
    </div>
  </div>
  <div class="card" style=" border: 2px; border-radius: 25px; background-color:white;">
    <img src="{{ asset('dist/img/ganareco.jpg')}}" class="card-img-top img-fluid d-none d-sm-none d-md-block" alt="..."  style="height: 75%; border-top-left-radius: 25px 25px; border-top-right-radius: 25px 25px;">
    <div class="card-body">
      <p class="card-text letra1" style="text-align: center;">
      <b>Insignias</b><br><br>
       <a href="/registro/insignias" type="button" class="btn confirmar letraform">Ingresar</a></p>
    </div>
  </div>
  <div class="card" style=" border: 2px; border-radius: 25px; background-color:white;">
    <img src="{{ asset('dist/img/ganains.jpg')}}" class="card-img-top img-fluid" style="border-top-left-radius: 25px 25px; border-top-right-radius: 25px 25px;">
    <div class="card-body">
      <p class="card-text letra1" style="text-align: center;">
       <b>Empresa</b><br><br>
      <a href="/areas/empresa" type="button" class="btn confirmar letraform">Ingresar</a></p>
    </div>
  </div>
</div>
@endif
<script type="text/javascript" src="https://rawgit.com/mervick/emojionearea/master/dist/emojionearea.js"></script>
<script>
  $('textarea[class*="contenido"]').emojioneArea({
      pickerPosition: "bottom"
  }, 1000);
// Ajusta el tiempo de espera según sea necesario
  document.addEventListener('DOMContentLoaded', (event) => {
            
    let dat = {!! json_encode($valor) !!};
    if (dat) {
        let collapseElement = document.getElementById('comentariosCollapse' + dat);
        if (collapseElement) {
            $(collapseElement).collapse('show');
        }
      }
  });
</script>
@endsection