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
        $id_mes = $this->input->post("id_presupuesto_mes");


        $data = array(
            'presupuestos' => $this->Presupuesto_model->getPresu($id_uni_respon_usu),
            'registros_financieros' => $this->Registros_financieros_model->getFuentes($id_uni_respon_usu),
            'origen' => $this->Origen_model->getOrigenes($id_uni_respon_usu),
            'programa' => $this->ProgramGasto_model->getProgramGastos($id_uni_respon_usu),
            //'ejecucionpresupuestaria' => $this->EjecucionP_model->getEjecucionesP($id_uni_respon_usu),
            'cuentacontable' => $this->CuentaContable_model->getCuentasContables(),
            'id_uni_respon_usu' => $id_uni_respon_usu // <--- Agrega esta línea

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
        $nombre = $this->session->userdata('Nombre_usuario');
        $id_user = $this->Usuarios_model->getUserIdByUserName($nombre);
        $id_uni_respon_usu = $this->Usuarios_model->getUserIdUniResponByUserId($id_user);
        try {
            // Validar fecha
            $fecha = $this->input->post("Año");
            if (!$fecha) {
                throw new Exception("La fecha es requerida");
            }

            // Formatear fecha para MySQL
            $fecha_mysql = date('Y-m-d', strtotime($fecha));
            $año = date('Y', strtotime($fecha));


            $presupuesto_data = [
                'Año' => $fecha_mysql,
                'TotalPresupuestado' => floatval($this->input->post("TotalPresupuestado")),
                'origen_de_financiamiento_id_of' => $this->input->post("origen_de_financiamiento_id_of"),
                'programa_id_pro' => $this->input->post("programa_id_pro"),
                'fuente_de_financiamiento_id_ff' => $this->input->post("fuente_de_financiamiento_id_ff"),
                'TotalModificado' => floatval($this->input->post("TotalModificado")),
                'Idcuentacontable' => $this->input->post("Idcuentacontable"),
                'id_uni_respon_usu' => $id_uni_respon_usu,
                'estado' => 1
            ];

            $this->db->trans_start();

            $id_presupuesto = $this->Presupuesto_model->save($presupuesto_data);


            $presupuestos_mensuales = [];
            $meses = ['ene', 'feb', 'mar', 'abr', 'may', 'jun', 'jul', 'ago', 'sep', 'oct', 'nov', 'dic'];

            foreach ($meses as $index => $mes_codigo) {
                $monto = floatval($this->input->post("pre_" . $mes_codigo));
                if ($monto > 0) {
                    $mes_num = str_pad($index + 1, 2, '0', STR_PAD_LEFT);
                    $fecha_mes = "{$año}-{$mes_num}-01";

                    $presupuestos_mensuales[] = [
                        'id_presupuesto' => $id_presupuesto,
                        'mes' => $fecha_mes, // Sin 00:00:00, se agregará en format_datetime
                        'monto_presupuestado' => $monto,
                        'monto_modificado' => floatval($this->input->post("TotalModificado"))
                    ];
                }
            }

            // Si hay presupuestos mensuales, guardarlos
            if (!empty($presupuestos_mensuales)) {
                $this->Presupuesto_model->save_batch_presupuesto_mensual($presupuestos_mensuales);
            }

            $this->db->trans_complete();

            if ($this->db->trans_status() === FALSE) {
                throw new Exception("Error en la transacción");
            }

            $this->session->set_flashdata('success', 'Presupuesto guardado exitosamente');
            redirect(base_url() . "mantenimiento/presupuesto");
        } catch (Exception $e) {
            $this->db->trans_rollback();
            $this->session->set_flashdata('error', $e->getMessage());
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
            'presupuestos_mensuales' => $this->Presupuesto_model->getPresupuestosMensuales($id),
            'registros_financieros' => $this->Registros_financieros_model->getFuentes(),
            'origen' => $this->Origen_model->getOrigenes(),
            'programa' => $this->ProgramGasto_model->getProgramGastos(),
            'cuentacontable' => $this->CuentaContable_model->getCuentasContables(),
        );

        $this->load->view("layouts/header");
        $this->load->view("layouts/sideBar");
        $this->load->view("admin/presupuesto/edit", $data);
        $this->load->view("layouts/footer");
    }
    //update refactorizado para el edit 
    public function update()
    {
        $nombre = $this->session->userdata('Nombre_usuario');
        $id_user = $this->Usuarios_model->getUserIdByUserName($nombre);
        $id_uni_respon_usu = $this->Usuarios_model->getUserIdUniResponByUserId($id_user);
        $id = $this->input->post("ID_Presupuesto");

        try {
            // Validar fecha
            $fecha = $this->input->post("Año");
            if (!$fecha) {
                throw new Exception("La fecha es requerida");
            }

            // Formatear fecha para MySQL
            $fecha_mysql = date('Y-m-d', strtotime($fecha));
            $año = date('Y', strtotime($fecha));

            $presupuesto_data = [
                'Año' => $fecha_mysql,
                'TotalPresupuestado' => floatval($this->input->post("TotalPresupuestado")),
                'origen_de_financiamiento_id_of' => $this->input->post("origen_de_financiamiento_id_of"),
                'programa_id_pro' => $this->input->post("programa_id_pro"),
                'fuente_de_financiamiento_id_ff' => $this->input->post("fuente_de_financiamiento_id_ff"),
                'TotalModificado' => floatval($this->input->post("TotalModificado")),
                'Idcuentacontable' => $this->input->post("Idcuentacontable"),
                'id_uni_respon_usu' => $id_uni_respon_usu,
                'estado' => 1
            ];

            $this->db->trans_start();

            // Actualizar presupuesto principal
            $this->Presupuesto_model->update($id, $presupuesto_data);

            // Obtener presupuestos mensuales existentes
            $presupuestos_existentes = $this->Presupuesto_model->getPresupuestosMensuales($id);

            // Procesar presupuestos mensuales
            $meses = ['ene', 'feb', 'mar', 'abr', 'may', 'jun', 'jul', 'ago', 'sep', 'oct', 'nov', 'dic'];

            foreach ($meses as $index => $mes_codigo) {
                $monto = $this->input->post("pre_" . $mes_codigo);
                if ($monto !== null) {
                    $monto = floatval($monto);
                    $mes_num = str_pad($index + 1, 2, '0', STR_PAD_LEFT);
                    $fecha_mes = "{$año}-{$mes_num}-01";

                    // Si ya existe el registro mensual, actualizarlo
                    if (isset($presupuestos_existentes['pre_' . $mes_codigo])) {
                        if ($monto > 0) {
                            $presupuesto_mensual = [
                                'monto_presupuestado' => $monto,
                                'monto_modificado' => floatval($this->input->post("TotalModificado"))
                            ];
                            $this->Presupuesto_model->update_mes($id, $fecha_mes, $presupuesto_mensual);
                        } else {
                            // Si el monto es 0, eliminar el registro existente
                            $this->Presupuesto_model->delete_mes($id, $fecha_mes);
                        }
                    } else {
                        // Si no existe y el monto es mayor a 0, agregarlo a nuevos registros
                        if ($monto > 0) {
                            $nuevos_registros[] = [
                                'id_presupuesto' => $id,
                                'mes' => $fecha_mes,
                                'monto_presupuestado' => $monto,
                                'monto_modificado' => floatval($this->input->post("TotalModificado"))
                            ];
                        }
                    }
                }
            }

            // Insertar solo los nuevos registros mensuales
            if (!empty($nuevos_registros)) {
                $this->Presupuesto_model->save_batch_presupuesto_mensual($nuevos_registros);
            }

            $this->db->trans_complete();

            if ($this->db->trans_status() === FALSE) {
                throw new Exception("Error en la transacción");
            }

            $this->session->set_flashdata('success', 'Presupuesto actualizado exitosamente');
            redirect(base_url() . "mantenimiento/presupuesto");
        } catch (Exception $e) {
            $this->db->trans_rollback();
            $this->session->set_flashdata('error', $e->getMessage());
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

    public function getPresupuestoDetalle($id)
    {
        $presupuestoDetalle = $this->Presupuesto_model->getPresupuesto($id);
        echo json_encode($presupuestoDetalle);
    }
}
