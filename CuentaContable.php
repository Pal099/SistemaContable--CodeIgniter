<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CuentaContable extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper('url');

        $this->load->model('CuentaContable_model');  // Cargar el modelo
        $this->load->library('session');
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
        $tipo = $this->input->get('tipo');  // Obtener el tipo seleccionado desde la URL
        $data = array(
            'cuentasPadre' => $this->CuentaContable_model->getCuentasPorTipo($tipo),  // Obtener las cuentas padre basadas en el tipo
        );
        $this->load->view('layouts/header');
        $this->load->view('layouts/aside');
        $this->load->view('admin/CuentaContable/add', $data);
        $this->load->view('layouts/footer');
    }
    
    
	public function store() {

        $codigo = $this->input->post("Codigo_CC");
        $descripcion = $this->input->post("Descripcion_CC");
        $tipo = $this->input->post("tipo");
        $imputable = $this->input->post("imputable") === '1' ? 1 : 0;
        $padre_id = $this->input->post("padre_id");
    
        // Validación del formulario
        $this->form_validation->set_rules("Codigo_CC", "Código", "required|is_unique[cuentacontable.Codigo_CC]");
        $this->form_validation->set_rules("Descripcion_CC", "Descripción", "required");
        // ... (otros campos si es necesario)
        if ($this->form_validation->run() == TRUE) {
            // Preparar datos para insertar.
            $data = array(
                'Codigo_CC' => $codigo,
                'Descripcion_CC' => $descripcion,
                'tipo' => $tipo,
               'imputable' => $imputable,  // usar la variable booleana
                'padre_id' => $padre_id,
                'estado' => '1' 
            );
          //  echo "Tipo: $tipo";
           // die();
        
            // Insertar la nueva cuenta
            if ($this->CuentaContable_model->save($data)) {
                redirect(base_url() . "mantenimiento/CuentaContable");
            } else {
                $this->session->set_flashdata("error", "No se pudo guardar la información");
                redirect(base_url() . "mantenimiento/CuentaContable/add");
            }
            if (!$codigo || !$descripcion || !$tipo) {
                $this->session->set_flashdata("error", "Los campos Código, Descripción y Tipo son obligatorios");
                $this->add();
                return;
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
        $imputable = $this->input->post("imputable") === '1' ? 1 : 0;
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
                'imputable' => $imputable,  // usar la variable booleana
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

    private function generarCodigo($tipo, $padre_id = null) {
        switch ($tipo) {
            case 'Titulo':
                return $this->CuentaContable_model->getNextCodigoTitulo();
            case 'Grupo':
                return $this->CuentaContable_model->getNextCodigoGrupo($padre_id);
            case 'SubGrupo':
                return $this->CuentaContable_model->getNextCodigoSubGrupo($padre_id);
            case 'Cuenta':
                return $this->CuentaContable_model->getNextCodigoCuenta($padre_id);
            case 'SubCuenta':
                return $this->CuentaContable_model->getNextCodigoSubCuenta($padre_id);
            case 'Analitico1':
                return $this->CuentaContable_model->getNextCodigoAnalitico1($padre_id);
            case 'Analitico2':
                return $this->CuentaContable_model->getNextCodigoAnalitico2($padre_id);
                               
                // ... (otros casos)
        }
    }
    public function getCuentasPadre(){
        $tipoHijo = $this->input->post('tipo');
        $cuentasPadre = $this->CuentaContable_model->getCuentasPadrePorTipo($tipoHijo);
        
        // Devuelve la respuesta como JSON
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode([
                'success' => !empty($cuentasPadre),
                'data' => $cuentasPadre,
                'message' => !empty($cuentasPadre) ? '' : 'No se encontraron cuentas padre para el tipo seleccionado.'
            ]));
    }
    public function getCuentasPadrePorTipo(){
        $tipo = $this->input->post('tipo');
        $cuentasPadrePermitidas = $this->CuentaContable_model->getCuentasPadrePermitidasPorTipo($tipo);

        // Devolver la respuesta en formato JSON
        if($cuentasPadrePermitidas){
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode($cuentasPadrePermitidas));
        } else {
            $this->output
                ->set_status_header(404)
                ->set_content_type('application/json')
                ->set_output(json_encode(['message' => 'No se encontraron cuentas padre para el tipo seleccionado']));
        }
    }
    
}
       
?>
