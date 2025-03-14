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
                let opciones = { day: 'numeric', month: 'long', year: 'numeric' }; // Opciones de formato
                limpiararea();
                for(let i=0; i<data.length; i++){

                    let fechaObj = new Date(data[i]['fecha']); // Convertir a objeto Date
                    let fechaFormateada = fechaObj.toLocaleDateString('es-ES', opciones); 
                    let fechaFinal = fechaFormateada.replace('de',' ').replace('de', ' ');

                    html +=
                        '<div class="user-panel pb-0 mb-0 mt-1" style="white-space: normal;">' +
                                '<img src="/dist/imgperfil/' + data[i]['imagen'] + '" class="img-circle img-sm" alt="User Image">' +
                                '<span> <b>&nbsp;&nbsp;' + data[i]['nombre'] + ' ' + data[i]['apellido'] + '</b>&nbsp;</span>' + 
                                '<span class="card-text mx-2"><small class="text-muted float-right">' + fechaFinal + '</small></span>' +
                                '<p style="margin-left:40px;">'+ data[i]['comentario'] + '</p>'
                        '</div>';
                }
                if(tipo === '1'){ //si es cumpleanios
                   $('#responsehappy' + formId).append(html);;
                }else{
                   $('#responseaniver' + formId).append(html);; 
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