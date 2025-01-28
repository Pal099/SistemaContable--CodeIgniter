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
		$this->load->model('CuentaContable_model');
		$this->load->model('Usuarios_model');
		$this->load->model('EjecucionP_model');
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
		$id = $this->input->post("ID_Presupuesto");

		$data = array(
			'presupuestos' => $this->Presupuesto_model->getPresu($id_uni_respon_usu),
			'registros_financieros' => $this->Registros_financieros_model->getFuentes($id_uni_respon_usu),
			'origen' => $this->Origen_model->getOrigenes($id_uni_respon_usu),
			'programa' => $this->ProgramGasto_model->getProgramGastos($id_uni_respon_usu),
			//'ejecucionpresupuestaria' => $this->EjecucionP_model->getEjecucionesP($id_uni_respon_usu),
			'cuentacontable' => $this->CuentaContable_model->getCuentasContables(),
		);

		$this->load->view("layouts/header");
		$this->load->view("layouts/sideBar");
		$this->load->view("admin/presupuesto/list", $data);
		$this->load->view("layouts/footer");
	}

	public function pdfs_presu()
	{
		$this->load->view("fpdf_presu");

	}

	public function add()
{
    $nombre = $this->session->userdata('Nombre_usuario');
    $id_user = $this->Usuarios_model->getUserIdByUserName($nombre);
    $id_uni_respon_usu = $this->Usuarios_model->getUserIdUniResponByUserId($id_user);
    $data = array(
        'presupuesto' => $this->Presupuesto_model->getPresu($id_uni_respon_usu),
        'registros_financieros' => $this->Registros_financieros_model->getFuentes(),
        'origen' => $this->Origen_model->getOrigenes(),
        'programa' => $this->ProgramGasto_model->getProgramGastos(),
        'cuentacontable' => $this->CuentaContable_model->getCuentasContables(),
    );

    $this->load->view("layouts/header");
    $this->load->view("layouts/sideBar");
    $this->load->view("admin/presupuesto/add", $data);
    $this->load->view("layouts/footer");
}

public function store()
{
    // Obtener el nombre de usuario y sus datos relacionados
    $nombre = $this->session->userdata('Nombre_usuario');
    $id_user = $this->Usuarios_model->getUserIdByUserName($nombre);
    $id_uni_respon_usu = $this->Usuarios_model->getUserIdUniResponByUserId($id_user);

    // Recibir los datos del formulario
	$id = $this->input->post("ID_Presupuesto");
	$año = $this->input->post("Año");
    $totalpresupuestado = $this->input->post("TotalPresupuestado");
    $origen_de_financiamiento_id_of = $this->input->post("origen_de_financiamiento_id_of");
    $programa_id_pro = $this->input->post("programa_id_pro");
    $fuente_de_financiamiento_id_ff = $this->input->post("fuente_de_financiamiento_id_ff");
    $TotalModificado = $this->input->post("TotalModificado");
    $Idcuentacontable = $this->input->post("Idcuentacontable");

    // Datos generales del presupuesto
    $presupuesto_data = [
        'Año' => $año,
        'TotalPresupuestado' => $totalpresupuestado,
        'origen_de_financiamiento_id_of' => $origen_de_financiamiento_id_of,
        'programa_id_pro' => $programa_id_pro,
        'fuente_de_financiamiento_id_ff' => $fuente_de_financiamiento_id_ff,
        'TotalModificado' => $TotalModificado,
        'Idcuentacontable' => $Idcuentacontable,
        'id_uni_respon_usu' => $id_uni_respon_usu, // Relacionado con el usuario
        'estado' => 1, // Estado activo por defecto
    ];

    // Guardar en la tabla `presupuestos` y obtener el ID generado
    if ($this->Presupuesto_model->save($presupuesto_data)) {
		$id = $this->input->post("ID_Presupuesto");

        // Relación de los meses con los valores ingresados
        $meses = [
            'Enero' => $this->input->post("pre_ene"),
            'Febrero' => $this->input->post("pre_feb"),
            'Marzo' => $this->input->post("pre_mar"),
            'Abril' => $this->input->post("pre_abr"),
            'Mayo' => $this->input->post("pre_may"),
            'Junio' => $this->input->post("pre_jun"),
            'Julio' => $this->input->post("pre_jul"),
            'Agosto' => $this->input->post("pre_ago"),
            'Septiembre' => $this->input->post("pre_sep"),
            'Octubre' => $this->input->post("pre_oct"),
            'Noviembre' => $this->input->post("pre_nov"),
            'Diciembre' => $this->input->post("pre_dic"),
        ];

        // Guardar los presupuestos mensuales que tengan valores no vacíos
        foreach ($meses as $mes => $monto) {
            if (!empty($monto)) {
                $presupuesto_mensual_data = [
                    'id_presupuesto' => $id, // Clave foránea
                    'mes' => $mes,
                    'monto_presupuestado' => $monto,
                    'monto_modificado' => $TotalModificado, // Valor inicial del monto modificado
                ];
                $this->Presupuesto_model->save_presupuesto_mensual($presupuesto_mensual_data);
            }
        }
		if (!$this->Presupuesto_model->save_presupuesto_mensual($presupuesto_mensual_data)) {
			$this->db->trans_rollback();
			$this->session->set_flashdata('error', 'Error al guardar los presupuestos mensuales.');
			redirect(base_url() . "mantenimiento/presupuesto/add");
		}
		

        // Redirigir con éxito
        redirect(base_url() . "mantenimiento/presupuesto");
    } else {
        // Redirigir a la vista de agregar con error
        redirect(base_url() . "mantenimiento/presupuesto/add");
    }
}

	public function edit($id)
	{
		$nombre = $this->session->userdata('Nombre_usuario');
		$id_user = $this->Usuarios_model->getUserIdByUserName($nombre);
		$id_uni_respon_usu = $this->Usuarios_model->getUserIdUniResponByUserId($id_user);
		$data = array(
			'presupuesto' => $this->Presupuesto_model->getPresupuesto($id),
			'registros_financieros' => $this->Registros_financieros_model->getFuentes(),
			'origen' => $this->Origen_model->getOrigenes(),
			'programa' => $this->ProgramGasto_model->getProgramGastos(),
			'cuentacontable' => $this->CuentaContable_model->getCuentasContables(),
			'plan_financiero' => $this->Presupuesto_model->getPlanFinanciero() // Añadido

		);
		$this->load->view("layouts/header");
		$this->load->view("layouts/sideBar");
		$this->load->view("admin/presupuesto/edit", $data);
		$this->load->view("layouts/footer");
	}

	public function update()
	{
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

	public function view($id)
	{
		$nombre = $this->session->userdata('Nombre_usuario');
		$id_user = $this->Usuarios_model->getUserIdByUserName($nombre);
		$id_uni_respon_usu = $this->Usuarios_model->getUserIdUniResponByUserId($id_user);
		$data = array(
			'presupuestos' => $this->Presupuesto_model->getPresupuesto($id),
			'registros_financieros' => $this->Registros_financieros_model->getFuentes(),
			'origen' => $this->Origen_model->getOrigenes(),
			'programa' => $this->ProgramGasto_model->getProgramGastos(),
			'cuentacontable' => $this->CuentaContable_model->getCuentasContables(),
		);
		$this->load->view("admin/presupuesto/view", $data);
	}

	public function delete($id)
	{
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