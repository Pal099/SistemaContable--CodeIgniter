<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pago_obli_model extends CI_Model
{public function __construct() {
	$this->load->database();
}
public function obtener_asientos($id_uni_respon_usu) {
	$this->db->select('num_asi_deta.*, programa.nombre as nombre_programa, num_asi.op as op,num_asi.concepto as concepto, num_asi.SumaMonto as suma_monto,num_asi.Montototal as total,
	 	num_asi.num_asi as nume, num_asi.estado as estado, num_asi.FechaEmision as fecha,num_asi.IDNum_Asi as id_numasi,num_asi.MontoTotal as total, num_asi.id_provee as provee,
		num_asi.MontoPagado as pagado, num_asi.op as op, proveedores.ruc as ruc_proveedor,proveedores.direccion as direccion_proveedor, proveedores.razon_social as razso_proveedor,
	 	fuente_de_financiamiento.nombre as nombre_fuente, origen_de_financiamiento.nombre as nombre_origen, cuentacontable.Codigo_CC as codigo, cuentacontable.IDCuentaContable as idcuenta,
		cuentacontable.Descripcion_CC as descrip ');
	$this->db->from('num_asi_deta');
	$this->db->join('programa', 'num_asi_deta.id_pro = programa.id_pro');
	$this->db->join('fuente_de_financiamiento', 'num_asi_deta.id_ff = fuente_de_financiamiento.id_ff');
	$this->db->join('origen_de_financiamiento', 'num_asi_deta.id_of = origen_de_financiamiento.id_of');
	$this->db->join('proveedores', 'num_asi_deta.proveedores_id = proveedores.id');
	$this->db->join('cuentacontable', 'num_asi_deta.IDCuentaContable = cuentacontable.IDCuentaContable');
	$this->db->join('num_asi', 'num_asi_deta.Num_Asi_IDNum_Asi = num_asi.IDNum_Asi');
	$this->db->join('uni_respon_usu', 'num_asi_deta.id_uni_respon_usu = uni_respon_usu.id_uni_respon_usu');
	$this->db->where('num_asi.MontoPagado < num_asi.MontoTotal');
	$this->db->where('num_asi_deta.estado_registro', '1');
	$this->db->where('uni_respon_usu.id_uni_respon_usu', $id_uni_respon_usu);
	
	$resultados = $this->db->get();
	return $resultados->result();    

}
public function GETasientos($id_uni_respon_usu) {
	$this->db->select('IDNum_Asi, FechaEmision, num_asi, op, estado');
	$this->db->where('estado_registro', '1');
	$this->db->where('id_form', '2');
	$this->db->join('uni_respon_usu', 'num_asi.id_uni_respon_usu = uni_respon_usu.id_uni_respon_usu');
	$this->db->where('uni_respon_usu.id_uni_respon_usu', $id_uni_respon_usu);
	$resultados = $this->db->get('num_asi');
	return $resultados->result();
}
public function guardarNuevoRegistro() {
	// Conexión a la base de datos (asegúrate de tenerla configurada)
	$this->load->database();

	// Obtener el número de operación actual (max + 1)
	$this->db->select_max('op');

	$query = $this->db->get('num_asi');
	$this->db->join('proveedores', 'proveedores.id = num_asi.id_provee');

	$op_actual = $query->row()->op;

	// Insertar un nuevo registro con el número de operación autoincremental
	$data = array(
		'op' => $op_actual + 1,
		// Agrega otras columnas según tus necesidades
	);
	$this->db->insert('num_asi', $data);

	// Devolver el nuevo número de operación
	return $op_actual + 1;
}

public function getIdNumAsiByProveedor($id_proveedor) {
	$this->db->select('IDNum_Asi');
	$this->db->where('id_provee', $id_proveedor);
	$query = $this->db->get('num_asi');

	if ($query->num_rows() > 0) {
		return $query->row()->IDNum_Asi;
	} else {
		return null; // O cualquier valor predeterminado si no hay registros que cumplan con las condiciones
	}
}


public function obtenerIdFormIdProveedor($id_proveedor)
{
	$this->db->select('id_form, id_provee');
	$this->db->from('num_asi');
	$this->db->where('id_form', 1);
	$this->db->where('id_provee', $id_proveedor);

	$query = $this->db->get();

	if ($query->num_rows() > 0) {
		return $query->row_array(); // Retorna el resultado como un array asociativo
	} else {
		return array(); // Retorna un array vacío si no hay resultados
	}
}



public function getOpAnterior($proveedor_id) {
	$this->db->select('op');
	$this->db->where('id_provee', $proveedor_id);
	$query = $this->db->get('num_asi');

	if ($query->num_rows() > 0) {
		$result = $query->row();
		return $result->op;
	} else {
		return 0; // Retorna 0 si no hay registros anteriores para ese proveedor
	}
}
public function getMontoTotalByProveedorId($proveedor_id) {
	// Supongamos que tienes una tabla llamada 'diario_obligaciones' con un campo 'MontoTotal'
	$this->db->select('MontoTotal');
	$this->db->from('num_asi');
	$this->db->where('id_provee', $proveedor_id);
	$this->db->order_by('FechaEmision', 'DESC'); // Ordenar por tiempo o ID en orden descendente
	$this->db->limit(1); // Obtener solo el resultado superior
	$query = $this->db->get();

	if ($query->num_rows() > 0) {
		$row = $query->row();
		return $row->MontoTotal;
	}

	return 0; // o el valor predeterminado que desees si no se encuentra ninguna entrada para el proveedor
}

public function obtener_asiento_por_id($id) {
	$this->db->where('IDNum_Asi', $id);
	return $this->db->get('num_asi')->row_array();
}
public function insertar_asiento($data) {
	return $this->db->insert('num_asi', $data);
}
public function actualizar_asiento($id, $data) {
	$this->db->where('IDNum_Asi', $id);
	return $this->db->update('num_asi', $data);
}
public function eliminar_asiento($id) {
	$this->db->where('IDNum_Asi', $id);
	return $this->db->delete('num_asi');
}





// num asi deta segundo
public function obtener_detalles_por_asiento($idAsiento) {
	$this->db->where('Num_Asi_IDNum_Asi', $idAsiento);
	return $this->db->get('num_asi_deta')->result_array();
}

public function obtener_detalle_por_id($idDetalle) {
	$this->db->where('IDNum_Asi_Deta', $idDetalle);
	return $this->db->get('num_asi_deta')->row_array();
}

public function insertar_detalle($data) {
	return $this->db->insert('num_asi_deta', $data);
}

public function actualizar_detalle($idDetalle, $data) {
	$this->db->where('IDNum_Asi_Deta', $idDetalle);
	return $this->db->update('num_asi_deta', $data);
}

public function eliminar_detalle($idDetalle) {
	$this->db->where('IDNum_Asi_Deta', $idDetalle);
	return $this->db->delete('num_asi_deta');
}

//desde acá es código de palo

public function getProveedorIdByRuc($ruc) {
$this->db->select('id'); 
$this->db->where('ruc', $ruc);
$query = $this->db->get('proveedores'); 

if ($query->num_rows() > 0) {
	$row = $query->row();
	return $row->id; 
} else {
	return false; 
}
}

public function getUsuarioId($nombre){
$nombre = $this->session->userdata("Nombre_usuario");
$this->db->select('id_user'); 
$this->db->where('Nombre_usuario', $nombre);
$query = $this->db->get('usuarios'); 

if ($query->num_rows() > 0) {
	$row = $query->row();
	return $row->id_user; 
} else {
	return false; 
}

}


public function getDiarios(){
	$this->db->where("estado","1");
	$resultados = $this->db->get("proveedores");
	return $resultados->result();
}

public function save($data){
	return $this->db->insert("num_asi_deta",$data);
}


public function getDiario($id){
	$this->db->where("id",$id);
	$resultado = $this->db->get("proveedores");
	return $resultado->row();

}

public function update($id,$data){
	$this->db->where("id",$id);
	return $this->db->update("proveedores",$data);
}

public function getProgramGastos($id_uni_respon_usu) {
	$this->db->select('programa.*');
	$this->db->from('programa');
	$this->db->join('uni_respon_usu', 'programa.id_uni_respon_usu = uni_respon_usu.id_uni_respon_usu');
	$this->db->where('programa.estado', '1');
	$this->db->where('uni_respon_usu.id_uni_respon_usu', $id_uni_respon_usu);
	
	$resultados = $this->db->get();
	return $resultados->result();
}

public function getFuentes($id_uni_respon_usu) {
	$this->db->select('fuente_de_financiamiento.*');
	$this->db->from('fuente_de_financiamiento');
	$this->db->join('uni_respon_usu', 'fuente_de_financiamiento.id_uni_respon_usu = uni_respon_usu.id_uni_respon_usu');
	$this->db->where('fuente_de_financiamiento.estado', '1');
	$this->db->where('uni_respon_usu.id_uni_respon_usu', $id_uni_respon_usu);
	$resultados = $this->db->get();
	return $resultados->result();
}

public function getOrigenes($id_uni_respon_usu) {
	$this->db->select('origen_de_financiamiento.*');
	$this->db->from('origen_de_financiamiento');
	$this->db->join('uni_respon_usu', 'origen_de_financiamiento.id_uni_respon_usu = uni_respon_usu.id_uni_respon_usu');
	$this->db->where('origen_de_financiamiento.estado', '1');
	$this->db->where('uni_respon_usu.id_uni_respon_usu', $id_uni_respon_usu);
	
	$resultados = $this->db->get();
	return $resultados->result();
}

public function getCuentasContables(){
	$this->db->select('cuentacontable.*');
	$this->db->from('cuentacontable');
	$this->db->join('uni_respon_usu', 'cuentacontable.id_uni_respon_usu = uni_respon_usu.id_uni_respon_usu');
	$this->db->where('cuentacontable.estado', '1');
	$this->db->where('uni_respon_usu.id_uni_respon_usu', $id_uni_respon_usu);
	$resultados = $this->db->get();
	return $resultados->result();
}




//guardar asientos
public function guardar_asiento($data, $dataDetaDebe, $dataDetaHaber) {
	$this->db->trans_start();  // Iniciar transacción

	$this->db->insert('num_asi', $data);  
	$this->db->insert('num_asi_deta', $dataDetaDebe); 
	$this->db->insert('num_asi_deta', $dataDetaHaber);  

	$this->db->trans_complete();  // Completar transacción

	return $this->db->trans_status();  // Devuelve TRUE si todo está OK o FALSE si hay algún fallo
}

public function getCuentaContable() {
	$query = $this->db->get("cuentacontable");
	return $query->result();
}

public function getCuentaContableN($descripcion) {
    $this->db->where('Descripcion_CC', $descripcion);
    $resultados = $this->db->get('cuentacontable')->row_array();
    return $resultados;
}

public function getDiarios_obli($id_uni_respon_usu)
{
	$this->db->select('num_asi_deta.*, programa.nombre as nombre_programa,num_asi.FechaEmision as fecha, proveedores.ruc as ruc_proveedor, proveedores.razon_social as razso_proveedor, fuente_de_financiamiento.nombre as nombre_fuente, origen_de_financiamiento.nombre as nombre_origen');
	$this->db->from('num_asi_deta');
	$this->db->join('uni_respon_usu', 'programa.id_uni_respon_usu = uni_respon_usu.id_uni_respon_usu');
	$this->db->join('programa', 'num_asi_deta.id_pro = programa.id_pro');
	$this->db->join('fuente_de_financiamiento', 'num_asi_deta.id_ff = fuente_de_financiamiento.id_ff');
	$this->db->join('origen_de_financiamiento', 'num_asi_deta.id_of = origen_de_financiamiento.id_of');
	$this->db->join('proveedores', 'num_asi_deta.proveedores_id = proveedores.id');
	$this->db->join('num_asi', 'num_asi_deta.Num_Asi_IDNum_Asi = num_asi.IDNum_Asi');

	$query = $this->db->get();
	if (!$query) {
		die("Database query error: " . $this->db->error());
	}
	$results = $query->result();


	return $results;
}

public function obtener_usuario_por_id($id)
{

	$query = $this->db->get_where('usuarios', array('id_user' => $id));
	return $query->row();
}

}
