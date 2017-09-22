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
            $adminitrador->setNomeCliente(trim($_POST["nomeCliente"]));
            $adminitrador->setDocumento(trim($_POST["documento"]));
            $adminitrador->setEmail(trim($_POST["email"]));
            $adminitrador->getEndereco()->setBairro(trim($_POST["bairro"]));
            $adminitrador->getEndereco()->setCep(trim($_POST["cep"]));
            $adminitrador->getEndereco()->setRua(preg_replace("/[0-9|]|,|\.\d+/", "", trim($_POST["rua"])));
            $adminitrador->getEndereco()->setNumero(trim($_POST["numero"]));
            $adminitrador->getEndereco()->setComplemento(trim($_POST["complemento"]));
            $cidade = $eDao->buscaCidadeNome(trim($_POST["cidade"]), trim($_POST["uf"]));
            $cliente->getEndereco()->setCidade($cidade);
            if ($cDao->validaCampos($adminitrador)) {
                if ($cDao->editaAdministrador($Administrador)) {
                    $_SESSION["msg_retorno"] = "Dados atualizado com sucesso!";
                } else {
                    $_SESSION["msg_retorno"] = "Falha ao atualizar dados!";
                }
            } else {
                $_SESSION["msg_retorno"] = "Dados inválidos. Preencha todos os campos corretamente!";
                header("Location: http://" . $_SERVER["HTTP_HOST"] . "control/ClienteControl.php?action=carrega_editar&codigo=" . $cliente->getCodigoCliente());
            }
            header("Location: http://" . $_SERVER["HTTP_HOST"] . "/BoletoPHP/GerenciadorBoleto/clientes.php");
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