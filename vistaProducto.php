<?php
include 'controlador/productoControlador.php';

// permite el acceso a consumir la api desde otro servidor
header("Access-Control-Allow-Origin: *");
// Permitir los métodos GET, POST, PUT, DELETE
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
// Permitir ciertos encabezados en las solicitudes
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");

$objproducto = new productoControlador();

switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        if (isset($_GET['id'])) {
            echo $objproducto->obtenerPorCampoEntero($_GET['id'], "id");
        } elseif (isset($_GET['producto'])) {
            echo $objproducto->obtenerPorCampoCadena($_GET['producto'], "articulo");
        } elseif (isset($_GET['t'])) {
            echo $objproducto->obtenerTodas($_GET['t']);
        } else {
            echo json_encode(['error' => 'Parámetros Incorrectos.'], JSON_UNESCAPED_UNICODE);
        }
        break;

        case 'POST':
            $body = json_decode(file_get_contents('php://input'), true);
            if (isset($body)) {
            if (empty($body['idp'])) {

                $datos = [
                    'codigo' => $body['codigo'],
                    'producto' => $body['producto'],
                    'precio' => $body['precio'],
                    'cantidad' => $body['cantidad']
                ];
                echo $objproducto->registrarProducto($datos);
                
            } else {
                // Si se recibe un ID, actualizar el producto
                $datos = [
                    'id' => $body['idp'],
                    'codigo' => $body['codigo'],
                    'producto' => $body['producto'],
                    'precio' => $body['precio'],
                    'cantidad' => $body['cantidad']
                ];
                echo $objproducto->actualizarProducto($datos);
            }
        }
        break;

        case 'DELETE':

            $body = json_decode(file_get_contents('php://input'), true);
            
            if (isset($body['delete'])) {
                echo $objproducto->eliminaProducto($body['delete']); 
            } else {
                echo json_encode(['error' => 'ID no especificado.'], JSON_UNESCAPED_UNICODE);
            }
            break;
    

    default:
    echo json_encode(['error' => 'Método no permitido.'], JSON_UNESCAPED_UNICODE);
}


?>