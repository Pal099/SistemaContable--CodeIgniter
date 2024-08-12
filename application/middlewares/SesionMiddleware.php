<?php
/**
 * Created by PhpStorm.
 * User: usuario
 * Date: 27/11/2018
 * Time: 12:14 PM
 */

class SesionMiddleware
{
    protected $controller;
    protected $ci;

    public function __construct($controller, $ci)
    {
        $this->controller = $controller;
        $this->ci = $ci;
    }

    public function run()
    {

        $this->controller->load->library('session');
           
        if (!$this->ci->session->has_userdata("username")) {
            $this->ci->session->set_flashdata('mensaje', 'No puedes acceder al recurso hasta que <strong>inicies sesión</strong>');
            $this->ci->session->set_flashdata('url', $this->controller->router->class);
            redirect("login/index");
        }


    }
}