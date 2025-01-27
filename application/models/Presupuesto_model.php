<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Presupuesto_model extends CI_Model
{

    public function getPresu($id_uni_academica) {
        // Aumentar límite de GROUP_CONCAT
        $this->db->query("SET SESSION group_concat_max_len = 1000000");
    
        $this->db->select('pre.*, 
            c.Descripcion_CC as descripcion, 
            ff.nombre as fuente_de_financiamiento, 
            of.nombre as origen_de_financiamiento, 
            pr.nombre as programa,
            GROUP_CONCAT(CONCAT(pm.mes, ":", pm.monto_presupuestado) SEPARATOR "|") as montos_mensuales' // Usar "|" para separar
        );

        $this->db->from('presupuestos pre');
        $this->db->join("fuente_de_financiamiento ff", "pre.fuente_de_financiamiento_id_ff = ff.id_ff");
        $this->db->join("origen_de_financiamiento of", "pre.origen_de_financiamiento_id_of = of.id_of");
        $this->db->join("programa pr", "pre.programa_id_pro = pr.id_pro");
        $this->db->join("cuentacontable c", "pre.Idcuentacontable = c.IDCuentaContable");
        $this->db->join('uni_respon_usu', 'pre.id_uni_respon_usu = uni_respon_usu.id_uni_respon_usu');
        $this->db->join('presupuesto_mensual pm', 'pre.id_presupuesto = pm.id_presupuesto', 'left'); // Join con montos
        $this->db->where('pre.estado', '1');
        $this->db->where('uni_respon_usu.id_uni_respon_usu', $id_uni_academica);
        $this->db->group_by('pre.id_presupuesto');
        $this->db->order_by('pre.Año', 'DESC'); // Ordenar por fecha
    
        return $this->db->get()->result();
    }




    
    public function save($presupuesto_data, $montos_mensuales = []) {
        $this->db->trans_start();
    
        // Insertar presupuesto principal
        $this->db->insert('presupuestos', $presupuesto_data);
        $presupuesto_id = $this->db->insert_id();
    
        if ($presupuesto_id <= 0) {
            log_message('error', 'Error al insertar presupuesto: ID no generado');
            $this->db->trans_rollback();
            return FALSE;
        }
    
        // Procesar montos mensuales
        if (!empty($montos_mensuales)) {
            $montos_a_insertar = [];
            foreach ($montos_mensuales as $mes => $monto) {
                if ($monto > 0) {
                    $montos_a_insertar[] = [
                        'id_presupuesto' => $presupuesto_id,
                        'mes' => $mes,
                        'monto_presupuestado' => $monto
                    ];
                }
            }
    
            if (!empty($montos_a_insertar)) {
                $this->db->insert_batch('presupuesto_mensual', $montos_a_insertar);
                $insertados = $this->db->affected_rows();
    
                if ($insertados !== count($montos_a_insertar)) {
                    log_message('error', "Montos insertados: $insertados / Esperados: " . count($montos_a_insertar));
                    $this->db->trans_rollback();
                    return FALSE;
                }
            }
        }
    
        $this->db->trans_complete();
        return $this->db->trans_status();
    }
    


    public function update($id, $presupuesto_data, $montos_mensuales)
    {
        $this->db->trans_start();

        // 1. Actualizar presupuesto principal
        $this->db->where('ID_Presupuesto', $id);
        $this->db->update('presupuestos', $presupuesto_data);

        // 2. Actualizar montos mensuales
        foreach ($montos_mensuales as $mes => $monto) {
            $this->db->where('id_presupuesto', $id);
            $this->db->where('mes', $mes);
            $this->db->update('presupuesto_mensual', [
                'monto_presupuestado' => $monto
            ]);
        }

        $this->db->trans_complete();
        return $this->db->trans_status();
    }

    public function getPresupuesto($id)
    {
        $this->db->where("ID_Presupuesto", $id);
        return $this->db->get("presupuestos")->row();
    }

    public function getMensual($id_presupuesto)
    {
        $this->db->where("id_presupuesto", $id_presupuesto);
        return $this->db->get("presupuesto_mensual")->result();
    }



    public function getCuentasContables($id_uni_academica = null)
    {
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




}