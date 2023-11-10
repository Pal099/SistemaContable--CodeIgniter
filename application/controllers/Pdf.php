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
    $pdf->SetFont('Arial', 'B', 12);

    $pdf->Cell(190, 40, 'Reporte de Datos Obligaciones', 0, 1, 'C');
    $pdf->Ln(10);

    // Agregar un logotipo (si tienes uno)
    $pdf->Image('assets/img/logo_sistema.jpg', -8, 0, 230);

    // Establece la posición Y para el comienzo de la tabla
    $pdf->SetY(35);
    $pdf->SetX(35);

    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(25, 6, 'Asiento ', 1);
    $pdf->Cell(40, 6, 'Comprobante ', 1);
    $pdf->Cell(30, 6, 'Debe ', 1);
    $pdf->Cell(30, 6, 'Haber ', 1);
    
    // Nuevas columnas para "Objeto de Gasto" y "Descripción"
    $pdf->Cell(35, 6, 'Objeto de Gasto', 1);
    $pdf->Cell(29, 6, 'Descripcion', 1);
    $pdf->Ln();

    $pdf->SetFont('Arial', '', 12);

    foreach ($data as $row) {
        $pdf->SetX(35); // Reinicia la posición X para cada fila
        $pdf->Cell(25, 6, $row['numero'], 1);
        $pdf->Cell(40, 6, $row['comprobante'], 1);
        $pdf->Cell(30, 6, $row['Debe'], 1);
        $pdf->Cell(30, 6, $row['Haber'], 1);
        
        $pdf->Ln();
    }

    $pdf->Output();
}


}




