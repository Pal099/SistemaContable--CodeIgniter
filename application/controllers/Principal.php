<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Principal extends CI_CONTROLLER {

    public function index()
    {
        $data = array(
		);
		$dato = array(


		);
		$this->load->view("layouts/header");
		$this->load->view("layouts/aside");
		$this->load->view("admin/principal", $data);
		$this->load->view("layouts/footer",$dato);
    }
    

	public function calcularTotalVentas()
    {
        $this->db->select_sum('precio_venta');
        $query = $this->db->get('productos');
        $result = $query->row();
        $totalVentas = $result->precio_venta;

        return $totalVentas;
    }



    public function getProductos()
    {
        $this->db->where('estado', '1'); // Solo obtener productos con estado igual a 1
        $resultados = $this->db->get('productos');
        return $resultados->result();
    }

    protected function middleware()
    {
        return ['Sesion'];
    }

    public function filtrar()
    {
        $producto = $this->input->post('producto'); // Obtener el valor seleccionado del formulario
        $dato = array(
            'producto' => $this->getProducto($producto),
            //'totalVentas' => $this->calcularTotalVentas() // Agrega esta línea para pasar la variable $totalVentas a la vista
        );

        if ($this->input->post('filtrar')) { // Verificar si se ha enviado el formulario

            $producto_id = $this->input->post('producto');
            $cantidad = $this->input->post('cantidad');

            // Validar que se haya seleccionado un producto y se haya ingresado una cantidad
            if ($producto_id && $cantidad) {
                // Obtener el producto
                $producto = $this->getProducto($producto_id);

                // Verificar si hay suficiente stock para la cantidad seleccionada
                if ($producto->stock_minimo >= $cantidad) {
                    // Restar la cantidad al stock mínimo del producto
                    $nuevo_stock_minimo = $producto->stock_minimo - $cantidad;

                    // Actualizar el stock mínimo en la base de datos
                    $data = array(
                        'stock_minimo' => $nuevo_stock_minimo
                    );

                    $this->db->where('id', $producto_id);
                    $this->db->update('productos', $data);

                    // Calcular el monto total
                    $monto_total = $cantidad * $producto->precio_venta;

                    // Obtener la fecha actual
                    $fecha = date('Y-m-d');

                    // Insertar la compra en la tabla "compras"
                    $compra_data = array(
                        'producto_id' => $producto_id,
                        'precio_unitario' => $producto->precio_venta,
                        'cantidad' => $cantidad,
                        'monto_total' => $monto_total,
                        'fecha' => $fecha
                    );
                    $this->db->insert('compras', $compra_data);

                    // Redireccionar o mostrar una respuesta de éxito
                } else {
                    echo "La cantidad seleccionada excede el stock mínimo del producto.";
                }
            } else {
                echo "Por favor, seleccione un producto y especifique una cantidad.";
            }

        }

        $this->load->view("layouts/header");
        $this->load->view("layouts/aside");
        $this->load->view("admin/carrito/micarrito", $dato);
        $this->load->view("layouts/footer");
    }

    public function store()
    {
        $producto = $this->input->post("producto");
        $cantidad = $this->input->post("cantidad");

        $data  = array(
            'producto' => $producto,
            'cantidad' => $cantidad,
            'estado' => "0"
        );

        $this->save($data);
    }

    public function add()
    {
        $this->load->view("layouts/header");
        $this->load->view("layouts/aside");
        $this->load->view("admin/categorias/add");
        $this->load->view("layouts/footer");
    }

    public function save($data)
    {
        return $this->db->insert("compras", $data);
    }

	public function delete($id){
		$data  = array(
			'estado' => "0", 
		);
		$this->Categorias_model->update($id,$data);
		echo "principal";
	}

    

}
