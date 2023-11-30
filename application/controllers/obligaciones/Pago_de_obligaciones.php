<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pago_de_obligaciones extends CI_Controller {

	//private $permisos;
	public function __construct(){
		parent::__construct();
	//	$this->permisos= $this->backend_lib->control();
		$this->load->model("Proveedores_model");
		$this->load->model("ProgramGasto_model");
		$this->load->model("Pago_obli_model");
		$this->load->model("Diario_obli_model");
		$this->load->model("Usuarios_model");
		
	}
	
	
	public function index() {
		//Con la libreria Session traemos los datos del usuario
		//Obtenemos el nombre que nos va servir para obtener su id
		$nombre=$this->session->userdata('Nombre_usuario'); 

		//Con el método getUserIdByUserName en el modelo del usuario, nos devuelve el id
		//id conseguido mediante el nombre del usuario
		$id_user=$this->Usuarios_model->getUserIdByUserName($nombre);
		
		//Y finalmente, con el método getUserIdUniResponByUserId traemos el id_uni_respon_usu
		//esa id es importante para hacer las relaciones y registros por usuario
		$id_uni_respon_usu = $this->Usuarios_model->getUserIdUniResponByUserId($id_user);

		$data['asientos'] = $this->Pago_obli_model->obtener_asientos($id_uni_respon_usu);
		$data['proveedores'] = $this->Proveedores_model->getProveedores($id_uni_respon_usu);  // Obtener la lista de proveedores
		$data['programa'] = $this->Pago_obli_model->getProgramGastos($id_uni_respon_usu);
		$data['Obli'] = $this->Pago_obli_model->getDiarios_obli(); 
		$data['fuente_de_financiamiento'] = $this->Pago_obli_model->getFuentes($id_uni_respon_usu);  
		$data['origen_de_financiamiento'] = $this->Pago_obli_model->getOrigenes($id_uni_respon_usu);
		$data['cuentacontable'] = $this->Pago_obli_model->getCuentasContables($id_uni_respon_usu); 

        $this->load->view("layouts/header");
        $this->load->view("layouts/aside");
        $this->load->view("admin/pagoobli/pagobli_combined", $data);
        $this->load->view("layouts/footer");
		
    }

	public function pdfs(){
		$this->load->view("fpdf");

	}
    // public function get_proveedores() {
    //     $data  = array(
    //         'proveedores' => $this->Proveedores_model->getProveedores(),
	// 		'programa' => $this->Diario_obli_model->getProgramas(),
	// 		'fuente_de_financiamiento' => $this->Diario_obli_model->getFuentesFinanciamiento(),
	// 		'origen_de_financiamiento' => $this->Diario_obli_model->getOrigenesFinanciamiento(),
    //     );
    //     echo json_encode($data);
    // }
	
	public function add(){

		$nombre=$this->session->userdata('Nombre_usuario');
		$id_user=$this->Usuarios_model->getUserIdByUserName($nombre);
		$id_uni_respon_usu = $this->Usuarios_model->getUserIdUniResponByUserId($id_user);

		$data  = array(
			'proveedores' => $this->Proveedores_model->getProveedores($id_uni_respon_usu), // Agregar esta línea para obtener la lista de proveedores
			'programa' => $this->Pago_obli_model->getProgramGastos($id_uni_respon_usu),
			'fuente_de_financiamiento' => $this->Pago_obli_model->getFuentes($id_uni_respon_usu),
			'origen_de_financiamiento' => $this->Pago_obli_model->getOrigenes($id_uni_respon_usu),
			'cuentacontable' => $this->Pago_obli_model->getCuentaContable($id_uni_respon_usu),
			'asientos' => $this->Pago_obli_model->obtener_asientos($id_uni_respon_usu),
		);

		$this->load->view("layouts/header");
		$this->load->view("layouts/aside");
		$this->load->view("admin/pagoobli/pagobli_combined", $data);// Pasar los datos a la vista
		$this->load->view("layouts/footer");
	}


	

	public function store() {
		$nombre = $this->session->userdata('Nombre_usuario');
		$id_user = $this->Usuarios_model->getUserIdByUserName($nombre);
		$id_uni_respon_usu = $this->Usuarios_model->getUserIdUniResponByUserId($id_user);
		$ruc_id_provee = $this->input->post("ruc");
		$numero = $this->input->post("num_asi");
		$id_num_asi = $this->input->post("IDNum_Asi");
		$contabilidad = $this->input->post("contabilidad");
		$direccion = $this->input->post("direccion");
		$telefono = $this->input->post("telefono");
		$observacion = $this->input->post("observacion");
		$fecha = $this->input->post("fecha");
		$debe = floatval($this->input->post("Debe"));
		$haber_2 = floatval($this->input->post("Haber_2"));
		$tesoreria = $this->input->post("tesoreria");
		$comprobante = $this->input->post("comprobante");
		$cheque_id = $this->input->post("cheques_che_id");
		$programa_id_pro = $this->input->post("id_pro");
		$cuentacontable = $this->input->post("cuentacontable");
		$fuente_de_financiamiento = $this->input->post("id_ff");
		$origen_de_financiamiento = $this->input->post("id_of");
		$pedi_matricula = $this->input->post("pedi_matricula");
		$MontoPago = floatval($this->input->post("MontoPago"));
		$modalidad = $this->input->post("modalidad");
		$tipo_presupuesto = $this->input->post("tipo_presupuesto");
		$unidad_respon = $this->input->post("unidad_respon");
		$proyecto = $this->input->post("proyecto");
		$nro_pac = $this->input->post("nro_pac");
		$nro_exp = $this->input->post("nro_exp");
		$total = $this->input->post("total");
		$pagado = floatval($this->input->post("pagado"));
		$monto_pagado_acumulado = floatval($this->input->post('monto_pagado_acumulado'));
		$nuevo_monto_pago = floatval($this->input->post('MontoPago'));
	
		$proveedor_id = $this->Pago_obli_model->getProveedorIdByRuc($ruc_id_provee);
	
		$MontoTotal = floatval($this->Pago_obli_model->getMontoTotalByProveedorId($proveedor_id));
	
		$monto_pago_anterior = $this->Diario_obli_model->getMontoPagoAnterior($proveedor_id);
	
		$suma_monto = $nuevo_monto_pago + $monto_pago_anterior;
		$estado = $this->Diario_obli_model->obtenerEstadoSegunSumaMonto($proveedor_id);
		$op= $this->input->post("OP");
		$this->form_validation->set_rules("Debe_2", "debe_2", "required");
		$this->form_validation->set_rules("Haber_2", "haber_2", "required");
		$this->form_validation->set_rules('Debe', 'Debe', 'matches[Haber_2]', array('matches' => 'El campo Debe debe ser igual al campo Haber_2.'));


			
		if ($proveedor_id && $this->form_validation->run() == TRUE) {
			$dataNum_Asi = array(
				'FechaEmision' => $fecha,
				'ped_mat' => $pedi_matricula,
				'tipo_presu' => $tipo_presupuesto,
				'unidad_resp' => $unidad_respon,
				'num_asi' => $numero,
				'proyecto' => $proyecto,
				'nro_pac' => $nro_pac,
				'nro_exp' => $nro_exp,
				'id_provee' => $proveedor_id,
				'MontoPagado' => $nuevo_monto_pago,
				'SumaMonto' => $suma_monto,
				'MontoTotal' => $MontoTotal,
				'op'=>$op,
				'estado' => $estado,
				'id_uni_respon_usu' => $id_uni_respon_usu,
				'id_form' => "2",
				'estado_registro' => "1",
			);
	
				// Aquí deberías llamar a la función que obtiene $id_num_asi
				$id_num_asi = $this->Pago_obli_model->getIdNumAsiByProveedor($proveedor_id);
				
				$this->Diario_obli_model->updateSumaMonto($id_num_asi, $suma_monto, $proveedor_id, $numero);
			
			$lastInsertedId = $this->Diario_obli_model->save_num_asi($dataNum_Asi, $proveedor_id);
	
			if ($lastInsertedId) {
				$dataDetaDebe = array(
					'Num_Asi_IDNum_Asi' => $lastInsertedId,
					'MontoPago' => $haber_2,
					'Debe' => $debe,
					'numero' => $numero,
					'comprobante' => $comprobante,
					'id_of' => $origen_de_financiamiento,
					'id_pro' => $programa_id_pro,
					'id_ff' => $fuente_de_financiamiento,
					'IDCuentaContable' => $cuentacontable,
					'cheques_che_id' => $cheque_id,
					'proveedores_id' => $proveedor_id,
					'id_uni_respon_usu' => $id_uni_respon_usu,
					'id_form' => "2",
					'estado_registro' => "1",
				);
	
				if ($this->Diario_obli_model->saveDebe($dataDetaDebe)) {
					$dataDetaHaber = array(
						'Num_Asi_IDNum_Asi' => $lastInsertedId,
						'MontoPago' => $haber_2,
						'Haber' => $haber_2,
						'numero' => $numero,
						'comprobante' => $comprobante,
						'id_of' => $origen_de_financiamiento,
						'id_pro' => $programa_id_pro,
						'id_ff' => $fuente_de_financiamiento,
						'IDCuentaContable' => $cuentacontable,
						'cheques_che_id' => $cheque_id,
						'proveedores_id' => $proveedor_id,
						'id_uni_respon_usu' => $id_uni_respon_usu,
						'id_form' => "2",
						'estado_registro' => "1",
					);
	
					$this->Diario_obli_model->saveHaber($dataDetaHaber);
					$this->Diario_obli_model->updateMontoPagado($proveedor_id, $id_num_asi, $nuevo_monto_pago);
		
					return redirect(base_url() . "obligaciones/pago_de_obligaciones/add");
				}
			}
		} else {
			$this->add();
		}
	}
	

	



	public function edit($id_uni_respon_usu){
		
		$nombre=$this->session->userdata('Nombre_usuario');
		$id_user=$this->Usuarios_model->getUserIdByUserName($nombre);
		$id_uni_respon_usu = $this->Usuarios_model->getUserIdUniResponByUserId($id_user);

		$data  = array(
			'proveedores' => $this->Proveedores_model->getProveedores($id_uni_respon_usu), // Agregar esta línea para obtener la lista de proveedores
			'programa' => $this->Pago_obli_model->getProgramGastos($id_uni_respon_usu),
			'fuente_de_financiamiento' => $this->Pago_obli_model->getFuentes($id_uni_respon_usu),
			'origen_de_financiamiento' => $this->Pago_obli_model->getOrigenes($id_uni_respon_usu),
			'cuentacontable' => $this->Pago_obli_model->getCuentaContable($id_uni_respon_usu),
			'asientos' => $this->Pago_obli_model->obtener_asientos($id_uni_respon_usu),
		);
	}


	public function update(){
		$nombre = $this->session->userdata('Nombre_usuario');
		$id_user = $this->Usuarios_model->getUserIdByUserName($nombre);
		$id_uni_respon_usu = $this->Usuarios_model->getUserIdUniResponByUserId($id_user);
		$ruc_id_provee = $this->input->post("ruc");
		$numero = $this->input->post("num_asi");
		$id_num_asi = $this->input->post("IDNum_Asi");
		$contabilidad = $this->input->post("contabilidad");
		$direccion = $this->input->post("direccion");
		$telefono = $this->input->post("telefono");
		$observacion = $this->input->post("observacion");
		$fecha = $this->input->post("fecha");
		$debe = floatval($this->input->post("Debe"));
		$haber_2 = floatval($this->input->post("Haber_2"));
		$tesoreria = $this->input->post("tesoreria");
		$comprobante = $this->input->post("comprobante");
		$cheque_id = $this->input->post("cheques_che_id");
		$programa_id_pro = $this->input->post("id_pro");
		$cuentacontable = $this->input->post("cuentacontable");
		$fuente_de_financiamiento = $this->input->post("id_ff");
		$origen_de_financiamiento = $this->input->post("id_of");
		$pedi_matricula = $this->input->post("pedi_matricula");
		$MontoPago = floatval($this->input->post("MontoPago"));
		$modalidad = $this->input->post("modalidad");
		$tipo_presupuesto = $this->input->post("tipo_presupuesto");
		$unidad_respon = $this->input->post("unidad_respon");
		$proyecto = $this->input->post("proyecto");
		$nro_pac = $this->input->post("nro_pac");
		$nro_exp = $this->input->post("nro_exp");
		$total = $this->input->post("total");
		$pagado = floatval($this->input->post("pagado"));
		$monto_pagado_acumulado = floatval($this->input->post('monto_pagado_acumulado'));
		$nuevo_monto_pago = floatval($this->input->post('MontoPago'));
	
		$proveedor_id = $this->Pago_obli_model->getProveedorIdByRuc($ruc_id_provee);
	
		$MontoTotal = floatval($this->Pago_obli_model->getMontoTotalByProveedorId($proveedor_id));
	
		$monto_pago_anterior = $this->Diario_obli_model->getMontoPagoAnterior($proveedor_id);
	
		$suma_monto = $nuevo_monto_pago + $monto_pago_anterior;
		$estado = $this->Diario_obli_model->obtenerEstadoSegunSumaMonto($proveedor_id);
		$op= $this->input->post("OP");
		$this->form_validation->set_rules("Debe_2", "debe_2", "required");
		$this->form_validation->set_rules("Haber_2", "haber_2", "required");
		$this->form_validation->set_rules('Debe', 'Debe', 'matches[Haber_2]', array('matches' => 'El campo Debe debe ser igual al campo Haber_2.'));


			
		if ($proveedor_id && $this->form_validation->run() == TRUE) {
			$dataNum_Asi = array(
				'FechaEmision' => $fecha,
				'ped_mat' => $pedi_matricula,
				'tipo_presu' => $tipo_presupuesto,
				'unidad_resp' => $unidad_respon,
				'num_asi' => $numero,
				'proyecto' => $proyecto,
				'nro_pac' => $nro_pac,
				'nro_exp' => $nro_exp,
				'id_provee' => $proveedor_id,
				'MontoPagado' => $nuevo_monto_pago,
				'SumaMonto' => $suma_monto,
				'MontoTotal' => $MontoTotal,
				'op'=>$op,
				'estado' => $estado,
				'id_uni_respon_usu' => $id_uni_respon_usu,
				'id_form' => "2",
				'estado_registro' => "1",
			);
	
				// Aquí deberías llamar a la función que obtiene $id_num_asi
				$id_num_asi = $this->Pago_obli_model->getIdNumAsiByProveedor($proveedor_id);
				
				$this->Diario_obli_model->updateSumaMonto($id_num_asi, $suma_monto, $proveedor_id, $numero);
			
			$lastInsertedId = $this->Diario_obli_model->save_num_asi($dataNum_Asi, $proveedor_id);
	
			if ($lastInsertedId) {
				$dataDetaDebe = array(
					'Num_Asi_IDNum_Asi' => $lastInsertedId,
					'MontoPago' => $haber_2,
					'Debe' => $debe,
					'numero' => $numero,
					'comprobante' => $comprobante,
					'id_of' => $origen_de_financiamiento,
					'id_pro' => $programa_id_pro,
					'id_ff' => $fuente_de_financiamiento,
					'IDCuentaContable' => $cuentacontable,
					'cheques_che_id' => $cheque_id,
					'proveedores_id' => $proveedor_id,
					'id_uni_respon_usu' => $id_uni_respon_usu,
					'id_form' => "2",
					'estado_registro' => "1",
				);
	
				if ($this->Diario_obli_model->saveDebe($dataDetaDebe)) {
					$dataDetaHaber = array(
						'Num_Asi_IDNum_Asi' => $lastInsertedId,
						'MontoPago' => $haber_2,
						'Haber' => $haber_2,
						'numero' => $numero,
						'comprobante' => $comprobante,
						'id_of' => $origen_de_financiamiento,
						'id_pro' => $programa_id_pro,
						'id_ff' => $fuente_de_financiamiento,
						'IDCuentaContable' => $cuentacontable,
						'cheques_che_id' => $cheque_id,
						'proveedores_id' => $proveedor_id,
						'id_uni_respon_usu' => $id_uni_respon_usu,
						'id_form' => "2",
						'estado_registro' => "1",
					);
	
					$this->Diario_obli_model->saveHaber($dataDetaHaber);
					$this->Diario_obli_model->updateMontoPagado($proveedor_id, $id_num_asi, $nuevo_monto_pago);
		
					return redirect(base_url() . "obligaciones/pago_de_obligaciones/add");
				}
			}
		} else {
			$this->add();
		}
	}
 
		
		
	


	public function view($id){
		$data  = array(
			'obligaciones' => $this->Pago_obli_model->getDiario($id), 
		);
		$this->load->view("admin/pagoobli/pagobliview",$data);
	}

	public function delete($id){
		$data  = array(
			'estado_bd' => "0", 
		);
		$this->Pago_obli_model->update($id,$data);
		echo "obligaciones/pago_de_obligaciones";
	}
}