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
		$nombre = $this->session->userdata('Nombre_usuario');
		$id_user = $this->Usuarios_model->getUserIdByUserName($nombre);
		$id_uni_respon_usu = $this->Usuarios_model->getUserIdUniResponByUserId($id_user);
		$id = $this->input->post("IDComprobanteGasto");
		$actividad = $this->input->post("actividad");
		$fuente = $this->input->post("fuente");
		$periodo = $this->input->post("periodo");
		$mes = $this->input->post("mes");
		$nropedido = $this->input->post("id_pedido");
		if (empty($actividad) && empty($periodo) && empty($mes)&& empty($nropedido)) {
			// Ningún campo seleccionado, redireccionar o mostrar un mensaje de error
			redirect(base_url() . "patrimonio/comprobantegasto");
		}
		$data  = array(
			'comprobantes' => $this->Comprobante_Gasto_model->getComprobantesGastosFiltrados($actividad,$periodo, $mes, $nropedido),
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
		try {
            $maxPedido = $this->Comprobante_Gasto_model->getMaxPedido();
            $nextPedido = $maxPedido + 1;
        } catch (Exception $e) {
            show_error($e->getMessage(), 500);
            return;
        }
		$data  = array(
			'presupuestos' => $this->Presupuesto_model->getPresu($id_uni_respon_usu),
			'comprobantes' => $this->Comprobante_Gasto_model->getComprobantesGastos($id_uni_respon_usu),
			'proveedores' => $this->Proveedores_model->getProveedores($id_uni_respon_usu),
			'fuentes' => $this->Registros_financieros_model->getFuentes($id_uni_respon_usu),
			'unidad' => $this->Unidad_academica_model->obtener_unidades_academicas($id_uni_respon_usu),
			'bienes_servicios' => $this->Bienes_Servicios_model->getBienesServicios($id_uni_respon_usu),
			'datos_vista' => $this->Comprobante_Gasto_model->obtener_datos_presupuesto(),
			'nextPedido' => $nextPedido

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
		$id_presupuesto= $datosFormulario['idpresupuesto'];

		if ($this->input->is_ajax_request()) {

			$datosFormulario = $datosCompletos['filas'];
			$filas = $datosCompletos['filas'];

			foreach ($filas as $fila) {
				// Ejemplo de cómo podrías procesar una fila
				$dataPedido = array(
					'id_pedido'=> $fila['id_pedido'], // Ajusta el nombre según tus datos
					'id_unidad' => $id_unidad,
					'fecha' => $fecha,
					'idpresupuesto' => $id_presupuesto,
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
	public function edit($id): void {
		// Verificar la sesión del usuario
		$nombre = $this->session->userdata('Nombre_usuario');
		$id_user = $this->Usuarios_model->getUserIdByUserName($nombre);
		$id_uni_respon_usu = $this->Usuarios_model->getUserIdUniResponByUserId($id_user);
		// se obtiene el siguiente numero de pedido 
		try {
            $maxPedido = $this->Comprobante_Gasto_model->getMaxPedido();
            $nextPedido = $maxPedido + 1;
        } catch (Exception $e) {
            show_error($e->getMessage(), 500);
            return;
        }
	
		// Obtener los datos del comprobante específico a editar
		$comprobante = $this->Comprobante_Gasto_model->getComprobanteGasto($id);
		$id_pedido = $comprobante->id_pedido;
		$comprobantesPedido = $this->Comprobante_Gasto_model->obtener_comprobantes_por_pedido($id_pedido);
		$proveedor = $this->Proveedores_model->getProveedor($comprobante->idproveedor);


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
			'nextPedido' => $nextPedido
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
	        // Agrega esta línea para depurar
			error_log("Datos de filas recibidos: " . print_r($filas, true));

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
				// Verificar si existe IDComprobanteGasto
				$idComprobanteGasto = $fila['IDComprobanteGasto'] ?? null; // Usar operador de fusión null
	
				$dataFila = array(
					'id_pedido' => $fila['id_pedido'],
					'IDComprobanteGasto' => $idComprobanteGasto, // Ahora es seguro
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
	
				// Lógica corregida: Usar IDComprobanteGasto para determinar si es update o insert
				if ($idComprobanteGasto !== null) {
					// Actualizar si existe el ID
					$this->Comprobante_Gasto_model->updateFilaComprobanteGasto($idComprobanteGasto, $dataFila);
				} else {
					// Insertar nueva fila si no hay ID
					$this->Comprobante_Gasto_model->save($dataFila);
				}
			}
	
			echo "success";
		} else {
			$this->session->set_flashdata("error", "No se pudo actualizar la información");
			return redirect(base_url() . "patrimonio/comprobantegasto/");
		}
	}
	
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
	
	public function getCuentacontableRelacion(){
		$nombre=$this->session->userdata('Nombre_usuario');
		$id_user=$this->Usuarios_model->getUserIdByUserName($nombre);
		$id_uni_respon_usu = $this->Usuarios_model->getUserIdUniResponByUserId($id_user);
		$idpresupuesto = $this->input->post('idpresupuesto');
		$this->db->select('Idcuentacontable');
		$this->db->from('presupuestos');
		$this->db->where('ID_Presupuesto', $idpresupuesto);
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			$idcuentacontable = $query->row()->Idcuentacontable;
			
			// Ahora, con el Idcuentacontable, obtenemos la relación desde la tabla cuentacontable
			$this->db->select('Relacion');
			$this->db->from('cuentacontable');
			$this->db->where('IDCuentaContable', $idcuentacontable);
			$queryRelacion = $this->db->get();
	
			if ($queryRelacion->num_rows() > 0) {
				$relacion = $queryRelacion->row()->relacion;
				echo json_encode(['Relacion' => explode(',', $relacion)]); // Devolver la relación como un array
			} else {
				echo json_encode(['Relacion' => []]);  // Si no se encuentra relación
			}
		} else {
			echo json_encode(['Relacion' => []]);  // Si no se encuentra el presupuesto
		}
	}
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
//esta función llama a la función en el modelo de la ejecución presupuestaria para verificar el saldo
	public function verificar_saldo() {
		$this->load->model('EjecucionP_model');
		$id_presupuesto = $this->input->post('id_presupuesto');
		
		try {
			$resultado = $this->EjecucionP_model->calcular_saldo_presupuestario($id_presupuesto);
			
			if(isset($resultado['error'])) {
				throw new Exception($resultado['error']);
			}
			
			$this->output
				->set_content_type('application/json')
				->set_output(json_encode([
					'status' => 'success',
					'saldo' => number_format($resultado['saldo'], 2),
					'presupuesto' => number_format($resultado['presupuesto'], 2),
					'ejecutado' => number_format($resultado['ejecutado'], 2)
				]));
				
		} catch (Exception $e) {
			$this->output
				->set_content_type('application/json')
				->set_output(json_encode([
					'status' => 'error',
					'message' => $e->getMessage()
				]));
		}
	}
}