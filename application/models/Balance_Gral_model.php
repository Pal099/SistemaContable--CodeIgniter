<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Balance_Gral_model extends CI_Model
{
	public function __construct() {
        $this->load->database();
    }
	public function getObtenerbalances($id_uni_respon_usu) {
		$this->db->select('num_asi_deta.*, cuentacontable.Codigo_CC, cuentacontable.Descripcion_CC, num_asi_deta.Debe, num_asi_deta.Haber');
		$this->db->from('num_asi_deta');
		$this->db->join('uni_respon_usu', 'num_asi_deta.id_uni_respon_usu = uni_respon_usu.id_uni_respon_usu');
		$this->db->join('cuentacontable', 'num_asi_deta.IDCuentaContable = cuentacontable.IDCuentaContable');
		$this->db->where('num_asi_deta.estado_registro', '1');
		$this->db->where('uni_respon_usu.id_uni_respon_usu', $id_uni_respon_usu);
		
		$resultados = $this->db->get();
		return $resultados->result();    
	}
	
}
