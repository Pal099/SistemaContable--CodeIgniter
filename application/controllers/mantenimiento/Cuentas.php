<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cuentas extends CI_Controller {


    public function __construct(){
        parent::__construct();
        $this->load->model("Cuentas_model");
    }


 
    
    public function index()
    {
        $data = array(
            'cuentas' => $this->Cuentas_model->getCuentas(), 
        );
        $this->load->view("layouts/header");
        $this->load->view("layouts/aside");
        $this->load->view("admin/cuentas/list", $data);
        $this->load->view("layouts/footer");
    }

    public function add(){
        $this->load->view("layouts/header");
        $this->load->view("layouts/aside");
        $this->load->view("admin/cuentas/add");
        $this->load->view("layouts/footer");
    }

    public function store() { 
        $cuentacod = $this->input->post("cuenta_codigo");
        $descripcion_cuenta = $this->input->post("descripcion_cuenta");

        $data = array(
            'CodigoCuentaContable' => $cuentacod, 
            'DescripcionCuentaContable' => $descripcion_cuenta,
            'estado' => "1",
        );

        if ($this->Cuentas_model->save($data)) {
            redirect(base_url()."mantenimiento/cuentas");
        } else {
            $this->session->set_flashdata("error", "No se pudo guardar la información");
            redirect(base_url()."mantenimiento/cuentas/add");
        }
    }

    public function edit($id){
        $data  = array(
            'cuenta' => $this->Cuentas_model->getCuenta($id), 
        );
        $this->load->view("layouts/header");
        $this->load->view("layouts/aside");
        $this->load->view("admin/cuentas/edit", $data);
        $this->load->view("layouts/footer");
    }

    public function update(){
        $cuenta_codigo = $this->input->post("cuenta_codigo");
        $descripcion_cuenta = $this->input->post("descripcion_cuenta");

        $data = array(
            'CodigoCuentaContable' => $cuenta_codigo, 
            'DescripcionCuentaContable' => $descripcion_cuenta,
            'estado' => "1",
        );

        if ($this->Cuentas_model->update($idCuentas, $data)) {
            redirect(base_url()."mantenimiento/cuentas");
        } else {
            $this->session->set_flashdata("error", "No se pudo actualizar la información");
            redirect(base_url()."mantenimiento/cuentas/edit/".$idCuentas);
        }
    }

    public function view($id){
        $data  = array(
            'cuenta' => $this->Cuentas_model->getCuenta($id), 
        );
        $this->load->view("admin/cuentas/view", $data);
    }
}
