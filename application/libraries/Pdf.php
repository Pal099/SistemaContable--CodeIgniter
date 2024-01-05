<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once dirname(__FILE__).'/tcpdf/tcpdf.php';
require('fpdf.php');
class Pdf  extends TCPDF{
// por defecto, usaremos papel A4 en vertical, salvo que digamos otra cosa al momento de generar un PDF
 function  __construct() {
    parent::__construct();
    $this->load->model("Pdf_model");
  }
  
  
  
  public function generarPDF() {
    $this->load->model("Pdf_model"); // Asegúrate de cargar el modelo de tu base de datos

    // Obtén los datos de tu base de datos (en este caso, desde el modelo)
    $data = $this->Pdf_model->obtenerDatos();

    // Configura el encabezado de la página
    $pdf = new FPDF();
    $pdf->AddPage();
    $pdf->SetFont('Arial', 'B', 12);

    // Títulos de las columnas
    $pdf->Cell(40, 10, 'Columna 1', 1);
    $pdf->Cell(40, 10, 'Columna 2', 1);
    $pdf->Cell(40, 10, 'Columna 3', 1);
    $pdf->Ln(); // Nueva línea

    // Agrega los registros desde la base de datos
    foreach($data as $row) {
        $pdf->Cell(40, 10, $row['columna1'], 1);
        $pdf->Cell(40, 10, $row['columna2'], 1);
        $pdf->Cell(40, 10, $row['columna3'], 1);
        $pdf->Ln(); // Nueva línea
    }

    $pdf->Output();
}
}
?>
