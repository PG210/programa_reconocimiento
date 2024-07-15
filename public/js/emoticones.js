
  function selecEmot(idc, emoticon, idemot){
    //========== ajax ============
    $.ajax({
        url: "/reacciones",
        type: 'GET',
        data: {
          idrec:idc,
          emoticon: emoticon,
          idemot: idemot
        },
        dataType: 'json', //debe agregar para ver el tipo de dato a recibir
        success:function(data){
        //console.log("datos", data);
         mostrarDatos(data, idc);
        },
        error:function(error){
            console.log("Error en la solicitud");
        }

    });

  }
  // funcion para mostrar datos
function mostrarDatos(data, idc){
  $("#reaccionesPHP"+idc).hide();
  $("#text"+idc).html(data.emot);
  $("#usuario"+idc+data.usu).hide();
  $("#em"+idc).html(
    '<span>'+ data.emot + ' ' + data.nombre + ' ' + data.apellido + '</span>'
    );
  // validar que los valores se han mayores a cero
  $("#reac" + idc).html(function() {
    var contenido = '';

    if (data.megusta > 0) {
        contenido += '👍<span class="badge badge-light">' + data.megusta + '</span> ';
    }
    if (data.encanta > 0) {
        contenido += '😍<span class="badge badge-light">' + data.encanta + '</span> ';
    }
    if (data.sorpresa > 0) {
        contenido += '😲<span class="badge badge-light">' + data.sorpresa + '</span> ';
    }
    if (data.abrazo > 0) {
        contenido += '🤗<span class="badge badge-light">' + data.abrazo + '</span>';
    }

    return contenido;
});
}

/* When the user clicks on the button,
toggle between hiding and showing the dropdown content */
function myFunction(idc) {
  document.getElementById("myDropdown"+idc).classList.toggle("show");
}
// Función para cerrar el dropdown si se hace clic fuera de él
function closeDropdowns(event) {
  if (!event.target.matches('.dropdownnew a, .dropdownnew a *')) {
    var dropdowns = document.getElementsByClassName('dropdownnew-content');
    for (var i = 0; i < dropdowns.length; i++) {
      var openDropdown = dropdowns[i];
      if (openDropdown.classList.contains('show')) {
        openDropdown.classList.remove('show');
      }
    }
  }
}
// Escuchar clics en el documento
document.addEventListener('click', closeDropdowns);
// funcion para filtrar
function filterFunction(idc) {
  const input = document.getElementById("myInput"+idc);
  const filter = input.value.toUpperCase();
  const div = document.getElementById("myDropdown"+idc);
  const a = div.getElementsByTagName("a");
  for (let i = 0; i < a.length; i++) {
    txtValue = a[i].textContent || a[i].innerText;
    if (txtValue.toUpperCase().indexOf(filter) > -1) {
      a[i].style.display = "";
    } else {
      a[i].style.display = "none";
    }
  }
}
