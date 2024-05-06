<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Presupuesto extends CI_Controller {


	//private $permisos;
	public function __construct(){
		parent::__construct();
	//	$this->permisos= $this->backend_lib->control();
	$this->load->model("Presupuesto_model");
	$this->load->model("Registros_financieros_model");
	$this->load->model("Origen_model");
	$this->load->model('ProgramGasto_model');
	$this->load->model('Cuentas_model');
	$this->load->model('CuentaContable_model');
	$this->load->model('Usuarios_model');
	$this->load->model('EjecucionP_model'); 
	}






	
	public function index()
	{
		//Con la libreria Session traemos los datos del usuario
		//Obtenemos el nombre que nos va servir para obtener su id
		$nombre=$this->session->userdata('Nombre_usuario');

		//Con el método getUserIdByUserName en el modelo del usuario, nos devuelve el id
		//id conseguido mediante el nombre del usuario
		$id_user=$this->Usuarios_model->getUserIdByUserName($nombre);
		
		//Y finalmente, con el método getUserIdUniResponByUserId traemos el id_uni_respon_usu
		//esa id es importante para hacer las relaciones y registros por usuario
		$id_uni_respon_usu = $this->Usuarios_model->getUserIdUniResponByUserId($id_user);
		
		$data  = array(
			'presupuestos' => $this->Presupuesto_model->getPresu($id_uni_respon_usu),
			'registros_financieros' => $this->Registros_financieros_model->getFuentes($id_uni_respon_usu),
			'origen' => $this->Origen_model->getOrigenes($id_uni_respon_usu),
			'programa' => $this->ProgramGasto_model->getProgramGastos($id_uni_respon_usu),
			//'ejecucionpresupuestaria' => $this->EjecucionP_model->getEjecucionesP($id_uni_respon_usu),
			'cuentacontable'=>$this->CuentaContable_model->getCuentasContables($id_uni_respon_usu),
		);
		$mes=1;
		$idCuentaContable=1;
		$idOf =1;
		$idFf=1;
		$idPro=1;

		$resultado = $this->Presupuesto_model->sumarDebePorMes($mes, $idCuentaContable, $idOf, $idFf, $idPro);

        // Puedes hacer algo con el resultado, como pasarlos a la vista
        $data['resultado'] = $resultado;


		$this->load->view("layouts/header");
		$this->load->view("layouts/sideBar");
		$this->load->view("admin/presupuesto/list", $data);
		$this->load->view("layouts/footer");
	}

	public function add(){
		$nombre=$this->session->userdata('Nombre_usuario');
		$id_user=$this->Usuarios_model->getUserIdByUserName($nombre);
		$id_uni_respon_usu = $this->Usuarios_model->getUserIdUniResponByUserId($id_user);
		$data  = array(
			'presupuesto' => $this->Presupuesto_model->getPresu($id_uni_respon_usu),
			'registros_financieros' => $this->Registros_financieros_model->getFuentes($id_uni_respon_usu),
			'origen' => $this->Origen_model->getOrigenes($id_uni_respon_usu),
			'programa' => $this->ProgramGasto_model->getProgramGastos($id_uni_respon_usu),
			'cuentacontable' => $this->CuentaContable_model->getCuentasContables($id_uni_respon_usu),
		);

		$this->load->view("layouts/header");
		$this->load->view("layouts/sideBar");
		$this->load->view("admin/presupuesto/add", $data);
		$this->load->view("layouts/footer");
	}

	public function store() {
		$nombre = $this->session->userdata('Nombre_usuario');
		$id_user = $this->Usuarios_model->getUserIdByUserName($nombre);
		$id_uni_respon_usu = $this->Usuarios_model->getUserIdUniResponByUserId($id_user);
		
		$año = $this->input->post("Año");
		$descripcion = $this->input->post("cuentacontable");
		$totalpresupuestado = $this->input->post("TotalPresupuestado");
		$origen_de_financiamiento_id_of = $this->input->post("origen_de_financiamiento");
		$programa_id_pro = $this->input->post("programa_id_pro");
		$fuente_de_financiamiento_id_ff = $this->input->post("fuente_de_financiamiento");
		$TotalModificado = $this->input->post("TotalModificado");
		$mesSeleccionado = $this->input->post('mes');
		$preMes = $this->input->post("pre_" . $mesSeleccionado);
	

		$excedenteMesAnterior = $this->Presupuesto_model->obtenerDatosPresupuestoAnterior($origen_de_financiamiento_id_of, $fuente_de_financiamiento_id_ff, $programa_id_pro, $descripcion, $mesSeleccionado);

		echo "Excedente del mes anterior: " . $excedenteMesAnterior . "<br>";
		$debeMesAnterior = $this->Presupuesto_model->sumarDebePorMes($mesSeleccionado, $descripcion, $origen_de_financiamiento_id_of, $fuente_de_financiamiento_id_ff, $programa_id_pro);
	

		$excedente= $excedenteMesAnterior - $debeMesAnterior;
	
		// Sumar el excedente al presupuesto del nuevo mes
		$preMes += $excedente;

		// Obtener la suma del debe del mes anterior
	
		// Construir el array de datos para guardar el nuevo presupuesto
		$data = array(
			'Año' => $año,
			'idcuentacontable' => $descripcion,
			'TotalPresupuestado' => $totalpresupuestado,
			'origen_de_financiamiento_id_of' => $origen_de_financiamiento_id_of,
			'programa_id_pro' => $programa_id_pro,
			'fuente_de_financiamiento_id_ff' => $fuente_de_financiamiento_id_ff,
			'TotalModificado' => $TotalModificado,
			'id_uni_respon_usu' => $id_uni_respon_usu,
			'estado' => "1"
		);
	
		// Añadir valores de los campos de mes al array
		$meses = array('ene', 'feb', 'mar', 'abr', 'may', 'jun', 'jul', 'ago', 'sep', 'oct', 'nov', 'dic');
		foreach ($meses as $mes) {
			$campoMes = "pre_" . $mes;
			$data[$campoMes] = ($mes == $mesSeleccionado);
		}

	
		// Guardar el nuevo presupuesto
		if ($this->Presupuesto_model->save($data)) {
			redirect(base_url() . "mantenimiento/presupuesto");
		} else {
			redirect(base_url() . "mantenimiento/presupuesto/add");
		}
	}
	
	
	
	public function calcularExcedenteInicioMes() {
		// Obtener la fecha actual
		$fechaActual = date('Y-m-d');
		
		// Obtener el mes y el año actual
		$mesActual = date('n', strtotime($fechaActual));
		$anioActual = date('Y', strtotime($fechaActual));
	
		// Calcular el mes anterior
		$mesAnterior = $mesActual - 1;
		$anioAnterior = $anioActual;
		if ($mesAnterior == 0) {
			$mesAnterior = 12;
			$anioAnterior = $anioActual - 1;
		}
	
		// Obtener el excedente del mes anterior para cada presupuesto
		// Suponiendo que tengas los datos necesarios para obtener los ID de origen, fuente, programa y cuenta contable
		$idOf = 1; // Ejemplo de ID de origen de financiamiento
		$idFf = 1; // Ejemplo de ID de fuente de financiamiento
		$idPro = 3; // Ejemplo de ID de programa
		$idCuentaContable = 1; // Ejemplo de ID de cuenta contable
	
		// Llamar a la función en el modelo para obtener el excedente del mes anterior
		$excedenteMesAnterior = $this->Presupuesto_model->obtenerDatosPresupuestoAnterior($idOf, $idFf, $idPro, $idCuentaContable, $mesAnterior);
	
		// Sumar el excedente al presupuesto del nuevo mes
		// Suponiendo que tienes una función en el modelo para actualizar el presupuesto del nuevo mes
		$this->Presupuesto_model->sumarExcedenteAPresupuestoNuevo($idOf, $idFf, $idPro, $idCuentaContable, $mesActual, $excedenteMesAnterior);
	
		// Aquí podrías realizar alguna acción adicional si lo necesitas, como redirigir a otra página o mostrar un mensaje de éxito
		echo "Excedente del mes anterior calculado y sumado al presupuesto del nuevo mes exitosamente.";
	}
	
	public function edit($id){
		$nombre = $this->session->userdata('Nombre_usuario');
		$id_user = $this->Usuarios_model->getUserIdByUserName($nombre);
		$id_uni_respon_usu = $this->Usuarios_model->getUserIdUniResponByUserId($id_user);
		$data = array(
			'presupuesto' => $this->Presupuesto_model->getPresupuesto($id),
			'registros_financieros' => $this->Registros_financieros_model->getFuentes($id_uni_respon_usu),
			'origen' => $this->Origen_model->getOrigenes($id_uni_respon_usu),
			'programa' => $this->ProgramGasto_model->getProgramGastos($id_uni_respon_usu),
			'cuentacontable'=>$this->CuentaContable_model->getCuentasContables($id_uni_respon_usu),
		);
		$this->load->view("layouts/header");
		$this->load->view("layouts/aside");
		$this->load->view("admin/presupuesto/edit", $data);
		//$this->load->view("layouts/footer");
	}

	public function update(){
		$id = $this->input->post("ID_Presupuesto");
		$año = $this->input->post("Año");
		//$descripcion = $this->input->post("Descripcion");
		$totalpresupuestado = $this->input->post("TotalPresupuestado");
		$origen_de_financiamiento_id_of = $this->input->post("origen_de_financiamiento_id_of");
		$programa_id_pro = $this->input->post("programa_id_pro");
		$fuente_de_financiamiento_id_ff = $this->input->post("fuente_de_financiamiento_id_ff");
		$TotalModificado = $this->input->post("TotalModificado");
		$Idcuentacontable = $this->input->post("Idcuentacontable");
		$pre_ene = $this->input->post("pre_ene");
		$pre_feb = $this->input->post("pre_feb");
		$pre_mar = $this->input->post("pre_mar");
		$pre_abr = $this->input->post("pre_abr");
		$pre_may = $this->input->post("pre_may");
		$pre_jun = $this->input->post("pre_jun");
		$pre_jul = $this->input->post("pre_jul");
		$pre_ago = $this->input->post("pre_ago");
		$pre_sep = $this->input->post("pre_sep");
		$pre_oct = $this->input->post("pre_oct");
		$pre_nov = $this->input->post("pre_nov");
		$pre_dic = $this->input->post("pre_dic");

		$presupuestoactual = $this->Presupuesto_model->getPresupuesto($id);
		$data = array(
			'ID_Presupuesto' => $id,
			'Año' => $año,
			//'Descripcion' => $descripcion,
			'TotalPresupuestado' => $totalpresupuestado,
			'origen_de_financiamiento_id_of' => $origen_de_financiamiento_id_of,
			'programa_id_pro' => $programa_id_pro,
			'fuente_de_financiamiento_id_ff' => $fuente_de_financiamiento_id_ff,
			'TotalModificado' => $TotalModificado,
			'Idcuentacontable' => $Idcuentacontable,
			'pre_ene' => $pre_ene,
			'pre_feb' => $pre_feb,
			'pre_mar' => $pre_mar,
			'pre_abr' => $pre_abr,
			'pre_may' => $pre_may,
			'pre_jun' => $pre_jun,
			'pre_jul' => $pre_jul,
			'pre_ago' => $pre_ago,
			'pre_sep' => $pre_sep,
			'pre_oct' => $pre_oct,
			'pre_nov' => $pre_nov,
			'pre_dic' => $pre_dic,
			'estado' => "1"
		);
		if ($this->Presupuesto_model->update($id, $data)) {
			redirect(base_url() . "mantenimiento/presupuesto");
		} else {
			$this->session->set_flashdata("error", "No se pudo actualizar la informacion");
			redirect(base_url() . "mantenimiento/presupuesto/edit/" . $id);
		}
		
	}

	public function view($id){
		$data = array(
			'presupuestos' => $this->Presupuesto_model->getPresupuesto($id),
			'registros_financieros' => $this->Registros_financieros_model->getFuentes(),
			'origen' => $this->Origen_model->getOrigenes(),
			'programa' => $this->ProgramGasto_model->getProgramGastos(),
			'cuentacontable' => $this->CuentaContable_model->getCuentasContables(),
		);
		$this->load->view("admin/presupuesto/view", $data);
	}

	public function delete($id){
		$data = array(
			'estado' => "0",
		);
		$this->Presupuesto_model->update($id, $data);
		redirect(base_url() . "mantenimiento/presupuesto");
	
	}

	public function getPresupuestoDetalle($id) {
		$presupuestoDetalle = $this->Presupuesto_model->getPresupuesto($id);
		echo json_encode($presupuestoDetalle);
	}
}