<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class EjecucionP_model extends CI_Model {

	public function getSumaDebePorCuenta() {
		$this->db->select('
        pro.codigo as codigo_prog,
        ff.codigo as codigo_ff,
        of.codigo as codigo_of,
        p.Idcuentacontable,
        p.Año,
        p.TotalPresupuestado,
        p.TotalModificado,
        c.Codigo_CC as codigo_cc,
        IFNULL(SUM(d.Debe), 0) as Obligado,
        IFNULL(SUM(d.Haber), 0) as Pagado
    ');
    
    $this->db->from('presupuestos p'); // Asegúrate de que el nombre de la tabla sea correcto
    $this->db->join('cuentacontable c', 'p.Idcuentacontable = c.IDCuentaContable');
    $this->db->join('programa pro', 'p.programa_id_pro = pro.id_pro');
    $this->db->join('fuente_de_financiamiento ff', 'ff.id_ff = p.fuente_de_financiamiento_id_ff');
    $this->db->join('origen_de_financiamiento of', 'of.id_of = p.origen_de_financiamiento_id_of');
    $this->db->join('num_asi_deta d', 'c.IDCuentaContable = d.IDCuentaContable', 'left');
    $this->db->group_by('p.Idcuentacontable, p.ID_Presupuesto');
    $query = $this->db->get();

    if ($query->num_rows() > 0) {
        return $query->result();
    } else {
        return false;
    }
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