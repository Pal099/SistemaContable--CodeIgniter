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
            'id_uni_respon_usu' => $id_uni_respon_usu,
            'estado' => 1, // Estado activo por defecto
        ];

        // Iniciar transacción
        $this->db->trans_start();

        // Guardar en la tabla `presupuestos` y obtener el ID generado
        $id_presupuesto = $this->Presupuesto_model->insertar_presupuesto($presupuesto_data);

        if ($id_presupuesto) {
            // Relación de los meses con los valores ingresados
            $meses_inputs = [
                'Enero' => "pre_ene",
                'Febrero' => "pre_feb",
                'Marzo' => "pre_mar",
                'Abril' => "pre_abr",
                'Mayo' => "pre_may",
                'Junio' => "pre_jun",
                'Julio' => "pre_jul",
                'Agosto' => "pre_ago",
                'Septiembre' => "pre_sep",
                'Octubre' => "pre_oct",
                'Noviembre' => "pre_nov",
                'Diciembre' => "pre_dic",
            ];
            // Recorre cada mes y su correspondiente input
            foreach ($meses_inputs as $mes => $input_name) {
                $valor = $this->input->post($input_name);
                if ($valor > 0) {
                    $meses[$mes] = $mes; // Guarda el nombre del mes en el array
                }
            }


            // Guardar los presupuestos mensuales
            foreach ($meses as $mes => $nombre_mes) {
                $monto = $this->input->post($meses_inputs[$nombre_mes]);
                if (!empty($monto)) {
                    $presupuesto_mensual_data = [
                        'id_presupuesto' => $id_presupuesto, // Clave foránea
                        'mes' => $nombre_mes, // Nombre del mes
                        'monto_presupuestado' => $monto, // Monto presupuestado
                        'monto_modificado' => $TotalModificado, // Total modificado
                    ];
                    $this->Presupuesto_model->save_presupuesto_mensual($presupuesto_mensual_data);
                }
            }
        } else {
            $this->db->trans_rollback();
            $this->session->set_flashdata('error', 'Error al guardar el presupuesto.');
            redirect(base_url() . "mantenimiento/presupuesto/add");
            return;
        }

        // Completar transacción
        $this->db->trans_complete();

        if ($this->db->trans_status()) {
            // Éxito
            $this->session->set_flashdata('success', 'Presupuesto guardado exitosamente.');
            redirect(base_url() . "mantenimiento/presupuesto");
        } else {
            // Error
            $this->session->set_flashdata('error', 'Error al guardar el presupuesto.');
            redirect(base_url() . "mantenimiento/presupuesto/add");
        }
    }



    public function edit($id)
    {
        $nombre = $this->session->userdata('Nombre_usuario');
        $id_user = $this->Usuarios_model->getUserIdByUserName($nombre);
        $id_uni_respon_usu = $this->Usuarios_model->getUserIdUniResponByUserId($id_user);

        // Obtener todos los presupuestos mensuales del presupuesto
        $presupuestos_mensuales = $this->Presupuesto_model->getPresupuestosMensuales($id);

        $data = array(
            'presupuesto' => $this->Presupuesto_model->getPresupuesto($id),
            'presupuestos_mensuales' => $presupuestos_mensuales, // Array con todos los meses
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

    public function update()
    {
        $id = $this->input->post("ID_Presupuesto");
        $id_mes = $this->input->post("id_presupuesto_mes");

        // Obtener el nombre de usuario y sus datos relacionados
        $nombre = $this->session->userdata('Nombre_usuario');
        $id_user = $this->Usuarios_model->getUserIdByUserName($nombre);
        $id_uni_respon_usu = $this->Usuarios_model->getUserIdUniResponByUserId($id_user);

        // Datos generales del presupuesto
        $año = $this->input->post("Año");
        $totalpresupuestado = $this->input->post("TotalPresupuestado");
        $origen_de_financiamiento_id_of = $this->input->post("origen_de_financiamiento_id_of");
        $programa_id_pro = $this->input->post("programa_id_pro");
        $fuente_de_financiamiento_id_ff = $this->input->post("fuente_de_financiamiento_id_ff");
        $TotalModificado = $this->input->post("TotalModificado");
        $Idcuentacontable = $this->input->post("Idcuentacontable");

        // Datos a actualizar en la tabla `presupuestos`
        $presupuesto_data = [
            'Año' => $año,
            'TotalPresupuestado' => $totalpresupuestado,
            'origen_de_financiamiento_id_of' => $origen_de_financiamiento_id_of,
            'programa_id_pro' => $programa_id_pro,
            'fuente_de_financiamiento_id_ff' => $fuente_de_financiamiento_id_ff,
            'TotalModificado' => $TotalModificado,
            'Idcuentacontable' => $Idcuentacontable,
            'id_uni_respon_usu' => $id_uni_respon_usu,
            'estado' => 1,
        ];

        // Iniciar transacción
        $this->db->trans_start();
        
        // Actualizar la tabla `presupuestos`
        $this->Presupuesto_model->update($id, $presupuesto_data);
        
        // Relación de los meses con los valores ingresados
        $meses_inputs = [
            'Enero' => "pre_ene",
            'Febrero' => "pre_feb",
            'Marzo' => "pre_mar",
            'Abril' => "pre_abr",
            'Mayo' => "pre_may",
            'Junio' => "pre_jun",
            'Julio' => "pre_jul",
            'Agosto' => "pre_ago",
            'Septiembre' => "pre_sep",
            'Octubre' => "pre_oct",
            'Noviembre' => "pre_nov",
            'Diciembre' => "pre_dic",
        ];
        
        // Recorre cada mes y su correspondiente input
        foreach ($meses_inputs as $mes => $input_name) {
            $valor = $this->input->post($input_name);
            if ($valor > 0) {
                $meses[$mes] = $mes; // Guarda el nombre del mes en el array
            }
        }
        
        // Actualizar los presupuestos mensuales
        foreach ($meses as $mes => $nombre_mes) {
            $monto = $this->input->post($meses_inputs[$nombre_mes]);
            if (!empty($monto)) {
                $presupuesto_mensual_data = [
                    'id_presupuesto' => $id, // Clave foránea
                    'mes' => $nombre_mes, // Nombre del mes
                    'monto_presupuestado' => $monto, // Monto presupuestado
                    'monto_modificado' => $TotalModificado, // Total modificado
                ];
        
                // Verificar si existe un registro para ese mes
                $existe = $this->Presupuesto_model->getPresupuestoMensual($id, $mes);
        
                if ($existe) {
                    // Si existe, actualizar
                    $this->Presupuesto_model->update_mes($existe->id_presupuesto_mes, $presupuesto_mensual_data);
                } else {
                    // Si no existe, insertar nuevo registro
                    $this->Presupuesto_model->save_presupuesto_mensual($presupuesto_mensual_data);
                }
            }
        }
        // Completar transacción
        $this->db->trans_complete();

        if ($this->db->trans_status()) {
            // Éxito
            $this->session->set_flashdata('success', 'Presupuesto actualizado exitosamente.');
            redirect(base_url() . "mantenimiento/presupuesto");
        } else {
            // Error
            $this->session->set_flashdata('error', 'Error al actualizar el presupuesto.');
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