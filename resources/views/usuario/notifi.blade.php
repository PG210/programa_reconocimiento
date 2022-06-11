<?php

  use App\Models\ModelNotify\Notificacion;
  use Illuminate\Support\Facades\DB;
  use Illuminate\Support\Facades\Auth;

  $usu= auth()->user()->id;
  $val = DB::table('notificaciones')->join('catrecibida', 'notificaciones.idnotifi', '=', 'catrecibida.id')
           ->where('catrecibida.id_user_recibe', $usu)->where('notificaciones.estado', 1)->count();
  if($val!=0){
    $noti =DB::table('notificaciones')
          ->join('catrecibida', 'notificaciones.idnotifi', '=', 'catrecibida.id')
          ->join('users', 'catrecibida.id_user_envia', '=', 'users.id')
          ->join('comportamiento_categ', 'catrecibida.id_categoria', '=', 'comportamiento_categ.id')
          ->join('categoria_reconoc', 'catrecibida.id_comportamiento', '=', 'categoria_reconoc.id')
          ->where('catrecibida.id_user_recibe', $usu)->where('notificaciones.estado', 1)
          ->select('notificaciones.id', 'notificaciones.notinom', 'notificaciones.notides', 'users.name', 
                   'users.apellido', 'users.imagen', 'notificaciones.fecha', 'comportamiento_categ.descripcion as categoria',
                   'categoria_reconoc.nombre as comportamiento', 'comportamiento_categ.puntos as catpuntos', 'categoria_reconoc.rutaimagen')
          ->get();
           }

            $valeidos= DB::table('notificaciones')->join('catrecibida', 'notificaciones.idnotifi', '=', 'catrecibida.id')
                       ->where('catrecibida.id_user_recibe', $usu)->where('notificaciones.estado', 2)->count();
            if($valeidos!=0){
              $leidos =DB::table('notificaciones')
                    ->join('catrecibida', 'notificaciones.idnotifi', '=', 'catrecibida.id')
                    ->join('users', 'catrecibida.id_user_envia', '=', 'users.id')
                    ->join('comportamiento_categ', 'catrecibida.id_categoria', '=', 'comportamiento_categ.id')
                    ->join('categoria_reconoc', 'catrecibida.id_comportamiento', '=', 'categoria_reconoc.id')
                    ->where('catrecibida.id_user_recibe', $usu)->where('notificaciones.estado', 2)
                    ->select('notificaciones.id', 'notificaciones.notinom', 'notificaciones.notides', 'users.name', 
                            'users.apellido', 'users.imagen', 'notificaciones.fecha', 'comportamiento_categ.descripcion as categoria',
                            'categoria_reconoc.nombre as comportamiento', 'comportamiento_categ.puntos as catpuntos', 'categoria_reconoc.rutaimagen')
                    ->get();
                   
            }
         
        //consultar insignias
         $insignoti =  DB::table('noti_insignia')->join('insignia_obtenida', 'noti_insignia.id_insignoti', '=', 'insignia_obtenida.id')
                       ->where('insignia_obtenida.id_usuario', $usu)->where('noti_insignia.estado', 1)->count();
         if($insignoti!=0){
          $insig =  DB::table('noti_insignia')
                    ->join('insignia_obtenida', 'noti_insignia.id_insignoti', '=', 'insignia_obtenida.id')
                    ->join('insignia', 'insignia_obtenida.id_insignia', '=', 'insignia.id')
                    ->join('premios', 'insignia.id_premio', '=', 'premios.id')
                    ->where('insignia_obtenida.id_usuario', $usu)->where('noti_insignia.estado', 1)
                    ->select('noti_insignia.id as idnotinsig', 'noti_insignia.estado', 'insignia.name', 'insignia.descripcion as nivel',
                           'insignia.puntos as insigpuntos', 'insignia.rutaimagen as imginsig', 'premios.name as premionom', 'premios.descripcion as predes',
                           'premios.rutaimagen as preimagen', 'insignia_obtenida.fecha')
                    ->get();

         }

         //consultar insignias que esten leidas
         $insigleida =  DB::table('noti_insignia')->join('insignia_obtenida', 'noti_insignia.id_insignoti', '=', 'insignia_obtenida.id')
                       ->where('insignia_obtenida.id_usuario', $usu)->where('noti_insignia.estado', 2)->count();
         if($insigleida!=0){
          $inleida =  DB::table('noti_insignia')
                    ->join('insignia_obtenida', 'noti_insignia.id_insignoti', '=', 'insignia_obtenida.id')
                    ->join('insignia', 'insignia_obtenida.id_insignia', '=', 'insignia.id')
                    ->join('premios', 'insignia.id_premio', '=', 'premios.id')
                    ->where('insignia_obtenida.id_usuario', $usu)->where('noti_insignia.estado', 2)
                    ->select('noti_insignia.id as idnotinsig', 'noti_insignia.estado', 'insignia.name', 'insignia.descripcion as nivel',
                           'insignia.puntos as insigpuntos', 'insignia.rutaimagen as imginsig', 'premios.name as premionom', 'premios.descripcion as predes',
                           'premios.rutaimagen as preimagen', 'insignia_obtenida.fecha')
                    ->get();

         } 

        
  
?>
<li class="nav-item dropdown">
        
        <!---###modal----->
          <!-- Button trigger modal -->
          <a type="button" class="nav-link" data-toggle="modal" data-target="#exampleModal" onclick="sonido()">
             <i class="far fa-bell fa-lg"></i>
             <div id="nnoti2">
              @if($val!=0 || $insignoti!=0)
              <span class="badge badge-warning navbar-badge" style="color:white; font-size: 0.875em;"> 
              {{$val + $insignoti}} <!---suma las notificaciones-->
             </span>
              @endif
            </div>
            <div id="nnoti1"></div>
          </a>

          <!-- Modal -->
          <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable">
              <div class="modal-content">
                <div class="modal-header" style="background-color:#1ED5F4; color:white;">
                  <h5 class="modal-title" id="exampleModalLabel"><span >Notificaciones</span></h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <!---collapse-->
                  @if($val!=null) 
                  @foreach($noti as $n)
                 
                  <div class="accordion" id="accordionExample">
                      <div class="card">
                        <div class="card-header" id="headingTwo">
                          <h2 class="mb-0">
                            <button class="btn btn-link btn-block text-left collapsed" type="submit" data-toggle="collapse" data-target="#collapseTwo{{$n->id}}" aria-expanded="false" aria-controls="collapseTwo{{$n->id}}"  onclick="test('{{$n->id}}')">
                              <!---imagen-->
                              <div class="row">
                                  <div class="col-3">
                                    <div  class="user-panel mt-0 pb-0 mb-0 d-flex" style="padding-left:5px;">
                                    @if($n->imagen!=null)
                                     <img src="{{asset('dist/imgperfil/'.$n->imagen)}}" class="img-circle elevation-1" alt="User Image" style="padding-bottom:2px;">
                                    @endif
                                    @if($n->imagen==null)
                                    <img src="{{asset('dist/imgperfil/perfil_no_borrar.jpeg')}}" class="img-circle elevation-1" alt="User Image" style="padding-bottom:2px;" >
                                    @endif
                                    <br>
                                   </div>
                                  </div>
                                  <div class="col-6">
                                    <div class="info">
                                     {{$n->name}}  {{$n->apellido}}
                                    </div>
                                  </div>
                                  <div class="col-3">
                                     <span class="float-right text-muted text-sm">{{date('Y-m-d', strtotime($n->fecha))}}</span>
                                  </div>
                              </div>
                              <!---end imagen-->
                             
                            </button>
                          </h2>
                        </div>
                        <div id="collapseTwo{{$n->id}}" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
                          <div class="card-body" style="background-color:#08FFD5;">
                          <!---Cuerpo del mensaje-->
                              <div class="container-flex">
                              <div class="row">
                                <div class="col-6">
                                  <h6 style="padding-left:20px;" style="color:#FFFFFF;"><i class="fas fa-award mr-2" style="color:#ffbd03"></i> Recibiste un reconocimiento</h6>
                                </div>
                                <div class="col-6 text-right">
                                  <img src="{{asset('imgpremios/'.$n->rutaimagen)}}" class="img-circle elevation-1" alt="User Image" style="padding-bottom:2px; width:50px; height: 50px;">&nbsp;&nbsp;
                                  <span class="badge badge-warning navbar-badge" style="color:white; font-size: 0.875em;"> {{$n->catpuntos}}</span>
                                
                                </div>
                              </div>
                              <br>
                              <div class="row">
                                <div class="col-12">
                                  <hr>
                                  <h6 style="padding-left:20px;"><b> Por: </b>&nbsp;{{$n->notides}}</h6>
                                  <hr>
                                </div>
                                </div>
                                <br>
                              <div class="row">
                                <div class="col-12">
                                <h6 style="padding-left:20px;"><b>Comportamiento:</b>&nbsp;{{$n->comportamiento}}</h6>
                                  <hr>
                                </div>
                                </div>
                                <br>
                              <div class="row">
                                <div class="col-12">
                                <h6 style="padding-left:20px;"><b>Categoria:</b>&nbsp;{{$n->categoria}}</h6>
                                    <hr>
                                </div>
                                </div>
                                <!--botones-->
                                <div class="row">
                                <div class="col-12">
                                  <a href="/reporte/insignias" type="button" class="btn btn-primary float-right">Ver</a>
                                </div>
                                </div>
                                <!--end -- botones-->
                              </div>
                          <!--end cuerpo del mensaje-->
                          </div>
                        </div>
                      </div>
                    </div>
                    @endforeach
                    @endif
                  <!---collapse end--->

                   <!---aqui notificaciones de insignia recibida--> 
                  @if($insignoti!=0) 
                  @foreach($insig as $in)
                  <div class="accordion" id="accordionExample">
                      <div class="card">
                        <div class="card-header" id="headingTwo">
                          <h2 class="mb-0">
                            <button class="btn btn-link btn-block text-left collapsed" type="submit" data-toggle="collapse" data-target="#collapseTwo{{$in->idnotinsig}}" aria-expanded="false" aria-controls="collapseTwo{{$in->idnotinsig}}" onclick="insignialeer('{{$in->idnotinsig}}')">
                              <!---imagen-->
                              <div class="row">
                                  <div class="col-3">
                                    <div  class="user-panel mt-0 pb-0 mb-0 d-flex" style="padding-left:5px;">
                                     <img src="{{asset('imgpremios/'.$in->imginsig)}}" class="img-circle elevation-1" alt="User Image" style="padding-bottom:2px;">
                                    <br>
                                   </div>
                                  </div>
                                  <div class="col-6">
                                    <div class="info">
                                     Felicidades Ganaste una Insignia
                                    </div>
                                  </div>
                                  <div class="col-3">
                                     <span class="float-right text-muted text-sm">{{date('Y-m-d', strtotime($in->fecha))}}</span>
                                  </div>
                              </div>
                              <!---end imagen-->
                             
                            </button>
                          </h2>
                        </div>
                        <div id="collapseTwo{{$in->idnotinsig}}" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
                          <div class="card-body" style="background-color:#08FFD5;">
                          <!---Cuerpo del mensaje-->
                              <div class="container-flex">
                              <div class="row">
                                <div class="col-6">
                                  <h6 style="padding-left:20px;" style="color:#FFFFFF;"><i class="fas fa-gift mr-2" style="color:#ffbd03"></i> Recibiste una Recompensa</h6>
                                </div>
                                <div class="col-6 text-right">
                                  <img src="{{asset('imgpremios/'.$in->preimagen)}}" class="img-circle elevation-1" alt="User Image" style="padding-bottom:2px; width:50px; height: 50px;">&nbsp;&nbsp;
                                  <span class="badge badge-warning navbar-badge" style="color:white; font-size: 0.875em;"> {{$in->insigpuntos}}</span>
                                
                                </div>
                              </div>
                              <br>
                              <div class="row">
                                <div class="col-12">
                                  <hr>
                                  <h6 style="padding-left:20px;"><b>Insignia: </b>&nbsp;{{$in->name}}</h6>
                                  <hr>
                                </div>
                                </div>
                                <br>
                              <div class="row">
                                <div class="col-12">
                                <h6 style="padding-left:20px;"><b>Nivel:</b>&nbsp;{{$in->nivel}}</h6>
                                  <hr>
                                </div>
                                </div>
                                <br>
                              <div class="row">
                                <div class="col-12">
                                <h6 style="padding-left:20px;"><b>Recompensa:</b>&nbsp; {{$in->predes}} </h6>
                                    <hr>
                                </div>
                                </div>
                                <!--botones-->
                                <div class="row">
                                <div class="col-12">
                                  <a href="/reconocimientos/listar" type="button" class="btn btn-primary float-right">Ver</a>
                                </div>
                                </div>
                                <!--end -- botones-->
                              </div>
                          <!--end cuerpo del mensaje-->
                          </div>
                        </div>
                      </div>
                    </div>
              
                  @endforeach
                  @endif
                  
                <!--end notificacion de insignia recibida--> 


                <!---Notificaciones leidas-->
                <div class="dropdown-divider"></div>
                <h6 style="background-color:#1ED5F4; padding-top:10px; padding-bottom:10px;">&nbsp;<i class="fas fa-check"></i>&nbsp;Notificaciones leidas</h6>
                <div class="dropdown-divider"></div>
                <!--colapsed para todas las notificaciones-->
                <div id="datosuno">
                @if($valeidos!=0) 
                @foreach($leidos as $le)
                <div class="accordion" id="accordionExample">
                  <div class="card">
                    <div class="card-header" id="headingThree">
                      <h2 class="mb-0">
                        <button class="btn btn-link btn-block text-left collapsed" type="button" data-toggle="collapse" data-target="#collapseThree{{$le->id}}" aria-expanded="false" aria-controls="collapseThree{{$le->id}}">
                        
                         <!---imagen-->
                         <div class="row">
                                 <div class="col-3">
                                   <div  class="user-panel mt-0 pb-0 mb-0 d-flex" style="padding-left:5px;">
                                   @if($le->imagen!="ruta")
                                    <img src="{{asset('dist/imgperfil/'.$le->imagen)}}" class="img-circle elevation-1" alt="User Image" style="padding-bottom:2px;">
                                   @endif
                                   @if($le->imagen=="ruta")
                                   <img src="{{asset('dist/imgperfil/perfil_no_borrar.jpeg')}}" class="img-circle elevation-1" alt="User Image" style="padding-bottom:2px;" >
                                   @endif
                                   <br>
                                  </div>
                                 </div>
                                 <div class="col-5">
                                   <div class="info">
                                    {{$le->name}}  {{$le->apellido}}
                                   </div>
                                 </div>
                                 <div class="col-4">
                                    <span class="float-right text-muted text-sm">{{date('Y-m-d', strtotime($le->fecha))}}</span>
                                 </div> 
                             </div>
                             <!---end imagen-->
                        </button>
                                                        
                      </h2>
                    </div>
                    <div id="collapseThree{{$le->id}}" class="collapse" aria-labelledby="headingThree" data-parent="#accordionExample">
                      <div class="card-body" style="background-color:#08FFD5;">
                         <!---Cuerpo del mensaje-->
                         <div class="container-flex">
                             <div class="row">
                               <div class="col-6">
                                 <h6 style="padding-left:20px;" style="color:#FFFFFF;"><i class="fas fa-award mr-2" style="color:#ffbd03"></i> Recibiste un reconocimiento</h6>
                               </div>
                               <div class="col-6 text-right">
                                 <img src="{{asset('imgpremios/'.$le->rutaimagen)}}" class="img-circle elevation-1" alt="User Image" style="padding-bottom:2px; width:50px; height: 50px;">&nbsp;&nbsp;
                                 <span class="badge badge-warning navbar-badge" style="color:white; font-size: 0.875em;"> {{$le->catpuntos}}</span>
                               
                               </div>
                             </div>
                             <br>
                             <div class="row">
                               <div class="col-12">
                                 <hr>
                                 <h6 style="padding-left:20px;"><b> Por: </b>&nbsp;{{$le->notides}}</h6>
                                 <hr>
                               </div>
                               </div>
                               <br>
                             <div class="row">
                               <div class="col-12">
                               <h6 style="padding-left:20px;"><b>Comportamiento:</b>&nbsp;{{$le->comportamiento}}</h6>
                                 <hr>
                               </div>
                               </div>
                               <br>
                             <div class="row">
                               <div class="col-12">
                               <h6 style="padding-left:20px;"><b>Categoria:</b>&nbsp;{{$le->categoria}}</h6>
                                   <hr>
                               </div>
                               </div>
                               <!--botones-->
                               <div class="row">
                               <div class="col-12">
                                 <a  onclick="eliminar('{{$le->id}}')"  type="button" class="float-right"> &nbsp;&nbsp;<i class="fas fa-trash-restore-alt fa-lg" style="color:#EC4857;"></i></a>
                                 <a href="/reporte/insignias" type="button" class="float-right" style="color:blue;">&nbsp;&nbsp;<i class="fas fa-eye  fa-lg"></i></a>
                               </div>
                               </div>
                               <!--end -- botones-->
                             </div>
                         <!--end cuerpo del mensaje-->
                      </div>
                    </div>
                  </div>
                </div>
                <!---end collapse-->
                
                @endforeach
                @endif
                </div>
                <div id="datos"></div><!--aqui se muestran los datos de insignias leidas a travez de jquery-->

                  <!---aqui notificaciones de insignia leidas--> 
                  <div id="insigniados">
                  @if($insigleida!=0)  
                  @foreach($inleida as $i)
                  <div class="accordion" id="accordionExample">
                      <div class="card">
                        <div class="card-header" id="headingTwo">
                          <h2 class="mb-0">
                            <button class="btn btn-link btn-block text-left collapsed" type="submit" data-toggle="collapse" data-target="#collapseTwo{{$i->idnotinsig}}" aria-expanded="false" aria-controls="collapseTwo{{$i->idnotinsig}}">
                              <!---imagen-->
                              <div class="row">
                                  <div class="col-3">
                                    <div  class="user-panel mt-0 pb-0 mb-0 d-flex" style="padding-left:5px;">
                                     <img src="{{asset('imgpremios/'.$i->imginsig)}}" class="img-circle elevation-1" alt="User Image" style="padding-bottom:2px;">
                                    <br>
                                   </div>
                                  </div>
                                  <div class="col-6">
                                    <div class="info">
                                     Felicidades Ganaste una Insignia
                                    </div>
                                  </div>
                                  <div class="col-3">
                                     <span class="float-right text-muted text-sm">{{date('Y-m-d', strtotime($i->fecha))}}</span>
                                  </div>
                              </div>
                              <!---end imagen-->
                             
                            </button>
                          </h2>
                        </div>
                        <div id="collapseTwo{{$i->idnotinsig}}" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
                          <div class="card-body" style="background-color:#08FFD5;">
                          <!---Cuerpo del mensaje-->
                              <div class="container-flex">
                              <div class="row">
                                <div class="col-6">
                                  <h6 style="padding-left:20px;" style="color:#FFFFFF;"><i class="fas fa-gift mr-2" style="color:#ffbd03"></i> Recibiste una Recompensa</h6>
                                </div>
                                <div class="col-6 text-right">
                                  <img src="{{asset('imgpremios/'.$i->preimagen)}}" class="img-circle elevation-1" alt="User Image" style="padding-bottom:2px; width:50px; height: 50px;">&nbsp;&nbsp;
                                  <span class="badge badge-warning navbar-badge" style="color:white; font-size: 0.875em;"> {{$i->insigpuntos}}</span>
                                
                                </div>
                              </div>
                              <br>
                              <div class="row">
                                <div class="col-12">
                                  <hr>
                                  <h6 style="padding-left:20px;"><b>Insignia: </b>&nbsp;{{$i->name}}</h6>
                                  <hr>
                                </div>
                                </div>
                                <br>
                              <div class="row">
                                <div class="col-12">
                                <h6 style="padding-left:20px;"><b>Nivel:</b>&nbsp;{{$i->nivel}}</h6>
                                  <hr>
                                </div>
                                </div>
                                <br>
                              <div class="row">
                                <div class="col-12">
                                <h6 style="padding-left:20px;"><b>Recompensa:</b>&nbsp; {{$i->predes}} </h6>
                                    <hr>
                                </div>
                                </div>
                                <!--botones-->
                                <div class="row">
                                <div class="col-12">
                                  <a  onclick="eliminarinsig('{{$i->idnotinsig}}')"  type="button" class="float-right"> &nbsp;&nbsp;<i class="fas fa-trash-restore-alt fa-lg" style="color:#EC4857;"></i></a>
                                  <a href="/reconocimientos/listar" type="button" class="float-right" style="color:blue;">&nbsp;&nbsp;<i class="fas fa-eye  fa-lg"></i></a>
                                </div>
                                </div>
                                <!--end -- botones-->
                              </div>
                          <!--end cuerpo del mensaje-->
                          </div>
                        </div>
                      </div>
                    </div>
              
                  @endforeach
                  @endif
                  
                <!--end notificacion de insignia recibida--> 
               </div>
               <div id="insignia"></div>
               </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                </div>
              </div>
            </div>
          </div>
        <!---##modal-->
      </li>

      <style>
        .modal-backdrop {
        z-index: -1;
      }
      </style>
<!-- Button trigger modal -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/howler/2.2.1/howler.min.js"></script>
<script>

function test(id){
      var idnoti=id;
     
      let ruta = "{{ url('notificacion/estado/{id}') }}";
          ruta = ruta.replace('{id}', idnoti);
     
      $.ajax({
        url: ruta,
        type: "GET",
        success:function(response){
          var r=response;
          $("#nnoti1").empty();
          $("#nnoti2").hide();
          var valor = '<span class="badge badge-warning navbar-badge" style="color:white; font-size: 0.875em;">'+r+'</span>';
          $('#nnoti1').append(valor);
        
          //setTimeout(refrescar, 1000);
        
      },
  })
   
} 
//eliminar notificacion
function eliminar(id){
      var idnoti=id;
      let ruta = "{{ url('notificacion/eliminar/{id}') }}";
          ruta = ruta.replace('{id}', idnoti);
      $.ajax({
        url: ruta,
        type: "GET",
        success:function(response){
          var arreglo = JSON.parse(response);
          
          toastr.warning('De forma exitosa!.', 'Notificación Eliminada', {timeOut:3000});
          $("#datos").empty();
          $("#datosuno").hide();
          if(arreglo.length!=0){
            for(var x=0; x<arreglo.length; x++){
            
            if(arreglo[x].imagen=="ruta"){

              var valor =  '<div class="accordion" id="accordionExample">'+
                  '<div class="card">'+
                    '<div class="card-header" id="headingThree">'+
                      '<h2 class="mb-0">'+
                       '<button class="btn btn-link btn-block text-left collapsed" type="button" data-toggle="collapse" data-target="#collapseThree'+arreglo[x].id+'" aria-expanded="false" aria-controls="collapseThree'+arreglo[x].id+'">'+
                         '<div class="row">'+
                                 '<div class="col-3">'+
                                   '<div  class="user-panel mt-0 pb-0 mb-0 d-flex" style="padding-left:5px;">'+
                                   '<img src="dist/imgperfil/perfil_no_borrar.jpeg" class="img-circle elevation-1" alt="User Image" style="padding-bottom:2px;" >'+
                                   '<br>'+
                                  '</div>'+
                                 '</div>'+
                                 '<div class="col-5">'+
                                   '<div class="info">'+
                                    arreglo[x].name+ ' ' +arreglo[x].apellido+
                                   '</div>'+
                                 '</div>'+
                                 '<div class="col-4">'+
                                    '<span class="float-right text-muted text-sm">' + arreglo[x].fecha +'</span>'+
                                 '</div>'+ 
                             '</div>'+
                        '</button>'+                               
                      '</h2>'+
                    '</div>'+
                    '<div id="collapseThree'+arreglo[x].id+'" class="collapse" aria-labelledby="headingThree" data-parent="#accordionExample">'+
                    '<div class="card-body" style="background-color:#08FFD5;">'+
                         '<div class="container-flex">'+
                             '<div class="row">'+
                               '<div class="col-6">'+
                                 '<h6 style="padding-left:20px;" style="color:#FFFFFF;"><i class="fas fa-award mr-2" style="color:#ffbd03"></i> Recibiste un reconocimiento</h6>'+
                               '</div>'+
                               '<div class="col-6 text-right">'+
                               '<img src="imgpremios/'+arreglo[x].rutaimagen+ ' " class="img-circle elevation-1" alt="User Image" style="padding-bottom:2px; width:50px; height: 50px;">&nbsp;&nbsp;'+
                               '<span class="badge badge-warning navbar-badge" style="color:white; font-size: 0.875em;"> '+arreglo[x].catpuntos+'</span>'+
                               
                               '</div>'+
                               '</div>'+
                               '<br>'+
                               '<div class="row">'+
                               '<div class="col-12">'+
                               '<hr>'+
                               '<h6 style="padding-left:20px;"><b> Por: </b>&nbsp;'+arreglo[x].notides+'</h6>'+
                               '<hr>'+
                               '</div>'+
                               '</div>'+
                               '<br>'+
                               '<div class="row">'+
                               '<div class="col-12">'+
                               '<h6 style="padding-left:20px;"><b>Comportamiento:</b>&nbsp;'+arreglo[x].comportamiento+'</h6>'+
                               '<hr>'+
                               '</div>'+
                               '</div>'+
                               '<br>'+
                               '<div class="row">'+
                               '<div class="col-12">'+
                               '<h6 style="padding-left:20px;"><b>Categoria:</b>&nbsp;'+arreglo[x].categoria+'</h6>'+
                               '<hr>'+
                               '</div>'+
                               '</div>'+
                               '<div class="row">'+
                               '<div class="col-12">'+
                               '<a onclick="eliminar('+arreglo[x].id+')"  type="button" class="float-right"> &nbsp;&nbsp;<i class="fas fa-trash-restore-alt fa-lg" style="color:#EC4857;"></i></a>'+
                               '<a href="/reporte/insignias" type="button" class="float-right" style="color:blue;">&nbsp;&nbsp;<i class="fas fa-eye  fa-lg"></i></a>'+
                               '</div>'+
                               '</div>'+
                             '</div>'+
                      '</div>'+
                    '</div>'+
                  '</div>'+
                '</div>';

            }else{

              var valor =  '<div class="accordion" id="accordionExample">'+
                  '<div class="card">'+
                    '<div class="card-header" id="headingThree">'+
                      '<h2 class="mb-0">'+
                       '<button class="btn btn-link btn-block text-left collapsed" type="button" data-toggle="collapse" data-target="#collapseThree'+arreglo[x].id+'" aria-expanded="false" aria-controls="collapseThree'+arreglo[x].id+'">'+
                         '<div class="row">'+
                                 '<div class="col-3">'+
                                   '<div  class="user-panel mt-0 pb-0 mb-0 d-flex" style="padding-left:5px;">'+
                                   '<img src="/dist/imgperfil/'+arreglo[x].imagen+ '" class="img-circle elevation-1" alt="User Image" style="padding-bottom:2px;" >'+
                                   '<br>'+
                                  '</div>'+
                                 '</div>'+
                                 '<div class="col-5">'+
                                   '<div class="info">'+
                                    arreglo[x].name+ ' ' +arreglo[x].apellido+
                                   '</div>'+
                                 '</div>'+
                                 '<div class="col-4">'+
                                    '<span class="float-right text-muted text-sm">' + arreglo[x].fecha +'</span>'+
                                 '</div>'+ 
                             '</div>'+
                        '</button>'+                               
                      '</h2>'+
                    '</div>'+
                    '<div id="collapseThree'+arreglo[x].id+'" class="collapse" aria-labelledby="headingThree" data-parent="#accordionExample">'+
                    '<div class="card-body" style="background-color:#08FFD5;">'+
                         '<div class="container-flex">'+
                             '<div class="row">'+
                               '<div class="col-6">'+
                                 '<h6 style="padding-left:20px;" style="color:#FFFFFF;"><i class="fas fa-award mr-2" style="color:#ffbd03"></i> Recibiste un reconocimiento</h6>'+
                               '</div>'+
                               '<div class="col-6 text-right">'+
                               '<img src="/imgpremios/'+arreglo[x].rutaimagen+ ' " class="img-circle elevation-1" alt="User Image" style="padding-bottom:2px; width:50px; height: 50px;">&nbsp;&nbsp;'+
                               '<span class="badge badge-warning navbar-badge" style="color:white; font-size: 0.875em;"> '+arreglo[x].catpuntos+'</span>'+
                               
                               '</div>'+
                               '</div>'+
                               '<br>'+
                               '<div class="row">'+
                               '<div class="col-12">'+
                               '<hr>'+
                               '<h6 style="padding-left:20px;"><b> Por: </b>&nbsp;'+arreglo[x].notides+'</h6>'+
                               '<hr>'+
                               '</div>'+
                               '</div>'+
                               '<br>'+
                               '<div class="row">'+
                               '<div class="col-12">'+
                               '<h6 style="padding-left:20px;"><b>Comportamiento:</b>&nbsp;'+arreglo[x].comportamiento+'</h6>'+
                               '<hr>'+
                               '</div>'+
                               '</div>'+
                               '<br>'+
                               '<div class="row">'+
                               '<div class="col-12">'+
                               '<h6 style="padding-left:20px;"><b>Categoria:</b>&nbsp;'+arreglo[x].categoria+'</h6>'+
                               '<hr>'+
                               '</div>'+
                               '</div>'+
                               '<div class="row">'+
                               '<div class="col-12">'+
                               '<a onclick="eliminar('+arreglo[x].id+')"  type="button" class="float-right"> &nbsp;&nbsp;<i class="fas fa-trash-restore-alt fa-lg" style="color:#EC4857;"></i></a>'+
                               '<a href="/reporte/insignias" type="button" class="float-right" style="color:blue;">&nbsp;&nbsp;<i class="fas fa-eye  fa-lg"></i></a>'+
                               '</div>'+
                               '</div>'+
                             '</div>'+
                      '</div>'+
                    '</div>'+
                  '</div>'+
                '</div>';


            }
            

            $('#datos').append(valor);
           }
            
          }
         
          //setTimeout(refrescar, 1000);
        
      }
  }).fail(function(jqXHR, response){
        
        $("#datos").empty();
        $("#datosuno").hide();
        toastr.warning('De forma exitosa!.', 'Notificación Eliminada', {timeOut:3000});
	  });
   
} 


function insignialeer(id){
      var insignoti=id;
      let rut = "{{ url('notificacion/insignia/estado/{id}') }}";
          rut = rut.replace('{id}', insignoti);
      $.ajax({
        url: rut,
        type: "GET",
        success:function(response){
         var res=response;
          $("#nnoti1").empty();
          $("#nnoti2").hide();
          var val = '<span class="badge badge-warning navbar-badge" style="color:white; font-size: 0.875em;">'+res+'</span>';
          $('#nnoti1').append(val);
         // console.log(r);
          //setTimeout(refrescar, 1000);
        
      },
  })
   
} 

function eliminarinsig(id){
      var idnoti=id;
      let ruta = "{{ url('notificacion/eliminar/insignia/{id}') }}";
          ruta = ruta.replace('{id}', idnoti);
      $.ajax({
        url: ruta,
        type: "GET",
        success:function(response){
          var arr = JSON.parse(response);
          toastr.warning('De forma exitosa!.', 'Notificación Eliminada', {timeOut:3000});
          $("#insignia").empty();
          $("#insigniados").hide();
          if(arr.length!=0){
            for(var x=0; x<arr.length; x++){
            var val=  '<div class="accordion" id="accordionExample">'+
                         '<div class="card">'+
                                '<div class="card-header" id="headingTwo">'+
                                  '<h2 class="mb-0">'+
                                    '<button class="btn btn-link btn-block text-left collapsed" type="submit" data-toggle="collapse" data-target="#collapseTwo'+arr[x].idnotinsig+'" aria-expanded="false" aria-controls="collapseTwo'+arr[x].idnotinsig+'">'+
                                      '<div class="row">'+
                                          '<div class="col-3">'+
                                            '<div  class="user-panel mt-0 pb-0 mb-0 d-flex" style="padding-left:5px;">'+
                                            '<img src="/imgpremios/'+ arr[x].imginsig +'" class="img-circle elevation-1" alt=" Image insignia" style="padding-bottom:2px;">'+
                                            '<br>'+
                                          '</div>'+
                                          '</div>'+
                                          '<div class="col-6">'+
                                            '<div class="info">'+
                                            'Felicidades Ganaste una Insignia'+
                                            '</div>'+
                                          '</div>'+
                                          '<div class="col-3">'+
                                            '<span class="float-right text-muted text-sm">'+ arr[x].fecha +'</span>'+
                                          '</div>'+
                                      '</div>'+                                                                        
                                    '</button>'+
                                  '</h2>'+
                                '</div>'+
                                '<div id="collapseTwo'+ arr[x].idnotinsig +'" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">'+
                                  '<div class="card-body" style="background-color:#08FFD5;">'+
                                   '<div class="container-flex">'+
                                      '<div class="row">'+
                                        '<div class="col-6">'+
                                          '<h6 style="padding-left:20px;" style="color:#FFFFFF;"><i class="fas fa-gift mr-2" style="color:#ffbd03"></i> Recibiste una Recompensa</h6>'+
                                        '</div>'+
                                        '<div class="col-6 text-right">'+
                                          '<img src="/imgpremios/'+ arr[x].preimagen +'" class="img-circle elevation-1" alt="User Image" style="padding-bottom:2px; width:50px; height: 50px;">&nbsp;&nbsp;'+
                                          '<span class="badge badge-warning navbar-badge" style="color:white; font-size: 0.875em;">'+ arr[x].insigpuntos +' </span>'+
                                        '</div>'+
                                      '</div>'+
                                      '<br>'+
                                      '<div class="row">'+
                                        '<div class="col-12">'+
                                          '<hr>'+
                                          '<h6 style="padding-left:20px;"><b>Insignia: </b>&nbsp;'+arr[x].name+'</h6>'+
                                          '<hr>'+
                                        '</div>'+
                                        '</div>'+
                                        '<br>'+
                                      '<div class="row">'+
                                        '<div class="col-12">'+
                                        '<h6 style="padding-left:20px;"><b>Nivel:</b>&nbsp;'+arr[x].nivel+'</h6>'+
                                          '<hr>'+
                                        '</div>'+
                                        '</div>'+
                                        '<br>'+
                                      '<div class="row">'+
                                        '<div class="col-12">'+
                                        '<h6 style="padding-left:20px;"><b>Recompensa:</b>&nbsp; '+arr[x].predes+'</h6>'+
                                            '<hr>'+
                                        '</div>'+
                                        '</div>'+
                                        '<div class="row">'+
                                        '<div class="col-12">'+
                                          '<a  onclick="eliminarinsig('+arr[x].idnotinsig+')"  type="button" class="float-right"> &nbsp;&nbsp;<i class="fas fa-trash-restore-alt fa-lg" style="color:#EC4857;"></i></a>'+
                                          '<a href="/reconocimientos/listar" type="button" class="float-right" style="color:blue;">&nbsp;&nbsp;<i class="fas fa-eye  fa-lg"></i></a>'+
                                        '</div>'+
                                        '</div>'+
                                      '</div>'+
                                  '</div>'+
                                '</div>'+
                              '</div>'+
                            '</div>';
          
                   $('#insignia').append(val);
           }

            
          }
         
          //setTimeout(refrescar, 1000);
        
      }
     }).fail(function(jqXHR, response){
        $("#insignia").empty();
        $("#insigniados").hide();
        toastr.warning('De forma exitosa!.', 'Notificación Eliminada', {timeOut:3000});
	  });
}

</script>

<script>
  //reproduce sonido 
    function sonido(){
      var sound = new Howl({
      src: ['/dist/img/sonido.mp3'],
      volume: 1.0,
      autoplay: true,   // true = se autoejecuta
      });
    sound.play();
    }
</script>


