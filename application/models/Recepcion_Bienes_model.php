<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Recepcion_Bienes_model extends CI_Model {

	public function getRecepcionesBienes($id_uni_respon_usu) {
		$this->db->select('recepcion_bienes.*');
		$this->db->from('recepcion_bienes');
		$this->db->join('uni_respon_usu', 'recepcion_bienes.id_uni_respon_usu = uni_respon_usu.id_uni_respon_usu');
		$this->db->where('recepcion_bienes.estado', '1');
		$this->db->where('uni_respon_usu.id_uni_respon_usu', $id_uni_respon_usu);
		
		$resultados = $this->db->get();
		return $resultados->result();
	}
	

	
	public function save($data) {
	
		return $this->db->insert('recepcion_bienes', $data);
	}
	
	
    
	public function getRecepcionBien($id){
		$this->db->where("IDRecepcionBienes",$id);
		$resultado = $this->db->get("recepcion_bienes");
		return $resultado->row();

	}
 
	public function update($id,$data){
		$this->db->where("IDRecepcionBienes",$id);
		return $this->db->update("recepcion_bienes",$data);
	}
}