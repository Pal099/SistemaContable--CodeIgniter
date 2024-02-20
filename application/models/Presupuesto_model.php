<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Presupuesto_model extends CI_Model
{



	public function getPresu($id_uni_respon_usu)
	{
		$this->db->select('pre.*, c.Descripcion_CC as descripcion, ff.nombre as fuente_de_financiamiento, of.nombre as origen_de_financiamiento, pr.nombre as programa');
		$this->db->from('presupuestos pre');
		$this->db->join("fuente_de_financiamiento ff", "pre.fuente_de_financiamiento_id_ff = ff.id_ff");
		$this->db->join("origen_de_financiamiento of", "pre.origen_de_financiamiento_id_of = of.id_of");
		$this->db->join("programa pr", "pre.programa_id_pro = pr.id_pro");
		$this->db->join("cuentacontable c", "pre.IDCUENTACONTABLE = c.IDCuentaContable");
		$this->db->join('uni_respon_usu', 'pre.id_uni_respon_usu = uni_respon_usu.id_uni_respon_usu');
		$this->db->where('pre.estado', '1');
		$this->db->where('uni_respon_usu.id_uni_respon_usu', $id_uni_respon_usu);

		$resultados = $this->db->get();
		return $resultados->result();
	}




	public function save($data)
	{
		return $this->db->insert("presupuestos", $data);
	}

	public function getPresupuesto($id)
	{
		$this->db->where("ID_Presupuesto", $id);
		$resultado = $this->db->get("presupuestos");
		return $resultado->row();

	}

	public function update($id, $data)
	{
		$this->db->where("id_presupuesto", $id);
		return $this->db->update("presupuestos", $data);
	}
	public function sumarDebePorMes($mes, $idCuentaContable, $idOf, $idFf, $idPro) {
		$this->db->select('MONTH(na.FechaEmision) as mes, SUM(nad.Debe) as suma_debe');
		$this->db->from('num_asi_deta as nad');
		$this->db->join('num_asi as na', 'nad.Num_Asi_IDNum_Asi = na.IDNum_Asi');
		$this->db->where('MONTH(na.FechaEmision)', $mes);
		$this->db->where('nad.IDCuentaContable', $idCuentaContable);
		$this->db->where('nad.id_of', $idOf);
		$this->db->where('nad.id_ff', $idFf);
		$this->db->where('nad.id_pro', $idPro);
		$this->db->group_by('MONTH(na.FechaEmision)');
	
		$query = $this->db->get();
		return $query->result();
	}
	public function obtenerDatosPresupuestoAnterior($idOf, $idFf, $idPro, $idCuentaContable, $mesActual) {
		// Calculamos el mes anterior al mes actual
		$mesAnterior = $mesActual - 1;
		if ($mesAnterior < 1) {
			$mesAnterior = 12;
		}
	
		// Buscamos el presupuesto correspondiente al mes anterior
		$this->db->select('pre_ene, pre_feb, pre_mar, pre_abr, pre_may, pre_jun, pre_jul, pre_ago, pre_sep, pre_oct, pre_nov, pre_dic');
		$this->db->from('presupuestos');
		$this->db->where('origen_de_financiamiento_id_of', $idOf);
		$this->db->where('fuente_de_financiamiento_id_ff', $idFf);
		$this->db->where('programa_id_pro', $idPro);
		$this->db->where('Idcuentacontable', $idCuentaContable);
		$this->db->where('estado', '1');
		$query = $this->db->get();
		$resultado = $query->row();
	
		// Obtenemos el valor correspondiente al mes anterior
		$valorMesAnterior = $resultado->{'pre_' . $this->obtenerNombreMes($mesAnterior)};
		
		return $valorMesAnterior;
	}
	
	private function obtenerNombreMes($numeroMes) {
		// Array con los nombres de los meses
		$nombresMeses = array(
			1 => 'ene', 2 => 'feb', 3 => 'mar', 4 => 'abr',
			5 => 'may', 6 => 'jun', 7 => 'jul', 8 => 'ago',
			9 => 'sep', 10 => 'oct', 11 => 'nov', 12 => 'dic'
		);
		// Retornamos el nombre del mes correspondiente al número
		return $nombresMeses[$numeroMes];
	}
	
	
	
}