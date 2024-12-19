<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pdf_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function obtenerDatos() {
        $this->db->select('numasi.FechaEmision as fecha,nd.numero, numasi.op as op, of.codigo as codigo_of, nd.Haber as haber, nd.detalles as detalle, pr.codigo as codigo_pro, numasi.MontoPagado as montopagado, cc.IDCuentaContable as id_cc, nd.comprobante, nd.Debe, nd.Haber, p.ruc as ruc, p.razon_social as proveedor,p.direccion as direccion,p.telefono as telef, p.email as email, numasi.op as orden_de_pago, cc.Descripcion_CC as Descripcion, nd.detalles as detalle, cc.tipo as tipo');
        $this->db->from('num_asi_deta nd');
        $this->db->join('proveedores p', 'p.id = nd.proveedores_id', 'left');
        $this->db->join('cuentacontable cc', 'cc.IDCuentaContable = nd.IDCuentaContable');
        $this->db->join('programa pr', 'pr.id_pro = nd.id_pro');
        $this->db->join('origen_de_financiamiento of', 'of.id_of = nd.id_of');
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


    public function obtenerDatosSu() {
        $this->db->select('numasi.FechaEmision AS fecha, nd.numero, numasi.op AS op, of.codigo AS codigo_of, nd.Haber AS haber, nd.detalles AS detalle, pr.codigo AS codigo_pro, numasi.MontoPagado AS montopagado, cc.IDCuentaContable AS id_cc, nd.comprobante, nd.Debe, nd.Haber, p.ruc AS ruc, p.razon_social AS proveedor, p.direccion AS direccion, p.telefono AS telef, p.email AS email, numasi.op AS orden_de_pago, cc.Descripcion_CC AS Descripcion, nd.detalles AS detalle, cc.tipo AS tipo, ff.nombre AS fuente_financiamiento');
        $this->db->from('num_asi_deta nd');
        $this->db->join('proveedores p', 'p.id = nd.proveedores_id', 'left');
        $this->db->join('cuentacontable cc', 'cc.IDCuentaContable = nd.IDCuentaContable');
        $this->db->join('programa pr', 'pr.id_pro = nd.id_pro');
        $this->db->join('origen_de_financiamiento of', 'of.id_of = nd.id_of');
        $this->db->join('num_asi numasi', 'numasi.IDNum_Asi = nd.Num_Asi_IDNum_Asi', 'left');
        $this->db->join('fuente_de_financiamiento ff', 'ff.id_ff = of.id_of'); // Asegúrate de que esta relación es correcta
        $this->db->order_by('nd.IDNum_Asi_Deta', 'DESC'); // Ordena por el ID de forma descendente
        $this->db->limit(1); // Limita a un solo registro
        $query = $this->db->get();
        $result = $query->result_array(); // Asegúrate de usar result_array() para obtener un resultado en forma de array
    
        return $result;
    }
    

    public function obtenerUnidadAcademicaPorNombreUsuario($nombreUsuario) {
        // Obtener el id_unidad del usuario
        $this->db->select('id_unidad');
        $this->db->from('usuarios');
        $this->db->where('Nombre_usuario', $nombreUsuario);
        $query = $this->db->get();
        $result = $query->row_array();
        if (!$result) {
            return null;
        }
        $idUnidad = $result['id_unidad'];
        
        // Obtener el nombre de la unidad académica
        $this->db->select('unidad');
        $this->db->from('unidad_academica');
        $this->db->where('id_unidad', $idUnidad);
        $query = $this->db->get();
        $result = $query->row_array();
        return $result ? $result['unidad'] : null;
    }


    public function obtenerDatos_pago() {
        $this->db->select('numasi.FechaEmision as fecha,nd.numero, numasi.op as op, of.codigo as codigo_of, nd.Haber as haber, nd.detalles as detalle, pr.codigo as codigo_pro, numasi.MontoPagado as montopagado, cc.IDCuentaContable as id_cc, nd.comprobante, nd.Debe, nd.Haber, p.ruc as ruc, p.razon_social as proveedor,p.direccion as direccion,p.telefono as telef, p.email as email, numasi.op as orden_de_pago, cc.Descripcion_CC as Descripcion, nd.detalles as detalle, cc.tipo as tipo, cc.Codigo_CC as codi_cc');
        $this->db->from('num_asi_deta nd');
        $this->db->join('proveedores p', 'p.id = nd.proveedores_id', 'left');
        $this->db->join('cuentacontable cc', 'cc.IDCuentaContable = nd.IDCuentaContable');
        $this->db->join('programa pr', 'pr.id_pro = nd.id_pro');
        $this->db->join('origen_de_financiamiento of', 'of.id_of = nd.id_of');
        $this->db->join('num_asi numasi', 'numasi.IDNum_Asi = nd.Num_Asi_IDNum_Asi', 'left');
        $this->db->order_by('numasi.op', 'DESC'); // Ordena por el ID de forma descendente
        $this->db->limit(1); // Limita a un solo registro
        $query = $this->db->get();
        $result = $query->result_array(); // Make sure to use result_array() for an array result

        if ($query->num_rows() > 0) {
            return $query->row_array(); // Devuelve un solo registro como un arreglo
        } else {
            return array(); // Si no hay resultados, devuelve un arreglo vacío
        }
    }

    public function obtenerDatos_pago_numasi($numero_asiento) {
        $this->db->select('numasi.FechaEmision as fecha,nd.numero, numasi.op as op, of.codigo as codigo_of, nd.Haber as haber, nd.detalles as detalle, pr.codigo as codigo_pro, numasi.MontoPagado as montopagado, cc.IDCuentaContable as id_cc, nd.comprobante, nd.Debe, nd.Haber, p.ruc as ruc, p.razon_social as proveedor,p.direccion as direccion,p.telefono as telef, p.email as email, numasi.op as orden_de_pago, cc.Descripcion_CC as Descripcion, nd.detalles as detalle, cc.tipo as tipo, cc.Codigo_CC as codi_cc');
        $this->db->from('num_asi_deta nd');
        $this->db->join('proveedores p', 'p.id = nd.proveedores_id', 'left');
        $this->db->join('cuentacontable cc', 'cc.IDCuentaContable = nd.IDCuentaContable');
        $this->db->join('programa pr', 'pr.id_pro = nd.id_pro');
        $this->db->join('origen_de_financiamiento of', 'of.id_of = nd.id_of');
        $this->db->join('num_asi numasi', 'numasi.IDNum_Asi = nd.Num_Asi_IDNum_Asi', 'left');
        $this->db->where('num_asi', $numero_asiento);
        $this->db->order_by('numasi.op', 'DESC'); // Ordena por el ID de forma descendente
        $this->db->limit(1); // Limita a un solo registro
        $query = $this->db->get();
        $result = $query->result_array(); // Make sure to use result_array() for an array result

        if ($query->num_rows() > 0) {
            return $query->row_array(); // Devuelve un solo registro como un arreglo
        } else {
            return array(); // Si no hay resultados, devuelve un arreglo vacío
        }
    }


    public function obtenerDatosPedido($id_pedido) {
        // Selecciona los campos necesarios, incluyendo 'fecha'
        $this->db->select('cg.*, p.ruc, p.razon_social as proveedor, cg.fecha'); 
        $this->db->from('comprobante_gasto cg');
        $this->db->join('proveedores p', 'p.id = cg.idproveedor', 'left');
        $this->db->where('cg.id_pedido', $id_pedido); // Filtra por id_pedido
        $query = $this->db->get();
        
        // Devuelve los resultados como un arreglo
        return $query->result_array();
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
    

    public function getPresu() {
        $this->db->select('pre.*, c.Descripcion_CC as descripcion, ff.codigo as ff, of.codigo as of, pr.nombre as prog, c.tipo as tipo, c.Codigo_CC as codi_cc, pre.TotalPresupuestado as presu_monto');
        $this->db->from('presupuestos pre');
        $this->db->join("fuente_de_financiamiento ff", "pre.fuente_de_financiamiento_id_ff = ff.id_ff");
        $this->db->join("origen_de_financiamiento of", "pre.origen_de_financiamiento_id_of = of.id_of");
        $this->db->join("programa pr", "pre.programa_id_pro = pr.id_pro");
        $this->db->join("cuentacontable c", "pre.Idcuentacontable = c.IDCuentaContable");
        $this->db->join('uni_respon_usu', 'pre.id_uni_respon_usu = uni_respon_usu.id_uni_respon_usu');
        $this->db->where('pre.estado', '1');
        
        $resultado = $this->db->get();
        return $resultado->result();  // Cambiando de 'result()' a 'row()'
    }
    
    
}