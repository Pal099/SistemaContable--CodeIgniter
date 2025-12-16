<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Comprobante_Gasto_model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	public function getComprobantesGastos($id_uni_respon_usu)
	{
		$this->db->select('comprobante_gasto.*, proveedores.*');
		$this->db->from('comprobante_gasto');
		$this->db->join('uni_respon_usu', 'comprobante_gasto.id_uni_respon_usu = uni_respon_usu.id_uni_respon_usu');
		$this->db->join('proveedores', 'comprobante_gasto.idproveedor = proveedores.id');
		$this->db->where('comprobante_gasto.estado', '1');
		$this->db->where('uni_respon_usu.id_uni_respon_usu', $id_uni_respon_usu);
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
		$this->db->where('estado', '1');
		$this->db->group_by('id_pedido'); // Agrupa los resultados por id_pedido
		$query = $this->db->get();

		return $query->result();
	}

	public function obtener_comprobantes_por_pedido($id_pedido)
	{
		$this->db->where('id_pedido', $id_pedido);
		$this->db->where('estado', '1');
		$this->db->order_by('IDComprobanteGasto', 'ASC'); 
		return $this->db->get('comprobante_gasto')->result();
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
		// Obtenemos el mes y año actual
		$mes_actual = date('n'); // Mes actual sin ceros iniciales (1-12)
		$año_actual = date('Y'); // Año actual

		// Seleccionamos los datos principales y usamos un subquery para listar todos los meses disponibles
		$this->db->select('
			presupuestos.ID_Presupuesto,
			origen_de_financiamiento.codigo AS origen_de_financiamiento_id_of,
			origen_de_financiamiento.nombre AS origen_de_financiamiento_nombre,
			fuente_de_financiamiento.codigo AS fuente_de_financiamiento_id_ff,
			fuente_de_financiamiento.nombre AS fuente_de_financiamiento_nombre,
			programa.codigo AS programa_id_pro,
			programa.nombre AS programa_nombre,
			cuentacontable.Codigo_CC as codigo,
			cuentacontable.Relacion as rubro,
			cuentacontable.Descripcion_CC as rubro_descripcion,
			presupuestos.Año,
			presupuestos.TotalPresupuestado,
			presupuestos.TotalModificado,
			(
				SELECT GROUP_CONCAT(DISTINCT DATE_FORMAT(mes, "%M %Y") 
					ORDER BY mes
					SEPARATOR ", "
				)
				FROM presupuesto_mensual 
				WHERE id_presupuesto = presupuestos.ID_Presupuesto
			) AS meses_presupuesto,
			presupuestos.id_uni_respon_usu,
			presupuestos.estado,
			pm.monto_presupuestado,
			pm.monto_modificado
		');

		$this->db->from('presupuestos');
		$this->db->join('origen_de_financiamiento', 'presupuestos.origen_de_financiamiento_id_of = origen_de_financiamiento.id_of');
		$this->db->join('fuente_de_financiamiento', 'presupuestos.fuente_de_financiamiento_id_ff = fuente_de_financiamiento.id_ff');
		$this->db->join('programa', 'presupuestos.programa_id_pro = programa.id_pro');
		$this->db->join('cuentacontable', 'presupuestos.Idcuentacontable = cuentacontable.IDCuentaContable');

		// JOIN para el presupuesto mensual del mes actual
		$this->db->join(
			'presupuesto_mensual pm',
			'pm.id_presupuesto = presupuestos.ID_Presupuesto 
			 AND MONTH(pm.mes) = ' . $mes_actual . ' 
			 AND YEAR(pm.mes) = ' . $año_actual,
			'left'
		);

		// JOIN para la ejecución del mes actual (asumiendo que existe la tabla ejecucion_mensual)
		$this->db->join(
			'ejecucion_mensual ej',
			'ej.id_presupuesto = presupuestos.ID_Presupuesto 
			 AND MONTH(ej.mes) = ' . $mes_actual . ' 
			 AND YEAR(ej.mes) = ' . $año_actual,
			'left'
		);

		// Agrupamos para poder sumar los "obligado" de ejecución
		$this->db->group_by('presupuestos.ID_Presupuesto, pm.monto_presupuestado, pm.monto_modificado');

		// Calculamos el saldo: (monto_presupuestado + monto_modificado) - obligado
		$this->db->select('
			((COALESCE(pm.monto_presupuestado, 0) + COALESCE(pm.monto_modificado, 0)) - 
			 COALESCE(SUM(ej.obligado), 0)) as saldo_actual
		', false);

		$result = $this->db->get()->result_array();
		return $result;
	}

	/**
	 * Guarda todas las filas de un pedido (comprobante_gasto) y genera el asiento contable asociado.
	 * - Un pedido => un asiento
	 * - num_asi.id_form = 4
	 * - num_asi.concepto = comprobante_gasto.concepto
	 * - Marca comprobante_gasto.procesado_asiento=1, numero_asiento, fecha_procesado
	 * - Ejecuta ejecucion_mensual via EjecucionP_model->actualizarEjecucion(numero_asiento)
	 */
	public function guardar_pedido_y_generar_asiento($datosFormulario, $filas, $id_uni_respon_usu, $id_user)
	{
		$this->load->model('Diario_obli_model');
		$this->load->model('EjecucionP_model');

		$id_unidad = $datosFormulario['id_unidad'] ?? null;
		$fecha = $datosFormulario['fecha'] ?? null;
		$concepto = $datosFormulario['concepto'] ?? null;
		$id_proveedor = $datosFormulario['idproveedor'] ?? null;
		$id_presupuesto = $datosFormulario['idpresupuesto'] ?? null;

		if (empty($id_unidad) || empty($fecha) || empty($concepto) || empty($id_proveedor) || empty($id_presupuesto)) {
			return ['status' => 'error', 'message' => 'DatosFormulario incompletos'];
		}
		if (empty($filas) || !is_array($filas)) {
			return ['status' => 'error', 'message' => 'No se recibieron filas del comprobante'];
		}

		$id_pedido = $filas[0]['id_pedido'] ?? null;
		if (empty($id_pedido)) {
			return ['status' => 'error', 'message' => 'Falta id_pedido'];
		}

		// Evitar duplicación: un pedido no debe generar más de un asiento
		$this->db->select('IDComprobanteGasto, procesado_asiento, numero_asiento');
		$this->db->from('comprobante_gasto');
		$this->db->where('id_pedido', $id_pedido);
		$this->db->where('estado', 1);
		$this->db->where('procesado_asiento', 1);
		$yaProcesado = $this->db->get()->row();
		if ($yaProcesado) {
			return ['status' => 'error', 'message' => 'Este pedido ya fue procesado a asiento: ' . $yaProcesado->numero_asiento];
		}

		// Calcular monto total
		$monto_total = 0;
		foreach ($filas as $fila) {
			$monto_total += ((int)($fila['gravada'] ?? 0) > 0) ? (float)$fila['gravada'] : (float)($fila['exenta'] ?? 0);
		}
		if ($monto_total <= 0) {
			return ['status' => 'error', 'message' => 'Monto total inválido'];
		}

		// Obtener presupuesto (cuenta + dimensiones)
		$this->db->select('Idcuentacontable, origen_de_financiamiento_id_of, fuente_de_financiamiento_id_ff, programa_id_pro');
		$this->db->from('presupuestos');
		$this->db->where('ID_Presupuesto', $id_presupuesto);
		$presupuesto = $this->db->get()->row();
		if (!$presupuesto) {
			return ['status' => 'error', 'message' => 'No se encontró presupuesto'];
		}

		$idCuentaDebe = (int)$presupuesto->Idcuentacontable;
		$id_of = (int)$presupuesto->origen_de_financiamiento_id_of;
		$id_ff = (int)$presupuesto->fuente_de_financiamiento_id_ff;
		$id_pro = (int)$presupuesto->programa_id_pro;

		// Derivar cuenta A.P. (HABER) a partir de Código_CC de la cuenta DEBE
		$this->db->select('Codigo_CC');
		$this->db->from('cuentacontable');
		$this->db->where('IDCuentaContable', $idCuentaDebe);
		$cuentaDebe = $this->db->get()->row();
		if (!$cuentaDebe || empty($cuentaDebe->Codigo_CC)) {
			return ['status' => 'error', 'message' => 'No se pudo obtener Código_CC de la cuenta presupuestada'];
		}

		$codigo = (string)$cuentaDebe->Codigo_CC;
		if (!preg_match('/^(\d{2})(\d{3})(\d{7})$/', $codigo, $m)) {
			return ['status' => 'error', 'message' => 'Código_CC no cumple patrón 2-3-7: ' . $codigo];
		}
		$segundaParte = $m[2];

		$this->db->select('IDCuentaContable');
		$this->db->from('cuentacontable');
		$this->db->where('imputable', 2);
		$this->db->like('Codigo_CC', $segundaParte);
		$this->db->limit(1);
		$cuentaHaber = $this->db->get()->row();
		if (!$cuentaHaber) {
			return ['status' => 'error', 'message' => 'No se encontró cuenta A.P. (imputable=2) para: ' . $segundaParte];
		}
		$idCuentaHaber = (int)$cuentaHaber->IDCuentaContable;

		// Próximo número de asiento por unidad responsable
		$max = $this->Diario_obli_model->getMaxNumAsiAndOp($id_uni_respon_usu);
		$numero_asiento = (int)($max->ultimo_numero ?? 0) + 1;

		$this->db->trans_start();

		// Guardar filas del comprobante
		foreach ($filas as $fila) {
			$ivaFlag = !empty($fila['iva']) ? 1 : 0;
			$porcentajeIva = $fila['piva'] ?? ($fila['porcentaje_iva'] ?? 0);
			$porcentajeIva = (int)$porcentajeIva;
			if ($ivaFlag === 1) {
				if ($porcentajeIva !== 5 && $porcentajeIva !== 10) {
					$porcentajeIva = 10;
				}
			} else {
				$porcentajeIva = 0;
			}

			$dataPedido = array(
				'id_pedido' => $id_pedido,
				'id_unidad' => $id_unidad,
				'fecha' => $fecha,
				'idpresupuesto' => $id_presupuesto,
				'idproveedor' => $id_proveedor,
				'descripcion' => $fila['descripcion'],
				'concepto' => $concepto,
				'id_item' => $fila['id_item'],
				'preciounit' => $fila['precioUnit'],
				'cantidad' => $fila['cantidad'],
				'iva' => $ivaFlag,
				'porcentaje_iva' => $porcentajeIva,
				'exenta' => $fila['exenta'],
				'gravada' => $fila['gravada'],
				'id_uni_respon_usu' => $id_uni_respon_usu,
				'estado' => 1,
				'procesado_asiento' => 0,
			);
			$this->db->insert('comprobante_gasto', $dataPedido);
		}

		// Insertar num_asi (id_form = 4)
		$dataNumAsi = array(
			'FechaEmision' => $fecha,
			'num_asi' => $numero_asiento,
			'op' => 0,
			'str' => 0,
			'concepto' => $concepto,
			'SumaMonto' => $monto_total,
			'MontoTotal' => $monto_total,
			'id_form' => 4,
			'id_provee' => $id_proveedor,
			'id_uni_respon_usu' => $id_uni_respon_usu,
			'id_usuario_numasi' => $id_user,
			'estado_registro' => 1,
		);
		$this->db->insert('num_asi', $dataNumAsi);
		$idNumAsi = $this->db->insert_id();

		// DEBE (contrapartida calculada: A.P.)
		$dataDebe = array(
			'numero' => $numero_asiento,
			'IDCuentaContable' => $idCuentaHaber,
			'MontoPago' => 0,
			'Debe' => $monto_total,
			'Haber' => 0,
			'comprobante' => (string)$id_pedido,
			'detalles' => $concepto,
			'id_of' => $id_of,
			'id_pro' => $id_pro,
			'Num_Asi_IDNum_Asi' => $idNumAsi,
			'id_ff' => $id_ff,
			'id_form' => 4,
			'cheques_che_id' => 0,
			'proveedores_id' => $id_proveedor,
			'id_uni_respon_usu' => $id_uni_respon_usu,
			'estado_registro' => 1,
		);
		$this->db->insert('num_asi_deta', $dataDebe);

		// HABER (cuenta presupuestada)
		$dataHaber = array(
			'numero' => $numero_asiento,
			'IDCuentaContable' => $idCuentaDebe,
			'MontoPago' => $monto_total,
			'Debe' => 0,
			'Haber' => $monto_total,
			'comprobante' => (string)$id_pedido,
			'detalles' => $concepto,
			'id_of' => $id_of,
			'id_pro' => $id_pro,
			'Num_Asi_IDNum_Asi' => $idNumAsi,
			'id_ff' => $id_ff,
			'id_form' => 4,
			'cheques_che_id' => 0,
			'proveedores_id' => $id_proveedor,
			'id_uni_respon_usu' => $id_uni_respon_usu,
			'estado_registro' => 1,
		);
		$this->db->insert('num_asi_deta', $dataHaber);

		// Marcar comprobante como procesado (por pedido)
		$this->db->set('procesado_asiento', 1);
		$this->db->set('numero_asiento', $numero_asiento);
		$this->db->set('fecha_procesado', date('Y-m-d H:i:s'));
		$this->db->where('id_pedido', $id_pedido);
		$this->db->where('estado', 1);
		$this->db->update('comprobante_gasto');

		$this->db->trans_complete();
		if ($this->db->trans_status() === false) {
			return ['status' => 'error', 'message' => 'Falló la transacción al guardar comprobante/asiento'];
		}

		// Actualizar ejecución (id_form=4 => obligado)
		if (!$this->EjecucionP_model->actualizarEjecucion($numero_asiento)) {
			log_message('error', 'Error al actualizar ejecución mensual para num_asi: ' . $numero_asiento);
		}

		return ['status' => 'success', 'numero_asiento' => $numero_asiento, 'id_pedido' => $id_pedido];
	}
	//cambiamos para que se adapte a la nueva estructura de la tabla de presupuestos(probablemente será mejor cambiar MES presupuesto_mensual a DATE)
/**
     * Devuelve la cuenta de contrapartida (A.P. / imputable=2) asociada a la cuenta del presupuesto.
     * Regla: tomar Codigo_CC de la cuenta presupuestada, extraer la "segunda parte" (patrón 2-3-7),
     * y buscar en cuentacontable una cuenta imputable=2 que contenga esa segunda parte.
     *
     * @param int $id_presupuesto
     * @return array|null { IDCuentaContable, Codigo_CC, Descripcion_CC } o null si no se encuentra
     */
public function getCuentaContrapartidaPorPresupuesto($id_presupuesto)
    {
        $id_presupuesto = (int)$id_presupuesto;
        if ($id_presupuesto <= 0) return null;

        // Presupuesto -> cuenta presupuestada -> Codigo_CC
        $this->db->select('p.Idcuentacontable, cc.Codigo_CC');
        $this->db->from('presupuestos p');
        $this->db->join('cuentacontable cc', 'cc.IDCuentaContable = p.Idcuentacontable', 'inner');
        $this->db->where('p.ID_Presupuesto', $id_presupuesto);
        $row = $this->db->get()->row();

        if (!$row || empty($row->Codigo_CC)) return null;

        if (!preg_match('/^(\\d{2})(\\d{3})(\\d{7})$/', trim($row->Codigo_CC), $m)) {
            return null;
        }

        $segundaParte = $m[2];

        // Buscar cuenta padre A.P. (imputable=2) por coincidencia de la segunda parte
        $this->db->select('IDCuentaContable, Codigo_CC, Descripcion_CC');
        $this->db->from('cuentacontable');
        $this->db->where('imputable', 2);
        $this->db->like('Codigo_CC', $segundaParte);
        $this->db->order_by('IDCuentaContable', 'ASC');
        $this->db->limit(1);

        $ap = $this->db->get()->row_array();
        return $ap ?: null;
    }

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
