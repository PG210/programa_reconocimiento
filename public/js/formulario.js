  /*tomamos la información del formulario y la enviamos a la ruta y de la ruta al controlador*/
  $('#formudatos').submit(function(e){
    e.preventDefault();
    //valores de los checkbox
    let usuariosSel = [];
    $('input[name="usuariosSel[]"]:checked').each(function() {
      usuariosSel.push($(this).val());
    });
    let idcat=$('#stl-compor').val();
    let detexto = $('#detexto').val();
    let previewDiv = document.getElementById("preview");
    let nomcat = document.getElementById("nomcate");
    let com = document.getElementById("compor");
    let _token = $('input[name=_token]').val(); //token de seguridad
    
    if(idcat != null && usuariosSel.length != 0){
      $.ajax({
      type: "POST",
      url:"/enviar/recono/categoria",
      
      data:{
        usuariosSel:usuariosSel,
        idcat:idcat,
        detexto:detexto,
        _token:_token
      }, 
      dataType: 'json', //debe agregar para ver el tipo de dato a recibir
        success:function(response){ 
        let dat = response['usuazar'];
        let respuesta = response['respuesta'];
        
        if(!respuesta){
          window.alert('Correo no enviado, por favor notifica al administrador.');
        }
         
        $("#sugerir").empty();
        previewDiv.textContent = ""; //limpiar el div donde aparece el texto
        nomcat.textContent = "";
        com.textContent = "";
        if(dat.length!=0){
          $('#formudatos')[0].reset();
          toastr.success('El envió de reconocimiento fue exitosó', 'Nuevo Reconocimiento', {timeOut:3000});
          //setTimeout(refrescar, 2000);
          for(var i=0; i<dat.length; i++){
            var resul= '<div class="list-group-item list-group-item-action d-flex align-items-center">'+
                  '<img src="http://127.0.0.1:8000/dist/imgperfil/perfil1740561960.jpg" class="profile-user-img img-fluid img-circle" style="width: 80px; height:80px" alt="'+ dat[i].name +'">'+
                  '<p style="width: 80%;">' + dat[i].name + '&nbsp;' + dat[i].apellido + '</p>'+
              '</div>';
              $('#sugerir').append(resul);
            }
          }else{
           
              $("#sugerir").empty();
              $('#formudatos')[0].reset();
              toastr.success('El envió de reconocimiento fue exitosó', 'Nuevo Reconocimiento', {timeOut:3000});

              var er = '<p class="list-group-item list-group-item-action d-flex align-items-center">'+
                            '<p> No hay sugerencias por el momento!</p>'+
                        '</p>';
                      $('#sugerir').append(er);

          }
          //mostar el modal 
          setTimeout(function() {
              $('#modalSugerencia').modal('show'); // Abre el modal después de 3 segundos
          }, 1000); // 3000 milisegundos = 3 segundos
      }
    }).fail(function(jqXHR, response){
          $("#sugerir").empty();
          $('#formudatos')[0].reset();
          toastr.success('El envió de reconocimiento fue exitosó', 'Nuevo Reconocimiento', {timeOut:3000});

	        var er = '<div class="alert alert-warning alert-dismissible fade show" role="alert">'+
                    '<strong><i class="fas fa-laugh-beam fa-2x" style="color:#FCFF24;"></i> &nbsp;No hay sugerencias!'+
                      '<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</strong>'+
                      '<button type="button" class="close" data-dismiss="alert" aria-label="Close">'+
                      '<span aria-hidden="true">&times;</span>'+
                    '</button>'+
                  '</div>';
          $('#sugerir').append(er);
        });
    }else{
      toastr.error('Elige una categoria, comportamiento y colaboradores.', 'Datos vacios!', {timeOut:3000});
      
    }
  });
 
  /*Resetear el formulario  */
  function resetform() {
    $("form select").each(function() { this.selectedIndex = 0 });
    $("form input[type=text],form input[type=number]").each(function() { this.value = '' });
 }

/*Peticion para encontrar categoria */
/*tomamos la información del formulario y la enviamos a la ruta y de la ruta al controlador*/
$(document).ready(function() {
    $('.btn-filtrar').on('click', function(e) {
        e.preventDefault(); // Evita el comportamiento predeterminado del enlace
        
        var idcate = $(this).data('id'); // Obtiene el ID desde el botón
        var _token = $('input[name=_token]').val(); // Token de seguridad
        var cursos = $("#slt-cursos");

        $.ajax({
            type: "POST",
            url: "/filtrar/categoria/comportamiento",
            data: {
                idcate: idcate,
                _token: _token
            }
        }).done(function(res) {
            cursos.find('option').remove(); // Elimina opciones previas
            let arreglo = JSON.parse(res);
            arreglo.unshift({id: 0, nombre: 'Elegir ...'}); // Agrega "Elegir ..." al inicio
            
            for (var x = 0; x < arreglo.length; x++) {
                let t = '<option value="' + arreglo[x].id + '">' + arreglo[x].nombre + '</option>';
                cursos.append(t);
            }
        });
    });
});
  /* peticion para encontrar departamentos */
  /*tomamos la información del formulario y la enviamos a la ruta y de la ruta al controlador*/
  $(document).ready(function () {
    $('#slt-cursos').on('change', function () { 
        let compor = $("#stl-compor"); // Select para comportamientos
        let imagen = $('.imagen'); // Contenedor para la imagen
        let imagen2 = $('.imagen2'); // Contenedor para la imagen
        let idcom = $(this).val(); // Valor seleccionado del curso
        let _token = $('input[name=_token]').val(); // CSRF Token de Laravel

        if (idcom === "") {
            compor.empty().append('<option value="">Seleccione un comportamiento</option>');
            return;
        }

        $.ajax({
            type: "POST",
            url: "/filtrar/comportamiento",
            data: {
                idcom: idcom,
                _token: _token
            }
        }).done(function (res) {
            try {
                let arreglo = JSON.parse(res);
                compor.empty(); // Limpiar el select antes de agregar nuevas opciones
                imagen.empty(); // Evitar duplicaciones de imágenes
                imagen2.empty(); //limpiar la imagen de visualizar reconocimiento
                if (arreglo.length > 0) {
                    for (let x = 0; x < arreglo.length; x++) {
                        $('.nomcate').text(arreglo[x].descripcion); // Nombre de la categoría
                        $('.compor').text(arreglo[x].nomcat); // Nombre del comportamiento
                        $('.punto').html('<span>' + arreglo[x].puntos + '</span>'); // Puntos
                        imagen.html('<img class="medallas" src="/imgpremios/' + arreglo[x].rutaimagen + '" alt="medalla">');
                        imagen2.html('<img class="medallas-muro" src="/imgpremios/' + arreglo[x].rutaimagen + '" alt="medalla">');
                        compor.append('<option value="' + arreglo[x].idcom + '">' + arreglo[x].nomcat + '</option>'); 
                    }
                } else {
                    compor.append('<option value="">No hay datos disponibles</option>');
                }
            } catch (e) {
                console.error("Error al procesar JSON:", e);
            }
        }).fail(function (jqXHR, textStatus, errorThrown) {
            console.error("Error en la petición AJAX:", textStatus, errorThrown);
        });
    });
});

/*script para replicar el texto ingresado en el textarea */
document.getElementById("detexto").addEventListener("input", function() {
  let texto = this.value;
  let previewDiv = document.getElementById("preview");

  // Actualizar el contenido del div
  previewDiv.textContent = texto || "El texto ingresado aparecerá aquí...";
});