document.addEventListener("DOMContentLoaded", function() {
    // Agregar evento al botón "Cancelar"
    const cancelarBtn = document.getElementById("cancelarBtn");
    cancelarBtn.addEventListener("click", function() {
        // Limpia el contenido de la tabla de datos seleccionados
        const tablaDatosSeleccionados = document.getElementById("tablaolilist");
        const tbody = tablaDatosSeleccionados.querySelector("tbody");
        tbody.innerHTML = ""; // Borra todas las filas
    });

});

function selectPrograma(nombrePrograma, nombreFuente, nombreOrigen, numeroCuenta) {
    // Captura la tabla principal por su ID
    var tabla = document.getElementById('tablaolilist').getElementsByTagName('tbody')[0];

    // Crea una nueva fila en la tabla
    var fila = tabla.insertRow();

    // Inserta celdas en la fila
    var celdaPrograma = fila.insertCell(0);
    var celdaFuente = fila.insertCell(1);
    var celdaOrigen = fila.insertCell(2);
    var celdaCuenta = fila.insertCell(3);

    // Asigna los valores a las celdas
    celdaPrograma.innerHTML = nombrePrograma;
    celdaFuente.innerHTML = nombreFuente;
    celdaOrigen.innerHTML = nombreOrigen;
    celdaCuenta.innerHTML = numeroCuenta;

    // Muestra el campo de comprobante
    var comprobanteContainer = document.querySelector('.comprobante-container');
    comprobanteContainer.style.display = 'block';

    closeModal_obli()
}



document.addEventListener("DOMContentLoaded", function() {
    var select = document.getElementById("cuentacontable");
    var textInput = document.getElementById("cuentacontable_text");

    // Actualiza el campo de texto oculto al cambiar la selección
    select.addEventListener("change", function() {
        var selectedOption = select.options[select.selectedIndex];
        textInput.value = selectedOption.textContent;
    });
});