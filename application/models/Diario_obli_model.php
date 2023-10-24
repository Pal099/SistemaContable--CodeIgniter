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
	public function getDiarios(){
		$this->db->where("estado","1");
		$resultados = $this->db->get("proveedores");
		return $resultados->result();
	}

	public function save($data){
		return $this->db->insert("proveedores",$data);
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
		print_r($data['programa']); exit; // Añadir esto para ver qué datos retorna

	}
	
	public function getOrigenesFinanciamiento() {
		$query = $this->db->get("origen_de_financiamiento");
		return $query->result();
	}
<<<<<<< Updated upstream
	


	public function getDiarios_obli() {
		$this->db->select('programa.nombre as nombre_programa, fuente_de_financiamiento.nombre as nombre_fuente, origen_de_financiamiento.nombre as nombre_origen');
		$this->db->from('num_asi_deta');
		$this->db->join('programa', 'num_asi_deta.id_pro = programa.id_pro', 'left');
		$this->db->join('fuente_de_financiamiento', 'num_asi_deta.id_ff = fuente_de_financiamiento.id_ff', 'left');
		$this->db->join('origen_de_financiamiento', 'num_asi_deta.id_of = origen_de_financiamiento.id_of', 'left');
	
		
		$query = $this->db->get();
=======
	public function getCuentaContable() {
		$query = $this->db->get("cuentacontable");
>>>>>>> Stashed changes
		return $query->result();
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
