<?php

if (!defined("DS")) {
    define('DS', DIRECTORY_SEPARATOR);
}
if (!defined("BASE_DIR")) {
    define('BASE_DIR', dirname(dirname(__FILE__)) . DS);
}

require_once BASE_DIR . "dao" . DS . "Database.php";
require_once BASE_DIR . "dao" . DS . "ClienteDAO.php";
require_once BASE_DIR . "dao" . DS . "AdministradorDAO.php";

$db = new Database();
$pdo = $db->conexao();
session_start();
$action = $_GET["action"];

switch ($action) {
    case "login":
        try {
            $email = trim($_POST['email']);
            $senha = trim($_POST['senha']);
            $clienteDAO = new ClienteDAO();
            $cliente = $clienteDAO->autenticaCliente($email, $senha);
            
            if ($cliente->getCodigoCliente() == null) {
                $administradorDAO = new AdministradorDAO();
                $administrador = $administradorDAO->autenticaAdministrador($email, $senha);
            }
            if ($cliente->getCodigoCliente() != null) {
                $_SESSION["usuario"] = $cliente;
                header("Location: http://" . $_SERVER["HTTP_HOST"] . "/BoletoPHP/GerenciadorBoleto/meu_boletos.php");
                exit;
            }
            if ($administrador->getCodigoAdministrador() != null) {
                $_SESSION["usuario"] = $administrador;
                header("Location: http://" . $_SERVER["HTTP_HOST"] . "/BoletoPHP/GerenciadorBoleto/clientes.php");
                exit;
            } else {
                $_SESSION["erro"] = "Senha ou Nº de Documento Incorreto";
                header("Location: http://" . $_SERVER["HTTP_HOST"] . "/BoletoPHP/GerenciadorBoleto/index.php");
                exit;
            }
        } catch (Exception $e) {
            print "Codigo: " . $e->getCode() . ", Mensagem:" . $e->getMessage();
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
