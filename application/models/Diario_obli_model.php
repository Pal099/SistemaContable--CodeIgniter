<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Diario_obli_model extends CI_Model
{
	//acá empieza el javorai de isaac
	//num asi primero
	public function __construct()
	{
		$this->load->database();
	}
	public function obtener_asientos()
	{
		return $this->db->get('num_asi')->result_array();
		var_dump($result); // Solo para depuración
		return $result;

	}

	public function GETasientos($id_uni_respon_usu)
	{
		$this->db->select('na.IDNum_Asi, na.FechaEmision, na.num_asi, na.op, na.estado_registro, p.razon_social, na.MontoTotal');
		$this->db->from('num_asi na');
		$this->db->join('uni_respon_usu uru', 'na.id_uni_respon_usu = uru.id_uni_respon_usu');
		$this->db->join('proveedores p', 'na.id_provee = p.id'); // Corregido para unir con la tabla de proveedores correctamente
		$this->db->where('na.estado_registro', '1');
		$this->db->where('na.id_form', '1');
		$this->db->where('uru.id_uni_respon_usu', $id_uni_respon_usu);

		$resultados = $this->db->get();
		return $resultados->result();
	}

	public function GETasientosD($id_uni_respon_usu)
	{
		$this->db->select('IDNum_Asi, FechaEmision, num_asi, op, estado');
		$this->db->where('estado_registro', '1');
		$this->db->join('uni_respon_usu', 'num_asi.id_uni_respon_usu = uni_respon_usu.id_uni_respon_usu');
		$this->db->where('uni_respon_usu.id_uni_respon_usu', $id_uni_respon_usu);
		$resultados = $this->db->get('num_asi');
		return $resultados->result();
	}


	public function obtener_asiento_por_id($id)
	{
		$this->db->where('IDNum_Asi', $id);
		return $this->db->get('num_asi')->row_array();
	}
	public function insertar_asiento($data)
	{
		return $this->db->insert('num_asi', $data);
	}

	public function eliminar_asiento($id)
	{
		$this->db->where('IDNum_Asi', $id);
		return $this->db->delete('num_asi');
	}
	public function save_num_asi($data, $proveedor_id)
	{
		$this->db->where('id_provee', $proveedor_id);
		$this->db->insert("num_asi", $data);

		// Obtener el último ID insertado
		$lastInsertedId = $this->db->insert_id();

		return $lastInsertedId;
	}
	//Funcion para obtener los asientos para su futura edicion
	public function GetAsientoEditar($IDNum_Asi)
	{
		$this->db->select('num_asi.IDNum_Asi, num_asi.FechaEmision, num_asi.num_asi, num_asi.op, num_asi.SumaMonto, num_asi.MontoTotal, 
		num_asi.id_provee, num_asi.concepto, num_asi.ped_mat, num_asi.modalidad, num_asi.tipo_presu, num_asi.nro_exp, 
		num_asi.MontoTotal, num_asi.MontoPagado, num_asi_deta.IDCuentaContable, num_asi_deta.MontoPago, num_asi_deta.Debe, 
		num_asi_deta.Haber, num_asi_deta.Comprobante, num_asi_deta.detalles, num_asi_deta.id_of, num_asi_deta.id_pro, 
		num_asi_deta.id_ff, num_asi_deta.cheques_che_id, num_asi_deta.IDNum_Asi_Deta');
		$this->db->from('num_asi');
		$this->db->join('num_asi_deta', 'num_asi.IdNum_Asi = num_asi_deta.Num_Asi_IDNum_Asi ');
		$this->db->where('num_asi.IDNUM_Asi', $IDNum_Asi);
		$this->db->where('num_asi.estado_registro', 1); // Condicion para saber si se borro el registro o no
		$this->db->where('num_asi_deta.estado_registro', 1); // Condicion para saber si se borro el registro o no

		$query = $this->db->get();
		//Guardamos el resultado de la busqueda en un array
		$arrayOriginal = $query->result();
		//Declaramos un array para poder agrupar nuestros datos en fijos y los dinamicos (la tabla)
		$agrupados = [];

		foreach ($arrayOriginal as $index => $objeto) {
			// Crear una clave única basada en las propiedades que no cambian en este caso los datos del formulario
			$claveUnica = $objeto->FechaEmision . '_' . $objeto->num_asi . '_' . $objeto->id_provee;

			// Si la clave no existe en el array $agrupados, inicializarla
			if (!array_key_exists($claveUnica, $agrupados)) {
				$agrupados[$claveUnica] = [
					'datosFijos' => [
						'IDNum_Asi' => $objeto->IDNum_Asi,
						'FechaEmision' => $objeto->FechaEmision,
						'num_asi' => $objeto->num_asi,
						'id_provee' => $objeto->id_provee,
						'op' => $objeto->op,
						'concepto' => $objeto->concepto,
						'ped_mat' => $objeto->ped_mat,
						'modalidad' => $objeto->modalidad,
						'tipo_presu' => $objeto->tipo_presu,
						'nro_exp' => $objeto->nro_exp,
						'MontoTotal' => $objeto->MontoTotal,
						'MontoPagado' => $objeto->MontoPagado,
						// Se puede seguir agregando segun la necesidad o los datos de la bd
					],
					//Array para los campos dinamicos
					'camposDinamicos' => [],
				];
			}

			// Creamos un objeto para los campos dinámicos
			$campoDinamico = new stdClass();
			$campoDinamico->IDNum_Asi_Deta = $objeto->IDNum_Asi_Deta;
			$campoDinamico->IDCuentaContable = $objeto->IDCuentaContable;
			$campoDinamico->Debe = $objeto->Debe;
			$campoDinamico->Haber = $objeto->Haber;
			$campoDinamico->id_of = $objeto->id_of;
			$campoDinamico->id_pro = $objeto->id_pro;
			$campoDinamico->id_ff = $objeto->id_ff;
			$campoDinamico->Comprobante = $objeto->Comprobante;
			$campoDinamico->detalles = $objeto->detalles;

			// Agregamos el objeto de campos dinámicos al array correspondiente
			$agrupados[$claveUnica]['camposDinamicos'][] = $campoDinamico;
		}

		// Convertimos el array de objetos agrupados en un array simple
		$arrayFinal = array_values($agrupados);

		return $arrayFinal;
	}

	//----------Funciones nuevas del editar----------
	public function actualizar_num_asi($id, $data)
	{
		$this->db->where('IDNum_Asi', $id);
		return $this->db->update('num_asi', $data);
	}

	public function update_num_asi_deta($IDNum_Asi_Deta, $data)
	{
		$this->db->where('IDNum_Asi_Deta', $IDNum_Asi_Deta);
		return $this->db->update('num_asi_deta', $data);
	}

	public function update_num_asi_deta_fila_nueva($data)
	{
		return $this->db->insert('num_asi_deta', $data);
	}

	public function borrado_logico($IDNum_Asi_Deta)
	{
		$data = array('estado_registro' => 0);
		$this->db->where('IDNum_Asi_Deta', $IDNum_Asi_Deta);
		return $this->db->update('num_asi_deta', $data);
	}

	//----------Acá terminan las funciones nuevas del editar----------

	// num asi deta segundo
	public function obtener_detalles_por_asiento($idAsiento)
	{
		$this->db->where('Num_Asi_IDNum_Asi', $idAsiento);
		return $this->db->get('num_asi_deta')->result_array();
	}

	public function obtener_detalle_por_id($idDetalle)
	{
		$this->db->where('IDNum_Asi_Deta', $idDetalle);
		return $this->db->get('num_asi_deta')->row_array();
	}

	public function insertar_detalle($data)
	{
		return $this->db->insert('num_asi_deta', $data);
	}

	public function actualizar_detalle($idDetalle, $data)
	{
		$this->db->where('IDNum_Asi_Deta', $idDetalle);
		return $this->db->update('num_asi_deta', $data);
	}

	public function eliminar_detalle($idDetalle)
	{
		$this->db->where('IDNum_Asi_Deta', $idDetalle);
		return $this->db->delete('num_asi_deta');
	}









	//desde acá es código de palo
	public function obtenerEstadoSegunSumaMonto($proveedor_id)
	{
		// Consulta SQL preparada para obtener la información más reciente de la tabla num_asi para un proveedor específico
		$consulta = "SELECT * FROM num_asi WHERE id_provee = ? ORDER BY FechaEmision DESC LIMIT 1";

		// Ejecuta la consulta preparada
		$resultado = $this->db->query($consulta, array($proveedor_id));

		// Verifica si se obtuvieron resultados
		if ($resultado->num_rows() > 0) {
			$row = $resultado->row();

			// Verifica la condición para determinar el estado y devuelve el número correspondiente
			if ($row->SumaMonto != $row->MontoTotal) {
				return 3; // Pendiente
			}
			if ($row->SumaMonto == $row->MontoTotal) {
				return 4; // Pagado
			}
		} else {
			// En caso de no encontrar registros
			return null;
		}
	}


	public function getProveedorIdByRuc($ruc)
	{
		$this->db->select('id');
		$this->db->where('ruc', $ruc);
		$query = $this->db->get('proveedores');

		if ($query->num_rows() > 0) {
			$row = $query->row();
			return $row->id;
		} else {
			return false;
		}
	}

	public function getUsuarioId($nombre)
	{
		$nombre = $this->session->userdata("Nombre_usuario");
		$this->db->select('id_user');
		$this->db->where('Nombre_usuario', $nombre);
		$query = $this->db->get('usuarios');

		if ($query->num_rows() > 0) {
			$row = $query->row();
			return $row->id_user;
		} else {
			return false;
		}

	}


	public function getDiarios()
	{
		$this->db->where("estado", "1");
		$resultados = $this->db->get("proveedores");
		return $resultados->result();
	}

	public function saveDebe($data)
	{
		return $this->db->insert("num_asi_deta", $data);
	}

	public function saveHaber($data)
	{
		return $this->db->insert("num_asi_deta", $data);
	}


	public function getDiario($id)
	{
		$this->db->where("id", $id);
		$resultado = $this->db->get("proveedores");
		return $resultado->row();

	}

	public function update($id, $data)
	{
		$this->db->where("id", $id);
		return $this->db->update("proveedores", $data);
	}

	public function getProgramGastos($id_uni_respon_usu)
	{
		$this->db->select('programa.*');
		$this->db->from('programa');
		$this->db->join('uni_respon_usu', 'programa.id_uni_respon_usu = uni_respon_usu.id_uni_respon_usu');
		$this->db->where('programa.estado', '1');
		$this->db->where('uni_respon_usu.id_uni_respon_usu', $id_uni_respon_usu);

		$resultados = $this->db->get();
		return $resultados->result();
	}

	public function getFuentes($id_uni_respon_usu)
	{
		$this->db->select('fuente_de_financiamiento.*');
		$this->db->from('fuente_de_financiamiento');
		$this->db->join('uni_respon_usu', 'fuente_de_financiamiento.id_uni_respon_usu = uni_respon_usu.id_uni_respon_usu');
		$this->db->where('fuente_de_financiamiento.estado', '1');
		$this->db->where('uni_respon_usu.id_uni_respon_usu', $id_uni_respon_usu);
		$resultados = $this->db->get();
		return $resultados->result();
	}

	public function getOrigenes($id_uni_respon_usu)
	{
		$this->db->select('origen_de_financiamiento.*');
		$this->db->from('origen_de_financiamiento');
		$this->db->join('uni_respon_usu', 'origen_de_financiamiento.id_uni_respon_usu = uni_respon_usu.id_uni_respon_usu');
		$this->db->where('origen_de_financiamiento.estado', '1');
		$this->db->where('uni_respon_usu.id_uni_respon_usu', $id_uni_respon_usu);

		$resultados = $this->db->get();
		return $resultados->result();
	}



	public function getPresupuesto()
	{
		$this->db->select('presupuestos.*, cuentacontable.Codigo_CC as codigo, cuentacontable.IDCuentaContable as idcuenta,
		cuentacontable.Descripcion_CC as descrip,');
		$this->db->from('presupuestos');
		$this->db->join('uni_respon_usu', 'presupuestos.id_uni_respon_usu = uni_respon_usu.id_uni_respon_usu');
		$this->db->join('cuentacontable', 'presupuestos.Idcuentacontable = cuentacontable.IDCuentaContable');
		$this->db->where('presupuestos.estado', '1');
		$this->db->where('(pre_ene > 0 OR pre_feb > 0 OR pre_mar > 0 OR pre_abr > 0 OR pre_may > 0 OR pre_jun > 0 OR pre_jul > 0 OR pre_ago > 0 OR pre_sep > 0 OR pre_oct > 0 OR pre_nov > 0 OR pre_dic > 0)');
		//$this->db->where('uni_respon_usu.id_uni_respon_usu', $id_uni_respon_usu);
		$resultados = $this->db->get();
		return $resultados->result();
	}

	public function getPresupuestoMes()
	{
		$this->db->select('ID_Presupuesto, pre_ene, pre_feb, pre_mar, pre_abr, pre_may, pre_jun, pre_jul, pre_ago, pre_sep, pre_oct, pre_nov, pre_dic');
		$this->db->from('presupuestos');
		$this->db->where('estado', '1');
		$this->db->where('(pre_ene > 0 OR pre_feb > 0 OR pre_mar > 0 OR pre_abr > 0 OR pre_may > 0 OR pre_jun > 0 OR pre_jul > 0 OR pre_ago > 0 OR pre_sep > 0 OR pre_oct > 0 OR pre_nov > 0 OR pre_dic > 0)');
		$resultados = $this->db->get()->result();
		// Procesar los resultados si es necesario
		$meses = array();
		foreach ($resultados as $fila) {
			// Aquí puedes hacer cualquier procesamiento adicional si es necesario
			// Por ejemplo, podrías filtrar los valores aquí mismo

			$meses[] = $fila;
		}

		// Devolver los resultados procesados
		return $meses;

	}



	//guardar asientos
	public function guardar_asiento($data, $dataDetaDebe, $dataDetaHaber)
	{
		$this->db->trans_start();  // Iniciar transacción

		$this->db->insert('num_asi', $data);
		$this->db->insert('num_asi_deta', $dataDetaDebe);
		$this->db->insert('num_asi_deta', $dataDetaHaber);

		$this->db->trans_complete();  // Completar transacción

		return $this->db->trans_status();  // Devuelve TRUE si todo está OK o FALSE si hay algún fallo
	}

	public function getCuentaContable()
	{
		$query = $this->db->get("cuentacontable");
		return $query->result();
	}

	public function getDiarios_obli()
	{
		$this->db->select('proveedores.id as id_provee, programa.nombre as nombre_programa, fuente_de_financiamiento.nombre as nombre_fuente, origen_de_financiamiento.nombre as nombre_origen, cuentacontable.CodigoCuentaContable as Codigocuentacontable ,cuentacontable.DescripcionCuentaContable as Desccuentacontable ,');
		$this->db->from('num_asi_deta');
		$this->db->join('programa', 'num_asi_deta.id_pro = programa.id_pro', 'left');
		$this->db->join('fuente_de_financiamiento', 'num_asi_deta.id_ff = fuente_de_financiamiento.id_ff');
		$this->db->join('origen_de_financiamiento', 'num_asi_deta.id_of = origen_de_financiamiento.id_of');
		$this->db->join('cuentacontable', 'num_asi_deta.IDCuentaContable = cuentacontable.IDCuentaContable');
		$this->db->join('proveedores', 'num_asi_deta.proveedores_id = proveedores.id');

		$query = $this->db->get();
	}

	// En tu modelo Diario_obli_model
	public function getMontoPagadoPorIdNumAsi($proveedor_id, $idNumAsi)
	{
		$this->db->select_sum('MontoPago');
		$this->db->where('proveedores_id', $proveedor_id);
		$this->db->where('Num_Asi_IDNum_Asi', $idNumAsi);
		$query = $this->db->get('num_asi_deta');

		if ($query->num_rows() > 0) {
			$result = $query->row();
			return $result->MontoPago;
		}

		return 0;
	}

	public function guardar_monto_pago($idNumAsi, $nuevoMontoPago)
	{
		// Actualiza el campo MontoPagado en la fila correspondiente
		$this->db->where('IDNum_Asi', $idNumAsi);
		$this->db->update('num_asi', ['MontoPagado' => $nuevoMontoPago]);
	}

	// En tu modelo Diario_obli_model
	public function getPrimerIdNumAsi($proveedor_id)
	{
		$this->db->select_min('IDNum_Asi');
		$this->db->where('id_provee', $proveedor_id);
		$query = $this->db->get('num_asi');

		if ($query->num_rows() > 0) {
			$result = $query->row();
			return $result->IDNum_Asi;
		}

		return null;
	}

	public function getMontoPagoAnterior($proveedor_id)
	{
		$this->db->select('SumaMonto');
		$this->db->where('id_provee', $proveedor_id);
		$this->db->order_by('num_asi.IDNum_Asi', 'DESC'); // Ordena por IDNum_Asi de forma descendente
		$this->db->limit(2); // Limita el resultado a dos filas (la más reciente y la anterior)

		$query = $this->db->get('num_asi');

		if ($query->num_rows() > 1) {
			// Obtiene el segundo resultado (la fila anterior)
			$query->next_row();
			return $query->row()->SumaMonto;
		} else {
			return 0; // O cualquier valor predeterminado si no hay registros anteriores
		}
	}


	public function updateSumaMonto($id_num_asi, $suma_monto, $proveedor_id)
	{
		$this->db->where('IDNum_Asi', $id_num_asi);
		$this->db->where('id_form', '1');
		$this->db->where('id_provee', $proveedor_id);
		$this->db->update('num_asi', array('SumaMonto' => $suma_monto, 'MontoPagado' => $suma_monto));
		return $this->db->affected_rows() > 0;
	}

	//update en presupuesto a corde del valor restante luego de la obligacion
	public function updatepresu($id_presu, $valpresu, $mes)
	{
		$this->db->where('ID_Presupuesto', $id_presu);
		$this->db->where('estado', '1');
		switch ($mes) {
			case '01':
				$this->db->update('presupuestos', array('pre_ene' => $valpresu));
				break;
			case '02':
				$this->db->update('presupuestos', array('pre_feb' => $valpresu));
				break;
			case '03':
				$this->db->update('presupuestos', array('pre_mar' => $valpresu));
				break;
			case '04':
				$this->db->update('presupuestos', array('pre_abr' => $valpresu));
				break;
			case '05':
				$this->db->update('presupuestos', array('pre_may' => $valpresu));
				break;
			case '06':
				$this->db->update('presupuestos', array('pre_jun' => $valpresu));
				break;
			case '07':
				$this->db->update('presupuestos', array('pre_jul' => $valpresu));
				break;
			case '08':
				$this->db->update('presupuestos', array('pre_ago' => $valpresu));
				break;
			case '09':
				$this->db->update('presupuestos', array('pre_sep' => $valpresu));
				break;
			case '10':
				$this->db->update('presupuestos', array('pre_oct' => $valpresu));
				break;
			case '11':
				$this->db->update('presupuestos', array('pre_nov' => $valpresu));
				break;
			case '12':
				$this->db->update('presupuestos', array('pre_dic' => $valpresu));
				break;
		}
		return $this->db->affected_rows() > 0;
	}

	public function updateEstadoSuma($idNum_Asi, $num_asi, $suma_monto, $proveedor_id, $nuevo_monto_pagado)
	{
		$this->db->where('IDNum_Asi', $idNum_Asi);
		$this->db->where('num_asi', $num_asi);
		$this->db->where('SumaMonto', $suma_monto);
		$this->db->where('id_provee', $proveedor_id);
		$this->db->where('MontoPagado', $nuevo_monto_pagado);
		$this->db->where('(SumaMonto = MontoTotal OR SumaMonto > MontoTotal)');

		$this->db->update('num_asi', array('estado' => 1, 'SumaMonto' => $suma_monto));

		return $this->db->affected_rows() > 0;
	}



	// En Diario_obli_model.php

	public function getMontoPagadoByIdForm($proveedor_id)
	{
		$this->db->select_sum('MontoPagado');
		$this->db->from('num_asi');
		$this->db->where('id_provee', $proveedor_id);
		$this->db->where('id_form', 1);
		$query = $this->db->get();

		return $query->row()->MontoPagado;
	}

	public function updateMontoPagadoByIdForm($proveedor_id, $monto_pagado)
	{
		$this->db->where('id_provee', $proveedor_id);
		$this->db->where('id_form', 1);
		$this->db->set('MontoPagado', $monto_pagado);
		$this->db->update('num_asi');
	}





	public function getDebeFromNumAsiDeta($id_provee)
	{
		$this->db->select_sum('Debe');
		$this->db->from('num_asi_deta');
		$this->db->where('proveedores_id', $id_provee);
		$this->db->where('estado_registro', '1');

		$query = $this->db->get();

		if ($query->num_rows() > 0) {
			$row = $query->row();
			return floatval($row->Debe);
		} else {
			return 0;
		}
	}


	public function getMontoPagadoAnterior($proveedor_id)
	{
		$this->db->select_sum('MontoPago');
		$this->db->where('proveedores_id', $proveedor_id);
		$query = $this->db->get('num_asi_deta');

		if ($query->num_rows() > 0) {
			$result = $query->row();
			return $result->suma_acumulativa;
		} else {
			return 0; // Retorna 0 si no hay registros anteriores para ese proveedor
		}
	}

	public function getSumaAcumulativa($proveedor_id, $num_asi)
	{
		// Obtén el Debe de la vista diario de obligaciones para el proveedor y el asiento específico
		$this->db->select('SUM(Debe) as Debe');
		$this->db->where('proveedores_id', $proveedor_id);
		$this->db->where('Num_Asi_IDNum_Asi', $num_asi);
		$query = $this->db->get('num_asi_deta');

		if ($query->num_rows() > 0) {
			$result = $query->row();
			$debe = $result->Debe;

			// Actualiza el campo MontoPagado en la tabla num_asi
			$this->db->where('id_provee', $proveedor_id);
			$this->db->where('IDNum_Asi', $num_asi);
			$this->db->set('MontoPagado', 'MontoPagado' . $debe, false);
			$this->db->update('num_asi');

			// Obtiene el nuevo valor de MontoPagado después de la actualización
			$this->db->select('MontoPagado');
			$this->db->where('id_provee', $proveedor_id);
			$this->db->where('IDNum_Asi', $num_asi);
			$query = $this->db->get('num_asi');

			if ($query->num_rows() > 0) {
				$result = $query->row();
				$nuevoMontopagado = $result->MontoPagado;

				// Verifica si se igualó o superó al MontoTotal
				$this->db->select('MontoTotal');
				$this->db->where('id_provee', $proveedor_id);
				$this->db->where('IDNum_Asi', $num_asi);
				$query = $this->db->get('num_asi');

				if ($query->num_rows() > 0) {
					$result = $query->row();
					$montototal = $result->MontoTotal;

					if ($nuevoMontopagado >= $montototal) {
						// Cambia el estado al valor 3 (liquidado)
						$this->db->where('id_provee', $proveedor_id);
						$this->db->where('IDNum_Asi', $num_asi);
						$this->db->update('num_asi', ['estado' => 3]);
					}
				}

				return $nuevoMontopagado;
			}
		}

		return 0;
	}



	public function updateMontoPagado($num_asi_id, $nuevo_monto_pagado)
	{
		$this->db->where('IDNum_Asi', $num_asi_id);
		$this->db->update('num_asi', ['MontoPagado' => $nuevo_monto_pagado]);
	}

	public function actualizarMontoTotal($idNumAsi, $montoTotal)
	{
		$this->db->where('IDNum_Asi', $idNumAsi);
		$this->db->update('num_asi', array('MontoTotal' => $montoTotal));
	}


	public function obtener_usuario_por_id($id)
	{

		$query = $this->db->get_where('usuarios', array('id_user' => $id));
		return $query->row();
	}
}