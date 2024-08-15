//script para cards
$(document).ready(function() {
      const cards = $('.card-group .card');
      let currentIndex = 0;
      let cardsPerPage = getCardsPerPage();

      /*Tamanio de la pantalla*/
      function getCardsPerPage() {
            const width = $(window).width();
            if (width >= 992) { // Pantallas grandes (>= 992px)
                return 3;
            } else { // Pantallas medianas y pequeñas
                return 2;
            }
        }

      function updateCards() {
        cards.removeClass('show').hide();
        for (let i = currentIndex; i < currentIndex + cardsPerPage; i++) {
          if (i < cards.length) {
            $(cards[i]).addClass('show').fadeIn();
          }
        }
        $('#prev').prop('disabled', currentIndex <= 0);
        $('#next').prop('disabled', currentIndex + cardsPerPage >= cards.length);
      }

      $('#next').click(function() {
        if (currentIndex + cardsPerPage < cards.length) {
          currentIndex += cardsPerPage;
          updateCards();
        }
      });

      $('#prev').click(function() {
        if (currentIndex - cardsPerPage >= 0) {
          currentIndex -= cardsPerPage;
          updateCards();
        }
      });
      /*Detecta la pantalla cambia de tamanio */
      $(window).resize(function() {
            cardsPerPage = getCardsPerPage();
            currentIndex = 0; // Reiniciar a la primera página
            updateCards();
        });

      updateCards();
    });
////////////////////// para manejar las fechas de los filtros
document.getElementById('fecini').addEventListener('change', function() {
    var fecini = document.getElementById('fecini').value;
    document.getElementById('fecfin').min = fecini;
});

////////////////////// para manejar el ver mas y ver menos

function toggleText(idcat) {
  var corta = document.getElementById('descripcion-corta' + idcat);
  var completa = document.getElementById('descripcion-completa' + idcat);
  var toggleLink = document.getElementById('toggle-text' + idcat);
  
  if (corta.classList.contains('d-none')) {
      // Si la descripción corta está oculta, mostrarla y ocultar la completa
      corta.classList.remove('d-none');
      completa.classList.add('d-none');
      toggleLink.textContent = 'Ver más';
  } else {
      // Si la descripción corta está visible, ocultarla y mostrar la completa
      corta.classList.add('d-none');
      completa.classList.remove('d-none');
      toggleLink.textContent = 'Ver menos';
  }
}
