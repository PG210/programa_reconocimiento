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
        success:function(response){
          var dat = JSON.parse(response);
          $("#sugerir").empty();
          if(dat.length!=0){
          $('#formudatos')[0].reset();
          toastr.success('El envió de reconocimiento fue exitosó', 'Nuevo Reconocimiento', {timeOut:3000});
          //setTimeout(refrescar, 2000);
          for(var i=0; i<dat.length; i++){
            var resul= '<div class="alert alert-info alert-dismissible fade show" role="alert">'+
                '<strong><i class="fas fa-laugh-beam fa-2x" style="color:#FCFF24;"></i> &nbsp;Sugerencia! Reconoce a :'+
                  '<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' + dat[i].name + '&nbsp;' + dat[i].apellido + '</strong>'+
                   '<button type="button" class="close" data-dismiss="alert" aria-label="Close">'+
                  '<span aria-hidden="true">&times;</span>'+
                '</button>'+
              '</div>';
              $('#sugerir').append(resul);
            }
          }else{
           
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

          }
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
   $('#categoria').on('change', function(){
    var idcate=$('#categor').val();
    var _token = $('input[name=_token]').val(); //token de seguridad
    var cursos = $("#slt-cursos");
    $.ajax({
      type: "POST",
      url:"/filtrar/categoria/comportamiento",
      data:{
        idcate:idcate,
        _token:_token
      } 
    }).done(function(res){
      cursos.find('option').remove();
      let arreglo = JSON.parse(res);
      arreglo.unshift({id: 0, nombre: 'Elegir ...'});//agrega el elegir al inicio
      for(var x=0; x<arreglo.length; x++){
          t='<option value="' + arreglo[x].id + '">' + arreglo[x].nombre  + '</option>';
         cursos.append(t);
      }
     
    });
  });

  /* peticion para encontrar departamentos */
  /*tomamos la información del formulario y la enviamos a la ruta y de la ruta al controlador*/
  $('#slt-cursos').on('change', function(){
    let compor= $("#stl-compor");//sirve para almacenar y limpiar el select
    let imagen = $('#imagen');//sirve para que las imagenes no se junten o dupliquen
    let idcom=$('#slt-cursos').val();
    let _token = $('input[name=_token]').val(); //token de seguridad
  
    $.ajax({
      type: "POST",
      url:"/filtrar/comportamiento",
      data:{
        idcom:idcom,
        _token:_token
      } 
    }).done(function(res){
      let arreglo = JSON.parse(res);
      compor.find('option').remove();
      for(var x=0; x<arreglo.length; x++){
        $('.nomcate').html(arreglo[x].descripcion);
        $('.compor').html(arreglo[x].nomcat);
        $('.punto').html('<span>' + arreglo[x].puntos  + '</span>');
        $('.imagen').html('<img class="card-img-top" src="/imgpremios/' + arreglo[x].rutaimagen + '" >');
        compor.append('<option value="' + arreglo[x].idcom + '">' +  arreglo[x].idcom + '</option>'); 
      }
    });
  });

