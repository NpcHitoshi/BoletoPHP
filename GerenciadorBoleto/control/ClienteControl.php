<?php

//Define cosntantes para caminhos de importações
if (!defined("DS")) {
    define('DS', DIRECTORY_SEPARATOR);
}
if (!defined("BASE_DIR")) {
    define('BASE_DIR', dirname(dirname(__FILE__)) . DS);
}
//Importa arquivos necessários
require_once BASE_DIR . "dao" . DS . "DataBase.php";
require_once BASE_DIR . "dao" . DS . "ClienteDao.php";
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
$cDao = new ClienteDAO();
$cliente = new Cliente();

switch ($action) {
    //Insere cliente no DB
    case "inserir":
        try {
            //Pega dados do formulário
            $cliente->setNomeCliente(trim($_POST["nomeCliente"]));
            $cliente->setDocumento(trim($_POST["documento"]));
            $cliente->setEmail(trim($_POST["email"]));
            $endereco = new Endereco();
            $eDao = new EnderecoDao();
            $endereco->setBairro(trim($_POST["bairro"]));
            $endereco->setCep(trim($_POST["cep"]));

            $cidade = new Cidade();
            $cidade->setNomeCidade(trim($_POST["cidade"]));
            $cidade = $eDao->buscaCidadeNome($cidade->getNomeCidade(), $_POST["uf"]);

            $endereco->setCidade($cidade);
            $endereco->setComplemento(trim($_POST["complemento"]));
            $endereco->setNumero(trim($_POST["numero"]));
            //Deixa somente letras na Rua
            $endereco->setRua(preg_replace("/[0-9|]|,|\.\d+/", "", trim($_POST["rua"])));
            $cliente->setEndereco($endereco);
            //Valida campos do cliente
            if ($cDao->validaCampos($cliente)) {
                //Insere cliente
                $codigo = $cDao->inserirCliente($cliente);
                if ($codigo != null) {
                    //Envia e-mail de cadastro caso sucesso.
                    $cliente->setCodigoCliente($codigo);
                    $_SESSION["msg_retorno"] = "Cliente gravado com sucesso!";
                    header("Location: http://" . $_SERVER["HTTP_HOST"] . "/BoletoPHP/GerenciadorBoleto/control/ClienteControl.php"
                            . "?action=emailCadastro&cod=" . $cliente->getCodigoCliente());
                    exit();
                } else {
                    //Mensagem de falha caso erro.
                    $_SESSION["msg_retorno"] = "Falha ao gravar cliente!";
                    header("Location: http://" . $_SERVER["HTTP_HOST"] . "/BoletoPHP/GerenciadorBoleto/clientes.php");
                    exit();
                }
            } else {
                //Mensagem de dados incorretos caso falhe validação de campos.
                $_SESSION["msg_retorno"] = "Dados incorretos! Preencha todos os campos corretamente.";
                header("Location: http://" . $_SERVER["HTTP_HOST"] . "/BoletoPHP/GerenciadorBoleto/novo_cliente.php");
                exit();
            }
        } catch (Exception $e) {
            print "Codigo: " . $e->getCode() . ", Mensagem:" . $e->getMessage();
        }
        break;
    //Carrega dados da página Editar Cliente.    
    case "editarSenha":
        $cliente = $_SESSION["usuario"];
        try {
            if (password_verify($_POST["senhaAtual"], $cliente->getSenha())) {
                $novaSenha = $_POST["novaSenha"];
                $confirmaSenha = $_POST["confirmaSenha"];
                
                if ($novaSenha == $confirmaSenha) {
                    $cliente->setSenha($novaSenha);
                    $cDao->editaSenha($cliente);
                    $_SESSION["msg_retorno"] = "Senha atualizada com sucesso!";
                    header("Location: http://" . $_SERVER["HTTP_HOST"] . "/BoletoPHP/GerenciadorBoleto/configuracoes_cliente.php");
                } else {
                    $_SESSION["msg_retorno"] = "Confirmação de senha errada!";
                    header("Location: http://" . $_SERVER["HTTP_HOST"] . "/BoletoPHP/GerenciadorBoleto/configuracoes_cliente.php");
                }
            } else {
                $_SESSION["msg_retorno"] = "Senha atual incorreta!";
                header("Location: http://" . $_SERVER["HTTP_HOST"] . "/BoletoPHP/GerenciadorBoleto/configuracoes_cliente.php");
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
    //Edita dados do cliente.    
    case "editar":
        try {
            //Pega dados do formulário.
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
            //Valida campos
            if ($cDao->validaCamposEditar($cliente)) {
                //Atualiza cliente
                if ($cDao->editaCliente($cliente))
                    $_SESSION["msg_retorno"] = "Cliente atualizado com sucesso!";
                else
                    $_SESSION["msg_retorno"] = "Falha ao atualizar cliente!";
            }
            else {
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
    //Desativa cliente    
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
    //Ativa cliente    
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
    //Envia e-mail após cadastro.    
    case "emailCadastro":
        try {
            $codigo = $_GET["cod"];
            $cliente = $cDao->buscarCliente($codigo);
            $_SESSION["email"] = $cliente->getEmail();
            $_SESSION["assunto"] = "Novo Cadastro - Gerenciador de Boletos Microvil";
            $_SESSION["mensagem"] = "Seu cadastro foi realizado através do nosso sistema de boletos, sua senha é: " .
                    substr($cliente->getDocumento(), 0, 8) . substr($cliente->getDocumento(), 12, 2);
            $_SESSION["redirecionamento"] = "/BoletoPHP/GerenciadorBoleto/clientes.php";
            $_SESSION["anexo"] = false;
            $_SESSION["flag_header"] = true;
            header("Location: http://" . $_SERVER["HTTP_HOST"] . "/BoletoPHP/GerenciadorBoleto/email.php");
            exit();
        } catch (Exception $e) {
            print "Codigo: " . $e->getCode() . ", Mensagem:" . $e->getMessage();
        }
        break;
    //Envia e-mail Esqueci minha senha.    
    case "emailSenha":
        try {
            $documento = $_POST["documento"];
            $cliente = $cDao->buscarClienteDocumento($documento);
            if ($cliente->getEmail() != null) {
                $cliente->setSenha(substr($cliente->getDocumento(), 0, 8) . 
                        substr($cliente->getDocumento(), 12, 2));
                $cDao->editaSenha($cliente);
                $_SESSION["email"] = $cliente->getEmail();
                $_SESSION["assunto"] = "Recuperação de senha - Gerenciador de Boletos Microvil";
                $_SESSION["mensagem"] = "Sua nova senha é: " .
                        $cliente->getSenha();
                $_SESSION["redirecionamento"] = "/BoletoPHP/GerenciadorBoleto/index.php";
                $_SESSION["msg_retorno"] = "E-mail de recuperação de senha enviado!";
                $_SESSION["anexo"] = false;
                $_SESSION["flag_header"] = true;
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
