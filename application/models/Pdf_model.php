<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pdf_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function obtenerDatos() {
        $this->db->select('numasi.FechaEmision as fecha,nd.numero, nd.comprobante, nd.Debe, nd.Haber, p.ruc as ruc, p.razon_social as proveedor,p.direccion as direccion,p.telefono as telef, p.email as email, numasi.op as orden_de_pago, cc.Descripcion_CC as Descripcion, nd.detalles as detalle');
        $this->db->from('num_asi_deta nd');
        $this->db->join('proveedores p', 'p.id = nd.proveedores_id', 'left');
        $this->db->join('cuentacontable cc', 'cc.IDCuentaContable = nd.IDCuentaContable');
        $this->db->join('num_asi numasi', 'numasi.IDNum_Asi = nd.Num_Asi_IDNum_Asi', 'left');
        $this->db->order_by('nd.IDNum_Asi_Deta', 'DESC'); // Ordena por el ID de forma descendente
        $this->db->limit(1); // Limita a un solo registro
        $query = $this->db->get();
        $result = $query->result_array(); // Make sure to use result_array() for an array result

        return $result;
        if ($query->num_rows() > 0) {
            return $query->row_array(); // Devuelve un solo registro como un arreglo
        } else {
            return array(); // Si no hay resultados, devuelve un arreglo vacío
        }
    }




    public function obtenerDatos_cdp($numero_asiento) {
        $this->db->select('
            numasi.FechaEmision as fecha,
            nd.numero,
            nd.comprobante,
            nd.Debe,
            nd.Haber,
            p.ruc as ruc,
            p.razon_social as proveedor,
            p.direccion as direccion,
            p.telefono as telef,
            p.email as email,
            numasi.op as orden_de_pago,
            cc.Descripcion_CC as Descripcion,
            of.codigo as of_codigo,
            ff.codigo as ff_codigo,
            pr.codigo as pro_codigo,
            nd.detalles as detalle,
            cc.tipo as tipo,
            cc.Descripcion_CC as descripcion,
            nd.numero as numero,
            pp.TotalPresupuestado as presupuesto_ini,
            nd.Debe as debe,
            COALESCE(
                SUM(nd.Debe) OVER (
                    PARTITION BY 
                        cc.Codigo_CC, 
                        pr.codigo, 
                        ff.codigo, 
                        of.codigo
                    ORDER BY numasi.num_asi ASC 
                    ROWS BETWEEN UNBOUNDED PRECEDING AND 1 PRECEDING
                ), 0) as acumulado_anterior
        ');
    
        $this->db->from('num_asi_deta nd');
        $this->db->join('proveedores p', 'p.id = nd.proveedores_id', 'left');
        $this->db->join('cuentacontable cc', 'cc.IDCuentaContable = nd.IDCuentaContable');
        $this->db->join('presupuestos pp', 'pp.idcuentacontable = cc.IDCuentaContable');
        $this->db->join('num_asi numasi', 'numasi.IDNum_Asi = nd.Num_Asi_IDNum_Asi', 'left');
        $this->db->join('programa pr', 'pr.id_pro = nd.id_pro');
        $this->db->join('fuente_de_financiamiento ff', 'ff.id_ff = nd.id_ff');
        $this->db->join('origen_de_financiamiento of', 'of.id_of = nd.id_of');
        $this->db->where('num_asi', $numero_asiento);
        $this->db->order_by('nd.IDNum_Asi_Deta', 'DESC');
        $this->db->limit(1);
        $query = $this->db->get();
        
        if ($query->num_rows() > 0) {
            return $query->row_array();
        } else {
            return array();
        }
    }
    
    
}
