<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Balance_Gral extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Balance_Gral_model'); 
        $this->load->model('Usuarios_model');
    }

    public function listarBalancesPorNumeroCuenta() {
        
        $nombre = $this->session->userdata('Nombre_usuario');
		$id_user = $this->Usuarios_model->getUserIdByUserName($nombre);
		$id_uni_respon_usu = $this->Usuarios_model->getUserIdUniResponByUserId($id_user);
        $this->load->model('Balance_Gral_model');
        $balances = $this->Balance_Gral_model->getObtenerbalances($id_uni_respon_usu);
        $resultados= array();
        $total_Debe = 0;
        $total_Haber = 0;
        foreach ($balances as $balance) {
            $Codigo_CC = $balance->Codigo_CC;
            $descripcion_cc = $balance->Descripcion_CC;
            $total_Debe += $balance->Debe;
            $total_Haber += $balance->Haber;

            if (array_key_exists($Codigo_CC, $resultados)) {
                $resultados[$Codigo_CC]['Debe'] += $balance->Debe;
                $resultados[$Codigo_CC]['Haber'] += $balance->Haber;
            } else {
                $resultados[$Codigo_CC] = array(
                    'Descripcion_CC' => $descripcion_cc,
                    'Debe' => $balance->Debe,
                    'Haber' => $balance->Haber
                );
            }
        }

        $resultados['total_Debe'] = $total_Debe;
        $resultados['total_Haber'] = $total_Haber;
        $data['resultados'] = $resultados;
    
        $this->load->view("layouts/header");
        $this->load->view("layouts/aside");
        $this->load->view("admin/balancegral/list", $data);
        $this->load->view("layouts/footer");
    }
    }