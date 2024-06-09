<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pedido_Material_model extends CI_Model
{

    public function getPedidosMateriales($id_uni_respon_usu)
    {
        $this->db->select('pedido_material.*');
        $this->db->from('pedido_material');
        $this->db->join('uni_respon_usu', 'pedido_material.id_uni_respon_usu = uni_respon_usu.id_uni_respon_usu');
        $this->db->where('pedido_material.estado', '1');
        $this->db->where('uni_respon_usu.id_uni_respon_usu', $id_uni_respon_usu);

        $resultados = $this->db->get();
        return $resultados->result();
    }



    public function savePedido($data)
    {
        return $this->db->insert('pedido_material', $data);
    }



    public function getPedidoMaterial($id)
    {
        $this->db->where("IDPedidoMaterial", $id);
        $resultado = $this->db->get("pedido_material");
        return $resultado->row();

    }

    public function getPedidoMaterialp($id)
    {
        $this->db->where("idpedido", $id);
        $resultado = $this->db->get("pedido_material");
        return $resultado->row();

    }

    public function update($id, $data)
    {
        $this->db->where("IDPedidoMaterial", $id);
        return $this->db->update("pedido_material", $data);
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
}
