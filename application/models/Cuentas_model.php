<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cuentas_model extends CI_Model {

	public function getCuentas_presu(){
		$this->db->select("c.*, p.descripcion as descripcion");
		$this->db->from("cuentacontable c");
		$this->db->join("presupuestos p","c.IDCUENTACONTABLE = p.IDCUENTACONTABLE");
		$this->db->where("c.estado", "1");
		$resultados = $this->db->get("cuentacontable");
		return $resultados->result();
	}

	public function getCuentas(){
		$this->db->where("estado", "1");
		$resultados = $this->db->get("cuentacontable");
		return $resultados->result();
	}

	public function save($data){
		return $this->db->insert("cuentacontable",$data);
	}
	public function getCuenta($id){
		$this->db->where("IDCUENTACONTABLE",$id);
		$resultado = $this->db->get("cuentacontable");
		return $resultado->row();

	}

	public function update($id,$data){
		$this->db->where("IDCUENTACONTABLE",$id);
		return $this->db->update("cuentacontable",$data);
	}
}
