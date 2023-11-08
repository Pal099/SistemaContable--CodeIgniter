<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Presupuesto extends CI_Controller
{

	//private $permisos;
	public function __construct()
	{
		parent::__construct();
		//	$this->permisos= $this->backend_lib->control();
		$this->load->model("Presupuesto_model");
		$this->load->model("Registros_financieros_model");
		$this->load->model("Origen_model");
		$this->load->model('ProgramGasto_model');
		$this->load->model('Cuentas_model');
		$this->load->model('EjecucionP_model');
	}


	public function index()
	{
		$data = array(
			'presupuestos' => $this->Presupuesto_model->getPresu(),
			'descripciones' => $this->Cuentas_model->getCuentas(),
			'registros_financieros' => $this->Registros_financieros_model->getFuentes(),
			'origen' => $this->Origen_model->getOrigenes(),
			'programa' => $this->ProgramGasto_model->getProgramGastos(),
			'ejecucionpresupuestaria' => $this->EjecucionP_model->getEjecucionesP(),
		);

		$this->load->view("layouts/header");
		$this->load->view("layouts/aside");
		$this->load->view("admin/presupuesto/list", $data);
		$this->load->view("layouts/footer");

	}

	public function add()
	{
		$data = array(
			'presupuesto' => $this->Presupuesto_model->getPresupuestos(),
			'registros_financieros' => $this->Registros_financieros_model->getFuentes(),
			'origen' => $this->Origen_model->getOrigenes(),
			'programa' => $this->ProgramGasto_model->getProgramGastos(),
			'descripciones' => $this->Cuentas_model->getCuentas(),
		);

		$this->load->view("layouts/header");
		$this->load->view("layouts/aside");
		$this->load->view("admin/presupuesto/add", $data);
		$this->load->view("layouts/footer");
	}

	public function store()
	{

		$id_presupuesto = $this->input->post("ID_Presupuesto");
		$año = $this->input->post("Año");
		$descripcion = $this->input->post("descripcion"); // Cambiar "descripcion" a "DescripcionCuentaContable"
		$totalpresupuestado = $this->input->post("TotalPresupuestado");
		$origen_de_financiamiento = $this->input->post("origen_de_financiamiento");
		$programa_id_pro = $this->input->post("programa_id_pro");
		$fuente_de_financiamiento = $this->input->post("fuente_de_financiamiento");
		$TotalModificado = $this->input->post("TotalModificado");
		$mes = $this->input->post("mes");
		$monto_mes = $this->input->post("monto_mes");

		$mes_actual = date('m');
		$monto_mes_pasado = 0;
		$excedente = 0;

		$data = array(
			'ID_Presupuesto' => $id_presupuesto,
			'Año' => $año,
			'descripcion' => $descripcion,
			'TotalPresupuestado' => $totalpresupuestado,
			'origen_de_financiamiento_id_of' => $origen_de_financiamiento,
			'programa_id_pro' => $programa_id_pro,
			'fuente_de_financiamiento_id_ff' => $fuente_de_financiamiento,
			'TotalModificado' => $TotalModificado,
			'mes' => $mes,
			'monto_mes' => $monto_mes,
			'estado' => "1"
		);
		$mes_cargado = date('m', strtotime($mes));
		$mes_siguiente = date('m', strtotime('+1 month'));
		$mes_anterior = date('m', strtotime('-1 month'));
		if ($mes_actual == "01" && $mes_cargado == "01") {

			if ($this->Presupuesto_model->save($data)) {
				redirect(base_url() . "mantenimiento/presupuesto");
			} else {
				$this->session->set_flashdata("error", "No se pudo guardar la informacion");
				redirect(base_url() . "mantenimiento/presupuesto/add");
			}
			$datos = array(
				'id_pro' => $this->input->post('programa_id_pro'),
				'id_ff' => $this->input->post('fuente_de_financiamiento'),
				'id_of' => $this->input->post('origen_de_financiamiento'),
				'Haber' => $this->input->post('TotalModificado'),
				'Debe' => $this->input->post('TotalPresupuestado'),
				'MontoPago' => $this->input->post('monto_mes'),
			);
		
			if ($this->Presupuesto_model->save2($datos)) {
				redirect(base_url() . "mantenimiento/presupuesto");
			}
			
		} elseif ($mes_actual == $mes_cargado) {

			$servername = "localhost";
			$username = "root";
			$password = "";
			$dbname = "contanuevo";
	
			$conn = new mysqli($servername, $username, $password, $dbname);
	
			if ($conn->connect_error) {
				die("Error en la conexión: " . $conn->connect_error);
			}
			$sql_monto_mes = "SELECT monto_mes FROM presupuesto WHERE mes = '$mes_anterior'";

			$sql_MontoEjecutado = "SELECT SUM(e.MontoEjecutado) AS totalMontoEjecutado 
			FROM ejecucionpresupuestaria e 
			INNER JOIN presupuesto p 
			ON e.presupuesto_ID_presupuesto = p.ID_presupuesto 
			WHERE p.mes = '$mes_anterior'";
			$result = $conn->query($sql_monto_mes);
			$result2 = $conn->query($sql_MontoEjecutado);
	
			if ($result->num_rows > 0) {
				while ($row = $result->fetch_assoc()) {
					$monto_mes_anterior = $row["monto_mes"];
				}
				while ($row = $result2->fetch_assoc()) {
					$total_monto_ejecutado = $row["totalMontoEjecutado"];
				}
			} else {
				echo "No se encontraron resultados para el mes anterior o monto ejecutado el mes anterior en la base de datos.";
			}

			$conn->close();
	
			$excedente = $monto_mes_anterior - $total_monto_ejecutado;
	
			$monto_mes += $excedente;
			if ($this->Presupuesto_model->save($data)) {
				redirect(base_url() . "mantenimiento/presupuesto");
			} else {
				$this->session->set_flashdata("error", "No se pudo guardar la informacion");
				redirect(base_url() . "mantenimiento/presupuesto/add");
			}
			$datos = array(
				'id_pro' => $this->input->post('programa_id_pro'),
				'id_ff' => $this->input->post('fuente_de_financiamiento'),
				'id_of' => $this->input->post('origen_de_financiamiento'),
				'Haber' => $this->input->post('TotalModificado'),
				'Debe' => $this->input->post('TotalPresupuestado'),
				'MontoPago' => $this->input->post('monto_mes'),
			);
		
			if ($this->Presupuesto_model->save2($datos)) {
				redirect(base_url() . "mantenimiento/presupuesto");
			}
			
	
	
		}/*elseif($mes_siguiente == $mes_cargado){ // falta ver como calcular si se carga antes de que se haya obligado todo el mes anterior
			$servername = "localhost";
			$username = "root";
			$password = "";
			$dbname = "contanuevo";
	
			$conn = new mysqli($servername, $username, $password, $dbname);
	
			if ($conn->connect_error) {
				die("Error en la conexión: " . $conn->connect_error);
			}
			$sql_monto_mes = "SELECT monto_mes FROM presupuesto WHERE mes = '$mes_anterior'";

			$sql_MontoEjecutado = "SELECT SUM(e.MontoEjecutado) AS totalMontoEjecutado 
			FROM ejecucionpresupuestaria e 
			INNER JOIN presupuesto p 
			ON e.presupuesto_ID_presupuesto = p.ID_presupuesto 
			WHERE p.mes = '$mes_anterior'";
			$result = $conn->query($sql_monto_mes);
			$result2 = $conn->query($sql_MontoEjecutado);
	
			if ($result->num_rows > 0) {
				while ($row = $result->fetch_assoc()) {
					$monto_mes_anterior = $row["monto_mes"];
				}
				while ($row = $result2->fetch_assoc()) {
					$total_monto_ejecutado = $row["totalMontoEjecutado"];
				}
			} else {
				echo "No se encontraron resultados para el mes anterior o monto ejecutado el mes anterior en la base de datos.";
			}

			$conn->close();
	
			$excedente = $monto_mes_anterior - $total_monto_ejecutado ;
	
			$monto_mes += $excedente;
			if ($this->Presupuesto_model->save($data)) {
				redirect(base_url() . "mantenimiento/presupuesto");
			} else {
				$this->session->set_flashdata("error", "No se pudo guardar la informacion");
				redirect(base_url() . "mantenimiento/presupuesto/add");
			}
	
		}*/
	}

	public function edit($id){
		$data = array(
			'presupuesto' => $this->Presupuesto_model->getPresupuesto($id),
			'registros_financieros' => $this->Registros_financieros_model->getFuentes(),
			'origen' => $this->Origen_model->getOrigenes(),
			'programa' => $this->ProgramGasto_model->getProgramGastos(),
		);
		$this->load->view("layouts/header");
		$this->load->view("layouts/aside");
		$this->load->view("admin/presupuesto/edit", $data);
		$this->load->view("layouts/footer");
	}

	public function update(){
		$id = $this->input->post("ID_Presupuesto");
		$año = $this->input->post("Año");
		$descripcion = $this->input->post("Descripcion");
		$totalpresupuestado = $this->input->post("TotalPresupuestado");
		$origen_de_financiamiento_id_of = $this->input->post("origen_de_financiamiento_id_of");
		$programa_id_pro = $this->input->post("programa_id_pro");
		$fuente_de_financiamiento_id_ff = $this->input->post("fuente_de_financiamiento_id_ff");
		$TotalModificado = $this->input->post("TotalModificado");
		$mes = $this->input->post("mes");
		$monto_mes = $this->input->post("monto_mes");

		$presupuestoactual = $this->Presupuesto_model->getPresupuesto($id);
		$data = array(
			'ID_Presupuesto' => $id,
			'Año' => $año,
			'Descripcion' => $descripcion,
			'TotalPresupuestado' => $totalpresupuestado,
			'origen_de_financiamiento_id_of' => $origen_de_financiamiento_id_of,
			'programa_id_pro' => $programa_id_pro,
			'fuente_de_financiamiento_id_ff' => $fuente_de_financiamiento_id_ff,
			'TotalModificado' => $TotalModificado,
			'mes' => $mes,
			'monto_mes' => $monto_mes,
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
			'descripcion' => $this->Cuentas_model->getCuentas(),
		);
		$this->load->view("admin/presupuesto/view", $data);
	}

	public function delete($id)
	{
		$data = array(
			'estado' => "0",
		);
		$this->Presupuesto_model->update($id, $data);
		echo "mantenimiento/presupuesto";
	}
}