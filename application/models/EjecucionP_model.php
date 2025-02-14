<?php
defined('BASEPATH') or exit('No direct script access allowed');

class EjecucionP_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
    /**
     * Actualiza la ejecución mensual usando el número de asiento.
     * Se asume que:
     * - El asiento con Debe > 0 (primer asiento) contiene el monto a sumar.
     * - El asiento con Haber > 0 (segundo asiento) contiene la cuenta presupuestada.
     */
    //esta función lo que hace es calcular el saldo presupuestario para validar que un presupuesto tenga disponible saldo para ejecutar en un comprobante de gasto
    public function calcular_saldo_presupuestario($id_presupuesto) {
        // Definimos el primer día del mes actual en formato datetime
        $fecha_mes_actual = date('Y-m-01 00:00:00');
    
        // Obtener el registro de presupuesto mensual correspondiente al mes actual
        $this->db->select('monto_presupuestado, monto_modificado');
        $this->db->from('presupuesto_mensual');
        $this->db->where('id_presupuesto', $id_presupuesto);
        $this->db->where('mes', $fecha_mes_actual); // Filtra por el primer día del mes
        $query_presupuesto = $this->db->get();
    
        if ($query_presupuesto->num_rows() == 0) {
            return ['error' => 'No existe presupuesto para este mes'];
        }
    
        $presupuesto = $query_presupuesto->row();
        $total_presupuesto = $presupuesto->monto_presupuestado + $presupuesto->monto_modificado;
    
        // Obtener el total de "obligado" acumulado para el mes actual en la tabla de ejecución
        $this->db->select('COALESCE(SUM(obligado), 0) AS total_obligado');
        $this->db->from('ejecucion_mensual');
        $this->db->where('id_presupuesto', $id_presupuesto);
        $this->db->where('mes', $fecha_mes_actual); // Filtra por el primer día del mes
        $ejecucion = $this->db->get()->row();
    
        $saldo = $total_presupuesto - $ejecucion->total_obligado;
    
        return [
            'saldo' => max($saldo, 0),  // Evitamos valores negativos
            'presupuesto' => $total_presupuesto,
            'ejecutado' => $ejecucion->total_obligado,
        ];
    }
    public function actualizarEjecucion($numero)
    {
        // Buscar la cuenta presupuestada (segundo asiento)
        $this->db->select('IDCuentaContable');
        $this->db->from('num_asi_deta');
        $this->db->where('numero', $numero);
        $this->db->where('Haber >', 0);
        $query = $this->db->get();
        $cuenta = $query->row();

        if (!$cuenta) {
            log_message('error', 'No se encontró cuenta presupuestada para el asiento número: ' . $numero);
            return false;
        }

        // Buscar el monto del Debe (primer asiento)
        $this->db->select('Debe');
        $this->db->from('num_asi_deta');
        $this->db->where('numero', $numero);
        $this->db->where('Debe >', 0);
        $query = $this->db->get();
        $monto = $query->row();

        if (!$monto) {
            log_message('error', 'No se encontró monto en Debe para el asiento número: ' . $numero);
            return false;
        }

        // Buscar el presupuesto asociado a la cuenta presupuestada
        $this->db->select('ID_Presupuesto');
        $this->db->from('presupuestos');
        $this->db->where('Idcuentacontable', $cuenta->IDCuentaContable);
        $query = $this->db->get();
        $presupuesto = $query->row();

        if (!$presupuesto) {
            log_message('error', 'No se encontró presupuesto para la cuenta: ' . $cuenta->IDCuentaContable);
            return false;
        }

        // Definir la fecha en la que se hará la actualización (se usa el primer día del mes de la fecha actual)
        $fecha = date('Y-m-01 00:00:00');
        $mes = date('Y-m-d H:i:s', strtotime($fecha));

        // Obtener el tipo de asiento para saber qué campo actualizar
        $this->db->select('id_form');
        $this->db->from('num_asi_deta');
        $this->db->where('numero', $numero);
        $query = $this->db->get();
        $asiento = $query->row();

        if (!$asiento) {
            log_message('error', 'No se encontró el tipo de asiento para el número: ' . $numero);
            return false;
        }

        // Actualizar la tabla ejecucion_mensual
        $this->db->select('*');
        $this->db->from('ejecucion_mensual');
        $this->db->where('id_presupuesto', $presupuesto->ID_Presupuesto);
        $this->db->where('mes', $mes);
        $query = $this->db->get();



        if ($query->num_rows() > 0) {
            // Si ya existe, actualizar el valor correspondiente
            if ($asiento->id_form == 1) {
                $this->db->set('obligado', 'obligado + ' . $monto->Debe, false);
            } elseif ($asiento->id_form == 2) {
                $this->db->set('pagado', 'pagado + ' . $monto->Debe, false);
            }

            $this->db->where('id_presupuesto', $presupuesto->ID_Presupuesto);
            $this->db->where('mes', $mes);
            $this->db->update('ejecucion_mensual');

            log_message('info', "Ejecución mensual actualizada para el presupuesto {$presupuesto->ID_Presupuesto} con monto {$monto->Debe} (asiento número: $numero)");
        } else {
            // Insertar si no existe
            $data = [
                'id_presupuesto' => $presupuesto->ID_Presupuesto,
                'mes' => $mes,
                'obligado' => $asiento->id_form == 1 ? $monto->Debe : 0,
                'pagado' => $asiento->id_form == 2 ? $monto->Debe : 0
            ];
            $this->db->insert('ejecucion_mensual', $data);
            log_message('info', "Nuevo registro creado en ejecucion_mensual para id_presupuesto {$presupuesto->ID_Presupuesto} y mes {$fecha} (asiento número: $numero)");
        }
    }


    public function obtener_ejecucion_completa($cuenta_id, $fecha_inicio, $fecha_fin)
    {
        // Obtener año para el presupuesto
        $anio_presupuesto = date('Y', strtotime($fecha_inicio));

        // Obtener datos del presupuesto con coalesce
        $this->db->select('COALESCE(SUM(TotalPresupuestado), 0) as TotalPresupuestado, 
                          COALESCE(SUM(TotalModificado), 0) as TotalModificado',
            false
        );
        $this->db->from('presupuestos');
        $this->db->where('Idcuentacontable', $cuenta_id);
        $this->db->where('YEAR(Año)', $anio_presupuesto);
        $query_presupuesto = $this->db->get();
        $presupuesto = $query_presupuesto->row_array();

        // Obtener ejecución presupuestaria con coalesce en la consulta
        $this->db->select("
            COALESCE(SUM(CASE WHEN id_form = 1 THEN Debe ELSE 0 END), 0) as obligado,
            COALESCE(SUM(CASE WHEN id_form = 2 THEN Debe ELSE 0 END), 0) as pagado",
            false
        );
        $this->db->from('num_asi_deta');
        $this->db->where('IDCuentaContable', $cuenta_id);
        $this->db->where('creado_en >=', $fecha_inicio);
        $this->db->where('creado_en <=', $fecha_fin);
        $query_ejecucion = $this->db->get();
        $ejecucion = $query_ejecucion->row_array();

        // Construir respuesta consolidada
        return [
            'presupuesto_inicial' => $presupuesto['TotalPresupuestado'],
            'presupuesto_modificado' => $presupuesto['TotalModificado'],
            'presupuesto_vigente' => $presupuesto['TotalPresupuestado'] + $presupuesto['TotalModificado'],
            'obligado' => $ejecucion['obligado'],
            'pagado' => $ejecucion['pagado'],
            'pendiente_pago' => $ejecucion['obligado'] - $ejecucion['pagado']
        ];
    }

    public function obtener_ejecuciones_para_vista($fecha_inicio, $fecha_fin, $origen = null, $fuente = null, $programa = null, $cuenta = null)
    {
        $this->db->select('
            p.Idcuentacontable,
            of.codigo AS codigo_origen,
            of.nombre AS nombre_of,
            ff.codigo AS codigo_fuente,
            ff.nombre AS nombre_ff,
            pro.codigo AS codigo_programa,
            pro.nombre AS nombre_pro,
            cc.Codigo_CC AS codigo_cuenta,
            cc.Descripcion_CC AS nombre_cuenta,
            SUM(p.TotalPresupuestado) AS TotalPresupuestado,
            SUM(p.TotalModificado) AS TotalModificado,
            (SUM(p.TotalPresupuestado) + SUM(p.TotalModificado)) AS Vigente,
            COALESCE(SUM(nd.MontoPago), 0) AS Obligado,
            COALESCE(SUM(nd.Haber), 0) AS Pagado,
            nd.creado_en As fecha
        ');

        $this->db->from('presupuestos p');

        // JOINS CORREGIDOS
        $this->db->join('origen_de_financiamiento of', 'p.origen_de_financiamiento_id_of = of.id_of', 'left');
        $this->db->join('fuente_de_financiamiento ff', 'p.fuente_de_financiamiento_id_ff = ff.id_ff', 'left');
        $this->db->join('programa pro', 'p.programa_id_pro = pro.id_pro', 'left');
        $this->db->join('cuentacontable cc', 'p.Idcuentacontable = cc.IDCuentaContable', 'left');
        $this->db->join('num_asi_deta nd', 'p.Idcuentacontable = nd.IDCuentaContable', 'left');

        // FILTRO DE FECHAS CON LEFT JOIN
        $this->db->group_start()
            ->where('nd.creado_en BETWEEN "' . $fecha_inicio . '" AND "' . $fecha_fin . '"')
            ->or_where('nd.creado_en IS NULL')
            ->group_end();

        // APLICAR FILTROS ADICIONALES
        if ($origen)
            $this->db->where('p.origen_de_financiamiento_id_of', $origen);
        if ($fuente)
            $this->db->where('p.fuente_de_financiamiento_id_ff', $fuente);
        if ($programa)
            $this->db->where('p.programa_id_pro', $programa);
        if ($cuenta)
            $this->db->where('p.Idcuentacontable', $cuenta);

        $this->db->group_by('p.Idcuentacontable, p.origen_de_financiamiento_id_of, p.fuente_de_financiamiento_id_ff, p.programa_id_pro');

        return $this->db->get()->result();
    }


    public function save($data)
    {
        return $this->db->insert("ejecucionpresupuestaria", $data);
    }

    public function getEjecucionesP($id)
    {
        $this->db->where("ID_EjecucionPresupuestaria", $id);
        $resultado = $this->db->get("ejecucionpresupuestaria");
        return $resultado->row();
    }

    public function update($id, $data)
    {
        $this->db->where("ID_EjecucionPresupuestaria", $id);
        return $this->db->update("ejecucionpresupuestaria", $data);
    }
}
