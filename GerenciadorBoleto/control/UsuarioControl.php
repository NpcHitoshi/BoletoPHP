<?php

require "../dao/Database.php";
require_once BASE_DIR . "dao" . DS . "UsuarioDao.php";

$db = new Database();
$pdo = $db->conexao();
session_start();
$action = $_GET["action"];
$uDao = new UsuarioDAO();
$usuario = new Usuario();

switch ($action) {
    case "buscar":
        break;

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
            }
        } catch (Exception $e) {
            print "Codigo: " . $e->getCode() . ", Mensagem:" . $e->getMessage();
        }
        break;

    case "alterar":
        break;

    case "desativar":
        $codigo = $_GET["codigo"];
        $uDao->desativarUsuario($codigo);
        header("Location: http://" . $_SERVER["HTTP_HOST"] . "/BoletoPHP/GerenciadorBoleto/clientes.php");
        break;

    case "ativar":
        $codigo = $_GET["codigo"];
        $uDao->ativarUsuario($codigo);
        header("Location: http://" . $_SERVER["HTTP_HOST"] . "/BoletoPHP/GerenciadorBoleto/clientes.php");
        break;

    default:
        break;
}
