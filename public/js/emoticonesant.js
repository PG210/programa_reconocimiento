
  function emotAniversario(iduser, emoticon, idemot, comentario, tipo){
    //========== ajax ============
    $.ajax({
        url: "/reacciones/holidays",
        type: 'GET',
        data: {
          iduser:iduser,
          emoticon: emoticon,
          idemot: idemot,
          tipo: tipo,
          comentario: comentario,
        },
        dataType: 'json', //debe agregar para ver el tipo de dato a recibir
        success:function(data){
         let datos = data['data'];
         let total = data['total'];
         if(datos.tipo == '2'){ //datos de aniversario
          mostrarDatosEventos(datos, iduser, total);
         }
         if(datos.tipo == '1'){
          mostrarDatosCumple(datos, iduser, total);
         }
        },
        error:function(error){
          window.alert('Alerta, Error al procesar la solicitud.'); 
        }

    });
  }
  // funcion para mostrar datos
function mostrarDatosEventos(data, idc, total){
  $("#reaccionesPHPaniver"+idc).hide();
  $("#textaniver"+idc).html(data.emoticon);
  $("#usuarioaniver"+idc).hide();
  $("#emaniver"+idc).html(
    '<span>'+ data.emoticon + ' ' + data.nombre + ' ' + data.apellido + '</span>'
    );
  // validar que los valores se han mayores a cero
  $("#reacaniver" + idc).html(function() {
    var contenido = '';

    if (total.likes > 0) {
        contenido += '👍<span class="badge badge-light">' + total.likes + '</span> ';
    }
    if (total.ilove > 0) {
        contenido += '😍<span class="badge badge-light">' + total.ilove + '</span> ';
    }
    if (total.surprised > 0) {
        contenido += '😲<span class="badge badge-light">' + total.surprised + '</span> ';
    }
    if (total.hug > 0) {
        contenido += '🤗<span class="badge badge-light">' + total.hug + '</span>';
    }

    return contenido;
});
}
/* When the user clicks on the button,
toggle between hiding and showing the dropdown content */

function userReaccion(idc) {
  document.getElementById("myDropdownaniver"+idc).classList.toggle("show");
}
// Función para cerrar el dropdown si se hace clic fuera de él

//informacion para imprimir en cumple anios
function mostrarDatosCumple(data, idc, total){
  $("#reaccionesPHPhappy"+idc).hide();
  $("#texthappy"+idc).html(data.emoticon);
  $("#usuariohappy"+idc).hide();
  $("#emhappy"+idc).html(
    '<span>'+ data.emoticon + ' ' + data.nombre + ' ' + data.apellido + '</span>'
    );
  // validar que los valores se han mayores a cero
  $("#reachappy" + idc).html(function() {
    var contenido = '';

    if (total.likes > 0) {
        contenido += '👍<span class="badge badge-light">' + total.likes + '</span> ';
    }
    if (total.ilove > 0) {
        contenido += '😍<span class="badge badge-light">' + total.ilove + '</span> ';
    }
    if (total.surprised > 0) {
        contenido += '😲<span class="badge badge-light">' + total.surprised + '</span> ';
    }
    if (total.hug > 0) {
        contenido += '🤗<span class="badge badge-light">' + total.hug + '</span>';
    }

    return contenido;
});
}

function happyReaccion(idc) {
  document.getElementById("myDropdownhappy"+idc).classList.toggle("show");
}
