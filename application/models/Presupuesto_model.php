<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Presupuesto_model extends CI_Model {



    public function getPresu($id_uni_academica) {
        $this->db->select('pre.*, c.Descripcion_CC as descripcion, ff.nombre as fuente_de_financiamiento, of.nombre as origen_de_financiamiento, pr.nombre as programa, pf.*');
        $this->db->from('presupuestos pre');
        $this->db->join("fuente_de_financiamiento ff", "pre.fuente_de_financiamiento_id_ff = ff.id_ff");
        $this->db->join("origen_de_financiamiento of", "pre.origen_de_financiamiento_id_of = of.id_of");
        $this->db->join("programa pr", "pre.programa_id_pro = pr.id_pro");
        $this->db->join("cuentacontable c", "pre.Idcuentacontable = c.IDCuentaContable");
        $this->db->join('uni_respon_usu', 'pre.id_uni_respon_usu = uni_respon_usu.id_uni_respon_usu');
        $this->db->join('plan_financiero pf', 'pre.id_pf_fk = pf.ID_PF'); // Unión externa izquierda
        $this->db->where('pre.estado', '1');
        $this->db->where('uni_respon_usu.id_uni_respon_usu', $id_uni_academica);
        
        $resultados = $this->db->get();
        return $resultados->result();
    }

    public function getPlanFinanciero($id_uni_academica) {
        $this->db->select('*');
        $this->db->from('plan_financiero');
        $this->db->where('id_user', $id_uni_academica);
        $resultados = $this->db->get();
        return $resultados->result();
    }

    public function save($presupuesto_data, $plan_financiero_data){
        $this->db->trans_start();
        
        // Guardar el presupuesto
        $this->db->insert("presupuestos", $presupuesto_data);
        $id_presupuesto = $this->db->insert_id(); // Obtener el ID del presupuesto recién insertado
        
        // Insertar el plan financiero
        $plan_financiero_data['id_presupuesto'] = $id_presupuesto; // Establecer la relación
        $this->db->insert("plan_financiero", $plan_financiero_data);
        $id_plan_financiero = $this->db->insert_id(); // Obtener el ID del plan financiero recién insertado
        
        // Actualizar el presupuesto con el ID del plan financiero
        $this->db->where('ID_Presupuesto', $id_presupuesto);
        $this->db->update('presupuestos', array('id_pf_fk' => $id_plan_financiero));
        
        $this->db->trans_complete();
        
        return $this->db->trans_status();
    }


    public function getCuentasContables($id_uni_academica = null) {
        $this->db->select('cuentacontable.*');
        $this->db->from('cuentacontable');
        $this->db->join('uni_respon_usu', 'cuentacontable.id_uni_respon_usu = uni_respon_usu.id_uni_respon_usu', 'left');
        $this->db->where('cuentacontable.estado', '1');
        
        if (!is_null($id_uni_academica)) {
            $this->db->where('uni_respon_usu.id_uni_respon_usu', $id_uni_academica);
        }
        
        $resultados = $this->db->get();
        return $resultados->result();
    }


	public function getPresupuesto($id){
		$this->db->where("ID_Presupuesto",$id);
		$resultado = $this->db->get("presupuestos");
		return $resultado->row();

	}

	public function update($id, $data){
		$this->db->where("ID_Presupuesto",$id);
		return $this->db->update("presupuestos",$data);
	}


	
}