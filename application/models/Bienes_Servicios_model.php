<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Bienes_Servicios_model extends CI_Model {

	public function getBienesServicios($id_uni_respon_usu) {
		$this->db->select('bienes_servicios.*');
		$this->db->from('bienes_servicios');
		$this->db->join('uni_respon_usu', 'bienes_servicios.id_uni_respon_usu = uni_respon_usu.id_uni_respon_usu');
		$this->db->where('bienes_servicios.estado', '1');
		$this->db->where('uni_respon_usu.id_uni_respon_usu', $id_uni_respon_usu);
		
		$resultados = $this->db->get();
		return $resultados->result();
	}
	

	
	public function save($data) {
	
		return $this->db->insert('bienes_servicios', $data);
	}
	
	
    
	public function getBienServicio($id){
		$this->db->where("IDbienservicio",$id);
		$resultado = $this->db->get("bienes_servicios");
		return $resultado->row();

	}
 
	public function update($id,$data){
		$this->db->where("IDbienservicio",$id);
		return $this->db->update("bienes_servicios",$data);
	}
}
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Bienes_Servicios_model extends CI_Model {

	public function getBienesServicios($id_uni_respon_usu) {
		$this->db->select('bienes_servicios.*');
		$this->db->from('bienes_servicios');
		$this->db->join('uni_respon_usu', 'bienes_servicios.id_uni_respon_usu = uni_respon_usu.id_uni_respon_usu');
		$this->db->where('bienes_servicios.estado', '1');
		$this->db->where('uni_respon_usu.id_uni_respon_usu', $id_uni_respon_usu);
		
		$resultados = $this->db->get();
		return $resultados->result();
	}
	

	
	public function save($data) {
	
		return $this->db->insert('bienes_servicios', $data);
	}
	
	
    
	public function getBienServicio($id){
		$this->db->where("IDbienservicio",$id);
		$resultado = $this->db->get("bienes_servicios");
		return $resultado->row();

	}
 
	public function update($id,$data){
		$this->db->where("IDbienservicio",$id);
		return $this->db->update("bienes_servicios",$data);
	}
}
