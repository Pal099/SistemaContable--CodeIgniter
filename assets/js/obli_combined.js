 // Función para abrir el modal de programas
 function openModal_obli() {
    var modalContainer = document.getElementById('modalContainer_obli');
    modalContainer.style.display = 'flex';
}

// Función para cerrar el modal de programas
function closeModal_obli() {
    var modalContainer = document.getElementById('modalContainer_obli');
    modalContainer.style.display = 'none';
}

// Función para seleccionar un programa
function selectPrograma(nombre) {
    // Actualizar los campos de texto en la vista principal
    document.getElementById('nombre').value = nombre;
    
    closeModal_obli(); // Cierra el modal después de seleccionar un programa
}

// Agregar evento al botón "Seleccionar Datos" para abrir el modal de programas
const openModalBtn_obli = document.getElementById("openModalBtn_obli");
openModalBtn_obli.addEventListener("click", () => {
    openModal_obli();
});

// Agregar evento al botón de cerrar para cerrar el modal de programas
const closeModalBtn_obli = document.getElementById("closeModalBtn_obli");
closeModalBtn_obli.addEventListener("click", () => {
    closeModal_obli();
});

    // Obtener la fecha actual en el formato deseado (yyyy-mm-dd)
    function obtenerFechaActual() {
        const fecha = new Date();
        const dia = fecha.getDate().toString().padStart(2, '0');
        const mes = (fecha.getMonth() + 1).toString().padStart(2, '0');
        const año = fecha.getFullYear();
        return `${dia}-${mes}-${año}`;
    }

    // Preestablecer el campo de fecha con la fecha actual
    const fechaInput = document.getElementById('fecha');
    fechaInput.value = obtenerFechaActual();

    const optionalFieldsSwitch = document.getElementById("optionalFieldsSwitch");
    const optionalFields = document.querySelector(".optional-fields");

    optionalFieldsSwitch.addEventListener("change", () => {
        if (optionalFieldsSwitch.checked) {
            optionalFields.style.display = "block";
        } else {
            optionalFields.style.display = "none";
        }
        

    });

    // Función para abrir el modal
    function openModal() {
        var modalContainer = document.getElementById('modalContainer');
        modalContainer.style.display = 'flex';
    }

    // Función para cerrar el modal
    function closeModal() {
        var modalContainer = document.getElementById('modalContainer');
        modalContainer.style.display = 'none';
    }

   // Función para seleccionar un proveedor
   function selectProveedor(ruc, razonSocial, direccion) {
        // Actualizar los campos de texto en la vista principal
        document.getElementById('ruc').value = ruc;
        document.getElementById('contabilidad').value = razonSocial;
        document.getElementById('tesoreria').value = razonSocial;
        document.getElementById('direccion').value = direccion;


        
        closeModal(); // Cierra el modal después de seleccionar un proveedor
    }

    // Agregar evento al botón "Nuevo" para abrir el modal
    const openModalBtn = document.getElementById("openModalBtn");
    openModalBtn.addEventListener("click", () => {
        openModal();
    });

    // Agregar evento al botón de cerrar para cerrar el modal
    const closeModalBtn = document.getElementById("closeModalBtn");
    closeModalBtn.addEventListener("click", () => {
        closeModal();
    });