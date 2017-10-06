<?php

//Define cosntantes para caminhos de importações
if (!defined("DS")) {
    define('DS', DIRECTORY_SEPARATOR);
}
if (!defined("BASE_DIR")) {
    define('BASE_DIR', dirname(dirname(__FILE__)) . DS);
}
//Importa arquivos necessários
require_once BASE_DIR . "dao" . DS . "BoletoDAO.php";
require_once BASE_DIR . "model" . DS . "Boleto.php";
//Conecta ao DB
$db = new Database();
$pdo = $db->conexao();
session_start();
//Verifica se está logado
if (($_SESSION["usuario"]) == null) {
    header("Location: http://" . $_SERVER["HTTP_HOST"] . "/BoletoPHP/GerenciadorBoleto/index.php");
}
//Captura action e instância DAO's
$action = $_GET["action"];
$boletoDao = new BoletoDAO();
$clienteDao = new ClienteDAO();
$bancoDao = new BancoDAO();
$boleto = new Boleto();

switch ($action) {
    //Carrega o Número do Documento do Boleto Novo e retorna por JSON
    case "carregaNumDocumento":
        try {
            $obj = new \stdClass();
            $obj->num = $boletoDao->numDocumento($_GET["cod"]);
            $objJSON = json_encode($obj);
            echo $objJSON;
        } catch (Exception $e) {
            print "Codigo: " . $e->getCode() . ", Mensagem:" . $e->getMessage();
        }
        break;
    //Carrega dados para preenchimento de 2ª Via Boleto e retorna via JSON
    case "carrega2via":
        try {
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
        } catch (Exception $e) {
            print "Codigo: " . $e->getCode() . ", Mensagem:" . $e->getMessage();
        }
        break;
    //Realiza 2ª Via    
    case "gerar2Via":
        try {
            //Captura dados
            $vencimento = trim($_POST["dataVencimento"]);
            $dataVencimento = new DateTime($vencimento);
            $dataHoje = new DateTime(date("Y-m-d"));
            $validaData = $dataVencimento->diff($dataHoje);
            //Trata campos valor
            $valor = trim($_POST["valor"]);
            $valor = str_replace("R$", "", ($_POST["valor"]));
            $valor = str_replace(".", "", $valor);
            $valor = str_replace(",", ".", $valor);
            $codigo = $_GET["codigo"];
            $boleto = $boletoDao->buscarBoleto($codigo);
            //Verifica se boleto existe e se a data é valida
            if ($boleto != null && $validaData->invert == 0 && $valor > 0) {
                $boleto->setValor($valor);
                $boleto->setDataVencimento($vencimento);
                //Atualiza boleto
                $retorno = $boletoDao->atualizaBoleto($boleto);
            } else {
                $retorno = false;
            }
            //Caso sucesso encaminha para visualização do boleto
            if (retorno) {
                header("Location: http://" . $_SERVER["HTTP_HOST"] .
                        "/BoletoPHP/GerenciadorBoleto/control/BoletoControl.php?action=vizualizar&codigo=" . $boleto->getCodigoBoleto());
            } else {
                //Falha envia para tela principal  
                $_SESSION["msg_retorno"] = "Falha ao gerar 2ª via!";
                header("Location: http://" . $_SERVER["HTTP_HOST"] . "/BoletoPHP/GerenciadorBoleto/boletos.php");
            }
            exit();
        } catch (Exception $e) {
            print "Codigo: " . $e->getCode() . ", Mensagem:" . $e->getMessage();
        }
        break;
    //Gera 2ª Via do lado do cliente. Mesmos procedimentos, porém os dados de preenchimento são fixados.    
    case "gerar2ViaCliente":
        try {
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
        } catch (Exception $e) {
            print "Codigo: " . $e->getCode() . ", Mensagem:" . $e->getMessage();
        }
        break;
    //Gera Novo Boleto    
    case "gerar":
        try {
            //Captura e trata dados do formulário
            $valor = (str_replace("R$", "", ($_POST["valor"])));
            $valor = (str_replace(",", ".", $valor));
            $juros = (str_replace("R$", "", ($_POST["juros"])));
            $juros = (str_replace(",", ".", $juros));
            //Instância objeto boleto.
            $boleto->setValor($valor);
            $boleto->setNumeroDocumento(trim($_POST["numeroDocumento"]));
            $boleto->setNossoNumero($boletoDao->nossoNumero());
            $boleto->setDataVencimento(trim($_POST["dataVencimento"]));
            $boleto->setMulta(trim($_POST["multa"]));
            $boleto->setJuros($juros);
            $boleto->setBanco($bancoDao->buscarBanco(trim($_POST["codigoBanco"])));
            $boleto->setCliente($clienteDao->buscarCliente(trim($_POST["codigoCliente"])));
            $boleto->setDataEmissao(date("Y-m-d"));
            //Seta objeto boleto na SESSION
            $_SESSION["boleto"] = $boleto;
            //Valida campos boleto
            if ($boletoDao->validaCampos($boleto)) {
                //Salva boleto no DB
                $codigo = $boletoDao->inserirBoleto($boleto);
                //Verifica qual é o banco do boleto.
                if ($boleto->getBanco()->getCodigoBanco() == 748) {
                    //Gera boleto Sicredi
                    $_SESSION["msg_retorno"] = "Boleto gerado com sucesso!";
                    header("Location: http://" . $_SERVER["HTTP_HOST"] . "/BoletoPHP/GerenciadorBoleto/boleto/boleto_sicredi.php");
                } else if ($boleto->getBanco()->getCodigoBanco() == 502) {
                    //Gera boleto Santander
                    $_SESSION["msg_retorno"] = "Boleto gerado com sucesso!";
                    header("Location: http://" . $_SERVER["HTTP_HOST"] . "/BoletoPHP/GerenciadorBoleto/boleto/boleto_banespa.php");
                }
                exit();
                //Caso os campos estejam incorretos.    
            } else {
                $_SESSION["msg_retorno"] = "Falha ao gerar boleto!";
                header("Location: http://" . $_SERVER["HTTP_HOST"] . "/BoletoPHP/GerenciadorBoleto/novo_boleto.php");
                exit();
            }
            exit();
        } catch (Exception $e) {
            print "Codigo: " . $e->getCode() . ", Mensagem:" . $e->getMessage();
        }
        break;
    //Instância boleto a partir do DB e gera PDF.    
    case "vizualizar":
        try {
            $codigo = $_GET["codigo"];
            $boleto = $boletoDao->buscarBoleto($codigo);
            $valor = (str_replace("R$", "", ($boleto->getValor())));
            $valor = (str_replace(",", ".", $valor));
            $boleto->setValor($valor);
            $_SESSION["boleto"] = $boleto;
            if ($boleto->getBanco()->getCodigoBanco() == 748) {
                header("Location: http://" . $_SERVER["HTTP_HOST"] . "/BoletoPHP/GerenciadorBoleto/boleto/boleto_sicredi.php");
            } else if ($boleto->getBanco()->getCodigoBanco() == 502) {
                header("Location: http://" . $_SERVER["HTTP_HOST"] . "/BoletoPHP/GerenciadorBoleto/boleto/boleto_banespa.php");
            }

            exit();
        } catch (Exception $e) {
            print "Codigo: " . $e->getCode() . ", Mensagem:" . $e->getMessage();
        }
        break;
    //Envia boleto por e-mail    
    case "enviarEmail":
        try {
            $codigo = $_GET["cod"];
            $cliente = $clienteDao->buscarCliente($codigo);
            $_SESSION["email"] = $cliente->getEmail();
            $_SESSION["assunto"] = "Boleto - Gerenciador de Boletos Microvil";
            $_SESSION["mensagem"] = "Segue em anexo boleto";
            $_SESSION["redirecionamento"] = "/BoletoPHP/GerenciadorBoleto/boletos.php";
            $_SESSION["anexo"] = true;
            //Flag de redirecionamento
            $_SESSION["flag_header"] = false;
        } catch (Exception $e) {
            print "Codigo: " . $e->getCode() . ", Mensagem:" . $e->getMessage();
        }
        break;
    //Envia boleto por e-mail através do botão.    
    case "enviarEmailBotao":
        try {
            $codigoCliente = $_GET["codCliente"];
            $codigoBoleto = $_GET["codBoleto"];
            $boleto = $boletoDao->buscarBoleto($codigoCliente);
            $valor = (str_replace("R$", "", ($boleto->getValor())));
            $valor = (str_replace(",", ".", $valor));
            $boleto->setValor($valor);
            $_SESSION["boleto"] = $boleto;
            
            $cliente = $clienteDao->buscarCliente($codigoBoleto);
            $_SESSION["email"] = $cliente->getEmail();
            $_SESSION["assunto"] = "Boleto - Gerenciador de Boletos Microvil";
            $_SESSION["mensagem"] = "Segue em anexo boleto";
            $_SESSION["redirecionamento"] = "/BoletoPHP/GerenciadorBoleto/boletos.php";
            $_SESSION["anexo"] = true;
            $_SESSION["include"] = true;
            $_SESSION["flag_header"] = false;
        } catch (Exception $e) {
            print "Codigo: " . $e->getCode() . ", Mensagem:" . $e->getMessage();
        }
        break;
    //Finalizar ou dar baixa em boleto    
    case "baixarBoleto":
        try {
            $codigo = $_GET["codigo"];
            $boleto = $boletoDao->buscarBoleto($codigo);
            $retorno = $boletoDao->baixaBoleto($boleto);
            if ($retorno) {
                $_SESSION["msg_retorno"] = "Boleto baixado com sucesso!";
            } else
                $_SESSION["msg_retorno"] = "Falha ao baixar boleto!";
            header("Location: http://" . $_SERVER["HTTP_HOST"] . "/BoletoPHP/GerenciadorBoleto/boletos.php");
            exit();
        } catch (Exception $e) {
            print "Codigo: " . $e->getCode() . ", Mensagem:" . $e->getMessage();
        }
        break;

    default:
        break;
}