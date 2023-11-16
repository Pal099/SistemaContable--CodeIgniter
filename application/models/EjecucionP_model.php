
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class EjecucionP_model extends CI_Model {

	public function getEjecucionesP(){
		$this->db->select("ep.*, p.ID_presupuesto as presupuesto, cc.IDCuentaContable as cuentacontable");
		$this->db->from("ejecucionpresupuestaria ep");
		$this->db->join("presupuesto p","ep.presupuesto_ID_Presupuesto = p.ID_presupuesto");
		$this->db->join("cuentacontable cc","ep.IDCuentaContable = cc.IDCuentaContable");
		$resultados = $this->db->get();
		return $resultados->result();
	}

	public function save($data){
		return $this->db->insert("ejecucionpresupuestaria",$data);
	}

	public function getEjecucionP($id){
		$this->db->where("ID_EjecucionPresupuestaria",$id);
		$resultado = $this->db->get("ejecucionpresupuestaria");
		return $resultado->row();

	}

	public function update($id, $data){
		$this->db->where("ID_EjecucionPresupuestaria",$id);
		return $this->db->update("ejecucionpresupuestaria",$data);
	}
}
