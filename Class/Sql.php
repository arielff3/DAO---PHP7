<?php

class SQL extends PDO{

    private $conn;

    // Connecta o php ao db atravez do método magico __construct; logo não preciso instancia-lo
    public function __construct(){

        $this->conn = new PDO("mysql:host=localhost;dbname=dbphp7", "root", "");
    }
    
    private function setParans($statements, $parameters = array()){

        foreach ($parameters as $key => $value) {

            $this->setParam($statements,$key, $value);

        }
    } 

    private function setParam($statements, $key, $value){

        $statements->bindParam($key, $value);
    } 

    public function query($rawQuery, $parans = array()){
        
        $stmt = $this->conn->prepare($rawQuery);    

        $this->setParans($stmt, $parans);

        $stmt->execute();

        return $stmt;

    }

    public function select($rawQuery, $parans = array()):array{

        $stmt = $this->query($rawQuery, $parans);
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);

    }

}