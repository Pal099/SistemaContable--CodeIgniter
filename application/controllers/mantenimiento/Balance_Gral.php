
<?php
class Balance_Gral extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->model('Balance_Gral_model');
        $this->load->library('pagination');
    }

    public function index() {

        $data['cuentas'] = $this->Balance_Gral_model->obtenerDatosCuentas();

        $this->load->view("layouts/header");
        $this->load->view("layouts/aside");
        $this->load->view("admin/balancegral/list", $data);
        $this->load->view("layouts/footer");
    }
}
?>


