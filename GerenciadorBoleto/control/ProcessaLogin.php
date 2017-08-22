<?php

require_once "../dao/Database.php";
require "../dao/UsuarioDAO.php";
require "../dao/EnderecoDAO.php";

$db = new Database();
$pdo = $db->conexao();
session_start();
$action = $_GET["action"];

switch ($action) {
    case "login":
        try {
            $cnpj = trim($_POST['cnpj']);
            $senha = trim($_POST['senha']);
            $usuarioDAO = new UsuarioDAO();
            $usuario = $usuarioDAO->autenticaUsuario($cnpj, $senha);

            if ($usuario->getCodigoUsuario() != null) {
                $_SESSION["usuario"] = $usuario;
                header("Location: http://" . $_SERVER["HTTP_HOST"] . "/GerenciadorBoleto/clientes.php");
                exit;
            } else {
                $_SESSION["erro"] = "Senha ou CNPJ incorreto";
                header("Location: http://" . $_SERVER["HTTP_HOST"] . "/GerenciadorBoleto/index.php");
                exit;
            }
        } catch (Exception $e) {
            
        }
        break;

    case "logout":  
        if ($usuario != null) {
            session_destroy();
        }
        header("Location: http://" . $_SERVER["HTTP_HOST"] . "/GerenciadorBoleto/index.php");
        exit;
        break;
    default:
        header("Location: http://" . $_SERVER["HTTP_HOST"] . "/GerenciadorBoleto/index.php");
        exit;
}
