@extends('principal')
@section('content')
<style>
  .letra{
       font-family: 'Roboto Slab', serif;
       font-size:40px;
       line-height: 1.3;
       font-weight: 700;
       text-align:center; 
  }
  .textos{
       font-family: 'Roboto Slab', serif;
       font-size:20px;
       line-height: 1.5;
       color:#2E2E2E;
       text-align:justify; 
  }
  .textos1{
       font-family: 'Roboto Slab', serif;
       font-size:18px;
       line-height: 1.3;
       color:white;
       text-align:justify; 
  }
  .textos2{
       font-family: 'Roboto Slab', serif;
       font-size:19px;
       line-height: 1.3;
       color:white;
       text-align:center; 
  }
</style>
<div class="overlay">
    <div id="pageintro" class="hoc clear"> 
      <!-- ################################################################################################ -->
      <article>
       <!-- <h3 class="heading">Programa Reconocimiento</h3>
        <p>Lema</p>-->
       <!-- <footer><a class="btn" href="#">Iniciar</a></footer>-->
      </article>
      <!-- ################################################################################################ -->
    </div>
  </div>
  <!-- ################################################################################################ -->
</div>
<div class="wrapper row3" style="background-color:#F8F8F8;">
  <main class="hoc container clear"> 
    <!-- main body -->
    <!-- ################################################################################################ -->
    
    <section id="introblocks">
  
      <ul class="nospace group btmspace-80">
        <li class="one_third first" >
          <figure><a class="imgover"><img src="{{asset('dist/img/puntos.png')}}"  alt="cargando imagen ..."  style=" border: 2px; border-radius: 25px; background-color:white;"> </a>
            <figcaption style=" border: 2px;  padding: 10px; border-radius: 25px; ">
              <h6 class="heading textos2">PUNTOS</h6>
              <div class="textos1" style="color:white;">
               <!-- <p>¿Como ganar puntos?</p>-->
               <p> Ser bueno en tu trabajo siempre trae cosas buenas, recibe reconocimientos por parte de tus compañeros y gana puntos redimibles.</p>
              </div>
            </figcaption>
          </figure>
        </li>
        <li class="one_third">
          <figure><a class="imgover" href="#"><img src="{{asset('dist/img/insignia.png')}}"  alt="cargando imagen ..." style=" border: 2px; border-radius: 25px; background-color:white;"></a>
            <figcaption style=" border: 2px;  padding: 10px; border-radius: 25px; ">
              <h6 class="heading textos2">INSIGNIAS</h6>
              <div class="textos1">
               <!-- <p>¿Como ganar insignias?</p>-->
                <p>Los puntos obtenidos por tu buen trabajo, se ven reflejados en cada insignia obtenida.</p>
              </div>
            </figcaption>
          </figure>
        </li>
        <li class="one_third">
          <figure><a class="imgover" href="#"><img src="{{asset('dist/img/recompensas.png')}}" alt="cargando imagen ..." style=" border: 2px; border-radius: 25px; background-color:white;"></a>
            <figcaption style=" border: 2px;  padding: 10px; border-radius: 25px; ">
              <h6 class="heading textos2">RECOMPENSAS</h6>
              <div class="textos1">
               <!-- <p>¿Como obtener recompensas?</p>-->
                <p>Cada insignia trae con sigo una gran recompensa.</p>
              </div>
            </figcaption>
          </figure>
        </li>
      </ul>
    </section>
    <!-- ################################################################################################ -->
    <div style=" border: 2px;  padding: 10px; border-radius: 25px; color:#15AFBA;" class="letra">¿POR QUÉ TENER UN PROGRAMA DE RECONOCIMIENTO EN SU EMPRESA? </div>
    <hr class="btmspace-80">
    
    <!-- ################################################################################################ -->
    <section class="group">
      <div class="one_half first"><img class="inspace-15 borderedbox" src="{{asset('images/demo/trofeo.png')}}" alt="cargando imagen ..." style="border-radius: 25px; background-color:white;" width="100%;"></div>
      <div class="one_half textos">
               <p> 
                Todos los estudios demuestras que cuando el ser humano es reconocido, su <span style="color:#FFBD03;">motivación</span>, sentido de <span style="color:#FFBD03;">pertenencia</span> y su <span style="color:#FFBD03;">compromiso</span> aumentan.
               </p>
               <p>
                Lo curioso es que se nos dificulta (por diferentes razones) reconocer las cosas buenas del otro, es más fácil evidenciar en que ha fallado y hacérselo saber de todas las maneras posible, que decirle todo lo bueno que hace.
               </p>
               <p>
               Por tanto, nuestro programa de reconocimiento le ayudará a que sea fácil y divertido reconocer, lo verán como un juego, con actividades a través del tiempo que irán consolidando día a día una cultura de agradecimiento, apalancando el fortalecimiento del clima organizacional, de las competencias y los valores organizacionales.
               </p>
      </div>
    </section>
    <!-- ################################################################################################ -->
    <!-- / main body -->
    <div class="clear"></div>
  </main>
</div>
  <!-- ################################################################################################ -->
  </section>
</div>

<!--
<div class="wrapper" style="background-color:#C4C4C4;">
  <div class="hoc container clear"> 
      <div style=" border: 2px;  padding: 10px; border-radius: 25px; color:#082e41;" class="letra">¿QUÉ PODRÁS HACER EN NUESTRO PROGRAMA DE RECONOCIMIENTO? </div>
       <hr class="btmspace-80">
       <ul class="nospace group team">
      <li class="one_quarter first">
        <figure><a class="imgover" href="#"><img src="images/demo/300x300.png" alt=""></a>
          <figcaption><strong>A. Doe</strong> <em>Job Title Here</em></figcaption>
        </figure>
      </li>
      <li class="one_quarter">
        <figure><a class="imgover" href="#"><img src="images/demo/300x300.png" alt=""></a>
          <figcaption><strong>B. Doe</strong> <em>Job Title Here</em></figcaption>
        </figure>
      </li>
      <li class="one_quarter">
        <figure><a class="imgover" href="#"><img src="images/demo/300x300.png" alt=""></a>
          <figcaption><strong>C. Doe</strong> <em>Job Title Here</em></figcaption>
        </figure>
      </li>
      <li class="one_quarter">
        <figure><a class="imgover" href="#"><img src="images/demo/300x300.png" alt=""></a>
          <figcaption><strong>D. Doe</strong> <em>Job Title Here</em></figcaption>
        </figure>
      </li>
    </ul>
  </div>
</div>-->
<!-- ################################################################################################ -->
<!-- ################################################################################################ -->
<!-- ################################################################################################ -->

@endsection