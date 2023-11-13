<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Usuario y Unidad Académica</title>
    <link rel="stylesheet" href="styles.css"> <!-- Agrega tu archivo CSS para los estilos -->
    <style>

.indicacion-seguridad {
    display: flex;
    align-items: center;
    margin: 10px 0;
}

.icono {
    width: 24px;
    height: 24px;
    margin-right: 10px;
    background-color: #ccc; /* Color de fondo del icono */
    border-radius: 50%;
}

.icono.insegura {
    background-color: red;
}

.icono.medio-segura {
    background-color: yellow;
}

.icono.muy-segura {
    background-color: green;
}

.mensaje {
    font-weight: bold;
}

@keyframes bounce {
    0%, 100% {
        transform: translateY(0);
    }
    50% {
        transform: translateY(-10px);
    }
}

        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
        }
        
        .container {
            display: flex;
            max-width: 800px;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .left-panel {
            flex: 1;
            padding: 20px;
            text-align: center;
            background: #007bff;
            color: #fff;
        }

        .left-panel img {
            max-width: 150px;
            margin: 0 auto 20px;
            display: block;
        }

        .left-panel .welcome-message {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 20px;
        }

        .right-panel {
            flex: 1;
            padding: 20px;
            text-align: center;
            background: #fff;
        }

        .right-panel h2 {
            color: #333;
        }

        .right-panel label {
            display: block;
            margin-bottom: 10px;
            font-weight: bold;
            color: #333;
        }

        .right-panel input[type="text"],
        .right-panel input[type="password"] {
            width: 90%;
            padding: 10px;
            margin-bottom: 20px;
            border-radius: 5px;
            font-size: 16px;
        }

        .right-panel button[type="submit"] {
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            padding: 10px 20px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .right-panel button[type="submit"]:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<link href="<?php echo base_url();?>assets/img/logoUNE.png" rel="icon">

<body>
    <div class="container">
        <div class="left-panel">
            <img src="/assets/img/logoUNE.png" alt="Logo de la Empresa">
            <div class="welcome-message">
                Registro de Usuario
            </div>
        </div>
        <div class="right-panel">
            <h2>Registro de Usuario</h2>
            <form action="<?php echo base_url(); ?>user/registro_usuario/registrar" method="post" onsubmit="return validarFormulario();">
                <label for="username">Nombre de Usuario:</label>
                <input type="text" name="username" required><br>

                <label for="password">Contraseña:</label>
                <input type="password" name="password" required>
              

                <label for="unidad_academica">Unidad Académica:</label>
                <select name="unidad_academica" required>
                    <option value="" disabled selected>Seleccione una unidad académica</option>
                    <?php
                        // Conexión a la base de datos (debes configurar tu conexión)
                        $conexion = new mysqli('localhost', 'root', '', 'contanuevo');
                        
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

                <button type="submit">Registrarse</button>
            </form>
        </div>
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

<script>
    var sessionTimeout;

    // Define la función para cerrar la sesión
    function logout() {
        window.location.href = '<?php echo base_url("login/index"); ?>';
    }

    // Resetea el temporizador si el usuario realiza una acción
    function resetSessionTimeout() {
        clearTimeout(sessionTimeout);
        sessionTimeout = setTimeout(logout, 300000); // 300,000 ms = 5 minutos
    }

    // Escucha eventos de inactividad del usuario
    document.addEventListener('mousemove', resetSessionTimeout);
    document.addEventListener('mousedown', resetSessionTimeout);
    document.addEventListener('keydown', resetSessionTimeout);

    // Inicia el temporizador cuando la página se carga
    resetSessionTimeout();
</script>

</body>
</html>
