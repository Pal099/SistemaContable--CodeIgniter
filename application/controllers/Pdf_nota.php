<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pdf_nota extends CI_Controller
{
    public function generarPDF_nota($id_pedido)
    {
        // Incluir la librería FPDF
        require_once APPPATH . 'third_party/fpdf/fpdf.php';

        // Cargar el modelo
        $this->load->model("Pdf_model");
        $datosComprobante = $this->Pdf_model->obtenerDatosPedido($id_pedido);

        if (empty($datosComprobante)) {
            show_error('No se encontraron datos para el comprobante especificado.');
            return;
        }

        // Crear un nuevo objeto FPDF
        $pdf = new FPDF();
        $pdf->AddPage('P', 'legal', 0);
        $pdf->SetFont('Arial', 'B', 12);

        // Obtener nombre de usuario y unidad académica
        $nombreUsuario = $this->session->userdata('Nombre_usuario');
        $unidadAcademica = $this->Pdf_model->obtenerUnidadAcademicaPorNombreUsuario($nombreUsuario);

        // Encabezado con el logo y el título
        $pdf->Image('assets/img/logoUNE.png', 35, 3, 25);
        $pdf->SetFont('Arial', 'B', 15);
        $pdf->Cell(0, 10, utf8_decode('28-2 Universidad Nacional del Este'), 0, 1, 'C');
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(0, 10, utf8_decode('GESTION ADMINISTRATIVA RECTORADO - UNE'), 0, 1, 'C');
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(0, 20, utf8_decode('NOTA DE RECEPCIÓN - PRIOVEEDORES'), 0, 1, 'C');

        // Año actual
        $year = date('Y');
        $pdf->SetXY(160, 35);
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(30, 10, utf8_decode('Nro.: ') . $id_pedido . '/' . $year, 1, 0, 'L');

        // Información general en formato de tabla
        $pdf->SetY(55);
        $pdf->SetFont('Arial', 'B', 10);

       
        // Pie del cuadro
        $pdf->SetXY(10, 60);
        $pdf->SetFont('Arial', '', 9);
        $pdf->MultiCell(190, 5, utf8_decode(
            "Fecha: " . date('d/m/Y') . "\n\n" . // Agregar la fecha actual
            "Por la presente, se deja constancia de haber recepcionado los bienes y/o servicios descritos más abajo, correspondientes a: VENTSERV S.R.L. RUC80077381-O, conforme a las especificaciones técnicas ofertadas y contratadas:\n\n" .
            "Procedimiento / Adjudicación:\n\n" .
            "Listado de Bienes y/o Servicios Recepcionados:"
        ), 0, 'L');
        


    // Inicializar acumulador para el total de la columna "Monto" (nontoi)
$totalGral = 0;

// Encabezado de la tabla de items (con bordes)
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(10, 7, 'Item', 1); // Con borde
$pdf->Cell(90, 7, utf8_decode('Descripción'), 1); // Ancho ajustado
$pdf->Cell(30, 7, 'Cantidad', 1); // Con borde
$pdf->Cell(30, 7, 'Precio', 1); // Con borde
$pdf->Cell(30, 7, 'Monto', 1); // Con borde
$pdf->Ln();

// Rellenar la tabla con los datos de los items (sin líneas)
$pdf->SetFont('Arial', '', 8);

$lineHeight = 4; // Reducir la altura de la línea estándar

foreach ($datosComprobante as $index => $dato) {
    // Obtener la descripción en UTF-8
    $descripcion = utf8_decode($dato['descripcion']);

    // Calcular la altura máxima de la fila (depende de la descripción)
    $cellHeightDescripcion = $pdf->GetStringWidth($descripcion) / 90; // Ancho máximo de la celda de descripción (90)
    $cellHeightDescripcion = ceil($cellHeightDescripcion) * $lineHeight; // Ajustar a múltiplos de la altura de línea

    // Obtener la altura máxima entre las celdas (8 es la nueva altura base)
    $maxHeight = max(8, $cellHeightDescripcion); // Reducir la altura base

    // Posición inicial de la fila
    $currentY = $pdf->GetY();

    // Celda para "Item" (con paréntesis y sin bordes)
    $pdf->MultiCell(10, $maxHeight, ($index + 1) . ')', 0, 'C', false);
    $pdf->SetXY(20, $currentY); // Ajustar la posición de la siguiente celda

    // Celda para "Descripción" (sin bordes)
    $pdf->MultiCell(90, $lineHeight, $descripcion, 0, 'L', false);
    $pdf->SetXY(110, $currentY); // Ajustar la posición de la siguiente celda

    // Celda para "Cantidad Solicitada" (sin bordes)
    $pdf->MultiCell(30, $maxHeight, $dato['cantidad'], 0, 'C', false);
    $pdf->SetXY(140, $currentY); // Ajustar la posición de la siguiente celda

    // Celda para "Precio Referencial" (sin bordes)
    $pdf->MultiCell(30, $maxHeight, number_format($dato['preciounit'], 0), 0, 'C', false);
    $pdf->SetXY(170, $currentY); // Ajustar la posición de la siguiente celda

    // Celda para "Monto" (sin bordes)
    $pdf->MultiCell(30, $maxHeight, number_format($dato['gravada'], 0), 0, 'C', false);

    // Acumular el total general de la columna "Monto"
    $totalGral += $dato['gravada'];

    // Mover el puntero a la siguiente línea con menor espacio
    $pdf->Ln(2); // Reducir el espacio entre filas
}

// Agregar la línea de total general
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(190, 7, 'Total Gral.: ' . number_format($totalGral, 0), 0, 0, 'R'); // Texto "Total Gral." y total en la última celda
$pdf->Ln(10); // Espacio antes de las firmas

// Agregar las líneas de título para las firmas
$pdf->SetFont('Arial', 'B', 8);
$signatureWidth = 47.5; // Ancho de cada columna de firmas

$pdf->Cell($signatureWidth, 10, 'Firma Ordenador:', 1, 0, 'C');
$pdf->Cell($signatureWidth, 10, 'Auditoria Interna:', 1, 0, 'C');
$pdf->Cell($signatureWidth, 10, 'Registro Presupuesto:', 1, 0, 'C');
$pdf->Cell($signatureWidth, 10, 'Recibi Conforme:', 1, 1, 'C'); // La última celda hace un salto de línea

// Agregar las celdas para las firmas debajo de los títulos
$pdf->SetFont('Arial', '', 8);
$pdf->Cell($signatureWidth, 20, '', 1, 0, 'C'); // Celda para "Firma Ordenador"
$pdf->Cell($signatureWidth, 20, '', 1, 0, 'C'); // Celda para "Auditoria Interna"
$pdf->Cell($signatureWidth, 20, '', 1, 0, 'C'); // Celda para "Registro Presupuesto"
$pdf->Cell($signatureWidth, 20, '', 1, 1, 'C'); // Celda para "Recibi Conforme"

        // Generar y enviar el PDF
        $pdf->Output('Orden_Servicio_' . $id_pedido . '.pdf', 'I');
    }
}
