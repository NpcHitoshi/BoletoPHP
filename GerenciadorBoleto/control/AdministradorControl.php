<?php

if (!defined("DS")) {
    define('DS', DIRECTORY_SEPARATOR);
}
if (!defined("BASE_DIR")) {
    define('BASE_DIR', dirname(dirname(__FILE__)) . DS);
}

require_once BASE_DIR . "model" . DS . "DadosBancario.php";
require_once BASE_DIR . "dao" . DS . "AdministradorDao.php";
require_once BASE_DIR . "dao" . DS . "DataBase.php";


$db = new Database();
$pdo = $db->conexao();
session_start();
if (($_SESSION["usuario"]) == null) {
    header("Location: http://" . $_SERVER["HTTP_HOST"] . "/BoletoPHP/GerenciadorBoleto/index.php");
}
$action = $_GET["action"];
$administradorDao = new AdministradorDAO();
$administrador = $_SESSION["usuario"];

switch ($action) {

    case "editarDados":
        try {
            $eDao = new EnderecoDao();
            $administrador->setNomeAdministrador(mb_strtoupper(trim($_POST["nomeAdministrador"])));
            $administrador->setDocumento(trim($_POST["documento"]));
            $administrador->setEmail(mb_strtoupper(trim($_POST["email"])));
            $administrador->getEndereco()->setBairro(mb_strtoupper(trim($_POST["bairro"])));
            $administrador->getEndereco()->setCep(trim($_POST["cep"]));
            $administrador->getEndereco()->setRua(preg_replace("/[0-9|]|,|\.\d+/", "", mb_strtoupper(trim($_POST["rua"]))));
            $administrador->getEndereco()->setNumero(trim($_POST["numero"]));
            $administrador->getEndereco()->setComplemento(mb_strtoupper(trim($_POST["complemento"])));
            $cidade = $eDao->buscaCidadeNome(mb_strtoupper(trim($_POST["cidade"])), mb_strtoupper(trim($_POST["uf"])));
            $administrador->getEndereco()->setCidade($cidade);
            if ($administradorDao->validaCampos($administrador)) {
                if ($administradorDao->editaAdministrador($administrador)) {
                    $_SESSION["msg_retorno"] = "Dados atualizado com sucesso!";
                } else {
                    $_SESSION["msg_retorno"] = "Falha ao atualizar dados!";
                }
            } else {
                $_SESSION["msg_retorno"] = "Dados inválidos. Preencha todos os campos corretamente!";
                header("Location: http://" . $_SERVER["HTTP_HOST"] . "/BoletoPHP/GerenciadorBoleto/configuracoes.php");
            }
            header("Location: http://" . $_SERVER["HTTP_HOST"] . "/BoletoPHP/GerenciadorBoleto/configuracoes.php");
            exit();
        } catch (Exception $e) {
            print "Codigo: " . $e->getCode() . ", Mensagem:" . $e->getMessage();
        }
        break;

    case "editarSenha":
        try {
            var_dump($administrador);
            if (password_verify($_POST["senhaAtual"], $administrador->getSenha())) {
                $novaSenha = $_POST["novaSenha"];
                $confirmaSenha = $_POST["confirmaSenha"];
                if ($novaSenha == $confirmaSenha) {
                    $administrador->setSenha($novaSenha);
                    $administradorDao->editaSenha($administrador);
                    $_SESSION["msg_retorno"] = "Senha atualizada com sucesso!";
                    header("Location: http://" . $_SERVER["HTTP_HOST"] . "/BoletoPHP/GerenciadorBoleto/configuracoes.php");
                } else {
                    $_SESSION["msg_retorno"] = "Confirmação de senha errada!";
                    header("Location: http://" . $_SERVER["HTTP_HOST"] . "/BoletoPHP/GerenciadorBoleto/configuracoes.php");
                }
            } else {
                $_SESSION["msg_retorno"] = "Senha atual incorreta!";
                header("Location: http://" . $_SERVER["HTTP_HOST"] . "/BoletoPHP/GerenciadorBoleto/configuracoes.php");
                exit();
            }
        } catch (Exception $e) {
            print "Codigo: " . $e->getCode() . ", Mensagem:" . $e->getMessage();
        }
        break;

    case "editarDadosBancario":
        try {
            $dadosBancario = new DadosBancario();
            $dadosBancario->setBanco($_POST["codigoBanco"]);
            $dadosBancario->setAgencia(trim($_POST["agencia"]));
            $dadosBancario->setContaCorrente(trim($_POST["contaCorrente"]));
            $dadosBancario->setDigitoVerificador($_POST["digitoVerificador"]);
            $dadosBancario->setJurosPadrao($_POST["jurosPadrao"]);
            $dadosBancario->setMultaPadrao($_POST["multaPadrao"]);
            if ($administradorDao->validaCamposDadosBancario($dadosBancario)) {
                if ($administradorDao->editaDadosBancarios($dadosBancario)) {
                    $_SESSION["msg_retorno"] = "Dados atualizado com sucesso!";
                } else {
                    $_SESSION["msg_retorno"] = "Falha ao atualizar dados!";
                }
            } else {
                $_SESSION["msg_retorno"] = "Dados inválidos. Preencha todos os campos corretamente!";
                header("Location: http://" . $_SERVER["HTTP_HOST"] . "/BoletoPHP/GerenciadorBoleto/configuracoes.php");
            }
            header("Location: http://" . $_SERVER["HTTP_HOST"] . "/BoletoPHP/GerenciadorBoleto/configuracoes.php");
            exit();
        } catch (Exception $e) {
            print "Codigo: " . $e->getCode() . ", Mensagem:" . $e->getMessage();
        }
        break;

    case "carregaDadosBanco":
        try {
            $obj = new \tdClass();
            $obj = $boletoDao->carregaDadosDocumento($_GET["cod"]);
            $objJSON = json_encode($obj);
            echo $objJSON;
        } catch (Exception $e) {
            print "Codigo: " . $e->getCode() . ", Mensagem:" . $e->getMessage();
        }

    default:
        break;
}
