<?php

require_once("Config.php");


// Carrega 1 usuaria
// $root = new Usuario();
// $root->loadById(2);
// echo $root;

// Carrega uma lista de usuarios
// $lista = Usuario::getList();
// echo json_encode($lista);

// Carrega uma lista de usuarios buscando pelo login
// $busca = Usuario::search("and");
// echo json_encode($busca);

// Carrega um usuario usando um loguin e senha

$usuario = new Usuario();
$usuario->login("Amanda","123312");
echo $usuario;