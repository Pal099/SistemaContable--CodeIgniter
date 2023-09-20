<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CuentaContable extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('CuentaContable_model');  // Cargar el modelo
    }

    public function index() {
        $data = array(
            'cuentascontables' => $this->CuentaContable_model->getCuentasContables(),
        );
        $this->load->view('layouts/header');
        $this->load->view('layouts/aside');
        $this->load->view('admin/CuentaContable/list', $data);
        $this->load->view('layouts/footer');
    }

    public function add() {
        $this->load->view('layouts/header');
        $this->load->view('layouts/aside');
        $this->load->view('admin/CuentaContable/add');
        $this->load->view('layouts/footer');
    }
    
	public function store() {
        $codigo = $this->input->post("Codigo_CC");
        $descripcion = $this->input->post("Descripcion_CC");
        $tipo = $this->input->post("tipo");
        $imputable = $this->input->post("imputable");
        $padre_id = $this->input->post("padre_id");
    
        // Validación del formulario
        $this->form_validation->set_rules("Codigo_CC", "Código", "required|is_unique[cuentacontable.Codigo_CC]");
        $this->form_validation->set_rules("Descripcion_CC", "Descripción", "required");
        $this->form_validation->set_rules("tipo", "Tipo", "required");
        // ... (otros campos si es necesario)
    
        if ($this->form_validation->run() == TRUE) {
            // Preparar datos para insertar
            $data = array(
                'Codigo_CC' => $codigo,
                'Descripcion_CC' => $descripcion,
                'tipo' => $tipo,
                'imputable' => $imputable === 'true' ? 1 : 0,  // imputable es un booleano
                'padre_id' => $padre_id,
                'estado' => '1' 
            );
    
            // Insertar la nueva cuenta
            if ($this->CuentaContable_model->save($data)) {
                redirect(base_url() . "mantenimiento/CuentaContable");
            } else {
                $this->session->set_flashdata("error", "No se pudo guardar la información");
                redirect(base_url() . "mantenimiento/CuentaContable/add");
            }
        } else {
            $this->add();
        }
    }
    

    public function edit($id) {
        // Obtener la información actual de la cuenta contable
        $data = array(
            'cuentascontables' => $this->CuentaContable_model->getCuentasContables($id),
        );
        $this->load->view('layouts/header');
        $this->load->view('layouts/aside');
        $this->load->view('admin/CuentaContable/edit', $data);
        $this->load->view('layouts/footer');
    }

    public function update() {
        // Obtener los datos del formulario
        $idCuentaContable = $this->input->post('IDCuentaContable');
        $codigo = $this->input->post('Codigo_CC');
        $descripcion = $this->input->post('Descripcion_CC');
        $tipo = $this->input->post('tipo');
        $imputable = $this->input->post('imputable');
        $padre_id = $this->input->post('padre_id');

        // Validación del formulario
        $this->form_validation->set_rules('Codigo_CC', 'Código', 'required');
        $this->form_validation->set_rules('Descripcion_CC', 'Descripción', 'required');
        $this->form_validation->set_rules('tipo', 'Tipo', 'required');
        // ... (otros campos si es necesario)

        if ($this->form_validation->run() == TRUE) {
            // Preparar datos para actualizar
            $data = array(
                'Codigo_CC' => $codigo,
                'Descripcion_CC' => $descripcion,
                'tipo' => $tipo,
                'imputable' => $imputable === 'true' ? 1 : 0,
                'padre_id' => $padre_id,
            );

            // Actualizar la cuenta
            if ($this->CuentaContable_model->update($idCuentaContable, $data)) {
                redirect(base_url() . 'mantenimiento/CuentaContable');
            } else {
                $this->session->set_flashdata('error', 'No se pudo actualizar la información');
                redirect(base_url() . 'mantenimiento/CuentaContable/edit/' . $idCuentaContable);
            }
        } else {
            $this->edit($idCuentaContable);
        }
    }
    public function view($id) {
        $data = array(
            'cuentascontables' => $this->CuentaContable_model->getCuentasContables($id),
        );
        $this->load->view('layouts/header');
        $this->load->view('layouts/aside');
        $this->load->view('admin/CuentaContable/view', $data);
        $this->load->view('layouts/footer');
    }
    public function delete($id) {
        $data = array(
            'estado' => '0',  // Marcar la cuenta como inactiva
        );
        $this->CuentaContable_model->update($id, $data);
        echo 'mantenimiento/CuentaContable';
    }
}
       


?>
