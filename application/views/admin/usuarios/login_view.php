<?php
// Establecer la conexión a la base de datos
$conexion = new mysqli('localhost', 'root', '', 'contanuevo');

// Verificar la conexión
if ($conexion->connect_error) {
    die("La conexión a la base de datos falló: " . $conexion->connect_error);
}

// Consulta para obtener las opciones de la tabla unidad_academica
$consulta_unidad = "SELECT id_unidad, unidad FROM unidad_academica";
$resultado_unidad = $conexion->query($consulta_unidad);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CodexVeritas</title>
    <link href="<?php echo base_url(); ?>assets/img/codex.png" rel="icon">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.3/css/all.css">
    <link href="<?php echo base_url(); ?>/assets/css/login_codex.css" rel="stylesheet">



</head>

<body>

    <form action="<?php echo base_url(); ?>login/index" method="POST" class="form bg-glass">
        <div class="profile">
            <img src="assets\img\codex.png" alt="Logo UNE " style="width: 200px; height: 200px; margin-top: -50px;">
        </div>
        <div class="input-container">
            <input type="text" name="username" class="input bg-glass" placeholder="Nombre de usuario">
            <i class="fas fa-user icon"></i>
        </div>

        <div class="input-container">
            <input type="password" name="contraseña" class="input bg-glass" placeholder="Contraseña">
            <i class="fas fa-lock icon"></i>
        </div>

        <section id="header-container">
            <select id="unidadDropdown" name="unidad_academica">
                <option disabled selected>Seleccione una unidad académica</option>
                <?php
                while ($dataSelect = mysqli_fetch_array($resultado_unidad)) {
                    echo '<option value="' . $dataSelect["id_unidad"] . '">' . utf8_encode($dataSelect["unidad"]) . '</option>';
                }
                ?>
            </select>
            <div id="selectedOptionDisplay">Unidad Académica Seleccionada: </div>
        </section>




        <div class="row">
            <div class="col-8">

                <?php if ($this->session->userdata('error')) { ?>
                    <p class="text-danger"><?= $this->session->userdata('error') ?></p>
                <?php } ?>
                <p class="text-danger"><?php echo validation_errors(); ?></p>

            </div>
        </div>

        <button type="submit" class="button bg-glass">Iniciar Sesión</button>
    </form>
    <script>
        const unidadDropdown = document.getElementById("unidadDropdown");
        const selectedOptionDisplay = document.getElementById("selectedOptionDisplay");

        unidadDropdown.addEventListener("change", function() {
            const selectedIndex = this.selectedIndex;
            const selectedOptionText = this.options[selectedIndex].text;
            selectedOptionDisplay.textContent = "Unidad Académica Seleccionada: " + selectedOptionText;
        });
    </script>

</body>

</html>

<?php
// Cierra la conexión a la base de datos al final del script
$conexion->close();
?>