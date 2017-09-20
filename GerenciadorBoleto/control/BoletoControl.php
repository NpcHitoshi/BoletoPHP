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

    case "carrega2via":
        $obj = new \stdClass();
        $boleto = $boletoDao->buscarBoleto($_GET["cod"]);
        $dataVencimento = new DateTime($boleto->getDataVencimento());
        $dataHoje = new DateTime(date("Y-m-d"));
        $diasCorridos = $dataVencimento->diff($dataHoje);
        $diasCorridos->days;
        if ($diasCorridos->invert == 0 && $diasCorridos->days > 0) {
            $obj->valor = $boleto->getValor() + (($boleto->getValor() * ($boleto->getMulta() / 100))) +
                    ($boleto->getJuros() * $diasCorridos->days);
        } else {
            $obj->valor = $boleto->getValor();
        }
        $obj->valor = number_format($obj->valor, 2, ",", ".");
        $obj->data = date("d-m-Y");
        $objSON = json_encode($obj);
        echo $objSON;
        break;

    case "gerar2Via":
        $vencimento = trim($_POST["dataVencimento"]);
        $dataVencimento = new DateTime($vencimento);
        $dataHoje = new DateTime(date("Y-m-d"));
        $validaData = $dataVencimento->diff($dataHoje);
        $valor = trim($_POST["valor"]);
        $valor = str_replace("R$", "", ($_POST["valor"]));
        $valor = str_replace(".", "", $valor);
        $valor = str_replace(",", ".", $valor);
        $codigo = $_GET["codigo"];
        $boleto = $boletoDao->buscarBoleto($codigo);
        if ($boleto != null && $validaData->invert == 0 && $valor > 0) {
            $boleto->setValor($valor);
            $boleto->setDataVencimento($vencimento);
            $retorno = $boletoDao->atualizaBoleto($boleto);
        } else {
            $retorno = false;
        }
        if (retorno) {
            header("Location: http://" . $_SERVER["HTTP_HOST"] . "/BoletoPHP/GerenciadorBoleto/control/BoletoControl.php?action=vizualizar&codigo=" . $boleto->getCodigoBoleto());
        } else {
            $_SESSION["msg_retorno"] = "Falha ao gerar 2ª via!";
            header("Location: http://" . $_SERVER["HTTP_HOST"] . "/BoletoPHP/GerenciadorBoleto/boletos.php");
        }
        exit();
        break;

    case "gerar2ViaCliente":
        $boleto = $boletoDao->buscarBoleto($_GET["codigo"]);
        $dataVencimento = new DateTime($boleto->getDataVencimento());
        $dataHoje = new DateTime(date("Y-m-d"));
        $validaData = $dataVencimento->diff($dataHoje);
        $diasCorridos = $dataVencimento->diff($dataHoje);
        $diasCorridos->days;
        
        if ($diasCorridos->invert == 0 && $diasCorridos->days > 0) {
            $boleto->setValor($boleto->getValor()) + (($boleto->getValor() * ($boleto->getMulta() / 100))) +
                    ($boleto->getJuros() * $diasCorridos->days);
        } else {
            $boleto->setValor($boleto->getValor());
        }

        $valor = str_replace("R$", "", $boleto->getValor());
        $valor = str_replace(".", "", $valor);
        $valor = str_replace(",", ".", $valor);
        if ($boleto != null && $validaData->invert == 0 && $valor > 0) {
            $boleto->setValor($valor);
            $boleto->setDataVencimento(date("Y-m-d"));
            $retorno = $boletoDao->atualizaBoleto($boleto);
        } else {
            $retorno = false;
        }
        if (retorno) {
            header("Location: http://" . $_SERVER["HTTP_HOST"] . "/BoletoPHP/GerenciadorBoleto/control/BoletoControl.php?action=vizualizar&codigo=" . $boleto->getCodigoBoleto());
        } else {
            $_SESSION["msg_retorno"] = "Falha ao gerar 2ª via!";
            header("Location: http://" . $_SERVER["HTTP_HOST"] . "/BoletoPHP/GerenciadorBoleto/boletos.php");
        }
        exit();
        break;
        
    case "gerar":
        $valor = (str_replace("R$", "", ($_POST["valor"])));
        $valor = (str_replace(",", ".", $valor));
        $juros = (str_replace("R$", "", ($_POST["juros"])));
        $juros = (str_replace(",", ".", $juros));
        $boleto->setValor($valor);
        $boleto->setNumeroDocumento(trim($_POST["numeroDocumento"]));
        $boleto->setNossoNumero($boletoDao->nossoNumero());
        $boleto->setDataVencimento(trim($_POST["dataVencimento"]));
        $boleto->setMulta(trim($_POST["multa"]));
        $boleto->setJuros($juros);
        $boleto->setBanco($bancoDao->buscarBanco(trim($_POST["codigoBanco"])));
        $boleto->setCliente($clienteDao->buscarCliente(trim($_POST["codigoCliente"])));
        $boleto->setDataEmissao(date("Y-m-d"));
        $_SESSION["boleto"] = $boleto;
        if ($boletoDao->validaCampos($boleto)) {
            $codigo = $boletoDao->inserirBoleto($boleto);
            header("Location: http://" . $_SERVER["HTTP_HOST"] . "/BoletoPHP/GerenciadorBoleto/boleto/boleto_sicredi.php");
            exit();
        } else {
            header("Location: http://" . $_SERVER["HTTP_HOST"] . "/BoletoPHP/GerenciadorBoleto/novo_boleto.php");
            exit();
        }
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

    case "enviarEmail":
        try {
            $codigo = $_GET["cod"];
            $cliente = $clienteDao->buscarCliente($codigo);
            $_SESSION["email"] = $cliente->getEmail();
            $_SESSION["assunto"] = "Boleto - Gerenciador de Boletos Microvil";
            $_SESSION["mensagem"] = "Segue em anexo boleto";
            $_SESSION["redirecionamento"] = "/BoletoPHP/GerenciadorBoleto/boletos.php";
            $_SESSION["anexo"] = true;
            $_SESSION["flag_header"] = false;
        } catch (Exception $e) {
            print "Codigo: " . $e->getCode() . ", Mensagem:" . $e->getMessage();
        }
        break;

    case "enviarEmailBotao":
        try {
            $codigo = $_GET["codigo"];
            $cliente = $clienteDao->buscarCliente($codigo);
            $_SESSION["email"] = $cliente->getEmail();
            $_SESSION["assunto"] = "Boleto - Gerenciador de Boletos Microvil";
            $_SESSION["mensagem"] = "Segue em anexo boleto";
            $_SESSION["redirecionamento"] = "/BoletoPHP/GerenciadorBoleto/boletos.php";
            $_SESSION["anexo"] = true;
            $_SESSION["flag_header"] = false;
        } catch (Exception $e) {
            print "Codigo: " . $e->getCode() . ", Mensagem:" . $e->getMessage();
        }
        break;

    case "baixarBoleto":
        try{
            $codigo = $_GET["codigo"];
            $boleto = $boletoDao->buscarBoleto($codigo);
            $retorno = $boletoDao->baixaBoleto($boleto);
            if($retorno){
                $_SESSION["msg_retorno"] = "Boleto baixado com sucesso!";
            }
            else
                $_SESSION["msg_retorno"] = "Falha oa baixar boleto!";
            header("Location: http://" . $_SERVER["HTTP_HOST"] . "/BoletoPHP/GerenciadorBoleto/boletos.php");
            exit();
        } catch (Exception $e){
            print "Codigo: " . $e->getCode() . ", Mensagem:" . $e->getMessage();
        }
        break;

    default:
        break;
}