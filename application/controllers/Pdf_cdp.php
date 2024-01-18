<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pdf_cdp extends CI_Controller {

    public function index()
    {
        $this->load->model("Pdf_model"); // Load the model first
        $datos['titulo'] = 'Reporte de CDP';
        $datos['ultimosDatos'] = $this->Pdf_model->obtenerDatos();
        $this->load->view('layouts/header');
        $this->load->view('fpdf_cdp', $datos);
        
        //$this->load->view('layouts/footer');
    }

    public function generarPDF_cdp()
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
   


 //---------------------Titulo para el cdp-----------//-------------------

 $pdf->SetFont('Arial', 'B', 10);
 $pdf->setY(25);
 $pdf->setX(70);
 $pdf->Cell(5, $textypos, "GESTION ADMINISTRATIVA   RECTORADO - UNE");

 $pdf->SetFont('Arial', 'B', 10);
 $pdf->setY(30);
 $pdf->setX(70);
 $pdf->Cell(5, $textypos, "Certificado de Disponibilidad Presupuestaria (CDP)");

       

    // Rectangulo para linea presupuestaria
    $pdf->setY(40);
    $pdf->setX(8);
    $pdf->Rect(6,$pdf->GetY(), 105, 8);
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Ln();


                // Rectangulo para tipo
                $pdf->setY(48);
                $pdf->setX(8);
                $pdf->Rect(6,$pdf->GetY(), 15, 4);
                $pdf->SetFont('Arial', 'B', 12);
                $pdf->Ln();
  

                // Rectangulo para programa/sub
                $pdf->setY(48);
                $pdf->setX(108);
                $pdf->Rect(21,$pdf->GetY(), 15, 4);
                $pdf->SetFont('Arial', 'B', 12);
                $pdf->Ln();

                 // Rectangulo para programa/sub
                 $pdf->setY(48);
                 $pdf->setX(115);
                 $pdf->Rect(36,$pdf->GetY(), 15, 4);
                 $pdf->SetFont('Arial', 'B', 12);
                 $pdf->Ln();

                  // Rectangulo para obj
                  $pdf->setY(48);
                  $pdf->setX(115);
                  $pdf->Rect(51,$pdf->GetY(), 15, 4);
                  $pdf->SetFont('Arial', 'B', 12);
                  $pdf->Ln();

                  // Rectangulo para FF
                  $pdf->setY(48);
                  $pdf->setX(115);
                  $pdf->Rect(66,$pdf->GetY(), 15, 4);
                  $pdf->SetFont('Arial', 'B', 12);
                  $pdf->Ln();

                     // Rectangulo para Org.
                     $pdf->setY(48);
                     $pdf->setX(115);
                     $pdf->Rect(81,$pdf->GetY(), 15, 4);
                     $pdf->SetFont('Arial', 'B', 12);
                     $pdf->Ln();
 
                    // Rectangulo para Dpto.
                    $pdf->setY(48);
                    $pdf->setX(115);
                    $pdf->Rect(96,$pdf->GetY(), 15, 4);
                    $pdf->SetFont('Arial', 'B', 12);
                    $pdf->Ln();
//----------------//------------------------------------


 // Rectangulo para Descripcion
 $pdf->setY(40);
 $pdf->setX(8);
 $pdf->Rect(111,$pdf->GetY(), 25, 8);
 $pdf->SetFont('Arial', 'B', 12);
 $pdf->Ln();

  // Rectangulo para presupuesto actual
  $pdf->setY(40);
  $pdf->setX(8);
  $pdf->Rect(136,$pdf->GetY(), 25, 8);
  $pdf->SetFont('Arial', 'B', 12);
  $pdf->Ln();

    // Rectangulo para reserva presupuestaria
    $pdf->setY(40);
    $pdf->setX(8);
    $pdf->Rect(161,$pdf->GetY(), 25, 8);
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Ln();

     // Rectangulo para reserva obligado actual
     $pdf->setY(40);
     $pdf->setX(8);
     $pdf->Rect(186,$pdf->GetY(), 25, 8);
     $pdf->SetFont('Arial', 'B', 12);
     $pdf->Ln();

    //Rectangulo para Solicitud
    $pdf->setY(7);
    $pdf->setX(210);
    $pdf->Rect(153,$pdf->GetY(), 57, 13);
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Ln();

   

    //---------------//-------------------------------//-----------------

       $datosProveedor = $this->Pdf_model->obtenerDatos();

       // Verifica si hay datos en el array antes de intentar acceder a ellos
       if (!empty($datosProveedor)) {
            
           $pdf->SetFont('Arial', 'B', 10);
           $pdf->setY(42);
           $pdf->setX(40);
           $pdf->Cell(5, $textypos, "Linea Presupuestaria");
           //--------------------------//----------------------

   
           $pdf->SetFont('Arial', 'B', 8);
           $pdf->setY(47);
           $pdf->setX(10);
           $pdf->Cell(5, $textypos, "Tipo"); //Estos son los titulos


           //--------------------------//----------------------

   
           $pdf->SetFont('Arial', 'B', 8);
           $pdf->setY(47);
           $pdf->setX(25);
           $pdf->Cell(5, $textypos, "Prog."); //Estos son los titulos

           $pdf->SetFont('Arial', 'B', 8);
           $pdf->setY(47);
           $pdf->setX(36);
           $pdf->Cell(5, $textypos, "Sub Prog."); //Estos son los titulos


           
           $pdf->SetFont('Arial', 'B', 8);
           $pdf->setY(47);
           $pdf->setX(55);
           $pdf->Cell(5, $textypos, "Obj"); //Estos son los titulos

           $pdf->SetFont('Arial', 'B', 8);
           $pdf->setY(47);
           $pdf->setX(70);
           $pdf->Cell(5, $textypos, "F.F"); //Estos son los titulos


           $pdf->SetFont('Arial', 'B', 8);
           $pdf->setY(47);
           $pdf->setX(85);
           $pdf->Cell(5, $textypos, "Org."); //Estos son los titulos

           
           $pdf->SetFont('Arial', 'B', 8);
           $pdf->setY(47);
           $pdf->setX(98);
           $pdf->Cell(5, $textypos, "Dpto."); //Estos son los titulos



           $pdf->SetFont('Arial', 'B', 10);
           $pdf->setY(42);
           $pdf->setX(55);
           $pdf->Cell(5, $textypos, "Descripcion");
           //-------------------//----------------------------
           $pdf->SetFont('Arial', '', 10);
           $pdf->setY(52);
           $pdf->setX(15);
           $pdf->Cell(5, $textypos, $datosProveedor[0]['proveedor']);  // Nombre del proveedor
          
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


// Agregamos los datos para la Solicitud------------------------------------

$pdf->SetFont('Arial', 'B', 10);
$pdf->setY(11);
$pdf->setX(153);
$pdf->Cell(5, $textypos, "Solicitud Nro: ");

$pdf->SetFont('Arial', '', 10);  // Sin negrita para los datos de la base de datos
$pdf->setY(11);
$pdf->setX(200);
$pdf->Cell(5, $textypos, $datosProveedor[0]['ruc']);







        $pdf->Output('Reporte CDP' , 'I' );
   }


    
    
    
}
