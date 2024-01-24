<?php

class Balance_Gral_model extends CI_Model
{
    public function obtenerDatosCuentas() {
        $this->db->like('Codigo_CC', '2', 'after'); // Solo cuentas que comienzan con 2
        $this->db->or_like('Codigo_CC', '4', 'after'); // Solo cuentas que comienzan con 4
        $query = $this->db->get('cuentacontable');
        return $query->result();
    }

    public function obtenerSumasDebeHaber($idCuentaContable) {
        // Seleccionar las sumas de Debe y Haber
        $this->db->select_sum('Debe', 'TotalDebe');
        $this->db->select_sum('Haber', 'TotalHaber');
    
        // Filtrar por IDCuentaContable
        $this->db->where('IDCuentaContable', $idCuentaContable);
    
        // Realizar la consulta
        $query = $this->db->get('num_asi_deta');
    
        if ($query->num_rows() > 0) {
            $result = $query->row();
    
            // Calcular TotalDeudor y TotalAcreedor
            $result->TotalDeudor = $result->TotalDebe - $result->TotalHaber;
            $result->TotalAcreedor = $result->TotalHaber - $result->TotalDebe;
    
            return $result;
        }
        return null;
    }
    
    public function obtenerCuentasHijas($idCuentaPadre) {
        $this->db->where('padre_id', $idCuentaPadre);
        $query = $this->db->get('cuentacontable');
        return $query->result();
    }
}

?>