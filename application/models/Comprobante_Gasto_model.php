<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Comprobante_Gasto_model extends CI_Model {

	public function getComprobantesGastos($id_user) {
		$this->db->select('comprobante_gasto.*, proveedores.*');
		$this->db->from('comprobante_gasto');
		$this->db->join('uni_respon_usu', 'comprobante_gasto.id_uni_respon_usu = uni_respon_usu.id_uni_respon_usu');
		$this->db->join('proveedores', 'comprobante_gasto.idproveedor = proveedores.id');
		$this->db->where('comprobante_gasto.estado', '1');
		$this->db->where('uni_respon_usu.id_uni_respon_usu', $id_user);
		
		$resultados = $this->db->get();
		return $resultados->result();
	}
	

	
	public function save($data) {
	
		return $this->db->insert('comprobante_gasto', $data);
	}
	
	
    
	public function getComprobanteGasto($id){
		$this->db->where("IDComprobanteGasto",$id);
		$resultado = $this->db->get("comprobante_gasto");
		return $resultado->row();

	}
 
	public function update($id,$data){
		$this->db->where("IDComprobanteGasto",$id);
		return $this->db->update("comprobante_gasto",$data);
	}
	public function getComprobantesGastosFiltrados($actividad, $fuente, $anio, $mes)
{
    $this->db->select('*');
    $this->db->from('comprobante_gasto');

    if (!empty($actividad)) {
        $this->db->where('id_unidad', $actividad);
    }
    if (!empty($fuente)) {
        $this->db->where('id_ff', $fuente);
    }
    if (!empty($periodo)) {
        $this->db->where('YEAR(fecha)', $periodo);
    }

    if (!empty($mes)) {
        $this->db->where('MONTH(fecha)', $mes);
    }

    $query = $this->db->get();
    return $query->result();
}
}
