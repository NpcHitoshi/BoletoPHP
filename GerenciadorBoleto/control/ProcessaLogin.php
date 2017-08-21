<?php

require "../dao/Database.php";
require "../dao/UsuarioDAO.php";

$db = new Database();
$pdo = $db->conexao();
session_start();
$action = $_GET['action'];
switch ($action) {
    case "login":
        try {
            $cnpj = trim($_POST['cnpj']);
            $senha = trim($_POST['senha']);
            $dao = new UsuarioDAO();
            $usuario = $dao->autenticaUsuario($cnpj, $senha);
            
            if ($usuario->getCodigoUsuario() != null) {
                $_SESSION["usuario"] = $usuario;
            } else {
                $_SESSION["erro"] = "Senha ou CNPJ incorreto";
                header("Location: http://".$_SERVER["HTTP_HOST"]."/GerenciadorBoleto/index.php");
                exit;
            }
        } catch (Exception $e) {
            
        }
        break;

    case "logout":
        if ($usuario != null){
            session_destroy();
        }
        header("Location: http://".$_SERVER["HTTP_HOST"]."/GerenciadorBoleto/index.php");
        exit;
        break;
    default:
        header("Location: http://".$_SERVER["HTTP_HOST"]."/GerenciadorBoleto/index.php");
        exit;
}
