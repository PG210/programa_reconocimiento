@extends('principal')
@section('content')
<br>
<div style="background-image: url('dist/img/fondolog.jpg');  background-position: center; background-repeat: no-repeat;  background-size: cover; position: relative; height:auto; ">
<br>
<main role="main" class="container my-auto letrap">
            <div class="row">
                <div id="login" class=" offset-lg-4 col-md-6 offset-md-3 col-12" style="background-color:rgba(241,241,241,0.8); padding-top:5px; border-radius:20px;">
                  <br>  
                <!--<h2 class="text-center">Bienvenido de nuevo</h2>-->
                        <!---errores-->
                           <!-- Session Status -->
                            <x-auth-session-status class="mb-4" :status="session('status')" />
                            <!-- Validation Errors -->
                            <x-auth-validation-errors class="mb-4" :errors="$errors" />
                        @if(Session::has('errorInicio'))
                            <div style="background-color:#FFE527;">
                            {{Session::get('errorInicio')}}
                            </div>
                            <br><br>
                        @endif
                        <!--end -->
                        <form method="POST" action="{{ route('login') }}">
                          @csrf
                        <div class="form-group">
                            <label for="correo">Correo</label>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1"><i class="bi bi-envelope"></i></span>
                                </div>
                                <input  id="email" name="email"  class="form-control" type="email" :value="old('email')" required >  
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="palabraSecreta">Contraseña</label>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1"><i class="bi bi-lock-fill"></i></span>
                                </div>
                                <input id="password" name="password" class="form-control" type="password" autocomplete="current-password" required>
                            </div>
                        </div>
                        <div class="form-group">
                           <input id="remember_me" type="checkbox" name="remember">&nbsp;Recordar contraseña
                        </div>
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}">
                            <u> Olvidó su contraseña?</u>
                            </a>
                        @endif
                        <button type="submit" class="btn float-right" style="background-color:#15AFBA; color:white;">
                        <i class="bi bi-arrow-right-square-fill"></i>&nbsp;Entrar
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

