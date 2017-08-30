<?php
if (!defined("DS")) {
    define('DS', DIRECTORY_SEPARATOR);
}
if (!defined("BASE_DIR")) {
    define('BASE_DIR', dirname(__FILE__) . DS);
}
require_once BASE_DIR . "model" . DS . "Usuario.php";
require_once BASE_DIR . "dao" . DS . "UsuarioDao.php";
session_start();
if (($_SESSION["usuario"]) == null) {
    header("Location: http://" . $_SERVER["HTTP_HOST"] . "/BoletoPHP/GerenciadorBoleto/index.php");
}
include("getcaptcha.php");
?>
<?php
$usuario = $_SESSION["usuarioCliente"];
require_once 'menu.php';
?>
<form action="control/UsuarioControl.php?action=editar" method="POST">
    <div class="col-md-10 col-md-offset-1">
        <h1 class="title">Editar Cliente</h1>
        <div class="col-md-6">
            <h4 class="title">Dados Básicos</h4>
            <div class="form-group col-md-12">
                <label for="cnpj">CNPJ:</label>
                <input id="cnpj" type="text" name="cnpj" class="form-control" placeholder="CNPJ" disabled="true" value="<?php echo $usuario->getCnpj() ?>" />
            </div>
            <div class="form-group col-md-12">
                <label for="razaoSocial">Nome Empresarial:</label>
                <input id="nome" type="text" name="razao_social" class="form-control" placeholder="Nome Empresarial" value="<?php echo $usuario->getRazaoSocial() ?>"/>
            </div>
            <div class="form-group col-md-12">
                <label for="email">E-mail:</label>
                <input id="email" type="text" name="email" class="form-control" placeholder="E-mail" value="<?php echo $usuario->getEmail() ?>"/>
            </div>
        </div>
        <div class="col-md-6">
            <h4 class="title">Endereço</h4>
            <div class="form-group col-md-12">
                <label for="cep">CEP:</label>
                <input id="cep" type="text" name="cep" class="form-control" placeholder="CEP" value="<?php echo $usuario->getEndereco()->getCep() ?>"/>
            </div>
            <div class="form-group col-md-8">
                <label for="rua">Rua:</label>
                <input id="rua" type="text" name="rua" class="form-control" placeholder="Rua" value="<?php echo $usuario->getEndereco()->getRua() ?>"/>
            </div>
            <div class="form-group col-md-4">
                <label for="numero">Número:</label>
                <input id="num" type="text" name="numero" class="form-control" placeholder="Número"value=" <?php echo $usuario->getEndereco()->getNumero() ?>"/>
            </div>
            <div class="form-group col-md-6">
                <label for="uf">Estado:</label>
                <input id="estado" type="text" name="uf" class="form-control" placeholder="Estado" value="<?php echo $usuario->getEndereco()->getCidade()->getEstado()->getUf() ?>"/>
            </div>
            <div class="form-group col-md-6">
                <label for="cidade">Cidade:</label>
                <input id="cidade" type="text" name="cidade" class="form-control" placeholder="Cidade"value=" <?php echo $usuario->getEndereco()->getCidade()->getNomeCidade() ?>"/>
            </div>
            <div class="form-group col-md-6">
                <label for="bairro">Bairro:</label>
                <input id="bairro" type="text" name="bairro" class="form-control" placeholder="Bairro" value="<?php echo $usuario->getEndereco()->getBairro() ?>"/>
            </div>
            <div class="form-group col-md-6">
                <label for="complemento">Complemento:</label>
                <input id="complemento" type="text" name="complemento" class="form-control" placeholder="Complemento" value="<?php echo $usuario->getEndereco()->getComplemento() ?>"/>
            </div>
        </div>
        <div id="cadastrar" class="col-md-12">
            <button type="submit" class="btn btn-default col-md-offset-5 col-md-2">Atualizar</button>
        </div>
    </div>
</form>
</body>
<script src="assets/js/jquery.maskedinput-1.1.4.pack.js" type="text/javascript" /></script>
<script src="assets/js/novo_cliente.js" type="text/javascript"></script>
<script src="assets/js/carrega_cnpj.js" type="text/javascript"></script>
<link rel="stylesheet" href="assets/css/novo_cliente.css">
</html>