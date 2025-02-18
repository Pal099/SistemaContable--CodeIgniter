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

        // Ancho de columnas
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
            // Calcular montos
            $monto = $dato['cantidad'] * $dato['preciounit'];
            $totalGral += $monto;
            $totalExentas += $dato['exenta'];
            $totalGravadas += $dato['gravada'];
            
            // Imprimir fila
            $pdf->Cell($w[0], 6, ($index + 1), 1, 0, 'C');
            $pdf->Cell($w[1], 6, 'Tipo 1', 1, 0, 'C');
            $pdf->Cell($w[2], 6, 'Prog 1', 1, 0, 'C');
            $pdf->Cell($w[3], 6, 'Obj 1', 1, 0, 'C');
            $pdf->Cell($w[4], 6, 'FF 1', 1, 0, 'C');
            $pdf->Cell($w[5], 6, 'Org 1', 1, 0, 'C');
            $pdf->Cell($w[6], 6, 'Dpto 1', 1, 0, 'C');
            $pdf->Cell($w[7], 6, utf8_decode($dato['descripcion']), 1, 0, 'L');
            $pdf->Cell($w[8], 6, $dato['cantidad'], 1, 0, 'C');
            $pdf->Cell($w[9], 6, number_format($dato['preciounit'], 0), 1, 0, 'R');
            $pdf->Cell($w[10], 6, number_format($dato['exenta'], 0), 1, 0, 'R');
            $pdf->Cell($w[11], 6, number_format($dato['gravada'], 0), 1, 0, 'R');
            $pdf->Cell($w[12], 6, $dato['porcentaje_iva'] . '%', 1, 1, 'C');
        }

        // Totales fuera de la tabla
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Ln(10);
        $pdf->Cell(0, 6, 'Total Exentas: ' . number_format($totalExentas, 0), 0, 1, 'R');
        $pdf->Cell(0, 6, 'Total Gravadas: ' . number_format($totalGravadas, 0), 0, 1, 'R');
        $pdf->Cell(0, 6, 'Total General: ' . number_format($totalGral, 0), 0, 1, 'R');

        $pdf->Output('Comprobante_Solicitud_' . $id_pedido . '.pdf', 'I');
    }
}