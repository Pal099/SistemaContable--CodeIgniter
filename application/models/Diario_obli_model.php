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



	public function getDiarios(){
		$this->db->where("estado","1");
		$resultados = $this->db->get("proveedores");
		return $resultados->result();
	}

	public function save($data){
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

	public function getProgramas() {
		$query = $this->db->get("programa");
		return $query->result();
	}
	
	public function getFuentesFinanciamiento() {
		$query = $this->db->get("fuente_de_financiamiento");
		return $query->result();
	}
	
	public function getOrigenesFinanciamiento() {
		$query = $this->db->get("origen_de_financiamiento");
		return $query->result();
	}

    public function getCuentasContables(){
        $this->db->where("estado", "1");
        $resultados = $this->db->get("cuentacontable");
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
