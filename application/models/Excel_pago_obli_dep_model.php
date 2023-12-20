<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Excel_pago_obli_dep_model extends CI_Model
{
    public function __construct()
    {
        $this->load->database();
    }
    public function obtenerDatos($fechaInicio, $fechaFin)
    {
        $this->db->select('num_asi.FechaEmision, num_asi.num_asi, num_asi.op, proveedores.razon_social, num_asi_deta.comprobante, SUM(num_asi_deta.Debe) as totalDebe, SUM(num_asi_deta.Haber) as totalHaber, cuentacontable.Codigo_CC, cuentacontable.Descripcion_CC, SUM(num_asi_deta.Debe) as balance, programa.codigo as num_programa, origen_de_financiamiento.nombre as of, fuente_de_financiamiento.nombre as ff, num_asi_deta.numero as num, programa.nombre');
        $this->db->from('num_asi');
        $this->db->join('num_asi_deta', 'num_asi.IDNum_Asi = num_asi_deta.Num_Asi_IDNum_Asi', 'left');
        $this->db->join('proveedores', 'num_asi.id_provee = proveedores.id', 'left');
        $this->db->join('programa', 'num_asi_deta.id_pro = programa.id_pro', 'left');
        $this->db->join('origen_de_financiamiento', 'num_asi_deta.id_of = origen_de_financiamiento.id_of', 'left');
        $this->db->join('fuente_de_financiamiento', 'num_asi_deta.id_ff = fuente_de_financiamiento.id_ff', 'left');
        $this->db->join('cuentacontable', 'num_asi_deta.IDCuentaContable = cuentacontable.IDCuentaContable', 'left');
        $this->db->where("(`num_asi`.`FechaEmision` BETWEEN '$fechaInicio' AND '$fechaFin') OR `num_asi`.`FechaEmision` IS NULL", NULL, FALSE);
        //$this->db->where('num_asi.FechaEmision >=', $fechaInicio);
        //$this->db->where('num_asi.FechaEmision <=', $fechaFin);
        $this->db->group_by('num_asi_deta.numero, cuentacontable.IDCuentaContable');

        $query = $this->db->get();
        return $query->result();
    }

    public function obtenerResumenPorMeses($mes=null) {
        $this->db->select('MONTH(FechaEmision) as mes, IDCuentaContable, SUM(Debe) as totalDebe, SUM(Haber) as totalHaber');
        $this->db->from('num_asi');
        $this->db->join('num_asi_deta', 'num_asi.IDNum_Asi = num_asi_deta.Num_Asi_IDNum_Asi', 'left');
        if ($mes !== null) {
            $this->db->where('MONTH(FechaEmision)', $mes);
        }
       
        $this->db->group_by('mes, IDCuentaContable');
    
        $query = $this->db->get();
        return $query->result();
    }
    
}


