<?php

    function verificarToken($token) {

        $claveSecreta = "oscar20";

        // Divide el token en payload y firma
        list($payloadBase64, $firmaRecibida) = explode('.', $token);
    
        // Decodificar el payload base64
        $payloadDecodificado = base64_decode($payloadBase64);
    
        // Calcula la firma esperada manualmente
        $firmaEsperadaManual = hash_hmac('sha256', $payloadBase64, $claveSecreta);
    
        // Imprime las firmas y los datos involucrados
        // var_dump([
        //     'Firma recibida' => $firmaRecibida,
        //     'Firma esperada manual' => $firmaEsperadaManual,
        //     'Payload decodificado' => $payloadDecodificado,
        //     'Clave secreta' => $claveSecreta
        // ]); 
    
        // Comparar las firmas en minúsculas
        if (strtolower($firmaRecibida) === strtolower($firmaEsperadaManual)) {
            // Token válido, decodifica el payload
            $payloadDecodificado = base64_decode($payloadBase64);
            return json_decode($payloadDecodificado, true);
        } else {
            return false; // Token no válido
        }
    }

function verificarPermisos($rolesNecesarios, $rolesUsuario) {
    foreach ($rolesNecesarios as $rolNecesario) {
        if (in_array($rolNecesario, $rolesUsuario)) {
            return true; // El usuario tiene el rol necesario
        }
    }
    return false; // El usuario no tiene el rol necesario
}
