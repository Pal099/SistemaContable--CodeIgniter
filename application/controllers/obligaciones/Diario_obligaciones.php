<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Diario_obligaciones extends CI_Controller {

	//private $permisos;
	public function __construct(){
		parent::__construct();
	//	$this->permisos= $this->backend_lib->control();
		$this->load->model("Proveedores_model");
		$this->load->model("ProgramGasto_model");
		$this->load->model("Pago_obli_model");
		$this->load->model("Diario_obli_model");
		$this->load->model("Usuarios_model");
		$this->load->library('form_validation');

	}
	
	
	
	
	public function index() {
		//Con la libreria Session traemos los datos del usuario
		//Obtenemos el nombre que nos va servir para obtener su id
		$nombre=$this->session->userdata('Nombre_usuario'); 

		//Con el método getUserIdByUserName en el modelo del usuario, nos devuelve el id
		//id conseguido mediante el nombre del usuario
		$id_user=$this->Usuarios_model->getUserIdByUserName($nombre);
		
		//Y finalmente, con el método getUserIdUniResponByUserId traemos el id_uni_respon_usu
		//esa id es importante para hacer las relaciones y registros por usuario
		$id_uni_respon_usu = $this->Usuarios_model->getUserIdUniResponByUserId($id_user);

		$data['asientos'] = $this->Diario_obli_model->obtener_asientos();
		$data['proveedores'] = $this->Proveedores_model->getProveedores($id_uni_respon_usu);  // Obtener la lista de proveedores
		$data['programa'] = $this->Diario_obli_model->getProgramGastos($id_uni_respon_usu);
		$data['fuente_de_financiamiento'] = $this->Diario_obli_model->getFuentes($id_uni_respon_usu);  
		$data['origen_de_financiamiento'] = $this->Diario_obli_model->getOrigenes($id_uni_respon_usu);
		//$data['cuentacontable'] = $this->Diario_obli_model->getCuentasContables($id_uni_respon_usu); 

        $this->load->view("layouts/header");
        $this->load->view("layouts/aside");
        $this->load->view("admin/obligacion/obli_combined", $data);
        $this->load->view("layouts/footer");
		$this->load->view("fpdf");

    }


	public function pdfs(){
		$this->load->view("fpdf");

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

		$nombre=$this->session->userdata('Nombre_usuario');
		$id_user=$this->Usuarios_model->getUserIdByUserName($nombre);
		$id_uni_respon_usu = $this->Usuarios_model->getUserIdUniResponByUserId($id_user);

		$data  = array(
			'proveedores' => $this->Proveedores_model->getProveedores($id_uni_respon_usu), // Agregar esta línea para obtener la lista de proveedores
			'programa' => $this->Diario_obli_model->getProgramGastos($id_uni_respon_usu),
			'fuente_de_financiamiento' => $this->Diario_obli_model->getFuentes($id_uni_respon_usu),
			'origen_de_financiamiento' => $this->Diario_obli_model->getOrigenes($id_uni_respon_usu),
			'cuentacontable' => $this->Diario_obli_model->getCuentasContables($id_uni_respon_usu),
		);

		$this->load->view("layouts/header");
		$this->load->view("layouts/aside");
		$this->load->view("admin/obligacion/obli_combined", $data); // Pasar los datos a la vista
		$this->load->view("layouts/footer");
	}

    public function store(){
			$nombre=$this->session->userdata('Nombre_usuario');
			$id_user=$this->Usuarios_model->getUserIdByUserName($nombre);
			$id_uni_respon_usu = $this->Usuarios_model->getUserIdUniResponByUserId($id_user);
			$ruc_id_provee = $this->input->post("ruc");
			$numero = $this->input->post("num_asi");
			$id_num_asi = $this->input->post("IDNum_Asi");
			$contabilidad = $this->input->post("contabilidad");
			$direccion = $this->input->post("direccion");
			$telefono = $this->input->post("telefono");
			$observacion = $this->input->post("observacion");
			$fecha = $this->input->post("fecha");
			$debe = floatval($this->input->post("Debe"));
			$haber_2 = floatval($this->input->post("Haber_2"));
			$tesoreria = $this->input->post("tesoreria");
			$comprobante = $this->input->post("comprobante");
			$cheque_id = $this->input->post("cheques_che_id");
			$programa_id_pro = $this->input->post("id_pro");
			$cuentacontable = $this->input->post("cuentacontable");
			$fuente_de_financiamiento = $this->input->post("id_ff");
			$origen_de_financiamiento = $this->input->post("id_of");
			//-----------------//---------------------------
			$pedi_matricula = $this->input->post("pedi_matricula");
			$MontoPago = floatval($this->input->post("MontoPago"));
			$modalidad = $this->input->post("modalidad");
			$tipo_presupuesto = $this->input->post("tipo_presupuesto");
			$unidad_respon = $this->input->post("unidad_respon");
			$proyecto = $this->input->post("proyecto");
			$estado = $this->input->post("estado");
			$nro_pac = $this->input->post("nro_pac");
			$nro_exp = $this->input->post("nro_exp");
			$total = $this->input->post("total");
			$pagado = floatval($this->input->post("pagado"));
			$proveedor_id = $this->Diario_obli_model->getProveedorIdByRuc($ruc_id_provee); //Obtenemos el proveedor en base al ruc
			$this->form_validation->set_rules("Debe_2", "debe_2", "required|is_unique[num_asi_deta.Debe]");
			$this->form_validation->set_rules("Haber_2", "haber_2", "required|is_unique[num_asi_deta.Haber]");
			$this->form_validation->set_rules('Debe', 'Debe', 'matches[Haber_2]', array('matches' => 'El campo Debe debe ser igual al campo Haber_2.'));
	
			if ($proveedor_id) {
				if ($this->form_validation->run() == TRUE) {
					$dataNum_Asi = array(
						'FechaEmision' => $fecha,
						'ped_mat' => $pedi_matricula,
						'tipo_presu' => $tipo_presupuesto,
						'unidad_resp' => $unidad_respon,
						'num_asi' => $numero,
						'proyecto' => $proyecto,
						'nro_pac' => $nro_pac,
						'nro_exp' => $nro_exp,
						'MontoPagado' => $pagado,
						'id_provee' => $proveedor_id,
						'MontoTotal' => $debe,
						'estado' => $estado,
						'id_uni_respon_usu'=>$id_uni_respon_usu,
						'id_form' => "1",
						'estado_registro' => "1",
					);
		
					$lastInsertedId = $this->Diario_obli_model->save_num_asi($dataNum_Asi);
		
					if ($lastInsertedId) {
							$dataDetaDebe = array(
								'Num_Asi_IDNum_Asi' => $lastInsertedId, // Utiliza el ID recién insertado
								'MontoPago' => $MontoPago,
								'Debe' => $debe,
								'numero'=>$numero,
								'comprobante' => $comprobante,
								'id_of' => $origen_de_financiamiento,
								'id_pro' => $programa_id_pro,
								'id_ff' => $fuente_de_financiamiento,
								'IDCuentaContable' => $cuentacontable,
								'cheques_che_id' => $cheque_id,
								'proveedores_id' => $proveedor_id,
								'id_uni_respon_usu'=>$id_uni_respon_usu,
								'id_form' => "1",
								'estado_registro' => "1",
							);
			
								if ($this->Diario_obli_model->saveDebe($dataDetaDebe)) {
									$dataDetaHaber = array(
										'Num_Asi_IDNum_Asi' => $lastInsertedId, // Utiliza el ID recién insertado
										'MontoPago' => $MontoPago,
										'Haber' => $haber_2,
										'numero'=>$numero,
										'comprobante' => $comprobante,
										'id_of' => $origen_de_financiamiento,
										'id_pro' => $programa_id_pro,
										'id_ff' => $fuente_de_financiamiento,
										'IDCuentaContable' => $cuentacontable,
										'cheques_che_id' => $cheque_id,
										'proveedores_id' => $proveedor_id,
										'id_uni_respon_usu'=>$id_uni_respon_usu,
										'id_form' => "1",
										'estado_registro' => "1",
									);

										$this->Diario_obli_model->saveHaber($dataDetaHaber);
										return redirect(base_url() . "obligaciones/diario_obligaciones/add");
									

								}
								
					}			
				
				}else {
					$this->add();
				}
			}
		

		
	} // fin del store




	public function edit($id){
		$data  = array(
			'obligaciones' => $this->Diario_obli_model->obtener_asiento_por_id($id), 
		);
		$this->load->view("layouts/header");
		$this->load->view("layouts/aside");
		$this->load->view("admin/obligacion/obliedit",$data);
		$this->load->view("layouts/footer");
	}



	public function update(){
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
		$estado = $this->input->post("estado");
		$nro_pac = $this->input->post("nro_pac");
		$nro_exp = $this->input->post("nro_exp");
		$total = $this->input->post("total");
		$pagado = $this->input->post("pagado");
		$obliaactual = $this->diario_obligacion_model->obtener_asiento_por_id($idobli);


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

			if ($this->Diario_obli_model->save_num_asiave($idobli,$data)) {
				redirect(base_url()."obligaciones/diario_obligaciones");
			}
			else{
				$this->session->set_flashdata("error","No se pudo guardar la informacion");
				redirect(base_url()."obligaciones/diario_obligaciones/add".$idobli);
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