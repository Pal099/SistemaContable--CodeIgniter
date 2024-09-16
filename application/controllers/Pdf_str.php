<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pdf_str extends CI_Controller {

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
       $fuenteFinanciamiento = isset($datosProveedor[0]['fuente_financiamiento']) ? $datosProveedor[0]['fuente_financiamiento'] : 'No disponible';
       $nombreCuenta = $datosProveedor[0]['Descripcion'];


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
$pdf->SetFont('Arial', 'B', 15);
$pdf->Cell(0, 20, 'Solicitud de Tranferencia de Recursos ', 0, 1, 'C');
         
       

    //Rectangulo para el encabezado
    $pdf->setY(52);
    $pdf->setX(5);
    $pdf->Rect(6,$pdf->GetY(), 204, 30);
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Ln();

       //----------------//------------------------------------

    //Rectangulo para importe
    $pdf->setY(90);
    $pdf->setX(10);
    $pdf->Rect(6,$pdf->GetY(), 204, 170);
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Ln();


    //Rectangulo para importe pequeño
    $pdf->setY(90);
    $pdf->setX(10);
    $pdf->Rect(6,$pdf->GetY(), 204, 12);
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Ln();




     //----------------//------------------------------------

    //Rectangulo para total
    $pdf->setY(240);
    $pdf->setX(6);
    $pdf->Rect(6,$pdf->GetY(), 204, 45);
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Ln();
         //----------------//------------------------------------

    //Rectangulo para firmas
    $pdf->setY(285);
    $pdf->setX(6);
    $pdf->Rect(6,$pdf->GetY(), 204, 45);
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Ln();






    
$pdf->SetFont('Arial', 'B', 10);
$pdf->setY(55);
$pdf->setX(7);
$pdf->Cell(5, $textypos, "Entidad:");
//-----------------------//-------------------------------------------------
$pdf->SetFont('Arial', '', 10);  // Sin negrita para los datos de la base de datos
$pdf->setY(55);
$pdf->setX(22);
$pdf->Cell(5, $textypos, "28-02 UNIVERSIDAD NACIONAL DEL ESTE");
//----------------------------//----------------------------------------
$pdf->SetFont('Arial', 'B', 10);
$pdf->setY(60);
$pdf->setX(7);
$pdf->Cell(5, $textypos, "Actividad:");
//-----------------------//-------------------------------------------------
$pdf->SetFont('Arial', '', 10);
        $pdf->setY(60);
        $pdf->setX(25);
        $pdf->Cell(5, $textypos, $unidadAcademica);

//----------------------------//----------------------------------------
$pdf->SetFont('Arial', 'B', 10);
$pdf->setY(65);
$pdf->setX(7);
$pdf->Cell(5, $textypos, "Unidad responsable:");
//-----------------------//-------------------------------------------------
$pdf->SetFont('Arial', '', 10);  // Sin negrita para los datos de la base de datos
$pdf->setY(65);
$pdf->setX(43);
$pdf->Cell(5, $textypos, $datosProveedor[0]['ruc']);

//----------------------------//----------------------------------------
$pdf->SetFont('Arial', 'B', 10);
$pdf->setY(70);
$pdf->setX(7);
$pdf->Cell(5, $textypos, "Financiamiento:");
//-----------------------//-------------------------------------------------
$pdf->SetFont('Arial', '', 10);  // Sin negrita para los datos de la base de datos
$pdf->setY(70);
$pdf->setX(34);
$pdf->Cell(5, $textypos,  $fuenteFinanciamiento);

//----------------------------//----------------------------------------


//----------------------------//----------------------------------------
$pdf->SetFont('Arial', 'B', 10);
$pdf->setY(55);
$pdf->setX(105);
$pdf->Cell(5, $textypos, utf8_decode("Fecha de recepción:"));
//-----------------------//-------------------------------------------------
$pdf->SetFont('Arial', '', 10);  // Sin negrita para los datos de la base de datos
$pdf->setY(55);
$pdf->setX(140);
$pdf->Cell(5, $textypos, $datosProveedor[0]['ruc']);

//----------------------------//----------------------------------------
$pdf->SetFont('Arial', 'B', 10);
$pdf->setY(60);
$pdf->setX(105);
$pdf->Cell(5, $textypos, "Doc. nro.:");
//-----------------------//-------------------------------------------------
$pdf->SetFont('Arial', '', 10);  // Sin negrita para los datos de la base de datos
$pdf->setY(60);
$pdf->setX(130);
$pdf->Cell(5, $textypos, $datosProveedor[0]['fecha']);

//----------------------------//----------------------------------------
$pdf->SetFont('Arial', 'B', 10);
$pdf->setY(65);
$pdf->setX(105);
$pdf->Cell(5, $textypos, "Cuenta de Debito:");
//-----------------------//-------------------------------------------------
$pdf->SetFont('Arial', '', 10);  // Sin negrita para los datos de la base de datos
$pdf->setY(65);
$pdf->setX(140);
$pdf->Cell(5, $textypos,$nombreCuenta);

//----------------------------//----------------------------------------
$pdf->SetFont('Arial', 'B', 10);
$pdf->setY(70);
$pdf->setX(105);
$pdf->Cell(5, $textypos, "Cuenta de Credito:");
//-----------------------//-------------------------------------------------
$pdf->SetFont('Arial', '', 10);  // Sin negrita para los datos de la base de datos
$pdf->setY(70);
$pdf->setX(142);
$pdf->Cell(5, $textypos, $datosProveedor[0]['ruc']);



//----------------------------//----------------------------------------
$pdf->SetFont('Arial', 'B', 8);
$pdf->setY(95);
$pdf->setX(7);
$pdf->Cell(5, $textypos, "Periodo");

$pdf->SetFont('Arial', '', 10);
$pdf->setY(105);
$pdf->setX(9);
$pdf->Cell(5, $textypos, "2024");

//-----------------//----------------------------------------------------

$pdf->SetFont('Arial', 'B', 8);
$pdf->setY(95);
$pdf->setX(25);
$pdf->Cell(5, $textypos, "Tipo");


if (isset($datosProveedor['tipo'])) {
$pdf->SetFont('Arial', '', 10);  // tipo
$texto = $datosProveedor['tipo'];
$pdf->setY(105);
$pdf->setX(25);
$pdf->MultiCell(0, 10, utf8_decode($texto), 0, 'J'); // 'J' para justificar
}
//------------------------//-------------------------------------------------

$pdf->SetFont('Arial', 'B', 8);
$pdf->setY(95);
$pdf->setX(35);
$pdf->Cell(5, $textypos, "Prog.");

$pdf->SetFont('Arial', '', 10);  // Sin negrita para los datos de la base de datos
$pdf->setY(105);
$pdf->setX(35);
$pdf->Cell(5, $textypos, $datosProveedor[0]['codigo_pro']);

//------------------------//------------------------------------------

$pdf->SetFont('Arial', 'B', 8);
$pdf->setY(95);
$pdf->setX(45);
$pdf->Cell(5, $textypos, "Sub. Pro");

//----------------------//----------------------------------------

$pdf->SetFont('Arial', 'B', 8);
$pdf->setY(95);
$pdf->setX(65);
$pdf->Cell(5, $textypos, "Objeto");

$pdf->SetFont('Arial', '', 10);  // Sin negrita para los datos de la base de datos
$pdf->setY(105);
$pdf->setX(65);
$pdf->Cell(5, $textypos, $datosProveedor[0]['id_cc']);

//--------------------------//---------------------------------

$pdf->SetFont('Arial', 'B', 8);
$pdf->setY(95);
$pdf->setX(80);
$pdf->Cell(5, $textypos, "Org.");

$pdf->SetFont('Arial', '', 10);  // Sin negrita para los datos de la base de datos
$pdf->setY(105);
$pdf->setX(80);
$pdf->Cell(5, $textypos, $datosProveedor[0]['codigo_of']);

//-----------------------------//---------------------------------

$pdf->SetFont('Arial', 'B', 8);
$pdf->setY(95);
$pdf->setX(95);
$pdf->Cell(5, $textypos, "Dpto.");

$pdf->SetFont('Arial', '', 10);  // Sin negrita para los datos de la base de datos
$pdf->setY(105);
$pdf->setX(95);
$pdf->Cell(5, $textypos, '10');

//----------------------------//---------------

$pdf->SetFont('Arial', 'B', 9);
$pdf->setY(95);
$pdf->setX(115);
$pdf->Cell(5, $textypos, "Descripcion");


$pdf->SetFont('Arial', '', 10);  // Sin negrita para los datos de la base de datos
$pdf->setY(105);
$pdf->setX(115);
$pdf->Cell(5, $textypos, $datosProveedor[0]['Descripcion']);

//------------------------//----------------------

$pdf->SetFont('Arial', 'B', 10);
$pdf->setY(95);
$pdf->setX(173);
$pdf->Cell(5, $textypos, "Importe del Egreso");

$mpago=$datosProveedor[0]['montopagado'];
$pdf->SetFont('Arial', '', 10);  // Sin negrita para los datos de la base de datos
$pdf->setY(105);
$pdf->setX(187);
$pdf->Cell(5, $textypos, number_format($mpago,0));


//----------------------------//----------------------------------------
$pdf->SetFont('Arial', 'B', 9);
$pdf->setY(240);
$pdf->setX(10);
$pdf->Cell(5, $textypos, "Son guaranies:");

$pdf->SetFont('Arial', 'B', 9);
$pdf->setY(240);
$pdf->setX(130);
$pdf->Cell(5, $textypos, "Total Gral.:");
$pdf->SetFont('Arial', 'B', 9);
$pdf->setY(245);
$pdf->setX(130);
$pdf->Cell(5, $textypos, "Deducciones:");
$pdf->SetFont('Arial', 'B', 9);
$pdf->setY(250);
$pdf->setX(130);
$pdf->Cell(5, $textypos, "Neto a Transferir:");




//detalles
//----------------------------//----------------------------------------
$pdf->SetFont('Arial', 'B', 9);
$pdf->setY(260);
$pdf->setX(10);
$pdf->Cell(5, $textypos, "Obs.:");

$pdf->SetFont('Arial', 'B', 9);
$pdf->setY(265);
$pdf->setX(10);
$pdf->Cell(5, $textypos, "Nivel de Control:");
$pdf->SetFont('Arial', 'B', 9);
$pdf->setY(270);
$pdf->setX(10);
$pdf->Cell(5, $textypos, "Beneficiario:");
$pdf->SetFont('Arial', 'B', 9);
$pdf->setY(275);
$pdf->setX(10);
$pdf->Cell(5, $textypos, "RUC:");

//----------------------------//----------------------------------------
$pdf->SetFont('Arial', 'B', 9);
$pdf->setY(290);
$pdf->setX(10);
$pdf->Cell(5, $textypos, "Se dispone el pago de la presente obligacion:");


//----------------------------//----------------------------------------
$pdf->SetFont('Arial', 'B', 9);
$pdf->setY(320);
$pdf->setX(12);
$pdf->Cell(5, $textypos, "Dr. Sebastian A. Benitez Gonzalez");


//----------------------------//----------------------------------------
$pdf->SetFont('Arial', 'B', 8);
$pdf->setY(325);
$pdf->setX(16);
$pdf->Cell(5, $textypos, "Dir. Gral. de Admin. y Finanzas ");



//----------------------------//----------------------------------------
$pdf->SetFont('Arial', 'B', 9);
$pdf->setY(320);
$pdf->setX(150);
$pdf->Cell(5, $textypos, "Prof. Dr. Julio Cesar Meaurio Leiva");

//----------------------------//----------------------------------------
$pdf->SetFont('Arial', 'B', 8);
$pdf->setY(325);
$pdf->setX(170);
$pdf->Cell(5, $textypos, "Vicerrector ");



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