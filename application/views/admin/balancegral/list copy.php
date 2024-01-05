<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Balance General</title>
</head>
<body>

<h1>Balance General</h1>

<table border="1">
    <tr>
        <th>Número de Cuenta</th>
        <th>Descripción de la Cuenta</th>
        <th>Total Debe</th>
        <th>Total Haber</th>
    </tr>

    <?php foreach ($cuentas as $cuenta) : ?>
    <tr>
        <td><?= $cuenta['Codigo_CC'] ?></td>
        <td><?= $cuenta['Descripcion_CC'] ?></td>
        <td><?= $cuenta['total_debe'] ?></td>
        <td><?= $cuenta['total_haber'] ?></td>
    </tr>

    <?php if (isset($cuenta['hijos']) && !empty($cuenta['hijos'])) : ?>
        <?php mostrarCuentasHijas($cuenta['hijos']); ?>
    <?php endif; ?>
<?php endforeach; ?>

</table>

</body>
</html>
