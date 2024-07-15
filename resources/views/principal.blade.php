<!doctype html>
<html lang="es">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Evolución, ReconoSER, Programa de incentivos y reconocimientos">
    <title>Evolución</title>
    <link rel="icon" href="{{asset('dist/img/favicon.png')}}">
    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Slab:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link href='https://fonts.googleapis.com/css?family=Roboto' rel='stylesheet'>
    <link href="{{ asset('/layouts_inicio/product.css') }}" rel="stylesheet" type="text/css" media="all">
    <style>
      /*se agrega para verificar */
      * {margin:0; padding:0}
      /*end verificar */
      .bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
      }

      @media (min-width: 768px) {
        .bd-placeholder-img-lg {
          font-size: 3.5rem;
        }
      }

      .ir-arriba {
        display:none;
        padding:5px;
        background:#024959;
        font-size:20px;
        color:#fff;
        cursor:pointer;
        position: fixed;
        bottom:20px;
        right:20px;
        border-radius:10px;
      }

     @media screen and (min-width: 1901px) {
        .letrarob {
          font-family: 'Roboto';
          line-height: 1.6;
        }
        
        .letratitulo{
          font-family: 'Roboto Slab', serif;
          font-size: 3rem;
          font-weight:700;
        }

        .letratitulofooter{
          font-family: 'Roboto Slab', serif;
          font-size: 1.5rem;
          font-weight:700;
        }

        .letrap{
          font-family: 'Roboto Slab', serif;
          font-size: 25px;
          font-weight:400;
        }
        
        .icono{
          font-size:45px;
        }

       /* .ampliar{
          padding: 6rem !important;
        }*/

        .ampliarnav{
          padding: 2rem !important;
        }

        .imagenlogin{
          padding: 17em;
        }
        .forms{  
          max-width: 100%;
        }

        .centraform{
          margin-left: 25% !important;
          font-size:30px;
        }

        .boton {
          font-size: 24px;
         }

        .iconwsp{
          width: 80px;
          height: 80px;
        }

        /*Se agrego estas lineas css */

        .imagenlogo{
          max-width: 390px !important;
          height: 145px !important;
        }

        .container{
          max-width: 1200px !important;
        }

        .btningresar{
          font-size:33px;
        }

        .iconfont{
          font-size:30px;
        }
        
      }/*Este rango esta bien para pantallas medianas*/

      @media screen and (min-width: 2400px) {
        .letrarob {
          font-family: 'Roboto';
          font-size: 45px;
          line-height: 1.6;
        }
        
        .letratitulo{
          font-family: 'Roboto Slab', serif;
          font-size: 3rem;
          font-weight:700;
        }

        .letratitulofooter{
          font-family: 'Roboto Slab', serif;
          font-size: 2rem;
          font-weight:700;
        }

        .letrap{
          font-family: 'Roboto Slab', serif;
          font-size: 25px;
          font-weight:400;
        }
        
        .icono{
          font-size:45px;
        }

        .ampliar{
          padding: 6rem !important;
        }

        .ampliarnav{
          padding: 2rem !important;
        }

        .imagenlogin{
          padding: 17em;
        }
        .forms{  
          max-width: 100%;
        }

        .centraform{
          margin-left: 25% !important;
          font-size:30px;
        }

        .boton {
          font-size: 24px;
         }

        .iconwsp{
          width: 80px;
          height: 80px;
        }

        /*Se agrego estas lineas css */

        .imagenlogo{
          max-width: 390px !important;
          height: 145px !important;
        }

        .container{
          max-width: 1200px !important;
        }

        .btningresar{
          font-size:33px;
        }

        .iconfont{
          font-size:30px;
        }
        
      }/*Este rango esta bien para pantallas extragrandes*/

    
      @media screen and (min-width: 1440px) and (max-width: 1900px) {
        .letrarob {
          font-family: 'Roboto';
          font-size: 24px;
          line-height: 1.6;
        }

        .letratitulofooter{
          font-family: 'Roboto Slab', serif;
          font-weight:700;
        }

        .letrap{
          font-family: 'Roboto Slab', serif;
          font-weight:400;
        }
       
        .icono{
          font-size:24px;
        }
        /*Se agrego esta codigo css */
         .imagenlogo{
          height: auto; 
          width: 80%;
        }

        .iconfont{
          font-size:25px;
        }
      }/*este rango esta bien para pantallas medianas */

      @media screen and (max-width: 1439px) {
        .letrarob {
          font-family: 'Roboto';
          font-size: 18px;
          line-height: 1.6;
        }

        .letratitulofooter{
          font-family: 'Roboto Slab', serif;
          font-weight:700;
        }

        .letrap{
          font-family: 'Roboto Slab', serif;
          font-weight:400;
        }

        .icono{
          font-size:24px;
        }
        /*Se agrego esta codigo css */
        .imagenlogo{
          height: auto; 
          width: 80%;
        }

        .iconfont{
          font-size:18px;
        }
      }/*Este rango para pantallas pequeñas */
    </style>
    <!-- Custom styles for this template -->
  </head>
  <body style="background-color:white;">
<!--navar-->
<nav class="navbar navbar-expand-lg navbar-light sticky-top ampliarnav" style="background-color:white; padding:0;">
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo03" aria-controls="navbarTogglerDemo03" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarTogglerDemo03">
  <div class="container d-flex flex-column flex-md-row justify-content-between">
    <a href="#" aria-label="Product">
      <img src="dist/img/evolucion_fondo_2.jpg" class="img-fluid imagenlogo" alt="Cargando imagen ...">
    </a>
    <div class="form-inline">
     <a class="mr-sm-3" href="{{url('/')}}"><i class="bi bi-house-fill iconfont" style="color:#15AFBA;"></i></a>&nbsp;
      <!--login-->
      @if (Route::has('login'))
      @auth
        <a class="form-control mr-sm-2 btningresar"  href="{{ url('/dashboard') }}" style="background-color:#15AFBA; color:white; text-decoration:none;"><b>Volver</b></a>
      @else
      <a class="form-control mr-sm-2 btningresar" href="{{url('/reg') }}" style="background-color:#15AFBA; color:white; text-decoration:none;"><i class="bi bi-arrow-right-square-fill iconfont" style="color:white;"></i> Ingresar</a>
      @endauth
    @endif
    </div>
  </div>
  </div>
</nav>
  <span class="ir-arriba"><i class="bi bi-arrow-up-square-fill" style="font-size: 24px; color:white;"></i></span>
  <!--end navar-->
        @yield('content')

<br>
<div class="card-footer" style="background-color:#15AFBA; color:white;">
  <footer class="container py-5" >
    <div class="row">
      
      <div class="col-lg-4 col-md-4">
         <div class="container" style="background-color:white; border-radius:20px;" >
         <a href="https://www.evolucion.co/" aria-label="Product" target="_blank">
            <img src="dist/img/evolucion_fondo.png" class="img-fluid imagenlogo" alt="Cargando imagen ...">
          </a>
       </div>
        
      </div>
      <div class="col-lg-3 col-md-3">
        <h5 class="letratitulofooter">Servicios</h5>
         <!--============= links de menu =================-->
        <div class="btn-group dropright text-small letrap">
          <a type="button" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false" style="color:white;">
            FormAcción
          </a>
          <div class="dropdown-menu">
            <!-- Dropdown menu links -->
            <a class="dropdown-item" href="https://evolucion.co/liderazgo/" target="_blank">Liderazgo Innovador</a>
            <a class="dropdown-item" href="https://evolucion.co/venta-consultiva/" target="_blank">Venta Consultiva</a>
            <a class="dropdown-item" href="https://evolucion.co/formadores-de-facilitadores/" target="_blank">Formadores de Facilitadores</a>
            <a class="dropdown-item" href="https://evolucion.co/creatividad-e-innovacion/" target="_blank">Creatividad e Innovación</a>
            <a class="dropdown-item" href="https://evolucion.co/cohesion-de-equipos/" target="_blank">Cohesión de Equipos</a>
          </div>
        </div>
        <!----===============================-->
        <div class="btn-group dropright text-small letrap">
          <a type="button" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false" style="color:white;">
            Tecnologías de <br> educación
          </a>
          <div class="dropdown-menu">
            <!-- Dropdown menu links -->
            <a class="dropdown-item" href="https://evolucion.co/metaversos/" target="_blank">Metaversos</a>
            <a class="dropdown-item" href="https://evolucion.co/g-learning/" target="_blank">G-Learning</a>
            <a class="dropdown-item" href="https://evolucion.co/reconoser/" target="_blank">ReconoSer</a>
            <a class="dropdown-item" href="https://evolucion.co/realidad-aumentada/" target="_blank">Realidad Aumentada</a>
            <a class="dropdown-item" href="https://evolucion.co/microlearning/" target="_blank">Microlearning WhatsApp</a>
          </div>
        </div>
         <!--============= links de menu =================-->
      </div>
      <div class="col-lg-2 col-md-3">
        <h5 class="letratitulofooter">Políticas</h5>
        <ul class="list-unstyled text-small letrap">
           <li><a type="button" data-toggle="modal" data-target="#acerca">Acerca</a></li>
            <!-- Button trigger modal -->
            <!-- Modal -->
            <div class="modal fade" id="acerca" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
              <div class="modal-dialog modal-dialog-scrollable">
                <div class="modal-content">
                  <div class="container">
                    <br>
                    <h5 class="letratitulo" id="staticBackdropLabel" style="color:#4c519c; text-align:center; padding-top:2px; font-size:24px;">EN EVOLUCIÓN</h5>
                    <hr>
                  </div>
                  <div class="modal-body text-justify letrap" style="font-size:20px;">
                    <!---frase-->
                    <p style="color:black;">
                    Creemos que <span style="color:#4c519c;"><b>un enfoque experiencial y divertido</b></span> es el mejor catalizador para el  <span style="color:#4c519c;"><b>aprendizaje en las organizaciones.</b></span> Para nosotros, tanto el contenido a dar como la forma de darlo es igualmente importante.  
                    </p>
                    <p style="color:black;">
                    Por esto, vivimos en constante actualización no solo de los mejores contenidos, si no también de los <span style="color:#4c519c;"><b>mejores métodos de facilitación organizacional</b></span> para adultos, para que ellos vivan experiencias a través de nuestros diseños (presenciales y/o virtuales), generando reflexiones, conceptualizaciones de los temas a trabajar y sobre todo obtengan una ruta de clara de cómo aplicar lo aprendido en sus vidas. 
                    </p>
                    <p style="color:black;">
                    <span style="color:#4c519c;"><b>
                    Son ustedes el centro de todo lo que construimos. Son ustedes los protagonistas activos de cada proceso formativo. </b></span>
                    </p>
                    <p style="color:black;">
                    Disfrutamos lo que hacemos, cada reto supone para nosotros un proceso apasionante de <span style="color:#4c519c;"><b>ideación a la medida de cada organización</b></span>, crear, innovar y diseñar nuevas formas de transferir ese conocimiento que la compañía necesita para sus colaboradores de una manera divertida, constructivista y aplicable en el tiempo es sin duda, nuestra razón de ser…
                    </p>
                    <!--frase-->
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-warning" data-dismiss="modal">Salir</button>
                  </div>
                </div>
              </div>
            </div>
          <!--end --modal-->
          <li>
           <a type="button" data-toggle="modal" data-target="#acceso">
              Acceso
            </a>
          </li>
          <!--modal-->
            <!-- Modal -->
            <div class="modal fade" id="acceso" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
              <div class="modal-dialog modal-dialog-scrollable">
                <div class="modal-content">
                  <div class="container">
                    <br>
                    <h5 class="letratitulo" id="staticBackdropLabel" style="color:#4c519c; text-align:center; padding-top:2px; font-size:24px;">POLÍTICAS DE CONTROL DE ACCESO</h5>
                    <hr>
                  </div>
                  <div class="modal-body text-justify letrap" style="font-size:18px;">
                    <!---frase-->
                   <div class="container"> 
                    <p style="color:black;">
                    <ul>
                      <li style="color:black; font-size:18px;">Esta prohibido acceder a la información o archivos de otros usuarios dentro de ReconoSER sin la autorización correspondiente.</li>
                      <li style="color:black; font-size:18px;">Únicamente el personal del área de desarrollo está autorizado para acceder al código fuente del aplicativo.</li>
                      <li style="color:black; font-size:18px;">El control de acceso se basa en roles predefinidos, los cuales deberán asignarse a los diferentes usuarios de acuerdo con su perfil en la organización.</li>
                      <li style="color:black; font-size:18px;">El usuario debe tener autorización de la respectiva Dirección para el uso de ReconoSER. Se debe verificar que el nivel de acceso otorgado sea adecuado para los propósitos de la empresa.</li>
                    </ul>
                    </p>
                  </div>
                    <!--frase-->
                  </div>
                  <div class="modal-footer font-size:18px;">
                    <button type="button" class="btn btn-warning" data-dismiss="modal">Salir</button>
                  </div>
                </div>
              </div>
            </div>
          <!--end --modal-->
          <!--end modal-->
          <li>
           <a type="button" data-toggle="modal" data-target="#seguridad">
              Seguridad
            </a>
              <!-- Modal -->
              <div class="modal fade" id="seguridad" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
              <div class="modal-dialog modal-dialog-scrollable">
                <div class="modal-content">
                  <div class="container">
                    <br>
                    <h5 class="letratitulo" id="staticBackdropLabel" style="color:#4c519c; text-align:center; padding-top:2px; font-size:24px;">POLÍTICAS DE CONTROL DE SEGURIDAD</h5>
                    <hr>
                  </div>
                  <div class="modal-body text-justify letrap" style="font-size:18px;">
                    <!---frase-->
                    <div class="container">
                    <p style="color:black;">
                    <ul>
                      <li style="color:black;">Los usuarios deben ser únicos y no podrán ser compartidos. Asimismo, los
                      Privilegios o roles de los usuarios será asignados por el encargad@ de la aplicación Reconocer.
                      </li>
                      <li style="color:black;">
                       El registro de usuarios y la asignación de contraseñas se lleva a cabo por el usuario administrador. Se recomienda actualizar la contraseña en el apartado de perfil para continuar utilizando la aplicación.
                     </li>
                      <li style="color:black;">Para el acceder al aplicativo se debe utilizar contraseñas de alta seguridad, las cuales contengan caracteres especiales o símbolos difíciles de descifrar.
                     </li>
                     <li style="color:black;">Si un usuario decide no continuar con el uso del aplicativo deberá notificar al encargado para ser eliminado de manera permanente.
                     </li>
                     <li style="color:black;">Se garantiza la seguridad de la información de cada usuario registrado en la base de datos del aplicativo ReconoSER.
                     </li>
                     </ul>
                    </p>
                  </div>
                    <!--frase-->
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-warning" data-dismiss="modal">Salir</button>
                  </div>
                </div>
              </div>
            </div>
          <!--end --modal-->
          </li>
        </ul>
      </div>
      <div class="col-lg-3 col-md-3">
        <h5 class="letratitulofooter">Contactos</h5>
        <ul class="list-unstyled text-small letrap">
          <li><a style="color:white;" href="#"> +57 3172821923</a></li>
          <li><a style="color:white;" href="mailto:info@envolucion.co"> info@envolucion.co</a></li>
          <li>
              <a style="color:white;" href="https://www.instagram.com/somos_evolucion_?igsh=amU2eG1xamR5Ync1" target="_blank"><i class="bi bi-instagram icono" style="color:#833ab4;"></i></a>&nbsp;&nbsp;
              <a href="https://www.linkedin.com/company/evolucionaprendizajedivertido/?viewAsMember=true" target="_blank"><i class="bi bi-linkedin icono" style="color:#006AA4;"></i></a></li>
        </ul>
      </div>
    </div>
  </footer>
</div>
<div class="card-footer text-center" style="padding: 1px; background-color:#082e41; color:white;">
      <small class="d-block mb-3 text-center letrap" style="padding-top:3px;">Copyright © 2024 Evolución. Todos los derechos reservados</small>
</div>
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <!-- GetButton.io widget -->
<script type="text/javascript">
    (function () {
        var options = {
            whatsapp: "+573172821923", // WhatsApp number
            call_to_action: "Evolución", // Call to action
            button_color: "#FF6550", // Color of button
            position: "left", // Position may be 'right' or 'left'
            pre_filled_message: "Información acerca del programa de reconocimiento.", // WhatsApp pre-filled message
        };
        var proto = 'https:', host = "getbutton.io", url = proto + '//static.' + host;
        var s = document.createElement('script'); s.type = 'text/javascript'; s.async = true; s.src = url + '/widget-send-button/js/init.js';
        s.onload = function () { WhWidgetSendButton.init(host, proto, options); };
        var x = document.getElementsByTagName('script')[0]; x.parentNode.insertBefore(s, x);
    })();
</script>
<!-- /GetButton.io widget --> 
<script>
    $(document).ready(function(){

  $('.ir-arriba').click(function(){
    $('body, html').animate({
      scrollTop: '0px'
    }, 300);
  });

  $(window).scroll(function(){
    if( $(this).scrollTop() > 0 ){
      $('.ir-arriba').slideDown(300);
    } else {
      $('.ir-arriba').slideUp(300);
    }
  });

  });
</script>
<!--aqui script de chatboot-->

<!--end script-->
  </body>
</html>
