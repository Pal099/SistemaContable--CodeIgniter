<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Diario_obligaciones extends CI_Controller {

	//private $permisos;
	public function __construct(){
		parent::__construct();
	//	$this->permisos= $this->backend_lib->control();
		$this->load->model("Proveedores_model");
		$this->load->model("ProgramGasto_model");
		$this->load->model("Diario_obli_model");
		
	}
	
	
	public function index() {
		$data['asientos'] = $this->Diario_obli_model->obtener_asientos();
		$data['proveedores'] = $this->Proveedores_model->getProveedores();  // Obtener la lista de proveedores
		$data['programa'] = $this->Diario_obli_model->getProgramas();  
		$data['fuente_de_financiamiento'] = $this->Diario_obli_model->getFuentesFinanciamiento();  
		$data['origen_de_financiamiento'] = $this->Diario_obli_model->getOrigenesFinanciamiento(); 
		$data['cuentacontable'] = $this->Diario_obli_model->getCuentasContables(); 

        $this->load->view("layouts/header");
        $this->load->view("layouts/aside");
        $this->load->view("admin/obligacion/obli_combined", $data);
        $this->load->view("layouts/footer");
    }
    
    public function get_proveedores() {
        $data  = array(
            'proveedores' => $this->Proveedores_model->getProveedores(),
			'programa' => $this->Diario_obli_model->getProgramas(),
			'fuente_de_financiamiento' => $this->Diario_obli_model->getFuentesFinanciamiento(),
			'origen_de_financiamiento' => $this->Diario_obli_model->getOrigenesFinanciamiento(),
        );
        echo json_encode($data);
    }
	
	public function add(){

		$data  = array(
			'proveedores' => $this->Proveedores_model->getProveedores(), // Agregar esta línea para obtener la lista de proveedores
			'programa' => $this->Diario_obli_model->getProgramas(),
			'fuente_de_financiamiento' => $this->Diario_obli_model->getFuentesFinanciamiento(),
			'origen_de_financiamiento' => $this->Diario_obli_model->getOrigenesFinanciamiento(),
			'cuentacontable' => $this->Diario_obli_model->getCuentaContable(),
		);
	
		$this->load->view("layouts/header");
		$this->load->view("layouts/aside");
		$this->load->view("admin/obligacion/obli_combined", $data); // Pasar los datos a la vista
		$this->load->view("layouts/footer");
	}

	public function store(){
		$numero = $this->input->post("numero");
		$contabilidad = $this->input->post("contabilidad");
		$direccion = $this->input->post("direccion");
        $telefono = $this->input->post("telefono");
		$observacion = $this->input->post("observacion");
		$fecha = $this->input->post("fecha");
        $tesoreria = $this->input->post("tesoreria");
		$comprobante = $this->input->post("comprobante");
		$programa_id_pro = $this->input->post("id_pro");
		$cuentacontable = $this->input->post("IDCuentaContable");
		$fuente_de_financiamiento = $this->input->post("id_ff");
		$orifen_de_financiamiento = $this->input->post("id_of");
		//-----------------//---------------------------
		$pedi_matricula = $this->input->post("pedi_matricula");
        $modalidad = $this->input->post("modalidad");
		$tipo_presupuesto = $this->input->post("tipo_presupuesto");
		$unidad_respon = $this->input->post("unidad_respon");
		$proyecto = $this->input->post("proyecto");
		$estado = $this->input->post("estado");
		$nro_pac = $this->input->post("nro_pac");
		$nro_exp = $this->input->post("nro_exp");
		$total = $this->input->post("total");
		$pagado = $this->input->post("pagado");
        $this->form_validation->set_rules("ruc","Ruc","required|is_unique[diario_obli.ruc]");

        if ($this->form_validation->run()==TRUE) {
			$data  = array(
                'ruc' => $ruc,
				'numero' => $numero, 
				'contabilidad' => $contabilidad,
				'direccion' => $direccion,
                'telefono' => $telefono,
                'observacion' => $observacion,
                'fecha' => $fecha,
                'tesoreria' => $tesoreria,
				'comprobante' => $comprobante,
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
				'estado_bd' => "1"
			);

			if ($this->Diario_obli_model->save($data)) {
				$lastInsertedId = $this->db->insert_id(); // Obtener el ID del último registro insertado en diario_obli
							// Datos para num_asi_deta (Asumo que estás obteniendo estos datos del formulario. Modifica según tus necesidades)
				$dataDetaDebe  = array(
					'Num_Asi_IDNum_Asi' => $lastInsertedId, 
					'IDCuentaContable' => $this->input->post("IDCuentaContable"),
					'MontoPago' => $this->input->post("MontoPago"),
					'Debe' => $this->input->post("Debe"),
					'Haber' => $this->input->post("Haber"),
					'comprobante' => $this->input->post("comprobante"),
					'id_of' => $this->input->post("id_of"),
					'id_pro' => $this->input->post("id_pro"),
					'id_ff' => $this->input->post("id_ff"),
					'cuentacontable' => $this->input->post("IDCuentaContable"),
					'cheques_che_id' => $this->input->post("cheques_che_id"),
					'proveedores_id' => $this->input->post("proveedores_id"),
					// 'id_user' => $this->input->post("id_user") // Asumo que obtienes el id_user de alguna manera
					'id_user' => "1"
				);
				$this->Diario_obli_model->insertar_detalle($dataDetaDebe);
				$dataDetaHaber = array(
					'Num_Asi_IDNum_Asi' => $lastInsertedId, 
					'IDCuentaContable' => $this->input->post("IDCuentaContable"),
					'MontoPago' => $this->input->post("MontoPago"),
					'Debe' => $this->input->post("Debe"),
					'Haber' => $this->input->post("Haber"),
					'comprobante' => $this->input->post("comprobante"),
					'id_of' => $this->input->post("id_of"),
					'id_pro' => $this->input->post("programa_id_pro"),
					'id_ff' => $this->input->post("id_ff"),
					'id_ff' => $this->input->post("id_ff"),
					'cuentacontable' => $this->input->post("IDCuentaContable"),
					'cheques_che_id' => $this->input->post("cheques_che_id"),
					'proveedores_id' => $this->input->post("proveedores_id"),
					// 'id_user' => $this->input->post("id_user") // Asumo que obtienes el id_user de alguna manera
					'id_user' => "1"
				);
				$this->Diario_obli_model->insertar_detalle($dataDetaHaber);

				if ($this->Diario_obli_model->insertar_detalle($dataDeta)) { // Función para guardar en num_asi_deta
					redirect(base_url() . "obligaciones/diario_obligaciones");
				} else {
					$this->session->set_flashdata("error", "No se pudo guardar la información en num_asi_deta");
					redirect(base_url() . "obligaciones/diario_obligaciones/add");
				}

			}
			else{
				$this->session->set_flashdata("error","No se pudo guardar la informacion");
				redirect(base_url()."obligaciones/diario_obligaciones/add");
			}
		}
		else{
			$this->add();
		}
			
	}

	public function edit($id){
		$data  = array(
			'obligaciones' => $this->Diario_obli_model->getDiario($id), 
		);
		$this->load->view("layouts/header");
		$this->load->view("layouts/aside");
		$this->load->view("admin/obligacion/obliedit",$data);
		$this->load->view("layouts/footer");
	}

	public function update(){
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
		$estado = $this->input->post("estado");
		$nro_pac = $this->input->post("nro_pac");
		$nro_exp = $this->input->post("nro_exp");
		$total = $this->input->post("total");
		$pagado = $this->input->post("pagado");
        $obligacionactual = $this->Diario_obli_model->getDiario($idobli);

		if ($ruc == $obligacionactual->ruc) {
			$is_unique = "";
		}else{
			$is_unique = "|is_unique[diario_obli.ruc]";
		}
        $this->form_validation->set_rules("ruc","Ruc","required".$is_unique);
        if ($this->form_validation->run()==TRUE) {

			$data  = array(
                'ruc' => $ruc,
				'numero' => $numero, 
				'contabilidad' => $contabilidad,
				'direccion' => $direccion,
                'telefono' => $telefono,
                'observacion' => $observacion,
                'fecha' => $fecha,
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
				'estado_bd' => "1"
			);

			if ($this->Diario_obli_model->save($idobli,$data)) {
				redirect(base_url()."obligaciones/diario_obligaciones");
			}
			else{
				$this->session->set_flashdata("error","No se pudo guardar la informacion");
				redirect(base_url()."obligaciones/diario_obligaciones/add".$idobli);
			}
		}
		else{
			$this->edit($idobli);
		}
		
	}

	public function view($id){
		$data  = array(
			'obligaciones' => $this->Diario_obli_model->getDiario($id), 
		);
		$this->load->view("admin/obligacion/obliview",$data);
	}

	public function delete($id){
		$data  = array(
			'estado_bd' => "0", 
		);
		$this->Diario_obli_model->update($id,$data);
		echo "obligaciones/diario_obligaciones";
	}
}
