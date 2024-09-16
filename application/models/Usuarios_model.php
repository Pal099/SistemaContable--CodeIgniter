<?php
class Usuarios_model extends CI_Model
{
    public function __construct() {
        parent::__construct();
        $this->load->database(); // Cargar la base de datos
    }
public function obtener_unidades_academicas() {
        $this->db->select('id_unidad, unidad');
        $this->db->from('unidad_academica');
        $query = $this->db->get();
        return $query->result();
    }

    // Función para verificar las credenciales del usuario
    public function checkUser($username, $password, $unidad_academica) {
        $this->db->select('id_user, Nombre_usuario, contraseña, id_unidad');
        $this->db->from('usuarios');
        $this->db->where('Nombre_usuario', $username);
        $this->db->where('contraseña', $password);
        $this->db->where('id_unidad', $unidad_academica);
        $query = $this->db->get();

        if ($query->num_rows() == 1) {
            return $query->row();
        } else {
            return false;
        }
    }

    public function obtener_Datos_Por_Unidad_Academica($unidad_academica) {
        $this->db->select('id_unidad');
        $this->db->from('usuarios');
        $this->db->where('id_unidad', $unidad_academica);
        $query = $this->db->get();
        return $query->result();
    }

    public function getUnidadResponId($id_user){
        $id_user = $this->session->userdata("id_user");
        $this->db->select('id_uni_respon_usu'); 
        $this->db->where('id_user', $id_user);
        $query = $this->db->get('uni_respon_usu'); 
    
        if ($query->num_rows() > 0) {
            $row = $query->row();
            return $row->id_uni_respon_usu; 
        } else {
            return false; 
        }
    }

     //Funcion para obtner la unidad academica del usuario
     public function getUserUnidadAcademica($id_user) {
        $this->db->select('id_unidad');
        $this->db->from('usuarios');
        $this->db->where('id_user', $id_user);
        $query = $this->db->get();
        
        // Se verifica si se encontraron resultados
        if ($query->num_rows() > 0) {
            // Retorna el ID de la unidad académica
            $row = $query->row();
            return $row->id_unidad;
        } else {
            return null;
        }
    }

   

    // Corrobora la contraseña
    function checkCurrentPassword($currentPassword) {
        $id_user = $this->session->userdata('LoginSession')['id_user'];
        $this->db->where('id_user', $id_user);
        $this->db->where('contraseña', $currentPassword);
        $query = $this->db->get('usuarios');
        return $query->num_rows() == 1;
    }

    // Actualiza la contraseña
    function updatePassword($password) {
        $id_user = $this->session->userdata('LoginSession')['id_user'];
        $this->db->set('contraseña', $password);
        $this->db->where('id_user', $id_user);
        $this->db->update('usuarios');
    }

    // Obtiene el id del usuario mediante su nombre de usuario
    public function getUserIdByUserName($username) {
        $this->db->select('id_user');
        $this->db->from('usuarios');
        $this->db->where('Nombre_usuario', $username);
        $query = $this->db->get();
        return $query->num_rows() > 0 ? $query->row()->id_user : false;
    }

    public function getRegistrosPorUnidadAcademica($id_uni_academica) {
        $this->db->select('proveedores.*');
        $this->db->from('proveedores');
        $this->db->join('usuarios', 'proveedores.id_uni_respon_usu = usuarios.id_unidad');
        $this->db->join('unidad_academica', 'usuarios.id_unidad = unidad_academica.id_unidad');
        $this->db->where('usuarios.id_unidad', $id_uni_academica);
        $query = $this->db->get();
        return $query->result();
    }
    
    //Funcion para obtner la unidad academica del usuario
    public function getUserUnidadAcademica($id_user) {
        $this->db->select('id_unidad');
        $this->db->from('usuarios');
        $this->db->where('id_user', $id_user);
        $query = $this->db->get();

        // Se verifica si se encontraron resultados
        if ($query->num_rows() > 0) {
            // Retorna el ID de la unidad académica
            $row = $query->row();
            return $row->id_unidad;
        } else {
            return null;
        }
    }
    
        //Acá obtenemos el id de la tabla id_uni_respon_usu  mediante el id del usuario
        public function getUserIdUniResponByUserId($id_user) {
            $this->db->select('unidad_academica.id_unidad');
            $this->db->from('unidad_academica');
            $this->db->join('usuarios', 'unidad_academica.id_unidad = usuarios.id_unidad');
            $this->db->where('unidad_academica.id_unidad', $id_user);
            $query = $this->db->get();
        
            if ($query->num_rows() > 0) {
                $row = $query->row();
                return $row->id_unidad;
            } else {
                return false;
            }
        }

         //Acá obtenemos el id de la tabla id_uni_respon_usu  mediante el id del usuario
         public function getUnidad_academica($id_unidad) {
            $this->db->select('uni_respon_usu.id_unidad');
            $this->db->from('uni_respon_usu');
            $this->db->join('unidad_academica', 'unidad_academica.id_unidad = uni_respon_usu.id_unidad');
            $this->db->where('unidad_academica.id_unidad', $id_unidad);
            $query = $this->db->get();
        
            if ($query->num_rows() > 0) {
                $row = $query->row();
                return $row->id_unidad;
            } else {
                return false;
            }
        }

    // Si queremos obtener nombres de usuarios directamente por los nombres de usuarios
    public function obtener_usuario_por_nombre($username) {
        $this->db->select('Nombre_usuario');
        $this->db->from('usuarios');
        $this->db->where('Nombre_usuario', $username);
        $query = $this->db->get();
        return $query->row() ? $query->row()->Nombre_usuario : false;
    }

    public function getNombreUnidadAcademica($id_unidad) {
        $this->db->select('unidad');
        $this->db->where('id_unidad', $id_unidad);
        $query = $this->db->get('unidad_academica');
        return $query->num_rows() > 0 ? $query->row()->unidad : null;
    }

    // Método para registrar usuario
    public function registrar_usuario($nombre, $contrasena, $unidad_academica) {
        $unidad_query = $this->db->get_where('unidad_academica', array('unidad' => $unidad_academica));

        if ($unidad_query->num_rows() > 0) {
            $unidad = $unidad_query->row();
            $unidad_id = $unidad->id_unidad;

            // Datos para insertar en la tabla usuarios
            $data_usuarios = array(
                'Nombre_usuario' => $nombre,
                'contraseña' => sha1($contrasena),
                'id_unidad' => $unidad_id,
                'estado' => 1,
            );

            // Insertar en la tabla usuarios
            $this->db->insert('usuarios', $data_usuarios);

            if ($this->db->affected_rows() > 0) {
                // Recupera el ID del usuario recién insertado
                $id_user = $this->db->insert_id();

                // Datos para insertar en la tabla uni_respon_usu
                $data_uni_respon_usu = array(
                    'id_user' => $id_user,
                    'id_unidad' => $unidad_id,
                );

                // Insertar en la tabla uni_respon_usu
                $this->db->insert('uni_respon_usu', $data_uni_respon_usu);

                // Registra al usuario y lo autentica
                $this->session->set_userdata('logged_in', TRUE);
                $this->session->set_userdata('Nombre_usuario', $nombre);
                $this->session->set_userdata('unidad_academica', $unidad_academica);
                
                // Asigna el ID del usuario a la sesión
                $this->session->set_userdata('id_user', $id_user);

                return true;
            }
        }

        return false;
    }
}
