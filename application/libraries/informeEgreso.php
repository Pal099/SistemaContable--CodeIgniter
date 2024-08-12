<?php

session_start();

if (!isset($_SESSION['rol'])) {
    header('location: ../../index.php');
}

require("../../clases/Conexion.php");
$c = new Conexion();
$conexion = $c->conectar();

?>
<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="../../assets/css/bootstrap.min.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel=stylesheet href="../../assets/style1.css">

    <script defer src="../../assets/js/bootstrap.min.js"></script>
    <title>Informe de egresos</title>
</head>

<body>

    <?php
    include_once '../../assets/header.php';
    ?>

    <div class="mt-2 text-light" style="width: 100%;">
        <h1 class="ms-3 text-light">Informe de egresos</h1>
        <hr />
    </div>

    <form action="#" method="post">

        <div class="w-50 mx-auto mt-3">
            <h4 class="text-light">Seleccione el rango de tiempo</h4>

            <div class="input-group mb-3">
                <span class="input-group-text">Desde: </span>
                <input type="date" class="form-control" name="txtfecha1">
                <span class="input-group-text">Hasta</span>
                <input type="date" class="form-control" name="txtfecha2">
                <input type="submit" value="Filtrar" class="btn btn-primary">
            </div>
        </div>
    </form>

    <div class="w-75 mt-5 mx-auto text-light">

        <?php
        if (isset($_POST["txtfecha1"]) && isset($_POST["txtfecha2"])) {
            $fecha1 = $_POST["txtfecha1"];
            $fecha2 = $_POST["txtfecha2"];

        ?>



            <div class="mx-auto mt-2 text-light">
                <a class="btn btn-primary mt-3 mb-3" href="pdfEgresos.php?f1=<?php echo $fecha1 ?>&f2=<?php echo $fecha2 ?>" target="_blank">PDF <i class='bx bx-download'></i> </a>
                <h3 class="text-light">Informe egresos</h1>
            </div>
            <table id="egresos" class="table table-secondary table-hover">
                <thead>
                    <tr>
                        <th class="text-center">Id</th>
                        <th class="text-center">Descripcion</th>
                        <th class="text-center">Fecha</th>
                        <th class="text-center">Valor</th>
                    </tr>
                </thead>
                <tbody class="text-center">
                    <?php

                    $sql = $conexion->query("SELECT * FROM egresos
                    WHERE egreso_fecha BETWEEN '$fecha1' AND '$fecha2' ORDER BY egreso_fecha ASC;");

                    while ($resultado = $sql->fetch_assoc()) {
                    ?>

                        <tr>
                            <td><?php echo $resultado['egreso_id'] ?></td>
                            <td><?php echo $resultado['egreso_desc'] ?></td>
                            <td><?php echo $resultado['egreso_fecha'] ?></td>
                            <td><?php echo $resultado['egreso_valor'] ?></td>
                        </tr>

                    <?php

                    }

                    ?>
                </tbody>
            </table>
        <?php
        }
        ?>
        <a class="btn btn-primary mt-3" href="../usuario/admin.php">Volver</a>
    </div>
    <script>
        var loader = document.getElementById("preloader");
        window.addEventListener("load", function(){
            loader.style.display = "none";
        })
    </script>
</body>

</html>