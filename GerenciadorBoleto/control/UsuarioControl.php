<?php

require "../dao/Database.php";
require_once BASE_DIR . "dao" . DS . "UsuarioDao.php";

$db = new Database();
$pdo = $db->conexao();
$action = $_GET["action"];
$_SESSION["usuario"] = $usuario;
$uDAO = new UsuarioDAO();
$usuario = new Usuario();
switch (action) {
    case "buscar":
        break;

    case "inserir":
        $usuario->setRazaoSocial(trim($_POST["razao_social"]));
        $usuario->setCnpj(trim($_POST["cnpj"]));
        $usuario->setEmail(trim($_POST["email"]));
        $numero = (trim($_POST["numero"]));
        break;

    case "alterar":
        break;

    case "desativar":
        
        $uDAO->desativarUsuario($usuario);
        break;

    case "ativar":
        break;

    default:
        break;
}
