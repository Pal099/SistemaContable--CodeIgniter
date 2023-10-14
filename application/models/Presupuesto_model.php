<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Presupuesto_model extends CI_Model {

	public function getPresupuestos() {
    $this->db->select("p.*, c.DescripcionCuentaContable as descripcion, ff.nombre as fuente_de_financiamiento, of.nombre as origen_de_financiamiento, pr.nombre as programa");
    $this->db->from("presupuestos p");
    $this->db->join("fuente_de_financiamiento ff", "p.fuente_de_financiamiento_id_ff = ff.id_ff");
    $this->db->join("origen_de_financiamiento of", "p.origen_de_financiamiento_id_of = of.id_of");
    $this->db->join("programa pr", "p.programa_id_pro = pr.id_pro");
    $this->db->join("cuentacontable c", "p.IDCUENTACONTABLE = c.IDCuentaContable"); // Unir la tabla CuentaContable
    $this->db->where("p.estado", "1");
    $resultados = $this->db->get();
    return $resultados->result();
}

public function getPresu(){
	$this->db->where("estado","1");
	$resultados = $this->db->get('presupuestos', 'cuentacontable');
	return $resultados->result();
}

	public function save($data){
		return $this->db->insert("presupuestos",$data);
	}

	public function getPresupuesto($id){
		$this->db->where("ID_Presupuesto",$id);
		$resultado = $this->db->get("presupuestos");
		return $resultado->row();

	}

	public function update($id, $data){
		$this->db->where("id_presupuesto",$id);
		return $this->db->update("presupuestos",$data);
	}
}
