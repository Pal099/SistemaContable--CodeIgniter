<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class LibroMayor_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }
    public function buscarPorDescripcion($descripcion) {
        $this->db->like('Descripcion_CC', $descripcion);
        $query = $this->db->get('cuentacontable');
        return $query->row_array(); // Devuelve la primera cuenta que coincide
    }



    public function obtenerEntradasConFiltros($filtros) {
        $this->db->select('nd.*, na.FechaEmision, cc.Codigo_CC, cc.Descripcion_CC');
        $this->db->from('num_asi_deta as nd');
        $this->db->join('num_asi as na', 'nd.Num_Asi_IDNum_Asi = na.IDNum_Asi', 'inner');
        $this->db->join('cuentacontable as cc', 'nd.IDCuentaContable = cc.IDCuentaContable', 'inner');
        
        if (!empty($filtros['codigo_cuenta_contable'])) {
            $this->db->group_start();
            $this->db->like('cc.Codigo_CC', $filtros['codigo_cuenta_contable']);
            $this->db->or_like('cc.Descripcion_CC', $filtros['codigo_cuenta_contable']);
            $this->db->group_end();
        }
        // Aplicar filtros de fecha
        if (!empty($filtros['fecha_inicio'])) {
            $this->db->where('na.FechaEmision >=', $filtros['fecha_inicio']);
        }
        if (!empty($filtros['fecha_fin'])) {
            $this->db->where('na.FechaEmision <=', $filtros['fecha_fin']);
        }
        
        // Filtro por código de cuenta contable
        if (!empty($filtros['codigo_cuenta_contable'])) {
            $this->db->like('cc.Codigo_CC', $filtros['codigo_cuenta_contable']);
            $this->db->or_like('cc.Descripcion_CC', $filtros['codigo_cuenta_contable']);
        }

        // Filtro por tipo de diario
        if (!empty($filtros['ver_diario']) && $filtros['ver_diario'] !== 'todos') {
            // Aquí necesitarás ajustar la condición según cómo se identifiquen los tipos de diario en tu base de datos
            $this->db->where('na.tipo_diario', $filtros['ver_diario']); // Cambia 'tipo_diario' por la columna correspondiente
        }

        // Filtro por programa
        if (!empty($filtros['programa']) && $filtros['programa'] !== 'todos') {
            $this->db->where('nd.id_pro', $filtros['programa']);
        }

        // Filtro por origen de financiamiento
        if (!empty($filtros['origen_financiamiento']) && $filtros['origen_financiamiento'] !== 'todos') {
            $this->db->where('nd.id_of', $filtros['origen_financiamiento']);
        }

        // Filtro por fuente de financiamiento
        if (!empty($filtros['fuente_financiamiento']) && $filtros['fuente_financiamiento'] !== 'todos') {
            $this->db->where('nd.id_ff', $filtros['fuente_financiamiento']);
        };
        if (!empty($filtros['descripcion_cuenta_contable'])) {
            $this->db->like('cc.Descripcion_CC', $filtros['descripcion_cuenta_contable']);
        }

        $query = $this->db->get();
        return $query->result_array();
    }
}
