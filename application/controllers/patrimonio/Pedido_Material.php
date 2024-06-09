<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pedido_Material extends MY_Controller
{

	//private $permisos;
	public function __construct()
	{
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
		$nombre = $this->session->userdata('Nombre_usuario');
		$id_user = $this->Usuarios_model->getUserIdByUserName($nombre);
		$id_uni_respon_usu = $this->Usuarios_model->getUserIdUniResponByUserId($id_user);
		$data = array(
			'pedidos' => $this->Pedido_Material_model->getPedidosMateriales($id_uni_respon_usu),
			'proveedores' => $this->Proveedores_model->getProveedores($id_uni_respon_usu),
			'fuentes' => $this->Registros_financieros_model->getFuentes($id_uni_respon_usu),
			'bienes' => $this->Bienes_Servicios_model->getBienesServicios($id_uni_respon_usu),
			'unidad' => $this->Unidad_academica_model->obtener_unidades_academicas($id_uni_respon_usu),

		);
		//var_dump($data['proveedores']);
		$this->load->view("layouts/header");
		$this->load->view("layouts/sideBar");
		$this->load->view("admin/pedidomaterial/list", $data);
		$this->load->view("layouts/footer");
	}

	public function filtrar()
	{
		$nombre = $this->session->userdata('Nombre_usuario');
		$id_user = $this->Usuarios_model->getUserIdByUserName($nombre);
		$id_uni_respon_usu = $this->Usuarios_model->getUserIdUniResponByUserId($id_user);
		$id = $this->input->post("IDPedidoMaterial");
		$actividad = $this->input->post("actividad");
		$pedido = $this->input->post("pedido");
		$mes = $this->input->post("mes");
		$anio = $this->input->post("anio");

		if (empty($actividad) && empty($pedido) && empty($anio) && empty($mes)) {
			// Ningún campo seleccionado, redireccionar o mostrar un mensaje de error
			redirect(base_url() . "patrimonio/pedidomaterial");
		}
		$data = array(
			'pedidos' => $this->Pedido_Material_model->getPedidosMaterialesFiltrados($actividad, $pedido, $mes, $anio),
			'proveedores' => $this->Proveedores_model->getProveedores($id_uni_respon_usu),
			'fuentes' => $this->Registros_financieros_model->getFuentes($id_uni_respon_usu),
			'unidad' => $this->Unidad_academica_model->obtener_unidades_academicas($id_uni_respon_usu),
			'bienes_servicios' => $this->Bienes_Servicios_model->getBienesServicios($id_uni_respon_usu),
		);
		$this->load->view("layouts/header");
		$this->load->view("layouts/sideBar");
		$this->load->view("admin/pedidomaterial/list", $data);
		$this->load->view("layouts/footer");

	}

	public function add()
	{
		$nombre = $this->session->userdata('Nombre_usuario');
		$id_user = $this->Usuarios_model->getUserIdByUserName($nombre);
		$id_uni_respon_usu = $this->Usuarios_model->getUserIdUniResponByUserId($id_user);
		$data = array(
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
		$id_pedido = $datosFormulario['IDPedidoMaterial'];
		$fecha = $datosFormulario['fecha'];

		if ($this->input->is_ajax_request()) {

			$datosFormulario = $datosCompletos['filas'];
			$filas = $datosCompletos['filas'];

			foreach ($filas as $fila) {
				// Ejemplo de cómo podrías procesar una fila
				$dataPedido = array(
					'idpedido' => $id_pedido, // Ajusta el nombre según tus datos
					'id_bien' => $fila['idbien'],
					'id_unidad' => $id_unidad,
					'fecha' => $fecha,
					'concepto' => $fila['descripcion'],
					'preciounit' => $fila['precioUnit'],
					'cantidad' => $fila['cantidad'],
					'iva' => $fila['piva'],
					'porcentaje_iva' => $fila['piva'],
					'exenta' => $fila['exenta'],
					'gravada' => $fila['gravada'],
					'id_uni_respon_usu' => $id_uni_respon_usu,
					'estado' => "1",
				);

				$this->Pedido_Material_model->savePedido($dataPedido);


			}

			echo "success";
		} else {
			$this->session->set_flashdata("error", "No se pudo guardar la información");
			return redirect(base_url() . "patrimonio/pedidomaterial/add");
		}
	}


	public function edit($id)
	{
		$nombre = $this->session->userdata('Nombre_usuario');
		$id_user = $this->Usuarios_model->getUserIdByUserName($nombre);
		$id_uni_respon_usu = $this->Usuarios_model->getUserIdUniResponByUserId($id_user);

		$pedidos = $this->Pedido_Material_model->getPedidoMaterial($id);
		$bienes = $this->Bienes_Servicios_model->getBienesServicios($id_uni_respon_usu);
		
		$bienEn = null;
		foreach ($bienes as $bien) {
			if ($bien->IDbienservicio == $pedidos->id_bien) {
				$bienEn = $bien;
				break;
			}
		}
		
		$data = array(
			'pedidos' => $this->Pedido_Material_model->getPedidosMateriales($id_uni_respon_usu),
			'proveedores' => $this->Proveedores_model->getProveedores($id_uni_respon_usu),
			'fuentes' => $this->Registros_financieros_model->getFuentes($id_uni_respon_usu),
			'unidad' => $this->Unidad_academica_model->obtener_unidades_academicas($id_uni_respon_usu),
			'bienes_servicios' => $this->Bienes_Servicios_model->getBienesServicios($id_uni_respon_usu),
			'bien' => $bienEn,
			'pedido' => $pedidos,
		);

		$this->load->view("layouts/header");
		$this->load->view("layouts/sideBar");
		$this->load->view("admin/pedidomaterial/edit", $data);
		$this->load->view("layouts/footer");
	}

	public function update()
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
		$id_pedido = $datosFormulario['npedido'];
		$idnumpedido = $datosFormulario['IDPedidoMaterial'];

		if ($this->input->is_ajax_request()) {

			$filas = $datosCompletos['filas'];

			foreach ($filas as $fila) {
				// Procesar cada fila y actualizar
				$dataPedido = array(
					'idpedido' => $id_pedido, // Usar el ID de pedido proporcionado
					'id_bien' => $fila['idbien'],
					'id_unidad' => $id_unidad,
					'fecha' => $fecha,
					'concepto' => $fila['descripcion'],
					'preciounit' => $fila['precioUnit'],
					'cantidad' => $fila['cantidad'],
					'iva' => $fila['piva'],
					'porcentaje_iva' => $fila['piva'],
					'exenta' => $fila['exenta'],
					'gravada' => $fila['gravada'],
					'id_uni_respon_usu' => $id_uni_respon_usu,
					'estado' => "1",
				);

				$this->Pedido_Material_model->update($idnumpedido, $dataPedido);
			}

			echo "success";
		} else {
			$this->session->set_flashdata("error", "No se pudo actualizar la información");
			return redirect(base_url() . "patrimonio/pedidomaterial/edit/" . $id_pedido);
		}
	}
	public function view($id)
	{
		$data = array(
			'pedidos' => $this->Pedido_Material_model->getPedidoMaterial($id),
		);
		$this->load->view("admin/pedidomaterial/view", $data);
	}

	public function delete($id)
	{
		$data = array(
			'estado' => "0",
		);
		$this->Pedido_Material_model->update($id, $data);
		redirect(base_url() . "patrimonio/pedido_material");
	}
	
}