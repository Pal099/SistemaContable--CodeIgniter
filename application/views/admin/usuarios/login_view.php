
<style>
    .notification {
    position: fixed;
    top: 20px;
    right: 20px;
    background-color: rgba(0, 123, 255, 0.9); /* Azul más oscuro con opacidad */
    color: white;
    padding: 16px;
    border-radius: 8px;
    z-index: 1000;
    opacity: 0;
    transform: translateY(-20px);
    animation: slideIn 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.275) forwards, fadeOut 0.5s 2s forwards;
    transition: opacity 0.5s ease, transform 0.5s ease;
}

    .close-btn {
        position: absolute;
        top: 10px;
        right: 10px;
        cursor: pointer;
    }

    /* Animación para mostrar la notificación */
    @keyframes slideIn {
        from {
            opacity: 0;
            transform: translateY(-20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Animación para ocultar la notificación después de un tiempo */
    @keyframes fadeOut {
        from {
            opacity: 1;
        }
        to {
            opacity: 0;
        }
    }
</style>
<style>
        .error-message {
    color: red;
    font-size: 14px;
    margin-top: 5px;
}

        /* Estilos para el mensaje emergente */
        .error-popup {
            position: fixed;
            top: 20px;
            right: 20px;
            background-color: rgba(255, 0, 0, 0.8); /* Fondo rojo con opacidad */
            color: white;
            padding: 10px;
            border-radius: 5px;
            display: none;
            z-index: 1000;
        }
    </style>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión</title>
    
    
    
    <style>

        
        body {
            font-family: Arial, sans-serif;
            background-image: url('./assets/img/rec.jpg'); /* Reemplaza 'ruta-de-tu-imagen-de-fondo.jpg' con la ruta de tu imagen de fondo */
            background-size: cover; /* Para que la imagen de fondo cubra toda la pantalla */
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .container {
           
            border-radius: 8px;
            box-shadow: 0 0 20px rgba(0, 123, 255, 0.3);
            display: flex;
            flex-direction: row; /* Coloca los elementos en fila */
        }

       

        /* Estilos para el panel izquierdo */
    .left-panel {
        flex: 1; /* Ocupa una fracción del espacio disponible */
        padding: 20px;
        text-align: center;
        background-color: rgba(255, 255, 255, 0.7); /* Fondo difuminado con transparencia */
        backdrop-filter: blur(0,1px); /* Agrega un efecto de desenfoque al fondo */
        transition: transform 0.3s ease, box-shadow 0.3s ease; /* Transiciones suaves de escala y sombra */
        position: relative; /* Necesario para el brillo animado */
    }

    /* Estilos para el panel derecho */
    .right-panel {
        flex: 1; /* Ocupa una fracción del espacio disponible */
        padding: 20px;
        text-align: center;
        background-color: rgba(255, 255, 255, 0.7); /* Fondo difuminado con transparencia */
        backdrop-filter: blur(0,1px); /* Agrega un efecto de desenfoque al fondo */
        transition: transform 0.3s ease, box-shadow 0.3s ease; /* Transiciones suaves de escala y sombra */
        position: relative; /* Necesario para el brillo animado */
    }

    /* Estilos para el brillo animado en el panel izquierdo y derecho */
    .left-panel::before,
    .right-panel::before {
        content: "";
        position: absolute;
        top: -10px;
        left: -10px;
        right: -10px;
        bottom: -10px;
        background: linear-gradient(45deg, rgba(255, 255, 255, 0.2), rgba(255, 255, 255, 0.5), rgba(255, 255, 255, 0.2));
        opacity: 0;
        z-index: -1;
        border-radius: 8px;
        transition: opacity 0.3s ease; /* Transición suave de opacidad */
    }

    /* Estilos para el texto en los paneles */
    .panel-text {
        position: relative; /* Alinea el texto sobre el brillo animado */
    }

    /* Efecto de brillo al hacer hover en el panel izquierdo y derecho */
    .left-panel:hover,
    .right-panel:hover {
        transform: scale(1.05); /* Aumentamos el tamaño al hacer hover */
        box-shadow: 0 0 30px rgba(0, 123, 255, 0.4);
    }

    .left-panel:hover::before,
    .right-panel:hover::before {
        opacity: 1;
    }
    

        h2 {
            color: #333;
        }

        label {
            display: block;
            margin-bottom: 10px;
            font-weight: bold;
            color: #333;
        }

        input[type="text"],
        input[type="password"] {
            width: 90%;
            padding: 10px;
            margin-bottom: 20px;
            border-radius: 5px;
            font-size: 16px;
        }

        button[type="submit"] {
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            padding: 10px 20px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        button[type="submit"]:hover {
            background-color: #0085b3;
        }

        /* Agregamos una animación al formulario y un efecto de sombra */
        .container:hover {
            transform: scale(1.03);
            box-shadow: 0 0 30px rgba(0, 123, 255, 0.4);
        }
         /* Agregamos una transición suave para el efecto de escala al hacer hover en el formulario */
    .container:hover {
        transform: scale(1.05); /* Aumentamos el tamaño al hacer hover */
        transition: transform 0.3s ease; /* Transición suave de 0.3 segundos */
        box-shadow: 0 0 30px rgba(0, 123, 255, 0.4);
    }

    /* Estilos para el mensaje de bienvenida */
    .welcome-message {
        font-size: 28px; /* Hemos aumentado el tamaño de la fuente */
        font-family: "Arial", sans-serif; /* Fuente más común */
        font-weight: bold; /* Texto en negrita */
        color: #333;
        margin-bottom: 20px;
    }

        /* Estilos para la imagen */
        .logo {
            max-width: 200px;
            margin: 0 auto 20px;
            display: block;
        }

        /* Estilos para el mensaje de bienvenida */
        .welcome-message {
            font-size: 24px;
            color: #333;
            margin-bottom: 20px;
        }
    </style>
   

</head>

<link href="<?php echo base_url();?>assets/img/logoUNE.png" rel="icon">

<body>
<form action="<?php echo base_url();?>user/Usuarios/login" method="post" onsubmit="return validarFormulario();"> 
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
              
        </div>
        <div class="right-panel">
            <h2>Iniciar Sesión</h2>
            <?php echo form_open('user/Usuarios/login'); ?>
                <label for="username">Nombre de Usuario:</label>
                <input type="text" name="username" required><br>

                <label for="password">Contraseña:</label>
                <input type="password" name="password" required>
                
                <button type="submit">Iniciar Sesión</button>
            </form>
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
