<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class LibroMayor_model extends CI_Model {

    public function __construct() {
        $this->load->database();
    }
	public function obtener_asientos() {
        return $this->db->get('num_asi')->result_array();
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

public function obtener_asiento_por_numero($num_asi) {
    $this->db->where('num_asi', $num_asi);
    return $this->db->get('num_asi')->row_array();
}

public function obtener_origen_financiamiento($id_of) {
    $this->db->where('id_of', $id_of);
    return $this->db->get('origen_de_financiamiento')->row_array();
}

public function obtener_fuente_financiamiento($id_ff) {
    $this->db->where('id_ff', $id_ff);
    return $this->db->get('fuente_de_financiamiento')->row_array();
}

public function obtener_programa($id_pro) {
    $this->db->where('id_pro', $id_pro);
    return $this->db->get('programa')->row_array();
}

public function obtener_cuenta_contable($IDCuentaContable) {
    $this->db->where('IDCuentaContable', $IDCuentaContable);
    return $this->db->get('cuentacontable')->row_array();
}

public function obtener_presupuesto($IDCuentaContable) {
    $this->db->where('Idcuentacontable', $IDCuentaContable);
    return $this->db->get('presupuestos')->row_array();
}

public function obtener_suma_debe_cuenta($IDCuentaContable) {
    $this->db->select_sum('Debe', 'total_debe');
    $this->db->where('IDCuentaContable', $IDCuentaContable);
    $result = $this->db->get('num_asi_deta')->row_array();
    return $result['total_debe'];
}


	public function save_num_asi($data){
		return $this->db->insert("num_asi",$data);
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

	public function saveDebe($data){
		return $this->db->insert("num_asi_deta",$data);
	}

	public function saveHaber($data){
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

   
    public function getCuentasContables($id_uni_respon_usu){
        $this->db->select('cuentacontable.*');
		$this->db->from('cuentacontable');
		$this->db->join('uni_respon_usu', 'cuentacontable.id_uni_respon_usu = uni_respon_usu.id_uni_respon_usu');
		$this->db->where('cuentacontable.estado', '1');
		$this->db->where('uni_respon_usu.id_uni_respon_usu', $id_uni_respon_usu);
        $resultados = $this->db->get();
        return $resultados->result();
    }
	public function getPresupuestos($id_uni_respon_usu){
        $this->db->select('presupuestos.*');
		$this->db->from('presupuestos');
		$this->db->join('uni_respon_usu', 'presupuestos.id_uni_respon_usu = uni_respon_usu.id_uni_respon_usu');
		$this->db->where('presupuestos.estado', '1');
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

	public function getDiarios_obli() {
		$this->db->select('proveedores.id as id_provee, programa.nombre as nombre_programa, fuente_de_financiamiento.nombre as nombre_fuente, origen_de_financiamiento.nombre as nombre_origen, cuentacontable.CodigoCuentaContable as Codigocuentacontable ,cuentacontable.DescripcionCuentaContable as Desccuentacontable ,');		
		$this->db->from('num_asi_deta');
		$this->db->join('programa', 'num_asi_deta.id_pro = programa.id_pro', 'left');
		$this->db->join('fuente_de_financiamiento', 'num_asi_deta.id_ff = fuente_de_financiamiento.id_ff');
		$this->db->join('origen_de_financiamiento', 'num_asi_deta.id_of = origen_de_financiamiento.id_of');
		$this->db->join('cuentacontable', 'num_asi_deta.IDCuentaContable = cuentacontable.IDCuentaContable');
		$this->db->join('proveedores', 'num_asi_deta.proveedores_id = proveedores.id');
	
		$query = $this->db->get();
	}	

	public function obtener_usuario_por_id($id) {
        
		$query = $this->db->get_where('usuarios', array('id_user' => $id));
		return $query->row();
   }
   public function obtener_datos_asiento($numero_asiento = null) {
    $this->db->select('
        origen_de_financiamiento.nombre as nombre_origen,
        fuente_de_financiamiento.nombre as nombre_fuente,
        programa.nombre as nombre_programa,
        num_asi.num_asi as numero_asiento,
        num_asi_deta.Debe as debe_num_asi_deta,
        cuentacontable.Codigo_CC,
        cuentacontable.Descripcion_CC,
        presupuestos.pre_ene,
        presupuestos.pre_feb,
        presupuestos.pre_mar,
        presupuestos.pre_abr,
        presupuestos.pre_may,
        presupuestos.pre_jun,
        presupuestos.pre_jul,
        presupuestos.pre_ago,
        presupuestos.pre_sep,
        presupuestos.pre_oct,
        presupuestos.pre_nov,
        presupuestos.pre_dic,
        SUM(num_asi_deta.Debe) as total_debe_cuenta,
    ');

    $this->db->from('num_asi_deta');
    $this->db->join('origen_de_financiamiento', 'num_asi_deta.id_of = origen_de_financiamiento.id_of');
    $this->db->join('fuente_de_financiamiento', 'num_asi_deta.id_ff = fuente_de_financiamiento.id_ff');
    $this->db->join('programa', 'num_asi_deta.id_pro = programa.id_pro');
    $this->db->join('cuentacontable', 'num_asi_deta.IDCuentaContable = cuentacontable.IDCuentaContable');
    $this->db->join('presupuestos', 'cuentacontable.Idcuentacontable = presupuestos.Idcuentacontable');
    $this->db->join('num_asi', 'num_asi_deta.Num_Asi_IDNum_Asi = num_asi.IDNum_Asi');

    if ($numero_asiento) {
        $this->db->where('num_asi.num_asi', $numero_asiento);
    }

    $this->db->group_by('origen_de_financiamiento.nombre, fuente_de_financiamiento.nombre, programa.nombre, cuentacontable.Codigo_CC, cuentacontable.Descripcion_CC, num_asi.num_asi');

    return $this->db->get()->result_array();
}
    public function obtenerEntradasLibroMayor($fechaInicio, $fechaFin, $idCuentaContable = null, $terminoBusqueda = ''){
        $this->db->select("
            nad.IDNum_Asi_Deta,
            nad.numero,
            nad.IDCuentaContable,
            nad.MontoPago,
            nad.Debe,
            nad.Haber,
            nad.comprobante,
            na.FechaEmision,
            na.Num_Asi,
            na.MontoTotal,
            cc.Codigo_CC,
            cc.Descripcion_CC
        ");
        $this->db->from('num_asi_deta nad');
        $this->db->join('num_asi na', 'nad.Num_Asi_IDNum_Asi = na.IDNum_Asi', 'inner');
        $this->db->join('cuentacontable cc', 'nad.IDCuentaContable = cc.IDCuentaContable', 'inner');
        $this->db->where('na.FechaEmision >=', $fechaInicio);
        $this->db->where('na.FechaEmision <=', $fechaFin);

        if ($idCuentaContable !== null) {
            $this->db->where('nad.IDCuentaContable', $idCuentaContable);
        }

        if (!empty($terminoBusqueda)) {
            $this->db->group_start();
            $this->db->like('cc.Codigo_CC', $terminoBusqueda);
            $this->db->or_like('cc.Descripcion_CC', $terminoBusqueda);
            $this->db->group_end();
        }

        $this->db->where('na.estado', 1); // Asumiendo que 1 representa 'activo'
        $this->db->where('nad.estado_registro', 1); // Asumiendo que 1 representa 'activo'

        $query = $this->db->get();
        return $query->result_array();
    }
    public function obtenerEntradasPorCuentaContable($idCuentaContable) {
        // Asumiendo que tienes una columna 'IDCuentaContable' en tu tabla 'num_asi_deta'
        $this->db->where('IDCuentaContable', $idCuentaContable);
        $query = $this->db->get('num_asi_deta');
        return $query->result_array();
    }
    
    // Otros métodos relacionados con el Libro Mayor podrían ir aquí

}
