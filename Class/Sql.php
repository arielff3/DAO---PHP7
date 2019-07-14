<?php

class SQL extends PDO{

    private $conn;

    public function __construct(){

        $this->conn = new PDO("mysql:host=localhost;dbname=dbphp7", "root", "");
    }

    private function setParans($statments, $parameters = array()){

        foreach ($parameters as $key => $value) {

            $this->setParans($key, $value);

        }
    } 

    private function setParam($statments, $key, $value){

        $statments->bindParam($key, $value);
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