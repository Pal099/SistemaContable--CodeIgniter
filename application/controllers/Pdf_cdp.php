<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pdf_cdp extends CI_Controller {

    public function index()
    {
        $this->load->model("Pdf_model"); // Load the model first
        $datos['titulo'] = 'Reporte de CDP';
        $datos['ultimosDatos'] = $this->Pdf_model->obtenerDatos_cdp($numero_asiento);
        $this->load->view('layouts/header');
        $this->load->view('fpdf_cdp', $datos);
        
        //$this->load->view('layouts/footer');
    }

    public function generarPDF_cdp($numero_asiento)    {
        require_once APPPATH . 'third_party/fpdf/fpdf.php';
    
        $this->load->model("Pdf_model"); // Load the model first
        $pdf = new FPDF();
        $datosProveedor = $this->Pdf_model->obtenerDatos_cdp($numero_asiento);
        // Obtener los datos correspondientes al número de asiento
    $datos['ultimosDatos'] = $this->Pdf_model->obtenerDatos_cdp($numero_asiento);
    $this->load->view('fpdf_cdp', $datos);
        $pdf->AddPage('L','legal',0);
       $pdf->SetFont('Arial','B',12);    
       $textypos = 5;

// Ajusta la posición vertical del título
$pdf->SetY(3);

$pdf->setX(10);
// Agregamos los datos de la empresa
$pdf->Image('assets/img/logoUNE.png', 90, 2, 25);
$pdf->SetFont('Arial', 'B', 20);
$pdf->Cell(0, 10, 'Universidad Nacional del Este', 0, 1, 'C');
$pdf->SetFont('Arial', 'B', 9);
$pdf->SetY(10);
$pdf->setX(10);
$pdf->Cell(0, 10, 'Campus Km 8 Acaray', 0, 1, 'C');
$pdf->SetY(15);
$pdf->setX(10);
$pdf->Cell(0, 10, 'Calle Universidad Nacional del Este y Rca. del Paraguay', 0, 1, 'C');
$pdf->SetY(20);
$pdf->setX(10);
$pdf->Cell(0, 10, 'Barrio San Juan Ciudad del Este Alto Parana', 0, 1, 'C');
   


 //---------------------Titulo para el cdp-----------//-------------------

 $pdf->SetFont('Arial', 'B', 10);
 $pdf->setY(28);
 $pdf->setX(135);
 $pdf->Cell(5, $textypos, "GESTION ADMINISTRATIVA   RECTORADO - UNE");

 $pdf->SetFont('Arial', 'B', 10);
 $pdf->setY(33);
 $pdf->setX(135);
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
                $pdf->Rect(6,$pdf->GetY(), 18, 4);
                $pdf->SetFont('Arial', 'B', 12);
                $pdf->Ln();
  

                // Rectangulo para programa
                $pdf->setY(48);
                $pdf->setX(115);
                $pdf->Rect(24,$pdf->GetY(), 12, 4);
                $pdf->SetFont('Arial', 'B', 12);
                $pdf->Ln();

                 // Rectangulo para sub
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
 $pdf->Rect(111,$pdf->GetY(), 60, 12);
 $pdf->SetFont('Arial', 'B', 12);
 $pdf->Ln();

  // Rectangulo para presupuesto actual
  $pdf->setY(40);
  $pdf->setX(100);
  $pdf->Rect(171,$pdf->GetY(), 30, 12);
  $pdf->SetFont('Arial', 'B', 12);
  $pdf->Ln();

    // Rectangulo para reserva presupuestaria
    $pdf->setY(40);
    $pdf->setX(8);
    $pdf->Rect(201,$pdf->GetY(), 37, 12);
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Ln();

     // Rectangulo para reserva obligado actual
     $pdf->setY(40);
     $pdf->setX(8);
     $pdf->Rect(238,$pdf->GetY(), 30, 12);
     $pdf->SetFont('Arial', 'B', 12);
     $pdf->Ln();

      // Rectangulo para reserva obligado actual
      $pdf->setY(40);
      $pdf->setX(8);
      $pdf->Rect(268,$pdf->GetY(), 38, 12);
      $pdf->SetFont('Arial', 'B', 12);
      $pdf->Ln();


    // Rectangulo para reserva obligado actual
    $pdf->setY(40);
    $pdf->setX(8);
    $pdf->Rect(306,$pdf->GetY(), 38, 12);
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Ln();

    //Rectangulo para Solicitud
    $pdf->setY(7);
    $pdf->setX(210);
    $pdf->Rect(268,$pdf->GetY(), 76, 13);
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Ln();



//------------ Rectangulo para total --------------------------
       $pdf->setY(67);
       $pdf->setX(8);
       $pdf->Rect(6,$pdf->GetY(), 338, 10);
       $pdf->SetFont('Arial', 'B', 12);
       $pdf->Ln();
   

    //---------------//-------------------------------//-----------------

       $datosProveedor = $this->Pdf_model->obtenerDatos_cdp($numero_asiento);

         // Define la posición inicial de la primera celda
          $yPos = 52;

            
           $pdf->SetFont('Arial', 'B', 12);
           $pdf->setY(42);
           $pdf->setX(40);
           $pdf->Cell(5, $textypos, "Linea Presupuestaria");
           //--------------------------//----------------------

   
           $pdf->SetFont('Arial', 'B', 9);
           $pdf->setY(48);
           $pdf->setX(10);
           $pdf->Cell(5, $textypos, "Tipo"); //tipo


           //--------------------------//----------------------

   
           $pdf->SetFont('Arial', 'B', 9);
           $pdf->setY(48);
           $pdf->setX(25);
           $pdf->Cell(5, $textypos, "Prog."); //Estos son los Prog.

           $pdf->SetFont('Arial', 'B', 9);
           $pdf->setY(48);
           $pdf->setX(38);
           $pdf->Cell(5, $textypos, "Sub."); //Estos son los Sub Prog.

           
           $pdf->SetFont('Arial', 'B', 9);
           $pdf->setY(48);
           $pdf->setX(55);
           $pdf->Cell(5, $textypos, "Obj"); //Estos son los Obj.

           $pdf->SetFont('Arial', 'B', 9);
           $pdf->setY(48);
           $pdf->setX(70);
           $pdf->Cell(5, $textypos, "F.F"); //Estos son los F.F


           $pdf->SetFont('Arial', 'B', 9);
           $pdf->setY(48);
           $pdf->setX(85);
           $pdf->Cell(5, $textypos, "O.F"); //Estos son los Org.

           
           $pdf->SetFont('Arial', 'B', 9);
           $pdf->setY(48);
           $pdf->setX(98);
           $pdf->Cell(5, $textypos, "Dpto."); //Estos son los Dpto.
           



           $pdf->SetFont('Arial', 'B', 12);
           $pdf->setY(42);
           $pdf->setX(130);
           $pdf->Cell(5, $textypos, "Descripcion");

//----------------------//----------------------------//--------------------------
           $pdf->SetFont('Arial', 'B', 11);
           $pdf->setY(42);
           $pdf->setX(171);
           $pdf->Cell(5, $textypos, "Presup. Actual");

//----------------------//----------------------------//--------------------------
        $pdf->SetFont('Arial', 'B', 11);
        $pdf->setY(42);
        $pdf->setX(205);
        $pdf->Cell(5, $textypos, "Reserva Presup.");

//----------------------//----------------------------//--------------------------
        $pdf->SetFont('Arial', 'B', 11);
        $pdf->setY(42);
        $pdf->setX(240);
        $pdf->Cell(5, $textypos, "Oblig. Actual");

        
//----------------------//----------------------------//--------------------------
        $pdf->SetFont('Arial', 'B', 11);
        $pdf->setY(42);
        $pdf->setX(270);
        $pdf->Cell(5, $textypos, "Oblig. Acumulado");

//----------------------//----------------------------//--------------------------
        $pdf->SetFont('Arial', 'B', 11);
        $pdf->setY(42);
        $pdf->setX(310);
        $pdf->Cell(5, $textypos, "Saldo Presup.");

           //-------------------//----------------------------


        $pdf->setY($yPos);


        if (isset($datosProveedor['tipo'])) {
            $texto = $datosProveedor['tipo'];
            $pdf->SetFont('Arial', '', 10);
            $pdf->setY(49);
            $pdf->setX(6);
            $pdf->MultiCell(0, 10, utf8_decode($texto), 0, 'J'); // 'J' para justificar
        }

           //-------------------//----------------------------
           if (isset($datosProveedor['pro_codigo'])) {
            $pdf->SetFont('Arial', '', 10);
            $pdf->setY(52);
            $pdf->setX(25);
            $pdf->Cell(5, $textypos, $datosProveedor['pro_codigo']);  // programa
        }
            //-------------------//----------------------------
            $pdf->SetFont('Arial', '', 11);
            $pdf->setY(52);
            $pdf->setX(40);
            $pdf->Cell(5, $textypos, "0");  // SubProg.

             //-------------------//----------------------------
             if (isset($datosProveedor['ff_codigo'])) {
                $pdf->SetFont('Arial', '', 10);
                $pdf->setY(52);
                $pdf->setX(70);
                $pdf->Cell(5, $textypos, $datosProveedor['ff_codigo']);  // programa
            }
             
            
             //-------------------//----------------------------
             if (isset($datosProveedor['of_codigo'])) {
                $pdf->SetFont('Arial', '', 10);
                $pdf->setY(52);
                $pdf->setX(85);
                $pdf->Cell(5, $textypos, $datosProveedor['of_codigo']);  // programa
            }

             //-------------------//----------------------------
             $pdf->SetFont('Arial', '', 11);
             $pdf->setY(52);
             $pdf->setX(100);
             $pdf->Cell(5, $textypos, "10");  // Dpto.


             
             //-------------------//----------------------------
             if (isset($datosProveedor['descripcion'])) {
                $texto = $datosProveedor['descripcion'];
                $pdf->SetFont('Arial', '', 12);
                $pdf->setY(50);
                $pdf->setX(122);
                $pdf->MultiCell(0, 10, utf8_decode($texto), 0, 'J'); // 'J' para justificar
            }  // Para descripcion.

             //-------------------//----------------------------
             if (isset($datosProveedor['presupuesto_ini'])) {
                $presuiniFormateado = number_format($datosProveedor['presupuesto_ini'], 0, ',', '.'); // Formato con 0 decimales, ',' como separador decimal y '.' como separador de miles

                $pdf->SetFont('Arial', '', 12);
                $pdf->setY(52);
                $pdf->setX(175);
                $pdf->Cell(5, $textypos, $presuiniFormateado);  
            }  // Para Presupuesto Actual.

             //-------------------//----------------------------
             /*$pdf->SetFont('Arial', '', 10);
             $pdf->setY(52);
             $pdf->setX(170);
             $pdf->Cell(5, $textypos, $datosProveedor[0]['ruc']);*/  // Para Reserva Presupuestaria.


             //-------------------//----------------------------
             if (isset($datosProveedor['debe'])) {
                $debeFormateado = number_format($datosProveedor['debe'], 0, ',', '.'); // Formato con 0 decimales, ',' como separador decimal y '.' como separador de miles
            
                $pdf->SetFont('Arial', '', 12);
                $pdf->setY(52);
                $pdf->setX(244);
                $pdf->Cell(5, $textypos, $debeFormateado);  // obligado actual
            }
            
            
            if (isset($datosProveedor['acumulado_anterior'])) {
                $acumuladoFormateado = number_format($datosProveedor['acumulado_anterior'], 0, ',', '.');
                $pdf->SetFont('Arial', '', 10);
                $pdf->setY(52);
                $pdf->setX(285);
                $pdf->Cell(5, $textypos, $acumuladoFormateado);
            }
            
            

                        // Ajusta la posición Y para la siguiente iteración
        $yPos += 10; // Puedes ajustar este valor según tus necesidades

    
    


// Agregamos los datos para la Solicitud------------------------------------

$pdf->SetFont('Arial', 'B', 12);
$pdf->setY(11);
$pdf->setX(270);
$pdf->Cell(5, $textypos, "Solicitud Nro: ");

// Check if the 'numero' key exists before accessing it
if (isset($datosProveedor['numero'])) {
    $pdf->SetFont('Arial', '', 15);
    $pdf->setY(11);
    $pdf->setX(335);
    $pdf->Cell(5, $textypos, $datosProveedor['numero']);  // numero
}


//----------------Agregamos Datos de obs----------------------------------
$pdf->SetFont('Arial', 'B', 12);
$pdf->setY(62);
$pdf->setX(7);
$pdf->Cell(5, $textypos, "Obs:");

             if (isset($datosProveedor['descripcion'])) {
                $texto = $datosProveedor['descripcion'];
                $pdf->SetFont('Arial', '', 12);
                $pdf->setY(62);
                $pdf->setX(20);
                $pdf->MultiCell(0, 5, utf8_decode($texto), 0, 'J'); // 'J' para justificar
            }  // Para descripcion.



//----------------Agregamos Datos de obs----------------------------------
$pdf->SetFont('Arial', 'B', 12);
$pdf->setY(70);
$pdf->setX(130);
$pdf->Cell(5, $textypos, "Total:");


if (isset($datosProveedor['presupuesto_ini'])) {
    $presuiniFormateado = number_format($datosProveedor['presupuesto_ini'], 0, ',', '.'); // Formato con 0 decimales, ',' como separador decimal y '.' como separador de miles

    $pdf->SetFont('Arial', '', 12);
    $pdf->setY(70);
    $pdf->setX(175);
    $pdf->Cell(5, $textypos, $presuiniFormateado);  
}  // Para Presupuesto Actual.

if (isset($datosProveedor['debe'])) {
    $debeFormateado = number_format($datosProveedor['debe'], 0, ',', '.'); // Formato con 0 decimales, ',' como separador decimal y '.' como separador de miles

    $pdf->SetFont('Arial', '', 12);
    $pdf->setY(70);
    $pdf->setX(244);
    $pdf->Cell(5, $textypos, $debeFormateado);  // obligado actual
}

if (isset($datosProveedor['acumulado_anterior'])) {
    $acumuladoFormateado = number_format($datosProveedor['acumulado_anterior'], 0, ',', '.');
    $pdf->SetFont('Arial', '', 10);
    $pdf->setY(70);
    $pdf->setX(285);
    $pdf->Cell(5, $textypos, $acumuladoFormateado);
}

/*$pdf->SetFont('Arial', '', 10);  
$pdf->setY(70);
$pdf->setX(195);
$pdf->Cell(5, $textypos, $datosProveedor[0]['ruc']);*/


/*$nombreUsuario = $this->session->userdata('Nombre_usuario');

$pdf->SetFont('Arial', 'B', 7);
$pdf->setY(330);
$pdf->setX(187);
$pdf->Cell(5, $textypos, "Usuario: ");


$pdf->SetFont('Arial', 'B', 7);
$pdf->setY(330);
$pdf->setX(198);
$pdf->Cell(5, $textypos, $nombreUsuario);*/

        $pdf->Output('Reporte CDP' , 'I' );
   }


    
    
    
}
