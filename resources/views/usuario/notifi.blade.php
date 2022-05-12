<?php

  use App\Models\ModelNotify\Notificacion;
  use Illuminate\Support\Facades\DB;
  use Illuminate\Support\Facades\Auth;

  $usu= auth()->user()->id;
  $val = DB::table('notificaciones')->where('id_user', $usu)->where('estado', 1)->count();
  if($val!=0){
    $noti = DB::table('notificaciones')->where('id_user', $usu)->where('estado', 1)->get();
  }

?>
<li class="nav-item dropdown">
        
        <!---###modal----->
          <!-- Button trigger modal -->
          <a type="button" class="nav-link" data-toggle="modal" data-target="#exampleModal">
             <i class="far fa-bell fa-lg"></i>
             @if($val!=null)
             <span class="badge badge-warning navbar-badge" style="color:white; font-size: 0.875em;"> 
            {{$val}}
            </span>
            @endif
          </a>

          <!-- Modal -->
          <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable">
              <div class="modal-content">
                <div class="modal-header" style="background-color:#1ED5F4; color:white;">
                  <h5 class="modal-title" id="exampleModalLabel"><span >Tienes {{$val}} Notificaciones</span></h5>
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
                              <i class="fas fa-award mr-2" style="color:#ffbd03"></i>{{$n->notinom}}
                              <span class="float-right text-muted text-sm">3 </span>
                            </button>
                          </h2>
                        </div>
                        <div id="collapseTwo{{$n->id}}" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
                          <div class="card-body">
                            {{$n->notides}}
                          </div>
                        </div>
                      </div>
                    </div>
                    @endforeach
                    @endif
                  <!---collapse end--->
                </div>
                <!---acomodar-->
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item dropdown-footer">Todas las notificaciones</a>
                <!---end acomodar-->
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
<script>

function test(id){
      var idnoti=id;
      console.log(idnoti);
      let ruta = "{{ url('notificacion/estado/{id}') }}";
          ruta = ruta.replace('{id}', idnoti);
      console.log(ruta);
      $.ajax({
        url: ruta,
        type: "GET",
        success:function(response){
          toastr.success('El registro se ingreso correctamente.', 'Nuevo Registro', {timeOut:3000});
          //setTimeout(refrescar, 1000);
        
      },
  })
   
} 
</script>


