<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Content-Type');

require("../conection.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $conection = new Conection();
    if ($conection->validate() === 'ok') {

        $data = json_decode($_POST['data'], true);
        $fileName = time().'.pdf';
        $temporalRoute = $_FILES['file']['tmp_name'];
        $dirFolder = '../../storage/'.date('Y-m-d').'/';
        if (!file_exists($dirFolder)) {
            mkdir($dirFolder, 0777, true); 
        }
        move_uploaded_file($temporalRoute, $dirFolder . $fileName);

        $dependency = $data['dependency'];
        $documentType = $data['documentType'];
        $name = $data['name'];
        $time = $data['time'];
        $selectedDatePicker = $data['selectedDatePicker'];
        $inventory = $data['inventory'];
        $location = $data['location'];
        $fileRoute = $dirFolder . $fileName;

        $conn = $conection->conect();
        $sql = "INSERT INTO document (DocumentName,DocumentType,DateElaboration,TotalInventory,RetentionTime,OriginDependency,PhysicalLocation, FileRoute) VALUES 
        ('$name','$documentType','$selectedDatePicker','$inventory','$time','$dependency','$location', '$fileRoute')";

        if ($conn->query($sql) === TRUE) {
            echo "Registro insertado correctamente";
        } else {
            echo "Error al insertar el registro: " . $conn->error;
        }

    }
}

?>