<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Proveedores_model extends CI_Model {

	public function getProveedores($id_uni_respon_usu) {
		$this->db->select('proveedores.*');
		$this->db->from('proveedores');
		$this->db->join('uni_respon_usu', 'proveedores.id_uni_respon_usu = uni_respon_usu.id_uni_respon_usu');
		$this->db->where('proveedores.estado', '1');
		$this->db->where('uni_respon_usu.id_uni_respon_usu', $id_uni_respon_usu);
		
		$resultados = $this->db->get();
		return $resultados->result();
	}
	
	public function getRegistrosPorUnidadAcademica($id_uni_academica, $id_user) {
		// Obtener la unidad académica del usuario
		$unidad_academica_usuario = $this->getUnidadAcademicaUsuario($id_user);
	
		if (!$unidad_academica_usuario) {
			// Si no se pudo obtener la unidad académica del usuario, retornar un array vacío o false según sea necesario
			return false;
		}
	
		$this->db->select('proveedores.*');
		$this->db->from('proveedores');
		$this->db->join('unidad_academica', 'proveedores.id_uni_respon_usu = unidad_academica.id_unidad');
		$this->db->join('usuarios', 'usuarios.id_unidad = unidad_academica.id_unidad');
		$this->db->where('proveedores.estado', '1');
		$this->db->where('unidad_academica.id_unidad', $id_uni_academica);
		$this->db->where('usuarios.id_user', $id_user); // Agregar condición para verificar que el usuario tiene acceso a esta unidad académica
	
		$query = $this->db->get();
		
		return $query->result();
	}
	public function getUnidadAcademicaUsuario($id_user) {
		$this->db->select('unidad_academica.*');
		$this->db->from('usuarios');
		$this->db->join('unidad_academica', 'usuarios.id_unidad = unidad_academica.id_unidad');
		$this->db->where('usuarios.id_user', $id_user);
	
		$query = $this->db->get();
	
		if ($query->num_rows() > 0) {
			return $query->row();
		} else {
			return false;
		}
	}
	
	
	
	public function save($data) {
	
		return $this->db->insert('proveedores', $data);
	}
	
	
    
	public function getProveedor($id){
		$this->db->where("id",$id);
		$resultado = $this->db->get("proveedores");
		return $resultado->row();

	}
 
	public function update($id,$data){
		$this->db->where("id",$id);
		return $this->db->update("proveedores",$data);
	}
}