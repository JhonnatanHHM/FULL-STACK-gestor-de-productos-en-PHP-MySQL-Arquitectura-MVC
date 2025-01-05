<?php
include 'conexion/bd.php';

class productoModelo {
    private $cone;
    private $tabla;

    function __construct($tabla) {
        global $conn;
        $this->cone = $conn;
        $this->tabla = $tabla;
    }

    // getById
    function obtenerEntero($dato, $campo) {
        $sentencia = $this->cone->prepare("SELECT * FROM " . $this->tabla . " WHERE " . $campo . " = :dato");
        $sentencia->bindParam(':dato', $dato, PDO::PARAM_INT); // Cambiado de $id a $dato
        $sentencia->execute();
        $resultado = $sentencia->fetch(PDO::FETCH_ASSOC);
        echo json_encode($resultado);
    }

    // getByString
    function obtenerCadena($datos, $campo) {
        $data = $datos;
        if ($data != "") {
            $sentencia = $this->cone->prepare("SELECT * FROM " . $this->tabla . " WHERE id LIKE '%".$data."%' OR producto LIKE '%".$data."%' OR precio LIKE '%".$data."%'");
            $sentencia->execute();
        
        return $sentencia->fetchAll(PDO::FETCH_ASSOC);
    } else {
        return json_encode(['error' => 'No es dato de página correcto.'], JSON_UNESCAPED_UNICODE);
    }
}

    //getAll
    function obtenerTodas($page) {
        if ($page > 0) {
            $offset = ($page - 1) * 50;
            $sentencia = $this->cone->prepare("SELECT * FROM " . $this->tabla . " LIMIT 50 OFFSET :offset");
            $sentencia->bindParam(':offset', $offset, PDO::PARAM_INT);
            $sentencia->execute();
            return $sentencia->fetchAll(PDO::FETCH_ASSOC);
        } else {
            return json_encode(['error' => 'No es dato de página correcto.'], JSON_UNESCAPED_UNICODE);
        }
    }

    //POST
    function registrarProducto($body)
    {
        
        $codigo = $body['codigo'];
        $producto = $body['producto'];
        $precio = $body['precio'];
        $cantidad = $body['cantidad'];
        
        $sentencia = $this->cone->prepare("INSERT INTO ". $this->tabla ."(codigo, producto, precio, cantidad) VALUES (:cod, :pro, :pre, :cant)");
        $sentencia->bindParam(":cod", $codigo);
        $sentencia->bindParam(":pro", $producto);
        $sentencia->bindParam(":pre", $precio);
        $sentencia->bindParam(":cant", $cantidad);
        $sentencia->execute();
        $cone = null;
        echo "ok";
    }
    //PUT
    function editarProducto($body)
    {
        $codigo = $body['codigo'];
        $producto = $body['producto'];
        $precio = $body['precio'];
        $cantidad = $body['cantidad'];
        $id = $body['id'];
        
        $sentencia = $this->cone->prepare("UPDATE ". $this->tabla ." SET codigo = :cod, producto = :pro, precio =:pre, cantidad = :cant WHERE id = :id");
        $sentencia->bindParam(":cod", $codigo);
        $sentencia->bindParam(":pro", $producto);
        $sentencia->bindParam(":pre", $precio);
        $sentencia->bindParam(":cant", $cantidad);
        $sentencia->bindParam("id", $id);
        $sentencia->execute();
        $cone = null;
        echo "ok";
    }


    // DELETE
function eliminaProducto($id) {
    $sentencia = $this->cone->prepare("DELETE FROM " . $this->tabla . " WHERE id = :id");
    $sentencia->bindParam(':id', $id, PDO::PARAM_INT);
    $sentencia->execute();
    
    if ($sentencia->rowCount() > 0) {
        echo "ok"; 
    } else {
        echo json_encode(['error' => 'No se encontró el producto.'], JSON_UNESCAPED_UNICODE);
    }
}


}
?>

