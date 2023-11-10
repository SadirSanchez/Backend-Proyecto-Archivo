<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Content-Type');

require("conection.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = file_get_contents("php://input");
    $data = json_decode($input, true);

    $nameUser = $data['nameUser'];
    $password = $data['password'];

    // Conecta a la base de datos
    $conection = new Conection();
    $conn = $conection->conect();

    // Verifica la conexión
    if ($conn->connect_error) {
        echo "Conexión fallida: " . $conn->connect_error;
    } else {
        // Realiza la consulta para verificar las credenciales del usuario
        $query = "SELECT * FROM users WHERE Email='$nameUser' AND Password='$password'";
        $result = $conn->query($query);

        if ($result->num_rows > 0) {
            echo "Autenticación exitosa"; // Las credenciales son válidas
        } else {
            echo "Credenciales inválidas"; // Las credenciales son incorrectas
        }

        $conn->close();
    }
}
