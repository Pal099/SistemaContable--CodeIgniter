<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Presupuesto_model extends CI_Model
{
    //formateado de fecha, usar lo más posible, evitar formatear dentro de los métodos 
    private function format_datetime($date)
    {
        // Si ya viene con formato YYYY-MM-DD, solo agregar la hora
        if (preg_match('/^\d{4}-\d{2}-\d{2}$/', $date)) {
            return $date . ' 00:00:00';
        }
        // Si viene con formato YYYY-MM, agregar día y hora
        if (preg_match('/^\d{4}-\d{2}$/', $date)) {
            return $date . '-01 00:00:00';
        }
        // Fallback original
        return date('Y-m-d H:i:s', strtotime($date . '-01'));
    }

    public function getPresu($id_uni_respon_usu)
    {
        $this->db->select('
                        pre.ID_Presupuesto,
                        pre.Año,
                        pre.fuente_de_financiamiento_id_ff,
                        pre.origen_de_financiamiento_id_of,
                        pre.programa_id_pro,
                        pre.Idcuentacontable,
                        c.IDCuentaContable,
                        c.Codigo_CC AS cod_cuenta,
                        c.Descripcion_CC AS descripcion,
                        ff.nombre AS fuente_de_financiamiento,
                        ori.nombre AS origen_de_financiamiento,
                        pr.nombre AS programa,
                        pre.TotalPresupuestado,
                        pre.TotalModificado

    ');
        $this->db->from('presupuestos pre');
        $this->db->join('fuente_de_financiamiento ff', 'pre.fuente_de_financiamiento_id_ff = ff.id_ff');
        $this->db->join('origen_de_financiamiento ori', 'pre.origen_de_financiamiento_id_of = ori.id_of');
        $this->db->join('programa pr', 'pre.programa_id_pro = pr.id_pro');
        $this->db->join('cuentacontable c', 'pre.Idcuentacontable = c.IDCuentaContable');
        $this->db->join('uni_respon_usu', 'pre.id_uni_respon_usu = uni_respon_usu.id_uni_respon_usu');
        $this->db->where('pre.estado', '1');
        $this->db->where('uni_respon_usu.id_uni_respon_usu', $id_uni_respon_usu);

        $resultados = $this->db->get();
        return $resultados->result();
    }



    public function save($presupuesto_data)
    {
        $this->db->trans_start();
        $this->db->insert("presupuestos", $presupuesto_data);
        $id_presupuesto = $this->db->insert_id();
        $this->db->trans_complete();
        return $id_presupuesto;
    }


    public function save_batch_presupuesto_mensual($presupuestos_mensuales)
    {
        if (empty($presupuestos_mensuales)) {
            return false;
        }

        // Convertir todos los meses a formato datetime usando el método existente
        foreach ($presupuestos_mensuales as &$mensual) {
            if (isset($mensual['mes'])) {
                $mensual['mes'] = $this->format_datetime($mensual['mes']);
            }
        }

        return $this->db->insert_batch('presupuesto_mensual', $presupuestos_mensuales);
    }
    public function getPresupuesto($id)
    {
        $this->db->where("ID_Presupuesto", $id);
        $resultado = $this->db->get("presupuestos");
        return $resultado->row();
    }

    //este metodo usamos en el store, volveremos a usarlo en el update
    public function getPresupuestosMensuales($id_presupuesto)
    {
        $this->db->where("id_presupuesto", $id_presupuesto);
        $resultado = $this->db->get("presupuesto_mensual");

        $presupuestos_mensuales = array();

        // Mapeo de números de mes a códigos españoles
        $meses_es = [
            1 => 'ene',
            2 => 'feb',
            3 => 'mar',
            4 => 'abr',
            5 => 'may',
            6 => 'jun',
            7 => 'jul',
            8 => 'ago',
            9 => 'sep',
            10 => 'oct',
            11 => 'nov',
            12 => 'dic'
        ];

        foreach ($resultado->result() as $row) {
            // Obtener el número del mes (1-12)
            $mes_numero = (int)date('n', strtotime($row->mes));
            // Obtener el código español correspondiente
            $mes_codigo = $meses_es[$mes_numero];
            // Guardar usando el código del mes como clave
            $presupuestos_mensuales['pre_' . $mes_codigo] = $row->monto_presupuestado;
        }

        return $presupuestos_mensuales;
    }
    public function update($id, $data)
    {
        $this->db->where("ID_Presupuesto", $id);
        return $this->db->update("presupuestos", $data);
    }

    public function update_mes($id_presupuesto, $mes, $data)
    {
        $this->db->where("id_presupuesto", $id_presupuesto);
        $mes_formatted = $this->format_datetime($mes);

        $this->db->where("mes", $this->format_datetime($mes));
        return $this->db->update("presupuesto_mensual", $data);
    }
    // eliminamos estos métodos por que se volvieron redundantes, estos metodos se usaban para el update -is
    /*    public function save_presupuesto_mensual($data)
    {
        // Asegurarnos que el mes esté en formato datetime
        if (isset($data['mes'])) {
            $mes_datetime = date('Y-m-d H:i:s', strtotime($data['mes'] . '-01'));
            $data['mes'] = $mes_datetime;
        }

        return $this->db->insert('presupuesto_mensual', $data);
    }
 */
    /*         
    public function getPresupuestoMensual($id_presupuesto, $mes)
    {
        $this->db->where("id_presupuesto", $id_presupuesto);
        $this->db->where("mes", $mes);
        $query = $this->db->get("presupuesto_mensual");
        return $query->row(); // Devuelve el registro si existe, o null si no
    } */
}
