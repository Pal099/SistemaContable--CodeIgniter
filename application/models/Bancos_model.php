<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Bancos_model extends CI_Model {

	public function getBancos(){
		$this->db->where("estado","1");
		$resultados = $this->db->get("bancos");
		return $resultados->result();
	}

	public function save($data){
		return $this->db->insert("bancos",$data);
	}
	public function getBanco($id){
		$this->db->where("ban_id",$id);
		$resultado = $this->db->get("bancos");
		return $resultado->row();

	}

	public function update($id,$data){
		$this->db->where("ban_id",$id);
		return $this->db->update("bancos",$data);
	}
}
