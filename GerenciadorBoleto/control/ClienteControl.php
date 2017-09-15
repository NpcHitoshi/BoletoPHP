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
            $c = $eDao->buscaCidadeNome($c->getNomeCidade(), $_POST["uf"]);

            $e->setCidade($c);
            $e->setComplemento(trim($_POST["complemento"]));
            $e->setNumero(trim($_POST["numero"]));
            $e->setRua(preg_replace("/[0-9|]|,|\.\d+/", "", trim($_POST["rua"])));
            $cliente->setEndereco($e);
            var_dump($cliente);
            if ($cDao->validaCampos($cliente)) {
                $codigo = $cDao->inserirCliente($cliente);
                if($codigo != null){
                    $cliente->setCodigoCliente($codigo);
                    $_SESSION["msg_retorno"] = "Cliente gravado com sucesso!";
                    header("Location: http://" . $_SERVER["HTTP_HOST"] . "/BoletoPHP/GerenciadorBoleto/control/ClienteControl.php"
                            . "?action=emailCadastro&cod=" . $cliente->getCodigoCliente());
                    exit();
                }
                else{
                    $_SESSION["msg_retorno"] = "Falha ao gravar cliente!";
                    header("Location: http://" . $_SERVER["HTTP_HOST"] . "/BoletoPHP/GerenciadorBoleto/clientes.php");
                    exit();
                }
            } else {
                $_SESSION["msg_retorno"] = "Dados incorretos! Preencha todos os campos corretamente.";
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
            $eDao = new EnderecoDao();
            $cliente = $_SESSION["usuarioCliente"];
            $cliente->setNomeCliente(trim($_POST["nomeCliente"]));
            $cliente->setEmail(trim($_POST["email"]));
            $cliente->getEndereco()->setBairro(trim($_POST["bairro"]));
            $cliente->getEndereco()->setCep(trim($_POST["cep"]));
            $cliente->getEndereco()->setRua(preg_replace("/[0-9|]|,|\.\d+/", "", trim($_POST["rua"])));
            $cliente->getEndereco()->setNumero(trim($_POST["numero"]));
            $cliente->getEndereco()->setComplemento(trim($_POST["complemento"]));
            $cidade = $eDao->buscaCidadeNome(trim($_POST["cidade"]), trim($_POST["uf"]));
            $cliente->getEndereco()->setCidade($cidade);
            if ($cDao->validaCamposEditar($cliente)) {
                if($cDao->editaCliente($cliente))
                    $_SESSION["msg_retorno"] = "Cliente atualizado com sucesso!";
                else
                    $_SESSION["msg_retorno"] = "Falha ao atualizar cliente!";
            }
            else{
                    $_SESSION["msg_retorno"] = "Dados inválidos. Preencha todos os campos corretamente!";
                    header("Location: http://" . $_SERVER["HTTP_HOST"] . "control/ClienteControl.php?action=carrega_editar&codigo=" . $cliente->getCodigoCliente());
            }
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
            $_SESSION["assunto"] = "Novo Cadastro - Gerenciador de Boletos Microvil";
            $_SESSION["mensagem"] = "Seu cadastro foi realizado através do nosso sistema de boletos, sua senha é: " .
                    substr($cliente->getDocumento(), 0, 8) . substr($cliente->getDocumento(), 12, 2) ;
            $_SESSION["redirecionamento"] = "/BoletoPHP/GerenciadorBoleto/clientes.php";
            header("Location: http://" . $_SERVER["HTTP_HOST"] . "/BoletoPHP/GerenciadorBoleto/email.php");
            exit();
        } catch (Exception $e) {
            print "Codigo: " . $e->getCode() . ", Mensagem:" . $e->getMessage();
        }
        break;

    case "emailSenha":
        try {
            $documento = $_POST["documento"];
            $cliente = $cDao->buscarClienteDocumento($documento);
            if ($cliente->getEmail() != null) {
                $_SESSION["email"] = $cliente->getEmail();
                $_SESSION["assunto"] = "Recuperação de senha - Gerenciador de Boletos Microvil";
                $_SESSION["mensagem"] = "Sua senha atual é: " .
                        substr($cliente->getDocumento(), 0, 8) . substr($cliente->getDocumento(), 12, 2) ;
                $_SESSION["redirecionamento"] = "/BoletoPHP/GerenciadorBoleto/index.php";
                $_SESSION["msg_retorno"] = "E-mail de recuperação de senha enviado!";
                $_SESSION["anexo"] = false;
                header("Location: http://" . $_SERVER["HTTP_HOST"] . "/BoletoPHP/GerenciadorBoleto/email.php");
                exit();
            } else {
                $_SESSION["msg_retorno"] = "Não há nenhum cliente cadastrado com este documento!";
                echo $_SESSION["msg_retorno"];
                header("Location: http://" . $_SERVER["HTTP_HOST"] . "/BoletoPHP/GerenciadorBoleto/index.php");
                exit();
            }
        } catch (Exception $e) {
            print "Codigo: " . $e->getCode() . ", Mensagem:" . $e->getMessage();
        }
        break;
    default:
        break;
}
