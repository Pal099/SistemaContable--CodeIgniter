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
           $pdf->Cell(5, $textypos, "Razon Social:");
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
       $pdf->SetFont('Arial', 'B', 15);
$pdf->setY(35);
$pdf->setX(135);
$pdf->Cell(5, $textypos, "Datos del Egreso:");

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


       /// Apartir de aqui empezamos con la tabla de productos
       $pdf->setY(65);$pdf->setX(135);
       $pdf->Ln();
       /////////////////////////////
       //// Array de Cabecera
       $header = array("Cod.", "Descripcion","Cant.","Precio","Total");
       //// Arrar de Productos
       $products = array(
           array("0010", "Producto 1",2,120,0),
           array("0024", "Producto 2",5,80,0),
           array("0001", "Producto 3",1,40,0),
           array("0001", "Producto 3",5,80,0),
           array("0001", "Producto 3",4,30,0),
           array("0001", "Producto 3",7,80,0),
       );
           // Column widths
           $w = array(20, 95, 20, 25, 25);
           // Header
           for($i=0;$i<count($header);$i++)
               $pdf->Cell($w[$i],7,$header[$i],1,0,'C');
           $pdf->Ln();
           // Data
           $total = 0;
           foreach($products as $row)
           {
               $pdf->Cell($w[0],6,$row[0],1);
               $pdf->Cell($w[1],6,$row[1],1);
               $pdf->Cell($w[2],6,number_format($row[2]),'1',0,'R');
               $pdf->Cell($w[3],6,"$ ".number_format($row[3],2,".",","),'1',0,'R');
               $pdf->Cell($w[4],6,"$ ".number_format($row[3]*$row[2],2,".",","),'1',0,'R');

               $pdf->Ln();
               $total+=$row[3]*$row[2];

           }
       /////////////////////////////
       //// Apartir de aqui esta la tabla con los subtotales y totales
       $yposdinamic = 60 + (count($products)*10);

       $pdf->setY($yposdinamic);
       $pdf->setX(235);
           $pdf->Ln();
       /////////////////////////////
       $header = array("", "");
       $data2 = array(
           array("Subtotal",$total),
           array("Descuento", 0),
           array("Impuesto", 0),
           array("Total", $total),
       );
           // Column widths
           $w2 = array(40, 40);
           // Header

           $pdf->Ln();
           // Data
           foreach($data2 as $row)
           {
       $pdf->setX(115);
               $pdf->Cell($w2[0],6,$row[0],1);
               $pdf->Cell($w2[1],6,"$ ".number_format($row[1], 2, ".",","),'1',0,'R');

               $pdf->Ln();
           }
       /////////////////////////////

       $yposdinamic += (count($data2)*10);
       $pdf->SetFont('Arial','B',10);    

       $pdf->setY($yposdinamic);
       $pdf->setX(10);
       $pdf->Cell(5,$textypos,"TERMINOS Y CONDICIONES");
       $pdf->SetFont('Arial','',10);    

       $pdf->setY($yposdinamic+10);
       $pdf->setX(10);
       $pdf->Cell(5,$textypos,"El cliente se compromete a pagar la factura.");
       $pdf->setY($yposdinamic+20);
       $pdf->setX(10);
       $pdf->Cell(5,$textypos,"Powered by Evilnapsis");



        $pdf->Output('paginaEnBlanco.pdf' , 'I' );
   }


public function recibo()
   {
        //Se agrega la clase desde thirdparty para usar FPDF
        require_once APPPATH.'third_party/fpdf/fpdf.php';
           
        $pdf = new FPDF();
        $pdf->AddPage('P','A4',0);
        $pdf->SetFont('Arial','B',16);
        //$pdf->Cell(0,0,'Hola mundo FPDF desde Codeigniter',0,1,'C');
       $pdf->SetFont('Arial','B',12);    
       $textypos = 5;
       $pdf->setY(12);
       $pdf->setX(10);
       // Agregamos los datos de la empresa
       $pdf->Cell(5,$textypos,"FACTURA CON FPDF Y");
       $pdf->SetFont('Arial','B',10);    
       $pdf->setY(30);$pdf->setX(10);
       $pdf->Cell(5,$textypos,"DE:");
       $pdf->SetFont('Arial','',10);    
       $pdf->setY(35);$pdf->setX(10);
       $pdf->Cell(5,$textypos,"Nombre de la empresa");
       $pdf->setY(40);$pdf->setX(10);
       $pdf->Cell(5,$textypos,"Direccion de la empresa");
       $pdf->setY(45);$pdf->setX(10);
       $pdf->Cell(5,$textypos,"Telefono de la empresa");
       $pdf->setY(50);$pdf->setX(10);
       $pdf->Cell(5,$textypos,"Email de la empresa");

       // Agregamos los datos del cliente
       $pdf->SetFont('Arial','B',10);    
       $pdf->setY(30);$pdf->setX(75);
       $pdf->Cell(5,$textypos,"PARA:");
       $pdf->SetFont('Arial','',10);    
       $pdf->setY(35);$pdf->setX(75);
       $pdf->Cell(5,$textypos,"Nombre del cliente");
       $pdf->setY(40);$pdf->setX(75);
       $pdf->Cell(5,$textypos,"Direccion del cliente");
       $pdf->setY(45);$pdf->setX(75);
       $pdf->Cell(5,$textypos,"Telefono del cliente");
       $pdf->setY(50);$pdf->setX(75);
       $pdf->Cell(5,$textypos,"Email del cliente");

       // Agregamos los datos del cliente
       $pdf->SetFont('Arial','B',10);    
       $pdf->setY(30);$pdf->setX(135);
       $pdf->Cell(5,$textypos,"FACTURA #12345");
       $pdf->SetFont('Arial','',10);    
       $pdf->setY(35);$pdf->setX(135);
       $pdf->Cell(5,$textypos,"Fecha: 11/DIC/2019");
       $pdf->setY(40);$pdf->setX(135);
       $pdf->Cell(5,$textypos,"Vencimiento: 11/ENE/2020");
       $pdf->setY(45);$pdf->setX(135);
       $pdf->Cell(5,$textypos,"");
       $pdf->setY(50);$pdf->setX(135);
       $pdf->Cell(5,$textypos,"");

       /// Apartir de aqui empezamos con la tabla de productos
       $pdf->setY(60);$pdf->setX(135);
       $pdf->Ln();
       /////////////////////////////
       //// Array de Cabecera
       $header = array("Cod.", "Descripcion","Cant.","Precio","Total");
       //// Arrar de Productos
       $products = array(
           array("0010", "Producto 1",2,120,0),
           array("0024", "Producto 2",5,80,0),
           array("0001", "Producto 3",1,40,0),
           array("0001", "Producto 3",5,80,0),
           array("0001", "Producto 3",4,30,0),
           array("0001", "Producto 3",7,80,0),
       );
           // Column widths
           $w = array(20, 95, 20, 25, 25);
           // Header
           for($i=0;$i<count($header);$i++)
               $pdf->Cell($w[$i],7,$header[$i],1,0,'C');
           $pdf->Ln();
           // Data
           $total = 0;
           foreach($products as $row)
           {
               $pdf->Cell($w[0],6,$row[0],1);
               $pdf->Cell($w[1],6,$row[1],1);
               $pdf->Cell($w[2],6,number_format($row[2]),'1',0,'R');
               $pdf->Cell($w[3],6,"$ ".number_format($row[3],2,".",","),'1',0,'R');
               $pdf->Cell($w[4],6,"$ ".number_format($row[3]*$row[2],2,".",","),'1',0,'R');

               $pdf->Ln();
               $total+=$row[3]*$row[2];

           }
       /////////////////////////////
       //// Apartir de aqui esta la tabla con los subtotales y totales
       $yposdinamic = 60 + (count($products)*10);

       $pdf->setY($yposdinamic);
       $pdf->setX(235);
           $pdf->Ln();
       /////////////////////////////
       $header = array("", "");
       $data2 = array(
           array("Subtotal",$total),
           array("Descuento", 0),
           array("Impuesto", 0),
           array("Total", $total),
       );
           // Column widths
           $w2 = array(40, 40);
           // Header

           $pdf->Ln();
           // Data
           foreach($data2 as $row)
           {
       $pdf->setX(115);
               $pdf->Cell($w2[0],6,$row[0],1);
               $pdf->Cell($w2[1],6,"$ ".number_format($row[1], 2, ".",","),'1',0,'R');

               $pdf->Ln();
           }
       /////////////////////////////

        $pdf->Output('recibo.pdf' , 'I' );
   }
    
    
    
    
}
