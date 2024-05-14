<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pedido_Material_model extends CI_Model {

	public function getPedidosMateriales($id_uni_respon_usu) {
		$this->db->select('pedido_material.*');
		$this->db->from('pedido_material');
		$this->db->join('uni_respon_usu', 'pedido_material.id_uni_respon_usu = uni_respon_usu.id_uni_respon_usu');
		$this->db->where('pedido_material.estado', '1');
		$this->db->where('uni_respon_usu.id_uni_respon_usu', $id_uni_respon_usu);
		
		$resultados = $this->db->get();
		return $resultados->result();
	}
	

	
	public function save($data) {
	
		return $this->db->insert('pedido_material', $data);
	}
	
	
    
	public function getPedidoMaterial($id){
		$this->db->where("IDPedidoMaterial",$id);
		$resultado = $this->db->get("pedido_material");
		return $resultado->row();

	}
 
	public function update($id,$data){
		$this->db->where("IDPedidoMaterial",$id);
		return $this->db->update("pedido_material",$data);
	}
	public function getPedidosMaterialesFiltrados($actividad, $pedido, $mes, $anio)
{
    $this->db->select('*');
    $this->db->from('pedido_material');

    if (!empty($actividad)) {
        $this->db->where('id_unidad', $actividad);
    }
    if (!empty($fuente)) {
        $this->db->where('idpedido', $pedido);
    }

    if (!empty($mes)) {
        $this->db->where('MONTH(fecha)', $mes);
    }
	if (!empty($anio)) {
        $this->db->where('YEAR(fecha)', $anio);
    }

    $query = $this->db->get();
    return $query->result();
}
public function savePedidoYItems($id_pedido, $items) {
    // Iniciar una transacción
    $this->db->trans_start();

    // Insertar datos del pedido
    foreach ($items as $item) {
        $data_pedido = array(
            'IDPedidoMaterial' => $id_pedido,
            'id_unidad' => $item['id_unidad'],
            'fecha' => $item['fecha'],
            'rubro' => $item['rubro'],
            'descripcion' => $item['descripcion'],
            'preciounit' => $item['preciounit'],
            'cantidad' => $item['cantidad'],
            'iva' => $item['iva'],
            'porcentaje_iva' => $item['porcentaje_iva'],
            'exenta' => $item['exenta'],
            'gravada' => $item['gravada'],
            'id_uni_respon_usu' => $item['id_uni_respon_usu'],
            'estado' => 1 // Suponiendo que 1 representa el estado activo
        );
        $this->db->insert('pedido_material', $data_pedido);
    }

    // Finalizar la transacción
    $this->db->trans_complete();

    // Verificar si la transacción fue exitosa
    if ($this->db->trans_status() === FALSE) {
        // Si la transacción falla, revertir y devolver falso
        $this->db->trans_rollback();
        return FALSE;
    } else {
        // Si la transacción tiene éxito, confirmar y devolver verdadero
        $this->db->trans_commit();
        return TRUE;
    }
}

}
