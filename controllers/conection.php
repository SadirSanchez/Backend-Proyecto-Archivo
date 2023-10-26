<?php

class Conection {

public $serverName = "127.0.0.1";
public $userName = "root";
public $password = "";
public $dataBase = "proyecto_archivo";

public function validate (){

    $conn = new mysqli($this->serverName, $this->userName, $this->password, $this->dataBase);// Crear una conexión

    // Verificar la conexión

    if ($conn->connect_error) {
        return "Conexión fallida: " . $conn->connect_error;
    }
    
    return "ok";
    
    $conn->close();

} 

public function conect(){
    $conn = new mysqli($this->serverName, $this->userName, $this->password, $this->dataBase);// Crear una conexión

    return $conn;
}

}



