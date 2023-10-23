<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Content-Type');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $input = file_get_contents("php://input");
    $data = json_decode($input, true);
    $dependency = $data['dependency'];
    echo "Dependencia: $dependency";
    $documentType = $data['documentType'];
    echo "Tipo de documento: $documentType";
    $name = $data['name'];
    echo "Nombre: $name";
    $code = $data['code'];
    echo "Código: $code";
    $selectedDatePicker = $data['selectedDatePicker'];
    echo "Fecha de elaboración: $selectedDatePicker";
    $inventory = $data['inventory'];
    echo "Inventario: $inventory";
    $location = $data['location'];
    echo "Ubicación en físico: $location";
}
