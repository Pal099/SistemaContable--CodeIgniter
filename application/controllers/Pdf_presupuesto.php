<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pdf extends CI_Controller {

    public function index()
    {
        $this->load->model("Pdf_model"); // Load the model firsta
        $datos['titulo'] = 'Reporte de Obligaciones';
        $datos['ultimosDatos'] = $this->Pdf_model->obtenerDatos();
        $this->load->view('layouts/header');
        $this->load->view('fpdf', $datos);
        
        //$this->load->view('layouts/footer');
    }

    public function generarPDF_presu()
    {
        require_once APPPATH . 'third_party/fpdf/fpdf.php';
    
        $this->load->model("Pdf_model"); // Load the model first
        $pdf = new FPDF();
        $datosProveedor = $this->Pdf_model->obtenerDatos();
        $pdf->AddPage('P','legal',0);
       $pdf->SetFont('Arial','B',12);    
       $textypos = 5;

// Ajusta la posición vertical del título
$pdf->SetY(3);

$pdf->setX(10);
// Agregamos los datos de la empresa
$pdf->Image('assets/img/logoUNE.png', 40, 3, 25);
$pdf->SetFont('Arial', 'B', 15);
$pdf->Cell(0, 10, 'Universidad Nacional del Este', 0, 1, 'C');
$pdf->SetFont('Arial', 'B', 8);
$pdf->SetY(8);
$pdf->setX(10);
$pdf->Cell(0, 10, 'Campus Km 8 Acaray', 0, 1, 'C');
$pdf->SetY(12);
$pdf->setX(10);
$pdf->Cell(0, 10, 'Calle Universidad Nacional del Este y Rca. del Paraguay', 0, 1, 'C');
$pdf->SetY(16);
$pdf->setX(10);
$pdf->Cell(0, 10, 'Barrio San Juan Ciudad del Este Alto Parana', 0, 1, 'C');
         
       

    // Rectangulo para datos del beneficiario
    $pdf->setY(33);
    $pdf->setX(8);
    $pdf->Rect(6,$pdf->GetY(), 100, 33);
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Ln();
// ...

// Agregamos los datos de la empresa
$pdf->Image('assets/img/logoUNE.png', 40, 3, 25);
$pdf->SetFont('Arial', 'B', 15);
$pdf->Cell(0, 10, 'Universidad Nacional del Este', 0, 1, 'C');
$pdf->SetFont('Arial', 'B', 8);
$pdf->SetY(8);
$pdf->setX(10);
$pdf->Cell(0, 10, 'Campus Km 8 Acaray', 0, 1, 'C');
$pdf->SetY(12);
$pdf->setX(10);
$pdf->Cell(0, 10, 'Calle Universidad Nacional del Este y Rca. del Paraguay', 0, 1, 'C');
$pdf->SetY(16);
$pdf->setX(10);
$pdf->Cell(0, 10, 'Barrio San Juan Ciudad del Este Alto Parana', 0, 1, 'C');

// ...

// Aquí comienza el bucle para iterar a través de los datos de la lista
$datosLista = [
    ['Fecha' => '2022', 'Descripcion' => '415', 'PresupuestoInicial' => '20.000', 'OrigenFinanciamiento' => 'Genuino', 'FuenteFinanciamiento' => 'Tesoro', 'Programa' => '80.000'],
    // Agrega más datos de acuerdo a tu lista
];

foreach ($datosLista as $datos) {
    $pdf->AddPage('P', 'legal', 0);
    // Resto del código para agregar celdas con datos de la lista al PDF
    // Ajusta las coordenadas y celdas según tus necesidades y diseño
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(0, 10, 'Fecha: ' . $datos['Fecha'], 0, 1);
    $pdf->Cell(0, 10, 'Descripcion: ' . $datos['Descripcion'], 0, 1);
    $pdf->Cell(0, 10, 'Presupuesto Inicial: ' . $datos['PresupuestoInicial'], 0, 1);
    // Agrega más celdas según tus datos
}

// ...



//------------------------//-----------------------------------------
$nombreUsuario = $this->session->userdata('Nombre_usuario');

$pdf->SetFont('Arial', 'B', 7);
$pdf->setY(330);
$pdf->setX(187);
$pdf->Cell(5, $textypos, "Usuario: ");


$pdf->SetFont('Arial', 'B', 7);
$pdf->setY(330);
$pdf->setX(198);
$pdf->Cell(5, $textypos, $nombreUsuario);




//-------------------------------------//-----------------------------------------

        $pdf->Output('Reporte Pago Obligacion.pdf' , 'I' );
   }


    
    
    
}