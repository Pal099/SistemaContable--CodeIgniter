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

	}

    public function index()
    {
        // Con la librería Session traemos los datos del usuario
        // Obtenemos el nombre que nos va servir para obtener su id
        $nombre = $this->session->userdata('Nombre_usuario');
    
        // Con el método getUserIdByUserName en el modelo del usuario, nos devuelve el id
        // id conseguido mediante el nombre del usuario
        $id_user = $this->Usuarios_model->getUserIdByUserName($nombre);
    
        // Y finalmente, con el método getUserIdUniResponByUserId traemos el id_uni_respon_usu
        // esa id es importante para hacer las relaciones y registros por usuario
        $id_uni_respon_usu = $this->Usuarios_model->getUserIdUniResponByUserId($id_user);
    
        // Llamamos a la función ultimoSTR para obtener el valor de str
        $ultimo_str = $this->Diario_obli_model->ultimoSTR($id_user);
        $str = $this->Diario_obli_model->getSTRaumentado($id_user);
        $niveles = $this->Diario_obli_model->getNiveles();
    
        // Mostramos el resultado para verlo
        echo "<pre>";
        print_r($ultimo_str);
        print_r($niveles); 
        print_r("Str aumentado: ");
        print_r($str);
        echo "</pre>";
    }
}