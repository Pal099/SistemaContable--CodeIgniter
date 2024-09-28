<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pdf extends CI_Controller
{

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
        $pdf->AddPage('P', 'legal', 0);
        $pdf->SetFont('Arial', 'B', 12);
        $textypos = 5;
        $nombreUsuario = $this->session->userdata('Nombre_usuario');
        $unidadAcademica = $this->Pdf_model->obtenerUnidadAcademicaPorNombreUsuario($nombreUsuario);
        $fuenteFinanciamiento = isset($datosProveedor[0]['fuente_financiamiento']) ? $datosProveedor[0]['fuente_financiamiento'] : 'No disponible';
        $nombreCuenta = $datosProveedor[0]['Descripcion'];


        // Ajusta la posición vertical del título
        $pdf->SetY(10);

        $pdf->setX(10);
        // Agregamos los datos de la empresa
        $pdf->Image('assets/img/logoUNE.png', 40, 3, 25);
        $pdf->SetFont('Arial', 'B', 15);
        $pdf->Cell(0, 10, 'Universidad Nacional del Este', 0, 1, 'C');
        $pdf->SetFont('Arial', 'B', 8);

        $pdf->SetY(22);
        $pdf->setX(10);
        $pdf->Cell(0, 10, 'GESTION ADMINISTRATIVA RECTORADO - UNE', 0, 1, 'C');
        $pdf->SetFont('Arial', 'B', 12);

        $pdf->Cell(0, 20, 'Pedido Interno - Proveedores ', 0, 1, 'C');




        // Rectángulo para el encabezado
        $pdf->setY(52);
        $pdf->setX(5);
        $pdf->Rect(6, $pdf->GetY(), 204, 23);
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Ln();

        //----------------//------------------------------------

        // Rectángulo para el nro.
        $pdf->setY(35);
        $pdf->setX(40);
        $pdf->Rect(165, $pdf->GetY(), 40, 8);
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Ln();



        //Rectangulo para importe pequeño
        $pdf->setY(75);
        $pdf->setX(10);
        $pdf->Rect(6, $pdf->GetY(), 204, 12);
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Ln();













        //----------------------------//----------------------------------------



        // ---------------------------- Primera Fila ----------------------------------------
// Título "Fecha Comprobante:"
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->setY(55);
        $pdf->setX(7);
        $pdf->Cell(5, $textypos, "Fecha Pedido:");
        // Valor de la base de datos
        $pdf->SetFont('Arial', '', 10);
        $pdf->setX(33);
        $pdf->Cell(5, $textypos, $datosProveedor[0]['fecha']);


        // ---------------------------- Segunda Fila ----------------------------------------
// Título "Dependencia Solicitante"
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->setY(62);
        $pdf->setX(7);
        $pdf->Cell(5, $textypos, "Dependencia Solicitante:");
        // Valor de la base de datos
        $pdf->SetFont('Arial', '', 10);
        $pdf->setX(50);
        $pdf->Cell(5, $textypos, $datosProveedor[0]['ruc']);


        // ---------------------------- Tercera  Fila ----------------------------------------
// Título "Local de salida:"
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->setY(69);
        $pdf->setX(7);
        $pdf->Cell(5, $textypos, "Local de salida:");
        // Valor de la base de datos
        $pdf->SetFont('Arial', '', 10);
        $pdf->setX(40);
        $pdf->Cell(5, $textypos, $datosProveedor[0]['ruc']);

        // LISTa

        $pdf->SetFont('Arial', 'B', 8);
        $pdf->setY(80); // Ajustado de 95 a 80
        $pdf->setX(7);
        $pdf->Cell(5, $textypos, "Item");

        $pdf->SetFont('Arial', '', 10);
        $pdf->setY(90); // Ajustado de 105 a 85
        $pdf->setX(7);
        $pdf->Cell(5, $textypos, "2024");

        $pdf->SetFont('Arial', 'B', 8);
        $pdf->setY(80); // Ajustado de 95 a 80
        $pdf->setX(20);
        $pdf->Cell(5, $textypos, "Codigo");

        if (isset($datosProveedor['tipo'])) {
            $pdf->SetFont('Arial', '', 10);
            $texto = $datosProveedor['tipo'];
            $pdf->setY(90); // Ajustado de 105 a 85
            $pdf->setX(20);
            $pdf->MultiCell(0, 10, utf8_decode($texto), 0, 'J');
        }

        $pdf->SetFont('Arial', 'B', 8);
        $pdf->setY(80); // Ajustado de 95 a 80
        $pdf->setX(70);
        $pdf->Cell(5, $textypos, "Descripcion");

        $pdf->SetFont('Arial', '', 10);
        $pdf->setY(90); // Ajustado de 105 a 85
        $pdf->setX(50);
        $pdf->Cell(5, $textypos, $datosProveedor[0]['codigo_pro']);

       

        // Precio Unitario
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->setY(80);
        $pdf->setX(140); // Ajusta X según el espacio necesario
        $pdf->Cell(5, $textypos, "cantidad Solicitada");

        $pdf->SetFont('Arial', '', 10);
        $pdf->setY(90);
        $pdf->setX(142); // Ajusta X según el espacio necesario
        $pdf->Cell(5, $textypos, "---");

        // Exentas
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->setY(80);
        $pdf->setX(160); // Ajusta X según el espacio necesario
        $pdf->Cell(5, $textypos, "Precio Referencial");

        $pdf->SetFont('Arial', '', 10);
        $pdf->setY(90);
        $pdf->setX(163); // Ajusta X según el espacio necesario
        $pdf->Cell(5, $textypos, "---");


        // Gravadas
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->setY(80);
        $pdf->setX(175); // Ajusta X según el espacio necesario
        $pdf->Cell(5, $textypos, "Cantidad Entregada");

        $pdf->SetFont('Arial', '', 10);
        $pdf->setY(90);
        $pdf->setX(180); // Ajusta X según el espacio necesario
        $pdf->Cell(5, $textypos, "---");

    


        //----------------------------//----------------------------------------

 







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

        $pdf->Output('Reporte Pago Obligacion.pdf', 'I');
    }





}