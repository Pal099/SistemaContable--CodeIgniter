
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pdf_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function obtenerDatos() {
        // Reemplaza 'nombre_de_la_tabla' con el nombre real de tu tabla en la base de datos
        $this->db->select('numero, comprobante, Debe, Haber'); // Selecciona las columnas que deseas recuperar
        $this->db->from('num_asi_deta'); // Nombre de la tabla
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->result_array(); // Devuelve un arreglo de resultados
        } else {
            return array(); // Si no hay resultados, devuelve un arreglo vacío
        }
    }
}
