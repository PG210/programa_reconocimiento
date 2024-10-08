@extends('principal')
@section('content')

<br>
<div class="imagenlogin" style="background-image: url('dist/img/fondolog.jpg');  background-position: center; background-repeat: no-repeat;  background-size: cover; position: relative; height:auto; ">
<br>
<main role="main" class="container my-auto letrap forms">
            <div class="row">
                <div id="login" class=" offset-lg-4 col-md-6 offset-md-3 col-12 centraform" style="background-color:rgba(241,241,241,0.8); padding-top:5px; border-radius:20px;">
                  <br>  
                <!--<h2 class="text-center">Bienvenido de nuevo</h2>-->
                        <!---errores-->
                           <!-- Session Status -->
                        <div class="container">
                            <x-auth-session-status class="mb-4" :status="session('status')" />
                            <!-- Validation Errors -->
                            <x-auth-validation-errors class="mb-4" :errors="$errors" />
                        @if(Session::has('errorInicio'))
                            <div  style="background-color:#FFE527;">
                            {{Session::get('errorInicio')}}
                            </div>
                            <br><br>
                        @endif
                        </div>
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
                                <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1">
                                   <a id="togglePassword" type="button" onclick="togglePasswordVisibility()">
                                     <i id="eyeIcon" class="bi bi-eye"></i>
                                   </a>
                                 </span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                           <input id="remember_me" type="checkbox" name="remember">&nbsp;Recordar contraseña
                        </div>

                        @if (Route::has('password.request'))
                           {{--<a href="{{ route('password.request') }}">
                            <u> Olvidó su contraseña?</u>
                            </a>--}}
                        @endif
                        <button type="submit" class="btn float-right boton" style="background-color:#15AFBA; color:white;">
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
<script>
function togglePasswordVisibility() {
    var passwordInput = document.getElementById("password");
    var eyeIcon = document.getElementById("eyeIcon");

    if (passwordInput.type === "password") {
        passwordInput.type = "text";
        eyeIcon.classList.remove("fa-eye");
        eyeIcon.classList.add("fa-eye-slash");
    } else {
        passwordInput.type = "password";
        eyeIcon.classList.remove("fa-eye-slash");
        eyeIcon.classList.add("fa-eye");
    }
}
</script>
@endsection

