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
$boletoDao = new BoletoDAO();
$clienteDao = new ClienteDAO();
$bancoDao = new BancoDAO();
$boleto = new Boleto();

switch ($action) {

    case "carregaNumDocumento":
        $obj = new \stdClass();
        $obj->num = $boletoDao->numDocumento($_GET["cod"]);
        $objJSON = json_encode($obj);
        echo $objJSON;
        break;

    case "carregaAtualizar":
        $obj = new\stdClass();
        $dataVencimento = new DateTime($boleto->getDataVencimento());
        $dataHoje = new DateTime(date("Y-m-d"));
        $diasCorridos = $dataVencimento->diff($dataHoje);
        $obj->valor = number_format(((($boleto->getValor() * $boleto->getMulta()) / 1000) * $diasCorridos), 2, ",", ".");
        $obj->dataAtual = date("d-m-Y");
        $objJSON = json_encode($obj);
        echo $objJSON;
        break;

    case "gerar":
        //var_dump(preg_replace('/[R\$|.|]/', '', $_POST["valor"]));
        $valor = (str_replace("R$", "", ($_POST["valor"])));
        $valor = (str_replace(",", ".", $valor));
        $boleto->setValor($valor);
        $boleto->setNumeroDocumento(trim($_POST["numeroDocumento"]));
        $boleto->setNossoNumero($boletoDao->nossoNumero());
        $boleto->setDataVencimento(trim($_POST["dataVencimento"]));
        $boleto->setMulta(trim($_POST["multa"]));
        $boleto->setBanco($bancoDao->buscarBanco(trim($_POST["codigoBanco"])));
        $boleto->setCliente($clienteDao->buscarCliente(trim($_POST["codigoCliente"])));
        $boleto->setDataEmissao(date("Y-m-d"));
        $_SESSION["boleto"] = $boleto;
        $boletoDao->inserirBoleto($boleto);
        header("Location: http://" . $_SERVER["HTTP_HOST"] . "/BoletoPHP/GerenciadorBoleto/boleto/boleto_sicredi.php");
        exit();
        break;

    case "atualizar":
        $valor = (str_replace("R$", "", ($_POST["valor"])));
        $valor = (str_replace(",", ".", $valor));
        $boleto->setValor($valor);
        $boleto->setDataVencimento(trim($_POST["dataVencimento"]));
        $_SESSION["boleto"] = $boleto;
        $boletoDao->atualizaBoleto($boleto);
        header("Location: http://" . $_SERVER["HTTP_HOST"] . "/BoletoPHP/GerenciadorBoleto/boleto/boleto_sicredi.php");
        exit();
        break;

    case "vizualizar":
        $codigo = $_GET["codigo"];
        $boleto = $boletoDao->buscarBoleto($codigo);
        $boleto->setValor(number_format($boleto->getValor(), 2, ",", "."));
        $_SESSION["boleto"] = $boleto;
        header("Location: http://" . $_SERVER["HTTP_HOST"] . "/BoletoPHP/GerenciadorBoleto/boleto/boleto_sicredi.php");
        exit();
        break;

    default:
        break;
}