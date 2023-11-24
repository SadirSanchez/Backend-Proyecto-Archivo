<?php
// Encabezados para permitir el acceso desde cualquier origen
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Content-Type');

// Se incluye el archivo de conexión
require("../conection.php");

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Crea una instancia de la clase Conection
    $conection = new Conection();
    $conn = $conection->conect();

    // Verifica la conexión
    if ($conn->connect_error) {
        echo "Conexión fallida: " . $conn->connect_error;
    } else {
        // Se obtiene campos de todos los usuarios
        $sql = "SELECT Id, NameUser, LastName FROM users";
        $result = $conn->query($sql);

        // Verifica errores de consulta
        // if (!$result) {
        //     die(json_encode(array("error" => "Query failed", "details" => $conn->error)));
        // }


        // Convierte el resultado a un array asociativo
        $users = $result->fetch_assoc();

        // Devuelve los usuarios como JSON
        header('Content-Type: application/json');
        echo json_encode($users);

        // Cierra la conexión
        $conn->close();
    }

}

?>