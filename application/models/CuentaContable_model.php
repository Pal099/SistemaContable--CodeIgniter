<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CuentaContable_model extends CI_Model {
//Aquí cargamos en la tabla"cuentacontable" los arrays

    public function getCuentasContables(){
        $this->db->where("estado", 1);
        $resultados = $this->db->get("cuentacontable");
        return $resultados->result();
    }

    public function save($data){
        return $this->db->insert("cuentacontable", $data);
    }

    public function getCuentaContable($id){
        $this->db->where("IDCuentaContable", $id);
        $resultado = $this->db->get("cuentacontable");
        return $resultado->row();
    }

    public function update($id, $data){
        $this->db->where("IDCuentaContable", $id);
        return $this->db->update("cuentacontable", $data);
    }

    // Puedes agregar más métodos aquí según lo necesites.
}
