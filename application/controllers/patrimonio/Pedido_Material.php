<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pedido_Material extends MY_Controller {

	//private $permisos;
	public function __construct(){
		parent::__construct();
	//	$this->permisos= $this->backend_lib->control();
		$this->load->model("Pedido_Material_model");
		$this->load->model("Bienes_Servicios_model");
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
			'pedidos' => $this->Pedido_Material_model->getPedidosMateriales($id_uni_respon_usu),
			'proveedores' => $this->Proveedores_model->getProveedores($id_uni_respon_usu),
			'fuentes' => $this->Registros_financieros_model->getFuentes($id_uni_respon_usu),
			'bienes' => $this->Bienes_Servicios_model->getBienesServicios($id_uni_respon_usu),
			'unidad' => $this->Unidad_academica_model->obtener_unidades_academicas($id_uni_respon_usu),
			
		);
		//var_dump($data['proveedores']);
		$this->load->view("layouts/header");
		$this->load->view("layouts/sideBar");
		$this->load->view("admin/pedidomaterial/list",$data);
		$this->load->view("layouts/footer");
	}

	public function filtrar()
	{
		$nombre=$this->session->userdata('Nombre_usuario');
		$id_user=$this->Usuarios_model->getUserIdByUserName($nombre);
		$id_uni_respon_usu = $this->Usuarios_model->getUserIdUniResponByUserId($id_user);
		$id = $this->input->post("IDPedidoMaterial");
		$actividad = $this->input->post("actividad");
		$pedido = $this->input->post("pedido");
		$mes = $this->input->post("mes");
		$anio= $this->input->post("anio");

		if (empty($actividad) && empty($pedido) && empty($anio) && empty($mes)) {
			// Ningún campo seleccionado, redireccionar o mostrar un mensaje de error
			redirect(base_url() . "patrimonio/pedidomaterial");
		}
		$data  = array(
			'pedidos' => $this->Pedido_Material_model->getPedidosMaterialesFiltrados($actividad, $pedido, $mes, $anio),
			'proveedores' => $this->Proveedores_model->getProveedores($id_uni_respon_usu),
			'fuentes' => $this->Registros_financieros_model->getFuentes($id_uni_respon_usu),
			'unidad' => $this->Unidad_academica_model->obtener_unidades_academicas($id_uni_respon_usu),
			'bienes_servicios' => $this->Bienes_Servicios_model->getBienesServicios($id_uni_respon_usu),
		);
		$this->load->view("layouts/header");
		$this->load->view("layouts/sideBar");
		$this->load->view("admin/pedidomaterial/list",$data);
		$this->load->view("layouts/footer");

	}

	public function add(){
		$nombre=$this->session->userdata('Nombre_usuario');
		$id_user=$this->Usuarios_model->getUserIdByUserName($nombre);
		$id_uni_respon_usu = $this->Usuarios_model->getUserIdUniResponByUserId($id_user);
		$data  = array(
			'pedidos' => $this->Pedido_Material_model->getPedidosMateriales($id_uni_respon_usu),
			'proveedores' => $this->Proveedores_model->getProveedores($id_uni_respon_usu),
			'fuentes' => $this->Registros_financieros_model->getFuentes($id_uni_respon_usu),
			'unidad' => $this->Unidad_academica_model->obtener_unidades_academicas($id_uni_respon_usu),
			'bienes_servicios' => $this->Bienes_Servicios_model->getBienesServicios($id_uni_respon_usu),
		);
		$this->load->view("layouts/header");
		$this->load->view("layouts/sideBar");
		$this->load->view("admin/pedidomaterial/add", $data);
		$this->load->view("layouts/footer");
	}

	public function store() {
		$nombre = $this->session->userdata('Nombre_usuario');
		$id_user = $this->Usuarios_model->getUserIdByUserName($nombre);
		$id_uni_respon_usu = $this->Usuarios_model->getUserIdUniResponByUserId($id_user);
	
		// Recopilar datos generales del pedido
		$id_unidad = $this->input->post("id_unidad");
		$id_pedido = $this->input->post("idpedido");
		$fecha = $this->input->post("fecha");
	
		// Crear un array multidimensional para almacenar los datos de los ítems del pedido
		$items = array();
	
		// Recorrer los datos de los ítems del formulario y guardarlos en el array
		foreach ($this->input->post("rubro") as $key => $rubro) {
			$rubro = $_POST["rubro"][$key];
			$descripcion = $_POST["descripcion"][$key];
			$precio_unit = $_POST["precioUnit"][$key];
			$cantidad = $_POST["cantidad"][$key];
			$iva = isset($_POST["iva"][$key]) ? 1 : 0; // Convertir el valor del checkbox de IVA a 1 o 0
			$porcentaje_iva = $_POST["porcentajeIVA"][$key];
			$exenta = $iva ? 0 : $precio_unit; // Calcular el valor de exenta según la presencia de IVA
			$gravada = $iva ? $precio_unit : 0; // Calcular el valor de gravada según la presencia de IVA
	
			// Agregar los datos del ítem al array multidimensional
			$items[] = array(
				'id_unidad' => $id_unidad,
				'id_pedido' => $id_pedido,
				'fecha' => $fecha,
				'rubro' => $rubro,
				'descripcion' => $descripcion,
				'precioUnit' => $precio_unit,
				'cantidad' => $cantidad,
				'iva' => $iva,
				'porcentajeIVA' => $porcentaje_iva,
				'exenta' => $exenta,
				'gravada' => $gravada,
				'id_uni_respon_usu' => $id_uni_respon_usu,
				'estado' => 1 
			);
		}
	
		// Guardar los datos del pedido y de los ítems en la base de datos
		if ($this->Pedido_Material_model->savePedidoYItems($id_pedido, $items)) {
			redirect(base_url() . "patrimonio/pedido_material");
		} else {
			$this->session->set_flashdata("error", "No se pudo guardar la información");
			redirect(base_url() . "patrimonio/pedidomaterial/add");
		}
	}
	
	
	public function edit($id){
		$data  = array(
			'pedidos' => $this->Pedido_Material_model->getPedidoMaterial($id), 
		);
		$this->load->view("layouts/header");
		$this->load->view("layouts/sideBar");
		$this->load->view("admin/pedidomaterial/edit",$data);
		$this->load->view("layouts/footer");
	}

	public function update(){
		$IDPedidoMaterial = $this->input->post("IDPedidoMaterial");
		$id_unidad = $this->input->post("id_unidad");
		$idpedido= $this->input->post("idpedido");
		$concepto= $this->input->post("concepto");
		$fecha = $this->input->post("fecha");
		$id_bien = $this->input->post("id_bien");
		$preciounit = $this->input->post("preciounit");
		$cantidad = $this->input->post("cantidad");
		$iva = $this->input->post("iva");
		$exenta = $this->input->post("exenta");
		$gravada = $this->input->post("gravada");

		$comprobanteactual = $this->Pedido_Material_model->getPedidoMaterial($IDPedidoMaterial);

			$data = array(
				'id_unidad' => $id_unidad,
				'fecha' => $fecha,
				'idpedido' => $idpedido,
				'concepto' => $concepto,
				'id_bien' => $id_bien,
				'preciounit' => $preciounit,
				'cantidad' => $cantidad,
				'iva' => $iva,
				'exenta' => $exenta,
				'gravada' => $gravada,

			);

			if ($this->Pedido_Material_model->update($IDPedidoMaterial,$data)) {
				redirect(base_url()."patrimonio/pedidomaterial");
			}
			else{
				$this->session->set_flashdata("error","No se pudo actualizar la informacion");
				redirect(base_url()."patrimonio/pedidomaterial/edit/".$IDPedidoMaterial);
			}
		
	}
	
	public function view($id){
		$data  = array(
			'pedidos' => $this->Pedido_Material_model->getPedidoMaterial($id), 
		);
		$this->load->view("admin/pedidomaterial/view",$data);
	}

	public function delete($id){
		$data  = array(
			'estado' => "0", 
		);
		$this->Pedido_Material_model->update($id,$data);
		redirect(base_url() . "patrimonio/pedidomaterial");
	}
	public function getPedidoDetalle($id) {
		$PedidoDetalle = $this->Pedido_Material_model->getPedidoMaterial($id);
		echo json_encode($PedidoDetalle);
	}
}