<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Diario_obli_model extends CI_Model {
	//acá empieza el javorai de isaac
	//num asi primero
	public function __construct() {
        $this->load->database();
    }
	public function obtener_asientos() {
        return $this->db->get('num_asi')->result_array();
    }
	public function obtener_asiento_por_id($id) {
        $this->db->where('IDNum_Asi', $id);
        return $this->db->get('num_asi')->row_array();
    }
    public function insertar_asiento($data) {
        return $this->db->insert('num_asi', $data);
    }
	public function actualizar_asiento($id, $data) {
        $this->db->where('IDNum_Asi', $id);
        return $this->db->update('num_asi', $data);
    }
	public function eliminar_asiento($id) {
        $this->db->where('IDNum_Asi', $id);
        return $this->db->delete('num_asi');
    }
	public function save_num_asi($data){
		return $this->db->insert("num_asi",$data);
	}



	// num asi deta segundo
	public function obtener_detalles_por_asiento($idAsiento) {
        $this->db->where('Num_Asi_IDNum_Asi', $idAsiento);
        return $this->db->get('num_asi_deta')->result_array();
    }

    public function obtener_detalle_por_id($idDetalle) {
        $this->db->where('IDNum_Asi_Deta', $idDetalle);
        return $this->db->get('num_asi_deta')->row_array();
    }

    public function insertar_detalle($data) {
        return $this->db->insert('num_asi_deta', $data);
    }

    public function actualizar_detalle($idDetalle, $data) {
        $this->db->where('IDNum_Asi_Deta', $idDetalle);
        return $this->db->update('num_asi_deta', $data);
    }

    public function eliminar_detalle($idDetalle) {
        $this->db->where('IDNum_Asi_Deta', $idDetalle);
        return $this->db->delete('num_asi_deta');
    }









//desde acá es código de palo

public function getProveedorIdByRuc($ruc) {
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

public function getUsuarioId($nombre){
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


	public function getDiarios(){
		$this->db->where("estado","1");
		$resultados = $this->db->get("proveedores");
		return $resultados->result();
	}

	public function saveDebe($data){
		return $this->db->insert("num_asi_deta",$data);
	}

	public function saveHaber($data){
		return $this->db->insert("num_asi_deta",$data);
	}

	
	public function getDiario($id){
		$this->db->where("id",$id);
		$resultado = $this->db->get("proveedores");
		return $resultado->row();

	}

	public function update($id,$data){
		$this->db->where("id",$id);
		return $this->db->update("proveedores",$data);
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

   
    public function getCuentasContables(){
        $this->db->select('cuentacontable.*');
		$this->db->from('cuentacontable');
		$this->db->join('uni_respon_usu', 'cuentacontable.id_uni_respon_usu = uni_respon_usu.id_uni_respon_usu');
		$this->db->where('cuentacontable.estado', '1');
		$this->db->where('uni_respon_usu.id_uni_respon_usu', $id_uni_respon_usu);
        $resultados = $this->db->get();
        return $resultados->result();
    }


	

	//guardar asientos
	public function guardar_asiento($data, $dataDetaDebe, $dataDetaHaber) {
		$this->db->trans_start();  // Iniciar transacción
	
		$this->db->insert('num_asi', $data);  
		$this->db->insert('num_asi_deta', $dataDetaDebe); 
		$this->db->insert('num_asi_deta', $dataDetaHaber);  
	
		$this->db->trans_complete();  // Completar transacción
	
		return $this->db->trans_status();  // Devuelve TRUE si todo está OK o FALSE si hay algún fallo
	}
	
	public function getCuentaContable() {
		$query = $this->db->get("cuentacontable");
		return $query->result();
	}

	public function getDiarios_obli() {
		$this->db->select('proveedores.id as id_provee, programa.nombre as nombre_programa, fuente_de_financiamiento.nombre as nombre_fuente, origen_de_financiamiento.nombre as nombre_origen, cuentacontable.CodigoCuentaContable as Codigocuentacontable ,cuentacontable.DescripcionCuentaContable as Desccuentacontable ,');		
		$this->db->from('num_asi_deta');
		$this->db->join('programa', 'num_asi_deta.id_pro = programa.id_pro', 'left');
		$this->db->join('fuente_de_financiamiento', 'num_asi_deta.id_ff = fuente_de_financiamiento.id_ff');
		$this->db->join('origen_de_financiamiento', 'num_asi_deta.id_of = origen_de_financiamiento.id_of');
		$this->db->join('cuentacontable', 'num_asi_deta.IDCuentaContable = cuentacontable.IDCuentaContable');
		$this->db->join('proveedores', 'num_asi_deta.proveedores_id = proveedores.id');
	
		$query = $this->db->get();
	}	



	public function getMontoPagadoAnterior($proveedor_id) {
		$this->db->select_sum('MontoPago', 'suma_acumulativa');
		$this->db->where('proveedores_id', $proveedor_id);
		$query = $this->db->get('num_asi_deta');
	
		if ($query->num_rows() > 0) {
			$result = $query->row();
			return $result->suma_acumulativa;
		} else {
			return 0; // Retorna 0 si no hay registros anteriores para ese proveedor
		}
	}


	public function getSumaAcumulativa($proveedor_id) {
		$this->db->select_sum('Debe');
		$this->db->where('proveedores_id', $proveedor_id);
		$query = $this->db->get('num_asi_deta');
	
		if ($query->num_rows() > 0) {
			$result = $query->row();
			return $result->Debe;

		}
	
		return 0;
	}
	
	public function updateMontoPagado($id_num_asi, $nuevo_monto_pagado) {
		$this->db->where('IDNum_Asi', $id_num_asi);
		$this->db->update('num_asi', array('MontoPagado' => $nuevo_monto_pagado));
	}
	
	public function actualizarMontoTotal($idNumAsi, $montoTotal)
{
    $this->db->where('IDNum_Asi', $idNumAsi);
    $this->db->update('num_asi', array('MontoTotal' => $montoTotal));
}


	public function obtener_usuario_por_id($id) {
        
		$query = $this->db->get_where('usuarios', array('id_user' => $id));
		return $query->row();
   }

//	public function getDiarios_obli() {
//		$this->db->select('programa.nombre as nombre_programa, fuente_de_financiamiento.nombre as nombre_fuente, origen_de_financiamiento.nombre as nombre_origen');
//		$this->db->from('num_asi_deta');
//		$this->db->join('programa', 'num_asi_deta.id_pro = programa.id_pro', 'left');
//		$this->db->join('fuente_de_financiamiento', 'num_asi_deta.id_ff = fuente_de_financiamiento.id_ff', 'left');
//		$this->db->join('origen_de_financiamiento', 'num_asi_deta.id_of = origen_de_financiamiento.id_of', 'left');
//	
//		
//		$query = $this->db->get();
//		return $query->result();
//	}
	
}
