<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Presupuesto extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
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
        $nombre = $this->session->userdata('Nombre_usuario');
        $id_user = $this->Usuarios_model->getUserIdByUserName($nombre);
        $id_uni_respon_usu = $this->Usuarios_model->getUserIdUniResponByUserId($id_user);

        $data = array(
            'presupuestos' => $this->Presupuesto_model->getPresu($id_uni_respon_usu),
            'registros_financieros' => $this->Registros_financieros_model->getFuentes($id_uni_respon_usu),
            'origen' => $this->Origen_model->getOrigenes($id_uni_respon_usu),
            'programa' => $this->ProgramGasto_model->getProgramGastos($id_uni_respon_usu),
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
            'registros_financieros' => $this->Registros_financieros_model->getFuentes($id_uni_respon_usu),
            'origen' => $this->Origen_model->getOrigenes($id_uni_respon_usu),
            'programa' => $this->ProgramGasto_model->getProgramGastos($id_uni_respon_usu),
            'cuentacontable' => $this->CuentaContable_model->getCuentasContables(),
            'meses' => $this->getMesesConfig()
        );

        $this->load->view("layouts/header");
        $this->load->view("layouts/sideBar");
        $this->load->view("admin/presupuesto/add", $data);
        $this->load->view("layouts/footer");
    }

    public function store()
    {
        $nombre = $this->session->userdata('Nombre_usuario');
        $id_user = $this->Usuarios_model->getUserIdByUserName($nombre);
        $id_uni_respon_usu = $this->Usuarios_model->getUserIdUniResponByUserId($id_user);

        // Validar formulario (sin regex)
        $this->form_validation->set_rules('Año', 'Año', 'required|valid_date');
        $this->form_validation->set_rules('Idcuentacontable', 'Cuenta Contable', 'required|numeric');
        $this->form_validation->set_rules('origen_de_financiamiento_id_of', 'Origen Financiamiento', 'required|numeric');
        $this->form_validation->set_rules('programa_id_pro', 'Programa', 'required|numeric');
        $this->form_validation->set_rules('fuente_de_financiamiento_id_ff', 'Fuente Financiamiento', 'required|numeric');
        $this->form_validation->set_rules('TotalPresupuestado', 'Presupuesto Inicial', 'required|numeric');
        $this->form_validation->set_rules('TotalModificado', 'Presupuesto Modificado', 'required|numeric');

        $montos_raw = $this->input->post("montos_mensuales") ?: [];

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error', validation_errors());
            redirect(base_url() . "mantenimiento/presupuesto/add");
        }

        // Procesar fecha
        $fecha = DateTime::createFromFormat('Y-m-d', $this->input->post('Año'));
        if (!$fecha) {
            $this->session->set_flashdata('error', 'Formato de fecha inválido');
            redirect(base_url() . "mantenimiento/presupuesto/add");
        }

        // Procesar montos principales (segunda capa de limpieza)
        $total_presupuestado = (float) preg_replace('/[^0-9]/', '', $this->input->post('TotalPresupuestado'));
        $total_modificado = (float) preg_replace('/[^0-9]/', '', $this->input->post('TotalModificado'));

        // Procesar montos mensuales
        $montos_mensuales = $this->procesarMontos($montos_raw);

        // Validar al menos un monto mensual positivo
        if (array_sum($montos_mensuales) <= 0) {
            $this->session->set_flashdata('error', 'Debe ingresar al menos un monto mensual válido');
            redirect(base_url() . "mantenimiento/presupuesto/add");
        }

        // Datos del presupuesto
        $presupuesto_data = array(
            'Año' => $fecha->format('Y-m-d'),
            'Idcuentacontable' => $this->input->post("Idcuentacontable"),
            'TotalPresupuestado' => $total_presupuestado,
            'TotalModificado' => $total_modificado,
            'origen_de_financiamiento_id_of' => $this->input->post("origen_de_financiamiento_id_of"),
            'programa_id_pro' => $this->input->post("programa_id_pro"),
            'fuente_de_financiamiento_id_ff' => $this->input->post("fuente_de_financiamiento_id_ff"),
            'id_uni_respon_usu' => $id_uni_respon_usu,
            'estado' => 1
        );

        if ($this->Presupuesto_model->save($presupuesto_data, $montos_mensuales)) {
            $this->session->set_flashdata('success', 'Presupuesto creado exitosamente');
        } else {
            $this->session->set_flashdata('error', 'Error al guardar el presupuesto');
        }

        redirect(base_url() . "mantenimiento/presupuesto");
    }

    // Funciones auxiliares
    private function getMesesConfig()
    {
        return [
            'ene' => 'Enero',
            'feb' => 'Febrero',
            'mar' => 'Marzo',
            'abr' => 'Abril',
            'may' => 'Mayo',
            'jun' => 'Junio',
            'jul' => 'Julio',
            'ago' => 'Agosto',
            'sep' => 'Septiembre',
            'oct' => 'Octubre',
            'nov' => 'Noviembre',
            'dic' => 'Diciembre'
        ];
    }

    private function procesarMontos($montos_raw)
    {
        $montos_procesados = [];
        foreach ($montos_raw as $mes => $valor) {
            $valor_limpio = preg_replace('/[^0-9]/', '', $valor);  // Elimina todo excepto números
            $montos_procesados[$mes] = is_numeric($valor_limpio) ? (int) $valor_limpio : 0;
        }
        return $montos_procesados;
    }
    public function edit($id)
    {

        if (!$id) {
            redirect(base_url() . "mantenimiento/presupuesto");
        }

        // Get user information
        $nombre = $this->session->userdata('Nombre_usuario');
        $id_user = $this->Usuarios_model->getUserIdByUserName($nombre);
        $id_uni_respon_usu = $this->Usuarios_model->getUserIdUniResponByUserId($id_user);
        // Obtener los datos del presupuesto y plan financiero
        $presupuesto = $this->Presupuesto_model->getPresupuesto($id);
        $plan_financiero = $this->Presupuesto_model->getPlanFinan($id);

        if (!$presupuesto) {
            show_404();
        }


        // If the form is submitted
        if ($this->input->post()) {
            // Prepare presupuesto data
            $presupuesto_data = array(
                'Año' => $this->input->post("Año"),
                'Idcuentacontable' => $this->input->post("Idcuentacontable"),
                'TotalPresupuestado' => $this->input->post("TotalPresupuestado"),
                'origen_de_financiamiento_id_of' => $this->input->post("origen_de_financiamiento_id_of"),
                'programa_id_pro' => $this->input->post("programa_id_pro"),
                'fuente_de_financiamiento_id_ff' => $this->input->post("fuente_de_financiamiento_id_ff"),
                'TotalModificado' => $this->input->post("TotalModificado"),
                'pre_ene' => $this->input->post("pre_ene"),
                'pre_feb' => $this->input->post("pre_feb"),
                'pre_mar' => $this->input->post("pre_mar"),
                'pre_abr' => $this->input->post("pre_abr"),
                'pre_may' => $this->input->post("pre_may"),
                'pre_jun' => $this->input->post("pre_jun"),
                'pre_jul' => $this->input->post("pre_jul"),
                'pre_ago' => $this->input->post("pre_ago"),
                'pre_sep' => $this->input->post("pre_sep"),
                'pre_oct' => $this->input->post("pre_oct"),
                'pre_nov' => $this->input->post("pre_nov"),
                'pre_dic' => $this->input->post("pre_dic"),
                'id_uni_respon_usu' => $id_uni_respon_usu,
                'estado' => "1"
            );

            // Prepare plan financiero data
            $plan_financiero_data = array(
                'Fecha' => $this->input->post("Año"),
                'sal_ene' => $this->input->post("sal_ene") !== '' ? str_replace(',', '', $this->input->post("sal_ene")) : NULL,
                'sal_feb' => $this->input->post("sal_feb") !== '' ? str_replace(',', '', $this->input->post("sal_feb")) : NULL,
                'sal_mar' => $this->input->post("sal_mar") !== '' ? str_replace(',', '', $this->input->post("sal_mar")) : NULL,
                'sal_abr' => $this->input->post("sal_abr") !== '' ? str_replace(',', '', $this->input->post("sal_abr")) : NULL,
                'sal_may' => $this->input->post("sal_may") !== '' ? str_replace(',', '', $this->input->post("sal_may")) : NULL,
                'sal_jun' => $this->input->post("sal_jun") !== '' ? str_replace(',', '', $this->input->post("sal_jun")) : NULL,
                'sal_jul' => $this->input->post("sal_jul") !== '' ? str_replace(',', '', $this->input->post("sal_jul")) : NULL,
                'sal_ago' => $this->input->post("sal_ago") !== '' ? str_replace(',', '', $this->input->post("sal_ago")) : NULL,
                'sal_sep' => $this->input->post("sal_sep") !== '' ? str_replace(',', '', $this->input->post("sal_sep")) : NULL,
                'sal_oct' => $this->input->post("sal_oct") !== '' ? str_replace(',', '', $this->input->post("sal_oct")) : NULL,
                'sal_nov' => $this->input->post("sal_nov") !== '' ? str_replace(',', '', $this->input->post("sal_nov")) : NULL,
                'sal_dic' => $this->input->post("sal_dic") !== '' ? str_replace(',', '', $this->input->post("sal_dic")) : NULL,
                'id_user' => $id_user
            );

            // Remove thousand separators from presupuesto amounts
            foreach ($presupuesto_data as $key => $value) {
                if (strpos($key, 'pre_') === 0) {
                    $presupuesto_data[$key] = $value !== '' ? str_replace(',', '', $value) : NULL;
                }
            }

            // Update the records
            if ($this->Presupuesto_model->update($id, $presupuesto_data, $plan_financiero_data)) {
                $this->session->set_flashdata('success', 'Registro actualizado exitosamente');
                redirect(base_url() . "mantenimiento/presupuesto");
            } else {
                $this->session->set_flashdata('error', 'Error al actualizar el registro');
                redirect(base_url() . "mantenimiento/presupuesto/edit/" . $id);
            }
        }

        // Get existing data for the form
        $presupuesto = $this->Presupuesto_model->getPresupuesto($id);
        $data['presupuesto'] = !empty($presupuestos) ? $presupuestos[0] : null; // Assuming you want the first object

        $plan_financiero = $this->Presupuesto_model->getPlanFinan($id);

        if (!$presupuesto) {
            show_404();
        }

        // Prepare data for the view
        $data = array(
            'presupuesto' => $presupuesto, // Use the fetched presupuesto
            'registros_financieros' => $this->Registros_financieros_model->getFuentes($id_uni_respon_usu),
            'origen' => $this->Origen_model->getOrigenes($id_uni_respon_usu),
            'programa' => $this->ProgramGasto_model->getProgramGastos($id_uni_respon_usu),
            'cuentacontable' => $this->CuentaContable_model->getCuentasContables(), // Aquí tampoco lo pasamos
            'plan_financiero' => $plan_financiero,
        );


        // Load views
        $this->load->view("layouts/header");
        $this->load->view("layouts/sideBar");
        $this->load->view("admin/presupuesto/edit", $data);
        $this->load->view("layouts/footer");
    }

    public function update($id)
    {
        $nombre = $this->session->userdata('Nombre_usuario');
        $id_user = $this->Usuarios_model->getUserIdByUserName($nombre);
        $id_uni_respon_usu = $this->Usuarios_model->getUserIdUniResponByUserId($id_user);

        // Datos del presupuesto
        $presupuesto_data = array(
            'Año' => $this->input->post("Año"),
            'Idcuentacontable' => $this->input->post("Idcuentacontable"),
            'TotalPresupuestado' => $this->input->post("TotalPresupuestado"),
            'origen_de_financiamiento_id_of' => $this->input->post("origen_de_financiamiento_id_of"),
            'programa_id_pro' => $this->input->post("programa_id_pro"),
            'fuente_de_financiamiento_id_ff' => $this->input->post("fuente_de_financiamiento_id_ff"),
            'TotalModificado' => $this->input->post("TotalModificado"),
            'pre_ene' => $this->input->post("pre_ene"),
            'pre_feb' => $this->input->post("pre_feb"),
            'pre_mar' => $this->input->post("pre_mar"),
            'pre_abr' => $this->input->post("pre_abr"),
            'pre_may' => $this->input->post("pre_may"),
            'pre_jun' => $this->input->post("pre_jun"),
            'pre_jul' => $this->input->post("pre_jul"),
            'pre_ago' => $this->input->post("pre_ago"),
            'pre_sep' => $this->input->post("pre_sep"),
            'pre_oct' => $this->input->post("pre_oct"),
            'pre_nov' => $this->input->post("pre_nov"),
            'pre_dic' => $this->input->post("pre_dic"),
            'id_uni_respon_usu' => $id_uni_respon_usu,
            'estado' => "1"
        );

        // Datos del plan financiero
        $plan_financiero_data = array(
            'Fecha' => $this->input->post("Año"),
            'sal_ene' => $this->input->post("sal_ene") !== '' ? $this->input->post("sal_ene") : NULL,
            'sal_feb' => $this->input->post("sal_feb") !== '' ? $this->input->post("sal_feb") : NULL,
            'sal_mar' => $this->input->post("sal_mar") !== '' ? $this->input->post("sal_mar") : NULL,
            'sal_abr' => $this->input->post("sal_abr") !== '' ? $this->input->post("sal_abr") : NULL,
            'sal_may' => $this->input->post("sal_may") !== '' ? $this->input->post("sal_may") : NULL,
            'sal_jun' => $this->input->post("sal_jun") !== '' ? $this->input->post("sal_jun") : NULL,
            'sal_jul' => $this->input->post("sal_jul") !== '' ? $this->input->post("sal_jul") : NULL,
            'sal_ago' => $this->input->post("sal_ago") !== '' ? $this->input->post("sal_ago") : NULL,
            'sal_sep' => $this->input->post("sal_sep") !== '' ? $this->input->post("sal_sep") : NULL,
            'sal_oct' => $this->input->post("sal_oct") !== '' ? $this->input->post("sal_oct") : NULL,
            'sal_nov' => $this->input->post("sal_nov") !== '' ? $this->input->post("sal_nov") : NULL,
            'sal_dic' => $this->input->post("sal_dic") !== '' ? $this->input->post("sal_dic") : NULL,
            'id_user' => $id_user
        );

        if ($this->Presupuesto_model->update($id, $presupuesto_data, $plan_financiero_data)) {
            redirect(base_url() . "mantenimiento/presupuesto");
        } else {
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
            'registros_financieros' => $this->Registros_financieros_model->getFuentes($id_uni_respon_usu),
            'origen' => $this->Origen_model->getOrigenes($id_uni_respon_usu),
            'programa' => $this->ProgramGasto_model->getProgramGastos($id_uni_respon_usu),
            'cuentacontable' => $this->CuentaContable_model->getCuentasContables(), // Aquí tampoco lo pasamos
            'plan_financiero' => $this->Presupuesto_model->getPlanFinan($id),//tomamos el plan financiero

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

    public function getPresupuestoDetalle($id)
    {
        $presupuestoDetalle = $this->Presupuesto_model->getPresupuesto($id);
        echo json_encode($presupuestoDetalle);
    }
}