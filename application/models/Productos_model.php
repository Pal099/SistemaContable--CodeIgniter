<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Productos_model extends CI_Model {
	
	//Este es el código original en Productos_model, dejé comentado por si

	/*public function getProductos(){
		$this->db->where("estado","1");
		$resultados = $this->db->get("productos");
		return $resultados->result();
	}*/

	//Este es el código del join con las columnas id de las tablas productos/proveedor

	public function getProductos() {
		$this->db->select('productos.*, proveedores.propietario as prop, categorias.nombre as cate'); //Muestra todos los productos e id del proov. asociados
		$this->db->from('productos'); //tabla productos 
		$this->db->join('proveedores', 'productos.id_proveedor = proveedores.id', 'inner'); //Hace el join en donde solo hayan coincidencias
		$this->db->join('categorias','productos.id_categoria = categorias.id');
		$this->db->where('productos.estado', '1'); //Donde el estado esté en 1 :V
		$resultados = $this->db->get(); //Obtiene las informaciones y guarda en la variable resultado
		return $resultados->result(); //Retorna los resultados
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