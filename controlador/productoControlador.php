<?php
include 'modelo/productoModelo.php';


class productoControlador { // clase a "productoControlador"
    private $productocontrol; // Atributos
    private $tabla = "productos"; // es la tabla a utilizar
 
    function __construct() {
        $this->productocontrol = new productoModelo($this->tabla);
    }
 
    function obtenerPorCampoEntero($getExterno, $campo) {
        $ce = $this->productocontrol->obtenerEntero($getExterno, $campo);
        return $this->mostrarResultado($ce);
    }
 
    function obtenerPorCampoCadena($getExterno, $campo) {
        $ce = $this->productocontrol->obtenerCadena($getExterno, $campo);
        return $this->mostrarResultado($ce);
    }
    function obtenerTodas($getExterno) {
        $pControl = $this->productocontrol->obtenerTodas($getExterno);
        return $this->mostrarResultado($pControl);
    }

    // Registrar un nuevo producto
    function registrarProducto($datos) {
        $body = $this->productocontrol->registrarProducto($datos);
        return $this->mostrarResultado($body);
    }

    // Actualizar un producto existente
    function actualizarProducto($datos) {
        $body = $this->productocontrol->editarProducto($datos);
        return $this->mostrarResultado($body);
    }

    // Método para eliminar en la tabala
    function eliminaProducto($id) {
        $ce = $this->productocontrol->eliminaProducto($id);
        return $this->mostrarResultado($ce);
    }

    private function mostrarResultado($resu) {
        if ($resu) {
            return json_encode(['data' => $resu], JSON_UNESCAPED_UNICODE);
        }
    }
    
}
?>