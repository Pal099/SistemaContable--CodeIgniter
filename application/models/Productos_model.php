<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Productos_model extends CI_Model {
	
	public function getProductos() {
		$this->db->select('productos.*, proveedores.propietario as prop, categorias.nombre as cate');
		$this->db->from('productos');
		$this->db->join('proveedores', 'productos.id_proveedor = proveedores.id', 'inner');
		$this->db->join('categorias', 'productos.id_categoria = categorias.id');
		$this->db->where('productos.estado', '1');
		$resultados = $this->db->get();
		return $resultados->result();
	}

	public function save($data){
		return $this->db->insert("productos", $data);
	}

	public function getProducto($id){
		$this->db->where("id", $id);
		$resultado = $this->db->get("productos");
		return $resultado->row();
	}

	public function update($id, $data){
		$this->db->where("id", $id);
		return $this->db->update("productos", $data);
	}

	//Acá hago los joins correspondientes para traer los productos y proveedores de acuerdo a su categoria.
	public function filtrar_productos_por_categoria($categoria) {
		$this->db->select('productos.*, proveedores.propietario as prop, categorias.nombre as cate');
		$this->db->from('productos');
		$this->db->join('proveedores', 'productos.id_proveedor = proveedores.id', 'inner');
		$this->db->join('categorias', 'productos.id_categoria = categorias.id');
		$this->db->where('productos.estado', '1');
		$this->db->where('categorias.id', $categoria);
		$resultados = $this->db->get();
		return $resultados->result();
	}
	//función para traer las categorias almacenadas en la base de datos. 
	public function getCategorias() {
		$this->db->select('id, nombre');
		$this->db->from('categorias');
		return $this->db->get()->result();
	}

	//Acá hago los joins correspondientes para traer los productos y proveedores de acuerdo a su categoria.
	public function filtrar_productos_por_proveedor($proveedor) {
		$this->db->select('productos.*, proveedores.propietario as prop, categorias.nombre as cate');
		$this->db->from('productos');
		$this->db->join('proveedores', 'productos.id_proveedor = proveedores.id', 'inner');
		$this->db->join('categorias', 'productos.id_categoria = categorias.id');
		$this->db->where('productos.estado', '1');
		$this->db->where('proveedores.estado', '1');
		$this->db->where('proveedores.id', $proveedor);
		$resultados = $this->db->get();
		return $resultados->result();
	}
	//función para traer las categorias almacenadas en la base de datos. 
	public function getProveedores() {
		$this->db->select('id, ruc, razon_social, propietario, direccion, telefono, email, observacion');
		$this->db->from('proveedores');
		return $this->db->get()->result();
	}

    public function calcularTotalVentas() {
		$this->db->select_sum('precio_venta');
		$query = $this->db->get('productos');
		$result = $query->row();
		$totalVentas = $result->precio_venta;
	
		return $totalVentas;
	}
	

	
}
