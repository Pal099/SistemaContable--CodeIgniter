<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class LibroMayor extends CI_Controller {

    public function __construct(){
        parent::__construct();
        $this->load->model('LibroMayor_model');
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
        $fechaInicio = $this->input->post('fecha_inicio'); // Recibir datos del formulario
        $fechaFin = $this->input->post('fecha_fin');
        $idCuentaContable = $this->input->post('cuenta_contable'); // Puede ser null
        $terminoBusqueda = $this->input->post('busquedaCuentaContable'); // Recibir el término de búsqueda del formulario
        // Obtener los datos del modelo
        $entradasLibroMayor = $this->LibroMayor_model->obtenerEntradasLibroMayor($fechaInicio, $fechaFin, $idCuentaContable, $terminoBusqueda);
    
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
        $this->load->view('admin/libro/librolist', $data); // Asegúrate de que esta vista exista
        $this->load->view('layouts/footer');
    }
    
    // Otros métodos necesarios para la gestión del Libro Mayor podrían ir aquí

}
