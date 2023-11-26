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
        $sql = "SELECT * FROM users";
        $result = $conn->query($sql);

        // Cierra la conexión
        $conn->close();

        // Convierte el resultado a un array asociativo
        $users = $result->fetch_all(MYSQLI_ASSOC);

        // Devuelve los usuarios como JSON
        header('Content-Type: application/json');
        $usersResult = "";
        for ( $i = 0; $i < count($users); $i++ ) {
            $usersResult .= $users[$i]['NameUser']."-".$users[$i]['LastName']."-".$users[$i]['Id']. ",";
                        
         }
        // $users = json_decode($users, true);
        // $users = json_encode($users, true);
         echo $usersResult;

    }

}

?>