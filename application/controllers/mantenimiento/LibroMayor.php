<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class LibroMayor extends CI_Controller {

    public function __construct(){
        parent::__construct();
        $this->load->model('LibroMayor_model');
        $this->load->model('CuentaContable_model'); // Asegúrate de cargar el modelo de Cuentas Contables
        // Cargar cualquier otra librería, helper, o modelo necesario
    }

    // Función para visualizar la página inicial del Libro Mayor con un formulario para seleccionar el rango de fechas
    public function index(){
        $this->load->view('layouts/header');
        $this->load->view('layouts/aside');
        $this->load->view('admin/libro/librolist'); // Cambiado de 'index' a 'librolist'
        $this->load->view('layouts/footer');
    }

    // Función para mostrar el Libro Mayor basado en un rango de fechas y, opcionalmente, una cuenta contable específica
    public function mostrarLibroMayor(){
        $fechaInicio = $this->input->post('fecha_inicio');
        $fechaFin = $this->input->post('fecha_fin');
        $idCuentaContable = $this->input->post('cuenta_contable'); // Asegúrate de que este campo existe en tu formulario

        // Obtener los datos del modelo
        $entradasLibroMayor = $this->LibroMayor_model->obtenerEntradasLibroMayor($fechaInicio, $fechaFin, $idCuentaContable);

        // Preparar los datos para la vista
        $data = array(
            'entradas' => $entradasLibroMayor,
            'fechaInicio' => $fechaInicio,
            'fechaFin' => $fechaFin,
            'idCuentaContable' => $idCuentaContable
        );

        // Cargar las vistas con los datos
        $this->load->view('layouts/header');
        $this->load->view('layouts/aside');
        $this->load->view('admin/libro/librolist', $data);
        $this->load->view('layouts/footer');
    }

    public function buscarCuentaContable(){
        $descripcion = $this->input->post('descripcion_cc');
        $cuentas = $this->CuentaContable_model->buscarPorDescripcion($descripcion);
        echo json_encode($cuentas);
    }
    
    // Otros métodos necesarios para la gestión del Libro Mayor podrían ir aquí
}
