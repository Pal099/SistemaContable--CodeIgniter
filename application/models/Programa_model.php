<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Programa_model extends CI_Model {
	public function getProgramGastos() {
		$this->db->select('programa.*');
		$this->db->from('programa');
		$this->db->where('programa.estado', '1');
		
		$resultados = $this->db->get();
		return $resultados->result();
	}

	public function save($data){
		return $this->db->insert("programa", $data);
	}

	public function getProgramGasto($id){
		$this->db->where("id_pro", $id);
		$resultado = $this->db->get("programa");
		return $resultado->row();
	}

	public function update($id, $data){
		$this->db->where("id_pro", $id);
		return $this->db->update("programa", $data);
	}

}