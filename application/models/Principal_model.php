<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Principal_model extends CI_Model {

    // Función para obtener los obligados por mes
    public function getCountObligadosMes($id_uni_respon_usu) {
        $this->db->select('COUNT(*) as num_obligados');
        $this->db->from('num_asi');
        $this->db->join('uni_respon_usu', 'num_asi.id_uni_respon_usu = uni_respon_usu.id_uni_respon_usu');
        $this->db->where('num_asi.estado_registro', '1');
        $this->db->where('num_asi.id_form', '1');
        $this->db->where('num_asi.op', '0');
        $this->db->where('uni_respon_usu.id_uni_respon_usu', $id_uni_respon_usu);
        $this->db->where('MONTH(num_asi.FechaEmision)', date('m')); // Filtrar por el mes actual
        $this->db->where('num_asi.SumaMonto != num_asi.MontoTotal'); // Agregar filtro para SumaMonto distinto de MontoTotal
    
        $resultados = $this->db->get();
        return $resultados->row()->num_obligados;
    }

    // Función para obtener los pagados por mes
    public function getCountPagadosMes($id_uni_respon_usu) {
        $this->db->select('COUNT(*) as num_pagados');
        $this->db->from('num_asi');
        $this->db->join('usuarios', 'num_asi.id_usuario_numasi = usuarios.id_user');
        $this->db->join('unidad_academica', 'unidad_academica.id_unidad = usuarios.id_unidad');
        $this->db->where('num_asi.estado_registro', '1');
        $this->db->where('num_asi.id_form', '2');
        $this->db->where('unidad_academica.id_unidad', $id_uni_respon_usu);
        $this->db->where('MONTH(num_asi.FechaEmision)', date('m')); // Filtrar por el mes actual
        $this->db->where('num_asi.SumaMonto != num_asi.MontoTotal'); // Agregar filtro para SumaMonto distinto de MontoTotal

        $resultados = $this->db->get();
        return $resultados->row()->num_pagados;
    }

    // Función para obtener el nombre del mes en español
    public function getMonthInSpanish($monthNumber) {
        $months = [
            1 => 'Enero', 
            2 => 'Febrero', 
            3 => 'Marzo', 
            4 => 'Abril', 
            5 => 'Mayo', 
            6 => 'Junio', 
            7 => 'Julio', 
            8 => 'Agosto', 
            9 => 'Septiembre', 
            10 => 'Octubre', 
            11 => 'Noviembre', 
            12 => 'Diciembre'
        ];
        return $months[$monthNumber];
    }
}
