@extends('usuario.principa_usul')
@section('content')

<!-- Content Header (Page header) -->
<div class="content-header">
 <div class="container"> 
  <div class="row mb-2">
   <div class="col-sm-8"> 
    <h1 class="m-0">Comunicación</h1>
   </div>
   <!-- /.col -->
   <div class="col-sm-4">
    <ol class="breadcrumb float-sm-right">
     <li class="breadcrumb-item"><a href="#">Inicio</a></li>
     <li class="breadcrumb-item active">Comunicación</li>
    </ol>
   </div>
   <!-- /.col -->
  </div>
  <!-- /.row -->
 </div>
 <!-- /.container-fluid -->
</div>
<!-- /.content-header -->
 
<!-- Mostrar mensajes de éxito -->
@if(session('success'))
<div class="alert alert-warning alert-dismissible fade show mt-3 letraform" role="alert">
   {{ session('success') }}
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
     <span aria-hidden="true">&times;</span>
  </button>
</div>
@endif

<div class="container">
<div class="row mb-2">
  <div class="col-12">
  <div class="card card-primary card-outline">
  <div class="card-body box-profile">
  <div class="row">
    <div class="col-lg-6">
      <p>1. Sube las imagenes para el banner en la pantalla de bienvenida:</p>
    <!---form -->
    @if(empty($imagen1))
    <form action="{{route('comunicacion.store')}}" class="needs-validation" method="POST"  enctype="multipart/form-data" novalidate>
    @csrf
    <div class=" card card-body"><div class="form-row">
        <div class="col-md-12 mb-3">
            <label for="validationCustom01">Imagen 1 (Dimensión 700 x 175px)</label>
            <input type="file" class="form-control" id="validationCustom01" name="imgone" accept="image/*" required>
        </div>
        <div class="col-md-11 mb-3">
          <label for="validationCustom02">Descripción: </label>
          <!---radiobutons -->
          <div class="custom-control custom-radio custom-control-inline">
            <input type="radio" id="radio1" name="customRadioInline" class="custom-control-input" onclick="toggleRequired(true, '2')">
            <label class="custom-control-label" for="radio1">Si</label>
          </div>
          <div class="custom-control custom-radio custom-control-inline">
          <input type="radio" id="radio2" name="customRadioInline" class="custom-control-input" onclick="toggleRequired(false, '2')">
            <label class="custom-control-label" for="radio2">No</label>
          </div>
          <!--- end radiobutons-->
          <textarea type="text" class="form-control" id="validationCustom02" name="desone"  required></textarea>
          <input type="number" name="posicion" value="1" hidden>
        </div>
        <div class="col-md-1 mt-5">
            <button type="submit" class="btn btn-info btn-sm" ><i class="fas fa-upload"></i></button>
        </div>
        <hr>
    </div></div>
  </form>
  @else
  <!--- aqui imprimir la imagen 01 -->
  <div class="card card-body"><div class="row">
    <div class="col-lg-11">
      <label for="validationCustom01">Imagen 1 (Dimensión 700 x 175px)</label><br>
      <img src="{{ asset('dist/carrucel/' . $imagen1->imagen) }}" class="img-thumbnail" alt="...">
    </div>
    <div class="col-lg-1 mt-5">
    <!---modal para confirmacion-->
      <button type="button" class="btn btn-outline-danger btn-sm" data-toggle="modal" data-target="#eliminarImagenes{{ $imagen1->id }}">
        <i class="fas fa-trash-alt"></i>
      </button>
      <div class="modal fade" id="eliminarImagenes{{ $imagen1->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">Mensaje de confirmación</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body text-left">
                <p>
                ¿Estás seguro de que deseas eliminar esta imagen?
                </p>
                </div>
                <div class="modal-footer justify-content-between">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                  <form action="{{ route('comunicacion.destroy', $imagen1->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-success">Eliminar</button>
                  </form>
                </div>
              </div>
          </div>
      </div>
      <!--end modal confirmacion-->
    </div>
    <div class="col-lg-11">
      @if($imagen1->descrip)
       <label for="validationCustom02">Descripción</label>
      <p style="color: {{ $imagen1->colorletra ?? '#000000' }};">{{$imagen1->descrip}}</p>
      <!--cambiar el color de letra -->
      <form action="{{ route('comunicacion.update', $imagen1->id) }}" method="POST">
         @csrf
         @method('PUT')
        <div class="row">
            <div class="col-lg-6">
              <label class="text-sm" for="validationCustom02">Color de letra</label>
              <input  type="color" id="colorletra" name="colorletra" value="{{ $imagen1->colorletra ?? '#000000' }}">
            </div>
            <div class="col-lg-4">
              <label class="text-sm" for="validationCustom02">Fondo</label>
              <input  type="color" id="colorfondo" name="colorfondo" value="{{ $imagen1->colorfondo ?? 'transparent' }}">
              <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" id="check01" name="checkfondo" value="1">
                <label class="form-check-label text-sm" for="check01">Quitar</label>
              </div>
            </div>
            <div class="col-lg-2 mt-4">
              <button type="submit" class="btn btn-info btn-sm">Aplicar</button>
            </div>
        </div>    
      </form>
      <!---end color letra-->
      @endif
    </div>
    </div>
  </div>
  <hr>
  @endif
  <!---formulario dos--->
  @if(empty($imagen2))
  <form action="{{route('comunicacion.store')}}" class="needs-validation" method="POST" enctype="multipart/form-data" novalidate>
  @csrf
  <div class="card card-body"><div class="form-row">
      <div class="col-md-12 mb-3">
        <label for="validationCustom03">Imagen 2 (Dimensión 700 x 175px)</label>
        <input type="file" class="form-control" id="validationCustom03" name="imgone" accept="image/*" required @if(!empty($imagen2)) disabled @endif>
      </div>
      <div class="col-md-11 mb-3">
           <label for="validationCustom04">Descripción:</label>
            <!---radiobutons -->
          <div class="custom-control custom-radio custom-control-inline">
            <input type="radio" id="radio3" name="customRadioInline" class="custom-control-input" onclick="toggleRequired(true, '4')">
            <label class="custom-control-label" for="radio3">Si</label>
          </div>
          <div class="custom-control custom-radio custom-control-inline">
          <input type="radio" id="radio4" name="customRadioInline" class="custom-control-input" onclick="toggleRequired(false, '4')">
            <label class="custom-control-label" for="radio4">No</label>
          </div>
          <!--- end radiobutons-->
           <textarea class="form-control" id="validationCustom04" name="desone" required @if(!empty($imagen2)) disabled @endif></textarea>
           <input type="number" name="posicion" value="2" hidden>
       </div>
      <div class="col-md-1 mt-5">
          <button type="submit" class="btn btn-info btn-sm" @if(!empty($imagen2)) disabled @endif><i class="fas fa-upload"></i></button>
      </div> 
     </div> </div>
  </form>
  <!--- aqui imprimir la imagen 01 -->
  @else
  <div class="card card-body"><div class="row">
    <div class="col-lg-11">
    <label for="validationCustom01">Imagen 2 (Dimensión 700 x 175px)</label><br>
    <img src="{{ asset('dist/carrucel/' . $imagen2->imagen) }}" class="img-thumbnail" alt="...">
    </div>
    <div class="col-lg-1 mt-5">
      <!---modal para confirmacion-->
      <button type="button" class="btn btn-outline-danger btn-sm" data-toggle="modal" data-target="#eliminarImagen{{ $imagen2->id }}">
        <i class="fas fa-trash-alt"></i>
      </button>
      <div class="modal fade" id="eliminarImagen{{ $imagen2->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">Mensaje de confirmación</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body text-left">
                <p>
                ¿Estás seguro de que deseas eliminar esta imagen?
                </p>
                </div>
                <div class="modal-footer justify-content-between">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                  <form action="{{ route('comunicacion.destroy', $imagen2->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-success">Eliminar</button>
                  </form>
                </div>
              </div>
          </div>
      </div>
      <!--end modal confirmacion-->
    </div>
    <div class="col-lg-12">
    @if($imagen2->descrip)
        <label for="validationCustom02">Descripción</label>
        <p style="color: {{ $imagen2->colorletra ?? '#000000' }};">{{$imagen2->descrip}}</p>
         <!--cambiar el color de letra -->
         <form action="{{ route('comunicacion.update', $imagen2->id) }}" method="POST">
          @csrf
          @method('PUT')
          <div class="row">
              <div class="col-lg-6">
                <label class="text-sm" for="validationCustom02">Color de letra</label>
                <input  type="color" id="colorletra" name="colorletra" value="{{ $imagen2->colorletra ?? '#000000' }}">
              </div>
              <div class="col-lg-4">
                <label class="text-sm" for="validationCustom02">Fondo</label>
                <input  type="color" id="colorfondo" name="colorfondo" value="{{ $imagen2->colorfondo ?? 'transparent' }}">
                <div class="form-check form-check-inline">
                  <input class="form-check-input" type="checkbox" id="check01" name="checkfondo" value="1">
                  <label class="form-check-label text-sm" for="check01">Quitar</label>
                </div>
              </div>
              <div class="col-lg-2 mt-4">
                <button type="submit" class="btn btn-info btn-sm">Aplicar</button>
              </div>
          </div>    
        </form>
        @endif
    </div>
    
  </div> </div>
  <hr>
  @endif
    <!--formulario 3-->
  @if(empty($imagen3))
  <form action="{{route('comunicacion.store')}}" class="needs-validation" method="POST"  enctype="multipart/form-data" novalidate>
   @csrf
   <div class="card card-body"><div class="form-row">
        <div class="col-md-12 mb-3">
            <label for="validationCustom05">Imagen 3 (Dimensión 700 x 175px)</label>
            <input type="file" class="form-control" id="validationCustom05" accept="image/*" name="imgone" required @if(!empty($imagen3)) disabled @endif>
        </div>
        <div class="col-md-11 mb-3">
          <label for="validationCustom06">Descripción:</label>
           <!---radiobutons -->
           <div class="custom-control custom-radio custom-control-inline">
            <input type="radio" id="radio5" name="customRadioInline" class="custom-control-input" onclick="toggleRequired(true, '6')">
            <label class="custom-control-label" for="radio5">Si</label>
          </div>
          <div class="custom-control custom-radio custom-control-inline">
          <input type="radio" id="radio6" name="customRadioInline" class="custom-control-input" onclick="toggleRequired(false, '6')">
            <label class="custom-control-label" for="radio6">No</label>
          </div>
          <!--- end radiobutons-->
          <textarea type="text" class="form-control" id="validationCustom06" name="desone" required @if(!empty($imagen3)) disabled @endif></textarea>
          <input type="number" name="posicion" value="3" hidden>
        </div>
        <div class="col-md-1 mt-5">
          <button type="submit" class="btn btn-info btn-sm"  @if(!empty($imagen3)) disabled @endif><i class="fas fa-upload"></i></button>
        </div>
    </div></div>
  </form>
  @else
  <!--- aqui imprimir la imagen 03 -->
  <div class="card card-body"><div class="row">
    <div class="col-lg-11">
    <label for="validationCustom01">Imagen 3 (Dimensión 700 x 175px)</label><br>
    <img src="{{ asset('dist/carrucel/' . $imagen3->imagen) }}" class="img-thumbnail" alt="..." >
    </div>
    <div class="col-lg-1 mt-5">
      <!---modal para confirmacion-->
      <button type="button" class="btn btn-outline-danger btn-sm" data-toggle="modal" data-target="#eliminarIma{{ $imagen3->id }}">
        <i class="fas fa-trash-alt"></i>
      </button>
      <div class="modal fade" id="eliminarIma{{ $imagen3->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">Mensaje de confirmación</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body text-left">
                <p>
                ¿Estás seguro de que deseas eliminar esta imagen?
                </p>
                </div>
                <div class="modal-footer justify-content-between">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                  <form action="{{ route('comunicacion.destroy', $imagen3->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-success">Eliminar</button>
                  </form>
                </div>
              </div>
          </div>
      </div>
      <!--end modal confirmacion-->
    </div>
    <div class="col-lg-12">
    @if($imagen3->descrip)
       <label for="validationCustom02">Descripción</label>
       <p style="color: {{ $imagen3->colorletra ?? '#000000' }};">{{$imagen3->descrip}}</p>
        <!--cambiar el color de letra -->
        <form action="{{ route('comunicacion.update', $imagen3->id) }}" method="POST">
          @csrf
          @method('PUT')
          <div class="row">
              <div class="col-lg-6">
                <label class="text-sm" for="validationCustom02">Color de letra</label>
                <input  type="color" id="colorletra" name="colorletra" value="{{ $imagen3->colorletra ?? '#000000' }}">
              </div>
              <div class="col-lg-4">
                <label class="text-sm" for="validationCustom02">Fondo</label>
                <input  type="color" id="colorfondo" name="colorfondo" value="{{ $imagen3->colorfondo ?? 'transparent' }}">
                <div class="form-check form-check-inline">
                  <input class="form-check-input" type="checkbox" id="check01" name="checkfondo" value="1">
                  <label class="form-check-label text-sm" for="check01">Quitar</label>
                </div>
              </div>
              <div class="col-lg-2 mt-4">
                <button type="submit" class="btn btn-info btn-sm">Aplicar</button>
              </div>
          </div>    
        </form>
        @endif
    </div>
    
  </div></div>
  <hr>
  @endif
  <!---formulario 4-->
  @if(empty($imagen4))
  <form action="{{route('comunicacion.store')}}" class="needs-validation" method="POST" enctype="multipart/form-data" novalidate>
   @csrf
   <div class="card card-body"><div class="form-row">
        <div class="col-md-12 mb-3">
            <label for="validationCustom07">Imagen 4 (Dimensión 700 x 175px)</label>
            <input type="file" class="form-control" id="validationCustom07" accept="image/*" name="imgone" required @if(!empty($imagen4)) disabled @endif>
        </div>
        <div class="col-md-11 mb-3">
          <label for="validationCustom08">Descripción:</label>
           <!---radiobutons -->
           <div class="custom-control custom-radio custom-control-inline">
            <input type="radio" id="radio7" name="customRadioInline" class="custom-control-input" onclick="toggleRequired(true, '8')">
            <label class="custom-control-label" for="radio7">Si</label>
          </div>
          <div class="custom-control custom-radio custom-control-inline">
          <input type="radio" id="radio8" name="customRadioInline" class="custom-control-input" onclick="toggleRequired(false, '8')">
            <label class="custom-control-label" for="radio8">No</label>
          </div>
          <!--- end radiobutons-->
          <textarea type="text" class="form-control" id="validationCustom08" name="desone" required @if(!empty($imagen4)) disabled @endif></textarea>
          <input type="number" name="posicion" value="4" hidden>
        </div>
       <div class="col-md-1 mt-5">
         <button type="submit" class="btn btn-info btn-sm"  @if(!empty($imagen4)) disabled @endif><i class="fas fa-upload"></i></button>
       </div>
       </div></div>
    </form>
  @else
  <div class="card card-body"><div class="row">
    <div class="col-lg-11">
      <label for="validationCustom01">Imagen 4 (Dimensión 700 x 175px)</label><br>
      <img src="{{ asset('dist/carrucel/' . $imagen4->imagen) }}" class="img-thumbnail" alt="...">
    </div>
    <div class="col-lg-1 mt-5">
       <!---modal para confirmacion-->
       <button type="button" class="btn btn-outline-danger btn-sm" data-toggle="modal" data-target="#eliminarImag{{ $imagen4->id }}">
        <i class="fas fa-trash-alt"></i>
      </button>
      <div class="modal fade" id="eliminarImag{{ $imagen4->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">Mensaje de confirmación</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body text-left">
                <p>
                ¿Estás seguro de que deseas eliminar esta imagen?
                </p>
                </div>
                <div class="modal-footer justify-content-between">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                  <form action="{{ route('comunicacion.destroy', $imagen4->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-success">Eliminar</button>
                  </form>
                </div>
              </div>
          </div>
      </div>
      <!--end modal confirmacion-->
    </div>
    <div class="col-lg-12">
    @if($imagen4->descrip)
      <label for="validationCustom02">Descripción</label>
      <p style="color: {{ $imagen4->colorletra ?? '#000000' }};">{{$imagen4->descrip}}</p>
       <!--cambiar el color de letra -->
        <form action="{{ route('comunicacion.update', $imagen4->id) }}" method="POST">
          @csrf
          @method('PUT')
          <div class="row">
              <div class="col-lg-6">
                <label class="text-sm" for="validationCustom02">Color de letra</label>
                <input  type="color" id="colorletra" name="colorletra" value="{{ $imagen4->colorletra ?? '#000000' }}">
              </div>
              <div class="col-lg-4">
                <label class="text-sm" for="validationCustom02">Fondo</label>
                <input  type="color" id="colorfondo" name="colorfondo" value="{{ $imagen4->colorfondo ?? 'transparent' }}">
                <div class="form-check form-check-inline">
                  <input class="form-check-input" type="checkbox" id="check01" name="checkfondo" value="1">
                  <label class="form-check-label text-sm" for="check01">Quitar</label>
                </div>
              </div>
              <div class="col-lg-2 mt-4">
                <button type="submit" class="btn btn-info btn-sm">Aplicar</button>
              </div>
          </div>    
        </form>
        @endif
    </div>
    
  </div></div>
  <hr>
  @endif
   <!--end forms -->
    </div>
    <div class="col-lg-6">
      <p>2. Así se verá tu carrousel:</p>
      <!---carrucel -->
      <div id="carouselExampleCaptions" class="carousel slide" data-ride="carousel">
          <ol class="carousel-indicators">
              @foreach($images as $index => $imgs)
                  <li data-target="#carouselExampleCaptions" data-slide-to="{{ $index }}" class="{{ $index == 0 ? 'active' : '' }}"></li>
              @endforeach
          </ol>
          <div class="carousel-inner carousel-fade">
              @foreach($images as $index => $imgs)
                  <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                      <img src="{{ asset('dist/carrucel/' . $imgs->imagen) }}" class="d-block w-100" alt="...">
                      <div class="carousel-caption d-none d-md-block">
                          <h5 style="color: {{ $imgs->colorletra ?? '#000000' }}; background-color:{{ $imgs->colorfondo ?? 'transparent' }}; border-radius:10px; opacity:0.7;">{{ $imgs->descrip }}</h5>
                      </div>
                  </div>
              @endforeach
          </div>
          <button class="carousel-control-prev" type="button" data-target="#carouselExampleCaptions" data-slide="prev">
              <span class="carousel-control-prev-icon" aria-hidden="true"></span>
              <span class="sr-only">Atras</span>
          </button>
          <button class="carousel-control-next" type="button" data-target="#carouselExampleCaptions" data-slide="next">
              <span class="carousel-control-next-icon" aria-hidden="true"></span>
              <span class="sr-only">Siguiente</span>
          </button>
      </div>
      <!---end carrucel-->

      <div class="container mt-3">
        <p>3. Publicalo cuando este listo:</p>
        @if(!empty($estadoimg->estado))
            @if($estadoimg->estado == '2')
              <a href="{{route('publicar')}}" type="button" class="text-dark w-100 btn btn-warning confirmar"><i class="fas fa-paper-plane"></i>  Publicar </a>
            @else
              <a href="{{route('publicar')}}" type="button" class="text-dark w-100 btn btn-danger"> Retirar </a>
            @endif
        @endif
      </div>
      <!---button -->
    </div>
    </div>
  </div>
 </div>
 </div>
 </div>
 </div>
 <script>
// Example starter JavaScript for disabling form submissions if there are invalid fields
(function() {
  'use strict';
  window.addEventListener('load', function() {
    // Fetch all the forms we want to apply custom Bootstrap validation styles to
    var forms = document.getElementsByClassName('needs-validation');
    // Loop over them and prevent submission
    var validation = Array.prototype.filter.call(forms, function(form) {
      form.addEventListener('submit', function(event) {
        if (form.checkValidity() === false) {
          event.preventDefault();
          event.stopPropagation();
        }
        form.classList.add('was-validated');
      }, false);
    });
  }, false);
})();
</script>
<script>
    function toggleRequired(isRequired, param) {
        const textarea = document.getElementById('validationCustom0' + param);
        if (isRequired) {
            textarea.setAttribute('required', 'required');
        } else {
            textarea.removeAttribute('required');
        }
    }
</script>
@endsection