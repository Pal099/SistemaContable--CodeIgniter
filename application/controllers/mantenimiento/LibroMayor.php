<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class LibroMayor extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('LibroMayor_model');
    }

    public function index() {
        $data['entradas'] = [];
        $this->load->view('admin/libro/librolist'); // Asegúrate de tener esta vista creada
    }

    

    public function buscarCuenta() {
        $descripcion_cuenta_contable = $this->input->post('descripcion_cuenta_contable');
        $filtros = array(
            'fecha_inicio' => $this->input->post('fecha_inicio'),
            'fecha_fin' => $this->input->post('fecha_fin'),
            'ver_diario' => $this->input->post('ver_diario'),
            'programa' => $this->input->post('programa'),
            'origen_financiamiento' => $this->input->post('origen_financiamiento'),
            'fuente_financiamiento' => $this->input->post('fuente_financiamiento'),
            'descripcion_cuenta_contable' => $descripcion_cuenta_contable,
        );
    
        if ($descripcion_cuenta_contable) {
            // Buscar por descripción de cuenta contable
            $cuenta = $this->LibroMayor_model->buscarPorDescripcion($descripcion_cuenta_contable);
            if ($cuenta) {
                // Aplicar filtros adicionales y obtener entradas
                $datos['entradas'] = $this->LibroMayor_model->obtenerEntradasConFiltros($filtros);
            } else {
                // Manejo de caso donde no se encuentra la cuenta
                $datos['entradas'] = [];
                // Aquí puedes agregar un mensaje de error si quieres
            }
        } else {
            // Manejar el caso donde no se ingresó una descripción
            $datos['entradas'] = [];
            // Aquí puedes agregar un mensaje de error si quieres
        }
    
        $this->load->view('admin/libro/librolist', $datos);
    }
    

}
