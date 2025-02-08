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
            // Lo de abajo se ejecutara después que se cierre el mensaje
            window.location.reload(); // Recargar la página
        }
    });
}

function mostrarAlertaEdicion(redirect) {
    Swal.fire({
        icon: 'success',
        title: '¡Éxito!',
        text: "Los datos fueron modificados de forma exitosa",
        timer: 2000, // Tiempo actual del mensaje: 2 segundos
        showConfirmButton: false,
        willClose: () => {
            // Lo de abajo se ejecutará después de que se cierre el mensaje
            window.location.href = redirect; // Redirige a lo enviado en el backend
        }
    });
}