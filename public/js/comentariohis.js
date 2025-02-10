$(document).ready(function() {
    // Capturar cualquier formulario con la clase 
    $('.formhistory').on('submit', function(e) {
        e.preventDefault();  
        let formData = $(this).serialize();
        let formId = $(this).attr('id'); // Captura el ID del formulario
        const comentario = $('#contenido'+ formId).val().trim();
        if (comentario === '') {
            //e.preventDefault();  // Evita el envío del formulario
            $('#mensajeError'+ formId).show();  // Muestra el mensaje de error
          } else {
            $('#mensajeError'+ formId).hide();  // Oculta el mensaje si no está vacío
            //datos del formulario para enviar
            $.ajax({
                url: '/comentario/history',
                type: 'POST',
                data: formData, 
                dataType: 'json', //debe agregar para ver el tipo de dato a recibir
                success: function(response) {
                    limpiararea();
                    let data = response.data; 
                    let total = response.totcomentarios[0]['totalcomentarios'];
                    let html = '';
                    let opciones = { day: 'numeric', month: 'long', year: 'numeric' }; // Opciones de formato
                   
                    for(let i=0; i<data.length; i++){
                        let fechaObj = new Date(data[i]['fecha']); // Convertir a objeto Date
                        let fechaFormateada = fechaObj.toLocaleDateString('en-GB', opciones); 
                        html +=
                            '<div class="user-panel mt-3 pb-0 mb-0" style="white-space: normal;">' +
                                '<img src="/dist/imgperfil/' + data[i]['imagen'] + '" class="img-circle elevation-1" alt="User Image" style="padding-bottom:2px;">' +
                                '<span> <b>&nbsp;&nbsp;' + data[i]['nombre'] + ' ' + data[i]['apellido'] + ':</b>&nbsp;</span>' + data[i]['com'] +
                                '<p class="card-text mx-2"><small class="text-muted">' + fechaFormateada + '</small></p>' +
                            '</div>';
                    } 
                    $('#respuestahis' + formId).append(html);//agrega la respuesta al front
                    $('#comentariohis' + formId).html('( '+ total + ' )' + " " + 'Comentarios');
                    
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.log('Error: ' + textStatus + ', ' + errorThrown);
                }
            });
            //end datos formulario
          }
        // Enviar el formulario mediante Ajax
       
    });
});

function limpiararea(){
    $('.emojionearea-editor').html('');  // Limpiar emojionearea
    $('textarea').val('');               // Limpiar todos los textarea
}