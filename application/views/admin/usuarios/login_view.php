<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión</title>

</head>

<link href="<?php echo base_url();?>./assets/img/logoUNE.png" rel="icon">
<script src="<?php echo base_url();?>assets/js/login.js"></script>
<link href="<?php echo base_url();?>assets/css/style_login.css" rel="stylesheet">
<link href="<?php echo base_url();?>assets/css/style_login2.css" rel="stylesheet">
<link href="<?php echo base_url();?>assets/css/style_login3.css" rel="stylesheet">


<body>
<form action="<?php echo base_url();?>./user/Usuarios/login" method="post" onsubmit="return validarFormulario();"> 
    <div class="container">
        <div class="left-panel">
                <img src="./assets/img/logoUNE.png" alt="Logo de la Empresa" class="logo">
            <div class="welcome-message">
                Bienvenido al Sistema Contable
            </div>
                 <!-- Dropdown de Unidad Académica -->
            <label for="unidad_academica">Unidad Académica:</label>
                <select name="unidad_academica" required>
                    <option value="" disabled selected>Seleccione una unidad académica</option>
                    <?php
                        // Conexión a la base de datos (debes configurar tu conexión)
                        $conexion = new mysqli('localhost', 'root', 'root', 'contanuevo');
                        
                        // Verificar la conexión
                        if ($conexion->connect_error) {
                            die("La conexión a la base de datos falló: " . $conexion->connect_error);
                        }
                        
                        // Consulta para obtener las opciones de la tabla unidad_academica
                        $unidad_academica = "SELECT unidad FROM unidad_academica";
                        $unidad_academica = $conexion->query($unidad_academica);
                        
                        if ($unidad_academica->num_rows > 0) {
                            while ($fila = $unidad_academica->fetch_assoc()) {
                                echo '<option value="' . $fila["unidad"] . '">' . $fila["unidad"] . '</option>';
                            }
                        }
                        
                        // Cierra la conexión a la base de datos
                        $conexion->close();
                    ?>
                </select>
                <div id="unidad-error" class="error-message" style="display:none;">Por favor, seleccione una unidad académica.</div>
                <!-- Fin del Dropdown de Unidad Académica -->
            </label>
        </div>    
    </div>
        
    <div class="containerR">
        <div class="right-panel">
            <h2>Iniciar Sesión</h2>
            <?php echo form_open('./user/Usuarios/login'); ?>
                <label for="username">Nombre de Usuario:</label>
                <input type="text" name="username" required><br>

                <label for="password">Contraseña:</label>
                <input type="password" name="password" required>
                
                <button type="submit">Iniciar Sesión</button>
            </form>
        </div>  
    </div>

</form>




        <?php if(isset($error)) { ?>
        <div class="error-popup" id="error-popup">
            <?php echo $error; ?>
        </div>
        <script>
            // Función para mostrar el mensaje emergente
            function showErrorPopup() {
                var errorPopup = document.getElementById('error-popup');
                errorPopup.style.display = 'block';
                
                // Ocultar el mensaje después de 5 segundos (ajusta el tiempo según tus necesidades)
                setTimeout(function() {
                    errorPopup.style.display = 'none';
                }, 5000); // 5000 milisegundos = 5 segundos
            }

            // Llama a la función para mostrar el mensaje emergente si existe un error
            showErrorPopup();
        </script>
        <?php } ?>

    </div>
    <script>
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

</script>

</body>


</html>
