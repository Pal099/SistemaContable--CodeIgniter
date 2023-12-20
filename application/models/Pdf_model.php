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

        if ($query->num_rows() > 0) {
            return $query->result_array(); // Devuelve un arreglo de resultados
        } else {
            return array(); // Si no hay resultados, devuelve un arreglo vacío
        }
    }
}
