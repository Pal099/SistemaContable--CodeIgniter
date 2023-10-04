<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Origen_model extends CI_Model {

public function getOrigenes(){
		$this->db->where("estado", "1");
		$resultados = $this->db->get("origen_de_financiamiento");
		return $resultados->result();
	}

	public function save($data){
		return $this->db->insert("origen_de_financiamiento", $data);
	}

	public function getOrigen($id){
		$this->db->where("id_of", $id);
		$resultado = $this->db->get("origen_de_financiamiento");
		return $resultado->row();
	}

	public function update($id, $data){
		$this->db->where("id_of", $id);
		return $this->db->update("origen_de_financiamiento", $data);
	}
}