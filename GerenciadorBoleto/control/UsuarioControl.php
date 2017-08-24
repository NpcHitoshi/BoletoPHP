<?php

require "../dao/Database.php";
require_once BASE_DIR . "dao" . DS . "UsuarioDao.php";

$db = new Database();
$pdo = $db->conexao();
session_start();
$action = $_GET["action"];
var_dump($action);
$uDAO = new UsuarioDAO();
$usuario = new Usuario();

switch ($action) {
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
        $codigo = $_GET["codigo"];
        $uDAO->desativarUsuario($codigo);
        header("Location: http://" . $_SERVER["HTTP_HOST"] . "/GerenciadorBoleto/clientes.php");
        break;

    case "ativar":
        break;

    default:
        break;
}
