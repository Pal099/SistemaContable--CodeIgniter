// Obtener la referencia al campo de texto para buscar la cuenta contable
const codigoCC2Input = document.getElementById("codigo_cc_2");

// Agregar un evento de escucha para la tecla "Enter" en el campo de texto
codigoCC2Input.addEventListener("keyup", function (event) {
    // Verificar si la tecla presionada es "Enter" (código 13)
    if (event.key === "Enter") {
        // Abrir el modal
        openModal_4();
    }
});

// También puedes agregar un evento al botón de búsqueda por si decides seguir usándolo
const openModalBtn4 = document.getElementById("openModalBtn_4");
openModalBtn_4.addEventListener("click", function (event) {
    event.preventDefault();
    openModal_4();
});
