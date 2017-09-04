<?php

if (!defined("DS")) {
    define('DS', DIRECTORY_SEPARATOR);
}
if (!defined("BASE_DIR")) {
    define('BASE_DIR', dirname(dirname(__FILE__)) . DS);
}

require_once BASE_DIR . "dao" . DS . "DataBase.php";
require_once BASE_DIR . "dao" . DS . "UsuarioDAO.php";

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

                header("Location: http://" . $_SERVER["HTTP_HOST"] . "/BoletoPHP/GerenciadorBoleto/clientes.php");
                exit;
            } else {
                $_SESSION["erro"] = "Senha ou CNPJ incorreto";
                header("Location: http://" . $_SERVER["HTTP_HOST"] . "/BoletoPHP/GerenciadorBoleto/index.php");
                exit;
            }
        } catch (Exception $e) {
            
        }
        break;

    case "logout":
        session_destroy();
        header("Location: http://" . $_SERVER["HTTP_HOST"] . "/BoletoPHP/GerenciadorBoleto/index.php");
        exit;
        break;
    default:
        header("Location: http://" . $_SERVER["HTTP_HOST"] . "/BoletoPHP/GerenciadorBoleto/index.php");
        exit;
}
