<?php
header("Content-type: application/xls");
header("Content-Disposition: attachment; filename= BalanceGeneralExcel.xls");
?>
<!DOCTYPE html>
<html lang="es">
<head>
</head>
<!DOCTYPE html>
<html lang="es">

<head>
</head>

<body>

                    <?php
                    // Función para mostrar cuentas hijas recursivamente
                    function mostrarCuentasHijas($cuentaHija)
                    {
                        ?>
                        <tr>
                            <td>
                                <?= $cuentaHija->Codigo_CC ?>
                            </td>
                            <td>
                                <?= $cuentaHija->Descripcion_CC ?>
                            </td>
                            <td>
                                <?= isset($cuentaHija->TotalDebe) ? $cuentaHija->TotalDebe : 0 ?>
                            </td>
                            <td>
                                <?= isset($cuentaHija->TotalHaber) ? $cuentaHija->TotalHaber : 0 ?>
                            </td>
                        </tr>
                        <?php if (isset($cuentaHija->cuentasHijas)): ?>
                            <?php foreach ($cuentaHija->cuentasHijas as $subCuentaHija): ?>
                                <!-- Mostrar cuentas hijas recursivamente -->
                                <?php mostrarCuentasHijas($subCuentaHija); ?>
                            <?php endforeach; ?>
                        <?php endif;
                    }
                    ?>
                    <table id="balanceTable" class="display">
                        <thead>
                            <tr>
                                <th>Número de Cuenta</th>
                                <th>Descripción de la Cuenta</th>
                                <th>Total Debe</th>
                                <th>Total Haber</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            function unique_objects($array, $key)
                            {
                                $temp_array = array();
                                $key_array = array();

                                foreach ($array as $val) {
                                    if (!in_array($val->$key, $key_array)) {
                                        $key_array[] = $val->$key;
                                        $temp_array[] = $val;
                                    }
                                }

                                return $temp_array;
                            }

                            // Filtrar cuentas duplicadas
                            $uniqueCuentas = unique_objects($cuentas, 'IDCuentaContable');

                            foreach ($uniqueCuentas as $cuenta):
                                ?>
                                <tr>
                                    <td>
                                        <?= $cuenta->Codigo_CC ?>
                                    </td>
                                    <td>
                                        <?= $cuenta->Descripcion_CC ?>
                                    </td>
                                    <td>
                                        <?= isset($cuenta->TotalDebe) ? $cuenta->TotalDebe : 0 ?>
                                    </td>
                                    <td>
                                        <?= isset($cuenta->TotalHaber) ? $cuenta->TotalHaber : 0 ?>
                                    </td>
                                </tr>
                                <?php if (isset($cuenta->cuentasHijas)): ?>
                                    <?php foreach ($cuenta->cuentasHijas as $cuentaHija): ?>
                                        <?php mostrarCuentasHijas($cuentaHija); ?>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </tbody>
                    </table>

                </div>
        </div>
        </div>
</body>

</html>