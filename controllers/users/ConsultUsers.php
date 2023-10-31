<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Content-Type');

require("../conection.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $conection = new Conection();
    if ($conection->validate() === 'ok') {
        // Obtener los parámetros de búsqueda desde la solicitud
        $input = file_get_contents("php://input");
        $data = json_decode($input, true);

        // Realizar la consulta para buscar usuarios
        $conn = $conection->conect();
        $nameUser = $data['nameUser'];
        $iDuser = $data['iDuser'];
        $sql = "SELECT * FROM users WHERE NameUser LIKE '%$nameUser%' or Id = '$iDuser'";

        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $users = [];
            while ($row = $result->fetch_assoc()) {
                $users[] = $row;
            }
            echo json_encode($users);
        } else {
            echo json_encode([]);
        }
    }
}
?>
