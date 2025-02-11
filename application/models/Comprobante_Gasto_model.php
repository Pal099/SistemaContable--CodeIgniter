<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Comprobante_Gasto_model extends CI_Model {

	public function getComprobantesGastos($id_user) {
		$this->db->select('comprobante_gasto.*, proveedores.*');
		$this->db->from('comprobante_gasto');
		$this->db->join('uni_respon_usu', 'comprobante_gasto.id_uni_respon_usu = uni_respon_usu.id_uni_respon_usu');
		$this->db->join('proveedores', 'comprobante_gasto.idproveedor = proveedores.id');
		$this->db->where('comprobante_gasto.estado', '1');
		$this->db->where('uni_respon_usu.id_uni_respon_usu', $id_user);
		
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
	public function getComprobantesPorPedido($id_uni_respon_usu)
{
    $this->db->select('*');
    $this->db->from('comprobante_gasto');
    $this->db->where('id_uni_respon_usu', $id_uni_respon_usu);
    $this->db->group_by('id_pedido'); // Agrupa los resultados por id_pedido
    $query = $this->db->get();

    return $query->result();
}
	
    public function updateComprobanteGasto($id_pedido, $data) {
        $this->db->where('id_pedido', $id_pedido);
        return $this->db->update('comprobante_gasto', $data);
    }

    public function updateFilaComprobanteGasto($IDComprobanteGasto, $filaData) {
        $this->db->where('IDComprobanteGasto', $IDComprobanteGasto);
        return $this->db->update('comprobante_gasto', $filaData);
    }
	public function update($id,$data){
		$this->db->where("IDComprobanteGasto",$id);
		return $this->db->update("comprobante_gasto",$data);
	}
	public function obtener_datos_presupuesto() {
		$this->db->select('
			presupuestos.ID_Presupuesto,
			origen_de_financiamiento.nombre AS origen_de_financiamiento_id_of,
			fuente_de_financiamiento.nombre AS fuente_de_financiamiento_id_ff,
			programa.nombre AS programa_id_pro,
			cuentacontable.Codigo_CC as codigo,
			cuentacontable.Relacion as rubro,
			presupuestos.Año,
			presupuestos.TotalPresupuestado,
			presupuestos.TotalModificado,
			GROUP_CONCAT(DISTINCT pm.mes ORDER BY FIELD(pm.mes, 
				"Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", 
				"Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"
			) SEPARATOR ", ") AS meses_presupuesto,
			presupuestos.id_uni_respon_usu,
			presupuestos.estado,
			COALESCE((
				SELECT pm_sub.monto_presupuestado - COALESCE(SUM(ej.pagado), 0)
				FROM presupuesto_mensual pm_sub
				LEFT JOIN ejecucion_mensual ej 
					ON ej.id_presupuesto = pm_sub.id_presupuesto 
					AND MONTH(ej.mes) = CASE pm_sub.mes
						WHEN "Enero" THEN 1
						WHEN "Febrero" THEN 2
						WHEN "Marzo" THEN 3
						WHEN "Abril" THEN 4
						WHEN "Mayo" THEN 5
						WHEN "Junio" THEN 6
						WHEN "Julio" THEN 7
						WHEN "Agosto" THEN 8
						WHEN "Septiembre" THEN 9
						WHEN "Octubre" THEN 10
						WHEN "Noviembre" THEN 11
						WHEN "Diciembre" THEN 12
					END
					AND YEAR(ej.mes) = YEAR(presupuestos.Año)
				WHERE pm_sub.id_presupuesto = presupuestos.ID_Presupuesto
				ORDER BY FIELD(pm_sub.mes, 
					"Diciembre", "Noviembre", "Octubre", "Septiembre", "Agosto", 
					"Julio", "Junio", "Mayo", "Abril", "Marzo", "Febrero", "Enero"
				) DESC
				LIMIT 1
			), 0) AS saldo_actual
		');
		
		$this->db->from('presupuestos');
		$this->db->join('origen_de_financiamiento', 'presupuestos.origen_de_financiamiento_id_of = origen_de_financiamiento.id_of');
		$this->db->join('fuente_de_financiamiento', 'presupuestos.fuente_de_financiamiento_id_ff = fuente_de_financiamiento.id_ff');
		$this->db->join('programa', 'presupuestos.programa_id_pro = programa.id_pro');
		$this->db->join('cuentacontable', 'presupuestos.Idcuentacontable = cuentacontable.Idcuentacontable');
		$this->db->join('presupuesto_mensual pm', 'pm.id_presupuesto = presupuestos.ID_Presupuesto', 'left');
		
		$this->db->group_by('presupuestos.ID_Presupuesto');
	
		return $this->db->get()->result_array();
	}//cambiamos para que se adapte a la nueva estructura de la tabla de presupuestos
	public function obtener_comprobantes_por_pedido($id_pedido) {
		$this->db->select('*');
		$this->db->from('comprobante_gasto');
		$this->db->where('id_pedido', $id_pedido); 
		
		$query = $this->db->get();
		return $query->result(); // Retorna todas las filas que coinciden con el id_pedido
	}


	public function getRubroYDescripcionByIdItem($id_item) {
		$this->db->select('rubro, descripcion');
		$this->db->from('bienes_servicios');
		$this->db->where('IDbienservicio', $id_item);
		$query = $this->db->get();
		
		if ($query->num_rows() > 0) {
			return $query->row();  
		} else {
			return null;  
		}
	}	

	public function getComprobantesGastosFiltrados($actividad, $periodo, $mes, $nropedido)
{
    $this->db->select('*');
    $this->db->from('comprobante_gasto');

    if (!empty($actividad)) {
        $this->db->where('id_unidad', $actividad);
    }
    if (!empty($periodo)) {
        $this->db->where('YEAR(fecha)', $periodo);
    }

    if (!empty($mes)) {
        $this->db->where('MONTH(fecha)', $mes);
    }
	if (!empty($nropedido)) {
        $this->db->where('id_pedido', $nropedido);
    }

    $query = $this->db->get();
    return $query->result();
}

public function getComprobanteReporte($id_pedido)
	{
		// Hacer un JOIN entre comprobante_gasto y proveedores
		$this->db->select('comprobante_gasto.*, proveedores.razon_social, proveedores.ruc ');
		$this->db->from('comprobante_gasto');
		$this->db->join('proveedores', 'comprobante_gasto.idproveedor = proveedores.id', 'left');
		$this->db->where('comprobante_gasto.id_pedido', $id_pedido);
	
		$query = $this->db->get();
	
    // Verifica si hay resultados
    if ($query->num_rows() > 0) {
        return $query->result_array(); // Retorna los resultados como un array
    } else {
        return false; // Retorna false si no hay resultados
    }
}
}
