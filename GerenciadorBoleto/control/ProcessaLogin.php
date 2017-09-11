<?php

if (!defined("DS")) {
    define('DS', DIRECTORY_SEPARATOR);
}
if (!defined("BASE_DIR")) {
    define('BASE_DIR', dirname(dirname(__FILE__)) . DS);
}

require_once BASE_DIR . "dao" . DS . "DataBase.php";
require_once BASE_DIR . "dao" . DS . "ClienteDAO.php";

$db = new Database();
$pdo = $db->conexao();
session_start();
$action = $_GET["action"];

switch ($action) {
    case "login":
        try {
            $documento = trim($_POST['documento']);
            $senha = trim($_POST['senha']);
            $clienteDAO = new ClienteDAO();
            $cliente = $clienteDAO->autenticaCliente($documento, $senha);

            if ($cliente->getCodigoCliente() != null) {
                $_SESSION["cliente"] = $cliente;

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
