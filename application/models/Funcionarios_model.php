<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Funcionarios_model extends CI_Model {
    
	public function getFuncionarios($id_uni_respon_usu) {
		$this->db->select('funcionarios.*, dependencias.dependencia as dependencia, unidad_academica.unidad as unidad');
		$this->db->from('funcionarios');
		$this->db->join('uni_respon_usu', 'funcionarios.id_uni_respon_usu = uni_respon_usu.id_uni_respon_usu');
		$this->db->join('dependencias', 'funcionarios.dependencia_id = dependencias.dependencia_id');
		$this->db->join('unidad_academica', 'funcionarios.unidad_id = unidad_academica.id_unidad');
		$this->db->where('funcionarios.estado', '1');
		$this->db->where('uni_respon_usu.id_uni_respon_usu', $id_uni_respon_usu);
		
		$resultados = $this->db->get();
		return $resultados->result();
	}
   
	public function getDependencias() {
		$this->db->select('dependencias.*,');
		$this->db->from('dependencias');
		
		
		$resultados = $this->db->get();
		return $resultados->result();
	}

	public function save($data){
		return $this->db->insert("funcionarios", $data);
	}

	public function getFuncionario($id){
		$this->db->where("funcionario_id", $id);
		$resultado = $this->db->get("funcionarios");
		return $resultado->row();
	}


	public function update($id, $data){
		$this->db->where("funcionario_id", $id);
		return $this->db->update("funcionarios", $data);
	}
}