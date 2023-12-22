<?php

class Balance_Gral_model extends CI_Model
{
    public function obtenerDatosCuentas() {
        $query = $this->db->get('cuentacontable');
        return $query->result();
    }

    public function obtenerSumasDebeHaber($idCuentaContable) {
        $this->db->select_sum('Debe', 'TotalDebe');
        $this->db->select_sum('Haber', 'TotalHaber');
        $this->db->where('IDCuentaContable', $idCuentaContable);
        $query = $this->db->get('num_asi_deta');
        return $query->row();
    }
    public function obtenerCuentasHijas($idCuentaPadre) {
        $this->db->where('padre_id', $idCuentaPadre);
        $query = $this->db->get('cuentacontable');
        return $query->result();
    }
}

?>