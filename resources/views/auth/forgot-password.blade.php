
@extends('principal')
@section('content')
<br>
<div style="background-image: url('dist/img/fondolog.jpg');  background-position: center; background-repeat: no-repeat;  background-size: cover; position: relative; height:auto; ">
<br>
<main role="main" class="container my-auto letrap">
            <div class="row">
                <div id="login" class=" offset-lg-4 col-md-6 offset-md-3 col-12" style="background-color:rgba(241,241,241,0.8); padding-top:5px; border-radius:20px;">
                  <br>  
                  <div class="mb-4 text-sm text-gray-600">
                        {{ __('¿Olvidaste tu contraseña? No hay problema. Simplemente ingrese su correo electrónico y le enviaremos un enlace de restablecimiento de contraseña.') }}
                    </div>
                <!--<h2 class="text-center">Bienvenido de nuevo</h2>-->
                        <!---errores-->
                           <!-- Session Status -->
                         <x-auth-session-status class="mb-4" :status="session('status')" />

                        <!-- Validation Errors -->
                        <x-auth-validation-errors class="mb-4" :errors="$errors" />
                        <!--end -->
                        <form method="POST" action="{{ route('password.email') }}">
                          @csrf
                        <div class="form-group">
                            <label for="correo">Correo</label>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1"><i class="bi bi-envelope"></i></span>
                                </div>
                                <input class="form-control" id="email" type="email" name="email" :value="old('email')" required autofocus>  
                            </div>
                        </div>
                        <button type="submit" class="btn float-right" style="background-color:#15AFBA; color:white;">
                         &nbsp;Enviar
                        </button>
                        <br>
                    </form>
                    <br>
                </div>
            </div>
        </main>
        <br></div>
        <br>
@endsection