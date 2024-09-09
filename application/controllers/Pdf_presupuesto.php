<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pdf_presupuesto extends CI_Controller {

    public function index()
    {
        $this->load->model("Pdf_model"); // Load the model first
        $datos['titulo'] = 'Pdf_Presupuesto';
        $datos['ultimosDatos'] = $this->Pdf_model->getPresu();
        $this->load->view('layouts/header');
        $this->load->view('fpdf_presu', $datos);
        // $this->load->view('layouts/footer');
    }

    public function PDF_presu()
    {
        require_once APPPATH . 'third_party/fpdf/fpdf.php';
    
        $this->load->model("Pdf_model"); // Load the model first
        $pdf = new FPDF();
        $datospresupuesto = $this->Pdf_model->getPresu();
        $pdf->AddPage('P', 'legal', 0);
        $pdf->SetFont('Arial', 'B', 12);
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

        // ---------------------------titulo-------------------------------//------------------------
        $pdf->SetFont('Arial', 'B', 15);
        $pdf->SetY(28);
        $pdf->setX(10);
        $pdf->Cell(0, 10, 'Programacion de los gastos', 0, 1, 'C');

        // Rectangulo para las columnas-------------
        $pdf->setY(40);
        $pdf->setX(6);
        $pdf->Rect(4, $pdf->GetY(), 207, 15);
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Ln();

        //---------------------------titulos de las columnas-------------------------------//------------------------

        //Columna para grupo--------------------
        $columnas = array(
            'Grupo' => 8,
            'Sub Grupo' => 19,
            'Obj. del Gasto' => 35,
            'F.F' => 48,
            'O.F' => 55,
            'Dpto' => 63,
            'Descripcion' => 88,
            'Gs' => 118,
            'Monto' => 132
        );

        $yPosition = 55; // Puedes ajustar esto según sea necesario

        foreach ($columnas as $columna => $x) {
            // Dibujar el título de la columna
            $pdf->SetFont('Arial', 'B', 10);
            $pdf->SetY(42); //Ubicacion de los titulos
            $pdf->setX($x);
            $pdf->Cell($x, 10, $columna, 0, 1, 'C');
        
            // Dibujar una línea vertical para separar la columna
            $pdf->Line($x, 40, $x, $pdf->GetY());
        }

        foreach ($this->Pdf_model->getPresu() as $datospresupuesto) {
             // Dibujar líneas verticales para separar cada columna
    foreach ($columnas as $x) {
        $pdf->Line($x, $yPosition - 0, $x, $yPosition + 0);
    }
            $pdf->SetFont('Arial', '', 10);
            $pdf->SetY($yPosition);
            $pdf->setX(5);
            $pdf->Cell(5, $textypos, utf8_decode($datospresupuesto->tipo)); // Tipo



//Columna para Objeto del gasto--------------------
$codigo_cc=$datospresupuesto->codi_cc;
$codigo_cc_str = strval($codigo_cc);
$digitos_789 = substr($codigo_cc_str, 10, 4);

$pdf->SetFont('Arial', '', 10);
$pdf->SetY($yPosition);
$pdf->setX(48);
$pdf->Cell(48, $textypos, $digitos_789); // objeto del gasto

//Columna para FF--------------------

$pdf->SetFont('Arial', '', 10);
$pdf->SetY($yPosition);
$pdf->setX(69);
$pdf->Cell(69, $textypos, $datospresupuesto->ff); // fuente de financiamiento

//Columna para OF--------------------

$pdf->SetFont('Arial', '', 10);
$pdf->SetY($yPosition);
$pdf->setX(79);
$pdf->Cell(79, $textypos, $datospresupuesto->of); // Origen de financiamiento

//Columna para Dpto--------------------

$pdf->SetFont('Arial', '', 10);
$pdf->SetY($yPosition);
$pdf->setX(92);
$pdf->Cell(5, 10, '10', 0, 1, 'C'); //Departamento de Alto Paraná -> 10

//Columna para Descripcion--------------------

$pdf->SetFont('Arial', '', 10);
$pdf->SetY($yPosition);
$pdf->setX(118);
$pdf->Cell(5, $textypos, utf8_decode($datospresupuesto->descripcion)); // Descripciom

            
//Columna para Gs--------------------

$pdf->SetFont('Arial', 'B', 10);
$pdf->SetY($yPosition);
$pdf->setX(175);
$pdf->Cell(5, 10, '-', 0, 1, 'C'); //Gs

//Columna para monto--------------------


$pdf->SetFont('Arial', '', 10);
$pdf->SetY($yPosition);
$pdf->setX(190);
$pdf->Cell(5, $textypos, number_format($datospresupuesto->presu_monto, 0, ',', '.')); // Monto con separador de miles



$yPosition += 8; // Incrementa la posición Y para la siguiente fila
}

//-----------------Traemos los datos de la lista de presupuestos-------------------------

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

$pdf->Output('Reporte de Presupuesto.pdf', 'I');
}
}
