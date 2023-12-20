<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pdf extends CI_Controller {

    public function index()
    {
        $this->load->model("Pdf_model"); // Load the model first
        $datos['titulo'] = 'Reporte de Obligaciones';
        $datos['ultimosDatos'] = $this->Pdf_model->obtenerDatos();
        $this->load->view('layouts/header');
        $this->load->view('fpdf', $datos);
        
        //$this->load->view('layouts/footer');
    }

    public function generarPDFS()
    {
        require_once APPPATH . 'third_party/fpdf/fpdf.php';
    
        $this->load->model("Pdf_model"); // Load the model first
        $pdf = new FPDF();
        $datosProveedor = $this->Pdf_model->obtenerDatos();
        $pdf->AddPage('P','A4',0);
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
    $pdf->setX(10);
    $pdf->Rect(10,$pdf->GetY(), 100, 33);
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Ln();

//----------------//------------------------------------

    //Rectangulo para Orden de Pago
    $pdf->setY(3);
    $pdf->setX(210);
    $pdf->Rect(153,$pdf->GetY(), 50, 25);
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Ln();


    //----------------//------------------------------------

    //Rectangulo para Datos del Egreso
    $pdf->setY(33);
    $pdf->setX(90);
    $pdf->Rect(113,$pdf->GetY(), 95, 33);
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Ln();

     //----------------//------------------------------------

    //Rectangulo para Documentos Adjuntos
    $pdf->setY(72);
    $pdf->setX(10);
    $pdf->Rect(10,$pdf->GetY(), 198, 35);
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Ln();

       //----------------//------------------------------------

    //Rectangulo para Imputación Presupuestaria
    $pdf->setY(112);
    $pdf->setX(10);
    $pdf->Rect(10,$pdf->GetY(), 198, 100);
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Ln();

         //----------------//------------------------------------

    //Rectangulo para Imputación Presupuestaria
    $pdf->setY(215);
    $pdf->setX(10);
    $pdf->Rect(10,$pdf->GetY(), 198, 75);
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Ln();

       $datosProveedor = $this->Pdf_model->obtenerDatos();

       // Verifica si hay datos en el array antes de intentar acceder a ellos
       if (!empty($datosProveedor)) {
           // Agregamos los datos del proveedor
       
           $pdf->SetFont('Arial', 'B', 15);
           $pdf->setY(35);
           $pdf->setX(13);
           $pdf->Cell(5, $textypos, "Datos del beneficiario:");
           //--------------------------//----------------------
           $pdf->SetFont('Arial', 'B', 10);
           $pdf->setY(40);
           $pdf->setX(10);
           $pdf->Cell(5, $textypos, "Razon Social:"); //Estos son los titulos
           //-------------------//----------------------------
           $pdf->SetFont('Arial', '', 10);
           $pdf->setY(40);
           $pdf->setX(35);
           $pdf->Cell(5, $textypos, $datosProveedor[0]['proveedor']);  // Nombre del proveedor
           //------------------//----------------------------------------

           $pdf->SetFont('Arial', 'B', 10);
           $pdf->setY(45);
           $pdf->setX(10);
           $pdf->Cell(5, $textypos, "Ruc:");

           //-----------//----------------------------------
           $pdf->SetFont('Arial', '', 10);
           $pdf->setY(45);
           $pdf->setX(19);
           $pdf->Cell(5, $textypos, $datosProveedor[0]['ruc']);
           //----------------------//-----------------------------------

           $pdf->SetFont('Arial', 'B', 10);
           $pdf->setY(50);
           $pdf->setX(10);
           $pdf->Cell(5, $textypos, "Direccion:");
           //------------------------------//--------------------------
           $pdf->SetFont('Arial', '', 10);
           $pdf->setY(50);
           $pdf->setX(29);
           $pdf->Cell(5, $textypos, $datosProveedor[0]['direccion']);     // Direccion del proveedor
           //----------------------//----------------------------

           $pdf->SetFont('Arial', 'B', 10);
           $pdf->setY(55);
           $pdf->setX(10);
           $pdf->Cell(5, $textypos, "Telefono:");

           //---------------------//-----------------------------------
           $pdf->SetFont('Arial', '', 10);
           $pdf->setY(55);
           $pdf->setX(28);
           $pdf->Cell(5, $textypos, $datosProveedor[0]['telef']);         // Telefono del proveedor
          
           //--------------------//------------------------------------
           $pdf->SetFont('Arial', 'B', 10);
           $pdf->setY(60);
           $pdf->setX(10);
           $pdf->Cell(5, $textypos, "Email:");
           //----------------//--------------------------------------
           $pdf->SetFont('Arial', '', 10);
           $pdf->setY(60);
           $pdf->setX(22);
           $pdf->Cell(5, $textypos, $datosProveedor[0]['email']);
       } else {
           // Manejo de la situación donde no hay datos del proveedor
           // Puedes agregar un mensaje o realizar alguna acción específica
           $pdf->SetFont('Arial', 'B', 10);
           $pdf->setY(30);
           $pdf->setX(75);
           $pdf->Cell(5, $textypos, "PARA:");
           $pdf->SetFont('Arial', '', 10);
           $pdf->setY(35);
           $pdf->setX(75);
           $pdf->Cell(5, $textypos, "Proveedor no encontrado");
           // Puedes agregar más celdas según tus necesidades
       }

       // Agregamos los datos del Orden de Pago


$pdf->SetFont('Arial', 'B', 10);
$pdf->setY(5);
$pdf->setX(153);
$pdf->Cell(5, $textypos, "Orden de Pago Nro:");

$pdf->SetFont('Arial', '', 10);  // Sin negrita para los datos de la base de datos
$pdf->setY(5);
$pdf->setX(188);
$pdf->Cell(5, $textypos, $datosProveedor[0]['orden_de_pago']);

$pdf->SetFont('Arial', 'B', 10);
$pdf->setY(11);
$pdf->setX(153);
$pdf->Cell(5, $textypos, "Fecha de emision:");

$pdf->SetFont('Arial', '', 10);  // Sin negrita para los datos de la base de datos
$pdf->setY(16);
$pdf->setX(153);
$pdf->Cell(5, $textypos, $datosProveedor[0]['fecha']);

$pdf->SetFont('Arial', 'B', 10);
$pdf->setY(22);
$pdf->setX(153);
$pdf->Cell(5, $textypos, "RUC:");

$pdf->SetFont('Arial', '', 10);  // Sin negrita para los datos de la base de datos
$pdf->setY(22);
$pdf->setX(163);
$pdf->Cell(5, $textypos, $datosProveedor[0]['ruc']);

$pdf->SetFont('Arial', 'B', 10);
$pdf->setY(45);
$pdf->setX(135);
$pdf->Cell(5, $textypos, "");

$pdf->SetFont('Arial', 'B', 10);
$pdf->setY(50);
$pdf->setX(135);
$pdf->Cell(5, $textypos, "");





//-----------------Datos del Egreso------------------

$pdf->SetFont('Arial', 'B', 15);
$pdf->setY(35);
$pdf->setX(118);
$pdf->Cell(5, $textypos, "Datos del Egreso:");

//-------------//---------------//-----------------
$pdf->SetFont('Arial', 'B', 10);
$pdf->setY(40);
$pdf->setX(118);
$pdf->Cell(5, $textypos, "Banco/Egreso:"); //Titulo
//----------------//------------------------------------
$pdf->SetFont('Arial', '', 10);  // Sin negrita para los datos de la base de datos
$pdf->setY(40);
$pdf->setX(144);
$pdf->Cell(5, $textypos, $datosProveedor[0]['Descripcion']);

//----------------//-------------------------------------
$pdf->SetFont('Arial', 'B', 10);
$pdf->setY(45);
$pdf->setX(118);
$pdf->Cell(5, $textypos, "Cta Cte Nro:"); //Titulo
//----------------//------------------------------------
$pdf->SetFont('Arial', '', 10);  // Sin negrita para los datos de la base de datos
$pdf->setY(45);
$pdf->setX(139);
$pdf->Cell(5, $textypos, $datosProveedor[0]['Descripcion']);


//----------------//-------------------------------------
$pdf->SetFont('Arial', 'B', 10);
$pdf->setY(50);
$pdf->setX(118);
$pdf->Cell(5, $textypos, "Cheque(s)/OT:"); //Titulo
//----------------//------------------------------------
$pdf->SetFont('Arial', '', 10);  // Sin negrita para los datos de la base de datos
$pdf->setY(50);
$pdf->setX(143);
$pdf->Cell(5, $textypos, $datosProveedor[0]['Descripcion']);

//----------------//-------------------------------------
$pdf->SetFont('Arial', 'B', 10);
$pdf->setY(55);
$pdf->setX(118);
$pdf->Cell(5, $textypos, "Importe Cheque(s):"); //Titulo
//-----------Para el menos retención-------------------
$pdf->SetFont('Arial', 'B', 8);
$pdf->setY(55);
$pdf->setX(180);
$pdf->Cell(5, $textypos, "(Menos Retencion)"); //Titulo
//----------------//------------------------------------
$pdf->SetFont('Arial', '', 10   );  // Sin negrita para los datos de la base de datos
$pdf->setY(55);
$pdf->setX(152);
$pdf->Cell(5, $textypos, $datosProveedor[0]['ruc']);

//----------------//-------------------------------------
$pdf->SetFont('Arial', 'B', 10);
$pdf->setY(60);
$pdf->setX(118);
$pdf->Cell(5, $textypos, "Cuenta Proveedor:"); //Titulo
//----------------//------------------------------------
$pdf->SetFont('Arial', '', 10);  // Sin negrita para los datos de la base de datos
$pdf->setY(60);
$pdf->setX(151);
$pdf->Cell(5, $textypos, $datosProveedor[0]['ruc']);








//-----------------Documentos Adjuntos-------------------------------

$pdf->SetFont('Arial', 'B', 13);
$pdf->setY(73);
$pdf->setX(13);
$pdf->Cell(5, $textypos, "Documentos Adjuntos:"); //Titulo del Documento Adjunto
//----------------//------------------------------------
$pdf->SetFont('Arial', 'B', 10);
$pdf->setY(80);
$pdf->setX(10);
$pdf->Cell(5, $textypos, "Observacion:");
//-----------------------//-------------------------------------------------
$pdf->SetFont('Arial', '', 10);  // Sin negrita para los datos de la base de datos
$pdf->setY(80);
$pdf->setX(33);
$pdf->Cell(5, $textypos, $datosProveedor[0]['detalle']);
//----------------------------//----------------------------------------
$pdf->SetFont('Arial', 'B', 10);
$pdf->setY(85);
$pdf->setX(10);
$pdf->Cell(5, $textypos, "Datos del comprobante Nro:");
//-----------------------//-------------------------------------------------
$pdf->SetFont('Arial', '', 10);  // Sin negrita para los datos de la base de datos
$pdf->setY(85);
$pdf->setX(58);
$pdf->Cell(5, $textypos, $datosProveedor[0]['comprobante']);

//----------------------------//----------------------------------------
$pdf->SetFont('Arial', 'B', 10);
$pdf->setY(90);
$pdf->setX(10);
$pdf->Cell(5, $textypos, "Datos de la recepcion Nro:");
//-----------------------//-------------------------------------------------
$pdf->SetFont('Arial', '', 10);  // Sin negrita para los datos de la base de datos
$pdf->setY(90);
$pdf->setX(56);
$pdf->Cell(5, $textypos, $datosProveedor[0]['ruc']);

//----------------------------//----------------------------------------
$pdf->SetFont('Arial', 'B', 10);
$pdf->setY(95);
$pdf->setX(10);
$pdf->Cell(5, $textypos, "Datos de la obligacion Nro:");
//-----------------------//-------------------------------------------------
$pdf->SetFont('Arial', '', 10);  // Sin negrita para los datos de la base de datos
$pdf->setY(95);
$pdf->setX(57);
$pdf->Cell(5, $textypos, $datosProveedor[0]['ruc']);

//----------------------------//----------------------------------------
$pdf->SetFont('Arial', 'B', 10);
$pdf->setY(100);
$pdf->setX(10);
$pdf->Cell(5, $textypos, "Datos de UOC:");
//-----------------------//-------------------------------------------------
$pdf->SetFont('Arial', '', 10);  // Sin negrita para los datos de la base de datos
$pdf->setY(100);
$pdf->setX(36);
$pdf->Cell(5, $textypos, $datosProveedor[0]['ruc']);

//----------------------------//----------------------------------------
$pdf->SetFont('Arial', 'B', 10);
$pdf->setY(80);
$pdf->setX(110);
$pdf->Cell(5, $textypos, "Tipo:");
//-----------------------//-------------------------------------------------
$pdf->SetFont('Arial', '', 10);  // Sin negrita para los datos de la base de datos
$pdf->setY(80);
$pdf->setX(120);
$pdf->Cell(5, $textypos, $datosProveedor[0]['ruc']);

//----------------------------//----------------------------------------
$pdf->SetFont('Arial', 'B', 10);
$pdf->setY(85);
$pdf->setX(110);
$pdf->Cell(5, $textypos, "Fecha:");
//-----------------------//-------------------------------------------------
$pdf->SetFont('Arial', '', 10);  // Sin negrita para los datos de la base de datos
$pdf->setY(85);
$pdf->setX(123);
$pdf->Cell(5, $textypos, $datosProveedor[0]['ruc']);

//----------------------------//----------------------------------------
$pdf->SetFont('Arial', 'B', 10);
$pdf->setY(90);
$pdf->setX(110);
$pdf->Cell(5, $textypos, "OBL Nro:");
//-----------------------//-------------------------------------------------
$pdf->SetFont('Arial', '', 10);  // Sin negrita para los datos de la base de datos
$pdf->setY(90);
$pdf->setX(126);
$pdf->Cell(5, $textypos, $datosProveedor[0]['ruc']);

//----------------------------//----------------------------------------
$pdf->SetFont('Arial', 'B', 10);
$pdf->setY(95);
$pdf->setX(110);
$pdf->Cell(5, $textypos, "Contrato:");
//-----------------------//-------------------------------------------------
$pdf->SetFont('Arial', '', 10);  // Sin negrita para los datos de la base de datos
$pdf->setY(95);
$pdf->setX(126);
$pdf->Cell(5, $textypos, $datosProveedor[0]['ruc']);

//----------------------------//----------------------------------------
$pdf->SetFont('Arial', 'B', 10);
$pdf->setY(100);
$pdf->setX(110);
$pdf->Cell(5, $textypos, "Egreso Nro:");
//-----------------------//-------------------------------------------------
$pdf->SetFont('Arial', '', 10);  // Sin negrita para los datos de la base de datos
$pdf->setY(100);
$pdf->setX(131);
$pdf->Cell(5, $textypos, $datosProveedor[0]['ruc']);





//-------------------------Imputacion Presupuestaria--------------------------------------
$pdf->SetFont('Arial', 'B', 13);
$pdf->setY(113);
$pdf->setX(80);
$pdf->Cell(5, $textypos, "Imputacion Presupuestaria");
//----------------------------//-------
//----------------------------//----------------------------------------
$pdf->SetFont('Arial', 'B', 10);
$pdf->setY(120);
$pdf->setX(10);
$pdf->Cell(5, $textypos, "Periodo");

$pdf->SetFont('Arial', 'B', 10);
$pdf->setY(120);
$pdf->setX(30);
$pdf->Cell(5, $textypos, "Tipo");

$pdf->SetFont('Arial', 'B', 10);
$pdf->setY(120);
$pdf->setX(45);
$pdf->Cell(5, $textypos, "Programa");


$pdf->SetFont('Arial', 'B', 10);
$pdf->setY(120);
$pdf->setX(68);
$pdf->Cell(5, $textypos, "Sub. Pro");


$pdf->SetFont('Arial', 'B', 10);
$pdf->setY(120);
$pdf->setX(89);
$pdf->Cell(5, $textypos, "Rubro");

$pdf->SetFont('Arial', 'B', 10);
$pdf->setY(120);
$pdf->setX(107);
$pdf->Cell(5, $textypos, "Org.");

$pdf->SetFont('Arial', 'B', 10);
$pdf->setY(120);
$pdf->setX(123);
$pdf->Cell(5, $textypos, "Dpto.");

$pdf->SetFont('Arial', 'B', 10);
$pdf->setY(120);
$pdf->setX(140);
$pdf->Cell(5, $textypos, "Concepto");

$pdf->SetFont('Arial', 'B', 10);
$pdf->setY(120);
$pdf->setX(173);
$pdf->Cell(5, $textypos, "Importe del Egreso");
//----------------------------//----------------------------------------
$pdf->SetFont('Arial', 'B', 10);
$pdf->setY(123);
$pdf->setX(10);
$pdf->Cell(5, $textypos, "-----------------------------------------------------------------------------------------------------------------------------------------------------------------------");










        $pdf->Output('Reporte Pago Obligacion.pdf' , 'I' );
   }


    
    
    
}
