<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Proveedores_model extends CI_Model {

	public function getProveedores($id_uni_respon_usu) {
		$this->db->select('proveedores.*');
		$this->db->from('proveedores');
		$this->db->join('uni_respon_usu', 'proveedores.id_uni_respon_usu = uni_respon_usu.id_uni_respon_usu');
		$this->db->where('proveedores.estado', '1');
		$this->db->where('uni_respon_usu.id_uni_respon_usu', $id_uni_respon_usu);
		
		$resultados = $this->db->get();
		return $resultados->result();
	}
	

	
	public function save($data) {
	
		return $this->db->insert('proveedores', $data);
	}
	
	
    
	public function getProveedor($id){
		$this->db->where("id",$id);
		$resultado = $this->db->get("proveedores");
		return $resultado->row();

	}
 
	public function update($id,$data){
		$this->db->where("id",$id);
		return $this->db->update("proveedores",$data);
	}
}
