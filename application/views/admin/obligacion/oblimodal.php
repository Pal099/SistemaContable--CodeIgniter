<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modal-like View</title>
    <style>
        /* Estilos para el contenedor de estilo modal */
        .modal-container {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.6); /* Fondo semi-transparente */
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 9999; /* Asegura que esté en la parte superior */
            display: none; /* Ocultar por defecto */
        }

        /* Estilos para el contenido del modal-like */
        .modal-content {
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.2);
            max-width: 80%; /* Controla el ancho máximo del contenido */
        }

        /* Estilos para el botón de cerrar */
        .close {
            position: absolute;
            top: 10px;
            right: 15px;
            font-size: 24px;
            cursor: pointer;
        }
    </style>
</head>
<body>

<!-- Contenedor del modal-like -->
<div class="modal-container" id="modalContainer">
    <div class="modal-content">
        <!-- Botón de cerrar -->
        <span class="close" id="closeModalBtn">&times;</span>
        <div class="modal-body">
            <!-- Contenido del modal -->
            <!-- ... (el contenido del modal) ... -->
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" id="closeModalBtn" data-dismiss="modal">Cerrar</button>
        </div>
    </div>
</div>

<script>
// Obtener el botón de cerrar modal
const closeModalBtn = document.getElementById("closeModalBtn");

// Manejar el clic en el botón de cerrar modal
closeModalBtn.addEventListener("click", () => {
    // Ocultar la vista modal
    const modalContainer = document.getElementById("modalContainer");
    modalContainer.style.display = "none";
});
</script>


</body>
</html>
