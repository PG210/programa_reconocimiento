$(document).ready(function() {
    $('.chekmensaje').change(function() {
        let checkbox = $(this);
        let estado = $(this).is(':checked') ? 1 : 0;  // 1 si está activado, 0 si está desactivado
        let id = checkbox.data('id');

        $.ajax({
                url: '/empresa/eventos/active/noty',
                type: 'POST',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    estado: estado,
                    id: id
                },
                success: function(response) {
                    toastr.success(response.message, 'Éxito', { timeOut: 3000 });
                },
                error: function(xhr) {
                    toastr.error('Hubo un error al actualizar el estado.', 'Error', { timeOut: 3000 });
                    $('.chekmensaje').prop('checked', !estado);  // Revertir el cambio si hay error
                }
            });
    });
});