<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pdf extends CI_Controller {

    public function index()
    {
        $this->load->model("Pdf_model"); // Load the model firsta
        $datos['titulo'] = 'Reporte de Obligaciones';
        $datos['ultimosDatos'] = $this->Pdf_model->obtenerDatosSu();
        $this->load->view('layouts/header');
        $this->load->view('fpdf', $datos);
        
        //$this->load->view('layouts/footer');
    }

    public function generarPDFS()
    {
        require_once APPPATH . 'third_party/fpdf/fpdf.php';
    
        $this->load->model("Pdf_model"); // Load the model first
        $pdf = new FPDF();
        $datosProveedor = $this->Pdf_model->obtenerDatosSu();
        $pdf->AddPage('P','legal',0);
       $pdf->SetFont('Arial','B',12);    
       $textypos = 5;
       $nombreUsuario = $this->session->userdata('Nombre_usuario');
        $unidadAcademica = $this->Pdf_model->obtenerUnidadAcademicaPorNombreUsuario($nombreUsuario);





// Ajusta la posición vertical del título
$pdf->SetY(10);

$pdf->setX(15);
// Agregamos los datos de la empresa
$pdf->Image('assets/img/logoUNE.png', 10, 10, 25);
$pdf->SetFont('Arial', 'B', 18);
$pdf->Cell(0, 25, 'GESTION ADMINISTRATIVA', 0, 1, 'C');
$pdf->SetFont('Arial', 'B', 15);
$pdf->Cell(0, 3, 'RECTORADO UNE ', 0, 1, 'C');
$pdf->SetFont('Arial', 'B', 15);
$pdf->Cell(0, 10, 'Retenciones Detalladas ', 0, 1, 'C');
         
       

    //Rectangulo para el encabezado
    $pdf->setY(55);
    $pdf->setX(5);
    $pdf->Rect(6,$pdf->GetY(), 204, 60);
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Ln();

      

    //Rectangulo pequeño
    $pdf->setY(118);
    $pdf->setX(10);
    $pdf->Rect(6,$pdf->GetY(), 204, 10);
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Ln();




     
         //----------------//------------------------------------

    //Rectangulo total
    $pdf->setY(130);
    $pdf->setX(6);
    $pdf->Rect(6,$pdf->GetY(), 204, 65);
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Ln();

    
$pdf->SetFont('Arial', 'B', 12);
$pdf->setY(60);
$pdf->setX(7);
$pdf->Cell(5, $textypos, "Razon Social:");
//-----------------------//-------------------------------------------------
$pdf->SetFont('Arial', '', 12);  // Sin negrita para los datos de la base de datos
$pdf->setY(60);
$pdf->setX(36);
$pdf->Cell(5, $textypos, "28-02 ");
//----------------------------//----------------------------------------
$pdf->SetFont('Arial', 'B', 12);
$pdf->setY(67);
$pdf->setX(7);
$pdf->Cell(5, $textypos, "RUC:");
//-----------------------//-------------------------------------------------
$pdf->SetFont('Arial', '', 12);
        $pdf->setY(67);
        $pdf->setX(19);
        $pdf->Cell(5, $textypos, $unidadAcademica);

//----------------------------//----------------------------------------
$pdf->SetFont('Arial', 'B', 12);
$pdf->setY(74);
$pdf->setX(7);
$pdf->Cell(5, $textypos, "Direccion:");
//-----------------------//-------------------------------------------------
$pdf->SetFont('Arial', '', 12);  // Sin negrita para los datos de la base de datos
$pdf->setY(74);
$pdf->setX(29);
$pdf->Cell(5, $textypos, $datosProveedor[0]['ruc']);

//----------------------------//----------------------------------------
$pdf->SetFont('Arial', 'B', 12);
$pdf->setY(81);
$pdf->setX(7);
$pdf->Cell(5, $textypos, "ID:");
//-----------------------//-------------------------------------------------
$pdf->SetFont('Arial', '', 12);  // Sin negrita para los datos de la base de datos
$pdf->setY(81);
$pdf->setX(14);
$pdf->Cell(5, $textypos, $datosProveedor[0]['ruc']);

$pdf->SetFont('Arial', 'B', 12);
$pdf->setY(88);
$pdf->setX(7);
$pdf->Cell(5, $textypos, "RUBRO:");
//-----------------------//-------------------------------------------------
$pdf->SetFont('Arial', '', 12);  // Sin negrita para los datos de la base de datos
$pdf->setY(88);
$pdf->setX(25);
$pdf->Cell(5, $textypos, $datosProveedor[0]['ruc']);

//----------------------------//----------------------------------------


//----------------------------//----------------------------------------
$pdf->SetFont('Arial', 'B', 12);
$pdf->setY(60);
$pdf->setX(120);
$pdf->Cell(5, $textypos, utf8_decode("Nro. de Factura:"));
//-----------------------//-------------------------------------------------
$pdf->SetFont('Arial', '', 12);  // Sin negrita para los datos de la base de datos
$pdf->setY(60);
$pdf->setX(154);
$pdf->Cell(5, $textypos, $datosProveedor[0]['ruc']);

//----------------------------//----------------------------------------
$pdf->SetFont('Arial', 'B', 12);
$pdf->setY(67);
$pdf->setX(120);
$pdf->Cell(5, $textypos, "Fecha:");
//-----------------------//-------------------------------------------------
$pdf->SetFont('Arial', '', 12);  // Sin negrita para los datos de la base de datos
$pdf->setY(67);
$pdf->setX(140);
$pdf->Cell(5, $textypos, $datosProveedor[0]['fecha']);

//----------------------------//----------------------------------------
$pdf->SetFont('Arial', 'B', 12);
$pdf->setY(74);
$pdf->setX(120);
$pdf->Cell(5, $textypos, "CC Nro.:");
//-----------------------//-------------------------------------------------
$pdf->SetFont('Arial', '', 12);  // Sin negrita para los datos de la base de datos
$pdf->setY(74);
$pdf->setX(138);
$pdf->Cell(5, $textypos, $datosProveedor[0]['ruc']);

//----------------------------//----------------------------------------
$pdf->SetFont('Arial', 'B', 12);
$pdf->setY(81);
$pdf->setX(120);
$pdf->Cell(5, $textypos, "Periodo:");
//-----------------------//-------------------------------------------------
$pdf->SetFont('Arial', '', 12);  // Sin negrita para los datos de la base de datos
$pdf->setY(81);
$pdf->setX(138);
$pdf->Cell(5, $textypos, "2024");



//----------------------------//----------------------------------------
$pdf->SetFont('Arial', 'B', 12);
$pdf->setY(88);
$pdf->setX(120);
$pdf->Cell(5, $textypos, "Monto de La Factura:");

$pdf->SetFont('Arial', '', 12);
$pdf->setY(88);
$pdf->setX(165);
$pdf->Cell(5, $textypos, "2024");

//-----------------//----------------------------------------------------

$pdf->SetFont('Arial', 'B', 12);
$pdf->setY(95);
$pdf->setX(120);
$pdf->Cell(5, $textypos, "A Ejecutar:");

$pdf->SetFont('Arial', 'B', 12);
$pdf->setY(102);
$pdf->setX(120);
$pdf->Cell(5, $textypos, "Total IVA:");

$pdf->SetFont('Arial', '', 12);
$pdf->setY(102);
$pdf->setX(141);
$pdf->Cell(5, $textypos, "2024");


if (isset($datosProveedor['tipo'])) {
$pdf->SetFont('Arial', '', 12);  // tipo
$texto = $datosProveedor['tipo'];
$pdf->setY(105);
$pdf->setX(25);
$pdf->MultiCell(0, 10, utf8_decode($texto), 0, 'J'); // 'J' para justificar
}
//------------------------//-------------------------------------------------

$pdf->SetFont('Arial', 'B', 12);
$pdf->setY(120);
$pdf->setX(10);
$pdf->Cell(5, $textypos, "Tipo de Retencion");



$pdf->SetFont('Arial', 'B', 12);
$pdf->setY(120);
$pdf->setX(80);
$pdf->Cell(5, $textypos, "Base de Retencion");


$pdf->SetFont('Arial', 'B', 12);
$pdf->setY(120);
$pdf->setX(160);
$pdf->Cell(5, $textypos, "Importe del Retencion");


// Contenido del tercer rectángulo
$pdf->SetFont('Arial', '', 10);
$pdf->setY(135);
$pdf->setX(8);
$pdf->Cell(5, $textypos, "Ley de contrataciones publicas");
$pdf->SetFont('Arial', '', 10);
$pdf->setY(141);
$pdf->setX(8);
$pdf->Cell(5, $textypos, utf8_decode( "Ley 6486/2020 Proteccion de los derechos de los niños"));
$pdf->SetFont('Arial', '', 10);
$pdf->setY(147);
$pdf->setX(8);
$pdf->Cell(5, $textypos, "Ley 5777 / 2016 de la proteccion integra la las mujeres");
$pdf->SetFont('Arial', '', 10);
$pdf->setY(153);
$pdf->setX(8);
$pdf->Cell(5, $textypos, "Retencion Ley 2051/03");
$pdf->SetFont('Arial', '', 10);
$pdf->setY(159);
$pdf->setX(8);
$pdf->Cell(5, $textypos, "Retencion Renta");
$pdf->SetFont('Arial', '', 10);
$pdf->setY(165);
$pdf->setX(8);
$pdf->Cell(5, $textypos, "Retencion IVA");

// Valores y espacios
$pdf->SetFont('Arial', '', 10);
$pdf->setY(135);
$pdf->setX(100);
$pdf->Cell(5, $textypos, "0,05");
$pdf->SetFont('Arial', '', 10);
$pdf->setY(141);
$pdf->setX(100);
$pdf->Cell(5, $textypos, "0,05");
$pdf->SetFont('Arial', '', 10);
$pdf->setY(147);
$pdf->setX(100);
$pdf->Cell(5, $textypos, "0,05");
$pdf->SetFont('Arial', '', 10);
$pdf->setY(153);
$pdf->setX(100);
$pdf->Cell(5, $textypos, "0,5");
$pdf->SetFont('Arial', '', 10);
$pdf->setY(159);
$pdf->setX(100);
$pdf->Cell(5, $textypos, "3");
$pdf->SetFont('Arial', '', 10);
$pdf->setY(165);
$pdf->setX(100);
$pdf->Cell(5, $textypos, "30");

//-------------------------------------//-----------------------------------------

        $pdf->Output( 'I' );
   }


    
    
    
}