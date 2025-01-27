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

    public function obtener_ejecuciones_para_vista($fecha_inicio, $fecha_fin, $origen = null, $fuente = null, $programa = null, $cuenta = null) {
        $this->db->select('
            p.Idcuentacontable,
            of.codigo AS codigo_origen,
            of.nombre AS nombre_of,
            ff.codigo AS codigo_fuente,
            ff.nombre AS nombre_ff,
            pro.codigo AS codigo_programa,
            pro.nombre AS nombre_pro,
            cc.Codigo_CC AS codigo_cuenta,
            cc.Descripcion_CC AS nombre_cuenta,
            SUM(p.TotalPresupuestado) AS TotalPresupuestado,
            SUM(p.TotalModificado) AS TotalModificado,
            (SUM(p.TotalPresupuestado) + SUM(p.TotalModificado)) AS Vigente,
            COALESCE(SUM(nd.MontoPago), 0) AS Obligado,
            COALESCE(SUM(nd.Haber), 0) AS Pagado,
            nd.creado_en As fecha
        ');
    
        $this->db->from('presupuestos p');
        
        // JOINS CORREGIDOS
        $this->db->join('origen_de_financiamiento of', 'p.origen_de_financiamiento_id_of = of.id_of', 'left');
        $this->db->join('fuente_de_financiamiento ff', 'p.fuente_de_financiamiento_id_ff = ff.id_ff', 'left');
        $this->db->join('programa pro', 'p.programa_id_pro = pro.id_pro', 'left');
        $this->db->join('cuentacontable cc', 'p.Idcuentacontable = cc.IDCuentaContable', 'left');
        $this->db->join('num_asi_deta nd', 'p.Idcuentacontable = nd.IDCuentaContable', 'left');
    
        // FILTRO DE FECHAS CON LEFT JOIN
        $this->db->group_start()
            ->where('nd.creado_en BETWEEN "' . $fecha_inicio . '" AND "' . $fecha_fin . '"')
            ->or_where('nd.creado_en IS NULL')
        ->group_end();
    
        // APLICAR FILTROS ADICIONALES
        if ($origen) $this->db->where('p.origen_de_financiamiento_id_of', $origen);
        if ($fuente) $this->db->where('p.fuente_de_financiamiento_id_ff', $fuente);
        if ($programa) $this->db->where('p.programa_id_pro', $programa);
        if ($cuenta) $this->db->where('p.Idcuentacontable', $cuenta);
    
        $this->db->group_by('p.Idcuentacontable, p.origen_de_financiamiento_id_of, p.fuente_de_financiamiento_id_ff, p.programa_id_pro');
    
        return $this->db->get()->result();
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
