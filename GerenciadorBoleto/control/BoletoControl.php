<?php

require_once BASE_DIR . "dao" . DS . "BoletoDao.php";

$db = new Database();
$pdo = $db->conexao();
session_start();
$action = $_GET["action"];
$bDao = new BoletoDAO();
$uDao = new UsuarioDAO();
$boleto = new Boleto();

switch ($action) {

    case "inserir":
        $boleto->setValor(trim($_POST["valor"]));
        $boleto->setNumeroDocumento(trim($_POST["numeroDocumento"]));
        $boleto->setDataVencimento(trim($_POST["dataVencimento"]));
        $boleto->setJuros(trim($_POST["juros"]));
        $boleto->setMulta(trim($_POST["multa"]));
        $boleto->setBanco($bDao->buscarBanco(trim($_POST["codigoBanco"])));
        $boleto->setUsuario($uDao->buscarUsuario(trim($_POST["codigoUsuario"])));
        $_SESSION["boleto"] = $boleto;
        break;
}