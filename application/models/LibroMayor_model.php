<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class LibroMayor_model extends CI_Model {

    public function __construct(){
        parent::__construct();
        $this->load->database();
    }

    public function obtenerEntradasLibroMayor($fechaInicio, $fechaFin, $idCuentaContable = null, $terminoBusqueda = ''){
        $this->db->select("
            nad.IDNum_Asi_Deta,
            nad.numero,
            nad.IDCuentaContable,
            nad.MontoPago,
            nad.Debe,
            nad.Haber,
            nad.comprobante,
            na.FechaEmision,
            na.Num_Asi,
            na.MontoTotal,
            cc.Codigo_CC,
            cc.Descripcion_CC
        ");
        $this->db->from('num_asi_deta nad');
        $this->db->join('num_asi na', 'nad.Num_Asi_IDNum_Asi = na.IDNum_Asi', 'inner');
        $this->db->join('cuentacontable cc', 'nad.IDCuentaContable = cc.IDCuentaContable', 'inner');
        $this->db->where('na.FechaEmision >=', $fechaInicio);
        $this->db->where('na.FechaEmision <=', $fechaFin);

        if ($idCuentaContable !== null) {
            $this->db->where('nad.IDCuentaContable', $idCuentaContable);
        }

        if (!empty($terminoBusqueda)) {
            $this->db->group_start();
            $this->db->like('cc.Codigo_CC', $terminoBusqueda);
            $this->db->or_like('cc.Descripcion_CC', $terminoBusqueda);
            $this->db->group_end();
        }

        $this->db->where('na.estado', 1); // Asumiendo que 1 representa 'activo'
        $this->db->where('nad.estado_registro', 1); // Asumiendo que 1 representa 'activo'

        $query = $this->db->get();
        return $query->result_array();
    }

    // Otros métodos relacionados con el Libro Mayor podrían ir aquí

}
