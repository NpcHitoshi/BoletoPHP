<?php

require "../dao/Database.php";
require "../dao/UsuarioDAO.php";
require "../dao/Endereco.php";

$db = new Database();
$pdo = $db->conexao();
$action = $_GET["action"];
$_SESSION["usuario"] = $usuario;
$usuarioDAO = new UsuarioDAO();

switch (action) {
    case "listar":
        $usuarios = $usuarioDAO->listarUsuarios();
         $_SESSION["usuario"] = $usuarios;
        header("Location: http://" . $_SERVER["HTTP_HOST"] . "/GerenciadorBoleto/clientes.php");
        exit;
        break;

    case "buscar":
        break;

    case "inserir":
        $usuario = new Usuario();
        $usuario->setRazaoSocial(trim($_POST["razao_social"]));
        $usuario->setCnpj(trim($_POST["cnpj"]));
        $usuario->setEmail(trim($_POST["email"]));
        
        $numero = (trim($_POST["numero"]));
        break;

    case "alterar":
        break;

    case "desativar":
        break;

    case "ativar":
        break;

    default:
        break;
}
