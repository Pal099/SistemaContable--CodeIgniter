<?php
class Usuarios_model extends CI_Model
{
    function checkUser($username, $password, $unidad_academica)
    {
        $query = $this->db->query("
            SELECT id_user, Nombre_usuario, contraseña, id_unidad
            FROM usuarios
            WHERE Nombre_usuario = '$username' AND contraseña = '$password' AND id_unidad = $unidad_academica
        ");
    
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
    
public function obtener_unidades_academicas()
    {
        // Selecciona todas las unidades académicas de la tabla unidad_academica
        $query = $this->db->get('unidad_academica');

        // Verifica si hay resultados
        if ($query->num_rows() > 0) {
            // Devuelve los resultados como un array de objetos
            return $query->result();
        }

        // Si no hay resultados, devuelve false
        return false;
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
        //Corrobora la contraseña
	function checkCurrentPassword($currentPassword)
	{
		$id_user = $this->session->userdata('LoginSession')['id_user'];
		$query = $this->db->query("SELECT * from usuarios WHERE id_user='$id_user' AND contraseña='$currentPassword' ");
		if($query->num_rows()==1)
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	function updatePassword($password)
	{
		$userid = $this->session->userdata('LoginSession')['id_user'];
		$query = $this->db->query("update  usuarios set contraseña='$password' WHERE id_user='$id_user' ");
		
	}

    //Acá obtenemos el id del usuario mediante su nombre de usuario
    public function getUserIdByUserName($username) {
        $this->db->select('id_user');
        $this->db->from('usuarios');
        $this->db->where('Nombre_usuario', $username);
        $query = $this->db->get();
    
        if ($query->num_rows() > 0) {
            $row = $query->row();
            return $row->id_user;
        } else {
            return false;
        }
    }
    
    //Acá obtenemos el id de la tabla id_uni_respon_usu  mediante el id del usuario
    public function getUserIdUniResponByUserId($id_user) {
        $this->db->select('id_uni_respon_usu');
        $this->db->from('uni_respon_usu');
        $this->db->join('usuarios', 'uni_respon_usu.id_user = usuarios.id_user');
        $this->db->where('uni_respon_usu.id_user', $id_user);
        $query = $this->db->get();
    
        if ($query->num_rows() > 0) {
            $row = $query->row();
            return $row->id_uni_respon_usu;
        } else {
            return false;
        }
    }

    //Si queremos obtener nombres de usuarios directamente por los nombres de usuarios
    public function obtener_usuario_por_nombre($username) {
        $query = $this->db->select('Nombre_usuario')
            ->get_where('usuarios', array('Nombre_usuario' => $username));
    
        $result = $query->row();
        if ($result) {
            return $result->Nombre_usuario;
        } else {
            return false;
        }
    }

    public function getNombreUnidadAcademica($id_unidad) {
        $this->db->select('unidad'); // Asumiendo que el campo que contiene el nombre es 'nombre'
        $this->db->where('id_unidad', $id_unidad);
        $query = $this->db->get('unidad_academica');

        if ($query->num_rows() > 0) {
            $unidad = $query->row();
            return $unidad->unidad;
        }

        return null;
    }
    
    
    //Acá es el método para registrar, y es llamado en el controlador Registro_usuario
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
            // Después de obtener el ID del usuario recién insertado
            $id_user = $this->db->insert_id();

            // Asigna el ID del usuario a la sesión
            $this->session->set_userdata('id_user', $id_user);

            return true;
        }
    }

    return false;
}


    



}