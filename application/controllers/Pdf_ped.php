<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pdf_ped extends CI_Controller
{
    public function generarPDF_ped($id_pedido)
    {
        require_once APPPATH . 'third_party/fpdf/fpdf.php';

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

        // Asegúrate de que el texto está en UTF-8
        $nombreUsuario = $this->session->userdata('Nombre_usuario');
        $unidadAcademica = $this->Pdf_model->obtenerUnidadAcademicaPorNombreUsuario($nombreUsuario);

        // Agregamos los datos de la empresa
        $pdf->Image('assets/img/logoUNE.png', 35, 3, 25);
        $pdf->SetFont('Arial', 'B', 15);
        $pdf->Cell(0, 10, utf8_decode('28-2 Universidad Nacional del Este'), 0, 1, 'C');
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(0, 10, utf8_decode('GESTION ADMINISTRATIVA RECTORADO - UNE'), 0, 1, 'C');
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(0, 20, utf8_decode('Pedido Interno - Proveedores'), 0, 1, 'C');


        /// Cuadro pequeño al lado del título con "Nro."
        $pdf->SetXY(160, 35);  // Ajustado más hacia la derecha y arriba
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(30, 10, utf8_decode('Nro.:'), 1, 0, 'L'); // Cuadro con borde y texto

        // Añadiendo tabla de datos generales
        $pdf->SetY(55);
        $pdf->SetFont('Arial', 'B', 10);

        // Crea un cuadro grande que cubra los 3 campos
        $pdf->Cell(190, 30, '', 1, 1, 'L', 0); // Borde exterior grande

        // Dentro del cuadro, puedes usar MultiCell para evitar líneas internas
        $pdf->SetXY(10, 55); // Ajustar la posición para el contenido
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(40, 10, utf8_decode("Fecha Pedido:"), 0, 0, 'L', 0);
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(150, 10, utf8_decode($datosComprobante[0]['fecha']), 0, 1, 'L', 0);

        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(40, 10, utf8_decode("Dependencia Solicitante:"), 0, 0, 'L', 0);
        $pdf->SetFont('Arial', '', 10);

        // Ajustar la posición de X para mover el contenido más a la izquierda
        $pdf->SetX(55); // Cambia este valor según sea necesario
        $pdf->Cell(150, 10, utf8_decode($datosComprobante[0]['ruc']), 0, 1, 'L', 0);

        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(40, 10, utf8_decode("Local de salida:"), 0, 0, 'L', 0);
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(150, 10, utf8_decode("Dpto. Suministros"), 0, 1, 'L', 0);

        // Eliminar el Ln() extra para pegar la tabla de ítems
        // $pdf->Ln();
// Encabezado de la tabla de items (con bordes)
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(10, 7, 'Item', 1); // Con borde
$pdf->Cell(20, 7, utf8_decode('Código'), 1); // Con borde
$pdf->Cell(70, 7, utf8_decode('Descripción'), 1); // Con borde
$pdf->Cell(30, 7, 'Cantidad Solicitada', 1); // Con borde
$pdf->Cell(30, 7, 'Precio Referencial', 1); // Con borde
$pdf->Cell(30, 7, 'Cantidad Entregada', 1); // Con borde
$pdf->Ln();

// Rellenar la tabla con los datos de los items (sin líneas)
$pdf->SetFont('Arial', '', 8);

$lineHeight = 4; // Reducir la altura de la línea estándar

foreach ($datosComprobante as $index => $dato) {
    // Obtener la descripción en UTF-8
    $descripcion = utf8_decode($dato['descripcion']);

    // Calcular la altura máxima de la fila (depende de la descripción)
    $cellHeightDescripcion = $pdf->GetStringWidth($descripcion) / 70; // Ancho máximo de la celda de descripción (70)
    $cellHeightDescripcion = ceil($cellHeightDescripcion) * $lineHeight; // Ajustar a múltiplos de la altura de línea

    // Obtener la altura máxima entre las celdas (8 es la nueva altura base)
    $maxHeight = max(8, $cellHeightDescripcion); // Reducir la altura base

    // Posición inicial de la fila
    $currentY = $pdf->GetY();

    // Celda para "Item" (con paréntesis y sin bordes)
    $pdf->MultiCell(10, $maxHeight, ($index + 1) . ')', 0, 'C', false);
    $pdf->SetXY(20, $currentY); // Ajustar la posición de la siguiente celda

    // Celda para "Código" (sin bordes)
    $pdf->MultiCell(20, $maxHeight, number_format($dato['exenta'], 2), 0, 'C', false);
    $pdf->SetXY(40, $currentY); // Ajustar la posición de la siguiente celda

    // Celda para "Descripción" (sin bordes)
    $pdf->MultiCell(70, $lineHeight, $descripcion, 0, 'L', false);
    $pdf->SetXY(110, $currentY); // Ajustar la posición de la siguiente celda

    // Celda para "Cantidad Solicitada" (sin bordes)
    $pdf->MultiCell(30, $maxHeight, $dato['cantidad'], 0, 'C', false);
    $pdf->SetXY(140, $currentY); // Ajustar la posición de la siguiente celda

    // Celda para "Precio Referencial" (sin bordes)
    $pdf->MultiCell(30, $maxHeight, number_format($dato['preciounit'], 2), 0, 'C', false);
    $pdf->SetXY(170, $currentY); // Ajustar la posición de la siguiente celda

    // Celda para "Cantidad Entregada" (sin bordes)
    $pdf->MultiCell(30, $maxHeight, $dato['cantidad'], 0, 'C', false);

    // Mover el puntero a la siguiente línea con menor espacio
    $pdf->Ln(2); // Reducir el espacio entre filas
}





        // Texto adicional debajo de la tabla
        $pdf->Ln(10); // Espacio entre la tabla y el texto
        $pdf->SetFont('Arial', 'I', 10);
        $pdf->MultiCell(0, 10, utf8_decode("Por la presente, declaramos haber recibidos bienes/servicios mencionados más arriba:"), 0, 'C');

        // Firmas
        $pdf->Ln(10); // Espacio entre el texto y las firmas
        $pdf->Cell(60, 10, utf8_decode("Fecha:"), 0);
        $pdf->Cell(60, 10, utf8_decode("Firma solicitante:"), 0);
        $pdf->Cell(60, 10, utf8_decode("Firma Enc. Suministros:"), 0);
        $pdf->Ln(20); // Espacio para las firmas

        $pdf->Output('Reporte Pago Obligacion.pdf', 'I');
    }
}
