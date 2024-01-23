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
        if (!empty($fechaInicio) && !empty($fechaFin)) {
            $this->db->where('na.FechaEmision >=', $fechaInicio);
            $this->db->where('na.FechaEmision <=', $fechaFin);
        }
    
        // Filtro por cuenta contable
        if (!empty($idcuentacontable)) {
            $this->db->where('nad.IDCuentaContable', $idcuentacontable);
        }
    
        // Filtro por programa
        if (!empty($idPro)) {
            $this->db->where('na.proyecto', $idPro);
        }
    
        // Filtro por fuente de financiamiento
        if (!empty($idFf)) {
            $this->db->where('na.id_ff', $idFf);
        }
    
        // Filtro por origen de financiamiento
        if (!empty($idOf)) {
            $this->db->where('na.id_of', $idOf);
        }
    
        // Filtro por id_form
        if (!empty($idForm)) {
            $this->db->where('na.id_form', $idForm);
        }
    
        $query = $this->db->get();
    
    
        if($query->num_rows() > 0){
            return $query->result_array();
        } else {
            return null;
        }
    }
    

    // Aquí puedes agregar otros métodos que necesites para tu modelo
}
