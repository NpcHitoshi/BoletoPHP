<?php

if (!defined("DS")) {
    define('DS', DIRECTORY_SEPARATOR);
}
if (!defined("BASE_DIR")) {
    define('BASE_DIR', dirname(dirname(__FILE__)) . DS);
}

require_once BASE_DIR . "dao" . DS . "DataBase.php";
require_once BASE_DIR . "dao" . DS . "ClienteDao.php";

$db = new Database();
$pdo = $db->conexao();
session_start();
$action = $_GET["action"];
$cDao = new ClienteDAO();
$cliente = new Cliente();

switch ($action) {
    case "inserir":
        try {
            $cliente->setNomeCliente(trim($_POST["nomeCliente"]));
            $cliente->setDocumento(trim($_POST["documento"]));
            $cliente->setEmail(trim($_POST["email"]));
            $e = new Endereco();
            $eDao = new EnderecoDao();
            $e->setBairro(trim($_POST["bairro"]));
            $e->setCep(trim($_POST["cep"]));

            $c = new Cidade();
            $c->setNomeCidade(trim($_POST["cidade"]));
            $c = $eDao->buscaCidadeNome($c->getNomeCidade());

            $e->setCidade($c);
            $e->setComplemento(trim($_POST["complemento"]));
            $e->setNumero(trim($_POST["numero"]));
            $e->setRua(trim($_POST["rua"]));
            $cliente->setEndereco($e);
            if ($cDao->validaCampos($cliente)) {
                $cDao->inserirCliente($cliente);
                header("Location: http://" . $_SERVER["HTTP_HOST"] . "/BoletoPHP/GerenciadorBoleto/control/ClienteControl"
                        . "?action=emailCadastro&cod=".$cliente->getCodigoCliente());
                exit();
            } else {
                header("Location: http://" . $_SERVER["HTTP_HOST"] . "/BoletoPHP/GerenciadorBoleto/novo_cliente.php");
                exit();
            }
        } catch (Exception $e) {
            print "Codigo: " . $e->getCode() . ", Mensagem:" . $e->getMessage();
        }
        break;

    case "carrega_editar":
        try {
            $codigo = $_GET["codigo"];
            $cliente = $cDao->buscarCliente($codigo);
            $_SESSION["usuarioCliente"] = $cliente;
            header("Location: http://" . $_SERVER["HTTP_HOST"] . "/BoletoPHP/GerenciadorBoleto/editar_cliente.php");
            exit();
        } catch (Exception $e) {
            print "Codigo: " . $e->getCode() . ", Mensagem:" . $e->getMessage();
        }
        break;

    case "editar":
        try {
            $cliente = $_SESSION["usuarioCliente"];

            $cliente->setNomeCliente(trim($_POST["nomeCliente"]));
            $cliente->setEmail(trim($_POST["email"]));
            $cliente->getEndereco()->setBairro(trim($_POST["bairro"]));
            $cliente->getEndereco()->setCep(trim($_POST["cep"]));
            $cliente->getEndereco()->setRua(trim($_POST["rua"]));
            $cliente->getEndereco()->setNumero(trim($_POST["numero"]));
            $cliente->getEndereco()->setComplemento(trim($_POST["complemento"]));
            $cliente->getEndereco()->getCidade()->setNomeCidade(trim($_POST["cidade"]));
            $cliente->getEndereco()->getCidade()->getEstado()->setUf(trim($_POST["uf"]));
            $cDao->editaCliente($cliente);
            unset($_SESSION["usuarioCliente"]);
            header("Location: http://" . $_SERVER["HTTP_HOST"] . "/BoletoPHP/GerenciadorBoleto/clientes.php");
            exit();
        } catch (Exception $e) {
            print "Codigo: " . $e->getCode() . ", Mensagem:" . $e->getMessage();
        }
        break;

    case "desativar":
        try {
            $codigo = $_GET["codigo"];
            $cDao->desativarCliente($codigo);
            header("Location: http://" . $_SERVER["HTTP_HOST"] . "/BoletoPHP/GerenciadorBoleto/clientes.php");
            exit();
        } catch (Exception $e) {
            print "Codigo: " . $e->getCode() . ", Mensagem:" . $e->getMessage();
        }
        break;

    case "ativar":
        try {
            $codigo = $_GET["codigo"];
            $cDao->ativarCliente($codigo);
            header("Location: http://" . $_SERVER["HTTP_HOST"] . "/BoletoPHP/GerenciadorBoleto/clientes.php");
            exit();
        } catch (Exception $e) {
            print "Codigo: " . $e->getCode() . ", Mensagem:" . $e->getMessage();
        }
        break;

    case "emailCadastro":
        try {
            $codigo = $_GET["cod"];
            $cliente = $cDao->buscarCliente($codigo);
            $_SESSION["email"] = $cliente->getEmail();
            $_SESSION["assunto"] = "Cadastro Microvil";
            $_SESSION["mensagem"] = "Seu cadastro foi realizado através do nosso sistema de boleto, sua senha é: " .
                    $cliente->getDocumento();
            $_SESSION["redirecionamento"] = "/BoletoPHP/GerenciadorBoleto/clientes.php";
            header("Location: http://" . $_SERVER["HTTP_HOST"] . "/BoletoPHP/GerenciadorBoleto/email.php");
            exit();
        } catch (Exception $e) {
            print "Codigo: " . $e->getCode() . ", Mensagem:" . $e->getMessage();
        }
        break;
    default:
        break;
}
