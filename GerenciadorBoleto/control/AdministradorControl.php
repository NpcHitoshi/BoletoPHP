<?php

if (!defined("DS")) {
    define('DS', DIRECTORY_SEPARATOR);
}
if (!defined("BASE_DIR")) {
    define('BASE_DIR', dirname(dirname(__FILE__)) . DS);
}

require_once BASE_DIR . "model" . DS . "DadosBancario.php";
require_once BASE_DIR . "dao" . DS . "AdministradorDAO.php";
require_once BASE_DIR . "dao" . DS . "Database.php";

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
            $documento = preg_replace("/(\/|-|\.)/", "", trim($_POST["documento"]));
            $administrador->setDocumento($documento);
            $administrador->setEmail(mb_strtoupper(trim($_POST["email"])));
            $administrador->getEndereco()->setBairro(mb_strtoupper(trim($_POST["bairro"])));
            $cep = preg_replace("/(\/|-|\.)/", "", trim($_POST["cep"]));
            $administrador->getEndereco()->setCep($cep);
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
            $dadosBancario->setCodigoCedente(trim($_POST["codigoCedente"]));
            $dadosBancario->setAgencia(trim($_POST["agencia"]));
            $dadosBancario->setContaCorrente(trim($_POST["contaCorrente"]));
            $dadosBancario->setDigitoVerificador($_POST["digitoVerificador"]);
            $juros = (str_replace("R$", "", ($_POST["jurosPadrao"])));
            $juros = (str_replace(",", ".", $juros));
            $dadosBancario->setJurosPadrao($juros);
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
            $dados = $administradorDao->carregaDadosDocumento($_GET["cod"]);;
            $juros = "R$".number_format($dados['jurosPadrao'], 2, ",", ".");
            $dados['jurosPadrao']= $juros;
            $objJSON = json_encode($dados);
            echo $objJSON;
        } catch (Exception $e) {
            print "Codigo: " . $e->getCode() . ", Mensagem:" . $e->getMessage();
        }

    default:
        break;
}
