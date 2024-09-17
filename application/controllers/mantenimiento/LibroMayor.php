<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class LibroMayor extends CI_Controller {

    public function __construct(){
        parent::__construct();
        $this->load->model("Proveedores_model");
        $this->load->model("ProgramGasto_model");
        $this->load->model("Cdp_model");
        $this->load->model("Usuarios_model");
        $this->load->model("Presupuesto_model");
        $this->load->model("Diario_obli_model");
        $this->load->model("LibroMayor_model");
        $this->load->library('pagination');
        $this->load->library('form_validation');
    }

    // Función para visualizar la página inicial del Libro Mayor con un formulario para seleccionar el rango de fechas
    public function index(){
        $nombre = $this->session->userdata('Nombre_usuario');
        $id_user = $this->Usuarios_model->getUserIdByUserName($nombre);
        $id_uni_respon_usu = $this->Usuarios_model->getUserIdUniResponByUserId($id_user);

        $data['asientos'] = $this->Diario_obli_model->GETasientos($id_uni_respon_usu);
        $data['proveedores'] = $this->Proveedores_model->getProveedores($id_uni_respon_usu);
        $data['programa'] = $this->Diario_obli_model->getProgramGastos($id_uni_respon_usu);
        $data['fuente_de_financiamiento'] = $this->Diario_obli_model->getFuentes($id_uni_respon_usu);
        $data['origen_de_financiamiento'] = $this->Diario_obli_model->getOrigenes($id_uni_respon_usu);
        $data['cuentacontable'] = $this->Diario_obli_model->getCuentaContable($id_uni_respon_usu);

        $this->load->view('layouts/header');
        $this->load->view('layouts/sideBar');
        $this->load->view('admin/libro/librolist', $data);
        $this->load->view('layouts/footer');
    }

    // Función para mostrar el Libro Mayor basado en un rango de fechas y, opcionalmente, una cuenta contable específica
    public function mostrarLibroMayor(){
        $fechaInicio = $this->input->post('fecha_inicio');
        $fechaFin = $this->input->post('fecha_fin');
        $idcuentacontable = $this->input->post('idcuentacontable');

        $nombre = $this->session->userdata('Nombre_usuario');
        $id_user = $this->Usuarios_model->getUserIdByUserName($nombre);
        $id_uni_respon_usu = $this->Usuarios_model->getUserIdUniResponByUserId($id_user);

        $entradasLibroMayor = $this->LibroMayor_model->obtenerEntradasLibroMayor($fechaInicio, $fechaFin, $idcuentacontable);
        error_log(print_r($entradasLibroMayor, true)); // Muestra las entradas en el log
        
        $data = array(
            'entradas' => $entradasLibroMayor,
            'fechaInicio' => $fechaInicio,
            'fechaFin' => $fechaFin,
            'idcuentacontable' => $idcuentacontable,
            'cuentacontable' => $this->Diario_obli_model->getCuentaContable($id_uni_respon_usu)
        );

        $this->load->view('layouts/header');
        $this->load->view('layouts/sideBar');
        $this->load->view('admin/libro/librolist', $data);
        $this->load->view('layouts/footer');
    }

    // Función para buscar cuentas contables por descripción
    public function buscarCuentaContable(){
        $descripcion = $this->input->post('descripcion_cc');
        $cuentas = $this->CuentaContable_model->buscarPorDescripcion($descripcion);
        echo json_encode($cuentas);
    }

    // Función para filtrar entradas del Libro Mayor por una cuenta contable específica
    public function filtrarEntradasPorCuentaContable(){
        $idCuentaContable = $this->input->post('idCuentaContable');
        

    }
    // En tu controlador LibroMayor.php



    // Otros métodos necesarios para la gestión del Libro Mayor podrían ir aquí
}