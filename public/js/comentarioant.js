$(document).ready(function() {
    // Capturar cualquier formulario con la clase 
    $('.formholidays').on('submit', function(e) {
        e.preventDefault();  
        let formData = $(this).serialize();
        let formId = $(this).attr('id'); // Captura el ID del formulario
        // Enviar el formulario mediante Ajax
        $.ajax({
            url: '/comentario/holidays',  
            type: 'POST',
            data: formData, 
            dataType: 'json', //debe agregar para ver el tipo de dato a recibir
            success: function(response) {
                let data = response.data; 
                let tipo = response.tipo; 
                let html = '';
                limpiararea();
                for(let i=0; i<data.length; i++){
                    html +=
                        '<div class="user-panel mt-3 pb-0 mb-0" style="white-space: normal;">' +
                            '<img src="/dist/imgperfil/' + data[i]['imagen'] + '" class="img-circle elevation-1" alt="User Image" style="padding-bottom:2px;">' +
                            '<span> <b>&nbsp;&nbsp;' + data[i]['nombre'] + ' ' + data[i]['apellido'] + ':</b>&nbsp;</span>' + data[i]['comentario'] +
                            '<p class="card-text mx-2"><small class="text-muted">' + data[i]['fecha'] + '</small></p>' +
                        '</div>';
                }
                if(tipo === '1'){ //si es cumpleanios
                   $('#responsehappy' + formId).html(html);
                }else{
                   $('#responseaniver' + formId).html(html); 
                }
                
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log('Error: ' + textStatus + ', ' + errorThrown);
            }
        });
    });
});

function limpiararea(){
    let divs = document.getElementsByClassName("emojionearea-editor"); //eliminar el texto de los textarea
    for (let i = 0; i < divs.length; i++) {
      divs[i].innerHTML = ""; 
    }
}