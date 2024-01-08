<?php
defined('BASEPATH') or exit('No direct script access allowed');

class EjecucionP_model extends CI_Model {

	public function getEjecucionesP($id_uni_respon_usu){
		$this->db->select("ep.*, p.ID_presupuesto as presupuesto, cc.IDCuentaContable as cuentacontable");
		$this->db->from("ejecucionpresupuestaria ep");
		$this->db->join("presupuestos p", "ep.presupuesto_ID_Presupuesto = p.ID_presupuesto");
		$this->db->join("cuentacontable cc", "ep.IDCuentaContable = cc.IDCuentaContable");
		$this->db->join('uni_respon_usu', 'ep.id_uni_respon_usu = uni_respon_usu.id_uni_respon_usu');
		$this->db->where('uni_respon_usu.id_uni_respon_usu', $id_uni_respon_usu);
		$resultados = $this->db->get();
		return $resultados->result();
	}



	public function save($data)
	{
		return $this->db->insert("ejecucionpresupuestaria", $data);
	}

	public function getEjecucionP($id)
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

	public function getMontoEjecutadoMesAnterior($id_uni_respon_usu, $año, $mesActual)
	{
		// Lógica para obtener el MontoEjecutado del mes anterior
		$mesAnterior = obtenerMesAnterior($mesActual);

		// Ajusta esto según tu estructura de base de datos
		$this->db->select('MontoEjecutado');
		$this->db->where('id_uni_respon_usu', $id_uni_respon_usu);
		$this->db->where('año', $año);
		$this->db->where('mes', $mesAnterior);

		$query = $this->db->get('ejecucionpresupuestaria');

		if ($query->num_rows() > 0) {
			$row = $query->row();
			return $row->MontoEjecutado;
		} else {
			return 0; // Puedes ajustar esto según tus necesidades
		}
	}
	private function obtenerMesAnterior($mesActual) {
        $meses = array('ene', 'feb', 'mar', 'abr', 'may', 'jun', 'jul', 'ago', 'sep', 'oct', 'nov', 'dic');
        $indexMesActual = array_search($mesActual, $meses);

        // Manejar el caso de enero
        $indexMesAnterior = ($indexMesActual - 1 + 12) % 12;

        return $meses[$indexMesAnterior];
    }
}