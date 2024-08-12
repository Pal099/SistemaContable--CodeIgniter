<?php
class Unidad_academica_model extends CI_Model {
    public function __construct() {
        parent::__construct();
    }

    public function obtener_unidades_academicas() {
        // Obtiene la lista de unidades académicas
        $query = $this->db->get('unidad_academica');
        return $query->result();
    }
}
?>
