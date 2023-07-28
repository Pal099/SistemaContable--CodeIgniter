<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Diario_obli_model extends CI_Model {

	public function getDiarios(){
		$this->db->where("estado_bd","1");
		$resultados = $this->db->get("diario_obli");
		return $resultados->result();
	}

	public function save($data){
		return $this->db->insert("diario_obli",$data);
	}
	public function getDiario($id){
		$this->db->where("id",$id);
		$resultado = $this->db->get("diario_obli");
		return $resultado->row();

	}

	public function update($id,$data){
		$this->db->where("id",$id);
		return $this->db->update("diario_obli",$data);
	}
}
