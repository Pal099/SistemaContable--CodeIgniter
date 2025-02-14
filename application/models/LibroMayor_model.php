<?php
defined('BASEPATH') or exit('No direct script access allowed');

class LibroMayor_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        // Cargar la base de datos si no se ha cargado automáticamente
        $this->load->database();
        $this->load->model("LibroMayor_model");

    }

    public function obtenerEntradasLibroMayor($fechaInicio = null, $fechaFin = null, $idcuentacontable = null, $idPro = null, $idFf = null, $idOf = null, $idForm = null)
    {
        // Primero, calculamos el saldo anterior para el mes anterior al periodo indicado por $fechaInicio.
        $saldo_anterior = 0;
        $mes_anterior_inicio = date('Y-m-01', strtotime($fechaInicio . ' -1 month')); // Primer día del mes anterior
        $mes_anterior_fin = date('Y-m-t', strtotime($fechaInicio . ' -1 month')); // Último día del mes anterior

        // Obtener las transacciones del mes anterior
        $this->db->select('na.FechaEmision, nad.Debe, nad.Haber, cc.Codigo_CC');
        $this->db->from('num_asi na');
        $this->db->join('num_asi_deta nad', 'na.num_asi = nad.Num_Asi_IDNum_Asi', 'inner');
        $this->db->join('cuentacontable cc', 'nad.IDCuentaContable = cc.IDCuentaContable', 'inner');
        $this->db->where('na.FechaEmision >=', $mes_anterior_inicio);
        $this->db->where('na.FechaEmision <=', $mes_anterior_fin);

        // Aplicar los mismos filtros del mes actual
        if (!empty($idcuentacontable) && $idcuentacontable != '-1') {
            $this->db->where('nad.IDCuentaContable', $idcuentacontable);
        }
        if (!empty($idPro) && $idPro != '-1') {
            $this->db->where('na.proyecto', $idPro);
        }
        if (!empty($idFf) && $idFf != '-1') {
            $this->db->where('na.id_ff', $idFf);
        }
        if (!empty($idOf) && $idOf != '-1') {
            $this->db->where('na.id_of', $idOf);
        }
        if (!empty($idForm) && $idForm != '-1') {
            $this->db->where('na.id_form', $idForm);
        }

        $query_anterior = $this->db->get();
        $resultados_anterior = $query_anterior->result_array();

        // Calcular saldo anterior
        foreach ($resultados_anterior as $resultado_anterior) {
            if (strpos($resultado_anterior['Codigo_CC'], "2") === 0 || strpos($resultado_anterior['Codigo_CC'], "3") === 0) {
                $saldo_anterior += ($resultado_anterior['Debe'] - $resultado_anterior['Haber']);
            } elseif (strpos($resultado_anterior['Codigo_CC'], "4") === 0 || strpos($resultado_anterior['Codigo_CC'], "8") === 0) {
                $saldo_anterior += ($resultado_anterior['Haber'] - $resultado_anterior['Debe']);
            }
        }

        // Ahora, obtenemos las transacciones del periodo actual
        $this->db->select('na.FechaEmision, na.id_form, nad.numero, na.num_asi as Num_Asi_IDNum_Asi, nad.comprobante, nad.detalles as Descripcion, nad.Debe, nad.Haber, cc.Codigo_CC, cc.Descripcion_CC');
        $this->db->from('num_asi na');
        $this->db->join('num_asi_deta nad', 'na.num_asi = nad.Num_Asi_IDNum_Asi', 'inner');
        $this->db->join('cuentacontable cc', 'nad.IDCuentaContable = cc.IDCuentaContable', 'inner');

        // Filtros por fechas
        if (!empty($fechaInicio) && !empty($fechaFin) && $fechaInicio != '-1' && $fechaFin != '-1') {
            $this->db->where('na.FechaEmision >=', $fechaInicio);
            $this->db->where('na.FechaEmision <=', $fechaFin);
        }

        // Aplicar los mismos filtros del mes actual
        if (!empty($idcuentacontable) && $idcuentacontable != '-1') {
            $this->db->where('nad.IDCuentaContable', $idcuentacontable);
        }
        if (!empty($idPro) && $idPro != '-1') {
            $this->db->where('na.proyecto', $idPro);
        }
        if (!empty($idFf) && $idFf != '-1') {
            $this->db->where('na.id_ff', $idFf);
        }
        if (!empty($idOf) && $idOf != '-1') {
            $this->db->where('na.id_of', $idOf);
        }
        if (!empty($idForm) && $idForm != '-1') {
            $this->db->where('na.id_form', $idForm);
        }

        $query = $this->db->get();
        $resultados = $query->result_array();

        // Calcular saldo actual
        $saldo_actual = $saldo_anterior; // El saldo actual comienza con el saldo del mes anterior
        foreach ($resultados as &$resultado) {
            // Determinar el tipo de cuenta basado en el inicio del Codigo_CC
            if (strpos($resultado['Codigo_CC'], "2") === 0 || strpos($resultado['Codigo_CC'], "3") === 0) {
                $saldo_actual += ($resultado['Debe'] - $resultado['Haber']);
            } elseif (strpos($resultado['Codigo_CC'], "4") === 0 || strpos($resultado['Codigo_CC'], "8") === 0) {
                $saldo_actual += ($resultado['Haber'] - $resultado['Debe']);
            }
            // Agregar el saldo calculado al array del resultado
            $resultado['Saldo'] = $saldo_actual;
            $resultado['Saldo_Anterior'] = $saldo_anterior;
        }

        return $resultados;
    }


    // Aquí puedes agregar otros métodos que necesites para tu modelo
}