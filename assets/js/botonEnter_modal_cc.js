// Obtener la referencia al campo de texto para buscar la cuenta contable
const codigoCC2Input = document.getElementById("codigo_cc");

// Agregar un evento de escucha para la tecla "Enter" en el campo de texto
codigoCC2Input.addEventListener("keyup", function (event) {
    // Verificar si la tecla presionada es "Enter" (código 13)
    if (event.key === "Enter") {
        // Abrir el modal
        openModal_3();
    }
});

// También puedes agregar un evento al botón de búsqueda por si decides seguir usándolo
const openModalBtn4 = document.getElementById("openModalBtn_3");
openModalBtn_3.addEventListener("click", function (event) {
    event.preventDefault();
    openModal_3();
});
