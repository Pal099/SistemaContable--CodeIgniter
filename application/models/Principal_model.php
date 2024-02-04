<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Principal_model extends CI_Model {

    // ... Otros métodos ...

    public function getCountObligadosMes($id_uni_respon_usu) {
        $this->db->select('COUNT(*) as num_obligados');
        $this->db->from('num_asi');
        $this->db->join('uni_respon_usu', 'num_asi.id_uni_respon_usu = uni_respon_usu.id_uni_respon_usu');
        $this->db->where('num_asi.estado_registro', '1');
        $this->db->where('num_asi.id_form', '1');
        $this->db->where('num_asi.op', '0');
        $this->db->where('uni_respon_usu.id_uni_respon_usu', $id_uni_respon_usu);
        $this->db->where('MONTH(num_asi.FechaEmision)', date('m')); // Filtrar por el mes actual
        $this->db->where('num_asi.SumaMonto != num_asi.MontoTotal'); // Agregar filtro para SumaMonto distinto de MontoTotal
    
        $resultados = $this->db->get();
        return $resultados->row()->num_obligados;
    }
    
}
