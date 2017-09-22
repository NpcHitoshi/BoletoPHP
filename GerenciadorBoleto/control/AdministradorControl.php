<?php

if (!defined("DS")) {
    define('DS', DIRECTORY_SEPARATOR);
}
if (!defined("BASE_DIR")) {
    define('BASE_DIR', dirname(dirname(__FILE__)) . DS);
}

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
            $administrador->setNomeAdministrador(trim($_POST["nomeAdministrador"]));
            $administrador->setDocumento(trim($_POST["documento"]));
            $administrador->setEmail(trim($_POST["email"]));
            $administrador->getEndereco()->setBairro(trim($_POST["bairro"]));
            $administrador->getEndereco()->setCep(trim($_POST["cep"]));
            $administrador->getEndereco()->setRua(preg_replace("/[0-9|]|,|\.\d+/", "", trim($_POST["rua"])));
            $administrador->getEndereco()->setNumero(trim($_POST["numero"]));
            $administrador->getEndereco()->setComplemento(trim($_POST["complemento"]));
            $cidade = $eDao->buscaCidadeNome(trim($_POST["cidade"]), trim($_POST["uf"]));
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
}