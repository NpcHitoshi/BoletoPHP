<?php

if (!defined("DS")) {
    define('DS', DIRECTORY_SEPARATOR);
}
if (!defined("BASE_DIR")) {
    define('BASE_DIR', dirname(dirname(__FILE__)) . DS);
}

require_once BASE_DIR . "dao" . DS . "DataBase.php";
require_once BASE_DIR . "dao" . DS . "UsuarioDao.php";

$db = new Database();
$pdo = $db->conexao();
session_start();
$action = $_GET["action"];
$uDao = new UsuarioDAO();
$usuario = new Usuario();

switch ($action) {
    case "inserir":
        try {
            $usuario->setRazaoSocial(trim($_POST["razao_social"]));
            $usuario->setCnpj(trim($_POST["cnpj"]));
            $usuario->setEmail(trim($_POST["email"]));
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
            $usuario->setEndereco($e);
            if ($uDao->validaCampos($usuario)) {
                $uDao->inserirUsuario($usuario);
                header("Location: http://" . $_SERVER["HTTP_HOST"] . "/BoletoPHP/GerenciadorBoleto/clientes.php");
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
            $usuario = $uDao->buscarUsuario($codigo);
            $_SESSION["usuarioCliente"] = $usuario;
            header("Location: http://" . $_SERVER["HTTP_HOST"] . "/BoletoPHP/GerenciadorBoleto/editar_cliente.php");
            exit();
        } catch (Exception $e) {
            print "Codigo: " . $e->getCode() . ", Mensagem:" . $e->getMessage();
        }
        break;

    case "editar":
        try {
            $usuario = $_SESSION["usuarioCliente"];

            $usuario->setRazaoSocial(trim($_POST["razao_social"]));
            $usuario->setEmail(trim($_POST["email"]));
            $usuario->getEndereco()->setBairro(trim($_POST["bairro"]));
            $usuario->getEndereco()->setCep(trim($_POST["cep"]));
            $usuario->getEndereco()->setRua(trim($_POST["rua"]));
            $usuario->getEndereco()->setNumero(trim($_POST["numero"]));
            $usuario->getEndereco()->setComplemento(trim($_POST["complemento"]));
            $usuario->getEndereco()->getCidade()->setNomeCidade(trim($_POST["cidade"]));
            $usuario->getEndereco()->getCidade()->getEstado()->setUf(trim($_POST["uf"]));
            $uDao->editaUsuario($usuario);
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
            $uDao->desativarUsuario($codigo);
            header("Location: http://" . $_SERVER["HTTP_HOST"] . "/BoletoPHP/GerenciadorBoleto/clientes.php");
            exit();
        } catch (Exception $e) {
            print "Codigo: " . $e->getCode() . ", Mensagem:" . $e->getMessage();
        }
        break;

    case "ativar":
        try {
            $codigo = $_GET["codigo"];
            $uDao->ativarUsuario($codigo);
            header("Location: http://" . $_SERVER["HTTP_HOST"] . "/BoletoPHP/GerenciadorBoleto/clientes.php");
            exit();
        } catch (Exception $e) {
            print "Codigo: " . $e->getCode() . ", Mensagem:" . $e->getMessage();
        }
        break;

    default:
        break;
}
