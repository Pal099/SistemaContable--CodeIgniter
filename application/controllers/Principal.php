<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Principal extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        //	$this->permisos= $this->backend_lib->control();
        $this->load->model("Presupuesto_model");
        $this->load->model('Usuarios_model');   
        $this->load->model('CuentaContable_model');
    }

    public function index()
    {
        //Con la libreria Session traemos los datos del usuario
		//Obtenemos el nombre que nos va servir para obtener su id
		$nombre=$this->session->userdata('Nombre_usuario');

		//Con el método getUserIdByUserName en el modelo del usuario, nos devuelve el id
		//id conseguido mediante el nombre del usuario
		$id_user=$this->Usuarios_model->getUserIdByUserName($nombre);
		
		//Y finalmente, con el método getUserIdUniResponByUserId traemos el id_uni_respon_usu
		//esa id es importante para hacer las relaciones y registros por usuario
		$id_uni_respon_usu = $this->Usuarios_model->getUserIdUniResponByUserId($id_user);
		
		$data  = array(
			'presupuestos' => $this->Presupuesto_model->getPresu($id_uni_respon_usu),
			'cuentacontable'=>$this->CuentaContable_model->getCuentasContables($id_uni_respon_usu),
		);

        $this->load->view("layouts/header");
        $this->load->view("layouts/sideBar");
        $this->load->view("admin/principal", $data);
        $this->load->view("layouts/footer");
    }



   

    public function store()
    {
        // Aquí realiza el almacenamiento si es necesario
        // ...
    }

    public function add()
    {
        $this->load->view("layouts/header");
        $this->load->view("layouts/sideBar");
        $this->load->view("admin/categorias/add");
        $this->load->view("layouts/footer");
    }

    public function save($data)
    {
        // Aquí realiza el guardado si es necesario
        // ...
    }

    public function delete($id)
    {
        $data = array(
            'estado' => "0",
        );
        // Aquí realiza la eliminación si es necesario
        // ...
        echo "principal";
    }

}
