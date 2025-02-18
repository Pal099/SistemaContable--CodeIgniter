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
        $fecha = date('d/m/y', strtotime($datosComprobante[0]['fecha']));

        // Información en el cuadro
        $pdf->SetXY(12, 47);
        $pdf->Cell(45, 5, 'Fecha: ' . $fecha, 0, 0);
        $pdf->Cell(80, 5, 'Proveedor: ' . utf8_decode($datosComprobante[0]['proveedor']), 0, 0);
        $pdf->Cell(60, 5, 'RUC: ' . $datosComprobante[0]['ruc'], 0, 1);

        $pdf->SetXY(12, 52);
        $pdf->Cell(45, 5, 'Nro. Comprobante: 001-001-0001275', 0, 0);
        $pdf->Cell(80, 5, 'Obs.: 242 - Mantenimiento y Reparaciones', 0, 1);

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
            $pdf->Cell($w[$i], 7, $header, 1, 0, 'C');
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
            
            // Calcular altura necesaria
            $lineHeight = 4;
            $lines = $pdf->NbLines($w[7], $descripcion);
            $height = max($lineHeight * $lines, 5);

            // Nueva página si es necesario
            if($pdf->GetY() + $height > $pdf->GetPageHeight() - 30) {
                $pdf->AddPage();
                foreach($headers as $i => $header) {
                    $pdf->Cell($w[$i], 7, $header, 1, 0, 'C');
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
            $pdf->Cell($w[0], $height, ($index + 1), 1, 0, 'C');
            $pdf->Cell($w[1], $height, 'Tipo 1', 1, 0, 'C');
            $pdf->Cell($w[2], $height, 'Prog 1', 1, 0, 'C');
            $pdf->Cell($w[3], $height, 'Obj 1', 1, 0, 'C');
            $pdf->Cell($w[4], $height, 'FF 1', 1, 0, 'C');
            $pdf->Cell($w[5], $height, 'Org 1', 1, 0, 'C');
            $pdf->Cell($w[6], $height, 'Dpto 1', 1, 0, 'C');
            
            // Descripción multilínea
            $currentX = $pdf->GetX();
            $currentY = $pdf->GetY();
            $pdf->MultiCell($w[7], $lineHeight, $descripcion, 1, 'L');
            
            // Restaurar posición
            $pdf->SetXY($currentX + $w[7], $currentY);
            
            $pdf->Cell($w[8], $height, $dato['cantidad'], 1, 0, 'C');
            $pdf->Cell($w[9], $height, number_format($dato['preciounit'], 0), 1, 0, 'R');
            $pdf->Cell($w[10], $height, number_format($dato['exenta'], 0), 1, 0, 'R');
            $pdf->Cell($w[11], $height, number_format($dato['gravada'], 0), 1, 0, 'R');
            $pdf->Cell($w[12], $height, $dato['porcentaje_iva'] . '%', 1, 1, 'C');
        }

        // Totales
        $pdf->SetFont('Arial', 'B', 8);
        $x = $pdf->GetX();
        $y = $pdf->GetY();
        
        // Calcular posición para totales (ajustado para incluir todas las columnas)
        $totalX = $x + array_sum(array_slice($w, 0, 10)); 
        
        // Imprimir totales
        $pdf->SetXY($totalX, $y);
        $pdf->Cell($w[10], 6, 'Total Exentas:', 1, 0, 'R');
        $pdf->Cell($w[11], 6, number_format($totalExentas, 0), 1, 0, 'R');
        $pdf->Cell($w[12], 6, '', 1, 1, 'R'); // Celda vacía para IVA
        
        $pdf->SetXY($totalX, $pdf->GetY());
        $pdf->Cell($w[10], 6, 'Total Gravadas:', 1, 0, 'R');
        $pdf->Cell($w[11], 6, number_format($totalGravadas, 0), 1, 0, 'R');
        $pdf->Cell($w[12], 6, '', 1, 1, 'R'); // Celda vacía para IVA
        
        $pdf->SetXY($totalX, $pdf->GetY());
        $pdf->Cell($w[10], 6, 'Total General:', 1, 0, 'R');
        $pdf->Cell($w[11] + $w[12], 6, number_format($totalGral, 0), 1, 1, 'R'); // Combinamos las últimas dos celdas

        $pdf->Output('Comprobante_Solicitud_' . $id_pedido . '.pdf', 'I');
    }

    // Función auxiliar para calcular número de líneas
    private function NbLines($w, $txt) {
        $cw = &$this->CurrentFont['cw'];
        if($w==0)
            $w = $this->w-$this->rMargin-$this->x;
        $wmax = ($w-2*$this->cMargin)*1000/$this->FontSize;
        $s = str_replace("\r",'',$txt);
        $nb = strlen($s);
        if($nb>0 && $s[$nb-1]=="\n")
            $nb--;
        $sep = -1;
        $i = 0;
        $j = 0;
        $l = 0;
        $nl = 1;
        while($i<$nb) {
            $c = $s[$i];
            if($c=="\n") {
                $i++;
                $sep = -1;
                $j = $i;
                $l = 0;
                $nl++;
                continue;
            }
            if($c==' ')
                $sep = $i;
            $l += $cw[$c];
            if($l>$wmax) {
                if($sep==-1) {
                    if($i==$j)
                        $i++;
                }
                else
                    $i = $sep+1;
                $sep = -1;
                $j = $i;
                $l = 0;
                $nl++;
            }
            else
                $i++;
        }
        return $nl;
    }
}