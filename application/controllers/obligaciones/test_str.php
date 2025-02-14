<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Test_Str extends CI_Controller
{

	//private $permisos;
	public function __construct()
	{
		parent::__construct();
		$this->load->model("Diario_obli_model");
		$this->load->model("Usuarios_model");
        $this->load->model("Pago_obli_model");

	}

    public function index()
    {
		$nombre = $this->session->userdata('Nombre_usuario');

		//Con el método getUserIdByUserName en el modelo del usuario, nos devuelve el id
		//id conseguido mediante el nombre del usuario
		$id_user = $this->Usuarios_model->getUserIdByUserName($nombre);

		//Y finalmente, con el método getUserIdUniResponByUserId traemos el id_uni_respon_usu
		//esa id es importante para hacer las relaciones y registros por usuario
		$id_uni_respon_usu = $this->Usuarios_model->getUserIdUniResponByUserId($id_user);
        
        $cuentas = $this->Pago_obli_model->getCuentasContables($id_uni_respon_usu);
    
        // Mostramos el resultado para verlo
        echo "<pre>";
        print_r("Cuentas contables: ");
        print_r($cuentas);
        echo "</pre>";
    }
}