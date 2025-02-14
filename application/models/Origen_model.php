<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Origen_model extends CI_Model {

	public function getOrigenes() {
		$this->db->select('origen_de_financiamiento.*');
		$this->db->from('origen_de_financiamiento');
		$this->db->where('origen_de_financiamiento.estado', '1');
		
		$resultados = $this->db->get();
		return $resultados->result();
	}

	public function save($data){
		return $this->db->insert("origen_de_financiamiento", $data);
	}

	public function getOrigen($id){
		$this->db->where("id", $id);
		$resultado = $this->db->get("origen_de_financiamiento");
		return $resultado->row();
	}

	public function update($id, $data){
		$this->db->where("id", $id);
		return $this->db->update("origen_de_financiamiento", $data);
	}
}