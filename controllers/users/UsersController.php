<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Content-Type');

require("../conection.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $conection = new Conection();
    if ($conection->validate() === 'ok') {

        // Consulta de inserción

    $input = file_get_contents("php://input");
    $data = json_decode($input, true);

        $nameUser = $data['nameUser'];
        $lastName = $data['lastName'];
        $typeId = $data['typeId'];
        $iDuser = $data['iDuser'];
        $eMail = $data['eMail'];
        $phone = $data['phone'];
        $dependency = $data['dependency'];
        $role = $data['role'];

        $conn = $conection->conect();
        $sql = "INSERT INTO users (NameUser,LastName,TypeId,Id,Email,Phone,Dependency,Role) VALUES 
        ('$nameUser','$lastName','$typeId','$iDuser','$eMail','$phone','$dependency','$role')";

        if ($conn->query($sql) === TRUE) {
            echo "Registro insertado correctamente.";
        } else {
            echo "Error al insertar el registro: " . $conn->error;
        }
    }
}
?>