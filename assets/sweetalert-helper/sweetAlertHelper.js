// Acá se configura el mensaje de Guardado para el sweet Alert

//Está funcion de acá abajo es la misma pero con un botón ↓↓
/* function mostrarAlertaExito(mensaje = "Datos guardados de forma exitosa") {
    Swal.fire({
        icon: 'success',
        title: '¡Éxito!',
        text: mensaje,
        confirmButtonText: 'Aceptar'
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.reload(); // Recargar la página no es necesario acá porque ya se usa esta función en el botón de guardar 
        }
    });
} */

function mostrarAlertaExito(mensaje = "Datos guardados de forma exitosa") {
    Swal.fire({
        icon: 'success',
        title: '¡Éxito!',
        text: mensaje,
        timer: 2000, //Tiempo actual del mensaje 2 segundos
        showConfirmButton: false,
        willClose: () => {
            // Esta función se ejecutará justo antes de que la alerta se cierre
            window.location.reload(); // Recargar la página
        }
    });
}