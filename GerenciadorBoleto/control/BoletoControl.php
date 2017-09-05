<?php

if (!defined("DS")) {
    define('DS', DIRECTORY_SEPARATOR);
}
if (!defined("BASE_DIR")) {
    define('BASE_DIR', dirname(dirname(__FILE__)) . DS);
}

require_once BASE_DIR . "dao" . DS . "BoletoDAO.php";
require_once BASE_DIR . "model" . DS . "Boleto.php";

$db = new Database();
$pdo = $db->conexao();
session_start();
$action = $_GET["action"];
$bDao = new BoletoDAO();
$uDao = new UsuarioDAO();
$boleto = new Boleto();

switch ($action) {

    case "gerar":
        $boleto->setValor(trim($_POST["valor"]));
        $boleto->setNumeroDocumento(trim($_POST["numeroDocumento"]));
        $boleto->setDataVencimento(trim($_POST["dataVencimento"]));
        $boleto->setMulta(trim($_POST["multa"]));
        $boleto->setJuros(trim($_POST["juros"]));
        $boleto->setBanco($bDao->buscarBanco(trim($_POST["codigoBanco"])));
        $boleto->setUsuario($uDao->buscarUsuario(trim($_POST["codigoUsuario"])));
        $_SESSION["boleto"] = $boleto;
        header("Location: http://" . $_SERVER["HTTP_HOST"] . "/BoletoPHP/GerenciadorBoleto/boleto/boleto_sicredi.php");
        exit();
        break;
    
    case "atualizar":
        
        break;
    
    case "vizualizar":
        $codigo = $_GET["codigo"];
        $boleto = $bDao->buscarBoleto($codigo);
        $_SESSION["boleto"] = $boleto;
        header("Location: http://" . $_SERVER["HTTP_HOST"] . "/BoletoPHP/GerenciadorBoleto/boleto/boleto_sicredi.php");
        exit();
        break;
}