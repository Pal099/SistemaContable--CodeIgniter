<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pdf_pago extends CI_Controller {

    public function index()
    {
        $this->load->model("Pdf_model"); // Load the model firsta
        $datos['titulo'] = 'Reporte de Obligaciones';
        $datos['ultimosDatos'] = $this->Pdf_model->obtenerDatos_pago();
        $this->load->view('layouts/header');
        $this->load->view('fpdf', $datos);
        
        //$this->load->view('layouts/footer');
    }

    public function pdf_pago_obli()
    {
        require_once APPPATH . 'third_party/fpdf/fpdf.php';
    
        $this->load->model("Pdf_model"); // Load the model first
        $pdf = new FPDF();
        $datosProveedor = $this->Pdf_model->obtenerDatos_pago();
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

//----------------//------------------------------------

    //Rectangulo para Orden de Pago
    $pdf->setY(3);
    $pdf->setX(210);
    $pdf->Rect(153,$pdf->GetY(), 57, 25);
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Ln();


    //----------------//------------------------------------

    //Rectangulo para Datos del Egreso
    $pdf->setY(33);
    $pdf->setX(90);
    $pdf->Rect(110,$pdf->GetY(), 100, 33);
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Ln();

     //----------------//------------------------------------

    //Rectangulo para Documentos Adjuntos
    $pdf->setY(72);
    $pdf->setX(10);
    $pdf->Rect(6,$pdf->GetY(), 204, 35);
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Ln();

       //----------------//------------------------------------

    //Rectangulo para Imputación Presupuestaria
    $pdf->setY(112);
    $pdf->setX(10);
    $pdf->Rect(6,$pdf->GetY(), 204, 87);
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Ln();

         //----------------//------------------------------------

    //Rectangulo para Retencion aplicada
    $pdf->setY(203);
    $pdf->setX(6);
    $pdf->Rect(6,$pdf->GetY(), 204, 127);
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Ln();






    //---------------//-------------------------------//-----------------

       $datosProveedor = $this->Pdf_model->obtenerDatos_pago();

       // Verifica si hay datos en el array antes de intentar acceder a ellos
       if (!empty($datosProveedor)) {
           // Agregamos los datos del proveedor
       
           $pdf->SetFont('Arial', 'B', 15);
           $pdf->setY(35);
           $pdf->setX(11);
           $pdf->Cell(5, $textypos, "Datos del beneficiario:");
           //--------------------------//----------------------
           $pdf->SetFont('Arial', 'B', 10);
           $pdf->setY(40);
           $pdf->setX(7);
           $pdf->Cell(5, $textypos, "Razon Social:"); //Estos son los titulos
           //-------------------//----------------------------
           $pdf->SetFont('Arial', '', 10);
           $pdf->setY(40);
           $pdf->setX(31);
           $pdf->Cell(5, $textypos, $datosProveedor['proveedor']);  // Nombre del proveedor
           //------------------//----------------------------------------

           $pdf->SetFont('Arial', 'B', 10);
           $pdf->setY(45);
           $pdf->setX(7);
           $pdf->Cell(5, $textypos, "Ruc:");

           //-----------//----------------------------------
           $pdf->SetFont('Arial', '', 10);
           $pdf->setY(45);
           $pdf->setX(16);
           $pdf->Cell(5, $textypos, $datosProveedor['ruc']);
           //----------------------//-----------------------------------

           $pdf->SetFont('Arial', 'B', 10);
           $pdf->setY(50);
           $pdf->setX(7);
           $pdf->Cell(5, $textypos, "Direccion:");
           //------------------------------//--------------------------
           $pdf->SetFont('Arial', '', 10);
           $pdf->setY(50);
           $pdf->setX(26);
           $pdf->Cell(5, $textypos, $datosProveedor['direccion']);     // Direccion del proveedor
           //----------------------//----------------------------

           $pdf->SetFont('Arial', 'B', 10);
           $pdf->setY(55);
           $pdf->setX(7);
           $pdf->Cell(5, $textypos, "Telefono:");

           //---------------------//-----------------------------------
           $pdf->SetFont('Arial', '', 10);
           $pdf->setY(55);
           $pdf->setX(25);
           $pdf->Cell(5, $textypos, $datosProveedor['telef']);         // Telefono del proveedor
          
           //--------------------//------------------------------------
           $pdf->SetFont('Arial', 'B', 10);
           $pdf->setY(60);
           $pdf->setX(7);
           $pdf->Cell(5, $textypos, "Email:");
           //----------------//--------------------------------------
           $pdf->SetFont('Arial', '', 10);
           $pdf->setY(60);
           $pdf->setX(19);
           $pdf->Cell(5, $textypos, $datosProveedor['email']);
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


// Agregamos los datos del Orden de Pago------------------------------------

$pdf->SetFont('Arial', 'B', 10);
$pdf->setY(5);
$pdf->setX(153);
$pdf->Cell(5, $textypos, "Orden de Pago Nro:");

$pdf->SetFont('Arial', '', 10);  // Sin negrita para los datos de la base de datos
$pdf->setY(5);
$pdf->setX(188);
$pdf->Cell(5, $textypos, $datosProveedor['orden_de_pago']);

$pdf->SetFont('Arial', 'B', 10);
$pdf->setY(11);
$pdf->setX(153);
$pdf->Cell(5, $textypos, "Fecha de emision:");

$pdf->SetFont('Arial', '', 10);  // Sin negrita para los datos de la base de datos
$pdf->setY(16);
$pdf->setX(153);
$pdf->Cell(5, $textypos, $datosProveedor['fecha']);

$pdf->SetFont('Arial', 'B', 10);
$pdf->setY(22);
$pdf->setX(153);
$pdf->Cell(5, $textypos, "RUC:");

$pdf->SetFont('Arial', '', 10);  // Sin negrita para los datos de la base de datos
$pdf->setY(22);
$pdf->setX(163);
$pdf->Cell(5, $textypos, $datosProveedor['ruc']);

$pdf->SetFont('Arial', 'B', 10);
$pdf->setY(45);
$pdf->setX(135);
$pdf->Cell(5, $textypos, "");

$pdf->SetFont('Arial', 'B', 10);
$pdf->setY(50);
$pdf->setX(135);
$pdf->Cell(5, $textypos, "");





//-----------------Datos del Egreso-----------------------------

$pdf->SetFont('Arial', 'B', 15);
$pdf->setY(35);
$pdf->setX(115);
$pdf->Cell(5, $textypos, "Datos del Egreso:");

//-------------//---------------//-----------------
$pdf->SetFont('Arial', 'B', 10);
$pdf->setY(40);
$pdf->setX(111);
$pdf->Cell(5, $textypos, "Banco/Egreso:"); //Titulo
//----------------//------------------------------------

if (isset($datosProveedor['Descripcion'])) {
    $pdf->SetFont('Arial', '', 10);  // tipo
    $texto = $datosProveedor['Descripcion'];
    $pdf->setY(38);
    $pdf->setX(137);
    $pdf->MultiCell(0, 10, utf8_decode($texto), 0, 'J'); // 'J' para justificar
    }


//----------------//-------------------------------------
$pdf->SetFont('Arial', 'B', 10);
$pdf->setY(45);
$pdf->setX(111);
$pdf->Cell(5, $textypos, "Cta Cte Nro:"); //Titulo
//----------------//------------------------------------

if (isset($datosProveedor['Descripcion'])) {
    $pdf->SetFont('Arial', '', 10);  // tipo
    $texto = $datosProveedor['Descripcion'];
    $pdf->setY(43);
    $pdf->setX(133);
    $pdf->MultiCell(0, 10, utf8_decode($texto), 0, 'J'); // 'J' para justificar
    }



//----------------//-------------------------------------
$pdf->SetFont('Arial', 'B', 10);
$pdf->setY(50);
$pdf->setX(111);
$pdf->Cell(5, $textypos, "Cheque(s)/OT:"); //Titulo
//----------------//------------------------------------

if (isset($datosProveedor['Descripcion'])) {
    $pdf->SetFont('Arial', '', 10);  // tipo
    $texto = $datosProveedor['Descripcion'];
    $pdf->setY(48);
    $pdf->setX(136);
    $pdf->MultiCell(0, 10, utf8_decode($texto), 0, 'J'); // 'J' para justificar
    }


//----------------//-------------------------------------
$pdf->SetFont('Arial', 'B', 10);
$pdf->setY(55);
$pdf->setX(111);
$pdf->Cell(5, $textypos, "Importe Cheque(s):"); //Cheque


//-----------Para el menos retención-------------------
$pdf->SetFont('Arial', 'B', 8);
$pdf->setY(55);
$pdf->setX(177);
$pdf->Cell(5, $textypos, "(Menos Retencion)"); //Titulo

//El valor del haber
$montopagado = $datosProveedor['montopagado'];

// Calcula el IVA (10%)
$iva = $montopagado * 0.4;

$pdf->SetFont('Arial', '', 10   );  // Sin negrita para los datos de la base de datos
$pdf->setY(55);
$pdf->setX(145);
$pdf->Cell(5, $textypos, number_format($iva, 0));


//----------------//-------------------------------------
$pdf->SetFont('Arial', 'B', 10);
$pdf->setY(60);
$pdf->setX(111);
$pdf->Cell(5, $textypos, "Cuenta Proveedor:"); //Titulo
//----------------//------------------------------------
$pdf->SetFont('Arial', '', 10);  // Sin negrita para los datos de la base de datos
$pdf->setY(60);
$pdf->setX(144);
$pdf->Cell(5, $textypos, $datosProveedor['ruc']);








//-----------------Documentos Adjuntos-------------------------------

$pdf->SetFont('Arial', 'B', 13);
$pdf->setY(73);
$pdf->setX(10);
$pdf->Cell(5, $textypos, "Documentos Adjuntos:"); //Titulo del Documento Adjunto
//----------------//------------------------------------
$pdf->SetFont('Arial', 'B', 10);
$pdf->setY(80);
$pdf->setX(7);
$pdf->Cell(5, $textypos, "Observacion:");
//-----------------------//-------------------------------------------------
$pdf->SetFont('Arial', '', 10);  // Sin negrita para los datos de la base de datos
$pdf->setY(80);
$pdf->setX(30);
$pdf->Cell(5, $textypos, $datosProveedor['detalle']);
//----------------------------//----------------------------------------
$pdf->SetFont('Arial', 'B', 10);
$pdf->setY(85);
$pdf->setX(7);
$pdf->Cell(5, $textypos, "Datos del comprobante Nro:");
//-----------------------//-------------------------------------------------
$pdf->SetFont('Arial', '', 10);  // Sin negrita para los datos de la base de datos
$pdf->setY(85);
$pdf->setX(56);
$pdf->Cell(5, $textypos, $datosProveedor['comprobante']);

//----------------------------//----------------------------------------
$pdf->SetFont('Arial', 'B', 10);
$pdf->setY(90);
$pdf->setX(7);
$pdf->Cell(5, $textypos, "Datos de la recepcion Nro:");
//-----------------------//-------------------------------------------------
$pdf->SetFont('Arial', '', 10);  // Sin negrita para los datos de la base de datos
$pdf->setY(90);
$pdf->setX(53);
$pdf->Cell(5, $textypos, $datosProveedor['ruc']);

//----------------------------//----------------------------------------
$pdf->SetFont('Arial', 'B', 10);
$pdf->setY(95);
$pdf->setX(7);
$pdf->Cell(5, $textypos, "Datos de la obligacion Nro:");
//-----------------------//-------------------------------------------------
$pdf->SetFont('Arial', '', 10);  // Sin negrita para los datos de la base de datos
$pdf->setY(95);
$pdf->setX(54);
$pdf->Cell(5, $textypos, $datosProveedor['ruc']);

//----------------------------//----------------------------------------
$pdf->SetFont('Arial', 'B', 10);
$pdf->setY(100);
$pdf->setX(7);
$pdf->Cell(5, $textypos, "Datos de UOC:");
//-----------------------//-------------------------------------------------
$pdf->SetFont('Arial', '', 10);  // Sin negrita para los datos de la base de datos
$pdf->setY(100);
$pdf->setX(33);
$pdf->Cell(5, $textypos, $datosProveedor['ruc']);

//----------------------------//----------------------------------------
$pdf->SetFont('Arial', 'B', 10);
$pdf->setY(80);
$pdf->setX(95);
$pdf->Cell(5, $textypos, "Tipo:");
//-----------------------//-------------------------------------------------
$pdf->SetFont('Arial', '', 10);  // Sin negrita para los datos de la base de datos
$pdf->setY(80);
$pdf->setX(105);
$pdf->Cell(5, $textypos, $datosProveedor['ruc']);

//----------------------------//----------------------------------------
$pdf->SetFont('Arial', 'B', 10);
$pdf->setY(85);
$pdf->setX(95);
$pdf->Cell(5, $textypos, "Fecha:");
//-----------------------//-------------------------------------------------
$pdf->SetFont('Arial', '', 10);  // Sin negrita para los datos de la base de datos
$pdf->setY(85);
$pdf->setX(108);
$pdf->Cell(5, $textypos, $datosProveedor['fecha']);

//----------------------------//----------------------------------------
$pdf->SetFont('Arial', 'B', 10);
$pdf->setY(90);
$pdf->setX(95);
$pdf->Cell(5, $textypos, "OBL Nro:");
//-----------------------//-------------------------------------------------
$pdf->SetFont('Arial', '', 10);  // Sin negrita para los datos de la base de datos
$pdf->setY(90);
$pdf->setX(112);
$pdf->Cell(5, $textypos, $datosProveedor['ruc']);

//----------------------------//----------------------------------------
$pdf->SetFont('Arial', 'B', 10);
$pdf->setY(95);
$pdf->setX(95);
$pdf->Cell(5, $textypos, "Contrato:");
//-----------------------//-------------------------------------------------
$pdf->SetFont('Arial', '', 10);  // Sin negrita para los datos de la base de datos
$pdf->setY(95);
$pdf->setX(112);
$pdf->Cell(5, $textypos, $datosProveedor['ruc']);

//----------------------------//----------------------------------------
$pdf->SetFont('Arial', 'B', 10);
$pdf->setY(100);
$pdf->setX(95);
$pdf->Cell(5, $textypos, "Egreso Nro:");
//-----------------------//-------------------------------------------------
$pdf->SetFont('Arial', '', 10);  // Sin negrita para los datos de la base de datos
$pdf->setY(100);
$pdf->setX(116);
$pdf->Cell(5, $textypos, $datosProveedor['ruc']);


//Tercera columna de datos adjuntos

//----------------------------//----------------------------------------
$pdf->SetFont('Arial', 'B', 10);
$pdf->setY(80);
$pdf->setX(150);
$pdf->Cell(5, $textypos, "Fecha:");
//-----------------------//-------------------------------------------------
$pdf->SetFont('Arial', '', 10);  // Sin negrita para los datos de la base de datos
$pdf->setY(80);
$pdf->setX(162);
$pdf->Cell(5, $textypos, $datosProveedor['fecha']);

//----------------------------//----------------------------------------
$pdf->SetFont('Arial', 'B', 10);
$pdf->setY(85);
$pdf->setX(150);
$pdf->Cell(5, $textypos, "Nota remision Nro:");
//-----------------------//-------------------------------------------------
$pdf->SetFont('Arial', '', 10);  // Sin negrita para los datos de la base de datos
$pdf->setY(85);
$pdf->setX(183);
$pdf->Cell(5, $textypos, $datosProveedor['ruc']);

//----------------------------//----------------------------------------
$pdf->SetFont('Arial', 'B', 10);
$pdf->setY(90);
$pdf->setX(150);
$pdf->Cell(5, $textypos, "OT Nro:");
//-----------------------//-------------------------------------------------
$pdf->SetFont('Arial', '', 10);  // Sin negrita para los datos de la base de datos
$pdf->setY(90);
$pdf->setX(165);
$pdf->Cell(5, $textypos, $datosProveedor['ruc']);

//----------------------------//----------------------------------------
$pdf->SetFont('Arial', 'B', 10);
$pdf->setY(95);
$pdf->setX(150);
$pdf->Cell(5, $textypos, "Monto Adjunto:");
//-----------------------//-------------------------------------------------
$pdf->SetFont('Arial', '', 10);  // Sin negrita para los datos de la base de datos
$pdf->setY(95);
$pdf->setX(177);
$pdf->Cell(5, $textypos, $datosProveedor['ruc']);

//----------------------------//----------------------------------------
$pdf->SetFont('Arial', 'B', 10);
$pdf->setY(100);
$pdf->setX(150);
$pdf->Cell(5, $textypos, "Pago Acumulado:");
//-----------------------//-------------------------------------------------
$pdf->SetFont('Arial', '', 10);  // Sin negrita para los datos de la base de datos
$pdf->setY(100);
$pdf->setX(182);
$pdf->Cell(5, $textypos, $datosProveedor['ruc']);






//-------------------------Imputacion Presupuestaria--------------------------------------
$pdf->SetFont('Arial', 'B', 13);
$pdf->setY(113);
$pdf->setX(80);
$pdf->Cell(5, $textypos, "Imputacion Presupuestaria");

//----------------------------//----------------------------------------
$pdf->SetFont('Arial', 'B', 10);
$pdf->setY(120);
$pdf->setX(7);
$pdf->Cell(5, $textypos, "Periodo");

$pdf->SetFont('Arial', '', 10);
$pdf->setY(126);
$pdf->setX(9);
$pdf->Cell(5, $textypos, "2024");

//-----------------//----------------------------------------------------

$pdf->SetFont('Arial', 'B', 10);
$pdf->setY(120);
$pdf->setX(28);
$pdf->Cell(5, $textypos, "Tipo");


if (isset($datosProveedor['tipo'])) {
$pdf->SetFont('Arial', '', 10);  // tipo
$texto = $datosProveedor['tipo'];
$pdf->setY(123);
$pdf->setX(25);
$pdf->MultiCell(0, 10, utf8_decode($texto), 0, 'J'); // 'J' para justificar
}
//------------------------//-------------------------------------------------

$pdf->SetFont('Arial', 'B', 10);
$pdf->setY(120);
$pdf->setX(43);
$pdf->Cell(5, $textypos, "Programa");

$pdf->SetFont('Arial', '', 10);  // Sin negrita para los datos de la base de datos
$pdf->setY(126);
$pdf->setX(48);
$pdf->Cell(5, $textypos, $datosProveedor['codigo_pro']);

//------------------------//------------------------------------------

$pdf->SetFont('Arial', 'B', 10);
$pdf->setY(120);
$pdf->setX(65);
$pdf->Cell(5, $textypos, "Sub. Pro");

//----------------------//----------------------------------------

$pdf->SetFont('Arial', 'B', 10);
$pdf->setY(120);
$pdf->setX(86);
$pdf->Cell(5, $textypos, "Rubro");

//Calculo para el objeto del gasto


$pdf->SetFont('Arial', '', 10);  // Sin negrita para los datos de la base de datos
$pdf->setY(126);
$pdf->setX(88);
$pdf->Cell(5, $textypos, $datosProveedor['id_cc']);

//--------------------------//---------------------------------

$pdf->SetFont('Arial', 'B', 10);
$pdf->setY(120);
$pdf->setX(104);
$pdf->Cell(5, $textypos, "Org.");

$pdf->SetFont('Arial', '', 10);  // Sin negrita para los datos de la base de datos
$pdf->setY(126);
$pdf->setX(105);
$pdf->Cell(5, $textypos, $datosProveedor['codigo_of']);

//-----------------------------//---------------------------------

$pdf->SetFont('Arial', 'B', 10);
$pdf->setY(120);
$pdf->setX(118);
$pdf->Cell(5, $textypos, "Dpto.");

$pdf->SetFont('Arial', '', 10);  // Sin negrita para los datos de la base de datos
$pdf->setY(126);
$pdf->setX(120);
$pdf->Cell(5, $textypos, '10');

//----------------------------//---------------

$pdf->SetFont('Arial', 'B', 10);
$pdf->setY(120);
$pdf->setX(134);
$pdf->Cell(5, $textypos, "Concepto");


if (isset($datosProveedor['Descripcion'])) {
    $pdf->SetFont('Arial', '', 10);  // tipo
    $texto = $datosProveedor['Descripcion'];
    $pdf->setY(123);
    $pdf->setX(130);
    $pdf->MultiCell(0, 10, utf8_decode($texto), 0, 'J'); // 'J' para justificar
    }

//------------------------//----------------------

$pdf->SetFont('Arial', 'B', 10);
$pdf->setY(120);
$pdf->setX(173);
$pdf->Cell(5, $textypos, "Importe del Egreso");

$mpago=$datosProveedor['montopagado'];
$pdf->SetFont('Arial', '', 10);  // Sin negrita para los datos de la base de datos
$pdf->setY(126);
$pdf->setX(187);
$pdf->Cell(5, $textypos, number_format($mpago,0));

//----------------------------//----------------------------------------
$pdf->SetFont('Arial', 'B', 10);
$pdf->setY(123);
$pdf->setX(6);
$pdf->Cell(5, $textypos, "----------------------------------------------------------------------------------------------------------------------------------------------------------------------------");







//-------------------------------------- Retenciones aplicadas -----------------------------------//-----------------

$pdf->SetFont('Arial', 'B', 14);
$pdf->setY(205);
$pdf->setX(80);
$pdf->Cell(5, $textypos, "Retenciones aplicadas");
//-----------------------//-------------------------------------------------
$pdf->SetFont('Arial', '', 10);  // Sin negrita para los datos de la base de datos
$pdf->setY(215);
$pdf->setX(33);
$pdf->Cell(5, $textypos, $datosProveedor['detalle']);
//----------------------------//----------------------------------------
$pdf->SetFont('Arial', 'B', 10);
$pdf->setY(215);
$pdf->setX(7);
$pdf->Cell(5, $textypos, "Retencion IVA: ");



//-----------------------//-------------------------------------------------
$pdf->SetFont('Arial', '', 10);  // Sin negrita para los datos de la base de datos
$pdf->setY(223);
$pdf->setX(38);
$pdf->Cell(5, $textypos, $datosProveedor['detalle']);
//----------------------------//----------------------------------------
$pdf->SetFont('Arial', 'B', 10);
$pdf->setY(223);
$pdf->setX(7);
$pdf->Cell(5, $textypos, "Retencion Renta: ");



//-----------------------//-------------------------------------------------
$pdf->SetFont('Arial', '', 10);  // Sin negrita para los datos de la base de datos
$pdf->setY(231);
$pdf->setX(42);
$pdf->Cell(5, $textypos, $datosProveedor['detalle']);
//----------------------------//----------------------------------------
$pdf->SetFont('Arial', 'B', 10);
$pdf->setY(231);
$pdf->setX(7);
$pdf->Cell(5, $textypos, "Ret. Ley 2051 0,4%: ");





//-----------------------//-------------------------------------------------
$pdf->SetFont('Arial', '', 10);  // Sin negrita para los datos de la base de datos
$pdf->setY(239);
$pdf->setX(46);
$pdf->Cell(5, $textypos, $datosProveedor['detalle']);
//----------------------------//----------------------------------------
$pdf->SetFont('Arial', 'B', 10);
$pdf->setY(239);
$pdf->setX(7);
$pdf->Cell(5, $textypos, "Retencion Jubilatorio: ");




//-----------------------//-------------------------------------------------
$pdf->SetFont('Arial', '', 10);  // Sin negrita para los datos de la base de datos
$pdf->setY(215);
$pdf->setX(98);
$pdf->Cell(5, $textypos, $datosProveedor['detalle']);
//----------------------------//----------------------------------------
$pdf->SetFont('Arial', 'B', 10);
$pdf->setY(215);
$pdf->setX(80);
$pdf->Cell(5, $textypos, "Anticipo: ");






//-----------------------//-------------------------------------------------
$pdf->SetFont('Arial', '', 10);  // Sin negrita para los datos de la base de datos
$pdf->setY(223);
$pdf->setX(108);
$pdf->Cell(5, $textypos, $datosProveedor['detalle']);
//----------------------------//----------------------------------------
$pdf->SetFont('Arial', 'B', 10);
$pdf->setY(223);
$pdf->setX(80);
$pdf->Cell(5, $textypos, "Fondo Reparo: ");




//-----------------------//-------------------------------------------------
$pdf->SetFont('Arial', '', 10);  // Sin negrita para los datos de la base de datos
$pdf->setY(231);
$pdf->setX(119);
$pdf->Cell(5, $textypos, $datosProveedor['detalle']);
//----------------------------//----------------------------------------
$pdf->SetFont('Arial', 'B', 10);
$pdf->setY(231);
$pdf->setX(80);
$pdf->Cell(5, $textypos, "Multa Incumplimiento: ");


//-----------------------//-------------------------------------------------
// Obtén el valor del haber
$montopagado = $datosProveedor['montopagado'];

// Calcula el IVA (10%)
$iva = $montopagado * 0.4;

// Suma el IVA al haber para obtener el total con IVA
$totalSinIva = $montopagado - $iva;

$pdf->SetFont('Arial', '', 10);  // Sin negrita para los datos de la base de datos
$pdf->setY(239);
$pdf->setX(105);
$pdf->Cell(5, $textypos, number_format($totalSinIva, 0));
//----------------------------//----------------------------------------
$pdf->SetFont('Arial', 'B', 10);
$pdf->setY(239);
$pdf->setX(80);
$pdf->Cell(5, $textypos, "Otras Reten.: ");



//-----------------------//-------------------------------------------------
$mpagos=$datosProveedor['montopagado'];
$pdf->SetFont('Arial', '', 10);  // Sin negrita para los datos de la base de datos
$pdf->setY(215);
$pdf->setX(175);
$pdf->Cell(5, $textypos, number_format($mpagos,0));
//----------------------------//----------------------------------------
$pdf->SetFont('Arial', 'B', 10);
$pdf->setY(215);
$pdf->setX(150);
$pdf->Cell(5, $textypos, "Total Gastos: ");



//-----------------------//-------------------------------------------------
// Obtén el valor del haber
$montopagado = $datosProveedor['montopagado'];

// Calcula el IVA (10%)
$iva = $montopagado * 0.4;

// Suma el IVA al haber para obtener el total con IVA
$totalSinIva = $montopagado - $iva;

$pdf->SetFont('Arial', '', 10);  // Sin negrita para los datos de la base de datos
$pdf->setY(223);
$pdf->setX(178);
$pdf->Cell(5, $textypos, number_format($totalSinIva, 0));
//----------------------------//----------------------------------------
$pdf->SetFont('Arial', 'B', 10);
$pdf->setY(223);
$pdf->setX(150);
$pdf->Cell(5, $textypos, "Retenciones (-): ");




//-----------------------//-------------------------------------------------
$pdf->SetFont('Arial', '', 10);  // Sin negrita para los datos de la base de datos
$pdf->setY(231);
$pdf->setX(175);
$pdf->Cell(5, $textypos, number_format($iva, 0));
//----------------------------//----------------------------------------
$pdf->SetFont('Arial', 'B', 10);
$pdf->setY(231);
$pdf->setX(150);
$pdf->Cell(5, $textypos, "Neto Pagado: ");



//----------------------------//----------------------------------------

//Convierte los numeros del pago realizado a palabras
function convertirNumeroPalabras($numero) {
    $unidades = ['Cero', 'Uno', 'Dos', 'Tres', 'Cuatro', 'Cinco', 'Seis', 'Siete', 'Ocho', 'Nueve'];
    $decenas = ['', '', 'Veinte', 'Treinta', 'Cuarenta', 'Cincuenta', 'Sesenta', 'Setenta', 'Ochenta', 'Noventa'];
    $centenas = ['', 'Cien', 'Doscientos', 'Trescientos', 'Cuatrocientos', 'Quinientos', 'Seiscientos', 'Setecientos', 'Ochocientos', 'Novecientos'];

    $palabras = '';

    $millones = floor($numero / 1000000);
    $numero %= 1000000;
    $miles = floor($numero / 1000);
    $numero %= 1000;
    $centenas_miles = floor($numero / 100);
    $numero %= 100;
    $decenas_miles = floor($numero / 10);
    $unidades_miles = $numero % 10;

    if ($millones > 0) {
        if ($millones == 1) {
            $palabras .= 'Un Millon ';
        } else {
            $palabras .= convertirNumeroPalabras($millones) . ' Millones ';
        }
    }

    if ($miles > 0) {
        $palabras .= convertirNumeroPalabras($miles) . ' Mil ';
    }

    if ($centenas_miles > 0) {
        $palabras .= $centenas[$centenas_miles] . ' ';
    }

    if ($decenas_miles > 0 || $unidades_miles > 0) {
        if ($decenas_miles == 1) {
            $palabras .= 'Diez ';
        } elseif ($decenas_miles > 1) {
            $palabras .= $decenas[$decenas_miles];
        }

        

        if ($unidades_miles > 0) {
            $palabras .= $unidades[$unidades_miles] . ' ';
        }
    }

    return trim($palabras);
}


$pdf->SetFont('Arial', 'B', 10);
$pdf->setY(250);
$pdf->setX(7);
$pdf->Cell(5, $textypos, "Son Gs.: ");

$pdf->SetFont('Arial', '', 10);
$pdf->setY(250);
$pdf->setX(23);

$montopagado = $datosProveedor['montopagado'];
$haberEnPalabras = convertirNumeroPalabras($montopagado);

$pdf->Cell(5, $textypos, $haberEnPalabras);



//----------------------------//----------------------------------------
$pdf->SetFont('Arial', 'B', 10);
$pdf->setY(260);
$pdf->setX(7);
$pdf->Cell(5, $textypos, "Concepto: ");

if (isset($datosProveedor['Descripcion'])) {
    $pdf->SetFont('Arial', '', 10);  // tipo
    $texto = $datosProveedor['Descripcion'];
    $pdf->setY(258);
    $pdf->setX(27);
    $pdf->MultiCell(0, 10, utf8_decode($texto), 0, 'J'); // 'J' para justificar
    }




//----------------------------//----------------------------------------
$pdf->SetFont('Arial', 'B', 10);
$pdf->setY(275);
$pdf->setX(60);
$pdf->Cell(5, $textypos, "SE DISPONE EL PAGO DE LA SIGUIENTE OBLIGACION: ");




//----------------------------//----------------------------------------

$nombreUnidad = $this->session->userdata('unidad');

// Condición para Derecho

if($nombreUnidad=='Derecho'){
    $pdf->SetFont('Arial', 'B', 9);
    $pdf->setY(320);
    $pdf->setX(12);
    //$pdf->Cell(5, $textypos, "Dr. Sebastian A. Benitez Gonzalez");
    $pdf->Cell(5, $textypos, "Derecho 1");
    
    //----------------------------//----------------------------------------
    $pdf->SetFont('Arial', 'B', 8);
    $pdf->setY(325);
    $pdf->setX(16);
    $pdf->Cell(5, $textypos, "Esto es una prueba de derecho ");
    
    
    
    //----------------------------//----------------------------------------
    $pdf->SetFont('Arial', 'B', 9);
    $pdf->setY(320);
    $pdf->setX(150);
    $pdf->Cell(5, $textypos, "Derecho 2");
    
    //----------------------------//----------------------------------------
    $pdf->SetFont('Arial', 'B', 8);
    $pdf->setY(325);
    $pdf->setX(170);
    $pdf->Cell(5, $textypos, "Misma Prueba ");


}elseif($nombreUnidad=='Politecnica'){
    $pdf->SetFont('Arial', 'B', 9);
    $pdf->setY(320);
    $pdf->setX(12);
    //$pdf->Cell(5, $textypos, "Dr. Sebastian A. Benitez Gonzalez");
    $pdf->Cell(5, $textypos, "Poli 1");
    
    //----------------------------//----------------------------------------
    $pdf->SetFont('Arial', 'B', 8);
    $pdf->setY(325);
    $pdf->setX(16);
    $pdf->Cell(5, $textypos, "Esto es una prueba de la Poli ");
    
    
    
    //----------------------------//----------------------------------------
    $pdf->SetFont('Arial', 'B', 9);
    $pdf->setY(320);
    $pdf->setX(150);
    $pdf->Cell(5, $textypos, "Poli 2");
    
    //----------------------------//----------------------------------------
    $pdf->SetFont('Arial', 'B', 8);
    $pdf->setY(325);
    $pdf->setX(170);
    $pdf->Cell(5, $textypos, "Misma Prueba ");
    
}


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