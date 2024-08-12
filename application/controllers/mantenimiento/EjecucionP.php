<?php
defined('BASEPATH') or exit('No direct script access allowed');

class EjecucionP extends CI_Controller
{

    //private $permisos;
    public function __construct()
    {
        parent::__construct();
        //	$this->permisos= $this->backend_lib->control();
        $this->load->model("EjecucionP_model");
        $this->load->model("Presupuesto_model");
        $this->load->model("CuentaContable_model");
        $this->load->model("Pago_obli_model");
        $this->load->model("Diario_obli_model");
        $this->load->model('Usuarios_model');
        $this->load->model("Registros_financieros_model");
		$this->load->model("Origen_model");
		$this->load->model('ProgramGasto_model');


    }


    public function index()
    {
  		//Con la libreria Session traemos los datos del usuario
		//Obtenemos el nombre que nos va servir para obtener su id
		$nombre = $this->session->userdata('Nombre_usuario');

		//Con el método getUserIdByUserName en el modelo del usuario, nos devuelve el id
		//id conseguido mediante el nombre del usuario
		$id_user = $this->Usuarios_model->getUserIdByUserName($nombre);

		//Y finalmente, con el método getUserIdUniResponByUserId traemos el id_uni_respon_usu
		//esa id es importante para hacer las relaciones y registros por usuario
		$id_uni_respon_usu = $this->Usuarios_model->getUserIdUniResponByUserId($id_user);

        // Ahora pasamos el ID como argumento al método getEjecucionesP().
        $data = array(
            'ejecucionpresupuestaria' => $this->EjecucionP_model->getSumaDebePorCuenta(),
            'fuente' => $this->Registros_financieros_model->getFuentes($id_uni_respon_usu),
			'origen' => $this->Origen_model->getOrigenes($id_uni_respon_usu),
			'programa' => $this->ProgramGasto_model->getProgramGastos($id_uni_respon_usu),
            'cuentas' => $this->CuentaContable_model->getCuentasContables($id_uni_respon_usu)
        );
        //var_dump($data['programa']);

        // Cargar vistas con datos
        $this->load->view("layouts/header");
		$this->load->view("layouts/aside");
        $this->load->view("admin/ejecucion/list_eje", $data);
        $this->load->view("layouts/footer");
    }

    public function view($id)
    {
        $data = array(
            'sumaDebePorCuenta' => $this->EjecucionP_model->getSumaDebePorCuenta(),
        );

        // Cargar vistas con datos
        $this->load->view("layouts/header");
		$this->load->view("layouts/aside");
        // Asegúrate de crear la vista 'reporte_ejecucion_presupuestaria' en la carpeta correspondiente
        $this->load->view("admin/ejecucion/list_eje", $data);
        $this->load->view("layouts/footer");
    }

}