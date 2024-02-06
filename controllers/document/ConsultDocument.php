<?php
require '../../ext/Carbon/autoload.php';
use Carbon\Carbon;
use Carbon\CarbonInterval;

// Encabezados para permitir el acceso desde cualquier origen
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Content-Type');

// Se incluye el archivo de conexión
require("../conection.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $conection = new Conection();
    if ($conection->validate() === 'ok') {

        $input = file_get_contents("php://input");
        $data = json_decode($input, true);

        $documentName = $data['documentName'];
        $documentType = $data['documentType'];
        $originDependency = $data['originDependency'];
        $dateElaboration = $data['dateElaboration'];

        // Convertir las cadenas a objetos Carbon
        $startDate = Carbon::parse($dateElaboration[0]);
        $endDate = Carbon::parse($dateElaboration[1]);

        // Ajustar las horas
        $startDate->startOfDay(); // Establecer hora a las 00:00:00
        $endDate->endOfDay();     // Establecer hora a las 23:59:59

        $conn = $conection->conect();

        // Verifica la conexión
        if ($conn->connect_error) {
            echo "Conexión fallida: " . $conn->connect_error;
        } else {
            // Realiza la consulta a la base de datos
            $query = "SELECT * FROM document WHERE DocumentName='$documentName' OR DocumentType='$documentType' OR OriginDependency='$originDependency' OR (DateElaboration BETWEEN '$startDate' AND '$endDate')";
            $result = $conn->query($query);

            // Cierra la conexión
            $conn->close();

            $documents = $result->fetch_all(MYSQLI_ASSOC);

            foreach ($documents as &$document) {
                $document['FileRoute'] = 'localhost/proyecto-archivo-back-end/' . $document['FileRoute'];
            }

            // Devuelve los usuarios como JSON
            header('Content-Type: application/json');

            echo json_encode($documents);

        }
    }

}

?>