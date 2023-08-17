<?php

$request = $_SERVER['REQUEST_URI'];
//acceder a la api: http://localhost/MiAPI/api/index.php/api/v1/recursos/usuarios
include 'v1/recursos/errores.php';


if ($request === "/MiAPI/api/index.php/api/v1/recursos/usuarios") {
    require 'v1/recursos/usuarios.php';
} elseif ($request === "/MiAPI/api/index.php/api/v1/recursos/productos") {
    require 'v1/recursos/productos.php';
} elseif ($request === "/MiAPI/api/index.php/api/v1/recursos/clientes") {
    require 'v1/recursos/clientes.php';
} 
 elseif ($request === "/MiAPI/api/index.php/api/v1/generar_token") {
    require 'v1/generar_token.php';
} 

else {
    generarRespuestaError("Recurso no encontrado", 401);
}