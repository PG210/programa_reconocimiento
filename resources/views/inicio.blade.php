@extends('principal')
@section('content')
<div class="position-relative overflow-hidden p-3 p-md-5 m-md-3 text-center" style="background-image: url('dist/img/y.jpg');  background-position: center; background-repeat: no-repeat;  background-size: cover; position: relative; height:auto;">
<div class="position-relative overflow-hidden p-3 p-md-5 m-md-3 text-center ampliar">
  <div class="col-md-5 p-lg-5 mx-auto my-5">
   <!-- <h1 class="display-4 font-weight-normal letratitulo">ReconoSER</h1>
    <p class="lead font-weight-normal letrap">Bienvenidos a nuestro programa de reconocimientos.</p>
    <a class="btn btn-outline-secondary letrap" href="#">Comenzar</a>-->
  </div>
  <!--<div class="product-device shadow-sm d-none d-md-block"></div>
  <div class="product-device product-device-2 shadow-sm d-none d-md-block"></div>-->
</div>
</div>
<br>
<!--que es reconocer-->
<!--linea divisora-->
<div class="card-body" style="background-color:#082e41;">
    <h2 class="display-5 text-center letratitulo" style="color:white;">¿POR QUÉ TENER UN PROGRAMA DE RECONOCIMIENTO EN SU EMPRESA?</h2>
  </div>
<br>
<!--end - linea divisora-->
<div class="d-md-flex flex-md-equal w-100 my-md-3 pl-md-3">
  <div class="bg-light mr-md-3 pt-3 px-3 pt-md-5 px-md-5 text-center overflow-hidden">
    <img src="{{asset('images/demo/parrafo.jpg')}}" class="img-fluid" height="auto" width="100%" alt="Cargando imagen ...">
  </div>
  <div class="bg-light mr-md-3 pt-3 px-3 pt-md-5 px-md-5 text-center overflow-hidden">
    <div>
      <!--<h2 class="display-5">Another headline</h2>-->
      <p class="text-justify letrarob">
        Cuando el ser humano cuenta con sus necesidades básicas satisfechas dentro de una organización, el reconocimiento es el siguiente paso para aumentar su motivación, el sentido de pertenencia y su compromiso.
      </p>
       <p class="text-justify letrarob">
        Lo curioso es que a las personas se les dificulta (por diferentes razones) reconocer las cosas buenas de sus compañeros de trabajo, es más fácil evidenciar en que ha fallado y hacérselo saber de todas las maneras posibles, que decirle todo lo bueno que hace.
       </p>
       <p class="text-justify letrarob">
        AsaReconoce es una plataforma virtual que le ayudará a su organización a que las personas reconozcan de una manera divertida los comportamientos, competencias y/o valores de sus compañeros. Lo verán como un juego, con actividades a través del tiempo que ayudarán a consolidar en el día a día una cultura de reconocimiento, apalancando el fortalecimiento del clima organizacional de la organización.
      </p>
    </div>
  </div>
</div>
<!--end reconocer-->
<div class="d-md-flex flex-md-equal w-100 my-md-3 pl-md-3">
  <div class="mr-md-3 pt-3 px-3 pt-md-5 px-md-5 text-center text-white overflow-hidden" style="background-color:#004E5A;">
   <img src="{{asset('dist/img/puntos.jpg')}}" class="img-fluid" height="auto" width="100%" alt="Cargando imagen ...">
  </div>
  <div class="bg-light mr-md-3 pt-3 px-3 pt-md-5 px-md-5 text-center overflow-hidden">
    <div class="my-3 p-3">
      <h2 class="display-5 letratitulo" style="color:#004E5A;">PUNTOS</h2>
    </div>
    <!-- <div class="bg-dark shadow-sm mx-auto" style="width: 80%; height: 300px; border-radius: 21px 21px 0 0;">-->
    <div class="mx-auto" style="width: 95%; height: auto; border-radius: 21px;">
    <div class="container">
    <p class="text-justify letrarob">
    Gana puntos por la forma de comportarte:
    </p>
    <p class="text-justify letrarob">
      1. Ganaras puntos cada que te reconozcan.
    </p>
    <p class="text-justify letrarob">
      2. Existen diferentes tipos de puntos, según el alcance del comportamiento.
    </p>
    <p class="text-justify letrarob">
      3. ¡A mayor cantidad de puntos, mayor cantidad de recompensas!
      </p>
     </div> 
   </div> 
 </div>
</div>

<div class="d-md-flex flex-md-equal w-100 my-md-3 pl-md-3">
  <div class="bg-light mr-md-3 pt-3 px-3 pt-md-5 px-md-5 text-center overflow-hidden">
    <div class="my-3 p-3">
      <h2 class="display-5 letratitulo" style="color:#90D1BD;">INSIGNIAS</h2>
    </div>
      <div class="mx-auto" style="width: 95%; height: auto; border-radius: 21px;">
        <div class="container">
        <p class="text-justify letrarob">
        Los símbolos tienen el poder de hacernos sentir especiales:
        </p>
        <p class="text-justify letrarob">
          1. Permiten dar forma a lo que no la tiene (Valores, competencias, comportamientos).
        </p>
        <p class="text-justify letrarob">
          2. Nos ayudan a distinguir al que lo está haciendo muy bien.
        </p>
        <p class="text-justify letrarob">
          3. Aumentan el compromiso social del que la posee.
        </p>
        <p class="text-justify letrarob">
          4. Tienen una función motivadora a través del STATUS.
        </p>
        </div> 
    </div> 
  </div>
  <div class="mr-md-3 pt-3 px-3 pt-md-5 px-md-5 text-center text-white overflow-hidden" style="background-color:#90D1BD;">
    <img  src="{{asset('dist/img/insignias.jpg')}}" class="img-fluid" height="auto" width="100%" alt="Cargando imagen ...">
  </div>
</div>

<div class="d-md-flex flex-md-equal w-100 my-md-3 pl-md-3">
  <div class=" mr-md-3 pt-3 px-3 pt-md-5 px-md-5 text-center overflow-hidden" style="background-color:#4df9bd;">
    <img  src="{{asset('dist/img/recompensas.jpg')}}" class="img-fluid" height="auto" width="100%" alt="Cargando imagen ...">
  </div>
  <div class="bg-light mr-md-3 pt-3 px-3 pt-md-5 px-md-5 text-center overflow-hidden">
  <div class="my-3 p-3">
      <h2 class="display-5 letratitulo" style="color:#4df9bd;">RECOMPENSAS</h2>
    </div>
      <div class="mx-auto" style="width: 95%; height: auto; border-radius: 21px;">
        <div class="container">
        <p class="text-justify letrarob">
        Las recompensas están diseñadas para impactar el salario emocional:
        </p>
        <p class="text-justify letrarob">
          1. Las recompensas emocionales ofrecen muchas posibilidades. Hay formas infinitas de evocar emociones positivas.
        </p>
        <p class="text-justify letrarob">
          2. Una emoción positiva genera recordación y afianza el concepto de la marca empleadora.
        </p>
        <p class="text-justify letrarob">
          3. Facilita a los colaboradores beneficios no económicos que les hace sentirse felices dentro de la empresa. 
        </p>
        </div> 
    </div> 
  </div>
</div>
<!---votación-->
<div class="d-md-flex flex-md-equal w-100 my-md-3 pl-md-3">
  <div class="bg-light mr-md-3 pt-3 px-3 pt-md-5 px-md-5 text-center overflow-hidden">
    <div class="my-3 p-3">
      <h2 class="display-5 letratitulo" style="color:#90D1BD;">VOTACIÓN</h2>
    </div>
      <div class="mx-auto" style="width: 95%; height: auto; border-radius: 21px;">
        <div class="container">
        <p class="text-justify letrarob">
        La participación de todos los colaboradores de la compañia para elegir a los mejores, permitirá:
        </p>
        <p class="text-justify letrarob">
          1. Contar con un proceso democrático de elección.
        </p>
        <p class="text-justify letrarob">
          2. Involucrar a toda la organización para escoger a los que mejor representen las competencias, comportamientos y/o valores de la compañia.
        </p>
        <p class="text-justify letrarob">
          3. Generar concesos a través de la participación mayoritaria.
        </p>
        </div> 
    </div> 
  </div>
  <div class="mr-md-3 pt-3 px-3 pt-md-5 px-md-5 text-center text-white overflow-hidden" style="background-color:#90D1BD;">
    <img  src="{{asset('dist/img/insignias.jpg')}}" class="img-fluid" height="auto" width="100%" alt="Cargando imagen ...">
  </div>
</div>
<!--end votacion-->
<br>
@endsection