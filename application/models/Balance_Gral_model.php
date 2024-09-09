<?php

class Balance_Gral_model extends CI_Model
{
    public function obtenerDatosCuentas()
    {
        $this->db->select('IDCuentaContable, Codigo_CC, Descripcion_CC'); 
        $this->db->where("(LEFT(Codigo_CC, 1) = '2' OR LEFT(Codigo_CC, 1) = '4' OR LEFT(Codigo_CC, 1) = '8')");
        $query = $this->db->get('cuentacontable');
        return $query->result();
    }

    public function obtenerDatosCuentasSyS()
    {
        $this->db->select('IDCuentaContable, Codigo_CC, Descripcion_CC'); 
        $query = $this->db->get('cuentacontable');
        return $query->result();
    }

    public function obtenerDatosCuentasRS()
    {
        $this->db->select('IDCuentaContable, Codigo_CC, Descripcion_CC'); 
        $this->db->where("(LEFT(Codigo_CC, 1) = '3' OR LEFT(Codigo_CC, 1) = '5')");
        $query = $this->db->get('cuentacontable');
        return $query->result();
    }
    
        public function obtenerDatosCuentass() {
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

    public function obtenerCuentasHijas($idCuentaPadre)
    {
        $this->db->where('padre_id', $idCuentaPadre);
        $query = $this->db->get('cuentacontable');
        return $query->result();
    }
    public function obtenerDatosCuentas345() {
        $this->db->select('*');
        $this->db->from('cuentacontable');
        $this->db->like('Codigo_CC', '3', 'after'); // Filtrar cuentas que comienzan con 3
        $this->db->or_like('Codigo_CC', '5', 'after'); // Filtrar cuentas que comienzan con 5

        $query = $this->db->get();
        return $query->result();
    }
}

?>