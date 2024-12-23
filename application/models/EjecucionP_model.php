<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class EjecucionP_model extends CI_Model {

	public function getSumaDebePorCuenta($id_uni_respon_usu) {
                $this->db->select('
                p.origen_de_financiamiento_id_of,
                p.fuente_de_financiamiento_id_ff,
                p.programa_id_pro,
                p.Idcuentacontable,
                p.Año,
                p.TotalPresupuestado,
                p.TotalModificado,
                (p.TotalPresupuestado + p.TotalModificado) as Vigente,
                IFNULL(SUM(d.Debe), 0) as Obligado,
                ((p.TotalPresupuestado + p.TotalModificado) - IFNULL(SUM(d.Debe), 0)) as SaldoPresupuestario,
                IFNULL(SUM(d.Haber), 0) as Pagado
            ');
            $this->db->from('presupuestos p'); // Asegúrate de que el nombre de la tabla sea correcto
            $this->db->join('cuentacontable c', 'p.Idcuentacontable = c.IDCuentaContable');
            $this->db->join('num_asi_deta d', 'c.IDCuentaContable = d.IDCuentaContable', 'left');
            $this->db->join('uni_respon_usu', 'p.id_uni_respon_usu = uni_respon_usu.id_uni_respon_usu');
            $this->db->where('uni_respon_usu.id_uni_respon_usu', $id_uni_respon_usu);
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

	public function getEjecucionesP($id){
		$this->db->where("ID_EjecucionPresupuestaria",$id);
		$resultado = $this->db->get("ejecucionpresupuestaria");
		return $resultado->row();

	}

	public function update($id, $data){
		$this->db->where("ID_EjecucionPresupuestaria",$id);
		return $this->db->update("ejecucionpresupuestaria",$data);
	}
}