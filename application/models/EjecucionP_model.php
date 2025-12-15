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
    * - La línea presupuestaria (cuenta + dimensiones) puede venir en DEBE o en HABER,
    *   según el origen del asiento; esta función busca la línea que mapea a un presupuesto
    *   (por las 4 dimensiones) y usa ese monto para actualizar la ejecución mensual.
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
        $this->db->select('
            COALESCE(SUM(obligado), 0) AS total_obligado, 
            COALESCE(SUM(pagado), 0) AS total_pagado
        ');
        $this->db->from('ejecucion_mensual');// en este otro método se hacen los calculos de la ejecución sobre los asientos que se van cargando     public function actualizarEjecucion($numero) 
        $this->db->where('id_presupuesto', $id_presupuesto);
        $this->db->where('mes', $fecha_mes_actual);
        $ejecucion = $this->db->get()->row();

        // SALDO DISPONIBLE = Presupuesto - Obligado
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
        log_message('debug', '=== INICIO actualizarEjecucion para número: ' . $numero . ' ===');
        
        // 1. Buscar líneas del asiento que contengan:
        //    - Monto (Debe o Haber)
        //    - Cuenta (IDCuentaContable)
        //    - Dimensiones financieras (id_of, id_ff, id_pro)
        //    - Tipo de formulario (id_form)
        // La cuenta presupuestada puede venir en DEBE o HABER, dependiendo del origen.
        $this->db->select('IDCuentaContable, Debe, Haber, creado_en, id_of, id_ff, id_pro, id_form');
        $this->db->from('num_asi_deta');
        $this->db->where('numero', $numero);
        $this->db->group_start();
        $this->db->where('Debe >', 0);
        $this->db->or_where('Haber >', 0);
        $this->db->group_end();
        $this->db->order_by('IDNum_Asi_Deta', 'ASC');
        $lineas = $this->db->get()->result();

        if (empty($lineas)) {
            log_message('error', 'No se encontraron líneas (Debe/Haber) para el número: ' . $numero);
            return false;
        }

        // Priorización:
        // - Para id_form=4 (Comprobante de Gasto), la cuenta presupuestada puede venir en HABER.
        // - Para otros orígenes, normalmente viene en DEBE.
        $id_form_global = (int)($lineas[0]->id_form ?? 0);
        $candidatasDebe = [];
        $candidatasHaber = [];
        foreach ($lineas as $ln) {
            if ((float)$ln->Debe > 0) {
                $candidatasDebe[] = $ln;
            }
            if ((float)$ln->Haber > 0) {
                $candidatasHaber[] = $ln;
            }
        }
        $candidatas = ($id_form_global === 4)
            ? array_merge($candidatasHaber, $candidatasDebe)
            : array_merge($candidatasDebe, $candidatasHaber);

        $linea_presupuestaria = null;
        $presupuesto = null;
        $monto = null;

        foreach ($candidatas as $ln) {
            $m = ((float)$ln->Debe > 0) ? (float)$ln->Debe : (float)$ln->Haber;

            if (!is_numeric($m) || $m <= 0) {
                continue;
            }

            if (empty($ln->IDCuentaContable) || empty($ln->id_of) || empty($ln->id_ff) || empty($ln->id_pro)) {
                continue;
            }

            // 2. Buscar el presupuesto asociado usando LAS 4 DIMENSIONES FINANCIERAS
            $this->db->select('ID_Presupuesto');
            $this->db->from('presupuestos');
            $this->db->where('Idcuentacontable', $ln->IDCuentaContable);
            $this->db->where('origen_de_financiamiento_id_of', $ln->id_of);
            $this->db->where('fuente_de_financiamiento_id_ff', $ln->id_ff);
            $this->db->where('programa_id_pro', $ln->id_pro);
            $pres = $this->db->get()->row();

            if ($pres) {
                $linea_presupuestaria = $ln;
                $presupuesto = $pres;
                $monto = $m;
                break;
            }
        }

        if (!$linea_presupuestaria || !$presupuesto) {
            log_message(
                'error',
                'No se encontró línea presupuestaria (mapeable a presupuesto) para el número: ' . $numero
            );
            return false;
        }

        log_message('debug', 'Línea presupuestaria encontrada - Cuenta: ' . $linea_presupuestaria->IDCuentaContable .
            ', Monto: ' . $monto . ', OF: ' . $linea_presupuestaria->id_of .
            ', FF: ' . $linea_presupuestaria->id_ff . ', PRO: ' . $linea_presupuestaria->id_pro .
            ', id_form: ' . $linea_presupuestaria->id_form);

        log_message('debug', 'Presupuesto encontrado - ID: ' . $presupuesto->ID_Presupuesto);

        // 3. Determinar el mes según la fecha de la línea
        $fecha_asiento = $linea_presupuestaria->creado_en ?? date('Y-m-d H:i:s');
        $mes = date('Y-m-01 00:00:00', strtotime($fecha_asiento));

        log_message('debug', 'Mes calculado: ' . $mes . ' desde fecha: ' . $fecha_asiento);

        // 4. Operación en ejecucion_mensual
        $this->db->where('id_presupuesto', $presupuesto->ID_Presupuesto);
        $this->db->where('mes', $mes);
        $query = $this->db->get('ejecucion_mensual');
        
        if ($query->num_rows() > 0) {
            // Actualizar registro existente
            if (in_array((int)$linea_presupuestaria->id_form, [1, 4], true)) {
                $field = 'obligado';
            } elseif ((int)$linea_presupuestaria->id_form === 2) {
                $field = 'pagado';
            } else {
                log_message('error', 'id_form no soportado para actualizarEjecucion: ' . $linea_presupuestaria->id_form);
                return false;
            }
            log_message('debug', 'UPDATE ejecucion_mensual - Campo: ' . $field . ', Incremento: ' . $monto);
            
            $this->db->set($field, "{$field} + {$monto}", false);
            $this->db->where('id_presupuesto', $presupuesto->ID_Presupuesto);
            $this->db->where('mes', $mes);
            $this->db->update('ejecucion_mensual');

            if ($this->db->affected_rows() === 0) {
                log_message('error', 'Falló la actualización en ejecucion_mensual');
                return false;
            }
            
            log_message('debug', 'UPDATE exitoso - Filas afectadas: ' . $this->db->affected_rows());
        } else {
            // Crear nuevo registro
            $data = [
                'id_presupuesto' => $presupuesto->ID_Presupuesto,
                'mes' => $mes,
                'obligado' => (in_array((int)$linea_presupuestaria->id_form, [1, 4], true)) ? $monto : 0,
                'pagado' => ((int)$linea_presupuestaria->id_form === 2) ? $monto : 0
            ];
            
            log_message('debug', 'INSERT ejecucion_mensual - Datos: ' . json_encode($data));
            
            $this->db->insert('ejecucion_mensual', $data);

            if ($this->db->affected_rows() === 0) {
                log_message('error', 'Falló la inserción en ejecucion_mensual');
                return false;
            }
            
            log_message('debug', 'INSERT exitoso - ID insertado: ' . $this->db->insert_id());
        }

        log_message('debug', '=== FIN actualizarEjecucion - ÉXITO ===');
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
