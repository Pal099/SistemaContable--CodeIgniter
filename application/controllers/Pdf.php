<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pdf extends CI_Controller {

	public function index()
	{
	     $datos['titulo'] = 'Reporte de Obligaciones';
	     $this->load->view('layouts/header');
	     $this->load->view('fpdf');
	     //$this->load->view('layouts/footer');
	}
	public function generarPDFS()
{
    require_once APPPATH . 'third_party/fpdf/fpdf.php';
    
    $this->load->model("Pdf_model");

    $data = $this->Pdf_model->obtenerDatos();
    $pdf = new FPDF();
    $pdf->AddPage();

    // Agregar un logotipo (si tienes uno)
    $pdf->SetFont('Arial', 'B', 18);
    $pdf->Cell(200, 10, 'Universidad Nacional del Este', 0, 1, 'C');
    $pdf->Ln();
    $pdf->Image('assets/img/logoUNE.png', 38, 10, 20);


    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(200, 5, '------------------------------------Orden de Pago Nro:  ----------------------------------------------------', 0, 1, 'C');
    $pdf->Ln();

 
    // ...

$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(210, -40, 'Campus Km 8 Acaray, Calle Universidad Nacional del Este y Rca. del Paraguay ', 0, 1, 'C');

// Establecer la posición X en el mismo nivel horizontal que la celda anterior
$pdf->SetX(15);

$pdf->Cell(205, 48, 'Barrio San Juan Ciudad del Este Alto Parana - Paraguay - Telefax: +595 61575478/80 ', 0, 5, 'C');
$pdf->Ln();

// ...


    // Establece la posición Y para el comienzo de la tabla
    $pdf->SetY(42);
    $pdf->SetX(13);

    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(25, 6, 'Asiento ', 1);
    $pdf->Cell(40, 6, 'Comprobante ', 1);
    $pdf->Cell(30, 6, 'Debe ', 1);
    $pdf->Cell(30, 6, 'Haber ', 1);
    $pdf->Cell(35, 6, 'Objeto de Gasto', 1);
    $pdf->Cell(29, 6, 'Descripcion', 1);
    $pdf->Ln();

    $pdf->SetFont('Arial', '', 12);

    foreach ($data as $row) {
        $pdf->SetX(13); // Reinicia la posición X para cada fila
        $pdf->Cell(25, 6, $row['numero'], 1);
        $pdf->Cell(40, 6, $row['comprobante'], 1);
        $pdf->Cell(30, 6, $row['Debe'], 1);
        $pdf->Cell(30, 6, $row['Haber'], 1);
        
        $pdf->Ln();
    }

    $pdf->Output();
}


}




