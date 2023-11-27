<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Content-Type');

require("../conection.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $conection = new Conection();
    if ($conection->validate() === 'ok') {

        $input = file_get_contents("php://input");
        $data = json_decode($input, true);

        $dependency = $data['dependency'];
        $documentType = $data['documentType'];
        $name = $data['name'];
        $time = $data['time'];
        $selectedDatePicker = $data['selectedDatePicker'];
        $inventory = $data['inventory'];
        $location = $data['location'];

        $conn = $conection->conect();
        $sql = "INSERT INTO document (DocumentName,DocumentType,DateElaboration,TotalInventory,RetentionTime,OriginDependency,PhysicalLocation) VALUES 
        ('$name','$documentType','$selectedDatePicker','$inventory','$time','$dependency','$location')";

        if ($conn->query($sql) === TRUE) {
            echo "Registro insertado correctamente.";
        } else {
            echo "Error al insertar el registro: " . $conn->error;
        }

    }
}

?>