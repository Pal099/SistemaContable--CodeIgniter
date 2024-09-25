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
	/*public function getComprobanteGasto($id = null, $id_pedido = null){
		if ($id !== null) {
			$this->db->where("IDComprobanteGasto", $id);
		}
		if ($id_pedido !== null) {
			$this->db->or_where("id_pedido", $id_pedido); 
		}
		
		$resultado = $this->db->get("comprobante_gasto");
		return $resultado->row();
	}*/
	
 
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

	public function getComprobantesGastosFiltrados($actividad, $fuente, $periodo, $mes, $nropedido)
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
	if (!empty($nropedido)) {
        $this->db->where('id_pedido', $nropedido);
    }

    $query = $this->db->get();
    return $query->result();
}
}
