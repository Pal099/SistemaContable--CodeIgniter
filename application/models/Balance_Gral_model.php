<?php
class Balance_Gral_model extends CI_Model
{
    public function obtenerDatosCuentas()
    {
        $this->db->select('c.IDCuentaContable, c.Codigo_CC, c.Descripcion_CC, SUM(nd.Debe) as TotalDebe, SUM(nd.Haber) as TotalHaber');
        $this->db->from('cuentacontable c');
        $this->db->join('num_asi_deta nd', 'c.IDCuentaContable = nd.IDCuentaContable', 'left');
        $this->db->group_by('c.IDCuentaContable, c.Codigo_CC, c.Descripcion_CC');
        $this->db->order_by('c.Codigo_CC');
        return $this->db->get()->result();
    }
}

?>