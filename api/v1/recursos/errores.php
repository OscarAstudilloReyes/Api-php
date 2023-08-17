<?php

function generarRespuestaError($mensaje, $codigo = 500) {

    // Registrar solicitud en el archivo de registro
    $logMessage = "[" . date('Y-m-d H:i:s') . "] solicitud API - Método: " . $_SERVER['REQUEST_METHOD'] . " - IP: " . $_SERVER['REMOTE_ADDR'] . PHP_EOL.$mensaje;
   
    $logFilePath = 'v1/api_log.txt';

    if (!file_exists($logFilePath)) {
        // Crea el archivo de registro vacío
        file_put_contents($logFilePath, '');
        // Asegúrate de que el archivo tenga permisos de escritura
        chmod($logFilePath, 0777);
    }
   
    error_log($logMessage, 3, 'v1/api_log.txt');


    http_response_code($codigo);
    echo json_encode(["error" => $mensaje]);
    exit();
}