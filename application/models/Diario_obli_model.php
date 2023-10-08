<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Diario_obli_model extends CI_Model {

	public function getDiarios(){
		$this->db->where("estado","1");
		$resultados = $this->db->get("proveedores");
		return $resultados->result();
	}

	public function save($data){
		return $this->db->insert("proveedores",$data);
	}
	public function getDiario($id){
		$this->db->where("id",$id);
		$resultado = $this->db->get("proveedores");
		return $resultado->row();

	}

	public function update($id,$data){
		$this->db->where("id",$id);
		return $this->db->update("proveedores",$data);
	}

	public function getProgramas() {
		$query = $this->db->get("programa");
		return $query->result();
	}
	
	public function getFuentesFinanciamiento() {
		$query = $this->db->get("fuente_de_financiamiento");
		return $query->result();
	}
	
	public function getOrigenesFinanciamiento() {
		$query = $this->db->get("origen_de_financiamiento");
		return $query->result();
	}
	


	public function getDiarios_obli() {
		$this->db->select('programa.nombre as nombre_programa, fuente_de_financiamiento.nombre as nombre_fuente, origen_de_financiamiento.nombre as nombre_origen');
		$this->db->from('num_asi_deta');
		$this->db->join('programa', 'num_asi_deta.id_pro = programa.id_pro', 'left');
		$this->db->join('fuente_de_financiamiento', 'num_asi_deta.id_ff = fuente_de_financiamiento.id_ff', 'left');
		$this->db->join('origen_de_financiamiento', 'num_asi_deta.id_of = origen_de_financiamiento.id_of', 'left');
	
		
		$query = $this->db->get();
		return $query->result();
	}
	
}
