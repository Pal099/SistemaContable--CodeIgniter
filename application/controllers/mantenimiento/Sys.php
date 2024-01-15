<?php
class SyS extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->model('Balance_Gral_model');
        $this->load->library('pagination');
    }

    public function index() {
        $cuentasOriginales = $this->Balance_Gral_model->obtenerDatosCuentas();
        $data['cuentas'] = array();

        foreach ($cuentasOriginales as $cuenta) {
            $cuentasProcesadas = array();
            if ($this->calcularSumasCuentas($cuenta, $cuentasProcesadas)) {
                $data['cuentas'][] = $cuenta;
            }
        }
    


        $this->load->view("layouts/header");
        $this->load->view("layouts/aside");
        $this->load->view("admin/sys/list", $data);
        $this->load->view("layouts/footer");
    }
    public function GenerarExcel() {
        $data['cuentas'] = $this->Balance_Gral_model->obtenerDatosCuentas();
        
        foreach ($data['cuentas'] as &$cuenta) {
            $cuentasProcesadas = array(); // Arreglo para evitar duplicados
            $this->calcularSumasCuentas($cuenta, $cuentasProcesadas);
        }
			$this->load->view("admin/balancegral/generarexcel", $data);

	}

    private function calcularSumasCuentas(&$cuenta, &$cuentasProcesadas) {
        // Verificar si la cuenta ya fue procesada
        if (in_array($cuenta->IDCuentaContable, $cuentasProcesadas)) {
            return;
        }

        // Obtener primerDigito para la cuenta actual
        $primerDigito = substr($cuenta->Codigo_CC, 0, 1);

        // Obtener sumas de Debe y Haber para la cuenta actual
        $sumas = $this->Balance_Gral_model->obtenerSumasDebeHaber($cuenta->IDCuentaContable);
        $cuenta->TotalDebe = $sumas->TotalDebe;
        $cuenta->TotalHaber = $sumas->TotalHaber;
    
        // Obtener cuentas hijas
        $cuentasHijas = $this->Balance_Gral_model->obtenerCuentasHijas($cuenta->IDCuentaContable);
    
        // Recursivamente calcular sumas para las cuentas hijas
        foreach ($cuentasHijas as &$cuentaHija) {
            $this->calcularSumasCuentas($cuentaHija, $cuentasProcesadas);
        
            // Acumular sumas de cuentas hijas en la cuenta actual
            $cuenta->TotalDebe += $cuentaHija->TotalDebe;
            $cuenta->TotalHaber += $cuentaHija->TotalHaber;
        }
        
        // Aplica las reglas del switch después de procesar todas las cuentas hijas
        $primerDigito = substr($cuenta->Codigo_CC, 0, 1);
        switch ($primerDigito) {
            case '2':
            case '3':
                // Para cuentas que comienzan con 2 o 3
                $cuenta->TotalDeudor = $cuenta->TotalDebe - $cuenta->TotalHaber;
                $cuenta->TotalAcreedor = 0;
                break;
            case '4':
            case '5':
                // Para cuentas que comienzan con 4 o 5
                $cuenta->TotalDeudor = 0;
                $cuenta->TotalAcreedor = $cuenta->TotalHaber - $cuenta->TotalDebe;
                break;
            default:
                // Para otras cuentas
                $cuenta->TotalDeudor = $cuenta->TotalDebe - $cuenta->TotalHaber;
                $cuenta->TotalAcreedor = $cuenta->TotalHaber - $cuenta->TotalDebe;
                break;
        }
        
        // Decide si incluir o no la cuenta
        if ($cuenta->TotalDebe > 0 || $cuenta->TotalHaber > 0 || $cuenta->TotalDeudor > 0 || $cuenta->TotalAcreedor > 0) {
            return true;
        } else {
            return false;
        }
        
    
        // Almacenar cuentas hijas en la cuenta actual
        $cuenta->cuentasHijas = $cuentasHijas;

        // Agregar la cuenta actual al arreglo de cuentas procesadas
        $cuentasProcesadas[] = $cuenta->IDCuentaContable;
    }
}
?>