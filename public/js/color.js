$(document).ready(function() {
    $('#tipo').on('change', function() {
      // Oculta todos los campos primero
      $('.tipo-campo').hide();

      // Obtiene el valor seleccionado
      const valor = $(this).val();

      // Muestra el campo correspondiente
      if (valor == "1") {
        $('#campoColor').show();
        $('#campoLogo').hide();
      } else if (valor == "2" || valor == "3") {
        $('#campoLogo').show();
        $('#campoColor').hide();
      }
    });
  });
