<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class LibroMayor_model extends CI_Model {

    public function __construct(){
        parent::__construct();
        // Cargar la base de datos si no se ha cargado automáticamente
        $this->load->database();
    }

    public function obtenerEntradasLibroMayor($fechaInicio = null, $fechaFin = null, $idcuentacontable = null){
        $this->db->select('na.FechaEmision, nad.numero, na.num_asi as Num_Asi_IDNum_Asi, nad.comprobante, nad.detalles as Descripcion, nad.Debe, nad.Haber, cc.Codigo_CC, cc.Descripcion_CC');
        $this->db->from('num_asi na');
        $this->db->join('num_asi_deta nad', 'na.num_asi = nad.Num_Asi_IDNum_Asi');
        $this->db->join('cuentacontable cc', 'nad.IDCuentaContable = cc.IDCuentaContable');
        
        if (!empty($fechaInicio) && !empty($fechaFin)) {
            $this->db->where('na.FechaEmision >=', $fechaInicio);
            $this->db->where('na.FechaEmision <=', $fechaFin);
        }
        
        if (!empty($idcuentacontable)) {
            $this->db->where('nad.IDCuentaContable', $idcuentacontable);
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
