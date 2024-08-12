
            // Función para abrir el modal
            function openModal_provee() {
                var modalContainer = document.getElementById('modalContainer_proveedores');
                modalContainer.style.display = 'flex';
                openModalBtnProveedores.style.zIndex = -1;
            }

            // Función para cerrar el modal
            function closeModal_provee() {
                var modalContainer = document.getElementById('modalContainer_proveedores');
                modalContainer.style.display = 'none';
                openModalBtnProveedores.style.zIndex = 1;
            }


            // Función para seleccionar un proveedor
            function selectProveedor(ruc, razonSocial, direccion) {
                // Actualizar los campos de texto en la vista principal
                document.getElementById('ruc').value = ruc;
                document.getElementById('contabilidad').value = razonSocial;
                document.getElementById('tesoreria').value = razonSocial;
                document.getElementById('direccion').value = direccion;



                closeModal_provee(); // Cierra el modal después de seleccionar un proveedor
            }

            document.addEventListener("DOMContentLoaded", function() {
    // Agregar evento al botón "Nuevo" para abrir el modal
    const openModalBtnProveedores = document.getElementById("openModalBtnProveedores");
    openModalBtnProveedores.addEventListener("click", () => {
        openModal_provee();
    });

    // Agregar evento al botón de cerrar para cerrar el modal
    const closeModalBtnProveedores = document.getElementById("closeModalBtn");
    closeModalBtnProveedores.addEventListener("click", () => {
        closeModal_provee();
    });
});
        
