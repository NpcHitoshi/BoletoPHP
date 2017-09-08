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

    case "carregaNumDocumento":
        $obj = new \stdClass();
        $obj->num = $bDao->numDocumento($_GET["cod"]);
        $objJSON = json_encode($obj);
        echo $objJSON;
        break;


    case "gerar":
        //var_dump(preg_replace('/[R\$|.|]/', '', $_POST["valor"]));
        $valor = (str_replace("R$", "", ($_POST["valor"])));
        $valor = (str_replace(",", ".", $valor));
        $boleto->setValor($valor);
        $boleto->setNumeroDocumento(trim($_POST["numeroDocumento"]));
        $boleto->setNossoNumero($bDao->nossoNumero());
        $boleto->setDataVencimento(trim($_POST["dataVencimento"]));
        $boleto->setMulta(trim($_POST["multa"]));
        $boleto->setBanco($bDao->buscarBanco(trim($_POST["codigoBanco"])));
        $boleto->setUsuario($uDao->buscarUsuario(trim($_POST["codigoUsuario"])));
        $boleto->setDataEmissao(date("Y-m-d"));
        $_SESSION["boleto"] = $boleto;
        $bDao->inserirBoleto($boleto);
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