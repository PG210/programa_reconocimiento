@extends('principal')
@section('content')
<style>
.f-box.style-1 {
  border: 1px solid rgba(20, 22, 24, 0.2);
  padding: 44px 36px;
  -webkit-transition: ease-out 0.14s;
  transition: ease-out 0.14s;
}
.f-box.style-1 {
    padding: 34px 30px;
  }
.f-box.style-1 {
    padding: 24px 20px;
  }
.f-box.style-1 .f-box-icon {
  margin-bottom: 20px;
  font-size: 40px;
  color: var(--success);
}
.f-box.style-1:hover {
  border-color: #141618;
}
.f-box.style-2 {
  border: 1px solid rgba(20, 22, 24, 0.2);
  padding: 44px 36px;
  -webkit-transition: ease-out 0.14s;
  transition: ease-out 0.14s;
}
.f-box.style-2 {
    padding: 34px 30px;
  }
.f-box.style-2 {
    padding: 24px 20px;
  }
.f-box.style-2 .f-box-icon {
  margin-bottom: 20px;
  font-size: 36px;
  color: #141618;
  -webkit-transition: ease-out 0.14s;
  transition: ease-out 0.14s;
}
.f-box.style-2 h6 {
  -webkit-transition: ease-out 0.14s;
  transition: ease-out 0.14s;
}
.f-box.style-2:hover {
  background: #f2f5f8;
  border-color: transparent;
}
.f-box.style-2 {
  border-color: var(--primary);
}
.f-box.style-1:hover {
  border-color: #fff;
}
.f-box.style-2 .f-box-icon {
  color: #fff;
}
.f-box.style-2:hover {
  background: rgba(255, 255, 255, 0.1);
  border-color: transparent;
}
.button-circle-2xl {
    width: 140px;
    height: 140px;
    line-height: 130px;
    font-size: 26px;
}

.button-circle-2xl i {
  line-height: 80px;
}

.button-circle-dark {
  background: var(--primary);
  color: rgba(255, 255, 255, 0.8);
}

.button-circle-dark:focus {
  background: var(--primary);
  color: #fff;
}

.button-circle-animation-drop {
  position: relative;
}.button-circle-animation-drop:before {
  content: '';
  position: absolute;
  top: 50%;
  left: 50%;
  -webkit-transform: translate(-50%, -50%);
  transform: translate(-50%, -50%);
  opacity: 1;
  width: 100%;
  height: 100%;
  border: 2px solid var(--primary);
  border-radius: 50%;
  -webkit-animation: button-drop 2s ease-out infinite;
  animation: button-drop 2s ease-out infinite;
}.button-circle-animation-drop:hover {
  -webkit-transform: scale(0.92);
  transform: scale(0.92);
}.button-circle-animation-drop.button-circle-white:before {
  border-color: rgba(255, 255, 255, 0.4);
}.button-circle-animation-drop.button-circle-outline-white-2:before {
  border-color: rgba(255, 255, 255, 0.3);
}.button-circle-animation-drop-2 {
  position: relative;
}.button-circle-animation-drop-2:before {
  content: '';
  position: absolute;
  top: 50%;
  left: 50%;
  -webkit-transform: translate(-50%, -50%);
  transform: translate(-50%, -50%);
  z-index: -1;
  opacity: 1;
  background: rgba(20, 22, 24, 0.1);
  width: 100%;
  height: 100%;
  border-radius: 50%;
  -webkit-animation: button-drop 2s ease-out infinite;
  animation: button-drop 2s ease-out infinite;
}.button-circle-animation-drop-2:hover {
  -webkit-transform: scale(0.92);
  transform: scale(0.92);
}.button-circle-animation-drop-2.button-circle-white:before {
  background: rgba(255, 255, 255, 0.2);
}.button-circle-animation-drop-2.button-circle-outline-white-2:before {
  background: rgba(255, 255, 255, 0.1);
}

.button-circle:focus {
  -webkit-transform: scale(1.04);
  transform: scale(1.04);
}.button-circle:focus {
  -webkit-transform: scale(0.96);
  transform: scale(0.96);
}.button-circle {
  background: #e6e6e6;
  display: inline-block;
  border-radius: 50%;
  color: #141618;
  text-align: center;
  -webkit-transition: ease-out 0.14s;
  transition: ease-out 0.14s;
}.button-circle:hover {
  color: #767A7D;
}.button-circle-xs {
  width: 32px;
  height: 32px;
  line-height: 32px;
}.button-circle-xs i {
  line-height: 32px;
}.button-circle-sm {
  width: 40px;
  height: 40px;
  line-height: 40px;
}.button-circle-sm i {
  line-height: 40px;
}.button-circle-md {
  width: 50px;
  height: 50px;
  line-height: 50px;
}.button-circle-md i {
  line-height: 50px;
}.button-circle-lg {
  width: 60px;
  height: 60px;
  line-height: 60px;
}.button-circle-lg i {
  line-height: 60px;
}.button-circle-xl {
  width: 70px;
  height: 70px;
  line-height: 70px;
}.button-circle-xl i {
  line-height: 70px;
}.button-circle-2xl i {
  line-height: 80px;
}.button-circle-gray {
  background: #eff2f5;
  color: rgba(20, 22, 24, 0.9);
}.button-circle-gray:focus {
  background: #e5e8eb;
  color: #141618;
}.button-circle-dark {
  background: var(--primary);
  color: rgba(255, 255, 255, 0.8);
}.button-circle-dark:focus {
  background: #141618;
  color: #fff;
}.button-circle-black {
  background: #000;
  color: rgba(255, 255, 255, 0.8);
}.button-circle-black:focus {
  background: #000;
  color: #fff;
}.button-circle-white {
  background: rgba(255, 255, 255, 0.9);
  color: rgba(20, 22, 24, 0.9);
}.button-circle-white:focus {
  background: #fff;
  color: #141618;
}.button-circle-outline-gray {
  background: transparent;
  border: 1px solid rgba(20, 22, 24, 0.2);
  color: rgba(20, 22, 24, 0.9);
}.button-circle-outline-gray:focus {
  border-color: #141618;
  color: #141618;
}.button-circle-outline-dark {
  background: transparent;
  border: 1px solid rgba(20, 22, 24, 0.8);
  color: rgba(20, 22, 24, 0.9);
}.button-circle-outline-dark:focus {
  border-color: rgba(20, 22, 24, 0.2);
  color: #141618;
}.button-circle-outline-white {
  background: transparent;
  border: 1px solid rgba(255, 255, 255, 0.3);
  color: rgba(255, 255, 255, 0.9);
}.button-circle-outline-white:focus {
  border-color: #fff;
  color: #fff;
}.button-circle-outline-white-2 {
  background: transparent;
  border: 1px solid #fff;
  color: rgba(255, 255, 255, 0.9);
}.button-circle-outline-white-2:focus {
  border-color: rgba(255, 255, 255, 0.2);
  color: #fff;
}.button-circle-hover-slide {
  position: relative;
  display: inline-block;
  overflow: hidden;
}.button-circle-hover-slide i {
  position: absolute;
  left: 50%;
  -webkit-transition: ease-out 0.14s;
  transition: ease-out 0.14s;
}.button-circle-hover-slide i:first-child {
  top: 50%;
  -webkit-transform: translateX(-50%) translateY(-50%);
  transform: translateX(-50%) translateY(-50%);
}.button-circle-hover-slide i:last-child {
  top: 100%;
  -webkit-transform: translateX(-50%);
  transform: translateX(-50%);
}.button-circle-hover-slide:hover i:first-child {
  top: -100%;
  -webkit-transform: translateX(-50%) translateY(0);
  transform: translateX(-50%) translateY(0);
}.button-circle-hover-slide:hover i:last-child {
  top: 50%;
  -webkit-transform: translateX(-50%) translateY(-50%);
  transform: translateX(-50%) translateY(-50%);
}.button-circle-animation-drop {
  position: relative;
}.button-circle-animation-drop:before {
  content: '';
  position: absolute;
  top: 50%;
  left: 50%;
  -webkit-transform: translate(-50%, -50%);
  transform: translate(-50%, -50%);
  opacity: 1;
  width: 100%;
  height: 100%;
  border: 2px solid rgba(20, 22, 24, 0.1);
  border-radius: 50%;
  -webkit-animation: button-drop 2s ease-out infinite;
  animation: button-drop 2s ease-out infinite;
}.button-circle-animation-drop:hover {
  -webkit-transform: scale(0.92);
  transform: scale(0.92);
}.button-circle-animation-drop.button-circle-white:before {
  border-color: rgba(255, 255, 255, 0.4);
}.button-circle-animation-drop.button-circle-outline-white-2:before {
  border-color: rgba(255, 255, 255, 0.3);
}.button-circle-animation-drop-2 {
  position: relative;
}.button-circle-animation-drop-2:before {
  content: '';
  position: absolute;
  top: 50%;
  left: 50%;
  -webkit-transform: translate(-50%, -50%);
  transform: translate(-50%, -50%);
  z-index: -1;
  opacity: 1;
  background: rgba(20, 22, 24, 0.1);
  width: 100%;
  height: 100%;
  border-radius: 50%;
  -webkit-animation: button-drop 2s ease-out infinite;
  animation: button-drop 2s ease-out infinite;
}.button-circle-animation-drop-2:hover {
  -webkit-transform: scale(0.92);
  transform: scale(0.92);
}.button-circle-animation-drop-2.button-circle-white:before {
  background: rgba(255, 255, 255, 0.2);
}.button-circle-animation-drop-2.button-circle-outline-white-2:before {
  background: rgba(255, 255, 255, 0.1);
}.button-circle) {
    color: rgba(255, 255, 255, 0.7);
  }.button-circle):focus {
    color: #fff;
  }.button-circle) {
    color: rgba(255, 255, 255, 0.7);
  }.button-circle):focus {
    color: #fff;
  }.button-circle) {
    color: rgba(255, 255, 255, 0.7);
  }.button-circle):focus {
    color: #fff;
  }.button-circle) {
    color: rgba(255, 255, 255, 0.8);
  }.button-circle):focus {
    color: #fff;
  }
scrolltotop:
.scrolltotop {
  position: fixed;
  right: 30px;
  bottom: 30px;
  -webkit-transform: translateY(20px);
  transform: translateY(20px);
  z-index: 989;
  visibility: hidden;
  opacity: 0;
  -webkit-transition: ease-out 0.12s;
  transition: ease-out 0.12s;
}

m-dropdown:
.m-dropdown {
    position: absolute;
    top: 84px;
    left: 0;
    -webkit-transform: translateY(10px);
    transform: translateY(10px);
    z-index: 990;
    visibility: hidden;
    opacity: 0;
    background: #fff;
    width: 240px;
    -webkit-box-shadow: 0 6px 38px -4px rgba(24, 27, 30, 0.14);
    box-shadow: 0 6px 38px -4px rgba(24, 27, 30, 0.14);
    border-radius: 0.375em;
    padding: 15px 0;
    -webkit-transition: ease-out 0.14s;
    transition: ease-out 0.14s;
  }.m-dropdown {
    right: 0;
    left: auto;
  }.m-dropdown {
    -webkit-transform: translateY(0);
    transform: translateY(0);
    visibility: visible;
    opacity: 1;
  }.m-dropdown {
    right: 0;
    left: auto;
  }.m-dropdown {
    display: none;
    background: #f2f5f8;
    border-radius: 4px;
    margin-top: 4px;
    padding: 14px 20px;
  }.m-dropdown {
    top: 104px;
  }.m-dropdown {
    top: 124px;
  }.m-dropdown {
    background: rgba(255, 255, 255, 0.9);
  }.m-dropdown {
    background: #000;
  }.m-dropdown {
    background: #141618;
  }.m-dropdown {
    background: rgba(20, 22, 24, 0.9);
  }.m-dropdown {
    color: rgba(255, 255, 255, 0.7);
  }

m-item:
.m-item {
    position: relative;
    display: inline-block;
    height: 100%;
    margin: 0 0 0 20px;
  }.m-item {
    display: block;
    width: 100%;
    margin: 0 0 12px;
  }

header-menu-wrapper:
.header-menu-wrapper {
  display: inline-block;
  font-size: 14px;
}.header-menu-wrapper {
    position: fixed;
    top: 0;
    right: 0;
    -webkit-transform: translateX(100%);
    transform: translateX(100%);
    z-index: 992;
    background: #fff;
    width: 300px;
    height: 100%;
    -webkit-box-shadow: 0 0 40px 0 rgba(24, 27, 30, 0.14);
    box-shadow: 0 0 40px 0 rgba(24, 27, 30, 0.14);
    padding: 70px 30px 30px;
    -webkit-transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
    transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
  }

button-circle-sm:
.button-circle-sm {
  width: 40px;
  height: 40px;
  line-height: 40px;
}

m-subdropdown-link:
.m-subdropdown-link {
    display: block;
    border-radius: 0.375em;
    padding: 8px 15px;
  }

m-dropdown-item:
.m-dropdown-item {
    position: relative;
    display: block;
    margin: 0;
    padding: 0 15px;
  }.m-dropdown-item {
    margin: 0 0 8px;
  }

progress:
.progress {
  overflow: visible;
  background: rgba(20, 22, 24, 0.2);
  margin: 0;
  padding: 0;
}.progress {
  background: rgba(255, 255, 255, 0.3);
}

line-height-140:
.line-height-140 {
  line-height: 1.4;
}

list-inline:
.list-inline {
  margin-right: -7px;
  margin-left: -7px;
}.list-inline {
    margin-right: -6px;
    margin-left: -6px;
  }.list-inline {
  margin-right: -12px;
  margin-left: -12px;
}

display-4:
.display-4 {
  font-size: 3.5em;
}.display-4 {
    font-size: 3em;
  }.display-4 {
    font-size: 3em;
  }

button-circle:
.button-circle {
  background: #e6e6e6;
  display: inline-block;
  border-radius: 50%;
  color: #141618;
  text-align: center;
  -webkit-transition: ease-out 0.14s;
  transition: ease-out 0.14s;
}

padding-top-0:
.padding-top-0 {
  padding-top: 0;
}

padding-lg-70:
.padding-lg-70 {
    padding: 70px;
  }

m-dropdown-link:
.m-dropdown-link {
    display: block;
    border-radius: 0.375em;
    padding: 8px 15px;
  }

section-2xl:
.section-2xl {
  padding: 240px 0;
}.section-2xl {
    padding: 180px 0;
  }.section-2xl {
    padding: 160px 0;
  }

bg-image:
.bg-image {
  position: relative;
  background-position: center center;
  background-attachment: scroll;
  -webkit-background-size: cover;
  -moz-background-size: cover;
  background-size: cover;
  background-repeat: no-repeat;
}.bg-image {
  padding: 0;
}

m-link:
.m-link {
  font-family: "Poppins", sans-serif;
  letter-spacing: -0.2px;
}.m-link {
  font-size: 13px;
  font-weight: 400;
  letter-spacing: 1px;
  text-transform: uppercase;
}.m-link {
    color: rgba(255, 255, 255, 0.7);
  }.m-link {
    color: rgba(255, 255, 255, 0.7);
  }.m-link {
    display: inline-block;
    line-height: 80px;
  }.m-link {
    line-height: 100px;
  }.m-link {
    line-height: 120px;
  }

row:
.row {
  margin-bottom: -30px;
}.row {
  margin-right: -15px;
  margin-bottom: -30px;
  margin-left: -15px;
}.row {
  min-width: 100%;
}

section-xl:
.section-xl {
  padding: 200px 0;
}.section-xl {
    padding: 160px 0;
  }.section-xl {
    padding: 140px 0;
  }

close-button:
.close-button {
  position: fixed;
  top: 10px;
  right: 10px;
  display: inline-block;
  visibility: hidden;
  opacity: 0.8;
  background: #eff2f5;
  width: 50px;
  height: 50px;
  border-radius: 50%;
  -webkit-transition: linear 0.1s;
  transition: linear 0.1s;
}.close-button {
    visibility: visible;
  }

header-menu:
.header-menu {
  display: inline-block;
  margin: 0;
  padding: 0;
  list-style-type: none;
  margin: 0;
  padding: 0;
}.header-menu {
    height: 100%;
  }.header-menu {
    overflow-y: auto;
    width: 100%;
    max-height: 400px;
  }



m-subdropdown:
.m-subdropdown {
    position: absolute;
    top: -15px;
    left: 244px;
    visibility: hidden;
    opacity: 0;
    background: #fff;
    width: 240px;
    -webkit-box-shadow: 0 6px 38px -4px rgba(24, 27, 30, 0.14);
    box-shadow: 0 6px 38px -4px rgba(24, 27, 30, 0.14);
    border-radius: 0.375em;
    padding: 15px;
    -webkit-transition: linear 0.06s;
    transition: linear 0.06s;
  }.m-subdropdown {
    visibility: visible;
    opacity: 1;
  }.m-subdropdown {
    right: 244px;
    left: auto;
  }.m-subdropdown {
    right: 244px;
    left: auto;
  }.m-subdropdown {
    display: none;
    padding-top: 8px;
    padding-left: 16px;
  }.m-subdropdown {
    background: rgba(255, 255, 255, 0.9);
  }.m-subdropdown {
    background: #000;
  }.m-subdropdown {
    background: #141618;
  }.m-subdropdown {
    background: rgba(20, 22, 24, 0.9);
  }

col-spacing-40:
.col-spacing-40 {
    margin-right: -20px;
    margin-bottom: -40px;
    margin-left: -20px;
  }.col-spacing-40 {
    margin-right: -10px;
    margin-left: -10px;
  }

progress-bar:
.progress-bar {
  height: 3px;
  box-shadow: none;
  border-radius: 10px;
}.progress-bar {
  overflow: visible;
  position: relative;
  background: rgba(20, 22, 24, 0.9);
  width: 30%;
  border: none;
  color: rgba(20, 22, 24, 0.9);
}.progress-bar {
  background: #fff;
  color: #fff;
}

button-circle-black:
.button-circle-black {
  background: #000;
  color: rgba(255, 255, 255, 0.8);
}

padding-40:
.padding-40 {
  padding: 40px;
}

progress-box:
.progress-box {
  margin-bottom: 16px;
}

col-spacing-50:
.col-spacing-50 {
    margin-right: -25px;
    margin-bottom: -50px;
    margin-left: -25px;
  }.col-spacing-50 {
    margin-right: -5px;
    margin-left: -5px;
  }

button-circle-dark:
.button-circle-dark {
  background: var(--primary); 
  color: rgba(255, 255, 255, 0.8);
}

m-subdropdown-item:
.m-subdropdown-item {
    display: block;
    margin: 0;
  }

header:
.header {
  top: 0;
  z-index: 990;
  overflow: visible;
  background: #fff;
  width: 100%;
  height: 80px;
  -webkit-transition: ease-in-out 0.2s;
  transition: ease-in-out 0.2s;
}.header {
    height: 70px;
  }

margin-0:
.margin-0 {
  margin: 0;
}

m-toggle:
.m-toggle {
  position: relative;
  display: inline-block;
  width: 28px;
  height: 28px;
}.m-toggle {
    display: none;
  }

bg-dark-05:
.bg-dark-05 {
  background: rgba(20, 22, 24, 0.5);
}

wrapper:
.wrapper {
  position: relative;
  z-index: 1;
  width: auto;
  min-height: 100%;
}

padding-md-60:
.padding-md-60 {
    padding: 60px;
  }

button-circle-animation-drop:
.button-circle-animation-drop {
  position: relative;
}

letter-spacing-2:
.letter-spacing-2 {
  letter-spacing: 2px;
}

header-menu-extra:
.header-menu-extra {
    margin-left: 30px;
  }.header-menu-extra {
    display: inline-block;
  }.header-menu-extra {
    position: absolute;
    right: 30px;
    bottom: 30px;
    left: 30px;
  }

</style>
<div class="wrapper">

<!--dust particel-->
<ul class="circles"> <li></li> <li></li> <li></li> <li></li> <li></li> <li></li> <li></li> <li></li> <li></li> <li></li> 
            </ul>

			

			<!-- Hero section -->
			<div class="section-2xl bg-image parallax-bg" data-bg-src="dist/img/imagen1.png" style="background-image: url(dist/img/imagen1.png);background-size: cover;background-repeat: no-repeat;background-attachment: fixed;background-size: 55%;background-position: left 0px;">
				<div class="bg-dark-05">
                <div class="container text-lg-right" style="padding: 220px 30px;">
                <div class="row align-items-center">
						<div class="col-12 col-lg-9 order-lg-2 text-lg-right">
							<h1 class="display-4 font-weight-bold line-height-140 margin-0">Bienvenidos a ReconoSER<br>
                            <p style="font-size:20px;">Un espacio donde el reconocimiento impulsa el crecimiento.</p></h1>
                            

                                <!--login-->
                            @if (Route::has('login'))
                                @auth
                                    <a class="button-circle button-circle-2xl button-circle-dark button-circle-animation-drop lightbox-media-link"  href="{{ url('/dashboard') }}"><b>Volver</b></a>
                                @else
                                <a class="button-circle button-circle-2xl button-circle-dark button-circle-animation-drop lightbox-media-link" href="{{url('/reg') }}" @if (Request::is('reg')) style="display:none;"  @endif><i class="bi bi-arrow-right-square-fill iconfont" style="color:white;"></i> Ingresar</a>
                                @endauth
                                @endif
						</div>
						<div  class="col-12 col-lg-3 order-lg-1">
							
						</div>
					</div><!-- end row -->
					</div><!-- end container -->
				</div>
			</div>
			<!-- end Hero section -->

            <!-- Services section -->
			<div class="section-xl padding-top-0 fondologin text-ligth" style="color: #fff;">
				<div class="container text-center">
					<div class="margin-bottom-50 text-center">
                    <h2 class="mb-3 text-light">Beneficios de Usar ReconoSER</h2>
					</div>
					<div class="row">
						<div class="col-12 col-lg-3" data-sal="fade" data-sal-delay="100">
							<div class="f-box style-1">
								<div class="f-box-icon">
									<i class="bi bi-lightning-charge-fill"></i>
								</div>
								<h5 class="text-light font-weight-normal">Motivación en Tiempo Real</h5>
								<p>Recibe reconocimiento de tus compañeros en el momento justo.</p>
							</div>
						</div>
						
						<div class="col-12 col-lg-3" data-sal="fade" data-sal-delay="500">
							<div class="f-box style-1">
								<div class="f-box-icon">
									<i class="bi bi-bar-chart-line-fill"></i>
								</div>
								<h5 class="text-light font-weight-normal">Crecimiento Profesional</h5>
								<p>Identifica tus fortalezas y áreas de mejora con cada reconocimiento.</p>
							</div>
						</div>
                        <div class="col-12 col-lg-3" data-sal="fade" data-sal-delay="500">
							<div class="f-box style-1">
								<div class="f-box-icon">
									<i class="bi bi-gift-fill"></i>
								</div>
								<h5 class="text-light font-weight-normal">Recompensas por tu Esfuerzo</h5>
								<p>Acumula puntos y canjéalos por increíbles beneficios.</p>
							</div>
						</div>
                        <div class="col-12 col-lg-3" data-sal="fade" data-sal-delay="300">
							<div class="f-box style-1">
								<div class="f-box-icon">
									<i class="bi bi-people-fill"></i>
								</div>
								<h5 class="text-light font-weight-normal">Mayor Sentido de Pertenencia</h5>
								<p>Fomenta una cultura positiva donde todos suman y crecen.</p>
							</div>
						</div>
					</div><!-- end row -->
				</div><!-- end container -->
			</div>
			<!-- end Services section -->

			
			<!-- Portfolio section -->
			<div class="section-xl padding-top-0">
				<div class="container">
					<div class="row align-items-center col-spacing-50">
						<div class="col-12 col-lg-4">
							<h1 class="font-weight-bold ">Reconocer a <br>tus compañeros</h1>
							<p>Agradece, felicita y motiva en un solo clic. Haz que cada reconocimiento cuente.</p>
                            <!--login-->
                            @if (Route::has('login'))
                                @auth
                                    <a class="btn btn-secondary btningresar "  href="{{ url('/dashboard') }}"><b>  Volver  </b></a>
                                @else
                                <a class="btn btn-secondary btningresar " href="{{url('/reg') }}" @if (Request::is('reg')) style="display:none;"  @endif><i class="bi bi-arrow-right-square-fill iconfont" style="color:white;"></i>  Ingresar</a>
                                @endauth
                                @endif 
						</div>
						<div class="col-12 col-lg-8">
							<div class="owl-carousel owl-nav-overlap-left hover-style-3" data-owl-items="1" data-owl-dots="false" data-owl-nav="true">
								<!-- 1 -->
								<div class="portfolio-item">
									<a href="#">
										<div class="portfolio-img">
                                        <img src="dist/img/reconocer-pc.png" alt="" class="w-100">
										</div>
									</a>
								</div>
							</div><!-- end owl-carousel -->
						</div>
					</div><!-- end row -->
				</div><!-- end container -->
			</div>
			<!-- end Portfolio section -->

            <!-- Portfolio section -->
			<div class="section-xl padding-top-0 fondologin">
				<div class="container">
					<div class="row align-items-center col-spacing-50">
						
						<div class="col-12 col-lg-8">
							<div class="owl-carousel owl-nav-overlap-left hover-style-3" data-owl-items="1" data-owl-dots="false" data-owl-nav="true">
								<!-- 1 -->
								<div class="portfolio-item">
									<a href="#">
										<div class="portfolio-img">
                                        <img src="dist/img/reconocer-pc2.png" alt="" class="w-100">
										</div>
									</a>
								</div>
							</div><!-- end owl-carousel -->
						</div>
                        <div class="col-12 col-lg-4">
							<h1 class="font-weight-bold">Gana insignias<br> y recompensas</h1>
							<p>Acumula puntos y desbloquea logros que te ayudarán a seguir creciendo.</p>
                            <!--login-->
                            @if (Route::has('login'))
                                @auth
                                    <a class="btn btn-secondary btningresar "  href="{{ url('/dashboard') }}"><b>  Volver  </b></a>
                                @else
                                <a class="btn btn-secondary btningresar " href="{{url('/reg') }}" @if (Request::is('reg')) style="display:none;"  @endif><i class="bi bi-arrow-right-square-fill iconfont" style="color:white;"></i>  Ingresar</a>
                                @endauth
                                @endif 
						</div>
					</div><!-- end row -->
				</div><!-- end container -->
			</div>
			<!-- end Portfolio section -->

            <!-- Portfolio section -->
			<div class="section-xl padding-top-0">
				<div class="container">
					<div class="row align-items-center col-spacing-50">
						<div class="col-12 col-lg-4">
							<h1 class="font-weight-bold">Ver tu evolución</h1>
							<p>Descubre en qué categoría destacas y cómo puedes mejorar. ¡Haz de cada reconocimiento una oportunidad!</p>
                            <!--login-->
                            @if (Route::has('login'))
                                @auth
                                    <a class="btn btn-secondary btningresar "  href="{{ url('/dashboard') }}"><b>  Volver  </b></a>
                                @else
                                <a class="btn btn-secondary btningresar " href="{{url('/reg') }}" @if (Request::is('reg')) style="display:none;"  @endif><i class="bi bi-arrow-right-square-fill iconfont" style="color:white;"></i>  Ingresar</a>
                                @endauth
                                @endif 
                        </div>
						<div class="col-12 col-lg-8">
							<div class="owl-carousel owl-nav-overlap-left hover-style-3" data-owl-items="1" data-owl-dots="false" data-owl-nav="true">
								<!-- 1 -->
								<div class="portfolio-item">
									<a href="#">
										<div class="portfolio-img">
                                        <img src="dist/img/reconocer-pc1.png" alt="" class="w-100">
										</div>
									</a>
								</div>
							</div><!-- end owl-carousel -->
						</div>
					</div><!-- end row -->
				</div><!-- end container -->
			</div>
			<!-- end Portfolio section -->

            
    <div class="parallax fondologin" >
    Empieza Hoy Mismo<br>
    <p style="font-size:15px;">Cada acción cuenta. Reconoce, crece y motiva.</p>
    <!--login-->
    @if (Route::has('login'))
    @auth
        <a class="btn btn-secondary btningresar "  href="{{ url('/dashboard') }}"><b>  Volver  </b></a>
    @else
    <a class="btn btn-secondary btningresar " href="{{url('/reg') }}" @if (Request::is('reg')) style="display:none;"  @endif><i class="bi bi-arrow-right-square-fill iconfont" style="color:white;"></i>  Ingresar</a>
    @endauth
    @endif 
    </div>

@endsection