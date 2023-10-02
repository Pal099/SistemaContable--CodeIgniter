<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Proveedores_model extends CI_Model {

	public function getProveedores(){
		$this->db->where("estado","1");
		$resultados = $this->db->get("proveedores");
		return $resultados->result();
	}

	public function getProveedoresByUser($id_usuario) {
		// Consulta SQL para obtener los proveedores relacionados con un usuario específico
		$this->db->select('*');
		$this->db->from('proveedores');
		$this->db->where('id_user', $id_usuario);
		$this->db->where('estado', '1'); // Si tienes una columna 'estado' para marcar proveedores activos/inactivos
	
		$query = $this->db->get();
	
		// Devolver el resultado como arreglo de objetos
		return $query->result();
	}
	

	public function save($data, $id_usuario) {
		$data['id_user'] = $id_usuario;
		return $this->db->insert('proveedores', $data);
	}
	
	public function getProveedor($id){
		$this->db->where("id",$id);
		$resultado = $this->db->get("proveedores");
		return $resultado->row();

	}
 // Definir una relación con la tabla usuarios
 public function usuario() {
	return $this->belongs_to('Usuarios_model', 'id_user');
}
	public function update($id,$data){
		$this->db->where("id",$id);
		return $this->db->update("proveedores",$data);
	}
}
