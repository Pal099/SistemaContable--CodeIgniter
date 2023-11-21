<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class LibroMayor_model extends CI_Model {

    public function __construct(){
        parent::__construct();
        $this->load->database();
    }

    public function obtenerEntradasLibroMayor($fechaInicio, $fechaFin, $idCuentaContable = null){
        $this->db->select("
            nad.IDNum_Asi_Deta,
            nad.numero,
            nad.IDCuentaContable,
            nad.MontoPago,
            nad.Debe,
            nad.Haber,
            nad.comprobante,
            na.FechaEmision,
            na.num_asi,
            na.MontoTotal
        ");
        $this->db->from('num_asi_deta nad');
        $this->db->join('num_asi na', 'nad.Num_Asi_IDNum_Asi = na.IDNum_Asi', 'inner');
        $this->db->where('na.FechaEmision >=', $fechaInicio);
        $this->db->where('na.FechaEmision <=', $fechaFin);

        // Filtrar por cuenta contable si se proporciona un ID
        if ($idCuentaContable !== null) {
            $this->db->where('nad.IDCuentaContable', $idCuentaContable);
        }
         // Filtrar por término de búsqueda si se proporciona
    if (!empty($terminoBusqueda)) {
        $this->db->like('cc.Codigo_CC', $terminoBusqueda);
        $this->db->or_like('cc.Descripcion_CC', $terminoBusqueda);
    }

        // Filtrar por registros activos o cualquier otro criterio necesario
        $this->db->where('na.estado', 1); // Asumiendo que 1 representa 'activo'
        $this->db->where('nad.estado_registro', 1); // Asumiendo que 1 representa 'activo'

        $query = $this->db->get();
        return $query->result_array();
    }

    // Otros métodos relacionados con el Libro Mayor podrían ir aquí

}
