<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<?php
defined('BASEPATH') or exit('No direct script access allowed');


class Pago_de_obligaciones extends CI_Controller
{

	//private $permisos;
	public function __construct()
	{
		parent::__construct();
		//	$this->permisos= $this->backend_lib->control();
		$this->load->model("Proveedores_model");
		$this->load->model("ProgramGasto_model");
		$this->load->model("Pago_obli_model");
		$this->load->model("Diario_obli_model");
		$this->load->model("Cdp_model");
		$this->load->model("Usuarios_model");
		$this->load->model("movimientos_editar/Editar_Movimientos_model");

	}


	public function index()
	{
		//Con la libreria Session traemos los datos del usuario
		//Obtenemos el nombre que nos va servir para obtener su id
		$nombre = $this->session->userdata('Nombre_usuario');

		//Con el método getUserIdByUserName en el modelo del usuario, nos devuelve el id
		//id conseguido mediante el nombre del usuario
		$id_user = $this->Usuarios_model->getUserIdByUserName($nombre);

		//Y finalmente, con el método getUserIdUniResponByUserId traemos el id_uni_respon_usu
		//esa id es importante para hacer las relaciones y registros por usuario
		$id_uni_respon_usu = $this->Usuarios_model->getUserIdUniResponByUserId($id_user);

		 // Obtener datos de asiento por búsqueda
		 $numero_asiento = obtener_numero_asiento(); // Debes proporcionar una forma de obtener el número de asiento
		 $data['dato_saldo'] = $this->Cdp_model->obtener_datos_asiento($numero_asiento); // Obtener saldo presupuestario
	 

		$data['asientos'] = $this->Diario_obli_model->GETasientos($id_uni_respon_usu); // Obtener la lista de asientos
		$data['proveedores'] = $this->Proveedores_model->getProveedores($id_uni_respon_usu);  // Obtener la lista de proveedores
		$data['programa'] = $this->Pago_obli_model->getProgramGastos($id_uni_respon_usu);
		$data['Obli'] = $this->Pago_obli_model->getDiarios_obli();
		$data['fuente_de_financiamiento'] = $this->Pago_obli_model->getFuentes($id_uni_respon_usu);
		$data['origen_de_financiamiento'] = $this->Pago_obli_model->getOrigenes($id_uni_respon_usu);
		$data['cuentacontable'] = $this->Pago_obli_model->getCuentasContables($id_uni_respon_usu);


		$this->load->view("layouts/header");
		$this->load->view("layouts/sideBar");
		$this->load->view("admin/pagoobli/pagobli_combined", $data);
		$this->load->view("layouts/footer");

	}

	public function pdfs_pago() //Para el ultimo obligado
	{
		$this->load->view("fpdf_pago");

	}

	
	

	public function add()
	{
				// Obtener datos de asiento por búsqueda
				$numero_asiento = $this->input->get('numero_asiento');
				$data_saldo['dato_saldo'] = $this->Cdp_model->obtener_datos_asiento($numero_asiento); // Obtener saldo presupuestario

		$nombre = $this->session->userdata('Nombre_usuario');
		$id_user = $this->Usuarios_model->getUserIdByUserName($nombre);
		$id_uni_respon_usu = $this->Usuarios_model->getUserIdUniResponByUserId($id_user);

		$data = array(
			'proveedores' => $this->Proveedores_model->getProveedores($id_uni_respon_usu), // Agregar esta línea para obtener la lista de proveedores
			'programa' => $this->Pago_obli_model->getProgramGastos($id_uni_respon_usu),
			'fuente_de_financiamiento' => $this->Pago_obli_model->getFuentes($id_uni_respon_usu),
			'origen_de_financiamiento' => $this->Pago_obli_model->getOrigenes($id_uni_respon_usu),
			'cuentacontable' => $this->Pago_obli_model->getCuentaContable($id_uni_respon_usu), //Aqui trabajamos con la columna ingr_egr, valor I
			'cuentacontable_E' => $this->Pago_obli_model->getCuenta_Contable($id_uni_respon_usu),
			'asientos' => $this->Pago_obli_model->obtener_asientos($id_uni_respon_usu),
			'asiento' => $this->Pago_obli_model->GETasientos($id_uni_respon_usu),
		);

		$this->load->view("layouts/header");
		$this->load->view("layouts/sideBar");
		$this->load->view("admin/pagoobli/pagobli_combined", $data); // Pasar los datos a la vista
		$this->load->view("layouts/footer");
	}

	public function pdfs_pago_num_asi($numero_asiento) //Por numero de asiento
	{
		// Puedes usar $numero_asiento en tu lógica de la vista
		$data['numero_asiento'] = $numero_asiento;
	
		$this->load->view("Pdf_pago_num_asi/pdf_pago_obli_num_asi", $data);
	}

	public function store()
	{
		header('Access-Control-Allow-Origin: *');
		$datosCompletos = $this->input->post('datos');
		$datosFormulario = $datosCompletos['datosFormulario'];
		var_dump($datosFormulario);

		$nombre = $this->session->userdata('Nombre_usuario');
		$id_user = $this->Usuarios_model->getUserIdByUserName($nombre);
		$id_uni_respon_usu = $this->Usuarios_model->getUserIdUniResponByUserId($id_user);
		$op = $datosFormulario['op'];
		$ruc_id_provee = $datosFormulario['ruc'];
		$numero = $datosFormulario['num_asi'];
		$id_num_asi = $datosFormulario['idnumasi'];
		$contabilidad = $datosFormulario['contabilidad'];
		$direccion = $datosFormulario['direccion'];
		$telefono = $datosFormulario['telefono'];
		$concepto = $datosFormulario['concepto'];
		$fecha = $datosFormulario['fecha'];
		$detalles = $datosFormulario['detalles'];
		$debe = floatval($datosFormulario['Debe']);
		$haber_2 = floatval($datosFormulario['Haber']);
		$tesoreria = $datosFormulario['tesoreria'];
		$comprobante = $datosFormulario['comprobante'];
		$cheque_id = $datosFormulario['cheques_che_id'];
		$programa_id_pro = $datosFormulario['id_pro'];
		$cuentacontable = $datosFormulario['IDCuentaContable'];
		$fuente_de_financiamiento = $datosFormulario['id_ff'];
		$origen_de_financiamiento = $datosFormulario['id_of'];

		//-----------------//---------------------------
		$pedi_matricula = $this->input->post("pedi_matricula");
		$MontoPago = $datosFormulario['MontoPago'];
		$modalidad = $this->input->post("modalidad");
		$tipo_presupuesto = $this->input->post("tipo_presupuesto");
		$unidad_respon = $this->input->post("unidad_respon");
		$proyecto = $this->input->post("proyecto");
		$nro_pac = $this->input->post("nro_pac");
		$nro_exp = $this->input->post("nro_exp");
		$total = $this->input->post("total");
		$pagado = floatval($this->input->post("pagado"));
		$monto_pagado_acumulado = floatval($this->input->post('monto_pagado_acumulado'));
		$nuevo_monto_pago = $debe;
		$proveedor_id = $this->Pago_obli_model->getProveedorIdByRuc($ruc_id_provee);

		$MontoTotal = floatval($this->Pago_obli_model->getMontoTotalByProveedorId($proveedor_id));

		$monto_pago_anterior = $this->Diario_obli_model->getMontoPagoAnterior($proveedor_id);

		$suma_monto = $nuevo_monto_pago + $monto_pago_anterior;
		$estado = $this->Diario_obli_model->obtenerEstadoSegunSumaMonto($proveedor_id);


		if ($proveedor_id) {
			//if ($this->form_validation->run() == TRUE) {

			$dataNum_Asi = array(
				'FechaEmision' => $fecha,
				'concepto' => $concepto,
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
				'op' => $op,
				'estado' => $estado,
				'id_uni_respon_usu' => $id_uni_respon_usu,
				'id_form' => "2",
				'estado_registro' => "1",
			);
			

			$this->Diario_obli_model->updateSumaMonto($id_num_asi, $suma_monto, $proveedor_id);

			$lastInsertedId = $this->Diario_obli_model->save_num_asi($dataNum_Asi, $proveedor_id);

			if ($lastInsertedId) {

				$dataDetaDebe = array(
					'Num_Asi_IDNum_Asi' => $lastInsertedId,
					'MontoPago' => $MontoPago,
					'Debe' => $debe,
					'numero' => $numero,
					'comprobante' => $comprobante,
					'id_of' => $origen_de_financiamiento,
					'id_pro' => $programa_id_pro,
					'id_ff' => $fuente_de_financiamiento,
					'IDCuentaContable' => $cuentacontable,
					'detalles' => $detalles,
					'cheques_che_id' => $cheque_id,
					'proveedores_id' => $proveedor_id,
					'id_uni_respon_usu' => $id_uni_respon_usu,
					'id_form' => "2",
					'estado_registro' => "1",
				);


				if ($this->input->is_ajax_request()) {

					$datosFormulario = $datosCompletos['filas'];
					$filas = $datosCompletos['filas'];
					if ($this->Diario_obli_model->saveDebe($dataDetaDebe)) {
						foreach ($filas as $fila) {
							// Ejemplo de cómo podrías procesar una fila
							$dataDetaHaber = array(
								'Num_Asi_IDNum_Asi' => $lastInsertedId,
								'MontoPago' => $fila['Haber'], // Ajusta el nombre según tus datos
								'Haber' => $fila['Haber'],
								'detalles' => $fila['detalles'],
								'numero' => $numero,
								'comprobante' => $fila['comprobante'],
								'id_of' => $fila['id_of'],
								'id_pro' => $fila['id_pro'],
								'id_ff' => $fila['id_ff'],
								'IDCuentaContable' => $fila['IDCuentaContable'],
								'cheques_che_id' => $fila['cheques_che_id'],
								'proveedores_id' => $proveedor_id,
								'id_uni_respon_usu' => $id_uni_respon_usu,
								'id_form' => "2",
								'estado_registro' => "1",
							);

							$this->Diario_obli_model->saveHaber($dataDetaHaber);
							$this->Diario_obli_model->updateMontoPagado($proveedor_id, $id_num_asi, $nuevo_monto_pago);

						}

					}

					return redirect(base_url() . "obligaciones/pago_de_obligaciones/add");
				} else {
					// Esta lógica se ejecutará si la solicitud no es AJAX
					// Puedes manejar la lógica específica de las solicitudes no AJAX aquí
					echo 'Esta no es una solicitud AJAX';
				}
			}
			//} else {
			//	$this->add();
			//}
		}
	}


	public function obtenerInformacionPorDescripcion()
	{
		// Obtener la descripción desde la URL
		$descripcionConPrefijo = urldecode($_GET['descripcion']);
		//$descripcionConPrefijo2 = urldecode($_GET['descripcion2']);
		// Utilizar la descripción completa con el prefijo "A.P."
		$descripcion = $descripcionConPrefijo;
		//$descripcion2 = $descripcionConPrefijo2;

		// Aquí deberías utilizar tu lógica para obtener información basada en la descripción desde la base de datos
		$informacion = $this->Pago_obli_model->getCuentaContableN($descripcion);
	
		/*if (is_null($informacion['IDCuentaContable'])) {
			$informacion = $this->Pago_obli_model->getCuentaContableN($descripcion2);
		}^*/
		

		if ($informacion) {
			// Imprimir los valores directamente
			echo $informacion . ',' . $informacion['IDCuentaContable'] . ',' . $informacion['Codigo_CC'] . ',' . $informacion['Descripcion_CC'];
		} else {
			echo 'No se pudo obtener la información.';
		}
	}


	public function edit($id)
	{
		$data = array(
			'obligaciones' => $this->Pago_obli_model->obtener_asiento_por_id($id),
		);
		$this->load->view("layouts/header");
		$this->load->view("layouts/sideBar");
		$this->load->view("admin/pagoobli/pagobli_combined", $data);
		$this->load->view("layouts/footer");
	}



	public function update()
	{
		$idobli = $this->input->post("idobli");
		$ruc = $this->input->post("ruc");
		$numero = $this->input->post("numero");
		$contabilidad = $this->input->post("contabilidad");
		$direccion = $this->input->post("direccion");
		$telefono = $this->input->post("telefono");
		$observacion = $this->input->post("observacion");
		$fecha = $this->input->post("fecha");
		$tesoreria = $this->input->post("tesoreria");
		$pedi_matricula = $this->input->post("pedi_matricula");
		$modalidad = $this->input->post("modalidad");
		$tipo_presupuesto = $this->input->post("tipo_presupuesto");
		$unidad_respon = $this->input->post("unidad_respon");
		$proyecto = $this->input->post("proyecto");
		$nro_pac = $this->input->post("nro_pac");
		$nro_exp = $this->input->post("nro_exp");
		$total = $this->input->post("total");
		$pagado = $this->input->post("pagado");
		$obliaactual = $this->Pago_obli_model->obtener_asiento_por_id($idobli);


			$data  = array(
                'ruc' => $ruc,
				'numero' => $numero, 
				'contabilidad' => $contabilidad,
				'direccion' => $direccion,
                'telefono' => $telefono,
                'observacion' => $observacion,
                'FechaEmision' => $fecha,
                'tesoreria' => $tesoreria,
                'pedi_matricula' => $pedi_matricula,
                'modalidad' => $modalidad,
                'tipo_presupuesto' => $tipo_presupuesto,
                'unidad_respon' => $unidad_respon,
                'proyecto' => $proyecto,
                'estado' => $estado,
                'nro_pac' => $nro_pac,
                'nro_exp' => $nro_exp,
                'total' => $total,
                'pagado' => $pagado,
				'estado_registro' => "1",
			);

			if ($this->Pago_obli_model->save_num_asiave($idobli,$data)) {
				redirect(base_url()."obligaciones/Pago_de_obligaciones");
			}
			else{
				$this->session->set_flashdata("error","No se pudo guardar la informacion");
				redirect(base_url()."obligaciones/Pago_de_obligaciones/add".$idobli);
			}
	}






	public function view($id)
	{
		$data = array(
			'obligaciones' => $this->Pago_obli_model->getDiario($id),
		);
		$this->load->view("admin/pagoobli/pagobliview", $data);
	}

	public function delete($id)
	{
		$data = array(
			'estado_bd' => "0",
		);
		$this->Pago_obli_model->update($id, $data);
		echo "obligaciones/pago_de_obligaciones";
	}
}