 // Función para abrir el modal de las cuentas contables
 function openModal_4() {
    var modalContainer = document.getElementById('modalContainer_4');
    modalContainer.style.display = 'flex';
    openModalBtn_4.style.zIndex = -1;
}

// Función para cerrar el modal
function closeModal_4() {
    var modalContainer = document.getElementById('modalContainer_4');
    modalContainer.style.display = 'none';
    openModalBtn_4.style.zIndex = 1;
}

function selectCC2(IDCuentaContable, Codigo_CC, Descripcion_CC) {
    // Actualizar los campos de texto en la vista principal con los valores seleccionados
    document.getElementById('idcuentacontable_2').value = IDCuentaContable;
    document.getElementById('codigo_cc_2').value = Codigo_CC; // Asume que tienes un campo con id 'codigo_cc'
    document.getElementById('descripcion_cc_2').value = Descripcion_CC; // Asume que tienes un campo con id 'descripcion_cc'

    closeModal_4();
}

 
 
 // Agregar evento al botón "buscar cuenta" para abrir el modal
 const openModalBtn_4 = document.getElementById("openModalBtn_4");
 openModalBtn_4.addEventListener("click", (event) => {
     event.preventDefault();

     openModal_4();
 });

 // Agregar evento al botón de cerrar para cerrar el modal
 const closeModalBtn_4 = document.getElementById("closeModalBtn_4");
 closeModalBtn_4.addEventListener("click", (event) => {
     event.preventDefault();
     closeModal_4();
 });
  
           
 function filterResults() {
    var input, filter, table, tr, td1, td2, i, txtValue;
    input = document.getElementById("searchInput_2"); // Ajusta el ID según tu campo de búsqueda
    filter = input.value.toUpperCase();
    table = document.getElementById("cuentasContablesTable_2");
    tr = table.getElementsByTagName("tr");

    for (i = 0; i < tr.length; i++) {
        td1 = tr[i].getElementsByTagName("td")[1]; // Índice para la posición 1 (Código de Cuenta)
        td2 = tr[i].getElementsByTagName("td")[2]; // Índice para la posición 2 (Descripción de Cuenta)

        if (td1 && td2) {
            // Combina los textos de ambas posiciones en una cadena
            txtValue = (td1.textContent || td1.innerText) + ' ' + (td2.textContent || td2.innerText);

            // Busca en la cadena combinada
            if (txtValue.toUpperCase().indexOf(filter) > -1) {
                tr[i].style.display = "";
            } else {
                tr[i].style.display = "none";
            }
        }
    }
}
document.getElementById("searchInput_2").addEventListener("input", filterResults);