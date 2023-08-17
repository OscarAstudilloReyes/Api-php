
<?php

header('Content-Type: application/json');

require_once 'baseDatosSimulada.php';

// Obtener lista de usuarios
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    echo json_encode($users);
}
