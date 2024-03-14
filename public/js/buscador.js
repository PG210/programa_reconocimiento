  /*buscador reactivo */
  function doSearch(){
    const tableReg = document.getElementById('tablaDate');
    const searchText = document.getElementById('searchTerm').value.toLowerCase();
    let total = 0;

    for (let i = 1; i < tableReg.rows.length; i++) {
        const cellsOfRow = tableReg.rows[i].getElementsByTagName('td');
        let found = false;

        for (let j = 0; j < cellsOfRow.length && !found; j++) {
            const compareWith = cellsOfRow[j].textContent.toLowerCase();

            if (!tableReg.rows[i].classList.contains("noSearch") &&
                (searchText.length === 0 || compareWith.indexOf(searchText) !== -1)) {
                found = true;
                total++;
            }
        }

        tableReg.rows[i].style.display = (found) ? '' : 'none';
    }

    const lastTR = tableReg.rows[tableReg.rows.length - 1];
    const td = lastTR.querySelector("td");
    lastTR.classList.remove("hide", "red");

    if (searchText === "") {
        lastTR.classList.add("hide");
    } else if (total) {
        td.innerHTML = "Se ha encontrado " + total + " coincidencia" + ((total > 1) ? "s" : "");
    } else {
        lastTR.classList.add("red");
        td.innerHTML = "No se han encontrado coincidencias";
    }
}