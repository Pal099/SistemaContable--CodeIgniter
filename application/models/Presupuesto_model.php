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


    public function save($presupuesto_data){
        $this->db->trans_start();
        
        //Guardar el presupuesto
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

    public function getPresupuestosMensuales($id_presupuesto)
    {
        $this->db->where("id_presupuesto", $id_presupuesto);
        $resultado = $this->db->get("presupuesto_mensual");
    
        $presupuestos_mensuales = array();
        foreach ($resultado->result() as $row) {
            $presupuestos_mensuales[$row->mes] = $row->monto_presupuestado;
        }
    
        return $presupuestos_mensuales;
    }
    


	public function update($id, $data){
		$this->db->where("ID_Presupuesto",$id);
		return $this->db->update("presupuestos",$data);
	}


    public function update_mes($id, $data){
		$this->db->where("id_presupuesto_mes",$id);
		return $this->db->update("presupuesto_mensual",$data);
	}



    public function getPresupuestoMensual($id_presupuesto, $mes)
{
    $this->db->where("id_presupuesto", $id_presupuesto);
    $this->db->where("mes", $mes);
    $query = $this->db->get("presupuesto_mensual");
    return $query->row(); // Devuelve el registro si existe, o null si no
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

     
     
     
     
     public function save_presupuesto_con_mensual($presupuesto_data, $presupuesto_mensual_data) {
        $this->db->trans_start(); // Inicia la transacción
    
        // Insertar en la tabla `presupuestos`
        $this->db->insert('presupuestos', $presupuesto_data);
        $id_presupuesto = $this->db->insert_id(); // Obtener el ID del presupuesto recién insertado
    
        // Agregar el `id_presupuesto` a los datos de `presupuesto_mensual`
        foreach ($presupuesto_mensual_data as &$mensual) {
            $mensual['id_presupuesto'] = $id_presupuesto;
        }
    
        // Insertar en la tabla `presupuesto_mensual`
        $this->db->insert_batch('presupuesto_mensual', $presupuesto_mensual_data);

        return $this->db->insert('presupuestos_mensuales', $data);

    
        $this->db->trans_complete(); // Completa la transacción
    
        return $this->db->trans_status(); // Retorna el estado de la transacción
    }
    
     
}