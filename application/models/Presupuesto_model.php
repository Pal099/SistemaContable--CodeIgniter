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
        return $this->db->insert("presupuestos", $presupuesto_data);
    }

    public function save_monto_presu($presupuestos_mensuales) {
        return $this->db->insert_batch("presupuesto_mensual", $presupuestos_mensuales);
    }

    public function getPresupuesto($id){
        $this->db->where("ID_Presupuesto",$id);
        $resultado = $this->db->get("presupuestos");
        return $resultado->row();
    }

    public function getPresupuestosMensuales($id_presupuesto) {
        $this->db->where("id_presupuesto", $id_presupuesto);
        $resultado = $this->db->get("presupuesto_mensual");
    
        $presupuestos_mensuales = array();
        foreach ($resultado->result() as $row) {
            // Extraer el nombre del mes en español desde la fecha (ej: '2025-01-01' -> 'Enero')
            $fecha = new DateTime($row->mes);
            $nombre_mes = $this->obtenerNombreMes($fecha->format('n')); 
            $presupuestos_mensuales[$nombre_mes] = $row->monto_presupuestado;
        }
    
        return $presupuestos_mensuales;
    }

    private function obtenerNombreMes($numero_mes) {
        $meses = [
            1 => 'Enero', 2 => 'Febrero', 3 => 'Marzo',
            4 => 'Abril', 5 => 'Mayo', 6 => 'Junio',
            7 => 'Julio', 8 => 'Agosto', 9 => 'Septiembre',
            10 => 'Octubre', 11 => 'Noviembre', 12 => 'Diciembre'
        ];
        return $meses[$numero_mes];
    }

    public function update($id, $data){
        $this->db->where("ID_Presupuesto",$id);
        return $this->db->update("presupuestos",$data);
    }

    public function update_mes($id, $data){
        $this->db->where("id_presupuesto_mes",$id);
        return $this->db->update("presupuesto_mensual",$data);
    }

    public function getPresupuestoMensual($id_presupuesto, $fecha_mes) {
        $this->db->where("id_presupuesto", $id_presupuesto);
        $this->db->where("mes", $fecha_mes); // Busca por fecha completa (ej: '2025-01-01 00:00:00')
        $query = $this->db->get("presupuesto_mensual");
        return $query->row();
    }

    public function insertar_presupuesto($data) {
        $this->db->insert('presupuestos', $data);
        return $this->db->insert_id();
    }

    public function insertar_presupuesto_mensual($data) {
        return $this->db->insert('presupuesto_mensual', $data);
    }

    public function save_presupuesto_mensual($data) {
        return $this->db->insert('presupuesto_mensual', $data);
    }

    public function save_presupuesto_con_mensual($presupuesto_data, $presupuesto_mensual_data) {
        $this->db->trans_start();
        
        $this->db->insert('presupuestos', $presupuesto_data);
        $id_presupuesto = $this->db->insert_id();
        
        // Asignar id_presupuesto a cada registro mensual
        foreach ($presupuesto_mensual_data as &$mensual) {
            $mensual['id_presupuesto'] = $id_presupuesto;
        }
        
        $this->db->insert_batch('presupuesto_mensual', $presupuesto_mensual_data);
        
        $this->db->trans_complete();
        return $this->db->trans_status();
    }
}