<?php

class Usuario {

    private $idusuario;
    private $deslogin;
    private $dessenha;
    private $dtcadastro;

    public function getIdusuario(){

        return $this->idusuario;
    }

    public function setIdusuario($id){

        return $this->idusuario = $id;

    }
    
    public function getDeslogin(){

        return $this->deslogin;
    }

    public function setDeslogin($login){

        return $this->deslogin = $login;

    }

    public function getDessenha(){
        
        return $this->dessenha;
    }

    public function setDessenha($senha){
        
        return $this->dessenha = $senha;
    }
    
    public function getDtcadastro(){

        return $this->dtcadastro;
    }

    public function setDtcadastro($cadastro){

        return $this->dtcadastro = $cadastro;
    }
    

    public function loadById($id){

        $sql = new Sql();
        $result = $sql->select("SELECT * FROM tb_usuarios WHERE idusuario = :ID", array(
            ":ID"=>$id
        ));

        if(isset($result[0])){

            $this->setData($result[0]);
        }

    }

    public static function getList(){
        $sql = new Sql();
        return $sql->select("SELECT * FROM tb_usuarios ORDER BY deslogin");
    }

    public static function search($login){
        $sql = new Sql();
        return $sql->select("SELECT * FROM tb_usuarios WHERE deslogin LIKE :SEARCH ORDER BY deslogin", array(
            ":SEARCH"=>"%".$login."%"
        ));
    }

    public  function login($login, $password){

        $sql = new Sql();
        $result = $sql->select("SELECT * FROM tb_usuarios WHERE deslogin = :LOGIN AND dessenha = :PASSWORD", array(
            ":LOGIN"=>$login,
            ":PASSWORD"=>$password
        ));

        if(isset($result[0])){

            $this->setData($result[0]);
            
        }else{
            throw new Exception("Login e/ou senha inválidos");
        }

    }

    public function setData($data){

        $this->setIdusuario($data['idusuario']);
        $this->setDeslogin($data['deslogin']);
        $this->setDessenha($data['dessenha']);
        $this->setDtcadastro(new DateTime($data['dtcadastro']));

    }

    public function insert(){
        $sql = new Sql();
        $result = $sql->select("CALL sp_usuarios_insert(:LOGIN, :PASSWORD)", array(
            ":LOGIN"=>$this->getDeslogin(),
            ":PASSWORD"=>$this->getDessenha()
        ));
        
        if(count($result) > 0){
            $this->setData($result[0]);
        }

    }

    public function __construct($login = "", $password = ""){

        $this->setDeslogin($login);
        $this->setDessenha($password);
        $this->insert();

    }

    public function update($login, $password){

        $this->setDeslogin($login);
        $this->setDessenha($password);

        $sql = new Sql();
        $sql->query("UPDATE tb_usuario SET deslogin = :login, dessenha = :password WHERE idusuario = :id", array(
            ':login'=>$this->getDeslogin(),
            ':password'=>$this->getDessenha(),
            ':id'=>$this->getIdusuario()
        ));
    }

    public function delete(){

        $sql = new Sql();
        $sql->query("DELETE FROM tb_usuarios WHERE idusuario = :id",array(
            ':id'=>$this->getIdusuario()
        ));

        $this->setIdusuario(0);
        $this->setIdusuario("");
        $this->setDessenha("");
        $this->setDtcadastro(new DateTime());

        
    }

    public function __toString(){
        
        return json_encode(array(
            "idusuario"=>$this->getIdusuario(),
            "deslogin"=>$this->getDeslogin(),
            "dessenha"=>$this->getDessenha(),
            "dtcadastro"=>$this->getDtcadastro()->format("d/m/y H:i:s")
        ));
    }
}