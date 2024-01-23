<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ProgramIngreso_model extends CI_Model {


	public function getProgramIngresos(){
		$this->db->where("estado", "1");
		$resultados = $this->db->get("programa_ingreso");
		return $resultados->result();
	}

	public function save($data){
		return $this->db->insert("programa_ingreso", $data);
	}

	public function getProgramIngreso($id){
		$this->db->where("id", $id);
		$resultado = $this->db->get("programa_ingreso");
		return $resultado->row();
	}

	public function update($id, $data){
		$this->db->where("id", $id);
		return $this->db->update("programa_ingreso", $data);
	} 
}