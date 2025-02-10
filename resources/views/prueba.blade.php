@extends('principal')
@section('content')


<div>

<main role="main" class="forms">
            <div class="">
            <h1 class="fw-bold">Hola!</h1>
            <h2 class="fw-bold mb-5">Ingresa a tu cuenta</h2>
                <div id="login" class="centraform">  
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
                        <button type="submit" class="btn btn-warning btningresar btn-block">
                        <i class="bi bi-arrow-right-square-fill"></i>&nbsp;Entrar
                        </button>
                    </form>
                </div>
            </div>
        </main>
        </div>
        
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

