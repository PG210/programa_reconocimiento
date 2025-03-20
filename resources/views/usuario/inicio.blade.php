@extends('usuario.principa_usul') @section('content')

<link href="{{ asset('css/emojionearea.min.css')}}" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('css/emoticones.css')}}">
<script src="{{ asset('js/emoticones.js')}}"></script>
<script src="{{ asset('js/emoticonesant.js')}}"></script>
<!-- Carga jQuery primero -->
<!-- Carga los estilos y scripts de emojioneArea después -->
@if(Auth::user()->id_rol!=1)
<!--Logeado como usuario-->

<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Hola {{ Auth::user()->name }}!</h1>
            </div>
            <!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Inicio</a></li>
                    <li class="breadcrumb-item active">Inicio</li>
                </ol>
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
</div>
<!-- /.content-header -->
<div class="container">
    <div class="row">
        <div class="col-md-3">
            <div class="fixed">
                <!-- Profile Image -->
                <div class="card card-primary card-outline">
                    <div class="card-body box-profile">
                        <div class="text-center">
                            @if(Auth::user()->imagen)
                            <img src="{{asset('dist/imgperfil/'.Auth::user()->imagen)}}"
                                class="profile-user-img img-fluid img-circle" alt="User profile picture"> @endif
                        </div>
                        <h3 class="profile-username text-center">{{ Auth::user()->name }} {{ Auth::user()->apellido }}</h3>
                        <p class="text-muted text-center">Cargo: {{ Auth::user()->cargo->nombre }} </p>
                        <ul class="list-group list-group-unbordered mb-3">
                            <li class="list-group-item">
                                <b><i class="fas fa-paper-plane"></i> Enviados</b> <a class="float-right">{{$totenviados}}</a>
                            </li>
                            <li class="list-group-item">
                                <b><i class="fas fa-award"></i> Recibidos</b> <a class="float-right">{{$totreconocimiento}}</a>
                            </li>
                            <li class="list-group-item">
                                <b><i class="fas fa-trophy"></i> Recompensas</b> <a class="float-right">{{$totrecom}}</a>
                            </li>
                            <li class="list-group-item">
                                <b><i class="fas fa-star"></i> Puntos obtenidos</b> 
                                <a class="float-right">
                                    @if(!empty($valorpun[0]->p))
                                      {{$valorpun[0]->p}}
                                    @else 
                                      <span>0</span> 
                                    @endif
                                </a>
                            </li>
                        </ul>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
                <div class="callout callout-warning">
                    <h5>Esta semana no haz reconocido
                        a tus compañeros !</h5>
                    <p>No te olvides de hacerlo</p>
                    <button onclick="window.location.href='{{ route('listareconocer') }}'" class="btn btn-warning font-weight-bold">
                        ¡Reconoce ahora!
                    </button>
                </div>
                <!-- Box -->
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title"><i class="far fa-file-alt mr-1"></i> Actualizaciones</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <p class="text-muted">Disfruta del nuevo diseño. ¿Te gusta?</p>
                        <hr>
                        <p class="text-muted">Nueva función: filtros para reportes por fecha.</p>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
        </div>
        <div class="col-md-9">
            <!---card--->
            @if(!empty($estadoimg->estado) && $estadoimg->estado == '1')
            <div class="container">
                <div class="card p-0 m-0">
                    @if(!empty($images))
                    <div id="carouselExampleCaptions" class="carousel slide" data-ride="carousel">
                        <ol class="carousel-indicators">
                            @foreach($images as $index => $imgs)
                            <li data-target="#carouselExampleCaptions" data-slide-to="{{ $index }}"
                                class="{{ $index == 0 ? 'active' : '' }}"></li>
                            @endforeach
                        </ol>
                        <div class="carousel-inner carousel-fade">
                            @foreach($images as $index => $imgs)
                            <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                                <img data-src="{{ asset('dist/carrucel/' . $imgs->imagen) }}"
                                    class="d-block w-100 lazy-load" alt="...">
                                <div class="carousel-caption d-none d-md-block">
                                    <h5 style="color: {{ $imgs->colorletra ?? '#000000' }}; background-color:{{ $imgs->colorfondo ?? 'transparent' }}; border-radius:10px; opacity:0.7;">
                                        {{ $imgs->descrip }}</h5>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        <button class="carousel-control-prev" type="button" data-target="#carouselExampleCaptions"
                            data-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="sr-only">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-target="#carouselExampleCaptions"
                            data-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="sr-only">Next</span>
                        </button>
                    </div>
                    @else
                    <img data-src="{{ asset('dist/img/enviare.jpg')}}" class="card-img-top lazy-load"
                        alt="Cargando imagen ..."
                        style="border-top-left-radius: 25px 25px; border-top-right-radius: 25px 25px;">
                    <div class="card-body">
                        <h5 class="text-center letra1 mb-2"><b>Envia Reconocimientos</b></h5>
                        <p class="card-text" style="text-align: center;"><a href="{{route('listareconocer')}}"
                                type="button" class="btn confirmar letraform">Ingresar</a></p>
                    </div>
                    <!--===============================-->
                    @endif
                </div>
            </div>
            <!--<div class="card text-center bg-secondary letraform">
                <h4 class="py-5">
                    <marquee> Pronto se publicará nueva información...</marquee>
                </h4>
            </div>-->
            @endif
            <!--card-->
            <!--end carrucel-->
            <div class=" ">
                <!-----================================================================--->
                <div class="row mt-3">
                    <div class="col-lg-12 col-md-12 col-12 text-center">
                        @if(isset($respuesta))
                            @if($respuesta == false)
                                <script>
                                window.alert('Correo no enviado, por favor notifica al administrador.');
                                </script>
                            @endif 
                        @endif
                    </div>
                </div>
                <div class="">
                    <!---mensaje--->
                    <div class="">
                        <div class="<!--pr-2 scrolly-->">
                            <!---card-->
                            @php $emoticones = [ ['emoticon' => '👍', 'descrip' => 'Me gusta', 'cod'=> '1'], ['emoticon'
                            => '😍', 'descrip' => 'Me encanta', 'cod'=> '2'], ['emoticon' => '😲', 'descrip' =>
                            'Sorprendido', 'cod'=> '3'], ['emoticon' => '🤗', 'descrip' => 'Abrazo', 'cod'=> '4'], ];
                            @endphp
                            <!---tabs for happy birthday and anniversary--->
                            <ul class="nav nav-tabs letraform" id="myTab" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active" id="home-tab" data-toggle="tab" data-target="#home"
                                        type="button" role="tab" aria-controls="home" aria-selected="true">Muro</button>
                                </li>
                                @if($estado->estado == 1)
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="profile-tab" data-toggle="tab" data-target="#profile"
                                        type="button" role="tab" aria-controls="profile"
                                        aria-selected="false">Cumpleaños y quinquenios</button>
                                </li>
                                @endif
                            </ul>
                            <div class="tab-content" id="myTabContent">
                                <!--- here happy birthday -->
                                <div class="tab-pane fade show active" id="home" role="tabpanel"
                                    aria-labelledby="home-tab">

                                    @foreach($detalle as $det)
                                    <div class="card card-primary card-widget">
                                        <div class="card-header py-4">
                                            <div class="card-tools">
                                                <button type="button" class="btn btn-tool" title="Mark as read">
                                                    <i class="far fa-circle"></i>
                                                </button>
                                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                                    <i class="fas fa-minus"></i>
                                                </button>
                                                <button type="button" class="btn btn-tool" data-card-widget="remove">
                                                    <i class="fas fa-times"></i>
                                                </button>
                                            </div>
                                            <!-- /.card-tools -->
                                            <div class="w-100 text-center">
                                                <!--<div class="medalla"><img data-src="{{asset('imgpremios/'.$det->img)}}" class="img-thumbnail lazy-load"  alt="Cargando imagen ...">-->
                                                <span class="text-center">
                                                    <h3>🎉 Buen trabajo {{ $det->nomrecibe }} {{ $det->aperecibe }}</h3>
                                                </span>
                                            </div>
                                            <!-- /.user-block -->
                                        </div>

                                        <div class="card-body">
                                            <div class="user-block w-100">
                                                <!--foto de perfil -->
                                                @if($det->imagenenv != 'ruta' && $det->imagenenv != '' )
                                                <img data-src="{{asset('dist/imgperfil/'.$det->imagenenv)}}"
                                                    class="profile-user-img img-circle lazy-load" alt="User Image">
                                                @else
                                                <img data-src="{{asset('dist/imgperfil/perfil_no_borrar.jpeg')}}"
                                                    class="profile-user-img img-circle lazy-load" alt="User Image">
                                                @endif

                                                <span class="username h4">{{$det->descat}} </span> <!---categoria -->
                                                <span class="description">Por: {{ $det->nomenvia }} {{ $det->apenvia }}
                                                    | {{ date('j F, Y', strtotime($det->fecha)) }} </span>
                                                <span class="description">{{ $det->comportamiento }} </span> <!--- comportamiento--->
                                            </div>
                                        </div>
                                        <div class="card-body pt-0 user-block w-100">
                                            <span class="description" style="font-size: 0.9rem;">{{ $det->det }} </span>
                                            
                                            <!---reacciones-->
                                            <div id="reac{{$det->idcat}}"></div>
                                            <div id="reaccionesPHP{{$det->idcat}}" class="emoji-caja">
                                                @foreach($emoticonCounts as $emti) @if($det->idcat == $emti->idrec)
                                                @if($emti->idemot == 1) 👍
                                                <span class="badge badge-light">{{$emti->count}}</span>
                                                @elseif($emti->idemot == 2) 😍
                                                <span class="badge badge-light">{{$emti->count}}</span>
                                                @elseif($emti->idemot == 3) 😲
                                                <span class="badge badge-light">{{$emti->count}}</span>
                                                @elseif($emti->idemot == 4) 🤗
                                                <span class="badge badge-light">{{$emti->count}}</span> @endif @endif
                                                @endforeach
                                            </div>

                                            <!---=boton reacciones=-->
                                            <button class="btn_reaccion mt-2" id="btn{{$det->idcat}}">
                                                <span style="color:black;" id="text{{$det->idcat}}">
                                                    @php $usuarioMarcado = false; @endphp
                                                    @foreach($emoticonuser as $emtic)
                                                    @if($det->idcat == $emtic->idrec)
                                                    @if($emtic->idemot >= 1 && $emtic->idemot <= 4) {{$emtic->emoticon}}
                                                        @php $usuarioMarcado=true; @endphp @endif @php break; @endphp
                                                        @endif @endforeach
                                                        {{-- Si no se encontró un emoticón marcado por el usuario, muestra el icono de "like" gris --}}
                                                        @if (!$usuarioMarcado) <i class="fas fa-thumbs-up"
                                                        style="color:gray;"></i>
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
                                                        <a id="btnr{{$det->idcat}}"
                                                            onclick="selecEmot('<?= $idc ?>', '<?= $emoticon ?>', '<?= $idemot ?>');"><i
                                                                style="font-style: normal!important;">{{$emot['emoticon']}}</i></a>
                                                        <span
                                                            style="padding:3px; border-radius: 10px; background-color:white;">{{$emot['descrip']}}</span>
                                                    </div>
                                                    @endforeach
                                            </button>
                                            <!--end reacciones-->
                                            <!---obtener las personas que reaccionaron-->
                                            <div class="dropdownnew">
                                                <a type="button" onclick="myFunction('<?= $idc ?>')"><i
                                                        class="fas fa-ellipsis-h"></i></a>
                                                <div id="myDropdown{{$det->idcat}}" class="dropdownnew-content">
                                                    <a id="em{{$det->idcat}}"></a>
                                                    @foreach($users as $usu) @if($det->idcat == $usu->idrec)
                                                    <a href="#" id="usuario{{$det->idcat}}{{$usu->iduser}}">
                                                        {{$usu->emoticon}} {{$usu->name}} {{$usu->apellido}}</a> @endif
                                                    @endforeach
                                                </div>
                                            </div>


                                            <span class="float-right text-muted"><i class="far fa-comments"></i>
                                                <!---===================comentarios=================-->
                                                <a data-toggle="collapse" href="#comentariosCollapse{{$det->idcat}}"
                                                    role="button" aria-expanded="false"
                                                    aria-controls="comentariosCollapse{{$det->idcat}}">
                                                        <span id="comentariohis{{$det->idcat}}">
                                                        @php 
                                                          $comentariosMostrados = false; 
                                                        @endphp
                                                        @foreach($totcomentarios as $tcom)
                                                            @if($tcom->idrec == $det->idcat)
                                                                ( {{$tcom->totalcomentarios}} ) Comentarios
                                                                @php $comentariosMostrados = true; @endphp
                                                            @endif
                                                        @endforeach

                                                        @if(!$comentariosMostrados)
                                                            (0) Comentarios
                                                        @endif
                                                        </span>
                                                </a>
                                            </span>
                                        </div>    
                                            <div class="collapse" id="comentariosCollapse{{$det->idcat}}">
                                                <div  class="card-footer card-comments">           
                                                        @foreach($comentarios as $comentario) 
                                                        @if($det->idcat == $comentario->idrec)
                                                        <div class="card-comment">
                                                            <!-- User image -->
                                                            @if($comentario->imagen != 'ruta' && $comentario->imagen != '' )
                                                                    <img src="{{asset('dist/imgperfil/'.$comentario->imagen)}}"
                                                                        class="img-circle img-sm" alt="User Image"> 
                                                            @else
                                                                    <img src="{{asset('dist/imgperfil/perfil_no_borrar.jpeg')}}"
                                                                        class="img-circle img-sm" alt="User Image"> 
                                                            @endif

                                                            <div class="comment-text">
                                                                <span class="username">
                                                                {{ $comentario->nombre }} {{ $comentario->apellido }}
                                                                <span class="text-muted float-right">{{ \Carbon\Carbon::parse($comentario->fecha)->translatedFormat('j F, Y') }}</span>
                                                                </span><!-- /.username -->
                                                                {{$comentario->comentario}}
                                                            </div>
                                                            <!-- /.comment-text -->
                                                        </div>

                                                        @endif 
                                                        @endforeach
                                                    <div id="respuestahis{{$det->idcat}}"> <!--div para respuestas de comentarios de js--->
                                                    </div>
                                                </div>
                                                <div  class="card-footer">  
                                                    <!-------------- formulario ----->
                                                    <div class="">
                                                        <form method="POST" class="formhistory" id="{{$det->idcat}}">
                                                            @csrf
                                                            <div class="form-group">
                                                                <label for="contenido{{$det->idcat}}">Comentario</label>
                                                                <input type="text" class="form-control valorInput"
                                                                    name="valorInput" id='valorInput{{$det->idcat}}'
                                                                    value="{{$det->idcat}}" hidden>
                                                                <textarea type="text"
                                                                    class="form-control limpiararea contenido"
                                                                    name="contenido" id='contenido{{$det->idcat}}'></textarea>
                                                                    <div class="invalid-feedback" id="mensajeError{{$det->idcat}}" style="display: none;">
                                                                        Por favor, escribe un comentario.
                                                                    </div>
                                                            </div>
                                                            <button type="submit"
                                                                class="btn btn-warning float-right">Enviar</button>
                                                        </form>
                                                    </div>
                                                    <!---end formulario --->
                                                </div>
                                            </div>
                                            <!---=====================================-->
                                            <!--
											<hr>
											<button type="button" class="btn btn-default btn-sm"><i class="fas fa-share"></i> Compartir</button>
											<button type="button" class="btn btn-default btn-sm"><i class="far fa-thumbs-up"></i> Me gusta</button>
											<hr>-->
                                        
                                    </div>
                                    @endforeach {{ $detalle->links() }}
                                </div>
                                <!---end happy and start anniversari--->
                                @if($estado->estado == '1')
                                <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                                    <!---data holidays --->
                                    @foreach($usershappy as $happy)
                                    <div class="card mb-3 mt-3">
                                        <div class="row no-gutters">
                                            <div class="col-md-4 col-lg-4">
                                                <img data-src="{{asset('dist/eventos/'.$cumple->imagen)}}"
                                                    class="img-thumbnail lazy-load" alt="Cargando imagen ...">
                                            </div>
                                            <div class="col-md-8 col-lg-8">
                                                <div class="card-body">
                                                    <!--foto de perfil -->
                                                    <div class="user-panel mt-0 pb-0 mb-0" style="white-space: normal;">
                                                        <img data-src="{{asset('dist/imgperfil/'.$happy->imagen)}}"
                                                            class="img-circle elevation-1 lazy-load" alt="User Image"
                                                            style="padding-bottom:2px;">
                                                        <span> <b>&nbsp;&nbsp;{{ $happy->name }}
                                                                {{ $happy->apellido }}</b>&nbsp; está celebrando su
                                                            cumpleaños.</span>
                                                        <p class="card-text mx-2">
                                                            <small class="text-muted">
                                                               {{ \Carbon\Carbon::parse($happy->fecha_cumple)->translatedFormat('j F, Y') }}
                                                            </small>
                                                        </p>
                                                    </div>
                                                    <p class="card-text m-2">Únete a la celebración y comparte un
                                                        mensaje especial. 🎉🎂</p>
                                                    <!---reacciones-->
                                                    <div id="reachappy{{$happy->id}}"></div>
                                                    <div id="reaccionesPHPhappy{{$happy->id}}">
                                                        <!--total de reacciones -->
                                                        @foreach($emotholys as $emohap) @if($happy->id ==
                                                        $emohap->iduser && $emohap->estado == '1') @if($emohap->idemot
                                                        == 1) 👍
                                                        <span class="badge badge-light">{{$emohap->count}}</span>
                                                        @elseif($emohap->idemot == 2) 😍
                                                        <span class="badge badge-light">{{$emohap->count}}</span>
                                                        @elseif($emohap->idemot == 3) 😲
                                                        <span class="badge badge-light">{{$emohap->count}}</span>
                                                        @elseif($emohap->idemot == 4) 🤗
                                                        <span class="badge badge-light">{{$emohap->count}}</span> @endif
                                                        @endif @endforeach
                                                        <!--end total de reacciones-->
                                                    </div>
                                                    <!---===========-->
                                                    <button class="btn_reaccion mt-2" id="btnhappy{{$happy->id}}">
                                                        <span style="color:black;" id="texthappy{{$happy->id}}">
                                                            <!---emoticon marcado por el usuario-->
                                                            @php
                                                            $emotmarcadoh = false;
                                                            @endphp
                                                            @foreach($useremotholys as $uemh)
                                                            @if($happy->id == $uemh->iduser && $uemh->estado == '1')
                                                            @if($uemh->idemot >= 1 && $uemh->idemot <= 4)
                                                                {{$uemh->emoticon}} @php $emotmarcadoh=true; @endphp
                                                                @endif @php break; @endphp @endif @endforeach
                                                                {{-- Si no se encontró un emoticón marcado por el usuario, muestra el icono de "like" gris --}}
                                                                @if (!$emotmarcadoh) <i class="fas fa-thumbs-up"
                                                                style="color:gray;"></i>
                                                                @endif
                                                                <!--end emoticon marcado por el usuario-->
                                                        </span>

                                                        <!---listado de emoticones realizados -->
                                                        <div class="reacciones">
                                                            @foreach($emoticones as $emot)
                                                            <div class="reaccion">
                                                                @php
                                                                $iduser= $happy->id;
                                                                $emoticon = $emot['emoticon'];
                                                                $idemot = $emot['cod'];
                                                                @endphp
                                                                <a id="btnhappy{{$happy->id}}"
                                                                    onclick="emotAniversario('<?= $iduser ?>', '<?= $emoticon ?>', '<?= $idemot ?>', '', '1');"><i
                                                                        style="font-style: normal!important;">{{$emot['emoticon']}}</i></a>
                                                                <span
                                                                    style="padding:3px; border-radius: 10px; background-color:white;">{{$emot['descrip']}}</span>
                                                            </div>
                                                            @endforeach
                                                            <!--- end listado de emoticones -->
                                                    </button>
                                                    <!--end reacciones-->
                                                    <!---obtener las personas que reaccionaron-->
                                                    <div class="dropdownnew">
                                                        <a type="button" onclick="happyReaccion('<?= $happy->id ?>')"><i
                                                                class="fas fa-ellipsis-h"></i></a>
                                                        <div id="myDropdownhappy{{$happy->id}}"
                                                            class="dropdownnew-content">
                                                            <!--- aqui las personas que reaccionan-->
                                                            <a id="emhappy{{$happy->id}}"></a>
                                                            @foreach($usuariosReaccioneshol as $ush) @if($happy->id ==
                                                            $ush->iduser && $ush->estado == '1')
                                                            <a href="#" id="usuariohappy{{$happy->id}}">
                                                                {{$ush->emoticon}} {{$ush->name}} {{$ush->apellido}}</a>
                                                            @endif @endforeach
                                                            <!--- end personas reaccionaron-->
                                                        </div>
                                                    </div>
                                                    <!---===================comentarios=================-->
                                                    <a data-toggle="collapse"
                                                        href="#comentariosCollapsehappy{{$happy->id}}" role="button"
                                                        aria-expanded="false"
                                                        aria-controls="comentariosCollapsehappy{{$happy->id}}">
                                                        &nbsp;Comentarios
                                                    </a>
                                                    <div class="collapse" id="comentariosCollapsehappy{{$happy->id}}">
                                                        <div class="card card-body mt-2">
                                                            <!---aqui van los comentarios-->
                                                            <div id="responsehappy{{$happy->id}}">
                                                                <!---end comentarios-->
                                                                @foreach($infoComentarios as $comcumple) 
                                                                  @if($happy->id == $comcumple->iduser && $comcumple->tipo == '1')
                                                                        <div class="user-panel mt-3 pb-0 mb-0" style="white-space: normal;">
                                                                            <img src="{{asset('dist/imgperfil/'.$comcumple->imagen)}}"
                                                                                class="img-circle elevation-1" alt="User Image"
                                                                                style="padding-bottom:2px;">
                                                                            <span> <b>&nbsp;&nbsp;{{ $comcumple->nombre }}
                                                                                    {{ $comcumple->apellido }}:</b>&nbsp;</b></span>
                                                                            {{$comcumple->comentario}}
                                                                            <p class="card-text mx-2">
                                                                                <small class="text-muted text-right">
                                                                                {{ \Carbon\Carbon::parse($comcumple->fecha)->translatedFormat('j F, Y') }}
                                                                                </small>
                                                                            </p>
                                                                        </div>
                                                                  @endif
                                                                @endforeach
                                                            </div>
                                                            <!-------------- formulario ----->
                                                            <div class="mt-3">
                                                                <form method="POST" class="formholidays" id="{{$happy->id}}">
                                                                    @csrf
                                                                    <div class="form-group">
                                                                        <label
                                                                            for="contenidohappy{{$happy->id}}">Comentario</label>
                                                                        <input type="text"
                                                                            class="form-control valorInput"
                                                                            name="valorInputhappy"
                                                                            id='valorInputhappy{{$happy->id}}'
                                                                            value="{{$happy->id}}" hidden>
                                                                        <input type="text"
                                                                            class="form-control valorInput"
                                                                            name="tipohappy"
                                                                            id='tipohappy{{$happy->id}}' value="1"
                                                                            hidden>
                                                                        <textarea type="text"
                                                                            class="form-control limpiararea contenido"
                                                                            name="contenidohappy"
                                                                            id='contenidohappy{{$happy->id}}'
                                                                            required></textarea>
                                                                    </div>
                                                                    <button type="submit"
                                                                        class="btn btn-warning float-right">Enviar</button>
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
                                    <!---end data holidays-->
                                    <!---data aniversario --->
                                    @foreach($usuanviersario as $aniver)
                                    <div class="card mb-3 mt-3">
                                        <div class="row no-gutters">
                                            <div class="col-md-4 col-lg-4">
                                                <img data-src="{{asset('dist/eventos/'.$aniver['imganiv'])}}"
                                                    class="img-thumbnail lazy-load" alt="Cargando imagen ...">
                                            </div>
                                            <div class="col-md-8 col-lg-8">
                                                <div class="card-body">
                                                    <!--foto de perfil -->
                                                    <div class="user-panel mt-0 pb-0 mb-0" style="white-space: normal;">
                                                        <img data-src="{{asset('dist/imgperfil/'.$aniver['perfil'])}}"
                                                            class="img-circle elevation-1 lazy-load" alt="User Image"
                                                            style="padding-bottom:2px;">
                                                        <span> <b>&nbsp;&nbsp;{{ $aniver['name'] }}
                                                                {{ $aniver['apellido'] }}</b>&nbsp; Celebra
                                                            <strong>{{$aniver['anios']}}</strong> año(s) en la
                                                            empresa.</span>
                                                        <p class="card-text mx-2">
                                                            <small class="text-muted">
                                                                 {{ \Carbon\Carbon::parse($aniver['fecaniv'])->translatedFormat('j F, Y') }}
                                                            </small>
                                                        </p>
                                                    </div>
                                                    <p class="card-text m-2">¡Únete a su celebración y comparte un
                                                        mensaje lleno de buenos deseos!</p>
                                                    <!---reacciones-->
                                                    <div id="reacaniver{{$aniver['id']}}"></div>
                                                    <div id="reaccionesPHPaniver{{$aniver['id']}}">
                                                        <!--total de reacciones -->
                                                        @foreach($emotholys as $emotan) @if($aniver['id'] ==
                                                        $emotan->iduser && $emotan->estado == '2') @if($emotan->idemot
                                                        == 1) 👍
                                                        <span class="badge badge-light">{{$emotan->count}}</span>
                                                        @elseif($emotan->idemot == 2) 😍
                                                        <span class="badge badge-light">{{$emotan->count}}</span>
                                                        @elseif($emotan->idemot == 3) 😲
                                                        <span class="badge badge-light">{{$emotan->count}}</span>
                                                        @elseif($emotan->idemot == 4) 🤗
                                                        <span class="badge badge-light">{{$emotan->count}}</span> @endif
                                                        @endif @endforeach
                                                        <!--end total de reacciones-->
                                                    </div>
                                                    <!---===========-->
                                                    <button class="btn_reaccion mt-2" id="btnaniver{{$aniver['id']}}">
                                                        <span style="color:black;" id="textaniver{{$aniver['id']}}">
                                                            <!---emoticon marcado por el usuario-->
                                                            @php
                                                            $emotmarcado = false;
                                                            @endphp
                                                            @foreach($useremotholys as $uem)
                                                            @if($aniver['id'] == $uem->iduser && $uem->estado == '2')
                                                            @if($uem->idemot >= 1 && $uem->idemot <= 4)
                                                                {{$uem->emoticon}} @php $emotmarcado=true; @endphp
                                                                @endif @php break; @endphp @endif @endforeach
                                                                {{-- Si no se encontró un emoticón marcado por el usuario, muestra el icono de "like" gris --}}
                                                                @if (!$emotmarcado) <i class="fas fa-thumbs-up"
                                                                style="color:gray;"></i>
                                                                @endif
                                                                <!--end emoticon marcado por el usuario-->
                                                        </span>

                                                        <!---listado de emoticones realizados -->
                                                        <div class="reacciones">
                                                            @foreach($emoticones as $emot)
                                                            <div class="reaccion">
                                                                @php
                                                                $iduser= $aniver['id'];
                                                                $emoticon = $emot['emoticon'];
                                                                $idemot = $emot['cod'];
                                                                @endphp
                                                                <a id="btnaniversario{{$aniver['id']}}"
                                                                    onclick="emotAniversario('<?= $iduser ?>', '<?= $emoticon ?>', '<?= $idemot ?>', '', '2');"><i
                                                                        style="font-style: normal!important;">{{$emot['emoticon']}}</i></a>
                                                                <span
                                                                    style="padding:3px; border-radius: 10px; background-color:white;">{{$emot['descrip']}}</span>
                                                            </div>
                                                            @endforeach
                                                            <!--- end listado de emoticones -->
                                                    </button>
                                                    <!--end reacciones-->
                                                    <!---obtener las personas que reaccionaron-->
                                                    <div class="dropdownnew">
                                                        <a type="button"
                                                            onclick="userReaccion('<?= $aniver['id'] ?>')"><i
                                                                class="fas fa-ellipsis-h"></i></a>
                                                        <div id="myDropdownaniver{{$aniver['id']}}"
                                                            class="dropdownnew-content">
                                                            <!--- aqui las personas que reaccionan-->
                                                            <a id="emaniver{{$aniver['id']}}"></a>
                                                            @foreach($usuariosReaccioneshol as $us) @if($aniver['id'] ==
                                                            $us->iduser && $us->estado == '2')
                                                            <a href="#" id="usuarioaniver{{$aniver['id']}}">
                                                                {{$us->emoticon}} {{$us->name}} {{$us->apellido}}</a>
                                                            @endif @endforeach
                                                            <!--- end personas reaccionaron-->
                                                        </div>
                                                    </div>
                                                    <!---===================comentarios=================-->
                                                    <a data-toggle="collapse"
                                                        href="#comentariosCollapseaniver{{$aniver['id']}}" role="button"
                                                        aria-expanded="false"
                                                        aria-controls="comentariosCollapseaniver{{$aniver['id']}}">
                                                        &nbsp;Comentarios
                                                    </a>
                                                    <div class="collapse"
                                                        id="comentariosCollapseaniver{{$aniver['id']}}">
                                                        <div class="card card-body mt-2">
                                                            <!---aqui van los comentarios-->
                                                            <div id="responseaniver{{$aniver['id']}}">
                                                                <!---end comentarios-->
                                                                @foreach($infoComentarios as $comaniv) @if($aniver['id']
                                                                == $comaniv->iduser && $comaniv->tipo == '2')
                                                                <div class="user-panel mt-3 pb-0 mb-0"
                                                                    style="white-space: normal;">
                                                                    <img src="{{asset('dist/imgperfil/'.$comaniv->imagen)}}"
                                                                        class="img-circle elevation-1" alt="User Image"
                                                                        style="padding-bottom:2px;">
                                                                    <span> <b>&nbsp;&nbsp;{{ $comaniv->nombre }}
                                                                            {{ $comaniv->apellido }}:</b>&nbsp;</b></span>
                                                                    {{$comaniv->comentario}}
                                                                    <p class="card-text mx-2">
                                                                        <small class="text-muted">
                                                                           {{ \Carbon\Carbon::parse($comaniv->fecha)->translatedFormat('j F, Y') }}
                                                                        </small>
                                                                    </p>
                                                                </div>
                                                                @endif @endforeach
                                                            </div>
                                                            <!-------------- formulario ----->
                                                            <div class="mt-3">
                                                                <form method="POST" class="formholidays"
                                                                    id="{{$aniver['id']}}">
                                                                    @csrf
                                                                    <div class="form-group">
                                                                        <label
                                                                            for="contenidoaniver{{$aniver['id']}}">Comentario</label>
                                                                        <input type="text"
                                                                            class="form-control valorInput"
                                                                            name="valorInputhappy"
                                                                            id="valorInputaniver{{$aniver['id']}}"
                                                                            value="{{$aniver['id']}}" hidden>
                                                                        <input type="text"
                                                                            class="form-control valorInput"
                                                                            name="tipohappy"
                                                                            id="tipohappy{{$aniver['id']}}" value="2"
                                                                            hidden>
                                                                        <textarea type="text"
                                                                            class="form-control limpiararea contenido"
                                                                            name="contenidohappy"
                                                                            id="contenidoaniver{{$aniver['id']}}"
                                                                            required></textarea>
                                                                    </div>
                                                                    <button type="submit"
                                                                        class="btn btn-warning float-right">Enviar</button>
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
                                    <!---end data aniversario-->
                                    <!--- proximas fechas especiales--->

                                    <div class="card card-primary">
                                        <div class="card-header py-3">
                                        <span class="text-center">
                                            <h3>Celebraciones en: {{$monthName}}</h3>
                                        </span>
                                            <!-- /.card-tools -->
                                        </div>
                                        <!-- /.card-header -->
                                    </div>

                                    <div class="row">
                                        <div class="col-12 col-md-6">
                                            <div class="card card-primary">
                                                <div class="card-header">
                                                    <h3 class="card-title">Cumpleaños</h3>

                                                    <div class="card-tools">
                                                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                                        <i class="fas fa-minus"></i>
                                                    </button>
                                                    </div>
                                                    <!-- /.card-tools -->
                                                </div>
                                                <!-- /.card-header -->
                                                <div class="card-body">
                                                    <!--- iterar-->
                                                    @foreach($usuarios as $usu)
                                                    <div class="user-panel pb-3 d-flex">
                                                        <div class="image">
                                                            <img src="{{ asset('dist/imgperfil/' . $usu->imagen) }}"
                                                                class="img-circle elevation-2" alt="User Image">
                                                        </div>
                                                        <div class="info">
                                                            <a type="button" class="d-block text-black" data-toggle="tooltip"
                                                                data-html="true" title="
                                                                    <div class='card bg-blue'>
                                                                    <div class='card-body'>
                                                                        <h6 class='card-text text-left'>Cargo: {{$usu->cargo}} </h6>
                                                                        <h6 class='card-text text-left'>Area: {{$usu->area}}</h6>
                                                                    </div>
                                                                    </div>
                                                                    ">
                                                                {{$usu->name}} {{$usu->apellido}} @if($usu->estado == 1) <i
                                                                    class="fas fa-birthday-cake" style="color: #FFD700;"></i>
                                                                @endif
                                                            </a>
                                                            <span class="text-sm">
                                                                @if($datehoy < $usu->fecha_cumple)
                                                                    Próximo
                                                                @elseif($datehoy == $usu->fecha_cumple)
                                                                    Hoy
                                                                @else
                                                                    Pasado
                                                                @endif
                                                                    {{ \Carbon\Carbon::parse($usu->fecha_cumple ?? '')->isoFormat('dddd, D [de] MMMM') }}
                                                            </span>
                                                        </div>
                                                    </div>
                                                    @endforeach
                                                    <!---end iteracion-->
                                                </div>
                                                <!-- /.card-body -->
                                            </div>    
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <div class="card card-primary">
                                                <div class="card-header">
                                                    <h3 class="card-title">Aniversarios Laborales</h3>

                                                    <div class="card-tools">
                                                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                                        <i class="fas fa-minus"></i>
                                                    </button>
                                                    </div>
                                                    <!-- /.card-tools -->
                                                </div>
                                                <!-- /.card-header -->
                                                <div class="card-body">
                                                    <!--- iteracion para aniversarios -->
                                                    @foreach($aniversario as $aniv)
                                                    <div class="user-panel pb-3 d-flex">
                                                        <div class="image">
                                                            <img src="{{ asset('dist/imgperfil/' . $aniv->imagen) }}"
                                                                class="img-circle elevation-2" alt="User Image">
                                                        </div>
                                                        <div class="info">
                                                            <a type="button" class="d-block text-black" data-toggle="tooltip"
                                                                data-html="true" title="
                                                                <div class='card bg-blue'>
                                                                <div class='card-body'>
                                                                    <h6 class='card-text text-left'>Cargo: {{$aniv->cargo}} </h6>
                                                                    <h6 class='card-text text-left'>Area: {{$aniv->area}}</h6>
                                                                </div>
                                                                </div>
                                                                ">
                                                                {{$aniv->name}} {{$aniv->apellido}} <i class="fas fa-gift"
                                                                    style="font-size: 24px; color: #ff0000;"></i>
                                                                @if($datehoy < $aniv->fecha_aniversario)
                                                                    {{$aniv->total_anios + 1}} Año(s) en la empresa.
                                                                    @else
                                                                    {{$aniv->total_anios}} Año(s) en la empresa.
                                                                    @endif
                                                            </a>
                                                            <span class="text-sm">
                                                                @if($datehoy < $aniv->fecha_aniversario)
                                                                    Próximo
                                                                @elseif($datehoy == $aniv->fecha_aniversario)
                                                                    Hoy
                                                                @else
                                                                    Pasado
                                                                @endif
                                                                    {{ \Carbon\Carbon::parse($aniv->fecha_aniversario ?? '')->isoFormat('dddd, D [de] MMMM') }}
                                                            </span>
                                                        </div>
                                                    </div>
                                                    @endforeach
                                                    <!--- end iteracion --->
                                                </div>
                                                <!-- /.card-body -->
                                            </div>
                                        </div>
                                    </div>
                                    <!-- end proximas fechas-->
                                </div>
                                @endif
                            </div>
                            <!--end tabs--->
                            <!--end card-->
                        </div>
                    </div>
                </div>
                <!---==================================================================-->
            </div>
        </div>
    </div>
</div>
@endif @if(Auth::user()->id_rol==1)
<!--Logeado como administrador-->
<!--- mensaje ---->
<!-- Content Header (Page header) -->
<div class="content-header">
	<div class="container">
		<div class="row mb-2">
			<div class="col-sm-8">
				<h1 class="m-0">🎉 ¡Bienvenido a ReconoSER! 🎉</h1> 
                <p>Estamos muy felices de tenerte como parte de nuestra familia. ¿Qué quieres hacer hoy? 😊</p>
			</div>
			<!-- /.col -->
			<div class="col-sm-4">
				<ol class="breadcrumb float-sm-right">
					<li class="breadcrumb-item"><a href="#">Inicio</a></li>
				</ol>
			</div>
			<!-- /.col -->
		</div>
		<!-- /.row -->
	</div>
	<!-- /.container-fluid -->
</div>
<!-- /.content-header -->
<div class="container">
<div class="row">
          <div class="col-12">

           <!-- small card -->
           <div class="small-box bg-info">
              <div class="inner">
              @if(isset($licencias->numlicencia))
              <h4>🔐 Licencias Activas: 
                   {{ $totaluser }} / {{ $licencias->numlicencia }} 
              </h4>
              <p> Fecha de Vencimiento: {{ \Carbon\Carbon::parse($licencias->vencimiento)->translatedFormat('j \d\e F \d\e Y') }}</p>
              @endif
              </div>
              <div class="icon">
                <i class="fas fa-shopping-cart"></i>
              </div>
              <a href="/areas/empresa" class="small-box-footer">
                Más información <i class="fas fa-arrow-circle-right"></i>
              </a>
            </div>
        </div>
        </div>

        <div class="row">
         <div class="col-12"><h3>¿Qué quieres hacer hoy?</h3></div>
    
          <div class="col-lg-3 col-6">
            <!-- small card -->
            <div class="small-box bg-white">
              <div class="inner">
              <h5>Recompensas</h5>
              <p>Configura y administra las recompensas disponibles para los colaboradores.</p>
              </div>
              <div class="icon">
                <i class="fas fa-gift"></i>
              </div>
              <a href="/premios/reg" class="bg-warning small-box-footer">
                Editar <i class="fas fa-arrow-circle-right"></i>
              </a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small card -->
            <div class="small-box bg-white">
              <div class="inner">
              <h5>Registro de Usuarios</h5>
              <p>Administra los usuarios y gestiona nuevos registros en la plataforma.</p>
              </div>
              <div class="icon">
                <i class="fas fa-user-plus"></i>
              </div>
              <a href="/reporte/usuarios" class="bg-warning small-box-footer">
              Editar <i class="fas fa-arrow-circle-right"></i>
              </a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small card -->
            <div class="small-box bg-white">
              <div class="inner">
              <h5> Categorías</h5>
              <p>Configura y ajusta las categorías de reconocimiento según la cultura de tu empresa.</p>
              </div>
              <div class="icon">
                <i class="fas fa-list-alt"></i>
              </div>
              <a href="/Categorias/registro" class="bg-warning small-box-footer">
              Editar <i class="fas fa-arrow-circle-right"></i>
              </a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small card -->
            <div class="small-box bg-white">
              <div class="inner">
              <h5>Insignias</h5>
              <p class="">Diseña y administra las insignias según los logros y valores de tu empresa.</p>
              </div>
              <div class="icon">
                <i class="fas fa-medal"></i>
              </div>
              <a href="/registro/insignias" class="bg-warning small-box-footer">
              Editar <i class="fas fa-arrow-circle-right"></i>
              </a>
            </div>
          </div>
          <!-- ./col -->

          <div class="col-lg-3 col-6">
            <!-- small card -->
            <div class="small-box bg-white">
              <div class="inner">
              <h5> Diseño de Banners</h5>
                <p>Diseña y edita banners para destacar campañas y logros en la empresa. </p>
              </div>
              <div class="icon">
                <i class="fas fa-paint-brush"></i>
              </div>
              <a href="/comunicacion" class="bg-warning small-box-footer">
                Editar <i class="fas fa-arrow-circle-right"></i>
              </a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small card -->
            <div class="small-box bg-white">
              <div class="inner">
              <h5>Eventos</h5>
              <p>Organiza y administra eventos clave para fortalecer la cultura de reconocimiento.</p>
              </div>
              <div class="icon">
                <i class="fas fa-calendar-alt"></i>
              </div>
              <a href="/empresa/eventos" class="bg-warning small-box-footer">
              Editar <i class="fas fa-arrow-circle-right"></i>
              </a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small card -->
            <div class="small-box bg-white">
              <div class="inner">
              <h5> Empresa</h5>
              <p>Gestiona los detalles y configuración general de la organización.</p>
              </div>
              <div class="icon">
                <i class="fas fa-building"></i>
              </div>
              <a href="/areas/empresa" class="bg-warning small-box-footer">
              Editar <i class="fas fa-arrow-circle-right"></i>
              </a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small card -->
            <div class="small-box bg-white">
                <div class="inner">
                <h5>Control de Votaciones</h5>
                <p>Gestiona y supervisa las votaciones activas en la plataforma.</p>
                </div>
                <div class="icon">
                    <i class="fas fa-vote-yea"></i>
                </div>
                <a href="/areas/empresa" class="bg-warning small-box-footer">
                Editar <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
          </div>
          <!-- ./col -->
        </div>
</div>
<!-- /.content-header -->

</div>
@endif

<script type="text/javascript" src="{{asset('dist/js/emojionearea.js')}}"></script>
<script type="text/javascript" src="{{ asset('js/comentarioant.js')}}"></script>
<script type="text/javascript" src="{{ asset('js/comentariohis.js')}}"></script>
<script>
$('textarea[class*="contenido"]').emojioneArea({
    pickerPosition: "bottom"
}, 1000);

</script>
<script>
$(function() {
    $('[data-toggle="tooltip"]').tooltip();
});
</script>
@endsection