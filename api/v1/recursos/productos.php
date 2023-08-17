
<?php

header('Content-Type: application/json');

require_once 'errores.php';
require_once 'baseDatosSimulada.php';
include 'v1/validacionTokens.php';



//primero ejecutar el archivo generar_token.php



//validacion de token generado
$token = $_SERVER['HTTP_X_ACCESS_TOKEN'];
$datosDecodificados = verificarToken($token);

if ($datosDecodificados !== false) {
    $rolesUsuario = $datosDecodificados["data"]["roles"];
    $rolDeseado = "administrador"; // Cambia esto al rol que estás buscando

    if (in_array($rolDeseado, $rolesUsuario)) {
        
// Obtener todos los productos 
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    echo json_encode($productos);
}

// Crear un nuevo producto - prueba con postman tipo POST
elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
/*
** Estructura envio
* {
    "nombre": "Producto 80",
    "precio": 29.99
}
*/

    // Obtenemos los datos enviados en el cuerpo de la solicitud
    $nuevoProducto = json_decode(file_get_contents("php://input"), true);
    // Validamos los datos (puedes agregar más validaciones aquí)
    if (isset($nuevoProducto['nombre']) && isset($nuevoProducto['precio'])) {
        // Agregamos el nuevo producto al array de productos
        $nuevoProducto['id'] = count($productos) + 1; // Generamos un nuevo ID
        $productos[] = $nuevoProducto;

        // Respondemos con el nuevo producto agregado
        echo json_encode($productos);
    } else {
        http_response_code(400); // Solicitud incorrecta
        echo json_encode(['message' => 'Datos incompletos'], JSON_PRETTY_PRINT);
    }

}
//Actualiza
elseif ($_SERVER['REQUEST_METHOD'] === 'PUT') {
    // Obtenemos los datos enviados en el cuerpo de la solicitud
    $datosActualizados = json_decode(file_get_contents("php://input"), true);

    // Validamos los datos (puedes agregar más validaciones aquí)
    if (isset($datosActualizados['id']) && isset($datosActualizados['nombre']) && isset($datosActualizados['precio'])) {
        // Buscamos el producto por su ID
        $productoEncontrado = null;
        foreach ($productos as &$producto) {
            if ($producto['id'] === $datosActualizados['id']) {
                $productoEncontrado = &$producto;
                break;
            }
        }

        if ($productoEncontrado !== null) {
            // Actualizamos los datos del producto
            $productoEncontrado['nombre'] = $datosActualizados['nombre'];
            $productoEncontrado['precio'] = $datosActualizados['precio'];

            // Respondemos con el producto actualizado
            echo json_encode($productoEncontrado);
        } else {
            http_response_code(404); // Recurso no encontrado
            echo json_encode(['message' => 'Producto no encontrado'], JSON_PRETTY_PRINT);
        }
    } else {
        http_response_code(400); // Solicitud incorrecta
        echo json_encode(['message' => 'Datos incompletos'], JSON_PRETTY_PRINT);
    }
}

elseif ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    // Obtenemos los datos enviados en el cuerpo de la solicitud (si los hay)
    $datosEliminacion = json_decode(file_get_contents("php://input"), true);

    // Validamos los datos (puedes agregar más validaciones aquí)
    if (isset($datosEliminacion['id'])) {
        // Buscamos el producto por su ID
        $indiceProducto = null;
        foreach ($productos as $indice => $producto) {
            if ($producto['id'] === $datosEliminacion['id']) {
                $indiceProducto = $indice;
                break;
            }
        }

        if ($indiceProducto !== null) {
            // Eliminamos el producto del array
            array_splice($productos, $indiceProducto, 1);

            // Respondemos con un mensaje de éxito
            echo json_encode(['message' => 'Producto eliminado con éxito']);
        } else {
            http_response_code(404); // Recurso no encontrado
            echo json_encode(['message' => 'Producto no encontrado'], JSON_PRETTY_PRINT);
        }
    } else {
        http_response_code(400); // Solicitud incorrecta
        echo json_encode(['message' => 'Datos incompletos'], JSON_PRETTY_PRINT);
    }
}


// ... Otras operaciones como actualizar y eliminar productos
else {
    generarRespuestaError("Método no permitido", 405);
}

        
    } else {
        http_response_code(403); // Prohibido
        echo json_encode(["mensaje" => "No tienes permisos para acceder al servicio"]);
        exit();
    }

}else {
    http_response_code(403); // Prohibido
    echo json_encode(["mensaje" => "El token que estas enviando no es correcto"]);
    exit();
}


