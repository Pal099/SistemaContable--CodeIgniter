<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class LibroMayor_model extends CI_Model {

    public function __construct(){
        parent::__construct();
        // Cargar la base de datos si no se ha cargado automáticamente
        $this->load->database();
            $this->load->model("LibroMayor_model");

    }

    public function obtenerEntradasLibroMayor($fechaInicio = null, $fechaFin = null, $idcuentacontable = null, $idPro = null, $idFf = null, $idOf = null, $idForm = null){
        $this->db->select('na.FechaEmision, na.id_form, nad.numero, na.num_asi as Num_Asi_IDNum_Asi, nad.comprobante, nad.detalles as Descripcion, nad.Debe, nad.Haber, cc.Codigo_CC, cc.Descripcion_CC');
        $this->db->from('num_asi na');
        $this->db->join('num_asi_deta nad', 'na.num_asi = nad.Num_Asi_IDNum_Asi');
        $this->db->join('cuentacontable cc', 'nad.IDCuentaContable = cc.IDCuentaContable');
    
        // Filtros por fechas
        if (!empty($fechaInicio) && !empty($fechaFin) && $fechaInicio != '-1' && $fechaFin != '-1') {
            $this->db->where('na.FechaEmision >=', $fechaInicio);
            $this->db->where('na.FechaEmision <=', $fechaFin);
        }
    
        // Filtro por cuenta contable
        if (!empty($idcuentacontable) && $idcuentacontable != '-1') {
            $this->db->where('nad.IDCuentaContable', $idcuentacontable);
        }
    
        // Filtro por programa
        if (!empty($idPro) && $idPro != '-1') {
            $this->db->where('na.proyecto', $idPro);
        }
    
        // Filtro por fuente de financiamiento
        if (!empty($idFf) && $idFf != '-1') {
            $this->db->where('na.id_ff', $idFf);
        }
    
        // Filtro por origen de financiamiento
        if (!empty($idOf) && $idOf != '-1') {
            $this->db->where('na.id_of', $idOf);
        }
    
        // Filtro por id_form
        if (!empty($idForm) && $idForm != '-1') {
            $this->db->where('na.id_form', $idForm);
        }
    
        $query = $this->db->get();
    
        if ($query->num_rows() > 0) {
            $resultados = $query->result_array();
            $saldo = 0; // Inicializar saldo fuera del bucle
    
            foreach ($resultados as &$resultado) {
                // Determinar el tipo de cuenta basado en el inicio del Codigo_CC
                if (strpos($resultado['Codigo_CC'], "2") === 0 || strpos($resultado['Codigo_CC'], "3") === 0) {
                    // Para cuentas que empiezan con "2" o "3"
                    $saldo += ($resultado['Debe'] - $resultado['Haber']); // Actualiza el saldo
                } elseif (strpos($resultado['Codigo_CC'], "4") === 0 || strpos($resultado['Codigo_CC'], "8") === 0) {
                    // Para cuentas que empiezan con "4" o "8"
                    $saldo += ($resultado['Haber'] - $resultado['Debe']); // Actualiza el saldo
                }
                // Agregar el saldo calculado al array del resultado
                $resultado['Saldo'] = $saldo;
            }
    
            return $resultados;
        } else {
            return null;
        }
    }
    

    // Aquí puedes agregar otros métodos que necesites para tu modelo
}