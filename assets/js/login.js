    // Función para validar el formulario antes de enviarlo
    function validarFormulario() {
        var unidadAcademica = document.querySelector("select[name='unidad_academica']");
        var unidadError = document.getElementById("unidad-error");
    
        if (unidadAcademica.value === "") {
            unidadError.style.display = "block";
            return false; // Evita que el formulario se envíe si falta la unidad académica
        } else {
            unidadError.style.display = "none";
            return true; // Envía el formulario si se ha seleccionado una unidad académica
        }
    }

    

 
    // Función para validar el formulario antes de enviarlo
function validarFormulario() {
    var unidadAcademica = document.querySelector("select[name='unidad_academica']");
    var unidadError = document.getElementById("unidad-error");

    if (unidadAcademica.value === "") {
        unidadError.style.display = "block";
        return false; // Evita que el formulario se envíe si falta la unidad académica
    } else {
        unidadError.style.display = "none";
        return true; // Envía el formulario si se ha seleccionado una unidad académica
    }
}

