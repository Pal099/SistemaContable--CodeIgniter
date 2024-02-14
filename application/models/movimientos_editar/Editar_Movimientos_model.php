<?php

class Editar_Movimientos_model extends CI_Model
{
    public function __construct() {
        $this->load->database();
    }

    //Funcion para obtener los asientos para su futura edicion
	public function GetAsientoEditar($IDNum_Asi) {
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
	public function actualizar_num_asi($id, $data) {
        $this->db->where('IDNum_Asi', $id);
        return $this->db->update('num_asi', $data);
    }

	public function update_num_asi_deta($IDNum_Asi_Deta, $data){
		$this->db->where('IDNum_Asi_Deta', $IDNum_Asi_Deta);
        return $this->db->update('num_asi_deta', $data);
	}

	public function update_num_asi_deta_fila_nueva($data) {
        return $this->db->insert('num_asi_deta', $data);
    }

	public function borrado_logico($IDNum_Asi_Deta){
		$data = array('estado_registro' => 0);
		$this->db->where('IDNum_Asi_Deta', $IDNum_Asi_Deta);
		return $this->db->update('num_asi_deta', $data);
	}

	//----------Acá terminan las funciones nuevas del editar----------
}

?>