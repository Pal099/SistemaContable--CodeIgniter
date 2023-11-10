<?php
class Usuarios_model extends CI_Model {

    public function __construct() {
        parent::__construct();
         $this->load->database();
    }

   
    public function obtener_usuario_por_id($id) {
        
         $query = $this->db->get_where('usuarios', array('id_user' => $id));
         return $query->row();
    }

    public function obtener_id_unidad_academica($unidad_academica) {
        $query = $this->db->get_where('unidad_academica', array('unidad' => $unidad_academica));
        $result = $query->row();
        if ($result) {
            return $result->id_unidad;
        } else {
            return false;
        }
    }

    public function obtener_usuario_por_nombre($username) {
        
        $query = $this->db->get_where('usuarios', array('Nombre_usuario' => $username));
        return $query->row();
   }

   public function actualizar_id_uni_respon_usu($id_user, $unidad_id) {
    $data = array('id_uni_respon_usu' => $unidad_id);
    $this->db->where('id_user', $id_user);
    $this->db->update('usuarios', $data);
}


    public function validar_credenciales_y_unidad($username, $password, $unidad_academica) {
        $query = $this->db->get_where('usuarios', array('Nombre_usuario' => $username, 'contraseña' => $password));
        $user = $query->row();
    
        if ($user) {
            $user_id = $user->id_user;
    
            $this->db->select('usuarios.id_user, unidad_academica.id_unidad');
            $this->db->from('usuarios');
            $this->db->join('uni_respon_usu', 'usuarios.id_user = uni_respon_usu.id_user');
            $this->db->join('unidad_academica', 'unidad_academica.id_unidad = uni_respon_usu.id_unidad');
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


    public function obtener_contraseña_por_usuario($username) {
        $query = $this->db->select('contraseña')
            ->get_where('usuarios', array('Nombre_usuario' => $username));
    
        $result = $query->row();
        if ($result) {
            return $result->contraseña;
        } else {
            return false;
        }
    }
    
    
    //--------------------------------//---------------------------------------//-------------------------------//

    public function registrar_usuario($nombre, $contrasena, $unidad_academica) {
        $unidad_query = $this->db->get_where('unidad_academica', array('unidad' => $unidad_academica));
        
        if ($unidad_query->num_rows() > 0) {
            $unidad = $unidad_query->row();
            $unidad_id = $unidad->id_unidad;
    
            $data = array(
                'Nombre_usuario' => $nombre,
                'contraseña' => password_hash($contrasena, PASSWORD_BCRYPT),
                'id_unidad' => $unidad_id,
                'estado' => 1,
            );
    
            $this->db->insert('usuarios', $data);
            
            if ($this->db->affected_rows() > 0) {
                // Registra al usuario y lo autentica
                $this->session->set_userdata('logged_in', TRUE);
                $this->session->set_userdata('Nombre_usuario', $nombre);
                $this->session->set_userdata('unidad_academica', $unidad_academica);
                
                // Recupera el ID del usuario recién autenticado
                $usuario = $this->obtener_usuario_por_nombre($nombre);
                $this->session->set_userdata('id_user', $usuario->id_user);
                
                return true;
            }
        }
    
        return false;
    }


}
