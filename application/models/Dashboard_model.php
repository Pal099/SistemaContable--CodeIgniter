<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    /**
     * Obtener estadísticas del mes anterior para comparación
     */
    public function getCountObligadosMesAnterior($id_uni_respon_usu) {
        $mesAnterior = date('m', strtotime('-1 month'));
        $añoAnterior = date('Y', strtotime('-1 month'));
        
        $this->db->select('COUNT(*) as num_obligados');
        $this->db->from('num_asi');
        $this->db->join('uni_respon_usu', 'num_asi.id_uni_respon_usu = uni_respon_usu.id_uni_respon_usu');
        $this->db->where('num_asi.estado_registro', '1');
        $this->db->where('num_asi.id_form', '1');
        $this->db->where('num_asi.op', '0');
        $this->db->where('uni_respon_usu.id_uni_respon_usu', $id_uni_respon_usu);
        $this->db->where('MONTH(num_asi.FechaEmision)', $mesAnterior);
        $this->db->where('YEAR(num_asi.FechaEmision)', $añoAnterior);
        $this->db->where('num_asi.SumaMonto != num_asi.MontoTotal');
    
        $resultados = $this->db->get();
        return $resultados->row()->num_obligados;
    }

    /**
     * Obtener datos para gráfico de tendencias de los últimos 6 meses
     */
    public function getTendenciasSeisMeses($id_uni_respon_usu) {
        $datos = [
            'obligados' => [],
            'pagados' => [],
            'meses' => []
        ];

        for ($i = 5; $i >= 0; $i--) {
            $fecha = date('Y-m', strtotime("-$i months"));
            $mes = date('m', strtotime("-$i months"));
            $año = date('Y', strtotime("-$i months"));
            $nombreMes = date('M', strtotime("-$i months"));

            // Obligados del mes
            $this->db->select('COUNT(*) as total');
            $this->db->from('num_asi');
            $this->db->join('uni_respon_usu', 'num_asi.id_uni_respon_usu = uni_respon_usu.id_uni_respon_usu');
            $this->db->where('num_asi.estado_registro', '1');
            $this->db->where('num_asi.id_form', '1');
            $this->db->where('num_asi.op', '0');
            $this->db->where('uni_respon_usu.id_uni_respon_usu', $id_uni_respon_usu);
            $this->db->where('MONTH(num_asi.FechaEmision)', $mes);
            $this->db->where('YEAR(num_asi.FechaEmision)', $año);
            $this->db->where('num_asi.SumaMonto != num_asi.MontoTotal');
            
            $obligados = $this->db->get()->row()->total;

            // Pagados del mes
            $this->db->select('COUNT(*) as total');
            $this->db->from('num_asi');
            $this->db->join('usuarios', 'num_asi.id_usuario_numasi = usuarios.id_user');
            $this->db->join('unidad_academica', 'unidad_academica.id_unidad = usuarios.id_unidad');
            $this->db->where('num_asi.estado_registro', '1');
            $this->db->where('num_asi.id_form', '2');
            $this->db->where('unidad_academica.id_unidad', $id_uni_respon_usu);
            $this->db->where('MONTH(num_asi.FechaEmision)', $mes);
            $this->db->where('YEAR(num_asi.FechaEmision)', $año);
            $this->db->where('num_asi.SumaMonto != num_asi.MontoTotal');

            $pagados = $this->db->get()->row()->total;

            $datos['obligados'][] = (int)$obligados;
            $datos['pagados'][] = (int)$pagados;
            $datos['meses'][] = $nombreMes;
        }

        return $datos;
    }

    /**
     * Obtener top proveedores del mes
     */
    public function getTopProveedores($id_uni_respon_usu, $limit = 5) {
        $this->db->select('p.razon_social, SUM(na.MontoTotal) as total_monto, COUNT(na.IDNum_Asi) as cantidad_obligaciones');
        $this->db->from('num_asi na');
        $this->db->join('proveedores p', 'na.id_provee = p.id');
        $this->db->join('uni_respon_usu uru', 'na.id_uni_respon_usu = uru.id_uni_respon_usu');
        $this->db->where('na.estado_registro', '1');
        $this->db->where('na.id_form', '1');
        $this->db->where('na.op', '0');
        $this->db->where('uru.id_uni_respon_usu', $id_uni_respon_usu);
        $this->db->where('MONTH(na.FechaEmision)', date('m'));
        $this->db->where('YEAR(na.FechaEmision)', date('Y'));
        $this->db->group_by('p.id');
        $this->db->order_by('total_monto', 'DESC');
        $this->db->limit($limit);

        return $this->db->get()->result();
    }

    /**
     * Obtener últimas obligaciones del mes
     */
    public function getUltimasObligaciones($id_uni_respon_usu, $limit = 10) {
        $this->db->select('na.*, p.razon_social');
        $this->db->from('num_asi na');
        $this->db->join('proveedores p', 'na.id_provee = p.id');
        $this->db->join('uni_respon_usu uru', 'na.id_uni_respon_usu = uru.id_uni_respon_usu');
        $this->db->where('na.estado_registro', '1');
        $this->db->where('na.id_form', '1');
        $this->db->where('na.op', '0');
        $this->db->where('uru.id_uni_respon_usu', $id_uni_respon_usu);
        $this->db->where('MONTH(na.FechaEmision)', date('m'));
        $this->db->where('YEAR(na.FechaEmision)', date('Y'));
        $this->db->order_by('na.FechaEmision', 'DESC');
        $this->db->limit($limit);

        return $this->db->get()->result();
    }

    /**
     * Obtener total de gastos del mes (comprobantes de gasto)
     */
    public function getGastosMes($id_uni_respon_usu) {
        // Calcular el total basado en los campos disponibles
        $this->db->select('SUM((preciounit * cantidad) + iva) as total_gastos, COUNT(*) as total_comprobantes');
        $this->db->from('comprobante_gasto');
        $this->db->where('estado', '1');
        $this->db->where('id_uni_respon_usu', $id_uni_respon_usu);
        $this->db->where('MONTH(fecha)', date('m'));
        $this->db->where('YEAR(fecha)', date('Y'));

        $resultado = $this->db->get()->row();
        
        return [
            'gastos_mes' => $resultado->total_gastos ?? 0,
            'total_comprobantes' => $resultado->total_comprobantes ?? 0
        ];
    }

    /**
     * Obtener datos de presupuesto
     */
    public function getDatosPresupuesto($id_uni_respon_usu) {
        // Obtener presupuesto total
        $this->db->select('SUM(TotalPresupuestado) as presupuesto_total');
        $this->db->from('presupuestos');
        $this->db->where('id_uni_respon_usu', $id_uni_respon_usu);
        $this->db->where('YEAR(Año)', date('Y'));
        
        $presupuesto_total = $this->db->get()->row()->presupuesto_total ?? 0;

        // Obtener presupuesto ejecutado (obligaciones)
        $this->db->select('SUM(MontoTotal) as ejecutado_obligaciones');
        $this->db->from('num_asi');
        $this->db->where('estado_registro', '1');
        $this->db->where('id_form', '1');
        $this->db->where('op', '0');
        $this->db->where('id_uni_respon_usu', $id_uni_respon_usu);
        $this->db->where('YEAR(FechaEmision)', date('Y'));
        
        $ejecutado_obligaciones = $this->db->get()->row()->ejecutado_obligaciones ?? 0;

        // Obtener gastos ejecutados
        $this->db->select('SUM((preciounit * cantidad) + iva) as ejecutado_gastos');
        $this->db->from('comprobante_gasto');
        $this->db->where('estado', '1');
        $this->db->where('id_uni_respon_usu', $id_uni_respon_usu);
        $this->db->where('YEAR(fecha)', date('Y'));
        
        $ejecutado_gastos = $this->db->get()->row()->ejecutado_gastos ?? 0;

        $presupuesto_ejecutado = $ejecutado_obligaciones + $ejecutado_gastos;

        return [
            'presupuesto_total' => $presupuesto_total,
            'presupuesto_ejecutado' => $presupuesto_ejecutado
        ];
    }

    /**
     * Obtener conteo de obligaciones pendientes
     */
    public function getCountPendientes($id_uni_respon_usu) {
        $this->db->select('COUNT(*) as num_pendientes');
        $this->db->from('num_asi');
        $this->db->join('uni_respon_usu', 'num_asi.id_uni_respon_usu = uni_respon_usu.id_uni_respon_usu');
        $this->db->where('num_asi.estado_registro', '1');
        $this->db->where('num_asi.id_form', '1');
        $this->db->where('num_asi.op', '0');
        $this->db->where('uni_respon_usu.id_uni_respon_usu', $id_uni_respon_usu);
        $this->db->where('MONTH(num_asi.FechaEmision)', date('m'));
        $this->db->where('num_asi.SumaMonto = num_asi.MontoTotal'); // Pendientes: SumaMonto igual a MontoTotal
    
        $resultados = $this->db->get();
        return $resultados->row()->num_pendientes;
    }

    /**
     * Obtener conteo de obligaciones sin pagar (estado 3)
     */
    public function getCountObligadosSinPagar($id_uni_respon_usu) {
        $this->db->select('COUNT(*) as num_obligados_sin_pagar');
        $this->db->from('num_asi');
        $this->db->join('uni_respon_usu', 'num_asi.id_uni_respon_usu = uni_respon_usu.id_uni_respon_usu');
        $this->db->where('num_asi.estado_registro', '1');
        $this->db->where('num_asi.id_form', '1');
        $this->db->where('num_asi.op', '0');
        $this->db->where('num_asi.estado', '3'); // Estado 3 = Obligado sin pagar
        $this->db->where('uni_respon_usu.id_uni_respon_usu', $id_uni_respon_usu);
        $this->db->where('MONTH(num_asi.FechaEmision)', date('m'));
    
        $resultados = $this->db->get();
        return $resultados->row()->num_obligados_sin_pagar;
    }

    /**
     * Método de debug para verificar la configuración del usuario
     */
    public function debugUsuario($nombre_usuario) {
        $this->db->select('u.id_user, u.Nombre_usuario, u.id_unidad, uru.id_uni_respon_usu');
        $this->db->from('usuarios u');
        $this->db->join('uni_respon_usu uru', 'u.id_user = uru.id_user', 'left');
        $this->db->where('u.Nombre_usuario', $nombre_usuario);
        
        return $this->db->get()->row();
    }
}
