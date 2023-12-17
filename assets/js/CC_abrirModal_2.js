// Función para abrir el modal de las cuentas contables
function openModal_3() {
    var modalContainer = document.getElementById('modalContainer_3');
    modalContainer.style.display = 'flex';
    openModalBtn_3.style.zIndex = -1;
}

// Función para cerrar el modal
function closeModal_3() {
    var modalContainer = document.getElementById('modalContainer_3');
    modalContainer.style.display = 'none';
    openModalBtn_3.style.zIndex = 1;
}

function selectCC(IDCuentaContable, Codigo_CC, Descripcion_CC) {
    // Actualizar los campos de texto en la vista principal con los valores seleccionados
    document.getElementById('idcuentacontable').value = IDCuentaContable;
    document.getElementById('codigo_cc').value = Codigo_CC; // Asume que tienes un campo con id 'codigo_cc'
    document.getElementById('descripcion_cc').value = Descripcion_CC; // Asume que tienes un campo con id 'descripcion_cc'

    closeModal_3();
}

// Agregar evento al botón "buscar cuenta" para abrir el modal
const openModalBtn_3 = document.getElementById("openModalBtn_3");
openModalBtn_3.addEventListener("click", (event) => {
    event.preventDefault();

    openModal_3();
});

// Agregar evento al botón de cerrar para cerrar el modal
const closeModalBtn_3 = document.getElementById("closeModalBtn_3");
closeModalBtn_3.addEventListener("click", (event) => {
    event.preventDefault();
    closeModal_3();
});

