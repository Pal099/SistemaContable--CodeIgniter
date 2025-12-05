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
     * Esta función se utilizará para validar en el momento de crear un comprobante de gasto,
     * está en el Controlador de comprobantes de gasto, la función verificar_saldo
     * Actualiza la ejecución mensual usando el número de asiento.
     *  ToDo:
     *      volver a analizar la forma que se toma la fecha
     *      agregar un sql para el calculo de la ejecución del  presupuesto global 
     * Se asume que:
     * - El asiento con Debe > 0 (primer asiento) contiene el monto a sumar.
     * - El asiento con Haber > 0 (segundo asiento) contiene la cuenta presupuestada.
     */
    //esta función lo que hace es calcular el saldo presupuestario para validar que un presupuesto tenga disponible saldo para ejecutar en un comprobante de gasto
    public function calcular_saldo_presupuestario($id_presupuesto)
    {
        // Definir el mes actual en formato datetime (primer día del mes)
        // Preguntar a papá sobre como es mejor determinar qué fecha se usa para el mes que afecta
        // hay que tener en cuenta que se puede querer afectar a un presupuesto en un mes diferente
        $fecha_mes_actual = date('Y-m-01 00:00:00');

        // Obtener presupuesto mensual
        // este select simplemente suma el monto presupuestado y modificado para el mes que toma la variable mes_actual
        // pero como se cargan estos montos acá ? 
        $this->db->select('monto_presupuestado, monto_modificado');
        $this->db->from('presupuesto_mensual');
        $this->db->where('id_presupuesto', $id_presupuesto);
        $this->db->where('mes', $fecha_mes_actual);
        $query_presupuesto = $this->db->get();


        if ($query_presupuesto->num_rows() == 0) {
            return ['error' => 'No existe presupuesto para este mes'];
        }

        $presupuesto = $query_presupuesto->row();
        $total_presupuesto = $presupuesto->monto_presupuestado + $presupuesto->monto_modificado;

        // Obtener ejecución acumulada (obligado y pagado)
        $this->db->select('COALESCE(SUM(obligado), 0) AS total_obligado, COALESCE(SUM(pagado), 0) AS total_pagado');
        $this->db->from('ejecucion_mensual');// en este otro método se hacen los calculos de la ejecución sobre los asientos que se van cargando     public function actualizarEjecucion($numero) 
        $this->db->where('id_presupuesto', $id_presupuesto);
        $this->db->where('mes', $fecha_mes_actual);
        $ejecucion = $this->db->get()->row();

        $saldo_disponible = $total_presupuesto - $ejecucion->total_obligado;
        $saldo_por_pagar = $ejecucion->total_obligado - $ejecucion->total_pagado;

        return [
            'saldo_disponible' => max($saldo_disponible, 0), // Evita negativos
            'saldo_por_pagar' => max($saldo_por_pagar, 0),
            'presupuesto_total' => $total_presupuesto,
            'ejecutado_obligado' => $ejecucion->total_obligado,
            'ejecutado_pagado' => $ejecucion->total_pagado
        ];
    }
    public function actualizarEjecucion($numero)
    {
         // 1. Buscar los detalles del asiento (Cuenta presupuestada + Dimensiones financieras)
        // Necesitamos id_of, id_ff, id_pro además de la cuenta para hacer el match exacto
        $this->db->select('IDCuentaContable, creado_en, id_of, id_ff, id_pro');
        $this->db->from('num_asi_deta');
        $this->db->where('numero', $numero);
        $this->db->where('Haber >', 0); // Asumimos que el Haber tiene la imputación presupuestaria
        $query = $this->db->get();
        $cuenta = $query->row();

        if (!$cuenta) {
            log_message('error', 'No se encontró cuenta presupuestada para el asiento número: ' . $numero);
            return false;
        }

        // 2. Buscar el monto del Debe (primer asiento - el gasto real, ya que puede haber por lo menos 1 asiento, más)
        $this->db->select('Debe');
        $this->db->from('num_asi_deta');
        $this->db->where('numero', $numero);
        $this->db->where('Debe >', 0);
        $query = $this->db->get();
        $monto = $query->row();

        if (!$monto || !is_numeric($monto->Debe)) {
            log_message('error', 'Monto en Debe no válido para el asiento número: ' . $numero);
            return false;
        }

        // Buscar el presupuesto asociado usando LAS 4 DIMENSIONES FINANCIERAS
        // CRÍTICO: Una cuenta puede aparecer en múltiples presupuestos (diferentes OF/FF/Programa)
        // Por eso DEBEMOS usar las 4 dimensiones para identificar EL presupuesto correcto
        $this->db->select('ID_Presupuesto');
        $this->db->from('presupuestos');
        $this->db->where('Idcuentacontable', $cuenta->IDCuentaContable);
        $this->db->where('origen_de_financiamiento_id_of', $cuenta->id_of);
        $this->db->where('fuente_de_financiamiento_id_ff', $cuenta->id_ff);
        $this->db->where('programa_id_pro', $cuenta->id_pro);
        $query = $this->db->get();
        $presupuesto = $query->row();

        if (!$presupuesto) {
            log_message('error', 'No se encontró presupuesto para la cuenta: ' . $cuenta->IDCuentaContable . 
                ' con dimensiones OF=' . $cuenta->id_of . ', FF=' . $cuenta->id_ff . ', PRO=' . $cuenta->id_pro);
            return false;
        }

        // Determinar mes según la fecha del asiento, creado_en es un timestamp sobre la fecha que se cargó un 
        // asiento en num_asi_deta, no la fecha seleccionada para el asiento en el num_asi
        $fecha_asiento = $cuenta->creado_en ?? date('Y-m-d H:i:s');
        $mes = date('Y-m-01 00:00:00', strtotime($fecha_asiento));

        // Obtener tipo de asiento y guardar la fila de del asiento seleccionado en $asiento
        $this->db->select('id_form');
        $this->db->from('num_asi_deta');
        $this->db->where('numero', $numero);
        $query = $this->db->get();
        $asiento = $query->row();

        if (!$asiento) {
            log_message('error', 'No se encontró el tipo de asiento para el número: ' . $numero);
            return false;
        }

        // Operación en ejecucion_mensual
        //toma el presupuesto asociado obtenido en la linea 97 , quizá es un error esto 
        $this->db->where('id_presupuesto', $presupuesto->ID_Presupuesto);
        $this->db->where('mes', $mes);
        $query = $this->db->get('ejecucion_mensual');
        //verifica si el asiento tiene más de 0 filas para actualizar 
        if ($query->num_rows() > 0) {
            //obtiene el obligado de el id_form1 
            $field = ($asiento->id_form == 1) ? 'obligado' : 'pagado';
            $this->db->set($field, "{$field} + {$monto->Debe}", false);
            $this->db->where('id_presupuesto', $presupuesto->ID_Presupuesto);
            $this->db->where('mes', $mes);
            $this->db->update('ejecucion_mensual');

            if ($this->db->affected_rows() === 0) {
                log_message('error', 'Falló la actualización en ejecucion_mensual');
                return false;
            }
        } else {
            $data = [
                'id_presupuesto' => $presupuesto->ID_Presupuesto,
                'mes' => $mes,
                'obligado' => ($asiento->id_form == 1) ? $monto->Debe : 0,
                'pagado' => ($asiento->id_form == 2) ? $monto->Debe : 0
            ];
            $this->db->insert('ejecucion_mensual', $data);

            if ($this->db->affected_rows() === 0) {
                log_message('error', 'Falló la inserción en ejecucion_mensual');
                return false;
            }
        }

        return true;
    }

    public function obtener_ejecucion_completa($cuenta_id, $fecha_inicio, $fecha_fin)
    {
        // Obtener los id_presupuesto asociados a la cuenta contable
        $this->db->select('ID_Presupuesto');
        $this->db->from('presupuestos');
        $this->db->where('Idcuentacontable', $cuenta_id);
        $query_presupuestos = $this->db->get();
        $ids_presupuesto = array_column($query_presupuestos->result_array(), 'ID_Presupuesto');

        // Obtener datos del presupuesto mensual
        $this->db->select('
            COALESCE(SUM(monto_presupuestado), 0) as TotalPresupuestado,
            COALESCE(SUM(monto_modificado), 0) as TotalModificado',
            false
        );
        $this->db->from('presupuesto_mensual');
        if (!empty($ids_presupuesto)) {
            $this->db->where_in('id_presupuesto', $ids_presupuesto);
        } else {
            // Si no hay presupuestos, retornar ceros
            return [
                'presupuesto_inicial' => 0,
                'presupuesto_modificado' => 0,
                'presupuesto_vigente' => 0,
                'obligado' => 0,
                'pagado' => 0,
                'pendiente_pago' => 0
            ];
        }
        $this->db->where('mes >=', $fecha_inicio);
        $this->db->where('mes <=', $fecha_fin);
        $query_presupuesto = $this->db->get();
        $presupuesto = $query_presupuesto->row_array();

        // Obtener ejecución presupuestaria (sin cambios, pero verificar fechas si es necesario)
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
