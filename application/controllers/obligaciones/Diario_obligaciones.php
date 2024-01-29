<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Diario_obligaciones extends CI_Controller
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
		$this->load->model("Usuarios_model");
		$this->load->library('form_validation');

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

		$data['asientos'] = $this->Diario_obli_model->GETasientos($id_uni_respon_usu); // Obtener la lista de asientos
		$data['proveedores'] = $this->Proveedores_model->getProveedores($id_uni_respon_usu);  // Obtener la lista de proveedores
		$data['programa'] = $this->Diario_obli_model->getProgramGastos($id_uni_respon_usu);
		$data['fuente_de_financiamiento'] = $this->Diario_obli_model->getFuentes($id_uni_respon_usu);
		$data['origen_de_financiamiento'] = $this->Diario_obli_model->getOrigenes($id_uni_respon_usu);
		//$data['cuentacontable'] = $this->Diario_obli_model->getCuentasContables($id_uni_respon_usu); 
		var_dump($data['asientos']); // Solo para depuración, eliminar después

        $this->load->view("layouts/header");
        $this->load->view("layouts/sideBar");
        $this->load->view("admin/obligacion/obli_combined", $data);
        $this->load->view("layouts/footer");
		$this->load->view("fpdf");

	}


	public function pdfs()
	{
		$this->load->view("fpdf");

	}

	public function get_proveedores()
	{
		$data = array(
			'proveedores' => $this->Proveedores_model->getProveedores(),
			'programa' => $this->Diario_obli_model->getProgramas(),
			'fuente_de_financiamiento' => $this->Diario_obli_model->getFuentesFinanciamiento(),
			'origen_de_financiamiento' => $this->Diario_obli_model->getOrigenesFinanciamiento(),
		);
		echo json_encode($data);
	}

	public function add()
	{

		$nombre = $this->session->userdata('Nombre_usuario');
		$id_user = $this->Usuarios_model->getUserIdByUserName($nombre);
		$id_uni_respon_usu = $this->Usuarios_model->getUserIdUniResponByUserId($id_user);

		$data = array(
			'proveedores' => $this->Proveedores_model->getProveedores($id_uni_respon_usu), // Agregar esta línea para obtener la lista de proveedores
			'programa' => $this->Diario_obli_model->getProgramGastos($id_uni_respon_usu),
			'fuente_de_financiamiento' => $this->Diario_obli_model->getFuentes($id_uni_respon_usu),
			'origen_de_financiamiento' => $this->Diario_obli_model->getOrigenes($id_uni_respon_usu),
			'asientos' => $this->Diario_obli_model->GETasientos($id_uni_respon_usu),
			'cuentacontable' => $this->Diario_obli_model->getCuentaContable($id_uni_respon_usu),
		);

		$this->load->view("layouts/header");
		$this->load->view("layouts/sideBar");
		$this->load->view("admin/obligacion/obli_combined", $data); // Pasar los datos a la vista
		$this->load->view("layouts/footer");
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
		$ruc_id_provee = $datosFormulario['ruc'];
		$numero = $datosFormulario['num_asi'];
		$id_num_asi = $this->input->post("IDNum_Asi");
		$contabilidad = $datosFormulario['contabilidad'];
		$concepto = $datosFormulario['concepto'];
		$fecha = $datosFormulario['fecha'];
		//-----------------//--------------------------- 1
		$detalles = $datosFormulario['detalles'];
		$debe = floatval($datosFormulario['Debe']);
		$haber_2 = floatval($datosFormulario['Haber']);
		$comprobante = $datosFormulario['comprobante'];
		$cheque_id = $datosFormulario['cheques_che_id'];
		$programa_id_pro = $datosFormulario['id_pro'];
		$cuentacontable = $datosFormulario['IDCuentaContable'];
		$fuente_de_financiamiento = $datosFormulario['id_ff'];
		$origen_de_financiamiento = $datosFormulario['id_of'];
		//-----------------//---------------------------
		$pedmat = $datosFormulario['pedmat'];
		$MontoPago = $datosFormulario['MontoPago'];
		$modalidad = $datosFormulario['modalidad'];
		$tipo_presupuesto = $datosFormulario['tipo_presu'];
		$unidad_respon = $this->input->post("unidad_respon");
		$proyecto = $this->input->post("proyecto");
		$estado = $this->input->post("estado");
		$nro_pac = $this->input->post("nro_pac");
		$nro_exp = $datosFormulario['nro_exp'];
		$pagado = $datosFormulario['pagado'];
		$proveedor_id = $this->Diario_obli_model->getProveedorIdByRuc($ruc_id_provee); //Obtenemos el proveedor en base al ruc


		$op = $datosFormulario['op'];


		if ($proveedor_id) {

			$dataNum_Asi = array(
				'FechaEmision' => $fecha,
				'concepto' => $concepto,
				'ped_mat' => $pedmat,
				'tipo_presu' => $tipo_presupuesto,
				'unidad_resp' => $unidad_respon,
				'num_asi' => $numero,
				'proyecto' => $proyecto,
				'nro_pac' => $nro_pac,
				'nro_exp' => $nro_exp,
				'MontoPagado' => $pagado,
				'id_provee' => $proveedor_id,
				'MontoTotal' => $debe,
				'modalidad' => $modalidad,
				'estado' => $estado,
				'op' => $op,
				'id_uni_respon_usu' => $id_uni_respon_usu,
				'id_form' => "1",
				'estado_registro' => "1",
			);

			$lastInsertedId = $this->Diario_obli_model->save_num_asi($dataNum_Asi, $proveedor_id);

			if ($lastInsertedId) {
				$dataDetaDebe = array(
					'Num_Asi_IDNum_Asi' => $lastInsertedId, // Utiliza el ID recién insertado
					'MontoPago' => $MontoPago,
					'Debe' => $debe,
					'numero' => $numero,
					'comprobante' => $comprobante,
					'detalles' => $detalles,
					'id_of' => $origen_de_financiamiento,
					'id_pro' => $programa_id_pro,
					'id_ff' => $fuente_de_financiamiento,
					'IDCuentaContable' => $cuentacontable,
					'cheques_che_id' => $cheque_id,
					'proveedores_id' => $proveedor_id,
					'id_uni_respon_usu' => $id_uni_respon_usu,
					'id_form' => "1",
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
								'id_form' => "1",
								'estado_registro' => "1",
							);
								
							$this->Diario_obli_model->saveHaber($dataDetaHaber);
							
								
						}

					}

					return redirect(base_url() . "obligaciones/diario_obligaciones/add");
				} else {
					// Esta lógica se ejecutará si la solicitud no es AJAX
					// Puedes manejar la lógica específica de las solicitudes no AJAX aquí
					echo 'Esta no es una solicitud AJAX';
				}

			}
		} 

	} // fin del store

	public function busqueda_por_cuenta()
	{
		$numero_cuenta = $this->input->get('busqueda');
		$desc_cuenta = $this->input->get('busqueda');
		$this->mostrar_vista($numero_cuenta, $desc_cuenta);
	}


	public function edit($id)
	{
		$nombre = $this->session->userdata('Nombre_usuario');
		$id_user = $this->Usuarios_model->getUserIdByUserName($nombre);
		$id_uni_respon_usu = $this->Usuarios_model->getUserIdUniResponByUserId($id_user);
	
		// Obtener datos de las tablas requeridas para los datos
		$asiento = $this->Diario_obli_model->GetAsientoEditar($id);
		$proveedores = $this->Proveedores_model->getProveedores($id_uni_respon_usu);
		$programas = $this->Diario_obli_model->getProgramGastos($id_uni_respon_usu);
		$fuente_de_financiamiento = $this->Diario_obli_model->getFuentes($id_uni_respon_usu);
		$origen_de_financiamiento = $this->Diario_obli_model->getOrigenes($id_uni_respon_usu);
		$cuentacontables = $this->Diario_obli_model->getCuentaContable($id_uni_respon_usu);
	
		// Buscamos los datos corresponiendentes de las tablas para facilidad de su manejo
		$proveedorEncontrado = null;
		foreach ($proveedores as $proveedor) {
			if ($proveedor->id == $asiento[0]['datosFijos']['id_provee']) {
				$proveedorEncontrado = $proveedor;
				break;
			}
		}

		// Buscamos los datos corresponiendentes de las cuentas y los insertamos en el array 'camposDinamicos' para su uso
		// Recorremos cada campo dinamico para obtener su IdCuentaContable
		foreach ($asiento[0]['camposDinamicos'] as $campoDinamico) {
			// Recorremos cada cuenta contable para encontrar nuestra cuenta objetivo
			foreach ($cuentacontables as $cuenta) {
				// Si el ID de la cuenta contable coincide con el ID del campo dinamico
				if ($cuenta->IDCuentaContable == $campoDinamico->IDCuentaContable) {
					// Entonces agreamos los datos necesarios a nuestro array de 'camposDinamicos'
					$campoDinamico->Codigo_CC = $cuenta->Codigo_CC;
					$campoDinamico->Descripcion_CC = $cuenta->Descripcion_CC;
					break;
				}
			}
		}

		// Agregar datos al array $data
		$data = array(
			'asiento' => $asiento,
			'proveedor' => $proveedorEncontrado, 
			'programa' => $programas,
			'fuente_de_financiamiento' => $fuente_de_financiamiento,
			'origen_de_financiamiento' => $origen_de_financiamiento,
			'cuentacontable' => $cuentacontables,
			'proveedoresALL' => $proveedores,
		);
	
		$this->load->view("layouts/header");
		$this->load->view("layouts/sideBar");
		$this->load->view("admin/obligacion/obliedit", $data);
		$this->load->view("layouts/footer");
	}
	public function testearDatos() {
		$IDNum_Asi = 18; 
		$datos = $this->Diario_obli_model->GetAsientoEditar($IDNum_Asi);
		$cuentacontables = $this->Diario_obli_model->getCuentaContable(1);

		foreach ($datos[0]['camposDinamicos'] as $campoDinamico) {
			// Recorrer cada cuenta contable
			foreach ($cuentacontables as $cuenta) {
				// Si el ID de la cuenta contable coincide con el ID del campo dinamico
				if ($cuenta->IDCuentaContable == $campoDinamico->IDCuentaContable) {
					// Agregar los datos de la cuenta contable al campo dinamico
					$campoDinamico->Codigo_CC = $cuenta->Codigo_CC;
					$campoDinamico->Descripcion_CC = $cuenta->Descripcion_CC;
					break;
				}
			}
		}
		// Se Imprime los datos para revisar su estructura
		echo '<pre>';
		print_r($datos);
		echo '</pre>';
	}

	public function update()
	{
		header('Access-Control-Allow-Origin: *');
		$datosCompletos = $this->input->post('datos');
		$datosFormulario = $datosCompletos['datosFormulario'];
		var_dump($datosFormulario);

		$nombre = $this->session->userdata('Nombre_usuario');
		$id_user = $this->Usuarios_model->getUserIdByUserName($nombre);
		$id_uni_respon_usu = $this->Usuarios_model->getUserIdUniResponByUserId($id_user);
		$IDNum_Asi = $datosFormulario['IDNum_Asi'];
		$num_asi = $datosFormulario['num_asi'];
		$ruc_id_provee = $datosFormulario['ruc'];
		$numero = $datosFormulario['num_asi'];
		$contabilidad = $datosFormulario['contabilidad'];
		$concepto = $datosFormulario['concepto'];
		$fecha = $datosFormulario['fecha'];
		//-----------------//--------------------------- 1
		$detalles = $datosFormulario['detalles'];
		$debe = floatval($datosFormulario['Debe']);
		$haber_2 = floatval($datosFormulario['Haber']);
		$comprobante = $datosFormulario['comprobante'];
		$cheque_id = $datosFormulario['cheques_che_id'];
		$programa_id_pro = $datosFormulario['id_pro'];
		$cuentacontable = $datosFormulario['IDCuentaContable'];
		$fuente_de_financiamiento = $datosFormulario['id_ff'];
		$origen_de_financiamiento = $datosFormulario['id_of'];
		//-----------------//---------------------------
		$pedmat = $datosFormulario['pedmat'];
		$MontoPago = $datosFormulario['MontoPago'];
		$MontoTotal= $datosFormulario['total'];
		$modalidad = $datosFormulario['modalidad'];
		$tipo_presupuesto = $datosFormulario['tipo_presu'];
		$nro_exp = $datosFormulario['nro_exp'];
		$proveedor_id = $this->Diario_obli_model->getProveedorIdByRuc($ruc_id_provee); //Obtenemos el proveedor en base al ruc


		$op = $datosFormulario['op'];


		if ($proveedor_id) {

			$dataNum_Asi = array(
				'FechaEmision' => $fecha,
				'concepto' => $concepto,
				'ped_mat' => $pedmat,
				'tipo_presu' => $tipo_presupuesto,
				'num_asi' => $numero,
				'nro_exp' => $nro_exp,
				'id_provee' => $proveedor_id,
				'MontoTotal' => $MontoTotal,
				'modalidad' => $modalidad,
				'op' => $op,
			);
			//Se actualiza num_asi
			$this->Diario_obli_model->actualizar_num_asi($IDNum_Asi, $dataNum_Asi);

			//Acá el codigo para actualizar num_asi_deta
				if ($this->input->is_ajax_request()) {
						$filas = $datosCompletos['filas'];
						foreach ($filas as $fila) {
							/* Si esto es true entonces es un campo nuevo que agrego el usuario al editar, por lo tanto
							debemos de agregarlo como un registro nuevo */
							if (!isset($fila['IDNum_Asi_Deta'])) {
								$Num_Asi_IDNum_Asi = $IDNum_Asi;
								$dataInsertar = array(
									'MontoPago' => $fila['Haber'],
									'Debe' => $fila['Debe'],
									'Haber' => $fila['Haber'],
									'detalles' => $fila['detalles'],
									'numero' => $numero,
									'Comprobante' => $fila['Comprobante'],
									'id_of' => $fila['id_of'],	
									'id_pro' => $fila['id_pro'],
									'id_ff' => $fila['id_ff'],
									'IDCuentaContable' => $fila['IDCuentaContable'],
									'cheques_che_id' => $fila['cheques_che_id'],
									'proveedores_id' => $proveedor_id,
									'numero' => $num_asi,
									'Num_Asi_IDNum_Asi' => $Num_Asi_IDNum_Asi,
								);
								$this->Diario_obli_model->update_num_asi_deta_fila_nueva($dataInsertar);
							}else{
								//Obtenemos el valor del id para poder actualizar los datos
								$IDNum_Asi_Deta = $fila['IDNum_Asi_Deta'];
								//Creamos el array de los datos que se actualizaran
								$dataActualizar = array(
									'MontoPago' => $fila['Haber'],
									'Debe' => $fila['Debe'],
									'Haber' => $fila['Haber'],
									'detalles' => $fila['detalles'],
									'numero' => $numero,
									'Comprobante' => $fila['Comprobante'],
									'id_of' => $fila['id_of'],	
									'id_pro' => $fila['id_pro'],
									'id_ff' => $fila['id_ff'],
									'IDCuentaContable' => $fila['IDCuentaContable'],
									'cheques_che_id' => $fila['cheques_che_id'],
									'proveedores_id' => $proveedor_id,
								);	
								$this->Diario_obli_model->update_num_asi_deta($IDNum_Asi_Deta, $dataActualizar);
							}
	
						}
						exit();
				} else {
					// Esta lógica se ejecutará si la solicitud no es AJAX
					// Puedes manejar la lógica específica de las solicitudes no AJAX aquí
					echo 'Esta no es una solicitud AJAX';
				}		
		} 
	}
	






	public function view($id)
	{
		$data = array(
			'obligaciones' => $this->Diario_obli_model->getDiario($id),
		);
		$this->load->view("admin/obligacion/obliview", $data);
	}

	public function delete($id)
	{
		$data = array(
			'estado_bd' => "0",
		);
		$this->Diario_obli_model->update($id, $data);
		echo "obligaciones/diario_obligaciones";
	}
}