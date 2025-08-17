<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pdf_comprobante extends CI_Controller
{
    public function generarPDF_comprobante($id_pedido)
    {
        // Incluir la librería FPDF
        require_once APPPATH . 'third_party/fpdf/fpdf.php';

        // Cargar el modelo
        $this->load->model("Pdf_model");
        $datosComprobante = $this->Pdf_model->obtenerDatosComprobante($id_pedido);

        if (empty($datosComprobante)) {
            show_error('No se encontraron datos para el comprobante especificado.');
            return;
        }

        // Crear PDF
        $pdf = new FPDF();
        $pdf->AddPage('P', 'legal', 0);

        // Encabezado
        $pdf->Image('assets/img/logoUNE.png', 35, 3, 25);
        $pdf->SetFont('Arial', 'B', 15);
        $pdf->Cell(0, 10, utf8_decode('28-2 Universidad Nacional del Este'), 0, 1, 'C');
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(0, 10, utf8_decode('GESTION ADMINISTRATIVA RECTORADO - UNE'), 0, 1, 'C');
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(0, 10, utf8_decode('COMPROBANTES DE LA SOLICITUD'), 0, 1, 'C');

        // Número de solicitud
        $pdf->SetXY(160, 35);
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(30, 10, utf8_decode('Solicitud N°: ') . $id_pedido, 1, 0, 'L');

        // Cuadro de información
        $pdf->SetY(45);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Rect(10, 45, 190, 15);

        // Formatear fecha
        $fecha = date('d/m/Y', strtotime($datosComprobante[0]['fecha']));

        // Información en el cuadro
        $pdf->SetXY(12, 47);
        $pdf->Cell(45, 5, 'Fecha: ' . $fecha, 0, 0);
        $pdf->Cell(80, 5, 'Proveedor: ' . utf8_decode($datosComprobante[0]['proveedor']), 0, 0);
        $pdf->Cell(60, 5, 'RUC: ' . $datosComprobante[0]['ruc'], 0, 1);

        $pdf->SetXY(12, 52);
        $pdf->Cell(45, 5, 'Nro. Comprobante: ' . $datosComprobante[0]['IDComprobanteGasto'], 0, 0);
        $pdf->Cell(80, 5, 'Obs.: ' . utf8_decode($datosComprobante[0]['concepto']), 0, 1);

        // Tabla de items
        $pdf->SetY(65);
        $pdf->SetFont('Arial', 'B', 8);

        // Ancho de columnas (ajustado manteniendo todas las columnas)
        $w = array(10, 12, 15, 12, 10, 12, 12, 35, 12, 15, 15, 15, 15);
        
        // Encabezados
        $headers = array('Item', 'Tipo', 'Prog./Sub', 'Obj', 'FF', 'Org.', 'Dpto.', 'Bien/Servicio', 
                        'Cantidad', 'P. Unit.', 'Exentas', 'Gravadas', 'IVA');
        
        // Dibujar encabezados
        foreach($headers as $i => $header) {
            $pdf->Cell($w[$i], 7, $header, 0, 0, 'C');
        }
        $pdf->Ln();

        // Variables para totales
        $totalGral = 0;
        $totalExentas = 0;
        $totalGravadas = 0;

        // Contenido de la tabla
        $pdf->SetFont('Arial', '', 8);
        foreach ($datosComprobante as $index => $dato) {
            $startY = $pdf->GetY();
            $descripcion = utf8_decode($dato['descripcion']);
            
            // Calcular altura necesaria usando GetStringWidth (método estándar de FPDF)
            $lineHeight = 4;
            $cellWidth = $w[7];
            $textWidth = $pdf->GetStringWidth($descripcion);
            $lines = ceil($textWidth / $cellWidth);
            $height = max($lineHeight * $lines, 5);

            // Nueva página si es necesario
            if($pdf->GetY() + $height > $pdf->GetPageHeight() - 30) {
                $pdf->AddPage();
                foreach($headers as $i => $header) {
                    $pdf->Cell($w[$i], 7, $header, 0, 0, 'C');
                }
                $pdf->Ln();
                $startY = $pdf->GetY();
            }

            // Calcular montos
            $monto = $dato['cantidad'] * $dato['preciounit'];
            $totalGral += $monto;
            $totalExentas += $dato['exenta'];
            $totalGravadas += $dato['gravada'];
            
            // Imprimir fila
            $pdf->Cell($w[0], $height, ($index + 1), 0, 0, 'C');
            $pdf->Cell($w[1], $height, '1', 0, 0, 'C'); // Tipo - valor por defecto
            $pdf->Cell($w[2], $height, $dato['programa_codigo'] ? $dato['programa_codigo'] : '01-01', 0, 0, 'C'); // Prog./Sub
            $pdf->Cell($w[3], $height, $dato['objeto_codigo'] ? $dato['objeto_codigo'] : '242', 0, 0, 'C'); // Obj
            $pdf->Cell($w[4], $height, $dato['ff_codigo'] ? $dato['ff_codigo'] : '10', 0, 0, 'C'); // FF
            $pdf->Cell($w[5], $height, $dato['of_codigo'] ? $dato['of_codigo'] : '01', 0, 0, 'C'); // Org
            $pdf->Cell($w[6], $height, '0', 0, 0, 'C'); // Dpto - valor por defecto
            
            // Descripción multilínea
            $currentX = $pdf->GetX();
            $currentY = $pdf->GetY();
            $pdf->MultiCell($w[7], $lineHeight, $descripcion, 0, 'L');
            
            // Restaurar posición
            $pdf->SetXY($currentX + $w[7], $currentY);
            
            $pdf->Cell($w[8], $height, $dato['cantidad'], 0, 0, 'C');
            $pdf->Cell($w[9], $height, number_format($dato['preciounit'], 0), 0, 0, 'R');
            $pdf->Cell($w[10], $height, number_format($dato['exenta'], 0), 0, 0, 'R');
            $pdf->Cell($w[11], $height, number_format($dato['gravada'], 0), 0, 0, 'R');
            $pdf->Cell($w[12], $height, $dato['porcentaje_iva'] . '%', 0, 1, 'C');
        }

        // Línea separadora antes de los totales
        $pdf->SetY($pdf->GetY() + 5);
        $pdf->Line(10, $pdf->GetY(), 200, $pdf->GetY());
        $pdf->SetY($pdf->GetY() + 5);
        
        // Totales
        $pdf->SetFont('Arial', 'B', 8);
        
        // Calcular posición para totales (debajo de cantidad, precios y exentas)
        $totalX = 10 + array_sum(array_slice($w, 0, 8)); // Suma hasta la columna de exentas
        
        // Total Comprobante (exentas + gravadas)
        $totalComprobante = $totalExentas + $totalGravadas;
        $pdf->SetXY($totalX, $pdf->GetY());
        $pdf->Cell($w[10] + $w[11], 6, 'Total Comprobante:', 0, 0, 'R');
        $pdf->Cell($w[12], 6, number_format($totalComprobante, 0), 0, 1, 'R');
        
        // Total General
        $pdf->SetXY($totalX, $pdf->GetY());
        $pdf->Cell($w[10] + $w[11], 6, 'Total General:', 0, 0, 'R');
        $pdf->Cell($w[12], 6, number_format($totalGral, 0), 0, 1, 'R');

        $pdf->Output('Comprobante_Solicitud_' . $id_pedido . '.pdf', 'I');
    }
} 