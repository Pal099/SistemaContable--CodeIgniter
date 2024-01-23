<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
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
		//var_dump($data['asientos']); // Solo para depuración, eliminar después


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
	public function add($id_edit = null)
	{
		$nombre = $this->session->userdata('Nombre_usuario');
		$id_user = $this->Usuarios_model->getUserIdByUserName($nombre);
		$id_uni_respon_usu = $this->Usuarios_model->getUserIdUniResponByUserId($id_user);
		$asiento = null;
		if ($id_edit) {
			$asiento = $this->Diario_obli_model->obtener_detalle_por_id($id_edit);
		}

		$data = array(
			'proveedores' => $this->Proveedores_model->getProveedores($id_uni_respon_usu),
			'programa' => $this->Diario_obli_model->getProgramGastos($id_uni_respon_usu),
			'fuente_de_financiamiento' => $this->Diario_obli_model->getFuentes($id_uni_respon_usu),
			'origen_de_financiamiento' => $this->Diario_obli_model->getOrigenes($id_uni_respon_usu),
			'asientos' => $this->Diario_obli_model->GETasientos($id_uni_respon_usu),
			'cuentacontable' => $this->Diario_obli_model->getCuentaContable($id_uni_respon_usu),
			'asiento' => $asiento, // Datos específicos del asiento para edición
		);
	

		$this->load->view("layouts/header");
		$this->load->view("layouts/sideBar");
		$this->load->view("admin/obligacion/obli_combined", $data);
		$this->load->view("layouts/footer");
		//$this->load->view("fpdf");
	}
	/*public function update()
	   {
			
		   
		   if ($this->input->post('guardar')) {
			   $accion = $this->input->post('accion');
			   var_dump($accion); 
			   $IDNum_Asi= $this->input->post('IDNum_Asi');
			   $num_asi = $this->input->post('num_asi');
			   $ruc = $this->input->post('ruc');
			   $razon_social = $this->input->post('razon_social');
			   $fecha = $this->input->post('fechaEmision');
			   $observacion = $this->input->post('observacion');
			   $pedi_matricula = $this->input->post('pedi_matricula');
			   $modalidad = $this->input->post('modalidad');
			   $tipo_presupuesto = $this->input->post('tipo_presu');
			   $nro_exp = $this->input->post('nro_exp');
			   $total = $this->input->post('Montototal');
			   $pagado = $this->input->post('pagado');
			   $op = $this->input->post('op');
	   
			   $data = array(
				   'num_asi' => $num_asi,
				   'ruc' => $ruc,
				   'razon_social' => $razon_social,
				   'fecha' => $fecha,
				   'observacion' => $observacion,
				   'ped_mat' => $pedi_matricula,
				   'modalidad' => $modalidad,
				   'tipo_presu' => $tipo_presupuesto,
				   'nro_exp' => $nro_exp,
				   'MontoTotal' => $total,
				   'MontoPagado' => $pagado,
				   'op' => $op
			   );

			   if ($accion == 'agregar') {
				   $insercion_exitosa = $this->Diario_obli_model->insertar_asiento($data);
				   if ($insercion_exitosa) {
					   //redirect(base_url() . "obligaciones/diario_obligaciones/add");
					   var_dump($accion); 
				   } else {
					   $this->session->set_flashdata("error", "No se pudo agregar la información");
				   }
			   } elseif ($accion == 'actualizar') {
				   $actualizacion_exitosa = $this->Diario_obli_model->actualizar_asiento($IDNum_Asi, $data);
				   if ($actualizacion_exitosa) {
					   redirect(base_url() . "obligaciones/diario_obligaciones/add");
				   } else {
					   $this->session->set_flashdata("error", "No se pudo actualizar la información");
				   }
			   }
		   }
	   
		   // Redirige en caso de error o si no se envió el formulario
		   redirect(base_url() . "obligaciones/diario_obligaciones/add");
	   }*/

	public function store()
	{
		header('Access-Control-Allow-Origin: *');
		$datosCompletos = $this->input->post('datos');
		$datosFormulario = $datosCompletos['datosFormulario'];
		//var_dump($datosFormulario);

		$nombre = $this->session->userdata('Nombre_usuario');
		$id_user = $this->Usuarios_model->getUserIdByUserName($nombre);
		$id_uni_respon_usu = $this->Usuarios_model->getUserIdUniResponByUserId($id_user);
		$ruc_id_provee = $datosFormulario['ruc'];
		$numero = $datosFormulario['num_asi'];
		$id_num_asi = $this->input->post("IDNum_Asi");
		$contabilidad = $datosFormulario['contabilidad'];
		$observacion = $datosFormulario['observacion'];
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


	public function edit($idNumAsiento = null)
	{
		// Obtener detalles del asiento por ID
		$asiento = $this->Diario_obli_model->obtener_asiento_por_id($idNumAsiento);

		// Obtener el proveedor por ID
		$proveedor = null;
		if (!empty($asiento['id_provee'])) {
			$proveedor = $this->Proveedores_model->getProveedor($asiento['id_provee']);
		}
		$detalles = null;
		if (!empty($asiento['IDNum_Asi'])) {
			$detalles = $this->Diario_obli_model->obtener_detalles_por_asiento($asiento['IDNum_Asi']);
		}
		//var_dump($detalles);
		// Otros datos necesarios para la vista
		$nombre = $this->session->userdata('Nombre_usuario');
		$id_user = $this->Usuarios_model->getUserIdByUserName($nombre);
		$id_uni_respon_usu = $this->Usuarios_model->getUserIdUniResponByUserId($id_user);

		// Verificar si se envió el formulario y se hizo clic en el botón 'guardar'
		if ($this->input->post() && $this->input->post('guardar')) {

			$num_asi = $this->input->post('num_asi');
			$ruc = $this->input->post('ruc');
			$razon_social = $this->input->post('razon_social');
			$fecha = $this->input->post('fechaEmision');
			$observacion = $this->input->post('observacion');
			$pedi_matricula = $this->input->post('ped_mat');
			$modalidad = $this->input->post('modalidad');
			$tipo_presupuesto = $this->input->post('tipo_presu');
			$nro_exp = $this->input->post('nro_exp');
			$total = $this->input->post('MontoTotal');
			$pagado = $this->input->post('MontoPagado');
			$op = $this->input->post('op');

			$dataActualizar = array(
				'num_asi' => $num_asi,
				'ruc' => $ruc,
				'razon_social' => $razon_social,
				'fechaEmision' => $fecha,
				'observacion' => $observacion,
				'ped_mat' => $pedi_matricula,
				'modalidad' => $modalidad,
				'tipo_presu' => $tipo_presupuesto,
				'nro_exp' => $nro_exp,
				'MontoTotal' => $total,
				'MontoPagado' => $pagado,
				'op' => $op,
			);

			// Verificar si es una inserción o una actualización
			if ($idNumAsiento === null) {
				$insercion_exitosa = $this->Diario_obli_model->insertar_asiento($dataActualizar);
				if ($insercion_exitosa) {
					$this->session->set_flashdata("Not error", "Se guardó la información correctamente");
				} else {
					// Manejar el caso en que ocurra un error al insertar
					show_error('Error al insertar el asiento', 500);
					return;
				}
			} else {
				// Actualizar el registro en la base de datos
				$resultado = $this->Diario_obli_model->actualizar_asiento($idNumAsiento, $dataActualizar);

				// Verificar el resultado de la actualización
				if ($resultado) {
					$this->session->set_flashdata("Not error", "Se actualizó el asiento correctamente");
				} else {
					// Manejar el caso en que ocurra un error al actualizar
					show_error('Error al actualizar el asiento', 500);
					return;
				}
			}

			// Redirigir a la página deseada después de la inserción o actualización
			redirect(base_url() . "obligaciones/diario_obligaciones/add");
		}

		// Cargar datos necesarios para la vista
		$data = array(
			'proveedores' => $this->Proveedores_model->getProveedores($id_uni_respon_usu),
			'programa' => $this->Diario_obli_model->getProgramGastos($id_uni_respon_usu),
			'fuente_de_financiamiento' => $this->Diario_obli_model->getFuentes($id_uni_respon_usu),
			'origen_de_financiamiento' => $this->Diario_obli_model->getOrigenes($id_uni_respon_usu),
			'asientos' => $this->Diario_obli_model->GETasientos($id_uni_respon_usu),
			'cuentacontable' => $this->Diario_obli_model->getCuentaContable($id_uni_respon_usu),
			'asiento' => $asiento,
			'proveedor' => $proveedor, // Pasar el proveedor a la vista
			'detalles' => $detalles,
		);
		json_encode($data);

		// Cargar vista
		$this->load->view("layouts/header");
		$this->load->view("layouts/sideBar");
		$this->load->view("admin/obligacion/obli_combined", $data);
		$this->load->view("layouts/footer");
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
			'estado_registro' => "0",
		);
		$this->Diario_obli_model->actualizar_asiento($id, $data);
		redirect(base_url() . "obligaciones/diario_obligaciones/add");
	}
}