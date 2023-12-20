<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Presupuesto_model extends CI_Model {

	public function getPresupuestos($id_uni_respon_usu) {
    $this->db->select("p.*, c.Codigo_CC as Idcuentacontable, c.Descripcion_CC as Idcuentacontable, ff.nombre as fuente_de_financiamiento, of.nombre as origen_de_financiamiento, pr.nombre as programa");
    $this->db->from("presupuestos p");
    $this->db->join("fuente_de_financiamiento ff", "p.fuente_de_financiamiento_id_ff = ff.id_ff");
    $this->db->join("origen_de_financiamiento of", "p.origen_de_financiamiento_id_of = of.id_of");
    $this->db->join("programa pr", "p.programa_id_pro = pr.id_pro");
    $this->db->join("cuentacontable c", "p.Idcuentacontable = c.IDCuentaContable"); 
	$this->db->join('uni_respon_usu', 'p.id_uni_respon_usu = uni_respon_usu.id_uni_respon_usu');
    $this->db->where("p.estado", "1");
	$this->db->where('uni_respon_usu.id_uni_respon_usu', $id_uni_respon_usu);
    $resultados = $this->db->get();
    return $resultados->result();
}

public function getPresu($id_uni_respon_usu) {
	$this->db->select('pre.*, c.Codigo_CC as Idcuentacontable,c.Descripcion_CC as Idcuentacontable, ff.nombre as fuente_de_financiamiento, of.nombre as origen_de_financiamiento, pr.nombre as programa');
	$this->db->from('presupuestos pre');
	$this->db->join("fuente_de_financiamiento ff", "pre.fuente_de_financiamiento_id_ff = ff.id_ff");
    $this->db->join("origen_de_financiamiento of", "pre.origen_de_financiamiento_id_of = of.id_of");
    $this->db->join("programa pr", "pre.programa_id_pro = pr.id_pro");
    $this->db->join("cuentacontable c", "pre.Idcuentacontable = c.IDCuentaContable");
	$this->db->join('uni_respon_usu', 'pre.id_uni_respon_usu = uni_respon_usu.id_uni_respon_usu');
	$this->db->where('pre.estado', '1');
	$this->db->where('uni_respon_usu.id_uni_respon_usu', $id_uni_respon_usu);
	
	$resultados = $this->db->get();
	return $resultados->result();
}


	public function save($data){
		return $this->db->insert("presupuestos",$data);
	}

	public function getPresupuesto($id)
	{
		$this->db->where("ID_Presupuesto", $id);
		$resultado = $this->db->get("presupuestos");
		return $resultado->row();

	}

	public function update($id, $data)
	{
		$this->db->where("id_presupuesto", $id);
		return $this->db->update("presupuestos", $data);
	}



}
