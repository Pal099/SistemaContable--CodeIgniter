<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CuentaContable_model extends CI_Model {
//Aquí cargamos en la tabla"cuentacontable" los arrays

    public function getCuentasContables(){
        $this->db->select('cuentacontable.*');
		$this->db->from('cuentacontable');
		$this->db->where('cuentacontable.estado', '1');
		
		$resultados = $this->db->get();
		return $resultados->result();   
    }

    public function getCuentaContable2() {
        $this->db->select('cuentacontable.Codigo_CC, cuentacontable.IDCuentaContable, cuentacontable.padre_id, cuentacontable.Descripcion_CC');
        
        // Agrupamos las condiciones con or_like
        $this->db->group_start();
        $this->db->like('Codigo_CC', '200000000000', 'after'); // Filtrar donde el código comience con "2"
        $this->db->or_like('Codigo_CC', '300000000000', 'after'); // Filtrar donde el código comience con "3"
        $this->db->or_like('Codigo_CC', '400000000000', 'after'); // Filtrar donde el código comience con "4"
        $this->db->or_like('Codigo_CC', '500000000000', 'after'); // Filtrar donde el código comience con "5"
        $this->db->or_like('Codigo_CC', '800000000000', 'after'); // Filtrar donde el código comience con "8"
        $this->db->or_like('Codigo_CC', '900000000000', 'after'); // Filtrar donde el código comience con "8"
        $this->db->group_end();
        
        $query = $this->db->get("cuentacontable");
        return $query->result();
    }

 
    public function getTiposPorCodigoPadre($codigoPadre) {
    $primerDigito = substr($codigoPadre, 0, 1); // Extrae el primer dígito del código del padre
    $this->db->select('cuentacontable.Codigo_CC, cuentacontable.Descripcion_CC, cuentacontable.tipo, cuentacontable.padre_id, cuentacontable.IDCuentaContable');
    $this->db->from('cuentacontable');
    
    // Filtrar por el primer dígito del código
    $this->db->like('Codigo_CC', $primerDigito, 'after'); // Filtra donde el código comience con ese dígito
    
    // Opcional: Agregar un filtro adicional si es necesario
    $this->db->where('estado', 1); // Solo cuentas activas (si tienes esta columna)
    
    $query = $this->db->get();
    return $query->result();
}









    public function getUltimoCodigoPorTipo($tipo)
    {
        // Buscar el último registro con el tipo seleccionado
        $this->db->select('Codigo_CC');
        $this->db->from('cuentacontable'); 
        $this->db->where('tipo', $tipo);
        $this->db->order_by('Codigo_CC', 'DESC'); 
        $this->db->limit(1);
        $query = $this->db->get();
    
        if ($query->num_rows() > 0) {
            return $query->row()->Codigo_CC;
        } else {
            return null;
        }
    }
    
















    public function save($data){
        return $this->db->insert("cuentacontable", $data);
    }

    public function getCuentaContable($id){
        $this->db->where("IDCuentaContable", $id);
        $resultado = $this->db->get("cuentacontable");
        return $resultado->row();
    }



    public function getCuentaPadre($codigo_cc) {
        // La lógica para determinar la cuenta padre puede variar
        // Aquí suponemos que las cuentas padre tienen un código que es un prefijo de las cuentas hijas
        $codigo_padre = substr($codigo_cc, 0, 4) . '01';

        $this->db->where('Codigo_CC', $codigo_padre);
        $query = $this->db->get('cuentas_contables');

        if ($query->num_rows() > 0) {
            return $query->row_array();
        } else {
            return null;
            
        }
    }

    public function update($id, $data){
        $this->db->where("IDCuentaContable", $id);
        return $this->db->update("cuentacontable", $data);
    }

    // Puedes agregar más métodos aquí según lo necesites.
    public function getCuentasPadre() {
        // Las cuentas que pueden ser "padre" son aquellas que no son imputables.
       // $this->db->where('imputable', 0);  // Donde 'imputable' es un campo booleano en tu tabla.
        $this->db->where('estado', 1);     // Asumiendo que 'estado' es un campo que indica si la cuenta está activa.
        
        // Puedes agregar más condiciones si, por ejemplo, solo ciertos tipos pueden ser padres.-si 
        // Por ejemplo, si solo "Título" y "Grupo" pueden ser padres, puedes agregar:
        $this->db->where_in('tipo', ['Título', 'Grupo','Subgrupo','Cuenta','Subcuenta','Analítico1']);
        
        $result = $this->db->get('cuentacontable');  // 'cuentacontable' es el nombre de tu tabla.
    
        if ($result->num_rows() > 0) {
            return $result->result();
        }
    
        return false;
    }

    public function getCuentasPadrePorTipo($tipoHijo) {
        switch ($tipoHijo) {
            case 'Grupo':
                $tipoPadre = 'Título';
                break;
            case 'Subgrupo':
                $tipoPadre = 'Grupo';
                break;
            // ... Y así sucesivamente para cada tipo de cuenta ...
            default:
                $tipoPadre = null;
        }
    
        if ($tipoPadre) {
            $this->db->where('tipo', $tipoPadre);
            $this->db->where('estado', 1);  // Asumiendo que 'estado' es un campo que indica si la cuenta está activa.
            $result = $this->db->get('cuentacontable');
        
            if ($result->num_rows() > 0) {
                return $result->result();
            }
        }
        
        return false;
    }
    public function getCuentasPorTipo($tipo) {
        $this->db->where('tipo', $tipo);
        $this->db->where('estado', 1);  // Asumiendo que 'estado' es un campo que indica si la cuenta está activa.
        $result = $this->db->get('cuentacontable');  // 'cuentacontable' es el nombre de tu tabla.
    
        if ($result->num_rows() > 0) {
            return $result->result();
        }
    
        return false;
    }
    

    
    public function add() {
        $data = array(
            'cuentasPadre' => $this->CuentaContable_model->getCuentasPadre(),  // Obtener las cuentas padre disponibles
        );
        $this->load->view('layouts/header');
        $this->load->view('layouts/aside');
        $this->load->view('admin/CuentaContable/add', $data);
        $this->load->view('layouts/footer');
    }



    public function getNextCodigoTitulo() {
        $this->db->select_max('Codigo_CC');
        $this->db->where('tipo', 'Título');
        $result = $this->db->get('cuentacontable')->row();
    
        if ($result) {
            $lastCode = intval($result->Codigo_CC);
            return $lastCode + 1 . ".0.0.0.00.00.00.000";
        } else {
            // Si no hay ningún título, comenzamos con el código "2" (basado en tu ejemplo)
            return "1.0.0.0.00.00.00.000";
        }
    }
    public function getNextCodigoGrupo($padre_id) {
        // Primero, obtenemos el código del título padre
        $this->db->select('Codigo_CC');
        $this->db->where('IDCuentaContable', $padre_id);
        $padre = $this->db->get('cuentacontable')->row();
    
        if ($padre) {
            $baseCode = $padre->Codigo_CC;
    
            // Luego, buscamos el último código de grupo bajo ese título
            $this->db->select_max('Codigo_CC');
            $this->db->like('Codigo_CC', $baseCode, 'after');
            $this->db->where('tipo', 'Grupo');
            $result = $this->db->get('cuentacontable')->row();
    
            if ($result) {
                $lastGroup = intval(explode('.', $result->Codigo_CC)[1]);
                return $baseCode[0] . "." . ($lastGroup + 1) . ".0.0.00.00.00.000";
            } else {
                // Si no hay ningún grupo bajo ese título, comenzamos con ".1"
                return $baseCode[0] . ".1.0.0.00.00.00.000";
            }
        } else {
            // Error: El padre_id proporcionado no corresponde a un título válido
            return false;
        }
    }
    public function getNextCodigoSubGrupo($padre_id) {
        // Primero, obtenemos el código del grupo padre
        $this->db->select('Codigo_CC');
        $this->db->where('IDCuentaContable', $padre_id);
        $padre = $this->db->get('cuentacontable')->row();
    
        if ($padre) {
            $baseCode = $padre->Codigo_CC;
    
            // Luego, buscamos el último código de subgrupo bajo ese grupo
            $this->db->select_max('Codigo_CC');
            $this->db->like('Codigo_CC', $baseCode, 'after');
            $this->db->where('tipo', 'SubGrupo');
            $result = $this->db->get('cuentacontable')->row();
    
            if ($result) {
                $lastSubGroup = intval(explode('.', $result->Codigo_CC)[2]);
                return substr($baseCode, 0, 4) . "." . ($lastSubGroup + 1) . ".0.0.00.00.00.000";
            } else {
                // Si no hay ningún subgrupo bajo ese grupo, comenzamos con ".1"
                return substr($baseCode, 0, 4) . ".1.0.0.00.00.00.000";
            }
        } else {
            // Error: El padre_id proporcionado no corresponde a un grupo válido
            return false;
        }
    }
    public function getNextCodigoCuenta($padre_id) {
        // Primero, obtenemos el código del subgrupo padre
        $this->db->select('Codigo_CC');
        $this->db->where('IDCuentaContable', $padre_id);
        $padre = $this->db->get('cuentacontable')->row();
    
        if ($padre) {
            $baseCode = $padre->Codigo_CC;
    
            // Luego, buscamos el último código de cuenta bajo ese subgrupo
            $this->db->select_max('Codigo_CC');
            $this->db->like('Codigo_CC', $baseCode, 'after');
            $this->db->where('tipo', 'Cuenta');
            $result = $this->db->get('cuentacontable')->row();
    
            if ($result) {
                $lastCuenta = intval(explode('.', $result->Codigo_CC)[3]);
                return substr($baseCode, 0, 8) . "." . str_pad($lastCuenta + 1, 2, '0', STR_PAD_LEFT) . ".0.00.00.00.000";
            } else {
                // Si no hay ninguna cuenta bajo ese subgrupo, comenzamos con ".01"
                return substr($baseCode, 0, 8) . ".01.0.00.00.00.000";
            }
        } else {
            // Error: El padre_id proporcionado no corresponde a un subgrupo válido
            return false;
        }
    }
    public function getNextCodigoSubCuenta($padre_id) {
        // Primero, obtenemos el código de la cuenta padre
        $this->db->select('Codigo_CC');
        $this->db->where('IDCuentaContable', $padre_id);
        $padre = $this->db->get('cuentacontable')->row();
    
        if ($padre) {
            $baseCode = $padre->Codigo_CC;
    
            // Luego, buscamos el último código de subcuenta bajo esa cuenta
            $this->db->select_max('Codigo_CC');
            $this->db->like('Codigo_CC', $baseCode, 'after');
            $this->db->where('tipo', 'SubCuenta');
            $result = $this->db->get('cuentacontable')->row();
    
            if ($result) {
                $lastSubCuenta = intval(explode('.', $result->Codigo_CC)[4]);
                return substr($baseCode, 0, 11) . "." . str_pad($lastSubCuenta + 1, 2, '0', STR_PAD_LEFT) . ".0.00.00.000";
            } else {
                // Si no hay ninguna subcuenta bajo esa cuenta, comenzamos con ".01"
                return substr($baseCode, 0, 11) . ".01.0.00.00.000";
            }
        } else {
            // Error: El padre_id proporcionado no corresponde a una cuenta válida
            return false;
        }
    }
    public function getNextCodigoAnalitico1($padre_id) {
        // Primero, obtenemos el código de la subcuenta padre
        $this->db->select('Codigo_CC');
        $this->db->where('IDCuentaContable', $padre_id);
        $padre = $this->db->get('cuentacontable')->row();
    
        if ($padre) {
            $baseCode = $padre->Codigo_CC;
    
            // Luego, buscamos el último código de analitico1 bajo esa subcuenta
            $this->db->select_max('Codigo_CC');
            $this->db->like('Codigo_CC', $baseCode, 'after');
            $this->db->where('tipo', 'Analitico 1');
            $result = $this->db->get('cuentacontable')->row();
    
            if ($result) {
                $lastAnalitico1 = intval(explode('.', $result->Codigo_CC)[5]);
                return substr($baseCode, 0, 14) . "." . str_pad($lastAnalitico1 + 1, 2, '0', STR_PAD_LEFT) . ".0.00.000";
            } else {
                // Si no hay ningún analitico1 bajo esa subcuenta, comenzamos con ".01"
                return substr($baseCode, 0, 14) . ".01.0.00.000";
            }
        } else {
            // Error: El padre_id proporcionado no corresponde a una subcuenta válida
            return false;
        }
    }

    public function getNextCodigoAnalitico2($padre_id) {
        // Primero, obtenemos el código del analitico1 padre
        $this->db->select('Codigo_CC');
        $this->db->where('IDCuentaContable', $padre_id);
        $padre = $this->db->get('cuentacontable')->row();
    
        if ($padre) {
            $baseCode = $padre->Codigo_CC;
    
            // Luego, buscamos el último código de analitico2 bajo ese analitico1
            $this->db->select_max('Codigo_CC');
            $this->db->like('Codigo_CC', $baseCode, 'after');
            $this->db->where('tipo', 'Analitico 2');
            $result = $this->db->get('cuentacontable')->row();
    
            if ($result) {
                $lastAnalitico2 = intval(explode('.', $result->Codigo_CC)[6]);
                return substr($baseCode, 0, 17) . "." . str_pad($lastAnalitico2 + 1, 3, '0', STR_PAD_LEFT);
            } else {
                // Si no hay ningún analitico2 bajo ese analitico1, comenzamos con ".001"
                return substr($baseCode, 0, 17) . ".001";
            }
        } else {
            // Error: El padre_id proporcionado no corresponde a un analitico1 válido
            return false;
        }
    }
    

}
