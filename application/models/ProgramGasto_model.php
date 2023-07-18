<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ProgramGasto_model extends CI_Model {
    public function getProgramGastos(){
		$this->db->where("estado", "1");
		$resultados = $this->db->get("programa_de_gastos");
		return $resultados->result();
	}

	public function save($data){
		return $this->db->insert("programa_de_gastos", $data);
	}

	public function getProgramGasto($id){
		$this->db->where("id", $id);
		$resultado = $this->db->get("programa_de_gastos");
		return $resultado->row();
	}

	public function update($id, $data){
		$this->db->where("id", $id);
		return $this->db->update("programa_de_gastos", $data);
	}

}