<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class EjecucionP_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function obtener_ejecucion_completa($cuenta_id, $fecha_inicio, $fecha_fin) {
        // Obtener año para el presupuesto
        $anio_presupuesto = date('Y', strtotime($fecha_inicio));
        
        // Obtener datos del presupuesto con coalesce
        $this->db->select('COALESCE(SUM(TotalPresupuestado), 0) as TotalPresupuestado, 
                          COALESCE(SUM(TotalModificado), 0) as TotalModificado',
                          false);
        $this->db->from('presupuestos');
        $this->db->where('Idcuentacontable', $cuenta_id);
        $this->db->where('YEAR(Año)', $anio_presupuesto);
        $query_presupuesto = $this->db->get();
        $presupuesto = $query_presupuesto->row_array();

        // Obtener ejecución presupuestaria con coalesce en la consulta
        $this->db->select("
            COALESCE(SUM(CASE WHEN id_form = 1 THEN Debe ELSE 0 END), 0) as obligado,
            COALESCE(SUM(CASE WHEN id_form = 2 THEN Debe ELSE 0 END), 0) as pagado",
            false
        );
        $this->db->from('num_asi_deta');
        $this->db->where('IDCuentaContable', $cuenta_id);
        $this->db->where('creado_en >=', $fecha_inicio);
        $this->db->where('creado_en <=', $fecha_fin);
        $query_ejecucion = $this->db->get();
        $ejecucion = $query_ejecucion->row_array();

        // Construir respuesta consolidada
        return [
            'presupuesto_inicial' => $presupuesto['TotalPresupuestado'],
            'presupuesto_modificado' => $presupuesto['TotalModificado'],
            'presupuesto_vigente' => $presupuesto['TotalPresupuestado'] + $presupuesto['TotalModificado'],
            'obligado' => $ejecucion['obligado'],
            'pagado' => $ejecucion['pagado'],
            'pendiente_pago' => $ejecucion['obligado'] - $ejecucion['pagado']
        ];
    }

    // Nuevo método para obtener todos los datos para la vista
    public function obtener_ejecuciones_para_vista($fecha_inicio, $fecha_fin) {
        $anio = date('Y', strtotime($fecha_inicio));
        
        $this->db->select('
            p.origen_de_financiamiento_id_of,
            p.fuente_de_financiamiento_id_ff,
            p.programa_id_pro,
            p.Idcuentacontable,
            COALESCE(SUM(p.TotalPresupuestado), 0) as TotalPresupuestado,
            COALESCE(SUM(p.TotalModificado), 0) as TotalModificado,
            COALESCE(SUM(n.obligado), 0) as Obligado,
            COALESCE(SUM(n.pagado), 0) as Pagado
        ');
        
        $this->db->from('presupuestos p');
        $this->db->join('(
            SELECT 
                IDCuentaContable,
                id_of as origen_de_financiamiento_id_of,  -- Alias para coincidir con presupuestos
                id_ff as fuente_de_financiamiento_id_ff,  -- Alias para coincidir con presupuestos
                id_pro as programa_id_pro,                -- Alias para coincidir con presupuestos
                SUM(CASE WHEN id_form = 1 THEN Debe ELSE 0 END) as obligado,
                SUM(CASE WHEN id_form = 2 THEN Debe ELSE 0 END) as pagado
            FROM num_asi_deta
            WHERE creado_en BETWEEN "'.$this->db->escape_str($fecha_inicio).'" 
            AND "'.$this->db->escape_str($fecha_fin).'"
            GROUP BY IDCuentaContable, id_of, id_ff, id_pro
        ) n', 'p.Idcuentacontable = n.IDCuentaContable 
            AND p.origen_de_financiamiento_id_of = n.origen_de_financiamiento_id_of
            AND p.fuente_de_financiamiento_id_ff = n.fuente_de_financiamiento_id_ff
            AND p.programa_id_pro = n.programa_id_pro', 'left');
        
        $this->db->where('YEAR(p.Año)', $anio);
        $this->db->group_by('p.Idcuentacontable, p.origen_de_financiamiento_id_of, p.fuente_de_financiamiento_id_ff, p.programa_id_pro');
        $query = $this->db->get();
    
        return $query->result();
    }
    
    public function save($data){
        return $this->db->insert("ejecucionpresupuestaria", $data);
    }

    public function getEjecucionesP($id){
        $this->db->where("ID_EjecucionPresupuestaria", $id);
        $resultado = $this->db->get("ejecucionpresupuestaria");
        return $resultado->row();
    }

    public function update($id, $data){
        $this->db->where("ID_EjecucionPresupuestaria", $id);
        return $this->db->update("ejecucionpresupuestaria", $data);
    }
}
