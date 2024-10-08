<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pdf extends CI_Controller
{
    public function generarPDFS($idComprobanteGasto)
    {
        require_once APPPATH . 'third_party/fpdf/fpdf.php';

        $this->load->model("Pdf_model");
        $datosComprobante = $this->Pdf_model->obtenerDatosComprobanteGasto($idComprobanteGasto);

        if (empty($datosComprobante)) {
            show_error('No se encontraron datos para el comprobante especificado.');
            return;
        }

        $pdf = new FPDF();
        $pdf->AddPage('P', 'legal', 0);
        $pdf->SetFont('Arial', 'B', 12);

        // Encabezado
        $pdf->Image('assets/img/logoUNE.png', 10, 10, 25);
        $pdf->Cell(0, 10, 'Universidad Nacional del Este', 0, 1, 'C');
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(0, 10, 'Comprobante de Gasto', 0, 1, 'C');

        // Información del comprobante
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(50, 10, 'Fecha:', 0);
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(0, 10, $datosComprobante[0]['fecha'], 0, 1);

        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(50, 10, 'Proveedor:', 0);
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(0, 10, $datosComprobante[0]['proveedor'], 0, 1);

        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(50, 10, 'RUC:', 0);
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(0, 10, $datosComprobante[0]['ruc'], 0, 1);

        // Tabla de datos
        $pdf->Ln(10);
        $pdf->SetFont('Arial', 'B', 8);

        // Encabezados de la tabla
        $pdf->Cell(10, 7, 'Item', 1, 0, 'C');
        $pdf->Cell(70, 7, 'Descripcion', 1, 0, 'C');
        $pdf->Cell(20, 7, 'Cantidad', 1, 0, 'C');
        $pdf->Cell(25, 7, 'Precio Unit.', 1, 0, 'C');
        $pdf->Cell(20, 7, 'IVA', 1, 0, 'C');
        $pdf->Cell(20, 7, 'Exenta', 1, 0, 'C');
        $pdf->Cell(25, 7, 'Gravada', 1, 1, 'C');

        // Datos de la tabla
        $pdf->SetFont('Arial', '', 8);
        $total = 0;
        foreach ($datosComprobante as $index => $dato) {
            $pdf->Cell(10, 6, $index + 1, 1, 0, 'C');
            $pdf->Cell(70, 6, substr($dato['descripcion'], 0, 40), 1, 0, 'L');
            $pdf->Cell(20, 6, $dato['cantidad'], 1, 0, 'R');
            $pdf->Cell(25, 6, number_format($dato['preciounit'], 2), 1, 0, 'R');
            $pdf->Cell(20, 6, $dato['porcentaje_iva'] . '%', 1, 0, 'C');
            $pdf->Cell(20, 6, number_format($dato['exenta'], 2), 1, 0, 'R');
            $pdf->Cell(25, 6, number_format($dato['gravada'], 2), 1, 1, 'R');
            $total += $dato['gravada'] + $dato['exenta'];
        }

        // Total
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(165, 7, 'Total:', 1, 0, 'R');
        $pdf->Cell(25, 7, number_format($total, 2), 1, 1, 'R');

        $pdf->Output('Comprobante_' . $idComprobanteGasto . '.pdf', 'I');
    }
}