<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Productos_model extends CI_Model {

	public function getProductos(){
		$this->db->select("p.*, c.nombre as categoria, pr.propietario as pro_nombre");
		$this->db->from("productos p");
		$this->db->join("categorias c","p.id_categoria = c.id");
		$this->db->join("proveedores pr","p.id_proveedor = pr.id");
		$this->db->where("p.estado","1");
		$resultados = $this->db->get();
		return $resultados->result();
	}

	public function save($data){
		return $this->db->insert("productos",$data);
	}
	public function getProducto($id){
		$this->db->where("id",$id);
		$resultado = $this->db->get("productos");
		return $resultado->row();

	}

	public function update($id,$data){
		$this->db->where("id",$id);
		return $this->db->update("productos",$data);
	}
}
