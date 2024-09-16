<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Niveles_model extends CI_Model {

    public function getNiveles() {
        $this->db->select('*');
        $this->db->from('nivel');
        $this->db->where('estado', '1');
        $resultados = $this->db->get();
        return $resultados->result();
    }

    public function save($data) {
        return $this->db->insert('nivel', $data);
    }

    public function getNivel($id){
        $this->db->where("id_nivel",$id);
        $resultado = $this->db->get("nivel");
        return $resultado->row();
    }

    public function update($id, $data){
        $this->db->where("id_nivel",$id);
        return $this->db->update("nivel",$data);
    }
}
