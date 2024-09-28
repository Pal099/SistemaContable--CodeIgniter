<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Comprobante_Gasto extends MY_Controller {

	//private $permisos;
	public function __construct(){
		parent::__construct();
	//	$this->permisos= $this->backend_lib->control();
		$this->load->model("Comprobante_Gasto_model");
		$this->load->model("Bienes_Servicios_model");
		$this->load->model("Presupuesto_model");
		$this->load->library('session');
		$this->load->model("Usuarios_model");
		$this->load->model("Proveedores_model");
		$this->load->model("Registros_financieros_model");
		$this->load->model("Unidad_academica_model");
		$this->load->library('form_validation');

	}

	public function index()
	{
		$nombre=$this->session->userdata('Nombre_usuario');
		$id_user=$this->Usuarios_model->getUserIdByUserName($nombre);
		$id_uni_respon_usu = $this->Usuarios_model->getUserIdUniResponByUserId($id_user);
		$data  = array(
			'comprobantes' => $this->Comprobante_Gasto_model->getComprobantesPorPedido($id_uni_respon_usu),
			'proveedores' => $this->Proveedores_model->getProveedores($id_uni_respon_usu),
			'fuentes' => $this->Registros_financieros_model->getFuentes($id_uni_respon_usu),
			'unidad' => $this->Unidad_academica_model->obtener_unidades_academicas($id_uni_respon_usu),
			
		);
		//var_dump($data['proveedores']);
		$this->load->view("layouts/header");
		$this->load->view("layouts/sideBar");
		$this->load->view("admin/comprobantegasto/list",$data);
		$this->load->view("layouts/footer");
	}

	public function filtrar()
	{
		$nombre=$this->session->userdata('Nombre_usuario');
		$id_user=$this->Usuarios_model->getUserIdByUserName($nombre);
		$id_uni_respon_usu = $this->Usuarios_model->getUserIdUniResponByUserId($id_user);
		$id = $this->input->post("IDComprobanteGasto");
		$actividad = $this->input->post("actividad");
		$fuente = $this->input->post("fuente");
		$periodo = $this->input->post("periodo");
		$mes = $this->input->post("mes");
		$nropedido = $this->input->post("id_pedido");
		if (empty($actividad) && empty($fuente) && empty($periodo) && empty($mes)&& empty($nropedido)) {
			// Ningún campo seleccionado, redireccionar o mostrar un mensaje de error
			redirect(base_url() . "patrimonio/comprobantegasto");
		}
		$data  = array(
			'comprobantes' => $this->Comprobante_Gasto_model->getComprobantesGastosFiltrados($actividad, $fuente, $periodo, $mes),
			'proveedores' => $this->Proveedores_model->getProveedores($id_uni_respon_usu),
			'fuentes' => $this->Registros_financieros_model->getFuentes($id_uni_respon_usu),
			'unidad' => $this->Unidad_academica_model->obtener_unidades_academicas($id_uni_respon_usu),
			'bienes_servicios' => $this->Bienes_Servicios_model->getBienesServicios($id_uni_respon_usu),
		);
		$this->load->view("layouts/header");
		$this->load->view("layouts/sideBar");
		$this->load->view("admin/comprobantegasto/list",$data);
		$this->load->view("layouts/footer");

	}

	public function add(){
		$nombre=$this->session->userdata('Nombre_usuario');
		$id_user=$this->Usuarios_model->getUserIdByUserName($nombre);
		$id_uni_respon_usu = $this->Usuarios_model->getUserIdUniResponByUserId($id_user);
		
		$data  = array(
			'presupuestos' => $this->Presupuesto_model->getPresu($id_uni_respon_usu),
			'comprobantes' => $this->Comprobante_Gasto_model->getComprobantesGastos($id_uni_respon_usu),
			'proveedores' => $this->Proveedores_model->getProveedores($id_uni_respon_usu),
			'fuentes' => $this->Registros_financieros_model->getFuentes($id_uni_respon_usu),
			'unidad' => $this->Unidad_academica_model->obtener_unidades_academicas($id_uni_respon_usu),
			'bienes_servicios' => $this->Bienes_Servicios_model->getBienesServicios($id_uni_respon_usu),
			'datos_vista' => $this->Comprobante_Gasto_model->obtener_datos_presupuesto(),
		);
		$this->load->view("layouts/header");
		$this->load->view("layouts/sideBar");
		$this->load->view("admin/comprobantegasto/add", $data);
		$this->load->view("layouts/footer");
	}


	public function store()
	{
		header('Access-Control-Allow-Origin: *');
		$datosCompletos = $this->input->post('datos');
		$datosFormulario = $datosCompletos['datosFormulario'];

		$nombre = $this->session->userdata('Nombre_usuario');
		$id_user = $this->Usuarios_model->getUserIdByUserName($nombre);
		$id_uni_respon_usu = $this->Usuarios_model->getUserIdUniResponByUserId($id_user);

		// Recopilar datos generales del pedido

		$id_unidad = $datosFormulario['id_unidad'];
		$fecha = $datosFormulario['fecha'];
		$concepto = $datosFormulario['concepto'];
		$id_proveedor = $datosFormulario['idproveedor'];
		//$id_presupuesto= $datosFormulario['idpresupuesto'];

		if ($this->input->is_ajax_request()) {

			$datosFormulario = $datosCompletos['filas'];
			$filas = $datosCompletos['filas'];

			foreach ($filas as $fila) {
				// Ejemplo de cómo podrías procesar una fila
				$dataPedido = array(
					'id_pedido'=> $fila['id_pedido'], // Ajusta el nombre según tus datos
					'id_unidad' => $id_unidad,
					'fecha' => $fecha,
					//'idpresupuesto' => $id_presupuesto,
					'idproveedor' => $id_proveedor,
					'descripcion' => $fila['descripcion'],
					'concepto' => $concepto,
					'id_item' => $fila['id_item'],
					'preciounit' => $fila['precioUnit'],
					'cantidad' => $fila['cantidad'],
					'iva' => $fila['iva'],
					'porcentaje_iva' => $fila['piva'],
 					'exenta' => $fila['exenta'],
					'gravada' => $fila['gravada'],
					'id_uni_respon_usu' => $id_uni_respon_usu,
					'estado' => "1",
				);

				$this->Comprobante_Gasto_model->save($dataPedido);


			}

			echo "success";
		} else {
			$this->session->set_flashdata("error", "No se pudo guardar la información");
			return redirect(base_url() . "patrimonio/comprobantegasto/add");
		}
	}
	public function edit($id) {
		// Verificar la sesión del usuario
		$nombre = $this->session->userdata('Nombre_usuario');
		$id_user = $this->Usuarios_model->getUserIdByUserName($nombre);
		$id_uni_respon_usu = $this->Usuarios_model->getUserIdUniResponByUserId($id_user);
	
		// Obtener los datos del comprobante específico a editar
		$comprobante = $this->Comprobante_Gasto_model->getComprobanteGasto($id);
		$id_pedido = $comprobante->id_pedido;
		$comprobantesPedido = $this->Comprobante_Gasto_model->obtener_comprobantes_por_pedido($id_pedido);
		$proveedor = $this->Proveedores_model->getProveedor($comprobante->idproveedor);

		if (!$comprobante) {
			// Manejar el caso de no encontrar el comprobante
			$this->session->set_flashdata("error", "Comprobante no encontrado");
			return redirect(base_url() . "patrimonio/comprobantegasto");
		}
		$rubroYDescripcion = $this->Comprobante_Gasto_model->getRubroYDescripcionByIdItem($comprobante->id_item);
		// Preparar los datos para la vista
		$data = array(
			'proveedor' => $proveedor,
			'comprobante' => $comprobante,
			'comprobantesPedido' => $comprobantesPedido,
			'presupuestos' => $this->Presupuesto_model->getPresu($id_uni_respon_usu),
			'comprobantes' => $this->Comprobante_Gasto_model->getComprobantesGastos($id_uni_respon_usu),
			'proveedores' => $this->Proveedores_model->getProveedores($id_uni_respon_usu),
			'rubro' => isset($rubroYDescripcion->rubro) ? $rubroYDescripcion->rubro : '',
			'fuentes' => $this->Registros_financieros_model->getFuentes($id_uni_respon_usu),
			'uni' => $this->Unidad_academica_model->obtener_unidades_academicas($id_uni_respon_usu),
			'bienes_servicios' => $this->Bienes_Servicios_model->getBienesServicios($id_uni_respon_usu),
			'datos_vista' => $this->Comprobante_Gasto_model->obtener_datos_presupuesto(),
		);
	
		// Cargar las vistas
		$this->load->view("layouts/header");
		$this->load->view("layouts/sideBar");
		$this->load->view("admin/comprobantegasto/edit", $data);
		$this->load->view("layouts/footer");
	}
	
	public function update() {
		header('Access-Control-Allow-Origin: *');
		$datosCompletos = $this->input->post('datos');
		$datosFormulario = $datosCompletos['datosFormulario'];
	
		$nombre = $this->session->userdata('Nombre_usuario');
		$id_user = $this->Usuarios_model->getUserIdByUserName($nombre);
		$id_uni_respon_usu = $this->Usuarios_model->getUserIdUniResponByUserId($id_user);
	
		// Recopilar datos generales del formulario
		$id_pedido = $datosFormulario['id_pedido'];
		$id_unidad = $datosFormulario['id_unidad'];
		$fecha = $datosFormulario['fecha'];
		$concepto = $datosFormulario['concepto'];
		$id_proveedor = $datosFormulario['idproveedor'];
	
		if ($this->input->is_ajax_request()) {
			$filas = $datosCompletos['filas'];
	
			// Actualizar el comprobante principal
			$dataComprobante = array(
				'id_pedido' => $id_pedido,
				'id_unidad' => $id_unidad,
				'fecha' => $fecha,
				'concepto' => $concepto,
				'idproveedor' => $id_proveedor,
				'id_uni_respon_usu' => $id_uni_respon_usu,
			);
	
			$this->Comprobante_Gasto_model->update($id_pedido, $dataComprobante);
	
			// Actualizar las filas
			foreach ($filas as $fila) {
				// Aquí podrías implementar la lógica para actualizar cada fila
				$dataFila = array(
					'id_pedido' => $fila['id_pedido'],
					'IDComprobanteGasto' => $fila['IDComprobanteGasto'],
					'id_unidad' => $id_unidad,
					'fecha' => $fecha,
					'idproveedor' => $id_proveedor,
					'descripcion' => $fila['descripcion'],
					'concepto' => $concepto,
					'id_item' => $fila['id_item'],
					'preciounit' => $fila['preciounit'],
					'cantidad' => $fila['cantidad'],
					'iva' => $fila['iva'],
					'porcentaje_iva' => $fila['porcentaje_iva'],
					'exenta' => $fila['exenta'],
					'gravada' => $fila['gravada'],
				);
	
				// Lógica para determinar si es una inserción o actualización
				if (isset($fila['id_pedido'])) {
					// Si tiene ID, es una actualización
					$this->Comprobante_Gasto_model->updateFilaComprobanteGasto($fila['IDComprobanteGasto'], $dataFila);
				} else {
					// Si no tiene ID, es una inserción
					$this->Comprobante_Gasto_model->save($dataFila);
				}
			}
	
			echo "success";
		} else {
			$this->session->set_flashdata("error", "No se pudo actualizar la información");
			return redirect(base_url() . "patrimonio/comprobantegasto/" );
		}
	}

	/*public function edit($id) {
		// Obtener nombre del usuario y sus identificadores relacionados
		$nombre = $this->session->userdata('Nombre_usuario');
		$id_user = $this->Usuarios_model->getUserIdByUserName($nombre);
		$id_uni_respon_usu = $this->Usuarios_model->getUserIdUniResponByUserId($id_user);
		

		// Obtener el comprobante de gasto a editar
		$comprobante = $this->Comprobante_Gasto_model->getComprobanteGasto($id);
		$id_pedido = $comprobante->id_pedido;

		$comprobantesPedido = $this->Comprobante_Gasto_model->obtener_comprobantes_por_pedido($id_pedido);
    
		// Obtener rubro y descripción de la tabla bienes_servicios
		$rubroYDescripcion = $this->Comprobante_Gasto_model->getRubroYDescripcionByIdItem($comprobante->id_item);
	
		// Obtener otros datos
		$proveedores = $this->Proveedores_model->getProveedores($id_uni_respon_usu);
		$comprobantes = $this->Comprobante_Gasto_model->getComprobantesGastos($id_uni_respon_usu);
		$unidad = $this->Unidad_academica_model->obtener_unidades_academicas($id_uni_respon_usu);
		$presupuestos = $this->Presupuesto_model->getPresu($id_uni_respon_usu);
		$fuentes = $this->Registros_financieros_model->getFuentes($id_uni_respon_usu);
		$bienes_servicios = $this->Bienes_Servicios_model->getBienesServicios($id_uni_respon_usu);
	
		// Buscar y asignar el proveedor y la unidad correspondiente al comprobante
		$proveedorEncontrado = null;
		foreach ($proveedores as $proveedor) {
			if ($proveedor->id == $comprobante->idproveedor) {
				$proveedorEncontrado = $proveedor;
				break;
			}
		}
	
		$unidadEncontrada = null;
		foreach ($unidad as $uni) {
			if ($uni->id_unidad == $comprobante->id_unidad) {
				$unidadEncontrada = $uni;
				break;
			}
		}
	
		// Preparar los datos para la vista
		$data = array(
			'proveedores' => $proveedores,
			'comprobante' => $comprobante,
			'comprobantes' => $comprobantes,
			'comprobantesPedido' => $comprobantesPedido,
			'uni' => $unidad,
			'proveedor' => $proveedorEncontrado,
			'unidad' => $unidadEncontrada,
			'presupuestos' => $presupuestos,
			'fuentes' => $fuentes,
			'bienes_servicios' => $bienes_servicios,
			'rubro' => isset($rubroYDescripcion->rubro) ? $rubroYDescripcion->rubro : '',
			'item' => isset($rubroYDescripcion->descripcion) ? $rubroYDescripcion->descripcion : '',
			'datos_vista' => $this->Comprobante_Gasto_model->obtener_datos_presupuesto(),			
			'bienes_servicios' => $this->Bienes_Servicios_model->getBienesServicios($id_uni_respon_usu),

			
		);

		$this->load->view("layouts/header");
		$this->load->view("layouts/sideBar");
		$this->load->view("admin/comprobantegasto/edit", $data);
		$this->load->view("layouts/footer");
	}*/
	public function obtenerItemsPorPedido() {
        // Verificar que el id_pedido esté presente en la solicitud
        if (isset($_GET['id_pedido'])) {
            $id_pedido = intval($_GET['id_pedido']);
            
            // Obtener los items desde el modelo
            $items = $this->model->obtenerItemsPorPedido($id_pedido);
            
            // Devolver los items como JSON para la vista
            echo json_encode($items);
        } else {
            echo json_encode(['error' => 'No se proporcionó id_pedido']);
        }
    }
	
	/*public function update() {
		// Obtener los datos enviados vía POST
		$datos = json_decode(file_get_contents('php://input'), true);  // Decodificar JSON
		log_message('info', 'Datos completos recibidos: ' . print_r($this->input->post(), true));

	
		// Verificar errores de JSON
		if (json_last_error() !== JSON_ERROR_NONE) {
			log_message('error', 'Error al decodificar JSON: ' . json_last_error_msg());
			echo json_encode(['status' => 'error', 'message' => 'Error al procesar los datos. Fila: ' . json_encode($datos)]);

			return;
		}
		
	
		// Obtener datos del usuario y la unidad responsable
		$nombre = $this->session->userdata('Nombre_usuario');
		$id_user = $this->Usuarios_model->getUserIdByUserName($nombre);
		$id_uni_respon_usu = $this->Usuarios_model->getUserIdUniResponByUserId($id_user);
	
		// Verificar que los datos del formulario principal y las filas no estén vacíos
		if (!empty($datos['datosFormulario']) && !empty($datos['filas'])) {
	
			// Procesar los datos del formulario principal
			$datosFormulario = $datos['datosFormulario'];
			if (empty($datosFormulario['fecha']) || empty($datosFormulario['id_unidad']) || empty($datosFormulario['concepto']) || empty($datosFormulario['idproveedor']) || empty($datosFormulario['id_pedido'])) {
				log_message('error', 'Faltan datos en datosFormulario: ' . print_r($datosFormulario, true));
				echo json_encode(['status' => 'error', 'message' => 'Datos incompletos en el formulario principal.']);
				return;
			}
	
			// Actualizar los datos principales del comprobante
			$id_pedido = $datosFormulario['id_pedido'];
			$data = array(
				'fecha' => $datosFormulario['fecha'],
				'id_unidad' => $datosFormulario['id_unidad'],
				'concepto' => $datosFormulario['concepto'],
				'idproveedor' => $datosFormulario['idproveedor'],
				'id_pedido' => $id_pedido
			);
	
			// Actualizar o insertar los datos en la base de datos
			$updateResult = $this->ComprobanteGastoModel->updateComprobanteGasto($id_pedido, $data);
			if (!$updateResult) {
				log_message('error', 'Error al actualizar comprobante de gasto.');
				echo json_encode(['status' => 'error', 'message' => 'Error al actualizar comprobante.']);
				return;
			}
	
			// Procesar cada fila
			foreach ($datos['filas'] as $fila) {
				if (empty($fila['IDComprobanteGasto']) || empty($fila['descripcion']) || empty($fila['preciounit']) || empty($fila['cantidad']) || empty($fila['porcentaje_iva'])) {
					log_message('error', 'Faltan datos en una fila: ' . print_r($fila, true));
					echo json_encode(['status' => 'error', 'message' => 'Datos incompletos en una de las filas.']);
					return;
				}
				log_message('info', 'Fila procesada: ' . print_r($fila, true));
				$iva = isset($fila['iva']) && $fila['iva'] === 'on' ? 1 : 0;
				// Preparar los datos de la fila para actualizar/insertar
				$filaData = array(
					'id_pedido' => $fila['id_pedido'],
					'IDComprobanteGasto' => $fila['IDComprobanteGasto'],
					'id_unidad' => $fila['id_unidad'],
					'id_item' => $fila['id_item'],
					'descripcion' => $fila['descripcion'],
					'preciounit' => $fila['preciounit'],
					'cantidad' => $fila['cantidad'],
					'iva' => $iva,  // Default a 0 si no está presente
					'porcentaje_iva' => $fila['porcentaje_iva'],
					'exenta' => $fila['exenta'],
					'gravada' => $fila['gravada'],
					'id_uni_respon_usu' => $id_uni_respon_usu,
					'estado' => "1",
				);
				if (is_null($fila)) {
					log_message('error', 'Error: Fila nula detectada.');
					echo json_encode(['status' => 'error', 'message' => 'Fila nula detectada en los datos recibidos.']);
					return;
				}
				log_message('info', 'Fila procesada correctamente: ' . print_r($fila, true));
	
				// Guardar o actualizar cada fila en la base de datos
				$updateFila = $this->ComprobanteGastoModel->updateFilaComprobanteGasto($fila['IDComprobanteGasto'], $filaData);
				if (!$updateFila) {
					log_message('error', 'Error al actualizar la fila: ' . print_r($fila, true));
					echo json_encode(['status' => 'error', 'message' => 'Error al actualizar una de las filas.']);
					return;
				}
			}
	
			// Devolver una respuesta de éxito
			echo json_encode(['status' => 'success', 'message' => 'Datos actualizados correctamente.']);
		} else {
			log_message('error', 'Datos incompletos recibidos: ' . print_r($datos, true));
			echo json_encode(['status' => 'error', 'message' => 'Datos incompletos.']);
		}
	}*/
	
	
	public function view($id){
		$data  = array(
			'comprobantes' => $this->Comprobante_Gasto_model->getComprobanteGasto($id), 
		);
		$this->load->view("admin/comprobantegasto/view",$data);
	}

	public function delete($id){
		$data  = array(
			'estado' => "0", 
		);
		$this->Comprobante_Gasto_model->update($id,$data);
		redirect(base_url() . "patrimonio/comprobante_gasto");
	}
	public function getComprobanteDetalle($id) {
		$ComprobanteDetalle = $this->Comprobante_Gasto_model->getComprobanteGasto($id);
		echo json_encode($ComprobanteDetalle);
	}
}