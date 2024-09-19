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

        $pdf->Cell(0, 20, 'Comprobante de la Solicitud ', 0, 1, 'C');




        // Rectángulo para el encabezado
        $pdf->setY(52);
        $pdf->setX(5);
        $pdf->Rect(6, $pdf->GetY(), 204, 20);
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Ln();

        //----------------//------------------------------------

        //Rectangulo para importe
        $pdf->setY(75);
        $pdf->setX(10);
        $pdf->Rect(6, $pdf->GetY(), 204, 170);
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Ln();


        //Rectangulo para importe pequeño
        $pdf->setY(75);
        $pdf->setX(10);
        $pdf->Rect(6, $pdf->GetY(), 204, 12);
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Ln();




        //----------------//------------------------------------

        //Rectangulo para total
        $pdf->setY(240);
        $pdf->setX(6);
        $pdf->Rect(6, $pdf->GetY(), 204, 45);
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Ln();
        //----------------//------------------------------------

        //Rectangulo para firmas
        $pdf->setY(285);
        $pdf->setX(6);
        $pdf->Rect(6, $pdf->GetY(), 204, 45);
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Ln();







        //----------------------------//----------------------------------------



        // ---------------------------- Primera Fila ----------------------------------------
// Título "Fecha Comprobante:"
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->setY(55);
        $pdf->setX(7);
        $pdf->Cell(5, $textypos, "Fecha Comprobante:");
        // Valor de la base de datos
        $pdf->SetFont('Arial', '', 10);
        $pdf->setX(40);
        $pdf->Cell(5, $textypos, $datosProveedor[0]['fecha']);

        // Título "Proveedor:"
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->setX(75);  // Posiciona más hacia la derecha
        $pdf->Cell(5, $textypos, "Proveedor:");
        // Valor de la base de datos
        $pdf->SetFont('Arial', '', 10);
        $pdf->setX(95);
        $pdf->Cell(5, $textypos, $datosProveedor[0]['ruc']);

        // Título "RUC:"
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->setX(130);  // Ajusta la posición
        $pdf->Cell(5, $textypos, "RUC:");
        // Valor de la base de datos
        $pdf->SetFont('Arial', '', 10);
        $pdf->setX(150);
        $pdf->Cell(5, $textypos, $datosProveedor[0]['ruc']);

        // Título "CC:"
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->setX(175);  // Ajusta la posición
        $pdf->Cell(5, $textypos, "CC:");
        // Valor de la base de datos
        $pdf->SetFont('Arial', '', 10);
        $pdf->setX(190);
        $pdf->Cell(5, $textypos, $nombreCuenta);

        // ---------------------------- Segunda Fila ----------------------------------------
// Título "Nro. Comprobante:"
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->setY(65);
        $pdf->setX(7);
        $pdf->Cell(5, $textypos, "Nro. Comprobante:");
        // Valor de la base de datos
        $pdf->SetFont('Arial', '', 10);
        $pdf->setX(40);
        $pdf->Cell(5, $textypos, $datosProveedor[0]['ruc']);

        // Título "Obs.:"
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->setX(75);  // Ajusta la posición
        $pdf->Cell(5, $textypos, "Obs.:");
        // Valor de la base de datos
        $pdf->SetFont('Arial', '', 10);
        $pdf->setX(95);
        $pdf->Cell(5, $textypos, $datosProveedor[0]['ruc']);

        // Título "Monto:"
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->setX(130);  // Ajusta la posición
        $pdf->Cell(5, $textypos, "Monto:");
        // Valor de la base de datos
        $pdf->SetFont('Arial', '', 10);
        $pdf->setX(150);
        $pdf->Cell(5, $textypos, $datosProveedor[0]['ruc']);

        // Ajuste del texto y campos dentro del rectángulo

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
        $pdf->setX(17);
        $pdf->Cell(5, $textypos, "Tipo");

        if (isset($datosProveedor['tipo'])) {
            $pdf->SetFont('Arial', '', 10);
            $texto = $datosProveedor['tipo'];
            $pdf->setY(90); // Ajustado de 105 a 85
            $pdf->setX(17);
            $pdf->MultiCell(0, 10, utf8_decode($texto), 0, 'J');
        }

        $pdf->SetFont('Arial', 'B', 8);
        $pdf->setY(80); // Ajustado de 95 a 80
        $pdf->setX(27);
        $pdf->Cell(5, $textypos, "Prog.");

        $pdf->SetFont('Arial', '', 10);
        $pdf->setY(90); // Ajustado de 105 a 85
        $pdf->setX(27);
        $pdf->Cell(5, $textypos, $datosProveedor[0]['codigo_pro']);

        $pdf->SetFont('Arial', 'B', 8);
        $pdf->setY(80); // Ajustado de 95 a 80
        $pdf->setX(37);
        $pdf->Cell(5, $textypos, "Objeto");

        $pdf->SetFont('Arial', '', 10);
        $pdf->setY(90); // Ajustado de 105 a 85
        $pdf->setX(37);
        $pdf->Cell(5, $textypos, $datosProveedor[0]['id_cc']);

        $pdf->SetFont('Arial', 'B', 8);
        $pdf->setY(80); // Ajustado de 95 a 80
        $pdf->setX(50);
        $pdf->Cell(5, $textypos, "FF");

        $pdf->SetFont('Arial', '', 10);
        $pdf->setY(90); // Ajustado de 105 a 85
        $pdf->setX(50);
        $pdf->Cell(5, $textypos, $datosProveedor[0]['id_cc']);

        $pdf->SetFont('Arial', 'B', 8);
        $pdf->setY(80); // Ajustado de 95 a 80
        $pdf->setX(60);
        $pdf->Cell(5, $textypos, "Org.");

        $pdf->SetFont('Arial', '', 10);
        $pdf->setY(90); // Ajustado de 105 a 85
        $pdf->setX(60);
        $pdf->Cell(5, $textypos, $datosProveedor[0]['codigo_of']);

        $pdf->SetFont('Arial', 'B', 8);
        $pdf->setY(80); // Ajustado de 95 a 80
        $pdf->setX(70);
        $pdf->Cell(5, $textypos, "Dpto.");

        $pdf->SetFont('Arial', '', 10);
        $pdf->setY(90); // Ajustado de 105 a 85
        $pdf->setX(70);
        $pdf->Cell(5, $textypos, '10');

        $pdf->SetFont('Arial', 'B', 9);
        $pdf->setY(80); // Ajustado de 95 a 80
        $pdf->setX(83);
        $pdf->Cell(5, $textypos, "Descripcion");

        $pdf->SetFont('Arial', '', 10);
        $pdf->setY(90); // Ajustado de 105 a 85
        $pdf->setX(83);
        $pdf->Cell(5, $textypos, $datosProveedor[0]['Descripcion']);

        // Cantidad
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->setY(80);
        $pdf->setX(125); // Ajusta X según el espacio necesario
        $pdf->Cell(5, $textypos, "Cant.");

        $pdf->SetFont('Arial', '', 10);
        $pdf->setY(90);
        $pdf->setX(125); // Ajusta X según el espacio necesario
        $pdf->Cell(5, $textypos, "---");

        // Precio Unitario
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->setY(80);
        $pdf->setX(135); // Ajusta X según el espacio necesario
        $pdf->Cell(5, $textypos, "Precio Un.");

        $pdf->SetFont('Arial', '', 10);
        $pdf->setY(90);
        $pdf->setX(135); // Ajusta X según el espacio necesario
        $pdf->Cell(5, $textypos, "---");

        // Exentas
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->setY(80);
        $pdf->setX(150); // Ajusta X según el espacio necesario
        $pdf->Cell(5, $textypos, "Exentas");

        $pdf->SetFont('Arial', '', 10);
        $pdf->setY(90);
        $pdf->setX(150); // Ajusta X según el espacio necesario
        $pdf->Cell(5, $textypos, "---");

        
        // Gravadas
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->setY(80);
        $pdf->setX(170); // Ajusta X según el espacio necesario
        $pdf->Cell(5, $textypos, "Gravadas");

        $pdf->SetFont('Arial', '', 10);
        $pdf->setY(90);
        $pdf->setX(170); // Ajusta X según el espacio necesario
        $pdf->Cell(5, $textypos, "---");

        // % IVA
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->setY(80);
        $pdf->setX(190); // Ajusta X según el espacio necesario
        $pdf->Cell(5, $textypos, "% IVA");

        $pdf->SetFont('Arial', '', 10);
        $pdf->setY(90);
        $pdf->setX(190); // Ajusta X según el espacio necesario
        $pdf->Cell(5, $textypos, "---");



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