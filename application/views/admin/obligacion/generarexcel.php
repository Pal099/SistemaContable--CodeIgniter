<?php
header("Content-type: application/xls");
header("Content-Disposition: attachment; filename= DetalleDepositoExcel.xls");
?>
<!DOCTYPE html>
<html lang="es">
<head>
</head>
<body>
<main id="main" class="content">
<table id="example1" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>Fecha</th>
                                    <th>Código</th>
                                    <th>op</th>
                                    <th>proveedor</th>
                                    <th>Comprobante</th>
                                    <th>debe</th>
                                    <th>haber</th>
                                    <th>Cod Cuenta Contable</th>
                                    <th>Cuenta Contable</th>
                                    <th>Balance</th>
                                    <th>Descripcion</th>
                                    <th>Numero de programa</th>
                                    <th>Programa</th>
                                    <th>Referencia Diario</th>
                                    <th>Origen de financiamiento</th>
                                    <th>Fuente de financiamiento</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($datos as $dato): ?>

                                    <tr>
                                        <td>
                                            <?= $dato->FechaEmision ?>
                                        </td>
                                        <td>
                                            <?= $dato->num_asi ?>
                                        </td>
                                        <td>
                                            <?= $dato->op ?>
                                        </td>
                                        <td>
                                            <?= $dato->razon_social ?>
                                        </td>
                                        <td>
                                            <?= $dato->comprobante ?>
                                        </td>
                                        <td>
                                            <?= $dato->totalDebe ?>
                                        </td>
                                        <td>
                                            <?= $dato->totalHaber ?>
                                        </td>
                                        <td>
                                            <?= $dato->Codigo_CC ?>
                                        </td>
                                        <td>
                                            <?= $dato->Descripcion_CC ?>
                                        </td>
                                        <td>
                                            <?= $dato->balance ?>
                                        </td>
                                        <td>?</td>
                                        <td>
                                            <?= $dato->num_programa ?>
                                        </td>
                                        <td>
                                            <?= $dato->nombre ?>
                                        </td>
                                        <td>
                                            <?= $dato->num ?>
                                        </td>
                                        <td>
                                            <?= $dato->of ?>
                                        </td>
                                        <td>
                                            <?= $dato->ff ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
</body>

</html>
