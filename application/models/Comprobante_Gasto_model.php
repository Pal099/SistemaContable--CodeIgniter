<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Comprobante_Gasto_model extends CI_Model {

	public function getComprobantesGastos($id_uni_respon_usu) {
		$this->db->select('comprobante_gasto.*');
		$this->db->from('comprobante_gasto');
		$this->db->join('uni_respon_usu', 'comprobante_gasto.id_uni_respon_usu = uni_respon_usu.id_uni_respon_usu');
		$this->db->where('comprobante_gasto.estado', '1');
		$this->db->where('uni_respon_usu.id_uni_respon_usu', $id_uni_respon_usu);
		
		$resultados = $this->db->get();
		return $resultados->result();
	}
	

	
	public function save($data) {
	
		return $this->db->insert('comprobante_gasto', $data);
	}
	
	
    
	public function getComprobanteGasto($id){
		$this->db->where("IDComprobanteGasto",$id);
		$resultado = $this->db->get("comprobante_gasto");
		return $resultado->row();

	}
 
	public function update($id,$data){
		$this->db->where("IDComprobanteGasto",$id);
		return $this->db->update("comprobante_gasto",$data);
	}
	public function obtener_datos_asiento($numero_asiento = null) {
		$this->db->select('
			origen_de_financiamiento.nombre as nombre_origen,
			fuente_de_financiamiento.nombre as nombre_fuente,
			programa.nombre as nombre_programa,
			num_asi.num_asi as numero_asiento,
			num_asi_deta.Debe as debe_num_asi_deta,
			cuentacontable.Codigo_CC as codigo,
			cuentacontable.Descripcion_CC,
			presupuestos.pre_ene,
			presupuestos.pre_feb,
			presupuestos.pre_mar,
			presupuestos.pre_abr,
			presupuestos.pre_may,
			presupuestos.pre_jun,
			presupuestos.pre_jul,
			presupuestos.pre_ago,
			presupuestos.pre_sep,
			presupuestos.pre_oct,
			presupuestos.pre_nov,
			presupuestos.pre_dic,
			(presupuestos.TotalPresupuestado + presupuestos.TotalModificado) as Vigente,
			IFNULL(SUM(num_asi_deta.Debe), 0) as Obligado,
			((presupuestos.TotalPresupuestado + presupuestos.TotalModificado) - IFNULL(SUM(num_asi_deta.Debe), 0)) as SaldoPresupuestario,
			SUM(num_asi_deta.Debe) as total_debe_cuenta,
			COALESCE(
				SUM(num_asi_deta.Debe) OVER (
					PARTITION BY 
						cuentacontable.Codigo_CC, 
						programa.codigo, 
						fuente_de_financiamiento.codigo, 
						origen_de_financiamiento.codigo
					ORDER BY num_asi.num_asi ASC 
					ROWS BETWEEN UNBOUNDED PRECEDING AND 1 PRECEDING
				), 0) as acumulado_anterior
		');
	
		$this->db->from('num_asi_deta');
		$this->db->join('origen_de_financiamiento', 'num_asi_deta.id_of = origen_de_financiamiento.id_of');
		$this->db->join('fuente_de_financiamiento', 'num_asi_deta.id_ff = fuente_de_financiamiento.id_ff');
		$this->db->join('programa', 'num_asi_deta.id_pro = programa.id_pro');
		$this->db->join('cuentacontable', 'num_asi_deta.IDCuentaContable = cuentacontable.IDCuentaContable');
		$this->db->join('presupuestos', 'cuentacontable.Idcuentacontable = presupuestos.Idcuentacontable');
		$this->db->join('num_asi', 'num_asi_deta.Num_Asi_IDNum_Asi = num_asi.IDNum_Asi');
	
		if ($numero_asiento) {
			$this->db->where('num_asi.num_asi', $numero_asiento);
		}
	
		$this->db->group_by('origen_de_financiamiento.nombre, fuente_de_financiamiento.nombre, programa.nombre, cuentacontable.Codigo_CC, cuentacontable.Descripcion_CC, num_asi.num_asi');
	
		return $this->db->get()->result_array();
	}
	
	
	public function obtener_datos_presupuesto() {
		$this->db->select('
			origen_de_financiamiento.nombre AS origen_de_financiamiento_id_of,
			fuente_de_financiamiento.nombre AS fuente_de_financiamiento_id_ff,
			programa.nombre AS programa_id_pro,
			cuentacontable.Codigo_CC as codigo,
			RIGHT(
            CONCAT(
                SUBSTRING_INDEX(SUBSTRING_INDEX(cuentacontable.Codigo_CC, ".", 4), ".", -1),
                SUBSTRING_INDEX(SUBSTRING_INDEX(cuentacontable.Codigo_CC, ".", 5), ".", -1)
            ), 3
        	) as rubro, 
			presupuestos.Año,
			presupuestos.TotalPresupuestado,
			presupuestos.TotalModificado,
			presupuestos.pre_ene,
			presupuestos.pre_feb,
			presupuestos.pre_mar,
			presupuestos.pre_abr,
			presupuestos.pre_may,
			presupuestos.pre_jun,
			presupuestos.pre_jul,
			presupuestos.pre_ago,
			presupuestos.pre_sep,
			presupuestos.pre_oct,
			presupuestos.pre_nov,
			presupuestos.pre_dic,
			presupuestos.id_uni_respon_usu,
			presupuestos.estado,
			(
				CASE
					WHEN presupuestos.pre_dic != 0 THEN presupuestos.pre_dic
					WHEN presupuestos.pre_nov != 0 THEN presupuestos.pre_nov
					WHEN presupuestos.pre_oct != 0 THEN presupuestos.pre_oct
					WHEN presupuestos.pre_sep != 0 THEN presupuestos.pre_sep
					WHEN presupuestos.pre_ago != 0 THEN presupuestos.pre_ago
					WHEN presupuestos.pre_jul != 0 THEN presupuestos.pre_jul
					WHEN presupuestos.pre_jun != 0 THEN presupuestos.pre_jun
					WHEN presupuestos.pre_may != 0 THEN presupuestos.pre_may
					WHEN presupuestos.pre_abr != 0 THEN presupuestos.pre_abr
					WHEN presupuestos.pre_mar != 0 THEN presupuestos.pre_mar
					WHEN presupuestos.pre_feb != 0 THEN presupuestos.pre_feb
					WHEN presupuestos.pre_ene != 0 THEN presupuestos.pre_ene
					ELSE 0
				END
			) AS saldo_actual
		');
	
		$this->db->from('presupuestos');
		$this->db->join('origen_de_financiamiento', 'presupuestos.origen_de_financiamiento_id_of = origen_de_financiamiento.id_of');
		$this->db->join('fuente_de_financiamiento', 'presupuestos.fuente_de_financiamiento_id_ff = fuente_de_financiamiento.id_ff');
		$this->db->join('programa', 'presupuestos.programa_id_pro = programa.id_pro');
		$this->db->join('cuentacontable', 'presupuestos.Idcuentacontable = cuentacontable.Idcuentacontable');
	
		return $this->db->get()->result_array();
	}
	
	
	
	public function getComprobantesGastosFiltrados($actividad, $fuente, $anio, $mes)
{
    $this->db->select('*');
    $this->db->from('comprobante_gasto');

    if (!empty($actividad)) {
        $this->db->where('id_unidad', $actividad);
    }
    if (!empty($fuente)) {
        $this->db->where('id_ff', $fuente);
    }
    if (!empty($periodo)) {
        $this->db->where('YEAR(fecha)', $periodo);
    }

    if (!empty($mes)) {
        $this->db->where('MONTH(fecha)', $mes);
    }

    $query = $this->db->get();
    return $query->result();
}
}
