/* codigo para enviar solicitud del boton */
$(document).ready(function() {
    $('#customSwitch1').change(function() {
        let estado = $(this).is(':checked') ? 1 : 0;  // 1 si está activado, 0 si está desactivado
       // let url = $(this).data('url');
        $.ajax({
                url: '/empresa/eventos/active',
                type: 'POST',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    estado: estado
                },
                success: function(response) {
                    toastr.success(response.message, 'Éxito', { timeOut: 3000 });
                },
                error: function(xhr) {
                    toastr.error('Hubo un error al actualizar el estado.', 'Error', { timeOut: 3000 });
                    $('#customSwitch1').prop('checked', !estado);  // Revertir el cambio si hay error
                }
            });
    });
});
//funcion para tooltip
$(function () {
    $('[data-toggle="tooltip"]').tooltip();
  });

