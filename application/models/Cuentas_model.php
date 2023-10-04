<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cuentas_model extends CI_Model {

	public function getCuentas(){
		$this->db->where("estado","1");
		$resultados = $this->db->get("cta_cte");
		return $resultados->result();
	}

	public function save($data){
		return $this->db->insert("cta_cte",$data);
	}
	public function getCuenta($id){
		$this->db->where("cta_id",$id);
		$resultado = $this->db->get("cta_cte");
		return $resultado->row();

	}

	public function update($id,$data){
		$this->db->where("cta_id",$id);
		return $this->db->update("cta_cte",$data);
	}
}
