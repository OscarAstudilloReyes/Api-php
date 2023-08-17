<?php

// Clave secreta para firmar los tokens (debe ser segura y mantenerse en secreto)
$claveSecreta = "oscar20";

// Datos del usuario (pueden incluir el ID, nombre de usuario, roles, etc.)
//administrador
//editor
//visitante

$datosUsuario = [
    "id" => 1,
    "nombre" => "oscar",
    "roles" => ["editor","administrador","invitado"]
];

// Configuración del token (puede incluir expiración y otras opciones)
$tiempoExpiracion = time() + 3600; // Expira en 1 hora
$tokenPayload = [
    "iss" => "tu_app",
    "aud" => "usuarios",
    "iat" => time(),
    "nbf" => time(),
    "exp" => $tiempoExpiracion,
    "data" => $datosUsuario
];

// Codificar el payload en base64
$payloadBase64 = base64_encode(json_encode($tokenPayload));

// Crear la firma del token
$firma = hash_hmac('sha256', $payloadBase64, $claveSecreta);

// Construir el token
$token = $payloadBase64 . '.' . $firma;

// Devolver el token al cliente (puede ser en una respuesta JSON)
echo json_encode(["token" => $token]);
