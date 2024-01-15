<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Registros_financieros_model extends CI_Model {

	//CODIGOS PARA LA TABLA FUENTE DE FINANCIAMIENTO

	public function getFuentes($id_uni_respon_usu) {
		$this->db->select('fuente_de_financiamiento.*');
		$this->db->from('fuente_de_financiamiento');
		$this->db->join('uni_respon_usu', 'fuente_de_financiamiento.id_uni_respon_usu = uni_respon_usu.id_uni_respon_usu');
		$this->db->where('fuente_de_financiamiento.estado', '1');
		$this->db->where('uni_respon_usu.id_uni_respon_usu', $id_uni_respon_usu);
		$resultados = $this->db->get();
		return $resultados->result();
	}

	public function save($data){
		return $this->db->insert('fuente_de_financiamiento', $data);
	}

	public function getFuente($id) {
        $this->db->where("id_ff", $id); // Cambié "codigo" a "id_ff"
        $resultado = $this->db->get("fuente_de_financiamiento");

        // Verificar si se encontró la fuente antes de devolver el resultado
        return $resultado->num_rows() > 0 ? $resultado->row() : null;
    }
	

	public function update($id, $data){
		$this->db->where("id_ff", $id);
		return $this->db->update("fuente_de_financiamiento", $data);
	}
}
