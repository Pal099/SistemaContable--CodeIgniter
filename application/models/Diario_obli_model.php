<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Diario_obli_model extends CI_Model
{
	//acá empieza el javorai de isaac
	//num asi primero
	public function __construct()
	{
		$this->load->database();
		$this->load->model("Usuarios_model");
	}
	public function obtener_asientos()
	{
		return $this->db->get('num_asi')->result_array();
		//var_dump($result); // Solo para depuración
		return $result;

	}

	public function getMaxNumAsiAndOp($id_uni_respon_usu)
	{
		// Obtener el último valor de num_asi para una unidad específica
		$this->db->select('MAX(num_asi) as ultimo_numero, MAX(op) as op_ultimo');
		$this->db->from('num_asi'); // Tu tabla
		$this->db->join('uni_respon_usu', 'num_asi.id_uni_respon_usu = uni_respon_usu.id_uni_respon_usu');
		$this->db->where('num_asi.id_uni_respon_usu', $id_uni_respon_usu); // Ser explícito con la tabla en el WHERE
		$query = $this->db->get();

		if ($query->num_rows() > 0) {
			return $query->row(); // Retorna el resultado como objeto
		} else {
			return null; // Si no hay registros, retorna null
		}
	}



	public function GETasientos($id_uni_respon_usu)
	{
		$this->db->select('na.IDNum_Asi, na.FechaEmision, na.num_asi, na.op, na.str, na.estado_registro, p.razon_social, na.MontoTotal');
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
		$this->db->select('na.IDNum_Asi, na.FechaEmision, na.num_asi, na.op, na.str, na.estado_registro, p.razon_social, na.MontoTotal');
		$this->db->from('num_asi na');
		$this->db->join('uni_respon_usu uru', 'na.id_uni_respon_usu = uru.id_uni_respon_usu');
		$this->db->join('proveedores p', 'na.id_provee = p.id'); // Corregido para unir con la tabla de proveedores correctamente
		$this->db->where('na.estado_registro', '1');
		$this->db->where('na.id_form', '3');
		$this->db->where('uru.id_uni_respon_usu', $id_uni_respon_usu);

		$resultados = $this->db->get();
		return $resultados->result();
	}

	public function getSTRaumentado($id_user)
	{
		// Acá obtenemos el id de la unidad academica perteneciente al usuario
		$id_unidad_user = $this->Usuarios_model->getUserUnidadAcademica($id_user);

		// Obtenemos el último valor de 'str' para esta unidad académica
		$this->db->select('num_asi.str');
		$this->db->from('num_asi');
		$this->db->join('usuarios', 'num_asi.id_usuario_numasi = usuarios.id_user');
		$this->db->where('usuarios.id_unidad', $id_unidad_user);
		$this->db->order_by('num_asi.str', 'desc');
		$this->db->limit(1);
		$last_str = $this->db->get()->row()->str;

		// Si no hay registros previos para esta unidad académica, inicializamos el str en 1
		if ($last_str == NULL) {
			$last_str = 1;
		} else {
			// Si ya hay registros, incrementamos el str en 1
			$last_str++;
		}

		return $last_str;
	}

	public function ultimoSTR($id_user)
	{
		// Acá obtenemos el id de la unidad académica perteneciente al usuario
		$id_unidad_user = $this->Usuarios_model->getUserUnidadAcademica($id_user);

		// Obtenemos el último valor de 'str' para esta unidad académica
		$this->db->select('num_asi.str');
		$this->db->from('num_asi');
		$this->db->join('usuarios', 'num_asi.id_usuario_numasi = usuarios.id_user');
		$this->db->where('usuarios.id_unidad', $id_unidad_user);
		$this->db->order_by('num_asi.str', 'desc');
		$this->db->limit(1);
		$query = $this->db->get();

		// Verificamos si hay resultados
		if ($query->num_rows() > 0) {
			// Extraemos el valor de 'str' del primer resultado
			$row = $query->row();
			$last_str = $row->str;
		} else {
			// Si no hay resultados, asignamos un valor predeterminado
			$last_str = 0; // O cualquier otro valor que desees
		}

		// Retornamos el valor de 'str'
		return $last_str;
	}

	public function getNiveles()
	{
		$this->db->select('id_nivel, nombre_nivel');
		$this->db->from('nivel');
		$query = $this->db->get();
		return $query->result();
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
		$this->db->where("IDNum_asi", $id);
		return $this->db->update("num_asi", $data);
	}

	public function getProgramGastos($id_uni_respon_usu) {
		$this->db->select('programa.*');
		$this->db->from('programa');
		$this->db->join('uni_respon_usu', 'programa.id_uni_respon_usu = uni_respon_usu.id_uni_respon_usu');
		$this->db->where('programa.estado', '1');
		$this->db->where('uni_respon_usu.id_uni_respon_usu', $id_uni_respon_usu);
		
		$resultados = $this->db->get();
		return $resultados->result();
	}

	public function getFuentes($id_uni_respon_usu) {
		$this->db->select('fuente_de_financiamiento.*');
		$this->db->from('fuente_de_financiamiento');
		$this->db->join('uni_respon_usu', 'fuente_de_financiamiento.id_uni_respon_usu = uni_respon_usu.id_uni_respon_usu');
		$this->db->where('fuente_de_financiamiento.estado', '1');
		$this->db->where('uni_respon_usu.id_uni_respon_usu', $id_uni_respon_usu);
		$resultados = $this->db->get();
		return $resultados->result();
	}

	public function getOrigenes($id_uni_respon_usu) {
		$this->db->select('origen_de_financiamiento.*');
		$this->db->from('origen_de_financiamiento');
		$this->db->join('uni_respon_usu', 'origen_de_financiamiento.id_uni_respon_usu = uni_respon_usu.id_uni_respon_usu');
		$this->db->where('origen_de_financiamiento.estado', '1');
		$this->db->where('uni_respon_usu.id_uni_respon_usu', $id_uni_respon_usu);
		
		$resultados = $this->db->get();
		return $resultados->result();
	}




	public function getCuentasContables()
	{
		$this->db->select('cuentacontable.*');
		$this->db->from('cuentacontable');
		$this->db->join('uni_respon_usu', 'cuentacontable.id_uni_respon_usu = uni_respon_usu.id_uni_respon_usu');
		$this->db->where('cuentacontable.estado', '1');
		$this->db->where('uni_respon_usu.id_uni_respon_usu', $id_uni_respon_usu);
		$resultados = $this->db->get();
		return $resultados->result();
	}



	public function getC_C()
	{
		$this->db->select('Codigo_CC, Descripcion_CC');
		$this->db->from('cuentacontable');
		$this->db->where('imputable', 2);
		$resultados = $this->db->get();
		echo json_encode($resultados->result());
	}






	//guardar asientos
	public function guardar_asiento($data, $dataDetaDebe, $dataDetaHaber)
	{
		$this->db->trans_start();  // Iniciar transacción

		// Insertar en la tabla num_asi
		$this->db->insert('num_asi', $data);
		$num_asi_id = $this->db->insert_id();  // Obtener el ID del último registro insertado

		// Asegurarse de que $dataDetaDebe y $dataDetaHaber contengan el ID de num_asi
		$dataDetaDebe['Num_Asi_IDNum_Asi'] = $num_asi_id;
		$dataDetaHaber['Num_Asi_IDNum_Asi'] = $num_asi_id;

		// Insertar en la tabla num_asi_deta
		$this->db->insert('num_asi_deta', $dataDetaDebe);
		$this->db->insert('num_asi_deta', $dataDetaHaber);

		$this->db->trans_complete();  // Completar transacción

		return $this->db->trans_status();  // Devuelve TRUE si todo está OK o FALSE si hay algún fallo
	}

	//Para el Selectcc, es decir, el primer modal del DEBE
	public function getCuentaContable()
	{
		$this->db->select('cuentacontable.IDCuentaContable, cuentacontable.Codigo_CC, cuentacontable.Descripcion_CC');
		$query = $this->db->get("cuentacontable");
		return $query->result();
	}
	public function getCuentaContable2()
	{
		$this->db->select("
			pre.TotalPresupuestado,
			ff.nombre as nombre_ff,
			of.nombre as nombre_of,
			of.codigo as codigo_of,
			ff.codigo as codigo_ff,
			cuentacontable.Codigo_CC,
			cuentacontable.Descripcion_CC,
			pre.IDCuentaContable,
			GROUP_CONCAT(DISTINCT pm.mes ORDER BY FIELD(pm.mes, 
				'Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 
				'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'
			) SEPARATOR ', ') AS meses_presupuesto
		"); // Obtiene los meses desde presupuesto_mensual

		$this->db->like('Codigo_CC', '4', 'after'); // Filtrar donde el código comience con "4"
		$this->db->join('presupuestos pre', 'pre.idcuentacontable = cuentacontable.IDCuentaContable');
		$this->db->join('fuente_de_financiamiento ff', 'ff.id_ff = pre.fuente_de_financiamiento_id_ff');
		$this->db->join('origen_de_financiamiento of', 'of.id_of = pre.origen_de_financiamiento_id_of');
		$this->db->join('presupuesto_mensual pm', 'pm.id_presupuesto = pre.ID_Presupuesto', 'left'); // Join con presupuesto_mensual

		$this->db->group_by('pre.ID_Presupuesto'); // Agrupar por presupuesto
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
		$this->db->update('num_asi', ['MontoPagado' => $nuevoMontoPagado]);
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