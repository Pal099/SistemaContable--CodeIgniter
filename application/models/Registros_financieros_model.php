<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Registros_financieros_model extends CI_Model {

	//CODIGOS PARA LA TABLA FUENTE DE FINANCIAMIENTO

	public function getFuentes(){
		$this->db->where("estado","1");
		$resultados = $this->db->get('fuente_de_financiamiento');
		return $resultados->result();
	}

	public function save($data){
		return $this->db->insert('fuente_de_financiamiento', $data);
	}

	public function getFuente($id){
		$this->db->where("id", $id);
		$resultado = $this->db->get("fuente_de_financiamiento");
		return $resultado->row();
	}

	public function update($id, $data){
		$this->db->where("id", $id);
		return $this->db->update("fuente_de_financiamiento", $data);
	}
}
