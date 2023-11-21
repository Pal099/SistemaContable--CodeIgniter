
                document.addEventListener("DOMContentLoaded", function () {
                    // Agregar evento al botón "Cancelar"
                    const cancelarBtn = document.getElementById("cancelarBtn");
                    cancelarBtn.addEventListener("click", function () {
                        // Limpia el contenido de la tabla de datos seleccionados
                        const tablaDatosSeleccionados = document.getElementById("tablaolilist");
                        const tbody = tablaDatosSeleccionados.querySelector("tbody");
                        tbody.innerHTML = ""; // Borra todas las filas

                        // Oculta el campo de comprobante
                        const comprobanteContainer = document.querySelector('.comprobante-container');
                        comprobanteContainer.style.display = 'none';
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
                


            
                    // Manejar la visibilidad de los campos opcionales
                    const optionalFieldsSwitch = document.getElementById("optionalFieldsSwitch");
                    const optionalFields = document.querySelector(".optional-fields");

                    optionalFieldsSwitch.addEventListener("change", () => {
                        if (optionalFieldsSwitch.checked) {
                            optionalFields.style.display = "block";
                        } else {
                            optionalFields.style.display = "none";
                        }
                        

                    });

                    




    document.addEventListener("DOMContentLoaded", function () {
        var select = document.getElementById("cuentacontable");
        var textInput = document.getElementById("cuentacontable_text");

        // Actualiza el campo de texto oculto al cambiar la selección
        select.addEventListener("change", function () {
            var selectedOption = select.options[select.selectedIndex];
            textInput.value = selectedOption.textContent;
        });
    });
