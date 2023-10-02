<?php
class Usuarios_model extends CI_Model {

    public function __construct() {
        parent::__construct();
         $this->load->database();
    }

    public function proveedores() {
        return $this->has_many('Proveedores_model', 'id_user');
    }
    public function obtener_usuario_por_nombre($username) {
        $query = $this->db->get_where('usuarios', array('Nombre_usuario' => $username));
        return $query->row();
    }
    
    public function obtener_usuario_por_id($id) {
        
         $query = $this->db->get_where('usuarios', array('id_user' => $id));
         return $query->row();
    }

    public function validar_credenciales_y_unidad($username, $password, $unidad_academica) {
        // Verificar las credenciales del usuario
        $query = $this->db->get_where('usuarios', array('Nombre_usuario' => $username, 'contraseña' => $password));
        $user = $query->row();
    
        if ($user) {
            // El usuario existe y las credenciales son correctas
            $user_id = $user->id_user;
    
            // Ahora, verifica si el usuario tiene acceso a la unidad académica deseada
            $this->db->select('usuarios.id_user, unidad_academica.id_unidad');
            $this->db->from('usuarios');
            $this->db->join('unidad_academica', 'usuarios.id_user = unidad_academica.id_user');
            $this->db->where('usuarios.id_user', $user_id);
            $this->db->where('unidad_academica.unidad', $unidad_academica);
            $query = $this->db->get();
    
            if ($query->num_rows() > 0) {
                // La unidad académica está relacionada con este usuario
                return true;
            }
        }
    
        return false;
    }
    
    
    
    

    

    

}
