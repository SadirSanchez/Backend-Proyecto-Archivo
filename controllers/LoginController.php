<?php
require '../ext/Carbon/autoload.php';
use Carbon\Carbon;
use Carbon\CarbonInterval;

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Content-Type');

require("conection.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Esta parate sólo se utiliza para solicitudes POST
    $input = file_get_contents("php://input");
    $data = json_decode($input, true);
    if ($data['action'] === 'Login') {
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
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {

    $email = $_GET['email'];

    // Conecta a la base de datos
    $conection = new Conection();
    $conn = $conection->conect();

    // Verifica la conexión
    if ($conn->connect_error) {
        echo "Conexión fallida: " . $conn->connect_error;
    } else {
        // Realiza la consulta para verificar las credenciales del usuario
        $query = "SELECT * FROM users WHERE Email='$email'";
        $result = $conn->query($query);

        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            date_default_timezone_set('America/Bogota');

            if ($user['ActiveSesion'] !== null) {
                $actualDate = Carbon::now();
                $localSesionDateTime = new Carbon($user['ActiveSesion']);
                $diff = $localSesionDateTime->diffInMinutes($actualDate);

                if ($diff > 60) {
                    echo 'sesiónInvalida';
                } else {
                    echo 'Ok';
                }
            } else {
                echo 'sesiónInvalida';
            }
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = file_get_contents("php://input");
    $data = json_decode($input, true);

    if ($data['action'] === 'upDateSesion') {
        // Conecta a la base de datos
        $conection = new Conection();
        $conn = $conection->conect();

        // Verifica la conexión
        if ($conn->connect_error) {
            echo "Conexión fallida: " . $conn->connect_error;
        } else {
            $email = $data['email'];
            $query = "SELECT * FROM users WHERE Email='$email'";
            $result = $conn->query($query);

            if ($result->num_rows > 0) {
                $user = $result->fetch_assoc();
                $createat = $data['createat'];
                $userId = $user['Id'];
                $query = "UPDATE users SET ActiveSesion = '$createat' WHERE Id = '$userId' ";
                $result = $conn->query($query);
            }
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = file_get_contents("php://input");
    $data = json_decode($input, true);

    if ($data['action'] === 'deleteSesion') {
        // Conecta a la base de datos
        $conection = new Conection();
        $conn = $conection->conect();

        // Verifica la conexión
        if ($conn->connect_error) {
            echo "Conexión fallida: " . $conn->connect_error;
        } else {
            $email = $data['email'];
            $query = "SELECT * FROM users WHERE Email='$email'";
            $result = $conn->query($query);


            if ($result->num_rows > 0) {
                $user = $result->fetch_assoc();
                $userId = $user['Id'];

                $query = "UPDATE users SET ActiveSesion = NULL WHERE Id = '$userId' ";
                $result = $conn->query($query);

                echo $userId;
            }
        }
    }
}