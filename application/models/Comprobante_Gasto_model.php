<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Comprobante_Gasto_model extends CI_Model
{

	public function getComprobantesGastos($id_uni_respon_usu)
	{
		$this->db->select('comprobante_gasto.*, proveedores.*');
		$this->db->from('comprobante_gasto');
		$this->db->join('unidad_academica', 'comprobante_gasto.id_uni_respon_usu = unidad_academica.id_unidad');
		$this->db->join('proveedores', 'comprobante_gasto.idproveedor = proveedores.id');
		$this->db->where('comprobante_gasto.estado', '1');
		$this->db->where('unidad_academica.id_unidad', $id_uni_respon_usu);

		$resultados = $this->db->get();
		return $resultados->result();
	}



	public function save($data)
	{

		return $this->db->insert('comprobante_gasto', $data);
	}

	public function getMaxPedido()
	{
		$this->db->select_max('id_pedido', 'maxPedido');
		$query = $this->db->get('comprobante_gasto');
		return $query->row()->maxPedido;
	}

	public function getComprobanteGasto($id)
	{
		$this->db->where("IDComprobanteGasto", $id);
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

	public function updateComprobanteGasto($id_pedido, $data)
	{
		$this->db->where('id_pedido', $id_pedido);
		return $this->db->update('comprobante_gasto', $data);
	}

	public function updateFilaComprobanteGasto($IDComprobanteGasto, $filaData)
	{
		$this->db->where('IDComprobanteGasto', $IDComprobanteGasto);
		return $this->db->update('comprobante_gasto', $filaData);
	}
	public function update($id, $data)
	{
		$this->db->where("IDComprobanteGasto", $id);
		return $this->db->update("comprobante_gasto", $data);
	}
	public function obtener_datos_presupuesto()
	{
<<<<<<< HEAD
=======
		// Arreglo de meses abreviados (tal como se define en el enum de la tabla)
		$meses = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];
		$mes_actual = $meses[date('n') - 1]; // date('n') devuelve el mes sin ceros iniciales

		// Seleccionamos los datos principales y usamos un subquery para listar todos los meses disponibles
>>>>>>> 6ee9dee472ac19d6011acc668569e1f7a084ecc0
		$this->db->select('
			presupuestos.ID_Presupuesto,
			origen_de_financiamiento.nombre AS origen_de_financiamiento_id_of,
			fuente_de_financiamiento.nombre AS fuente_de_financiamiento_id_ff,
			programa.nombre AS programa_id_pro,
<<<<<<< HEAD
			cuentacontable.Codigo_CC AS codigo,
			cuentacontable.Relacion AS rubro,
=======
			cuentacontable.Codigo_CC as codigo,
			cuentacontable.Relacion as rubro,
>>>>>>> 6ee9dee472ac19d6011acc668569e1f7a084ecc0
			presupuestos.Año,
			presupuestos.TotalPresupuestado,
			presupuestos.TotalModificado,
			(
<<<<<<< HEAD
				SELECT GROUP_CONCAT(DISTINCT DATE_FORMAT(pm2.mes, "%Y-%m") 
					ORDER BY pm2.mes
					SEPARATOR ", "
				)
				FROM presupuesto_mensual pm2
				WHERE pm2.id_presupuesto = presupuestos.ID_Presupuesto
=======
            SELECT GROUP_CONCAT(DISTINCT mes 
                ORDER BY FIELD(mes, "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre")
                SEPARATOR ", "
            )
				FROM presupuesto_mensual 
				WHERE id_presupuesto = presupuestos.ID_Presupuesto
>>>>>>> 6ee9dee472ac19d6011acc668569e1f7a084ecc0
			) AS meses_presupuesto,
			presupuestos.id_uni_respon_usu,
			presupuestos.estado
		');
		$this->db->from('presupuestos');
		$this->db->join('origen_de_financiamiento', 'presupuestos.origen_de_financiamiento_id_of = origen_de_financiamiento.id_of');
		$this->db->join('fuente_de_financiamiento', 'presupuestos.fuente_de_financiamiento_id_ff = fuente_de_financiamiento.id_ff');
		$this->db->join('programa', 'presupuestos.programa_id_pro = programa.id_pro');
		$this->db->join('cuentacontable', 'presupuestos.Idcuentacontable = cuentacontable.Idcuentacontable');

<<<<<<< HEAD
		// JOIN para obtener el registro de presupuesto mensual del mes actual
		$this->db->join(
			'presupuesto_mensual pm',
			'pm.id_presupuesto = presupuestos.ID_Presupuesto 
			 AND MONTH(pm.mes) = MONTH(CURRENT_DATE()) 
			 AND YEAR(pm.mes) = YEAR(CURRENT_DATE())',
			'left'
		);
		// JOIN para la ejecución del mes actual
=======
		// JOIN para el presupuesto mensual del mes actual
		$this->db->join(
			'presupuesto_mensual pm',
			'pm.id_presupuesto = presupuestos.ID_Presupuesto AND pm.mes = ' . $this->db->escape($mes_actual),
			'left'
		);
		// JOIN para la ejecución del mes actual (la tabla ejecucion_mensual tiene campo mes de tipo datetime)
>>>>>>> 6ee9dee472ac19d6011acc668569e1f7a084ecc0
		$this->db->join(
			'ejecucion_mensual ej',
			'ej.id_presupuesto = presupuestos.ID_Presupuesto 
			 AND MONTH(ej.mes) = MONTH(CURRENT_DATE()) 
			 AND YEAR(ej.mes) = YEAR(CURRENT_DATE())',
			'left'
		);

<<<<<<< HEAD
		// Agrupamos para sumar el total de "obligado"
		$this->db->group_by('presupuestos.ID_Presupuesto, pm.monto_presupuestado, pm.monto_modificado');

		// Calculamos el saldo disponible: (monto_presupuestado + monto_modificado) - SUM(ej.obligado)
		$this->db->select('(COALESCE(pm.monto_presupuestado, 0) + COALESCE(pm.monto_modificado, 0) - COALESCE(SUM(ej.obligado), 0)) AS saldo_actual', false);
=======
		// Agrupamos para poder sumar los "obligado" de ejecución
		$this->db->group_by('presupuestos.ID_Presupuesto, pm.monto_presupuestado, pm.monto_modificado');

		// Calculamos el saldo: (monto_presupuestado + monto_modificado) - SUM(ej.obligado)
		$this->db->select('(COALESCE(SUM(ej.obligado), 0) - (COALESCE(pm.monto_presupuestado, 0) + COALESCE(pm.monto_modificado, 0))) as saldo_actual', false);
>>>>>>> 6ee9dee472ac19d6011acc668569e1f7a084ecc0

		$result = $this->db->get()->result_array();
		return $result;
	}
<<<<<<< HEAD

=======
>>>>>>> 6ee9dee472ac19d6011acc668569e1f7a084ecc0
	//cambiamos para que se adapte a la nueva estructura de la tabla de presupuestos(probablemente será mejor cambiar MES presupuesto_mensual a DATE)


	public function getRubroYDescripcionByIdItem($id_item)
	{
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
