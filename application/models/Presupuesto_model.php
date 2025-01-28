<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Presupuesto_model extends CI_Model {



    public function getPresu($id_uni_respon_usu) {
        $this->db->select('pre_men.*, pre.*, c.Descripcion_CC as descripcion, ff.nombre as fuente_de_financiamiento, of.nombre as origen_de_financiamiento, pr.nombre as programa');
        $this->db->from('presupuestos pre');
        $this->db->join("fuente_de_financiamiento ff", "pre.fuente_de_financiamiento_id_ff = ff.id_ff");
        $this->db->join("origen_de_financiamiento of", "pre.origen_de_financiamiento_id_of = of.id_of");
        $this->db->join("programa pr", "pre.programa_id_pro = pr.id_pro");
        $this->db->join("cuentacontable c", "pre.Idcuentacontable = c.IDCuentaContable");
        $this->db->join("presupuesto_mensual pre_men", "pre.ID_Presupuesto = pre_men.id_presupuesto");
        $this->db->join('uni_respon_usu', 'pre.id_uni_respon_usu = uni_respon_usu.id_uni_respon_usu');
        $this->db->where('pre.estado', '1');
        $this->db->where('uni_respon_usu.id_uni_respon_usu', $id_uni_respon_usu);
        
        $resultados = $this->db->get();
        return $resultados->result();
    }

    public function getPlanFinanciero($id_uni_respon_usu) {
        $this->db->select('*');
        $this->db->from('plan_financiero');
        $this->db->where('id_user', $id_uni_respon_usu);
        $resultados = $this->db->get();
        return $resultados->result();
    }

    public function save($presupuesto_data){
        $this->db->trans_start();
        
        // Guardar el presupuesto
        $this->db->insert("presupuestos", $presupuesto_data);
        $id_presupuesto = $this->db->insert_id(); // Obtener el ID del presupuesto recién insertado
        
        $this->db->trans_complete();
        
        return $this->db->trans_status();
    }

    public function save_monto_presu($presupuestos_mensuales) {
        $this->db->insert("presupuesto_mensual", $presupuestos_mensuales); // Inserta múltiples registros
        return $this->db->affected_rows() > 0;
        
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



    
     // Insertar en la tabla `presupuestos`
     public function insertar_presupuesto($data)
     {
         $this->db->insert('presupuestos', $data);
         return $this->db->insert_id(); // Retorna el ID del presupuesto generado
     }
 
     // Insertar en la tabla `presupuesto_mensual`
     public function insertar_presupuesto_mensual($data)
     {
         return $this->db->insert('presupuesto_mensual', $data);
     }

     public function save_presupuesto_mensual($data)
     {
         return $this->db->insert('presupuesto_mensual', $data);
     }
     
}