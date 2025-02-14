<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pdf_presupuesto extends CI_Controller {

    
    public function __construct()
    {
        parent::__construct();
        //	$this->permisos= $this->backend_lib->control();
        $this->load->model("Presupuesto_model");
        $this->load->model("Registros_financieros_model");
        $this->load->model("Origen_model");
        $this->load->model('ProgramGasto_model');
        $this->load->model('CuentaContable_model');
        $this->load->model('Usuarios_model');
        $this->load->model('EjecucionP_model');
        $this->load->model("Unidad_academica_model");
        $this->load->library('session');
        $this->load->model("Pdf_model"); // Load the model first


    }

    public function index()
    {
        $nombre = $this->session->userdata('Nombre_usuario');
        $id_user = $this->Usuarios_model->getUserIdByUserName($nombre);
        $id_uni_respon_usu = $this->Usuarios_model->getUserIdUniResponByUserId($id_user);
    
        $datos['titulo'] = 'Pdf_Presupuesto';
        $datos['ultimosDatos'] = $this->Pdf_model->getPresu($id_uni_respon_usu);
        // Agrega la variable que necesitas en la vista:
        $datos['id_uni_respon_usu'] = $id_uni_respon_usu;
    
        $this->load->view('layouts/header');
        $this->load->view('fpdf_presu', $datos);
        // $this->load->view('layouts/footer');
    }
    public function PDF_presu($id_uni_respon_usu)
    {
        require_once APPPATH . 'third_party/fpdf/fpdf.php';
        
        $pdf = new FPDF();
        $pdf->AddPage('L', 'Legal');
        $pdf->SetFont('Arial', 'B', 12);
        
        $datospresupuesto = $this->Pdf_model->getPresu($id_uni_respon_usu);
        
        // Agregar Logo y Encabezado
        $pdf->Image('assets/img/logoUNE.png', 40, 3, 25);
        $pdf->SetFont('Arial', 'B', 15);
        $pdf->Cell(0, 10, 'Universidad Nacional del Este', 0, 1, 'C');
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(0, 10, 'Campus Km 8 Acaray - Calle Universidad Nacional del Este y Rca. del Paraguay', 0, 1, 'C');
        $pdf->Cell(0, 10, 'Barrio San Juan, Ciudad del Este, Alto Parana', 0, 1, 'C');
        
        // Título
        $pdf->SetFont('Arial', 'B', 15);
        $pdf->Cell(0, 10, 'Programacion de los gastos', 0, 1, 'C');
        
        // Encabezado de la tabla
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->SetFillColor(200, 200, 200);
        $pdf->Cell(20, 10, 'Grupo', 1, 0, 'C', true);
        $pdf->Cell(20, 10, 'Sub Grupo', 1, 0, 'C', true);
        $pdf->Cell(35, 10, 'Obj. Gasto', 1, 0, 'C', true);
        $pdf->Cell(20, 10, 'F.F', 1, 0, 'C', true);
        $pdf->Cell(20, 10, 'O.F', 1, 0, 'C', true);
        $pdf->Cell(25, 10, 'Dpto', 1, 0, 'C', true);
        $pdf->Cell(50, 10, 'Descripcion', 1, 0, 'C', true);
        $pdf->Cell(20, 10, 'Gs', 1, 0, 'C', true);
        $pdf->Cell(30, 10, 'Total Presup.', 1, 0, 'C', true);
        $pdf->Cell(30, 10, 'Total Modificado', 1, 0, 'C', true);
        $pdf->Cell(30, 10, 'Total Vigente', 1, 1, 'C', true);
        
        // Contenido de la tabla
        $pdf->SetFont('Arial', '', 10);
        foreach ($datospresupuesto as $dato) {
            $totalVigente = $dato->TotalPresupuestado + $dato->TotalModificado;
            
            $pdf->Cell(20, 8, utf8_decode($dato->programa), 1);
            $pdf->Cell(20, 8, utf8_decode($dato->descripcion), 1);
            $pdf->Cell(35, 8, utf8_decode($dato->relacion), 1);
            $pdf->Cell(20, 8, utf8_decode($dato->fuente_de_financiamiento), 1);
            $pdf->Cell(20, 8, utf8_decode($dato->origen_de_financiamiento), 1);
            $pdf->Cell(25, 8, '10', 1, 0, 'C');
            $pdf->Cell(50, 8, utf8_decode($dato->descripcion), 1);
            $pdf->Cell(20, 8, '-', 1, 0, 'C');
            $pdf->Cell(30, 8, number_format($dato->TotalPresupuestado, 0, ',', '.'), 1, 0, 'R');
            $pdf->Cell(30, 8, number_format($dato->TotalModificado, 0, ',', '.'), 1, 0, 'R');
            $pdf->Cell(30, 8, number_format($totalVigente, 0, ',', '.'), 1, 1, 'R');
        }
        
        // Información del usuario
        $nombreUsuario = $this->session->userdata('Nombre_usuario');
        $pdf->SetFont('Arial', 'B', 7);
        $pdf->Cell(0, 10, "Usuario: $nombreUsuario", 0, 1, 'R');
        
        // Salida del PDF
        $pdf->Output('Reporte_de_Presupuesto.pdf', 'I');
    }
    
}
