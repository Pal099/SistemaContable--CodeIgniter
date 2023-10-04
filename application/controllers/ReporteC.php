<?php
defined('BASEPATH') or exit('No direct script access allowed');


class ReporteC extends CI_Controller
{

	public function index()
	{
		$datos['titulo'] = 'Generar PDF con librería FPDF desde Codeigniter';
		$this->load->view('layouts/header');
		$this->load->view('fpdf');
		//$this->load->view('layouts/footer');
	}
	public function hojaEnBlanco()
	{
		//Se agrega la clase desde thirdparty para usar FPDF
		require_once APPPATH . 'third_party/fpdf/fpdf.php';
		require 'cn.php';
		$consulta= "SELECT id, nombre, descripcion FROM categorias";
		$resultado= $mysqli->query($consulta);
		$display_heading = array('id' => '#', 'nombre' => 'Nombre', 'descripcion' => 'Observacion' );

		$pdf = new FPDF();
		$pdf->AddPage('P', 'A4', 0);
		//$pdf->SetFont('Arial','B',16);
		//$pdf->Cell(0,0,'Hola mundo FPDF desde Codeigniter',0,1,'C');
		//$pdf->SetTitle('Gernerado por Ruffo',0);
		$pdf->SetFont('Arial', 'B', 12);
		$textypos = 5;
		$pdf->setY(12);
		$pdf->setX(10);
		// Agregamos los datos de la empresa
		$pdf->Cell(5, $textypos, "Reporte de Categorias");
		$pdf->SetFont('Arial', 'B', 10);
		$pdf->setY(30);
		$pdf->setX(10);
		$pdf->Cell(5, $textypos, "DE:");
		$pdf->SetFont('Arial', '', 10);
		$pdf->setY(35);
		$pdf->setX(10);
		$pdf->Cell(5, $textypos, "PitStop");
		$pdf->setY(40);
		$pdf->setX(10);
		$pdf->Cell(5, $textypos, "Av. Centenerio calle los trigales ");
		$pdf->setY(45);
		$pdf->setX(10);
		$pdf->Cell(5, $textypos, "+595 978278878");
		$pdf->setY(50);
		$pdf->setX(10);
		$pdf->Cell(5, $textypos, "pitstop@pitstop.com");


		/// Apartir de aqui empezamos con la tabla de productos
		$pdf->setY(60);
		$pdf->setX(135);
		$pdf->Ln();
		/////////////////////////////
		while($row=$resultado->fetch_assoc()){
			$pdf->Cell(50 ,10 ,$row['id'],1,0,'C',0);
			$pdf->Cell(50 ,10 ,$row['nombre'],1,0,'C',0);
			$pdf->Cell(50 ,10 ,$row['descripcion'],1,0,'C',0);
			$pdf->Ln();
		}
		//$pdf->Ln();


		$pdf->Output('ReporteCategorias.pdf', 'I');
	}


}