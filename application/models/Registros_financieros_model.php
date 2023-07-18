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

	//------------------------------------------------------------------------------------------------------

	//CODIGOS PARA LA TABLA ORIGEN DE FINANCIAMIENTO
 
	public function getOrigenes(){
		$this->db->where("estado", "1");
		$resultados = $this->db->get("origen_de_financiamiento");
		return $resultados->result();
	}

	public function saveOrigen($data){
		return $this->db->insert("origen_de_financiamiento", $data);
	}

	public function getOrigen($id){
		$this->db->where("id", $id);
		$resultado = $this->db->get("origen_de_financiamiento");
		return $resultado->row();
	}

	public function updateOrigen($id, $data){
		$this->db->where("id", $id);
		return $this->db->update("origen_de_financiamiento", $data);
	}

	//------------------------------------------------------------------------------------------------------

	//CODIGOS PARA LA TABLA PROGRAMA DE GASTOS

	public function getProgramGastos(){
		$this->db->where("estado", "1");
		$resultados = $this->db->get("programa_de_gastos");
		return $resultados->result();
	}

	public function saveProgramGasto($data){
		return $this->db->insert("programa_de_gastos", $data);
	}

	public function getProgramGasto($id){
		$this->db->where("id", $id);
		$resultado = $this->db->get("programa_de_gastos");
		return $resultado->row();
	}

	public function updateProgramGasto($id, $data){
		$this->db->where("id", $id);
		return $this->db->update("programa_de_gastos", $data);
	}

	//------------------------------------------------------------------------------------------------------

	//CODIGOS PARA LA TABLA PROGRAMA DE INGRESOS

	public function getProgramIngresos(){
		$this->db->where("estado", "1");
		$resultados = $this->db->get("programa_ingreso");
		return $resultados->result();
	}

	public function saveProgramIngreso($data){
		return $this->db->insert("programa_ingreso", $data);
	}

	public function getProgramIngreso($id){
		$this->db->where("id", $id);
		$resultado = $this->db->get("programa_ingreso");
		return $resultado->row();
	}

	public function updateProgramIngreso($id, $data){
		$this->db->where("id", $id);
		return $this->db->update("programa_ingreso", $data);
	} 
}
