<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Balance General</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
    <div class="container mt-5">
        <h2>Balance General</h2>
        <table class="table">
            <thead>
                <tr>
                    <th>Número de Cuenta</th>
                    <th>Descripción de la Cuenta</th>
                    <th>Total Debe</th>
                    <th>Total Haber</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($cuentas as $cuenta): ?>
                    <tr>
                        <td><?= $cuenta->Codigo_CC ?></td>
                        <td><?= $cuenta->Descripcion_CC ?></td>
                        <td><?= $cuenta->TotalDebe ?></td>
                        <td><?= $cuenta->TotalHaber ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>


